/*
    datepickr - pick your date not your nose
    Copyright (c) 2010
*/

function datepickr(id, userConfig) {
	
	var config = {
		fullCurrentMonth: true,
		dateFormat: 'F jS, Y',
		theCurrentDate: userConfig.theCurrentDate 
	},
	currentDate = new Date(config.theCurrentDate+'T10:00:00'),
	// shortcuts to get date info

	get = {
		current: {
			year: function() {
				return currentDate.getFullYear();
			},
			month: {
				integer: function() {
					return currentDate.getMonth();
				},
				string: function(full) {
					var date = currentDate.getMonth();
					return monthToStr(date, full);
				}
			},
			day: function() {
				return currentDate.getDate();			
			}
		},
		month: {
			integer: function() {
				return currentMonthView;
			},
			string: function(full) {
				var date = currentMonthView;
				return monthToStr(date, full);
			},
			numDays: function() {
				// checks to see if february is a leap year otherwise return the respective # of days
				return (get.month.integer() == 1 && !(currentYearView & 3) && (currentYearView % 1e2 || !(currentYearView % 4e2))) ? 29 : daysInMonth[get.month.integer()];
			}
		}
	},
	// variables used throughout the class
	weekdays = ['Sun', 'Mon', 'Tues', 'Wednes', 'Thurs', 'Fri', 'Satur'],
	months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
	daysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
	suffix = { 1: 'st', 2: 'nd', 3: 'rd', 21: 'st', 22: 'nd', 23: 'rd', 31: 'st' },
	element, container, body, month, prevMonth, nextMonth,
	currentYearView = get.current.year(),
	currentMonthView = get.current.month.integer(),
	i, x, buildCache = [];
	
	function build(nodeName, attributes, content) {
		var element;
		
		if(!(nodeName in buildCache)) {
			buildCache[nodeName] = document.createElement(nodeName);
		}
		
		element = buildCache[nodeName].cloneNode(false);
		
		if(attributes != null) {
			for(var attribute in attributes) {
				element[attribute] = attributes[attribute];
			}
		}
		
		if(content != null) {
			if(typeof(content) == 'object') {
				element.appendChild(content);
			} else {
				element.innerHTML = content;
			}
		}
		
		return element;
	}
	
	function monthToStr(date, full) {
		return ((full == true) ? months[date] : ((months[date].length > 3) ? months[date].substring(0, 3) : months[date]));
	}
	
	function formatDate(milliseconds) {
		var formattedDate = '',
		dateObj = new Date(milliseconds),
		format = {
			d: function() {
				var day = format.j();
				return (day < 10) ? '0' + day : day;
			},
			D: function() {
				return weekdays[format.w()].substring(0, 3);
			},
			j: function() {
				return dateObj.getDate();
			},
			l: function() {
				return weekdays[format.w()] + 'day';
			},
			S: function() {
				return suffix[format.j()] || 'th';
			},
			w: function() {
				return dateObj.getDay();
			},
			F: function() {
				return monthToStr(format.n(), true);
			},
			m: function() {
				var month = format.n() + 1;
				return (month < 10) ? '0' + month : month;
			},
			M: function() {
				return monthToStr(format.n(), false);
			},
			n: function() {
				return dateObj.getMonth();
			},
			Y: function() {
				return dateObj.getFullYear();
			},
			y: function() {
				return format.Y().substring(2, 4);
			}
		},
		formatPieces = config.dateFormat.split('');
		
		for(i = 0, x = formatPieces.length; i < x; i++) {
			formattedDate += format[formatPieces[i]] ? format[formatPieces[i]]() : formatPieces[i];
		}
		
		return formattedDate;
	}
	
	function handleMonthClick() {
		// if we go too far into the past
		if(currentMonthView < 0) {
			currentYearView--;
			
			// start our month count at 11 (11 = december)
			currentMonthView = 11;
		}
		
		// if we go too far into the future
		if(currentMonthView > 11) {
			currentYearView++;
			
			// restart our month count (0 = january)
			currentMonthView = 0;
		}
		
		month.innerHTML = get.month.string(config.fullCurrentMonth) + ' ' + currentYearView;
		
		// rebuild the calendar
		while(body.hasChildNodes()){
			body.removeChild(body.lastChild);
		}
		body.appendChild(buildCalendar());
		bindDayLinks();
		
		return false;
	}
	
	function bindMonthLinks() {
		prevMonth.onclick = function() {
			currentMonthView--;
			return handleMonthClick();
		}
		
		nextMonth.onclick = function() {
			currentMonthView++;
			return handleMonthClick();
		}
	}
	
	// our link binding function
	function bindDayLinks() {
		var days = body.getElementsByTagName('a');
		
		for(i = 0, x = days.length; i < x; i++) {
			days[i].onclick = function() {
				element.value = formatDate(new Date(currentYearView, currentMonthView, this.innerHTML).getTime());
				close();
				return false;
			}
		}
	}
	
	function buildWeekdays() {
		var html = document.createDocumentFragment();
		// write out the names of each week day
		for(i = 0, x = weekdays.length; i < x; i++) {
			html.appendChild(build('th', {}, weekdays[i].substring(0, 2)));
		}
		return html;
	}
	
	function buildCalendar() {
		// get the first day of the month we are currently viewing
		var firstOfMonth = new Date(currentYearView, currentMonthView, 1).getDay(),		
		// get the total number of days in the month we are currently viewing
		numDays = get.month.numDays(),
		// declare our day counter
		dayCount = 0,
		html = document.createDocumentFragment(),
		row = build('tr');
		
		// print out previous month's "days"
		for(i = 1; i <= firstOfMonth; i++) {
			row.appendChild(build('td', {}, '&nbsp;'));
			dayCount++;
		}
		
		for(i = 1; i <= numDays; i++) {
			// if we have reached the end of a week, wrap to the next line
			if(dayCount == 7) {
				html.appendChild(row);
				row = build('tr');
				dayCount = 0;
			}
			
			// output the text that goes inside each td
			// if the day is the current day, add a class of "today"
			row.appendChild(build('td', { className: (i == get.current.day() && currentMonthView == get.current.month.integer() && currentYearView == get.current.year()) ? '' : '' }, build('a', { href: 'javascript:void(0)' }, i)));
			dayCount++;
		}
		
		// if we haven't finished at the end of the week, start writing out the "days" for the next month
		for(i = 1; i <= (7 - dayCount); i++) {
			row.appendChild(build('td', {}, '&nbsp;'));
		}
		
		html.appendChild(row);
		
		return html;
	}
	
	function open() {
		document.onclick = function(e) {
			e = e || window.event;
			var target = e.target || e.srcElement;
			
			var parentNode = target.parentNode;
			if(target != element && parentNode != container) {
				while(parentNode != container) {
					parentNode = parentNode.parentNode;
					if(parentNode == null) {
						close();
						break;
					}
				}
			}
		}
		
		bindDayLinks();
		container.style.display = 'block';
	}
	
	function close() {
		document.onclick = null;
		container.style.display = 'none';
	}
	
	function initialise(userConfig) {
		if(userConfig) {
			for(var key in userConfig) {
				if(config.hasOwnProperty(key)) {
					config[key] = userConfig[key];
				}
			}
		}
		
		var inputLeft = inputTop = 0,
		obj = element;
		if(obj.offsetParent) {
			do {
				inputLeft += obj.offsetLeft;
				inputTop += obj.offsetTop;
			} while (obj = obj.offsetParent);
		}
		
		container = build('div', { className: 'calendar' });
		container.style.cssText = 'display: none; position: absolute; top: ' + (inputTop + element.offsetHeight) + 'px; left: ' + inputLeft + 'px; z-index: 9999;';
		
		var months = build('div', { className: 'months' });
		prevMonth = build('span', { className: 'prev-month' }, build('a', { href: '#' }, '&lt;'));
		nextMonth = build('span', { className: 'next-month' }, build('a', { href: '#' }, '&gt;'));
		month = build('span', { className: 'current-month' }, get.month.string(config.fullCurrentMonth) + ' ' + currentYearView);
		
		months.appendChild(prevMonth);
		months.appendChild(nextMonth);
		months.appendChild(month);
		
		var calendar = build('table', {}, build('thead', {}, build('tr', { className: 'weekdays' }, buildWeekdays())));
		body = build('tbody', {}, buildCalendar());
		
		calendar.appendChild(body);
		
		container.appendChild(months);
		container.appendChild(calendar);
		
		document.body.appendChild(container);
		bindMonthLinks();
		
		element.onfocus = open;
	}
	
	return (function() {
		element = document.getElementById(id);
		initialise(userConfig);
	})();
}
