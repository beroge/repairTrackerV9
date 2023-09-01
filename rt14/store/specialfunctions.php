<?php



function build_calendar($month,$year,$dateArray) {

     // Create array containing abbreviations of days of week.
     $daysOfWeek = array('Su','Mo','Tu','We','Th','Fr','Sa');

     // What is the first day of the month in question?
     $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

     // How many days does this month contain?
     $numberDays = date('t',$firstDayOfMonth);

     // Retrieve some information about the first day of the
     // month in question.
     $dateComponents = getdate($firstDayOfMonth);

     // What is the name of the month in question?
     $monthName = $dateComponents['month'];

     // What is the index value (0-6) of the first day of the
     // month in question.
     $dayOfWeek = $dateComponents['wday'];

     // Create the table tag opener and day headers

     $calendar = "<table class='calendar'>";
     $calendar .= "<caption>$monthName, $year</caption>";
     $calendar .= "<tr>";

     // Create the calendar headers

     foreach($daysOfWeek as $day) {
          $calendar .= "<th class='header'>$day</th>";
     } 

     // Create the rest of the calendar

     // Initiate the day counter, starting with the 1st.

     $currentDay = 1;

     $calendar .= "</tr><tr>";

     // The variable $dayOfWeek is used to
     // ensure that the calendar
     // display consists of exactly 7 columns.

     if ($dayOfWeek > 0) { 
          $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>"; 
     }

     while ($currentDay <= $numberDays) {

          // Seventh column (Saturday) reached. Start a new row.

          if ($dayOfWeek == 7) {

               $dayOfWeek = 0;
               $calendar .= "</tr><tr>";

          }

         // Is the $currentDay a member of $dateArray? If so,
         // the day should be linked.

         if (in_array($currentDay,$dateArray)) {

            $date = "$year-$month-$currentDay";

$rs_date2 = date("Y-m-d", strtotime($date));
    $calendar .= "<td class='linkedday'><a href='reports.php?func=day_report&day=$rs_date2' class='calendarlink'>$currentDay</a></td>";

          // $currentDay is not a member of $dateArray.

          } else {

               $calendar .= "<td class='day'>$currentDay</td>";

          }

          // Increment counters
 
          $currentDay++;
          $dayOfWeek++;

     }

     // Complete the row of the last week in month, if necessary

     if ($dayOfWeek != 7) { 
     
          $remainingDays = 7 - $dayOfWeek;
          $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>"; 

     }

     $calendar .= "</table>";

     return $calendar;

}

?>
