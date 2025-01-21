<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

global $db;
require_once "includes/database.php";

$link = "login.php";
$text = "Login";
if (!empty($_SESSION) === true) {
    $link = "logout.php";
    $text = "Logout";
} else {
    $link = "login.php";
    $text = "Login";
}

$id = mysqli_escape_string($db, $_GET['id']);

if ($_SESSION['admin_key'] === '1') {
    $selectedTeacher = mysqli_escape_string($db, $_GET['user']);
}
$query = "SELECT * FROM reservations WHERE id = $id";
$result = mysqli_query($db, $query)
or die('Error ' . mysqli_error($db) . ' with query ' . $query);

$reservation = mysqli_fetch_assoc($result);

mysqli_close($db);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@100..900&display=swap" rel="stylesheet">
    <link href="output.css" rel="stylesheet">
    <title>Reservering details</title>
</head>
<body class="font-asap">
<nav class="flex items-center justify-between p-6 bg-[#04588D]">
    <div>
        <a href="index.php">
            <img src="https://www.deeendragt.nl/wp-content/uploads/sites/13/2022/10/IKCElogoklein.jpg" alt="Logo"
                 class="w-20 h-20">
        </a>
    </div>
    <div class="hidden md:flex gap-6 nav-links p-8">
        <a href="index.php" class="text-white hover:text-[#003060]">Home</a>
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

<main class="flex justify-around">
    <div>
        <h1 class="font-bold mb-8 text-3xl px-16 py-8 max-lg:text-xl max-lg:px-4 max-lg:py-3 max-lg:mb-0 max-lg:mt-4">
            Reservering details</h1>
        <div class="flex flex-col justify-between px-16 mb-8 text-2xl max-lg:px-4 max-lg:flex-col">
            <p><strong>Naam:</strong> <?= $reservation['first_name'] ?> <?= $reservation['last_name'] ?></p>
            <p><strong>Email:</strong> <?= $reservation['email'] ?> </p>
            <p><strong>Telefoon nummer:</strong> <?= $reservation['phone_number'] ?></p>
        </div>
        <div class="flex flex-col gap-2 justify-between px-16 mb-8 text-2xl">
            <p><strong>Opmerking</strong></p>
            <p class="w-3/4 italic mb-12"><?= $reservation['comment'] ?></p>
        </div>
    </div>
    <div class="flex flex-col justify-center items-center gap-4 px-16 py-8">
        <h1 class="font-bold text-3xl max-lg:text-xl max-lg:px-4 max-lg:py-3 max-lg:mb-0 max-lg:mt-4">Wijzig datum en/of
            tijd</h1>
        <p class="text-2xl"><strong>Datum:</strong> <?= $reservation['date'] ?> om <?= $reservation['start_time'] ?></p>
        <a href="edit.php?id=<?= $id ?>&user=<?= $_SESSION['admin_key'] === '1' ? $selectedTeacher : '' ?>"
           class="w-1/2 rounded-lg text-center bg-[#04588D] font-bold text-white p-2 hover:bg-[#04599D]">Aanpassen</a>
            <button id="myButton" onclick="buttonClicker()" class="rounded-lg text-center bg-[#FF0000] font-bold text-white p-2 hover:bg-[#CC0202]">Verwijderen</button>
            <script>
                function buttonClicker() {
                    // Get the button element
                    const button = document.getElementById('myButton');

                    // Add a click event listener to the button
                    button.addEventListener('click', function () {
                        let result = "Weet je zeker dat je deze reservering wilt verwijderen?";
                        confirm(result);
                        if (result) {
                            window.location.href = "delete.php?id=<?= $id ?>";
                        } else {
                            window.location.href = "details.php?id=<?= $id ?>";
                        }
                    });
                }
            </script>
    </div>
</main>

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