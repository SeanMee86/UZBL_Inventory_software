<?php
session_start();

if(isset($_SESSION['user_info'])){
    $user_info = $_SESSION['user_info'];

    echo 'Welcome ' . $user_info['first_name'];
}else{
    header('location: ../login');
}