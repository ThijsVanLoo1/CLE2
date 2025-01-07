<?php

global $db;
require_once "includes/database.php";

if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if($email === '') {
    $errors['email'] = 'Email needs to be filled in';
    }
    if($password === '') {
    $errors['password'] = 'Password cannot be empty';
    }
}

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
    <title>Log-in</title>
</head>
<body class="font-asap">
<nav class="bg-white flex justify-end">
    <a href="index.php">Home</a>
</nav>
<main>
    <div class="flex justify-center">
    <form class="flex flex-col gap-2">
        <label for="email" class="">Email</label>
        <input type="text" id="email" name="email" class="border-2 border-black rounded">

        <label for="password">Password</label>
        <input type="text" id="password" name="password" class="border-2 border-black rounded">

        <input type="submit" value="Log-in" class="border-2 border-black">
    </form>
    </div>
</main>

</body>
</html>