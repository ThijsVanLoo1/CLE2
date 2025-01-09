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
        <a href="#" class="text-white hover:text-[#003060]">Home</a>
        <a href="reservation.php" class="text-white hover:text-[#003060]">Afspraak maken</a>
        <a href="#" class="text-white hover:text-[#003060]">Contact</a>
    </div>
    <div id="mobile-menu" class="menu-toggle md:hidden cursor-pointer flex flex-col gap-1">
        <span class="w-8 h-1 bg-white rounded transition-all"></span>
        <span class="w-8 h-1 bg-white rounded transition-all"></span>
        <span class="w-8 h-1 bg-white rounded transition-all"></span>
    </div>
</nav>

<div class="nav-links hidden flex-col gap-4 bg-[#04588D] p-4 md:hidden">
    <a href="index.php" class="text-white">Home</a>
    <a href="#" class="text-white">Afspraak maken</a>
    <a href="#" class="text-white">Contact</a>
</div>
<div id="mobile-menu" class="hidden sm:hidden flex flex-col gap-2 p-4 bg-[#04588D] text-white">
    <a href="index.php" class="hover:text-[#003060]">Home</a>
    <a href="" class="hover:text-[#003060]">Afspraak maken</a>
    <a href="" class="hover:text-[#003060]">Contact</a>
</div>
<header class="sm:flex flex h-100v w-100w bg-[#003060] border-b border-black xl:p-20 xl:mx-52 p-5 flex-col gap-4 xl:h-70v">
    <h1 class="text-white xl:text-4xl text-xl ">Bedankt voor je reservatie &lt;naam&gt;.</h1>
    <p class="text-white text-base">
        Je hebt een reservatie met docent &lt;naam&gt;. Deze afspraak is op &lt;datum&gt; om &lt;tijdstip&gt; en zal
        plaatsvinden op &lt;locatie&gt;. De afspraak staat geregistreerd onder de naam &lt;naam&gt;. Vergeet niet om
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
        <li><a href="#albums">Afspraak maken</a></li>
        <li><a href="#over">Contact</a></li>
    </ul>
</footer>

<script>
    const menuToggle = document.querySelector("#mobile-menu");
    const navLinks = document.querySelector(".nav-links");

    menuToggle.addEventListener("click", () => {
        navLinks.classList.toggle("hidden");
        menuToggle.classList.toggle("open");
    });
</script>
</body>
</html>