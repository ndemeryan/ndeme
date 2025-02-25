<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/signup_view.inc.php';
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
    
    <h3>Signup</h3>

    <form action="includes/signup.inc.php" method="post">
       <?php
        signup_inputs();
       ?>
       <br><br>
        <button>Signup</button>
        <br><br>
        <p>Akready have an account? <a href="login.php">Login</a></p>
    </form>
    <?php
    check_signup_errors();
    ?>
</body>
</html>