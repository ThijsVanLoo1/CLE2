<?php
/** @var mysqli $db */
require_once "includes/database.php";

$first_name = "";
$last_name = "";
$email = "";
$phone_number = "";
$comment = "";
$date = "";
$time_slot = "";
$error = "";

if (isset($_POST['submit'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $comment = $_POST['comment'];
    $date = $_POST['days'];
    $time_slot = $_POST['times'];

    $errors = [];

    if ($_POST['first_name'] == '') {
        $errors['emptyFirstName'] = 'Vul je voornaam in.';
    }

    if ($_POST['last_name'] == '') {
        $errors['emptyLastName'] = 'Vul je achternaam in.';
    }

    if ($_POST['email'] == '') {
        $errors['emptyEmail'] = 'Vul je email in.';
    }

    if ($_POST['phone_number'] == '') {
        $errors['emptyPhoneNumber'] = 'Vul je telefoonnummer in.';
    }

    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($phone_number)) {

        $first_name = mysqli_real_escape_string($db, $first_name);
        $last_name = mysqli_real_escape_string($db, $last_name);
        $email = mysqli_real_escape_string($db, $email);
        $phone_number = mysqli_real_escape_string($db, $phone_number);
        $time_slot = mysqli_real_escape_string($db, $time_slot);
        $date = mysqli_real_escape_string($db, $date);

        $query = "INSERT INTO reservations (`first_name`, `last_name`, `email`, `phone_number`, `comment`, `date`, `time_slot`) VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$comment', '$date', '$time_slot')";
        $result = mysqli_query($db, $query)
        or die('Error: ' . mysqli_error($db) . ' with query ' . $query);
        header('Location: confirmation.php');
        mysqli_close($db);
        exit;
    }
}
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
        //Functie om de dagen select op te roepen.
        function showDays() {
            const weeks = document.getElementById('weeks').value;
            const daysContainer = document.getElementById('days-container');
            //Als de week is geselecteerd verander de display naar block om het zichtbaar te maken.
            if (weeks) {
                daysContainer.style.display = 'block';
            }
        }

        //Funcitie om een display te maken met alle beschikbare tijden.
        function timeSelect() {
            const selectedDay = document.getElementById('days').value;
            const timeContainer = document.getElementById('time-container');

            timeContainer.innerHTML = '';

            //Maak een label voor de tijd select.
            const label = document.createElement('label');
            label.setAttribute('for', 'times');
            label.textContent = `Selecteer Tijd voor ${selectedDay}`;

            //Maak een form met bijbehorende gegevens.
            const select = document.createElement('select');
            select.setAttribute('id', 'times');
            select.setAttribute('name', 'times');
            select.setAttribute('onchange', 'showData()');
            select.setAttribute('class', 'flex flex-col items-center mt-4 border-2 border-black rounded')

            //Lijst met tijd. Moet nog worden aangepast om met PHP te werken.
            const times = ["12:30", "20:00"];
            //Voor elke tijd maak een optie.
            times.forEach(time => {
                const option = document.createElement('option');
                option.setAttribute('value', time);
                option.textContent = time;
                select.appendChild(option);
            });

            timeContainer.appendChild(label);
            timeContainer.appendChild(select);
        }

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
    <form class="flex flex-col justify-between gap-2" method="post" action="">
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

        <div id="time-container"></div>
        <div id="data-container" class="flex flex-col gap-4" style="display: none;">
            <label for="first_name">Voornaam</label>
            <input type="text" id="first_name" name="first_name" class="border-2 border-black rounded p-4"
                   value="<?= htmlspecialchars($first_name) ?>">
            <label for="last_name">Achternaam</label>
            <input type="text" id="last_name" name="last_name" class="border-2 border-black rounded p-4"
                   value="<?= htmlspecialchars($last_name) ?>">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="border-2 border-black rounded p-4"
                   value="<?= htmlspecialchars($email) ?>">
            <label for="phone_number">Telefoon Nummer</label>
            <input type="number" id="phone_number" name="phone_number" class="border-2 border-black rounded p-4"
                   value="<?= htmlspecialchars($phone_number) ?>">
            <label for="comment">Comment</label>
            <textarea rows="5" cols="3" type="text" id="comment" name="comment"
                      class="border-2 border-black rounded p-4"><?= htmlspecialchars($comment) ?></textarea>
        </div>
        <input type="submit" name="submit" value="Bevestig Keuze" class="border-2 border-black rounded p-2">
    </form>
</div>
</body>
</html>