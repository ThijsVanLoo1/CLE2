<?php

//logged in, so starting session
session_start();

//check if user is actually logged in
if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

//check if user is admin
if ($_SESSION['admin_key'] == 1) {
    header('Location: admin.php');
    exit();
}

//gives user correct id
$id = $_SESSION['id'];

//get data from database
global $db;
require_once "includes/database.php";
require_once "includes/functions.php";

$query = "SELECT * FROM reservations WHERE user_id = $id";

$result = mysqli_query($db, $query)
or die('Error ' . mysqli_error($db) . ' with query ' . $query);

$reservations = [];

while ($row = mysqli_fetch_assoc($result)) {
    $reservations[] = $row;
}

//Get the current week from the GET or default to 0 (current week)
$selectedWeek = $_GET['week'] ?? 0;

//Retrieve the timestamp that belongs to the week that is active
$timestampWeek = strtotime("+$selectedWeek weeks");

//Get the weekdays that are part of the active week based on the timestamp
$weekDays = getWeekDays($timestampWeek);

//Get the month that belongs to the monday of that week
$monthOfWeek = date('F', $weekDays[0]['timestamp']);

//Get the year that belongs to the monday of that week
$yearOfWeek = date('Y', $weekDays[0]['timestamp']);

//The actual times visible in the calendar view
$rosterTimes = getRosterTimes();

//The events from the database that are in this week
$events = getEvents($id, $weekDays[0]['fullDate'], $weekDays[4]['fullDate']);

$link = "logout.php";
$text = "Logout";
$link_login = "overview.php";
$text_overview = "Overview";
$hidden = "hidden";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">
    <!-- From: https://codepen.io/kjellmf/pen/qgxyVJ -->
    <link href="css/normalize.css" rel="stylesheet" type="text/css"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <style><?= getDynamicCSS($rosterTimes, $events); ?></style>
    <title>Docent - Overzicht</title>
</head>
<body>
<nav class="flex items-center justify-between p-6 bg-[#04588D]">
    <div>
        <a href="index.php">
            <img src="https://www.deeendragt.nl/wp-content/uploads/sites/13/2022/10/IKCElogoklein.jpg" alt="Logo"
                 class="w-20 h-20">
        </a>
    </div>
    <div class="hidden md:flex gap-6 nav-links p-8">
        <a href="index.php" class="text-white hover:text-[#003060]">Home</a>
        <a href="logout.php" class="text-white hover:text-[#003060]">Logout</a>
    </div>
    <div id="mobile-menu" class="menu-toggle md:hidden cursor-pointer flex flex-col gap-1">
        <span class="w-8 h-1 bg-white rounded transition-all"></span>
        <span class="w-8 h-1 bg-white rounded transition-all"></span>
        <span class="w-8 h-1 bg-white rounded transition-all"></span>
    </div>
</nav>

<div class="nav-links hidden flex-col gap-4 bg-[#04588D] md:hidden " id="nav-links">
    <a href="index.php" class="text-white block text-center p-2 bg-[#003060] border-b border-t">Home</a>
    <a href="logout.php" class="text-white block text-center p-2 bg-[#003060] border-b">Logout</a>
</div>
<div id="mobile-menu" class="hidden sm:hidden flex flex-col gap-2 p-4 bg-[#04588D] text-white">
    <a href="index.php" class="hover:text-[#003060] block ">Home</a>
    <a href="logout.php" class="text-white hover:text-[#003060] block ">Logout</a>
</div>
<main>
    <div class="container">
        <div class="title">
            <a href="?week=<?= $selectedWeek - 1 ?>">Vorige week</a>
            <span><?= $monthOfWeek . ' ' . $yearOfWeek; ?></span>
            <a href="?week=<?= $selectedWeek + 1 ?>">Volgende week</a>
        </div>
        <div class="days">
            <div class="filler"></div>
            <div class="filler"></div>
            <?php foreach ($weekDays as $weekday) { ?>
                <div class="day<?= $weekday['current'] ? ' current' : ''; ?>">
                    <?= $weekday['day'] . ' ' . $weekday['dayNumber']; ?>
                </div>
            <?php } ?>
        </div>
        <div class="content">
            <div class="filler-col"></div>
            <div class="col monday"></div>
            <div class="col tuesday"></div>
            <div class="col wednesday"></div>
            <div class="col thursday"></div>
            <div class="col friday"></div>
            <?php foreach ($rosterTimes as $index => $rosterTime) { ?>
                <div class="time row-roster-<?= $index + 1; ?>"><?= $rosterTime; ?></div>
                <div class="row row-roster-<?= $index + 1; ?>"></div>
            <?php } ?>
            <?php foreach ($events as $event) { ?>
                <a href="details.php?id=<?= $event['id'] ?>"
                   class="event event-item-<?= $event['id']; ?>"><?= $event['first_name'] . " " . $event['last_name']; ?></a>
            <?php } ?>
        </div>
    </div>
</main>
</body>
<footer class="flex flex-col sm:flex-row sm:gap-3 justify-around p-4 bg-[#003060] mt-4">
    <div class="flex flex-col items-center py-4">
        <img src="https://www.deeendragt.nl/wp-content/uploads/sites/13/2022/10/IKCElogoklein.jpg" class="w-16 h-16">
    </div>
    <div class="flex gap-2 py-4">
        <img src="https://upload.wikimedia.org/wikipedia/commons/9/95/Instagram_logo_2022.svg" alt="Instagram logo"
             class="w-10 h-10">
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg" alt="Facebook logo"
             class="w-10 h-10">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRokEYt0yyh6uNDKL8uksVLlhZ35laKNQgZ9g"
             alt="LinkedIn logo" class="w-10 h-10">
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b7/X_logo.jpg" alt="X logo" class="w-10 h-10">
    </div>
    <ul class="text-white flex flex-col gap-2 font-bold py-4">
        <li><a href="index.php">Home</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</footer>
</html>