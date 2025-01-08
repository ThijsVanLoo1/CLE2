<?php
//require_once "includes/database.php";

$days = [

];

$times = [

];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">
    <link href="output.css" rel="stylesheet">
    <title>Reservatie pagina</title>
</head>

<nav>
    <a href="login.php">Login</a>
    <a href="logout.php">Logout</a>
    <a href="register.php">Register</a>
    <a href="admin.php">Admin</a>
    <a href="overview.php">Overview</a>
    <a href="confirmation.php">Confirmation</a>
</nav>

<header class="text-center">Rooster</header>
<body>
<ul class="flex justify-center gap-10">
    <li>Ma</li>
    <li>Di</li>
    <li>Wo</li>
    <li>Do</li>
    <li>Vr</li>
</ul>
<ul class="flex flex-col items-center gap-10">
    <li>18:00</li>
    <li>18:30</li>
    <li>19:00</li>
    <li>19:30</li>
</ul>
</body>
</html>