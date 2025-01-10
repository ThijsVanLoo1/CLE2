<?php


$days = [
    "Ma",
    "Di",
    "Wo",
    "Do",
    "Vr",
];

$dates = [

];

$hours = [
    "12:30",
    "20:00",
]

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
    <script>
        function timeSelect() {
            const selectedDay = document.getElementById('days').value;
            const timeContainer = document.getElementById('time-container');

            timeContainer.innerHTML = '';

            const label = document.createElement('label');
            label.setAttribute('for', 'times');
            label.textContent = `Selecteer Tijd voor ${selectedDay}`;

            const select = document.createElement('select');
            select.setAttribute('id', 'times');
            select.setAttribute('name', 'times');

            const times = ["12:30", "20:00"]; // Hardcoded timestamps
            times.forEach(time => {
                const option = document.createElement('option');
                option.setAttribute('value', time);
                option.textContent = time;
                select.appendChild(option);
            });

            timeContainer.appendChild(label);
            timeContainer.appendChild(select);
        }
    </script>
</head>

<nav class="text-center bg-cyan-900 font-poppins p-6">
    <a href="login.php">Login</a>
    <a href="logout.php">Logout</a>
    <a href="register.php">Register</a>
    <a href="admin.php">Admin</a>
    <a href="overview.php">Overview</a>
    <a href="confirmation.php">Confirmation</a>
</nav>

<header class="flex justify-center text-4xl font-bold font-asap text-[#04588D] my-12">Rooster</header>
<body>
<div class="flex justify-center">
    <form class="flex flex-col justify-between gap-2" method="post">
        <label for="weeks"></label>
        <select id="weeks" name="weeks" onchange="showDays()" class="border-2 border-black rounded">
            <option value="" disabled selected>Selecteer een week.</option>
            <option value="week1">Week 1</option>
            <option value="week2">Week 2</option>
            <option value="week3">Week 3</option>
            <option value="week4">Week 4</option>
        </select>
        <div id="days-container" style="display: none;">
            <label for="days"></label>
            <select id="days" name="days" class="border-2 border-black rounded p-6" onchange="timeSelect()">
                <option value="" disabled selected>Selecteer een dag.</option>
                <option value="Maandag">Ma</option>
                <option value="Dinsdag">Di</option>
                <option value="Woensdag">Wo</option>
                <option value="Donderdag">Do</option>
                <option value="Vrijdag">Vr</option>
            </select>
        </div>

    <div id="time-container" class="flex flex-col items-center mt-4"></div>
    <input type="submit" value="Bevestig Keuze" class="border border-solid border-gray-400 rounded p-2">
</form>
        <div id="time-container" class="flex flex-col items-center mt-4 border-2 border-black rounded"></div>
        <input type="submit" value="Bevestig Keuze" class="border-2 border-black rounded p-2">
    </form>
</div>
</body>
</html>