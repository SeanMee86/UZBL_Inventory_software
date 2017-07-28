<?php
session_start();
require"mysql_conf.php";
if(isset($_SESSION['user_info'])){
        include '../components/header/header.php';
        include '../components/sidebar/sidebar.php';

        $sql = "SELECT `name`, `description`, `device_model`, `retail_price`, `quantity` FROM `inventory`";

        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        foreach($data as $key => $value){
            echo '<div>' . $value['name'] . ' for ' . $value['device_model'] . '</div>';
            echo '<div>' . $value['description'] . '</div>';
            echo '<div>Price: ' . $value['retail_price'] . '</div>';
            echo '<div>Qty: ' . $value['quantity'] . '</div>';
            echo '<br>';
        }
        include '../components/footer/footer.php';
}else{
    header('location: ../login/index.php');
}