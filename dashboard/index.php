<?php
session_start();
if(isset($_SESSION['user_info'])){

    include('../components/header/header.php');
    include('../components/sidebar/sidebar.php');

    $user_info = $_SESSION['user_info'];

    echo '<div>Welcome ' . $user_info['first_name'].'</div>';

        include('../components/footer/footer.php');

}else{
    header('location: ../login');
}