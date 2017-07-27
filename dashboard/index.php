<?php
session_start();
if(isset($_SESSION['user_info'])){

    include('../components/header/header.php');
    include('../components/sidebar/sidebar.php');

    $user_info = $_SESSION['user_info'];

    echo '<div>Welcome ' . $user_info['first_name'].'</div>';

        if($_SESSION['privileges']['admin'] || $_SESSION['privileges']['shipping']) {
            echo "<a href = '../inventory_feature/index.php'> Update Inventory </a>";
        }

        include('../components/footer/footer.php');

}else{
    header('location: ../login');
}