<?php

/** @var mysqli $db */
require_once "includes/database.php";

$userId = $_SESSION['id'];
$adminKey = $_SESSION['admin_key'];
$selectedTeacher = $_GET['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date'])) {
    $date = mysqli_real_escape_string($db, $_POST['date']);

    // Haal bestaande reservaties op.
    if ($adminKey === 1) {
        $query = "SELECT start_time, end_time FROM reservations WHERE date = '$date' AND user_id = '$selectedTeacher'";
    } else {
        $query = "SELECT start_time, end_time FROM reservations WHERE date = '$date' AND user_id = '$userId'";
    }

    $result = mysqli_query($db, $query);

    $reservations = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $reservations[] = [
            'start_time' => strtotime($row['start_time']),
            'end_time' => strtotime($row['end_time']),
        ];
    }

    // Maak de tijden aan.
    $times = [];
    $time = strtotime('12:30');
    $endTime = strtotime('20:00');
    $addTime = 10;

    while ($time <= $endTime) {
        $times[] = date('H:i', $time);
        $time += 60 * $addTime;
    }

    // Haal de bezette tijden eruit.
    $availableTimes = array_values(array_filter($times, function ($time) use ($reservations) {
        $currentTime = strtotime($time);
        foreach ($reservations as $reservation) {
            if ($currentTime >= $reservation['start_time'] && $currentTime < $reservation['end_time']) {
                return false;
            }
        }
        return true;
    }));

    // Stuur JSON door.
    echo json_encode($availableTimes);
}
?>