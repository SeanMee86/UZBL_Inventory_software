<?php
session_start();
require"../backend/mysql_conf.php";
if(isset($_SESSION['user_info'])){
    if($_SESSION['privileges']['admin'] || $_SESSION['privileges']['shipping']) {
        include '../components/header/header.php';
        include '../components/sidebar/sidebar.php';
        $sql = "SELECT * FROM `history`";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            foreach ($data as $key => $value) {
                echo '<img src="../public/images/' . $value["thumbnail_location"] . '" width="10%">' . "-" . $value['upc'] . "-" . $value['name'] . "-" . $value['device_model'] . "-" . $value['color'] . "-" . $value['timestamp'] . "-" . $value['qty_difference'] . "-" . $value['qty_current'] . "<br>";
            }
        }
        include '../components/footer/footer.php';
    }else{
        echo "Permission Denied";
    }
}else{
    header('location: ../login/index.php');
}