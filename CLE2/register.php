<?php
//after register button is pressed
if(isset($_POST['submit'])) {
    /** @var mysqli $db */
    require_once "includes/database.php";

    $firstName = mysqli_escape_string($db, $_POST['firstName']);
    $lastName = mysqli_escape_string($db, $_POST['lastName']);
    $password = mysqli_escape_string($db, $_POST['password']);
    $email = mysqli_escape_string($db, $_POST['email']);
//check if values are empty
    if ($firstName === '') {
        $errors['firstName'] = 'First name cannot be empty';
    }
    if ($lastName === '') {
        $errors['lastName'] = 'Last name cannot be empty';
    }
    if ($password === '') {
        $errors['password'] = 'Password cannot be empty';
    }
    if ($email === '') {
        $errors['email'] = 'Email cannot be empty';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email is not valid';
    }
//check if there are no errors,
// then insert into database
    if (empty($errors)) {
        $securePassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$firstName', '$lastName', '$email', '$securePassword')";

        $result = mysqli_query($db, $query)
        or die('Error ' . mysqli_error($db) . ' with query ' . $query);

        mysqli_close($db);

        header("location:login.php");
        exit;
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
    <title>Register Pagina</title>
    <link href="output.css" rel="stylesheet">
</head>
<body class="font-asap">
<nav>

</nav>
<main>
    <h1 class="text-[#04588D] font-bold text-4xl flex justify-center m">Registreer Docent</h1><br>
    <form class="flex flex-col items-center font-bold text-[#04588D] text-2xl" action="" method="post">
        <div class="flex flex-col items-start gap-2">
        <label for="firstName">Voornaam</label>
        <input type="text" id="firstName" name="firstName" value="<?= $firstName ?? '' ?>" class="border-2 border-black rounded">
            <p class="font-bold text-red-600 text-xl">
                <?= $errors['firstName'] ?? '' ?>
            </p>

        <label for="lastName">Achternaam</label>
        <input type="text" id="lastName" name="lastName" value="<?= $lastName ?? '' ?>" class="border-2 border-black rounded">
            <p class="font-bold text-red-600 text-xl">
                <?= $errors['lastName'] ?? '' ?>
            </p>

        <label for="email">Email</label>
        <input type="text" id="email" name="email" value="<?= $email ?? '' ?>" class="border-2 border-black rounded">
            <p class="font-bold text-red-600 text-xl">
                <?= $errors['email'] ?? '' ?>
            </p>

        <label for="password">Wachtwoord</label>
        <input type="password" id="password" name="password" value="<?= $password ?? '' ?>" class="border-2 border-black rounded">
            <p class="font-bold text-red-600 text-xl">
                <?= $errors['password'] ?? '' ?>
            </p>
        </div>
        <br>
        <input type="submit" name="submit" value="Registreer" class="rounded-full bg-[#04588D] font-bold text-white p-2 hover:bg-[#04599D]">
    </form>
</main>
<footer>

</footer>
</body>