<?php
session_start();

global $db;
require_once "includes/database.php";

if ($_SESSION['admin_key'] != 1) {
    header('location: login.php');
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@100..900&display=swap" rel="stylesheet">
    <link href="output.css" rel="stylesheet">
    <title>Home</title>
</head>
<body class="font-sans">
<nav class="flex items-center justify-between p-6 bg-[#04588D]">
    <div>
        <a href="index.php">
            <img src="https://www.deeendragt.nl/wp-content/uploads/sites/13/2022/10/IKCElogoklein.jpg" alt="Logo"
                 class="w-20 h-20">
        </a>
    </div>
    <div class="hidden md:flex gap-6 nav-links p-8">
        <a href="index.php" class="text-white hover:text-[#003060]">Home</a>
        <a href="overview.php" class="text-white hover:text-[#003060]">Overview</a>
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
    <a href="overview.php" class="text-white block text-center p-2 bg-[#003060] border-b">Overview</a>
    <a href="logout.php" class="text-white block text-center p-2 bg-[#003060] border-b">Logout</a>
</div>
<div id="mobile-menu" class="hidden sm:hidden flex flex-col gap-2 p-4 bg-[#04588D] text-white">
    <a href="index.php" class="hover:text-[#003060] block ">Home</a>
    <a href="overview.php" class="text-white hover:text-[#003060] block">Overview</a>
    <a href="logout.php" class="text-white hover:text-[#003060] block ">Logout</a>
</div>
<main>

</main>
