<?php
session_start();
require"../backend/mysql_conf.php";
if(isset($_SESSION['user_info'])){
    if($_SESSION['privileges']['admin'] || $_SESSION['privileges']['shipping']) {
        include '../components/header/header.php';
        include '../components/sidebar/sidebar.php';
        $sql = "DELETE FROM `history` WHERE `timestamp` < (NOW() - INTERVAL 7 DAY)";
        $result = mysqli_query($conn, $sql);
        $sql = "SELECT * FROM `history` ORDER BY `timestamp` DESC";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            foreach ($data as $key => $value) {
                if($value['qty_difference']>0){
                    $value['qty_difference'] = '+'.$value['qty_difference'];
                }
                echo '<img src="../public/images/' . $value["thumbnail_location"] . '" class="history_thumbnail">';
                echo '<div class="history_name">'.$value['name'].' '.$value['device_model'].' ('.$value['color'].') </div>';
                echo '<div class="history_time">'.$value['timestamp'].' </div>';
                echo '<div class="history_upc">'.$value['upc'].' </div>';
                echo '<div class="history_qty_diff">'.$value['qty_difference'].' </div>';
                echo '<div class="history_qty_curr">'.$value['qty_current'].' </div>';
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