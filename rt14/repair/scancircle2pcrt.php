<?php

/*
 * Adds the ScanCircle scans and/or computer specs and to PC Repair Tracker 
 * (PCRT) by using the PCRT asset id (pcid) as ScanCircle reference code. 
 * 
 * Customized handling can be achieved using URL parameters, including:
 * - link scan to pc and/or last work order;
 * - how to handle changes in specs (update and/or log or ignore them),
 *	 both as a generic setting and per spec;
 * - what to do if key fields (e.g. serial number) differ (ignore/skip/mark).
 * 
 * See https://www.scancircle.com/forum/showthread.php?tid=131 for more info 
 * on the requirements, settings and URL parameters (partner login required).
 * 
 * Global processing:
 *	a) Reference code is checked (exit if none or wrong category);
 *	b) pc_owner record is retrieved based on pcid (exit if not found);
 *	c) Old and new values are compared (changes are optionally logged);
 *	d) pc_owner fields pcmake and pcextra are updated if required;
 *	e) Scan is added to attachments, linked to pc and/or work order.

 * Version history
 * 2016-01-16	v1.33	Initial release.
 * 2016-02-13	v1.34.1	Multi-lingual, installation tips, extra fields, version
 * 2016-02-19	v1.34.2	Added token authentication parameter (suggested by Luke)
 * 2016-02-25	v1.34.3	Added debug option, updated labels for store hash
 * 2016-03-02	v1.35	Extended debug option with echo instead of file log
 * 2016-09-21	v1.38	Results now included in scan (1-step), text corrections.
 * 2017-03-17	v1.39	Adjusted to coding standards
 * 2017-07-19	v1.41	Feedback in English only, removed setup detail messages.
*/

// Keep this up-to-date
define('VERSION', 'v1.41');

// Debug option
if(isset($_GET['debug'])) {
	if(!$debug = $_GET['debug']) $debug = true;
	logDebug('--- '.gmdate('Y-m-d H:i:s').' GMT ---');
	ini_set('error_log', $debug);
	ini_set('log_errors', 1);
	ini_set('display_errors', 1);
	error_reporting(E_ALL & ~E_STRICT);
} else {
	$debug = false;
}

// URL parameters				// used by:
define('PAR_NONE',	'none');	// linkto, changes
define('PAR_PC',	'pc');		// linkto
define('PAR_WO',	'wo');		// linkto
define('PAR_BOTH',	'both');	// linkto, changes
define('PAR_LOG',	'log');		// changes
define('PAR_UPDATE', 'update');	// changes
define('PAR_IGNORE', 'ignore');	// spec
define('PAR_SKIP',	'skip');	// spec
define('PAR_MARK',	'mark');	// spec

// Result messages
$L = array(
	'ERR_CFG_MISSING' => "Configuration file deps.php not found.
		Please put this add-on in your PC Repair Tracker 'repair' folder.",
	'ERR_DB_CONN' => "Error connecting to the database: ",
	'ERR_DB_QUERY' => "Error querying the database: ",
	'ERR_TOKEN_MISSING' => "The required 'token' parameter is missing. Add-on version: ",
	'ERR_TOKEN_ERROR' => "The specified token does not match any store hash: ",
	'ERR_XML_MISSING' => "This ScanCircle add-on seems to be installed correctly. Add-on version: ",
	'ERR_XML_LOAD' => "Error parsing the XML structure: ",
	'ERR_XML_ROOT' => "Unsupported XML root: ",
	'ERR_REF_UNKNOWN' => "No match for PC in the database: ",
	'ERR_REF_WRONG' => "Wrong PC in the database: ",
	'ERR_REF_NONE' => "No reference code specified",
	'ERR_REF_CATEGORY' => "No/wrong category: ",
	'ERR_PAR_UNKNOWN' => "Unsupported parameter: ",
	'WARN_DEBUG' => "Warning: debug option active.",
	'SUCCESS' => "Scan added to the database",
);

// Configuration
logDebug('Loading deps.php');
if(!file_exists('deps.php')) handleError('ERR_CFG_MISSING');
require 'deps.php';	// get $mypcrtlanguage, $pcrt_timezone, dbhost, $dbuname, $dbpass, $dbname
if(function_exists('date_default_timezone_set')) {
	logDebug('Setting default timezone');
	date_default_timezone_set($pcrt_timezone);
}

// open PCRT database
logDebug('Opening database');
$db = new mysqli($dbhost, $dbuname, $dbpass, $dbname);
if($db->connect_errno) handleError('ERR_DB_CONN', $dbname, $db->connect_error);

// check token parameter
logDebug('Checking token');
if(!isset($_GET['token'])) handleError('ERR_TOKEN_MISSING', VERSION);
if(!$token = prep($db, $_GET['token'])) handleError('ERR_TOKEN_MISSING');
$dbq = sprintf("SELECT storeid FROM stores WHERE storehash='%s'", $token);
if(!$dbr = $db->query($dbq)) handleError('ERR_DB_QUERY', $dbq, $db->error);
if(!$row = $dbr->fetch_object()) handleError('ERR_TOKEN_ERROR', $token);

// get post info
logDebug('Getting post info');
if(!isset($_POST['info'])) handleError('ERR_XML_MISSING', VERSION);
$info = $_POST['info'];
logDebug('Post info: '.$info);
if(!$xml = simplexml_load_string($info)) {
	$errors = libxml_get_errors();
	libxml_clear_errors();
	$msg = '';
	foreach($errors as $error) {
		$msg .= "Line: {$error->line}, Column: {$error->column}, ".
				"Level: {$error->level}, Message: {$error->message}; ";
	}
	handleError('ERR_XML_LOAD', $info, $msg);
}

// check XML root
logDebug('Checking XML root');
if($xml->getName() != 'scan') handleError('ERR_XML_ROOT', $xml->getName());
handleScan($db, $xml);

logDebug('Finished');
handleError();	// finish successfully


// ======== Main functions ========

/*
 * Handles the scan data info
 *
 * @param object $db open database connection
 * @param object $xml XML info
 * 
 */
function handleScan($db, $xml) {
	// initialize
	$linkto = (isset($_GET['linkto']) ? $_GET['linkto'] : PAR_PC);
	$changes = (isset($_GET['changes']) ? $_GET['changes'] : PAR_LOG);
	$notes = '';
	$wrongpc = '';

	// check reference code and extract pcid
	// exits if no (PCRT) reference code or no match found
	logDebug('Getting reference');
	$pcid = getPcReference(strval($xml->reference));

	// try to find pc and last work order
	logDebug('Querying pc_owner en pc_wo');
	$dbq = sprintf("
			SELECT PC.pcmake, PC.pcextra, PC.pcnotes, WO.woid, WO.pcstatus
			FROM pc_owner AS PC
			LEFT JOIN pc_wo AS WO ON WO.pcid=PC.pcid
			WHERE PC.pcid = %d
			ORDER BY WO.dropdate DESC
			LIMIT 1
			", $pcid);
	if(!$dbr = $db->query($dbq)) handleError('ERR_DB_QUERY', $dbq, $db->error);
	if(!$row = $dbr->fetch_object()) handleError('ERR_REF_UNKNOWN', $pcid);
	$pcnotes = $row->pcnotes;
	$woid = intval($row->woid);

	// update make
	logDebug('Checking make spec');
	$pcmake = updateSpec('make', $row->pcmake, strval($xml->make), 
			$changes, $pcnotes, $notes, $wrongpc);

	// get array with existing pcextra values (index is fieldid)
	$dbv = ($row->pcextra ? unserialize($row->pcextra) : array());

	// build array with new scan values (index is matchword)
	// Not all fields may be supplied by ScanCircle yet
	$new = array(
		'serial'			=> strval($xml->serial),
		'operatingsystem'	=> strval($xml->os),
		'cpu'				=> strval($xml->cpu),
		'ram'				=> strval($xml->memory),
		'partition'			=> strval($xml->disk),
		'videocard'			=> strval($xml->video),
		'computername'		=> strval($xml->name),
		'motherboard'		=> strval($xml->mobo),
		'bios'				=> strval($xml->bios),
		'installedon'		=> strval($xml->installed),
		'windowsproductkey'	=> strval($xml->keys),
		'ipaddress'			=> strval($xml->ip)
	);

	// mainassetinfofields contains link between fieldid and matchword
	logDebug('Checking other specs');
	$dbq = "SELECT mainassetfieldid, matchword FROM mainassetinfofields WHERE LENGTH(matchword)>0";
	if(!$dbr = $db->query($dbq)) handleError('ERR_DB_QUERY', $dbq, $db->error);
	while($maif = $dbr->fetch_object()) {
		if(isset($new[$maif->matchword])) {
			// compare and update value
			$dbv[$maif->mainassetfieldid] = 
				updateSpec($maif->matchword,  nzIndex($dbv, $maif->mainassetfieldid), 
					nzIndex($new, $maif->matchword), $changes, $pcnotes, $notes, $wrongpc);
		}
	}

	if($wrongpc !== PAR_SKIP) {
		// where to link the scan to
		switch($linkto) {
			case PAR_PC:
				$pc = $pcid;	
				$wo = 0;
				break;
			case PAR_WO:
				$pc = 0;	
				$wo = $woid;
				break;
			case PAR_BOTH:
				$pc = $pcid;	
				$wo = $woid;
				break;
			case PAR_NONE:
				$pc = 0;
				$wo = 0;
				break;
			default:
				handleError('ERR_PAR_UNKNOWN', 'linkto', $linkto);
		}
		// add scan to database
		if($pc || $wo) {
			$mode = ($wrongpc == PAR_MARK ? 'WRONGPC?' : 
						($xml->scanmode == 'Reference' ? 'Client' : 
							prep($db, $xml->scanmode)));	// should be Partner
			logDebug('Inserting scan link');
			$dbq = sprintf("
					INSERT INTO attachments (
						attach_title, attach_filename, attach_size, attach_dcount, 
						attach_keywords, pcid, woid, groupid, attach_cat, 
						attach_date) 
					VALUES (
						'ScanCircle %s (%s)', '%s', %d, 0, 
						'', %d, %d, 0, 0, 
						now())
					", date('Y-m-d H:i:s'), $mode, prep($db, $xml->advice), 
						floatval($xml->score) * 1024, $pc, $wo);
						// score may not yet be supplied in the scan request
						// *1024 causes the score to be shown as #.# KB
			if(!$dbr = $db->query($dbq)) handleError('ERR_DB_QUERY', $dbq, $db->error);
		}
	}
	if($wrongpc) handleError('ERR_REF_WRONG', $pcid, $notes);

	if($notes) {
		// prepend changes with timestamp to pcnotes
		$pcnotes = date('Y-m-d H:i:s: ').$notes."\n\r".$pcnotes;
	}

	// update pc_owner
	logDebug('Updating pc_owner');
	$pcextra = serialize($dbv);
	$dbq = sprintf("
			UPDATE pc_owner 
			SET pcmake = '%s', pcextra = '%s', pcnotes = '%s' 
			WHERE pcid = %d
			", prep($db, $pcmake), prep($db, $pcextra), prep($db, $pcnotes), $pcid);
	if(!$dbr = $db->query($dbq)) handleError('ERR_DB_QUERY', $dbq, $db->error);

}

// ======== Support functions ========

/*
 * Escapes potentially insecure sequences in string
 *
 * @param object $db open database connection
 * @param string $param parameter value
 * @return string escaped parameter value
 * 
 */
function prep($db, $param) {
	return $db->real_escape_string($param);
}

/*
 * Check reference code and extract pcid
 * 
 * @param string $reference reference code optionally starting with category:
 * @return int pcid to match for in PCRT database
 * 
 */
function getPcReference($reference) {
	// no reference
	if(!$reference) handleError('ERR_REF_NONE');

	// no category
	if(!isset($_GET['category'])) return intval($reference);

	// check category
	$category = $_GET['category'].':';
	if(strncasecmp($reference, $category, strlen($category)) !== 0) {
		handleError('ERR_REF_CATEGORY', $reference);
	}
	return intval(substr($reference, strlen($category)));
}

/*
 * Updates spec field and optionally logs changes in notes
 *
 * @param string $field field name
 * @param string $old old value
 * @param string $new new value
 * @param string $changes changes URL parameter
 * @param string $pcnotes current pcnotes
 * @param string $notes notes for this scan (in/out)
 * @param string $wrongpc indicates when key field differs (in/out)
 * @return string value to be stored
 * 
 */
function updateSpec($field, $old, $new, $changes, $pcnotes, &$notes, &$wrongpc) {
	// check field specific parameter
	$spec = (isset($_GET[$field]) ? $_GET[$field] : 
				($field == 'serial' ? PAR_MARK : $changes));

	// if no new value or same as old value or ignore field or 
	// ignore changes, return old value
	if(!$new || ($new === $old) || ($spec == PAR_IGNORE) || 
			($old && ($spec == PAR_NONE))) return $old;

	// if no old value, return new value (not seen as a change)
	if(!$old) return $new;

	// else handle the change
	switch($spec) {
		case PAR_SKIP:
		case PAR_MARK:
			if($wrongpc !== PAR_SKIP) $wrongpc = $spec;
			// don't break: include change in e-mail to partner
		case PAR_LOG:
		case PAR_BOTH:
			// log change (if not yet logged in pcnotes)
			$note = "$field: $old => $new; ";
			if(strpos($pcnotes, $note) === false) {
				$notes .= $note;
			}
			break;
		case PAR_UPDATE:
		case PAR_NONE:
			break;
		default:
			handleError('ERR_PAR_UNKNOWN', isset($_GET[$field]) ? $field : 'changes', $spec);
	}

	return (($spec == PAR_UPDATE) || ($spec == PAR_BOTH)) ? $new : $old;
}

/*
 * Check if array key exists to prevent Undefined offset error
 * 
 * @param array $arr The array
 * @global string $key The key
 * returns The value or empty string if the key does not exist
 */
function nzIndex($arr, $key) {
	return (isset($arr[$key]) ? $arr[$key] : '');
}

/*
 * Error handler
 * 
 * @param string $error error code
 * @param string $param addition text to be appended to error text
 * @param string $details error number or other error details
 * @global string $debug debug option
 * @global string $mypcrtlanguage selected language
 * @global array $L language translations
 */
function handleError($error = '', $param = '', $details = '') {
	global $debug, $mypcrtlanguage, $L;
	
	// Handle success situation
	if(!$error) {
		// return 'OK' to redirect user to partner's/ScanCircle result page
		// TODO: return URL to redirect user to specified URL (interferes with copy)
		if($debug) {
			$error = 'WARN_DEBUG';
		} elseif(isset($_GET['copy'])) {
			$error = 'SUCCESS';
		} else {
			die('OK');
		}
	}

	// Tell ScanCircle to send the message to the partner by e-mail
	die('[scancircle2pcrt] '.$L[$error].$param.($details ? ' ('.$details.')' : ''));
}

/*
 * Log message to debug file
 * 
 * @param string $msg Message
 * @global string $debug Path of log file
 */
function logDebug($msg) {
	global $debug;
	
	if($debug) {
		if($debug === true) {
			echo '* '.$msg."\n";
		} else {
			file_put_contents($debug, '* '.$msg."\n", FILE_APPEND | LOCK_EX);
		}
	}
}
