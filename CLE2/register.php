<?php
//after register button is pressed
if (isset($_POST['submit'])) {
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

        $adminKey = 0;
        $query = "INSERT INTO users (admin_key, first_name, last_name, email, password) VALUES ('$adminKey', '$firstName', '$lastName', '$email', '$securePassword')";

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
<nav class="flex items-center justify-between p-6 bg-[#04588D]">
    <div>
        <a href="index.php">
            <img src="https://www.deeendragt.nl/wp-content/uploads/sites/13/2022/10/IKCElogoklein.jpg" alt="Logo"
                 class="w-20 h-20">
        </a>
    </div>
    <div class="hidden md:flex gap-6 nav-links">
        <a href="index.php" class="text-white hover:text-[#003060]">Home</a>
        <a href="admin.php" class="text-white hover:text-[#003060]">Overzicht</a>
        <a href="logout.php" class="text-white hover:text-[#003060]">Logout</a>
    </div>
    <div id="mobile-menu" class="menu-toggle md:hidden cursor-pointer flex flex-col gap-1">
        <span class="w-8 h-1 bg-white rounded transition-all"></span>
        <span class="w-8 h-1 bg-white rounded transition-all"></span>
        <span class="w-8 h-1 bg-white rounded transition-all"></span>
    </div>
</nav>
<main>
    <h1 class="flex justify-center text-4xl font-bold font-asap text-[#04588D] my-12">Register</h1><br>
    <div class="flex justify-center">
        <form class="flex flex-col gap-2" action="" method="post">
            <div class="flex flex-col items-start gap-2">
                <label for="firstName">Voornaam</label>
                <input type="text" id="firstName" name="firstName" value="<?= $firstName ?? '' ?>"
                       class="border-2 border-black rounded">
                <p class="font-bold text-red-600 text-xl">
                    <?= $errors['firstName'] ?? '' ?>
                </p>

                <label for="lastName">Achternaam</label>
                <input type="text" id="lastName" name="lastName" value="<?= $lastName ?? '' ?>"
                       class="border-2 border-black rounded">
                <p class="font-bold text-red-600 text-xl">
                    <?= $errors['lastName'] ?? '' ?>
                </p>

                <label for="email">Email</label>
                <input type="text" id="email" name="email" value="<?= $email ?? '' ?>"
                       class="border-2 border-black rounded">
                <p class="font-bold text-red-600 text-xl">
                    <?= $errors['email'] ?? '' ?>
                </p>

                <label for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" value="<?= $password ?? '' ?>"
                       class="border-2 border-black rounded">
                <p class="font-bold text-red-600 text-xl">
                    <?= $errors['password'] ?? '' ?>
                </p>
            </div>
            <br>
            <input type="submit" name=submit value="Registreer"
                   class="rounded-full bg-[#04588D] font-bold text-white p-2 hover:bg-[#04599D]">
        </form>
    </div>
</main>
<footer>

</footer>
</body>
<script>
    // Hamburger menu
    const menuToggle = document.querySelector("#mobile-menu"); // selecteert het id van het element en maakt ervoor een variable aan
    const navLinks = document.querySelector("#nav-links"); // selecteert het id van het element en maakt ervoor een variable aan
    // als je op het hamburger menu klikt
    menuToggle.addEventListener("click", () => {
        navLinks.classList.toggle("hidden"); // voegt hij bij de nav links id de class hidden bij zodat hij verdwijnt
        menuToggle.classList.toggle("open"); // en voegt hij hierbij dat de mobile menu open gaat
    });
</script>
</html>