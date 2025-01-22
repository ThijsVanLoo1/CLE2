<?php
session_start();

global $db;
require_once "includes/database.php";

$id = $_GET['id'];

$queryDelete = "DELETE FROM users WHERE id = $id";
$result = mysqli_query($db, $queryDelete)
or die('Error ' . mysqli_error($db) . ' with query ' . $queryDelete);

header("Location: admin.php");
?>
