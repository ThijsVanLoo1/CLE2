<?php
/**
 * The actual times for our calendar view
 *
 * @return string[]
 */
function getRosterTimes(): array
{
    return ['12:30', '12:40', '12:50','13:00' , '13:10', '13:20','13:30', '13:40', '13:50','14:00', '14:10', '14:20', '14:30', '14:40', '14:50', '15:00','15:10', '15:20', '15:30', '15:40', '15:50', '16:00','16:10', '16:20', '16:30', '16:40', '16:50', '17:00','17:10', '17:20', '17:30', '17:40', '17:50','18:00', '18:10', '18:20', '18:30', '18:40', '18:50', '19:00','19:10', '19:20', '19:30', '19:40', '19:50', '20:00','20:10', '20:20', '20:30', '20:40'];
}

/**
 * Retrieve the weekdays based on the given timestamp
 *
 * @param int $timestamp
 * @return array
 */
function getWeekDays(int $timestamp): array
{
    //Resolve back to the monday of the week
    $start = date('w', $timestamp) == 1 ? $timestamp : strtotime('last monday', $timestamp);
    $startDate = date('Y-m-d', $start);

    //Loop till 5 to build the days of the week
    $dates = [];
    for ($i = 0; $i < 5; $i++) {
        $dayTimestamp = strtotime($startDate . "+$i days");
        //Build array keys that are relevant to use when someone calls this function
        $dates[] = [
            'timestamp' => $dayTimestamp,
            'fullDate' => date('Y-m-d', $dayTimestamp),
            'day' => date('D', $dayTimestamp),
            'dayNumber' => date('d', $dayTimestamp),
            'current' => date('d', $dayTimestamp) === date('d')
        ];
    }
    return $dates;
}

/**
 * Format the event, so we can use it in our calendar view
 *
 * @param array $event
 * @return array
 */
function formatEvent(array $event): array
{
    //To compare times, we need the exact same values without the trailing :00 seconds
    $event['start_time'] = substr($event['start_time'], 0, -3);
    $event['end_time'] = substr($event['end_time'], 0, -3);

    //Add the day of the week (translated from the default weird start on Sunday)
    $dayNumber = (int)date('w', strtotime($event['date']));
    $event['day_number'] = $dayNumber === 0 ? 5 : $dayNumber;

    //Get the times and translate the event times to the rows in the grid
    $rosterItems = getRosterTimes();
    $event['row_start'] = array_search($event['start_time'], $rosterItems) + 2;
    $event['row_span'] = array_search($event['end_time'], $rosterItems) + 2 - $event['row_start'];

    return $event;
}

/**
 * Query the database & return events
 *
 * @param string $from
 * @param string $to
 * @return array
 */
function getEvents(string $teacher_id,string $from, string $to): array
{
    global $db;
    require_once "database.php";

    //Get the result set from the database with an SQL query
    if($_SESSION['admin_key'] == 1) {
        print_r($teacher_id);
        $query = "SELECT * FROM reservations WHERE date >= '$from' AND date <= '$to' AND  user_id = $teacher_id";
    }
    else {
        $id = $_SESSION['id'];
        $query = "SELECT * FROM reservations WHERE date >= '$from' AND date <= '$to' AND  user_id = $id";
    }

    $result = mysqli_query($db, $query);
    //Loop through the result to create a custom array of events
    $events = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = formatEvent($row);
    }

    //Close connection
    mysqli_close($db);

    return $events;
}


/**
 * To prevent too much clutter of PHP-in-CSS within index.php, we'll use this function
 * This creates classes that are later used in the actual HTML
 *
 * @param array $rosterTimes
 * @param array $events
 * @return string
 */
function getDynamicCSS(array $rosterTimes, array $events): string
{
    //First make sure grid & rows are set for the total timeslots we have
    $totalRosterTimes = count($rosterTimes);
    $css = <<<CSS
        .content {
            grid-template-rows: repeat({$totalRosterTimes}, 2em);
        }

        .col {
            grid-row: 1 / span {$totalRosterTimes};
        }
CSS;

    //Create the actual row-styling based on total items we have
    foreach ($rosterTimes as $index => $rosterTime) {
        $rowNumber = $index + 1;
        $css .= <<<CSS
            .row-roster-{$rowNumber} {
                grid-row: {$rowNumber};
            }
CSS;
    }

    //Create the styling for every event to give it a unique position in the grid
    foreach ($events as $event) {
        $dayNumber = $event['day_number'] + 2;
        $css .= <<<CSS
            .event-item-{$event['id']} {
                grid-column: {$dayNumber};
                grid-row: {$event['row_start']} / span {$event['row_span']};
            }
CSS;
    }

    return $css;
}
