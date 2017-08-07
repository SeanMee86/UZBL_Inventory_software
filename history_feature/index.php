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
                echo '<img src="../public/images/' . $value["thumbnail_location"] . '" class="history_thumbnail">';
                echo '<span class="history_name">'.$value['name'].' '.$value['device_model'].' ('.$value['color'].') </span>';
                echo '<span class="history_time">'.$value['timestamp'].' </span>';
                echo '<span class="history_upc">'.$value['upc'].' </span>';
                echo '<span class="history_qty_diff">'.$value['qty_difference'].' </span>';
                echo '<span class="history_qty_curr">'.$value['qty_current'].' </span>';
                echo '<br>';
            }
        }
        include '../components/footer/footer.php';
    }else{
        echo "Permission Denied";
    }
}else{
    header('location: ../login/index.php');
}