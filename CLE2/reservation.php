<?php
/** @var mysqli $db */
require_once "includes/database.php";
session_start();
$query = "SELECT id, day_1, day_2, day_3, day_4, day_5 FROM weeks";
$result = mysqli_query($db, $query)
or die('Error ' . mysqli_error($db) . ' with query ' . $query);

//Genereer de weken.
$weekData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $weekData[$row['id']] = [
        $row['day_1'],
        $row['day_2'],
        $row['day_3'],
        $row['day_4'],
        $row['day_5']
    ];
}

$first_name = "";
$last_name = "";
$email = "";
$phone_number = "";
$comment = "";
$date = "";
$start_time = "";
$end_time = "";
$error = "";

$query = "SELECT id, first_name, last_name FROM users";
$result = mysqli_query($db, $query) or die('Error ' . mysqli_error($db) . ' with query ' . $query);
$docenten = [];
while ($row = mysqli_fetch_assoc($result)) {
    $docenten[] = $row;
}

$current_user_id = $_POST['user_id'] ?? $user_id ?? "";

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

//Wanneer er wordt gedrukt op submit.
if (isset($_POST['submit'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $comment = $_POST['comment'];
    $date = $_POST['days'];
    $start_time = $_POST['times'];
    $user_id = $_POST['user_id'];
    $selected_week = $_POST['weeks'];
    $end_time = date('H:i:s', strtotime($start_time) + 10 * 60);

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

    if (empty($errors)) {

        $first_name = mysqli_real_escape_string($db, $first_name);
        $last_name = mysqli_real_escape_string($db, $last_name);
        $email = mysqli_real_escape_string($db, $email);
        $phone_number = mysqli_real_escape_string($db, $phone_number);
        $start_time = mysqli_real_escape_string($db, $start_time);
        $end_time = mysqli_escape_string($db, $end_time);
        $date = mysqli_real_escape_string($db, $date);
        $user_id = mysqli_real_escape_string($db, $user_id);
        $comment = mysqli_real_escape_string($db, $comment);
        $selected_week = mysqli_escape_string($db, $selected_week);

        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['email'] = $email;
        $_SESSION['phone_number'] = $phone_number;
        $_SESSION['start_time'] = $start_time;
        $_SESSION['end_time'] = $end_time;
        $_SESSION['date'] = $date;
        $_SESSION['docent_id'] = $user_id;
        $_SESSION['comment'] = $comment;
        $_SESSION['login'] = false;

        $query = "INSERT INTO reservations (`first_name`, `last_name`, `email`, `phone_number`, `comment`, `user_id`, `week_id`,`date`, `start_time`, `end_time`) VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$comment', '$user_id', '$selected_week', '$date', '$start_time', '$end_time')";
        $result = mysqli_query($db, $query)
        or die('Error: ' . mysqli_error($db) . ' with query ' . $query);
        $id_reservation = mysqli_insert_id($db);
        // Many to many relatie insert
        $query = "INSERT INTO user_reservation (`user_id`, `reservation_id`) values ('$user_id','$id_reservation')";
        $result = mysqli_query($db, $query)
        or die('Error: ' . mysqli_error($db) . ' with query ' . $query);
        header('Location: confirmation.php');
    }

    mysqli_close($db);
    exit;
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

        //Variabelen voor JS.

        const weekData = <?= json_encode($weekData); ?>;
        const availableTimes = <?= json_encode($availableTimes); ?>;

    </script>
    <script>

        function showWeek() {
            const teacherId = document.getElementById('user_id').value;
            const weeksContainer = document.getElementById('weeks-container');

            if (teacherId) {
                weeksContainer.style.display = 'flex';
            }
        }

        //Functie om de dagen select op te roepen.
        function showDays() {
            const weekId = document.getElementById('weeks').value;
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
            //Haal de dag en leraar op.
            const selectedDay = document.getElementById('days').value;
            const selectedTeacher = document.getElementById('user_id').value;

            if (!selectedDay || !selectedTeacher) {
                return;
            }

            const formData = new FormData();
            formData.append('date', selectedDay); //Voeg de dag toe.
            formData.append('user_id', selectedTeacher); //Voeg de ID toe.

            fetch('fetch.php', {
                method: 'POST',
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    const timeContainer = document.getElementById('time-container');
                    timeContainer.innerHTML = ''; //Maak de lijst leeg.

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

                        // Voeg beschikbare tijden to.
                        data.forEach((time) => {
                            const option = document.createElement('option');
                            option.setAttribute('value', time);
                            option.textContent = time;
                            select.appendChild(option);
                        });

                        timeContainer.appendChild(label);
                        timeContainer.appendChild(select);
                    } else {
                        // Geef een bericht door als die leeg is.
                        timeContainer.innerHTML = 'Geen beschikbare tijden voor deze dag.';
                    }
                })
                .catch((error) => {
                    console.error('Error fetching available times:', error);
                });
        }

        // Als de data verandert run het opnieuw.
        document.addEventListener('DOMContentLoaded', () => {
            const selectedWeek = "<?= $_POST['weeks'] ?? '' ?>";
            const selectedDay = "<?= $_POST['days'] ?? '' ?>";
            const selectedTeacher = "<?= $_POST['user_id'] ?? '' ?>";

            // Maak de gegevens opnieuw.
            if (selectedTeacher) {
                document.getElementById('user_id').value = selectedTeacher;
                showWeek();
            }
            if (selectedWeek) {
                document.getElementById('weeks').value = selectedWeek;
                showDays();
            }

            // Doe de fetch opnieuw.
            if (selectedDay) {
                document.getElementById('days').value = selectedDay;
                fetchAvailableTimes();
            }

            // Maak de containers opnieuw.
            const selectedTime = "<?= $_POST['times'] ?? '' ?>";
            if (selectedTime) {
                document.getElementById('times').value = selectedTime;
                showData();
            }
        });

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

<nav class="flex items-center justify-between p-6 bg-[#04588D]">
    <div>
        <a href="index.php">
            <img src="https://www.deeendragt.nl/wp-content/uploads/sites/13/2022/10/IKCElogoklein.jpg" alt="Logo"
                 class="w-20 h-20">
        </a>
    </div>
    <div class="hidden md:flex gap-6 nav-links">
        <a href="index.php" class="text-white hover:text-[#003060]">Home</a>
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
    <a href="#" class="text-white block text-center p-2 bg-[#003060] border-b">Contact</a>
</div>
<div id="mobile-menu" class="hidden sm:hidden flex flex-col gap-2 p-4 bg-[#04588D] text-white">
    <a href="index.php" class="hover:text-[#003060] block ">Home</a>
    <a href="" class="hover:text-[#003060] block ">Contact</a>
</div>

<header class="flex justify-center text-4xl font-bold font-asap text-[#04588D] my-12">Rooster</header>
<body class="min-h-screen flex flex-col">
<div class="h-100v">
    <main class="flex-grow flex justify-center">
        <form class="flex flex-col justify-between items-center gap-2" method="post" action="">
            <div id="teacher-container" class="mt-4">
                <label for="user_id" class="block font-asap"></label>
                <select id="user_id" name="user_id"
                        class="flex flex-col items-center mt-4 border-2 border-black rounded" onchange="showWeek()">
                    <option class="font-asap" value="" disabled selected>Selecteer een docent.</option>
                    <!--                    //Genereer de lijst met docenten: De voornaam en achternaam.-->
                    <?php foreach ($docenten as $docent): ?>
                        <option value="<?= htmlspecialchars($docent['id']) ?>" <?= ($docent['id'] == $current_user_id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($docent['first_name'] . ' ' . $docent['last_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <label for="weeks"></label>
            <div id="weeks-container" style="display: none;">
                <select id="weeks" name="weeks" onchange="showDays()" class="border-2 border-black rounded">
                    <option value="" disabled selected>Selecteer een week.</option>
                    <!--                    //Genereer de lijst met weken.-->
                    <?php foreach ($weekData as $weekId => $days): ?>
                        <option value="<?= htmlspecialchars($weekId); ?>" <?= ($weekId == ($_POST['weeks'] ?? '')) ? 'selected' : ''; ?>>
                            Week <?= htmlspecialchars($weekId); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id="days-container" style="display: none;">
                <label for="days"></label>
                <!--                //Roep Fetch op wanneer er hier iets wordt gekozen.-->
                <select id="days" name="days" class="border-2 border-black rounded p-6"
                        onchange="fetchAvailableTimes()">
                    <option value="" disabled selected>Selecteer een dag.</option>
                </select>
            </div>

            <div id="time-container"></div>
            <div id="data-container" class="flex flex-col items-center gap-4" style="display: none;">
                <div class="flex flex-row">
                    <div class="flex flex-col">
                        <label for="first_name">Voornaam</label>
                        <input type="text" id="first_name" name="first_name" class="border-2 border-black rounded p-4"
                               value="<?= htmlspecialchars($_POST['first_name'] ?? $first_name ?? "") ?>">
                        <p class="font-bold text-red-600 text-xl">
                            <?= ($errors['emptyFirstName']) ?? '' ?>
                        </p>
                    </div>
                    <div class="flex flex-col">
                        <label for="last_name">Achternaam</label>
                        <input type="text" id="last_name" name="last_name" class="border-2 border-black rounded p-4"
                               value="<?= htmlspecialchars($_POST['last_name'] ?? $last_name ?? "") ?>">
                        <p class="font-bold text-red-600 text-xl">
                            <?= ($errors['emptyLastName']) ?? '' ?>
                        </p>
                    </div>
                </div>
                <div class="flex flex-row">
                    <div class="flex flex-col">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="border-2 border-black rounded p-4"
                               value="<?= htmlspecialchars($_POST['email'] ?? $email ?? "") ?>">
                        <p class="font-bold text-red-600 text-xl">
                            <?= ($errors['emptyEmail']) ?? '' ?>
                        </p>
                    </div>
                    <div class="flex flex-col">
                        <label for="phone_number">Telefoon Nummer</label>
                        <input type="number" id="phone_number" name="phone_number"
                               class="border-2 border-black rounded p-4"
                               value="<?= htmlspecialchars($_POST['phone_number'] ?? $phone_number ?? "") ?>">
                        <p class="font-bold text-red-600 text-xl">
                            <?= ($errors['emptyPhoneNumber']) ?? '' ?>
                        </p>
                    </div>
                </div>
                <label for="comment">Comment</label>
                <textarea type="text" id="comment" name="comment"
                          class="border-2 border-black rounded p-4"><?= htmlspecialchars($_POST['comment'] ?? $comment ?? "") ?></textarea>
                <input type="submit" name="submit" value="Bevestig Keuze" class="border-2 border-black rounded p-2">
            </div>
        </form>
    </main>
</div>
<footer class="flex flex-col sm:flex-row sm:gap-3 justify-around p-4 bg-[#003060]">
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
</body>
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
</html>