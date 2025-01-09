<?php
//working in session, because log-in
session_start();

//is user logged in?
$login = false;

if(isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

//connection with database
global $db;
require_once "includes/database.php";

//if form is submitted
if(isset($_POST['submit'])) {
    //get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    //server-side validation
    if($email === '') {
    $errors['email'] = 'Email needs to be filled in';
    }
    if($password === '') {
    $errors['password'] = 'Password cannot be empty';
    }

    //if there are no errors
    if(empty($errors)) {
        $query = "SELECT * FROM users WHERE email = '$email'";

        $result = mysqli_query($db, $query)
        or die('Error ' . mysqli_error($db) . ' with query ' . $query);

        // check if the user exists
        if(mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);


            // check if password matches in database
            if (password_verify($password, $row['password'])) {
                $_SESSION['user'] = $email;

                header('Location: index.php');
                exit();
            } else {
                //incorrect log-in
                $errors['loginFailed'] = 'Email or password not correct';
            }
        } else {
            // user does not exist
            $errors['loginFailed'] = 'Email or password not correct';
        }
    }
    //error incorrect log in
    mysqli_close($db);
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
    <a href="reservation.php">Reservering maken</a>
</nav>
<main class="bg-white py-6">
    <h1 class="flex justify-center text-4xl font-bold font-asap text-[#04588D] my-12">Log-in</h1><br>
    <div class="flex justify-center">
    <form class="flex flex-col gap-2" action="" method="post">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" class="border-2 border-black rounded">
        <p class="font-bold text-red-600 text-xl">
            <?= $errors['email'] ?? '' ?>
        </p>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="border-2 border-black rounded">
        <p class="font-bold text-red-600 text-xl">
            <?= $errors['password'] ?? '' ?>
        </p>

        <input type="submit" name=submit value="Log-in" class="rounded-full bg-[#04588D] font-bold text-white p-2 hover:bg-[#04599D]">
    </form>
    </div>
</main>

</body>
</html>