<?php
/** @var mysqli $db */
require_once "includes/database.php";
session_start();
// 1. kies een week
// 2. zet de value van die week zijn id
// 3. haal de datum uit het database voor die week
// 4. zet de value in de datum's
$query = "SELECT * FROM weeks";
$result = mysqli_query($db, $query) or die('Error ' . mysqli_error($db) . ' with query ' . $query);
$weeks = [];

while ($row = mysqli_fetch_assoc($result)) {
    $weeks[] = $row;
}
$week1 = $weeks[0];
$week2 = $weeks[1];
$week3 = $weeks[2];
$week4 = $weeks[3];

$query = "SELECT id, first_name, last_name FROM users";
$result = mysqli_query($db, $query) or die('Error ' . mysqli_error($db) . ' with query ' . $query);
$docenten = [];

while ($row = mysqli_fetch_assoc($result)) {
    $docenten[] = $row;
}

$current_user_id = $_POST['user_id'] ?? $user_id ?? "";
if (isset($_POST['submit'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $comment = $_POST['comment'];
    $user_id = $_POST['user_id'];
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
        $user_id = mysqli_real_escape_string($db, $user_id);
        $comment = mysqli_real_escape_string($db, $comment);

        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['date'] = $date;
        $_SESSION['docent_id'] = $user_id;
        $_SESSION['time_slot'] = $time_slot;

        $query = "INSERT INTO reservations (`first_name`, `last_name`, `email`, `phone_number`, `comment`,`user_id`, `date`, `time_slot`) VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$comment', '$user_id', '$date', '$time_slot')";
        $result = mysqli_query($db, $query) or die('Error: ' . mysqli_error($db) . ' with query ' . $query);

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@100..900&display=swap" rel="stylesheet">
    <link href="output.css" rel="stylesheet">
    <title>Reservatie pagina</title>
    <script>
        const weeksData = {
            "<?= $week1['week_id'] ?>": ["<?= $week1['day_1'] ?>", "<?= $week1['day_2'] ?>", "<?= $week1['day_3'] ?>", "<?= $week1['day_4'] ?>", "<?= $week1['day_5'] ?>"],
            "<?= $week2['week_id'] ?>": ["<?= $week2['day_1'] ?>", "<?= $week2['day_2'] ?>", "<?= $week2['day_3'] ?>", "<?= $week2['day_4'] ?>", "<?= $week2['day_5'] ?>"],
            "<?= $week3['week_id'] ?>": ["<?= $week3['day_1'] ?>", "<?= $week3['day_2'] ?>", "<?= $week3['day_3'] ?>", "<?= $week3['day_4'] ?>", "<?= $week3['day_5'] ?>"],
            "<?= $week4['week_id'] ?>": ["<?= $week4['day_1'] ?>", "<?= $week4['day_2'] ?>", "<?= $week4['day_3'] ?>", "<?= $week4['day_4'] ?>", "<?= $week4['day_5'] ?>"]
        };

        function showDays() {
            const selectedWeek = document.getElementById('weeks').value;
            const daysContainer = document.getElementById('days-container');
            const daysSelect = document.getElementById('days');

            daysSelect.innerHTML = '<option value="" disabled selected>Selecteer een dag.</option>';

            if (selectedWeek && weeksData[selectedWeek]) {
                weeksData[selectedWeek].forEach((day, index) => {
                    const option = document.createElement('option');
                    option.value = day;
                    option.textContent = ["Ma", "Di", "Wo", "Do", "Vr"][index];
                    daysSelect.appendChild(option);
                });
                daysContainer.style.display = 'block';
            } else {
                daysContainer.style.display = 'none';
            }
        }

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
            select.setAttribute('onchange', 'showData()');
            select.setAttribute('class', 'flex flex-col items-center mt-4 border-2 border-black rounded');

            const times = ["12:30", "20:00"];
            times.forEach(time => {
                const option = document.createElement('option');
                option.setAttribute('value', time);
                option.textContent = time;
                select.appendChild(option);
            });

            timeContainer.appendChild(label);
            timeContainer.appendChild(select);
        }

        function showData() {
            const timeSlot = document.getElementById('times').value;
            const dataContainer = document.getElementById('data-container');
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
<body>
<div class="flex justify-center">
    <form class="flex flex-col justify-between gap-2" method="post" action="">
        <label for="weeks"></label>
        <select id="weeks" name="weeks" onchange="showDays()" class="border-2 border-black rounded">
            <option value="" disabled selected>Selecteer een week.</option>
            <option value="<?= $week1['week_id'] ?>">Week 1</option>
            <option value="<?= $week2['week_id'] ?>">Week 2</option>
            <option value="<?= $week3['week_id'] ?>">Week 3</option>
            <option value="<?= $week4['week_id'] ?>">Week 4</option>
        </select>
        <div id="days-container" style="display: none;">
            <label for="days"></label>
            <select id="days" name="days" class="border-2 border-black rounded p-6" onchange="timeSelect()">
                <option value="" disabled selected>Selecteer een dag.</option>
            </select>
        </div>

        <div id="time-container"></div>
        <div id="data-container" class="flex flex-col gap-4" style="display: none;">
            <label for="first_name">Voornaam</label>
            <input type="text" id="first_name" name="first_name" class="border-2 border-black rounded p-4"
                   value="<?= htmlspecialchars($_POST['first_name'] ?? $first_name ?? "") ?>">
            <label for="last_name">Achternaam</label>
            <input type="text" id="last_name" name="last_name" class="border-2 border-black rounded p-4"
                   value="<?= htmlspecialchars($_POST['last_name'] ?? $last_name ?? "") ?>">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="border-2 border-black rounded p-4"
                   value="<?= htmlspecialchars($_POST['email'] ?? $email ?? "") ?>">
            <label for="user_id">Docent</label>
            <select id="user_id" name="user_id" class="border-2 border-black rounded p-4">
                <option value="">Selecteer een docent</option>
                <?php foreach ($docenten as $docent): ?>
                    <option value="<?= htmlspecialchars($docent['id']) ?>" <?= ($docent['id'] == $current_user_id) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($docent['first_name'] . ' ' . $docent['last_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="phone_number">Telefoon Nummer</label>
            <input type="number" id="phone_number" name="phone_number" class="border-2 border-black rounded p-4"
                   value="<?= htmlspecialchars($_POST['phone_number'] ?? $phone_number ?? "") ?>">
            <label for="comment">Comment</label>
            <textarea rows="5" cols="3" type="text" id="comment" name="comment"
                      class="border-2 border-black rounded p-4"><?= htmlspecialchars($_POST['comment'] ?? $comment ?? "") ?></textarea>
        </div>
        <input type="submit" name="submit" value="Bevestig Keuze" class="border-2 border-black rounded p-2">
    </form>
</div>
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