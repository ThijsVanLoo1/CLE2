<?php
if (isset($_POST['submit'])) {
    /** @var mysqli $db */
    require_once "includes/database.php";

    $account = [
        $firstName = $_POST['first_name'],
        $lastName = $_POST['last_name'],
        $password = $_POST['password'],
        $email = $_POST['email'],
        $passwordSecure = '',
    ];

    $errors = [];

    if ($_POST['first_name'] == '') {
        $errors['firstName'] = 'Voer een voornaam in.';
    }

    if ($_POST['last_name'] == '') {
        $errors['lastName'] = 'Voer een achternaam in.';
    }

    if ($_POST['password'] == '') {
        $errors['password'] = 'Voer een wachtwoord in.';
    }

    if ($_POST['email'] == '') {
        $errors['email'] = 'Voer een e-mail adres in.';
    }

    if (!empty($firstName) && !empty($lastName) && !empty($password) && !empty($email)) {
        $passwordSecure = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO `users` (`first_name`, `last_name`, `password`, `email`) VALUES ('$firstName', '$lastName', '$passwordSecure', '$email')";
        $result = mysqli_query($db, $query)
        or die('Error: ' . mysqli_error($db) . ' with query ' . $query);
    }


    mysqli_close($db);
    header('Location: admin.php');
    exit;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Pagina</title>
    <link href="output.css" rel="stylesheet">
</head>
