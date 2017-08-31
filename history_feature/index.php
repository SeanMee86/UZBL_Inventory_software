<?php
session_start();
require"../backend/mysql_conf.php";
if(isset($_SESSION['user_info'])){

    include '../components/header/header.php';
    include '../components/sidebar/sidebar.php';
    $sql = "DELETE FROM `history` WHERE `timestamp` < (NOW() - INTERVAL 180 DAY)";
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
                if($value["thumbnail_location"]) {
                    echo '<img src="../public/images/' . $value["thumbnail_location"] . '" class="history_thumbnail">';
                }else{
                    echo '<img src="../public/images/placeholder150-min.png" class="history_thumbnail">';

                }
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
    echo'<div class="history_labels labels_name">Name</div>
         <div class="history_labels labels_time">Time</div>
         <div class="history_labels labels_upc">UPC</div>
         <div class="history_labels labels_qty_diff">Change</div>
         <div class="history_labels labels_qty_curr">Current Count</div>';
    echo '<div class="day_of_week current_day">Today<div class="history_hr"></div></div>';
    selectHistory(0,1);
    echo '<div class="day_of_week">'.date('F jS, Y', mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"))).'<div class="history_hr"></div></div>';
    selectHistory(-1,0);
    echo '<div class="day_of_week">'.date('F jS, Y', mktime(0, 0, 0, date("m")  , date("d")-2, date("Y"))).'<div class="history_hr"></div></div>';
    selectHistory(-2,-1);
    echo '<div class="day_of_week">'.date('F jS, Y', mktime(0, 0, 0, date("m")  , date("d")-3, date("Y"))).'<div class="history_hr"></div></div>';
    selectHistory(-3,-2);
    echo '<div class="day_of_week">'.date('F jS, Y', mktime(0, 0, 0, date("m")  , date("d")-4, date("Y"))).'<div class="history_hr"></div></div>';
    selectHistory(-4,-3);
    echo '<div class="day_of_week">'.date('F jS, Y', mktime(0, 0, 0, date("m")  , date("d")-5, date("Y"))).'<div class="history_hr"></div></div>';
    selectHistory(-5,-4);
    echo '<div class="day_of_week">'.date('F jS, Y', mktime(0, 0, 0, date("m")  , date("d")-6, date("Y"))).'<div class="history_hr"></div></div>';
    selectHistory(-6,-5);
    include '../components/footer/footer.php';

}else{
    header('location: ../login/index.php');
}