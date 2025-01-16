<?php
session_start();
global $db;
require_once "includes/database.php";
$docent = $_SESSION['docent_id'];
$link = "login.php";
$text = "Login";
if (!empty($_SESSION) === true) {
    $link = "logout.php";
    $text = "Logout";
} else {
    $link = "login.php";
    $text = "Login";
}
// Docent id ophalen voor de namen
$query = "SELECT first_name, last_name FROM users where id= $docent";
$result = mysqli_query($db, $query) or die('Error ' . mysqli_error($db) . ' with query ' . $query);

// Array aanmaken voor de docent
$docent = [];

//
$row = mysqli_fetch_assoc($result);
$docent = $row;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@100..900&display=swap" rel="stylesheet">
    <link href="output.css" rel="stylesheet">
    <title>Confirm Pagina</title>
</head>
<body class="font-sans">
<nav class="flex items-center justify-between p-6 bg-[#04588D]">
    <div>
        <a href="index.php">
            <img src="https://www.deeendragt.nl/wp-content/uploads/sites/13/2022/10/IKCElogoklein.jpg" alt="Logo"
                 class="w-20 h-20">
        </a>
    </div>
    <div class="hidden md:flex gap-6 nav-links">
        <a href="index.php" class="text-white hover:text-[#003060]">Home</a>
        <a href="reservation.php" class="text-white hover:text-[#003060]">Afspraak maken</a>
        <a href="#" class="text-white hover:text-[#003060]">Contact</a>
    </div>
    <div id="mobile-menu" class="menu-toggle md:hidden cursor-pointer flex flex-col gap-1">
        <span class="w-8 h-1 bg-white rounded transition-all"></span>
        <span class="w-8 h-1 bg-white rounded transition-all"></span>
        <span class="w-8 h-1 bg-white rounded transition-all"></span>
    </div>
</nav>

<div class="nav-links hidden flex-col gap-4 bg-[#04588D] md:hidden " id="nav-links">
    <a href="index.php" class="text-white block text-center p-2 bg-[#003060] border-b border-t">Home</a>
    <a href="reservation.php" class="text-white block text-center p-2 bg-[#003060] border-b">Afspraak maken</a>
    <a href="#" class="text-white block text-center p-2 bg-[#003060] border-b">Contact</a>
    <a href="<?= $link; ?>" class="text-white block text-center p-2 bg-[#003060] border-b"><?= $text; ?></a>
</div>
<div id="mobile-menu" class="hidden sm:hidden flex flex-col gap-2 p-4 bg-[#04588D] text-white">
    <a href="index.php" class="hover:text-[#003060] block ">Home</a>
    <a href="reservation.php" class="hover:text-[#003060] block ">Afspraak maken</a>
    <a href="" class="hover:text-[#003060] block ">Contact</a>
    <a href="<?= $link; ?>" class="text-white hover:text-[#003060] block "><?= $text; ?></a>
</div>
<header class="sm:flex flex h-100v w-100w bg-[#003060] border-b border-black xl:p-20 xl:mx-52 p-5 flex-col gap-4 xl:h-70v">
    <h1 class="text-white xl:text-4xl text-xl ">Bedankt voor je
        reservatie <?= $_SESSION['first_name'] ?> <?= $_SESSION['last_name'] ?></h1>
    <p class="text-white text-base">
        Je hebt een reservatie met docent <?= $docent['first_name'] ?> <?= $docent['last_name'] ?>. Deze afspraak is
        op <?= $_SESSION['date'] ?>
        om <?= $_SESSION['start_time'] ?>. De afspraak staat geregistreerd onder de
        naam <?= $_SESSION['first_name'] ?> <?= $_SESSION['last_name'] ?>. Vergeet niet om
        eventuele vragen of onderwerpen die je wilt bespreken voor te bereiden, zodat je het meeste uit je afspraak kunt
        halen. Als je verhinderd bent, laat dit dan tijdig weten om een nieuwe afspraak te plannen.

        Is er nog iets anders waarmee ik je kan helpen?
    </p>
</header>
<footer class="flex flex-col sm:flex-row sm:gap-3 justify-around p-4 bg-[#003060] ">
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
        <li><a href="reservation.php">Afspraak maken</a></li>
        <li><a href="#over">Contact</a></li>
    </ul>
</footer>

<script>
    // Hamburger menu
    const menuToggle = document.querySelector("#mobile-menu"); // selecteert het id van het element en maakt ervoor een variable aan
    const navLinks = document.querySelector("#nav-links"); // selecteert het id van het element en maakt ervoor een variable aan
    // als je op het hamburger menu klikt
    menuToggle.addEventListener("click", () => {
        navLinks.classList.toggle("hidden"); // voegt hij bij de nav links id de class hidden bij zodat hij verdwijnt
        menuToggle.classList.toggle("open"); // en voegt hij hierbij dat de mobile menu open gaat
    });
</script>
</body>
</html>