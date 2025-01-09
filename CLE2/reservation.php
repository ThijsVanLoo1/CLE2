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

<header class="text-center font-bold font-asap text-lg p-4">Rooster</header>
<body>
<form class="flex justify-center" method="post">
    <label for="weeks">Selecteer Week</label>
    <select id="weeks" name="weeks" size="4">
        <option value="week1">Week 1</option>
        <option value="week2">Week 2</option>
        <option value="week3">Week 3</option>
        <option value="week4">Week 4</option>
    </select>
    <label for="days"></label>
    <select id="days" name="days" size="5" onchange="timeSelect()">
        <option value="day1">Ma</option>
        <option value="day2">Di</option>
        <option value="day3">Wo</option>
        <option value="day4">Do</option>
        <option value="day5">Vr</option>
    </select>

    <div id="time-container" class="flex flex-col items-center mt-4"></div>
    <!--    <table class="flex flex-col items-center table-auto border-collapse p-6">-->
    <!--        <thead class="border border-gray-400 px-8 py-2">-->
    <!--        <tr class="flex gap-12 text-base font-asap">-->
    <!--            --><?php //foreach ($days as $day): ?>
    <!--                <th>--><?php //echo $day; ?><!--</th>-->
    <!--            --><?php //endforeach; ?>
    <!--        </tr>-->
    <!--        </thead>-->
    <!--        <tbody class="font-poppins">-->
    <!--        --><?php
    //        for ($i = 0; $i < count($hours); $i++) {
    //            echo '<tr>';
    //            foreach ($days as $day) {
    //                echo '<td class="border border-gray-400 px-4 py-2"><a href="">' . $hours[$i] . '</td>';
    //            }
    //            echo '</tr>';
    //        }
    //        ?>
    <!--        </tbody>-->
    <!--    </table>-->
    <!--    <table>-->
    <!---->
    <!--    </table>-->
    <input type="submit" value="Bevestig Keuze" class="border border-solid border-gray-400 rounded p-2">
</form>
</body>
</html>