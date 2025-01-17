<?php
session_start();

global $db;
require_once "includes/database.php";

$query = "SELECT week_id, day_1, day_2, day_3, day_4, day_5 FROM weeks";
$result = mysqli_query($db, $query)
or die('Error ' . mysqli_error($db) . ' with query ' . $query);

//Genereer de weken.
$weekData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $weekData[$row['week_id']] = [
        $row['day_1'],
        $row['day_2'],
        $row['day_3'],
        $row['day_4'],
        $row['day_5']
    ];
}

//Genereer de tijden.
$time = strtotime('12:30');
$endTime = strtotime('20:00');
$addTime = 10; // in minutes
$times = [];

while ($time <= $endTime) {
    $times[] = date('H:i', $time);
    $time += 60 * $addTime;
}

$availableTimes = [];

$link = "login.php";
$text = "Login";

if (!empty($_SESSION) === true) {
    $link = "logout.php";
    $text = "Logout";
} else {
    $link = "login.php";
    $text = "Login";
}

$id = $_GET['id'];

$queryReservation = "SELECT * FROM reservations where id = $id";

$result = mysqli_query($db, $queryReservation) or die('Error ' . mysqli_error($db) . ' with query ' . $queryReservation);

$row = mysqli_fetch_assoc($result);
$reservation = $row;
print_r($reservation);
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
<script>

    //Variabelen voor JS.

    const weekData = <?= json_encode($weekData); ?>;
    const availableTimes = <?= json_encode($availableTimes); ?>;

</script>
<script>


    //Functie om de dagen select op te roepen.
    function showDays() {
        const weekId = document.getElementById('weeks').value; // Correctly get the selected week ID
        const daysContainer = document.getElementById('days-container');
        const dayList = document.getElementById('days');

        // Maak de lijst leeg.
        dayList.innerHTML = '<option value="" disabled selected>Selecteer een dag.</option>';
        daysContainer.style.display = 'none';

        // Vul de lijst in.
        if (weekId && weekData[weekId]) {
            const days = weekData[weekId];
            days.forEach(day => {
                if (day) { // Sla lege dagen over.
                    const option = document.createElement('option');
                    option.value = day;
                    option.textContent = day;
                    dayList.appendChild(option);
                }
            });
            daysContainer.style.display = 'block'; // Laat de lijst zien.
        }

    }

    //Gebruikt Fetch om alle beschikbaren tijden te pakken.
    function fetchAvailableTimes() {

        const selectedDay = document.getElementById('days').value;

        if (!selectedDay) {
            return; // Doe niks als geen dag gekozen is.
        }

        //Maak de form data.
        const formData = new FormData();
        formData.append('date', selectedDay);

        // Gebruik AJAX om een fetch request te doen.
        fetch('fetch.php', {
            method: 'POST',
            body: formData
        })
            //Als de fetch lukt ga door met het maken van de form.
            .then(response => response.json())
            .then(data => {
                const timeContainer = document.getElementById('time-container');
                timeContainer.innerHTML = ''; // Clear the previous times

                //Maak de form.
                if (data && data.length > 0) {
                    const label = document.createElement('label');
                    label.setAttribute('for', 'times');
                    label.textContent = `Selecteer Tijd voor ${selectedDay}`;

                    const select = document.createElement('select');
                    select.setAttribute('id', 'times');
                    select.setAttribute('name', 'times');
                    select.setAttribute('onchange', 'showData()');
                    select.setAttribute('class', 'flex flex-col items-center mt-4 border-2 border-black rounded');

                    // Add available times as options
                    data.forEach(time => {
                        const option = document.createElement('option');
                        option.setAttribute('value', time);
                        option.textContent = time;
                        select.appendChild(option);
                    });

                    timeContainer.appendChild(label);
                    timeContainer.appendChild(select);
                } else {
                    // Geef een bericht door als er geen tijden beschikbaar zijn.
                    timeContainer.innerHTML = 'Geen beschikbare tijden voor deze dag.';
                }
            })
            //Error check.
            .catch(error => {
                console.error('Error fetching available times:', error);
            });
    }

    // Roep de functie op zodra de dag is gekozen.
    document.getElementById('days').addEventListener('change', fetchAvailableTimes);


    //Funcitie die alle andere gegevens laat zien.
    function showData() {
        const timeSlot = document.getElementById('times').value;
        const dataContainer = document.getElementById('data-container');
        //Display flex wordt gebruikt om de velden in een lijst te zetten.
        if (timeSlot) {
            dataContainer.style.display = 'flex';
        }
    }
</script>
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
<main class="h-dvh bg-[#04588D] p-6">
    <form method="post" action="">
        <label for="weeks"></label>
        <select id="weeks" name="weeks" onchange="showDays()" class="border-2 border-black rounded">
            <!-- Hier moet nog een zelfde value van de reservatie  -->
            <option value="" disabled selected>Selecteer een week.</option>
            <?php foreach ($weekData as $weekId => $days): ?>
                <option value="<?= htmlspecialchars($weekId); ?>">
                    Week <?= htmlspecialchars($weekId); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div id="days-container" style="display: none;">
            <label for="days"></label>
            <select id="days" name="days" class="border-2 border-black rounded p-6"
                    onchange="fetchAvailableTimes()">
                <option value="<?= $reservation['date'] ?>" disabled selected>Selecteer een dag.</option>
            </select>
        </div>

        <div id="time-container"></div>
        <div id="data-container" class="flex flex-col gap-4" style="display: none;">
    </form>
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