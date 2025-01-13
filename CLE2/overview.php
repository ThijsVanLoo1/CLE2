<?php

//logged in, so starting session
session_start();

//check if user is actually logged in
if(!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

//check if user is admin
if($_SESSION['admin_key'] !== null) {
    header('Location: admin.php');
    exit();
}

//gives user correct id
$id = $_SESSION['id'];

//get data from database
global $db;
require_once "includes/database.php";

$query = "SELECT * FROM reservations WHERE user_id = $id";

$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$reservations = [];

while($row = mysqli_fetch_assoc($result)) {
    $reservations[] = $row;
}

mysqli_close($db);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Docent - Overzicht</title>
    <body>
        <main>
            <section class="section">
                <table class="table mx-auto">
                    <thead>
                    <tr>
                        <th>Voornaam</th>
                        <th>Achternaam</th>
                        <th>Email</th>
                        <th>Telefoonnummer</th>
                        <th>Opmerking</th>
                        <th>Docentnummer</th>
                        <th>Datum</th>
                        <th>Tijdslot</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td colspan="8">&copy; Reserveringen</td>
                    </tr>
                    </tfoot>
                    <tbody>
                    <!--        print reservations information-->
                    <?php

                    for ($i = 0; $i < count($reservations); $i++) {
                        echo '<tr>';
                        echo "<td>" . htmlentities($reservations[$i]['first_name']) . "</td>";
                        echo "<td>" . htmlentities($reservations[$i]['last_name']) . "</td>";
                        echo "<td>" . htmlentities($reservations[$i]['email']) . "</td>";
                        echo "<td>" . htmlentities($reservations[$i]['phone_number']) . "</td>";
                        echo "<td>" . htmlentities($reservations[$i]['comment']) . "</td>";
                        echo "<td>" . htmlentities($reservations[$i]['user_id']) . "</td>";
                        echo "<td>" . htmlentities($reservations[$i]['date']) . "</td>";
                        echo "<td>" . htmlentities($reservations[$i]['time_slot']) . "</td>";
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </section>
        </main>
    </body>
