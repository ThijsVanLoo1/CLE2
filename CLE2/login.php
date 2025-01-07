<?php

global $db;
require_once "includes/database.php";

if(isset($_POST['submit'])) {
    $email = $_POST['email'];


}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log-in</title>
</head>
<body>
<nav>
    <a href="index.php">Home</a>
</nav>
<main>
    <form>
        <label for="email">Email</label>
        <input type="text" id="email" name="email">

        <label for="password">Password</label>
        <input type="text" id="password" name="password">

        <input type="submit" value="Log-in">
    </form>
</main>

</body>
</html>