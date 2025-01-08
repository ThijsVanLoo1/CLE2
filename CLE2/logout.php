<?php
session_start();
session_destroy();
header("Location: reservation.php");
exit;
?>