<?php
require_once("./config.php");
if(!empty($_SESSION["user_id"])) {
    header("Location: ./index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script src="ajax.js" defer></script>
</head>

<body class="center">
    <h4>Register</h4>
    <form id="register" method="POST">
        <input type="text" class="form-control" name="login" placeholder="Enter Login">
        <input type="email" class="form-control" name="email" placeholder="Enter email">
        <input type="password" class="form-control" name="password" placeholder="Enter Password">
        <input type="password" class="form-control" name="password2" placeholder="Confirm Password">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <p>Already have an account <span><a href="login.php">Login</a></span></p>
</body>

</html>