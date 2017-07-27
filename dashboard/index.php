<?php
session_start();

if(isset($_SESSION['user_info'])){
    $user_info = $_SESSION['user_info'];

    echo 'Welcome ' . $user_info['first_name'];
?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
    <?php
        if($_SESSION['privileges']['admin'] || $_SESSION['privileges']['shipping']) {
            echo "<a href = '../inventory_feature/index.php'> Update Inventory </a>";
        }
    ?>
    </body>
    </html>
<?php

}else{
    header('location: ../login');
}