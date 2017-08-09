<?php
session_start();
require"../backend/mysql_conf.php";
if(isset($_SESSION['user_info'])){
    if($_SESSION['privileges']['admin'] || $_SESSION['privileges']['shipping']) {
        include '../components/header/header.php';
        include '../components/sidebar/sidebar.php';
        $sql = "DELETE FROM `history` WHERE `timestamp` < (NOW() - INTERVAL 30 DAY)";
        $result = mysqli_query($conn, $sql);

        function selectHistory($start_date, $end_date)
        {
            global $conn;
            $sql = "SELECT * FROM `history` 
                    WHERE `timestamp` > DATE_ADD(CURDATE(), INTERVAL $start_date DAY) 
                    AND `timestamp` < DATE_ADD(CURDATE(), INTERVAL $end_date DAY) 
                    ORDER BY `timestamp` DESC";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
                foreach ($data as $key => $value) {
                    if ($value['qty_difference'] > 0) {
                        $value['qty_difference'] = '+' . $value['qty_difference'];
                    }
                    echo '<img src="../public/images/' . $value["thumbnail_location"] . '" class="history_thumbnail">';
                    echo '<div class="history_name">' . $value['name'] . ' ' . $value['device_model'] . ' (' . $value['color'] . ') </div>';
                    echo '<div class="history_time">' . $value['timestamp'] . ' </div>';
                    echo '<div class="history_upc">' . $value['upc'] . ' </div>';
                    echo '<div class="history_qty_diff">' . $value['qty_difference'] . ' </div>';
                    echo '<div class="history_qty_curr">' . $value['qty_current'] . ' </div>';
                    echo '<br>';
                }
                echo '<br>';
            }else{
                echo "No History Data Found.<br>";
            }
        }

        echo 'Today<hr>';
        selectHistory(0,1);
        echo date('F jS, Y', mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")))."<hr>";
        selectHistory(-1,0);
        echo date('F jS, Y', mktime(0, 0, 0, date("m")  , date("d")-2, date("Y")))."<hr>";
        selectHistory(-2,-1);
        echo date('F jS, Y', mktime(0, 0, 0, date("m")  , date("d")-3, date("Y")))."<hr>";
        selectHistory(-3,-2);
        echo date('F jS, Y', mktime(0, 0, 0, date("m")  , date("d")-4, date("Y")))."<hr>";
        selectHistory(-4,-3);
        echo date('F jS, Y', mktime(0, 0, 0, date("m")  , date("d")-5, date("Y")))."<hr>";
        selectHistory(-5,-4);
        echo date('F jS, Y', mktime(0, 0, 0, date("m")  , date("d")-6, date("Y")))."<hr>";
        selectHistory(-6,-5);
        include '../components/footer/footer.php';
    }else{
        echo "Permission Denied";
    }
}else{
    header('location: ../login/index.php');
}