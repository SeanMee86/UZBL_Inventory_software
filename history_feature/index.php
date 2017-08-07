<?php
session_start();
require"../backend/mysql_conf.php";
if(isset($_SESSION['user_info'])){
    include '../components/header/header.php';
    include '../components/sidebar/sidebar.php';

    include '../components/footer/footer.php';
}else{
    header('location: ../login/index.php');
}