<?php
session_start();
$link = "login.php";
$text = "Login";
if (!empty($_SESSION) === true) {
    $link = "logout.php";
    $text = "Logout";
} else {
    $link = "login.php";
    $text = "Login";
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
    <div class="hidden md:flex gap-6 nav-links">
        <a href="index.php" class="text-white hover:text-[#003060]">Home</a>
        <a href="reservation.php" class="text-white hover:text-[#003060]">Afspraak maken</a>
        <a href="contact.html" class="text-white hover:text-[#003060]">Contact</a>
        <a href="<?= $link; ?>" class="text-white hover:text-[#003060]"><?= $text; ?></a>
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
<header class="sm:flex">
    <img class="sm:w-1/2 w-full h-auto"
         src="https://www.deeendragt.nl/wp-content/uploads/sites/15/2021/04/02h78234-1920x0-1-1024x1024.jpg"
         alt="Kinderen die lachen">
    <div class="bg-[#04588D] text-white sm:w-1/2 px-6 py-10 sm:px-12 sm:py-12 flex flex-col gap-6 sm:my-24
 ">
        <h1 class="font-bold text-lg sm:text-2xl">Afspraak maken met Docent</h1>
        <p>
            De ouderavond komt eraan, dus plan nu je afspraak in om samen met de leerkracht de voortgang, sterke punten
            en aandachtspunten van je kind te bespreken! Zorg ervoor dat je op tijd bent om een moment te reserveren dat
            het beste past bij jouw agenda.
        </p>
        <a class="p-2 bg-[#003060] text-center rounded hover:bg-white hover:text-[#003060] transition duration-300 w-28"
           href="reservation.php">Plan Nu</a>
    </div>
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
