<?php
session_start();
require"../backend/mysql_conf.php";
if(isset($_SESSION['user_info'])){

    include '../components/header/header.php';
    include '../components/sidebar/sidebar.php';
    $sql = "DELETE FROM `history` WHERE `timestamp` < (NOW() - INTERVAL 180 DAY)";
    $result = mysqli_query($conn, $sql);
    if(!isset($_POST['submit'])) {
        
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
                if($start_date == 0){
                    echo '<div class="day_of_week">Today</div>';
                }else {
                    echo '<div class="day_of_week">' . date('F jS, Y', mktime(0, 0, 0, date("m"), date("d") + ($start_date), date("Y"))) . '<div class="history_hr"></div></div>';
                }
                foreach ($data as $key => $value) {

                    if ($value['qty_difference'] > 0) {
                        $value['qty_difference'] = '+' . $value['qty_difference'];
                    }
                    if ($value["thumbnail_location"]) {
                        echo '<img src="../public/images/' . $value["thumbnail_location"] . '" class="history_thumbnail">';
                    } else {
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
            }
        }
    }else{

        $upc = $_POST['upc'];

        function selectHistory($start_date, $end_date)
        {
            global $upc;
            global $conn;
            $sql = "SELECT * FROM `history` 
                WHERE `timestamp` > DATE_ADD(CURDATE(), INTERVAL $start_date DAY) 
                AND `timestamp` < DATE_ADD(CURDATE(), INTERVAL $end_date DAY)
                AND `upc`=$upc
                ORDER BY `timestamp` DESC";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result)>0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
                if($start_date == 0){
                    echo '<div class="day_of_week">Today</div>';
                }else {
                    echo '<div class="day_of_week">' . date('F jS, Y', mktime(0, 0, 0, date("m"), date("d") + ($start_date), date("Y"))) . '<div class="history_hr"></div></div>';
                }                foreach ($data as $key => $value) {
                    if ($value['qty_difference'] > 0) {
                        $value['qty_difference'] = '+' . $value['qty_difference'];
                    }
                    if ($value["thumbnail_location"]) {
                        echo '<img src="../public/images/' . $value["thumbnail_location"] . '" class="history_thumbnail">';
                    } else {
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
            }
        }
    }
?>

    <form action="index.php" method="post">
        <input class="form-control col-4" autofocus="autofocus" type="text" name="upc" placeholder="Enter UPC">
        <br>
        <input class="btn btn-primary col-1" name="submit" type="submit" value="Search">
        <hr>
    </form>

<?php
    echo'<div class="history_labels labels_name">Name</div>
         <div class="history_labels labels_time">Time</div>
         <div class="history_labels labels_upc">UPC</div>
         <div class="history_labels labels_qty_diff">Change</div>
         <div class="history_labels labels_qty_curr">Current Count</div>';

    for($i=0; $i>-30;$i--)
    {
        selectHistory($i, $i + 1);
    }

    include '../components/footer/footer.php';

}else{
    header('location: ../login/index.php');
}