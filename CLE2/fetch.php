<?php

/** @var mysqli $db */
require_once "includes/database.php";

// Geef de request via post.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date'])) {
    $date = mysqli_real_escape_string($db, $_POST['date']);

    // Pak alle bestaande reserveringen.
    $query = "SELECT start_time, end_time FROM reservations WHERE date = '$date'";
    $result = mysqli_query($db, $query);

    //Maak lijst met reservations.
    $reservations = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $reservations[] = [
            'start_time' => strtotime($row['start_time']),
            'end_time' => strtotime($row['end_time']),
        ];
    }

    // Geef de tijden door.
    $times = [];
    $time = strtotime('12:30');
    $endTime = strtotime('20:00');
    $addTime = 10; // in minutes

    while ($time <= $endTime) {
        $times[] = date('H:i', $time);
        $time += 60 * $addTime;
    }

    // Filter de tijden uit.
    $availableTimes = array_values(array_filter($times, function ($time) use ($reservations) {
        $currentTime = strtotime($time);
        foreach ($reservations as $reservation) {
            if ($currentTime >= $reservation['start_time'] && $currentTime < $reservation['end_time']) {
                return false;
            }
        }
        return true;
    }));

    // Stuur Json door zodat die kan worden opgepakt in de reservation.php.
    echo json_encode($availableTimes);
}

?>
