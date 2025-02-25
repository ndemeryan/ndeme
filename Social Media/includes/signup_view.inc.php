<?php

declare(strict_types=1);

function signup_inputs() {

    if(isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])){
        echo '<input type="text" name="username" placeholder="Username" value="' . $_SESSION["signup_data"]["username"] .'">';
        echo '<br>';
        echo '<br>';
    }else{
        echo '<input type="text" name="username" placeholder="Username">';
        echo '<br>';
        echo '<br>';
    }

    echo '<input type="password" name="pwd" placeholder="Password">';
    echo '<br>';
    echo '<br>';

    if(isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["invalid_email"])){
        echo '<input type="text" name="email" placeholder="E-mail" value="' . $_SESSION["signup_data"]["email"] .'">';
    }else{
        echo '<input type="text" name="email" placeholder="E-mail">';
    }
}

function check_signup_errors() {
    if(isset($_SESSION["error_signup"])){
        $errors = $_SESSION["error_signup"];

        echo "<br>";

        foreach($errors as $error){
            echo '<p class="form-error">' . $error . '</p>';
        }

        unset($_SESSION["error_signup"]);
    }else if(isset($_GET["signup"])  && $_GET["signup"] === "success"){
        echo '<br>';
        echo '<p class="form-success">Signup success</p>';
    }
}
