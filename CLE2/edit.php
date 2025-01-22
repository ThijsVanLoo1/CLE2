<?php
session_start();

global $db;
require_once "includes/database.php";

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
$selectedTeacher = mysqli_escape_string($db, $_GET['user']);

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

$adminKey = $_SESSION['admin_key'];
// Pakt de geseleceteerde user van de admin
if ($_SESSION['admin_key'] === '1') {
    $adminKey = $_SESSION['admin_key'];
}
// Kijkt of iemand een admin is
if ($adminKey === '1') {
    // Maakt een query aan voor de admin
    $selectedTeacher = $_GET['user'];
    $queryTeacher = "SELECT first_name, last_name, id FROM users where id =$selectedTeacher";
    $resultTeacher = mysqli_query($db, $queryTeacher) or die('Error ' . mysqli_error($db) . ' with query ' . $queryTeacher);
    $rowTeacher = mysqli_fetch_assoc($resultTeacher);
} // anders
else {
    // Pakt hij het id van de docent
    $id_docent = $_SESSION['id'];
    // Daar maakt hij dan een query voor
    $queryTeacher = "SELECT first_name, last_name, id FROM users where id =$id_docent";
    $resultTeacher = mysqli_query($db, $queryTeacher) or die('Error ' . mysqli_error($db) . ' with query ' . $queryTeacher);
    $rowTeacher = mysqli_fetch_assoc($resultTeacher);
}
$idTeacher = $rowTeacher['id'];
$teacherFirstName = $rowTeacher['first_name'];
$teacherLastName = $rowTeacher['last_name'];
$id = $_GET['id'];


$queryReservation = "
SELECT reservations.id, reservations.user_id, reservations.date, reservations.start_time, reservations.end_time, weeks.week_number,weeks.id as week_id 
FROM reservations 
INNER JOIN weeks ON reservations.week_id = weeks.id WHERE reservations.id = $id;";


$result = mysqli_query($db, $queryReservation)
or die('Error ' . mysqli_error($db) . ' with query ' . $queryReservation);

$row = mysqli_fetch_assoc($result);
$timeReservation = $row['start_time'];
$dateReservation = $row['date'];
$weekReservation = $row['id'];
$weekId = $row['week_id'];
$weekNum = $row['week_number'];

if (isset($_POST['submit'])) {
    $weeks = $_POST['weeks'];
    $days = $_POST['days'];
    $times = $_POST['times'];
    $endTime = date('H:i:s', strtotime($times) + 10 * 60);

    $queryUpdate = "UPDATE reservations SET `week_id` = $weeks, `date` = '$days', `start_time` = '$times', `end_time` = '$endTime' where id = $id";

    $result = mysqli_query($db, $queryUpdate)
    or die('Error ' . mysqli_error($db) . ' with query ' . $queryUpdate);

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
        dayList.innerHTML = '<option value="<?= $dateReservation?>" selected><?= $dateReservation?></option>';

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
            // Laat de lijst zien.
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
<nav class="flex items-center justify-between p-6 bg-[#04588D]">
    <div>
        <a href="index.php">
            <img src="https://www.deeendragt.nl/wp-content/uploads/sites/13/2022/10/IKCElogoklein.jpg" alt="Logo"
                 class="w-20 h-20">
        </a>
    </div>
    <div class="hidden md:flex gap-6 nav-links p-8">
        <a href="index.php" class="text-white hover:text-[#003060]">Home</a>
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
    <a href="logout.php" class="text-white block text-center p-2 bg-[#003060] border-b">Logout</a>
</div>
<div id="mobile-menu" class="hidden sm:hidden flex flex-col gap-2 p-4 bg-[#04588D] text-white">
    <a href="index.php" class="hover:text-[#003060] block ">Home</a>
    <a href="logout.php" class="text-white hover:text-[#003060] block ">Logout</a>
</div>
<main class="h-100v w-full flex justify-center items-center m-auto flex-col gap-4">
    <h1 class=" text-xl">Wijzig reservatie</h1>
    <form method="post" action="" class="w-full max-w-md p-8 border-black border-2 rounded text-white bg-[#003060]">
        <div id="teacher-container" class="mt-4 hidden p-2">
            <label for="user_id" class="block font-asap"></label>
            <select id="user_id" name="user_id"
                    class="flex flex-col items-center mt-4 border-2 border-black rounded w-full text-black"
                    onchange="showWeek()">
                <option class="font-asap text-black" value="<?= $idTeacher; ?>"
                        selected><?= $teacherFirstName ?> <?= $teacherLastName ?></option>
            </select>
        </div>
        <label for="weeks" class="mx-2">Welke week:</label>
        <select id="weeks" name="weeks" onchange="showDays()"
                class="border-2 border-black rounded p-2 m-2 w-full font-poppins bg-white text-black">
            <option value="<?= $weekId ?>" selected> Week <?= $weekNum ?></option>
            <?php foreach ($weekData as $weekId => $days): ?>
                <option value="<?= htmlspecialchars($weekId); ?>">
                    Week <?= htmlspecialchars($weekId); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div id="days-container" class="flex flex-col">
            <label for="days" class="mx-2">Welke Dag</label>
            <select id="days" name="days" class="border-2 border-black rounded p-6 mx-2 bg-white text-black"
                    onchange="fetchAvailableTimes()">
                <option value="<?= $dateReservation ?>" selected><?= $dateReservation ?></option>
            </select>
        </div>
        <script type="text/javascript">showDays()</script>

        <div id="time-container" class="w-full m-2 text-black"></div>
        <div id="data-container" class="flex flex-col gap-4 rounded"
             style="display: none; background-color: white;">
            <input type="submit" name="submit" value="Bevestig Keuze"
                   class="border-2 border-black rounded p-4 bg-white text-black">
            <script type="text/javascript">fetchAvailableTimes()</script>
        </div>
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
        <li><a href="logout.php">Logout</a></li>
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