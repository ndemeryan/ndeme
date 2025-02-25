<?php

require_once 'includes/config_session.inc.php';
require_once 'includes/login_view.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
    font-family: Arial, Helvetica, sans-serif;
}
input{
    width: 300px;
    height: 30px;
}
button{
    width: 300px;
    height: 30px;
}
    </style>
</head>
<body>
<form action="includes/login.inc.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <br><br>
        <input type="password" name="pwd" placeholder="Password">
        <br><br>
        <button>Login</button>
    </form>

    <?php
    check_login_errors();
    ?>
</body>
</html>