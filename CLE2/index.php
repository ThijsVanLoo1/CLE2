<?php


$days = [
    "Ma",
    "Di",
    "Wo",
    "Do",
    "Vr",
];

$hours = [
    "17:45",
    "18:15",
    "18:45",
    "19:15",
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
<form class="flex flex-col items-center">
    <table class="flex flex-col items-center table-auto border-collapse p-6">
        <thead class="border border-gray-400 px-8 py-2">
        <tr class="flex gap-12 text-base font-asap">
            <?php foreach ($days as $day): ?>
                <th><?php echo $day; ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody class="font-poppins">
        <?php
        for ($i = 0; $i < count($hours); $i++) {
            echo '<tr>';
            foreach ($days as $day) {
                echo '<td class="border border-gray-400 px-4 py-2"><a href="">' . $hours[$i] . '</td>';
            }
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
    <input type="submit" value="Bevestig Keuze" class="border border-solid border-gray-400 rounded p-2">
</form>
</body>
</html>