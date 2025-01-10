<?php

session_start();

print_r($_SESSION);

if($_SESSION['admin_key'] === null) {
    header('location: overview.php');
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Pagina</title>
    <link href="output.css" rel="stylesheet">
</head>
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
            <!--        Loop through all albums in the collection-->
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
