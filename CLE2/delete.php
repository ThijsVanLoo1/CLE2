<?php
global $db;
require_once "includes/database.php";

$id = $_GET['id'];

$queryDelete = "DELETE FROM reservations WHERE id = $id";
$result = mysqli_query($db, $queryDelete)
or die('Error ' . mysqli_error($db) . ' with query ' . $queryDelete);

header("Location: overview.php");
?>


