<?php
/**
 * Created by PhpStorm.
 * User: seanm
 * Date: 7/26/2017
 * Time: 12:28 PM
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.2/axios.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
    <script src="js/main.js"></script>

</head>
<body>
<form class="centerLogin">
    <img id="loginLogo" src="img/loginlogo-min.png" /> 
    <input id="username" class="inputLogin" type="text" name="username">
    <br><br>
    <input id="password" class="inputLogin" type="text" name="password">
    <br><br>
    <input id="login_submit" class="bluebuttonSubmit" type="button" value="Login">
</form>
<div class="error_message"></div>

</body>
</html>

