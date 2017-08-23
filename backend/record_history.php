<?php
session_start();

require"mysql_conf.php";

if(isset($_SESSION['user_info'])){
    $history_information = json_decode(file_get_contents('php://input'), true);
    $upc = mysqli_real_escape_string($conn, $history_information['upc']);
    $qty = mysqli_real_escape_string($conn, $history_information['qty']);

    $sql = "SELECT * FROM `inventory` WHERE `upc`=$upc";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    if(!empty($data)) {
        $name = $data[0]['name'];
        $device_model = $data[0]['device_model'];
        $color = $data[0]['color'];
        $thumbnail = $data[0]['thumbnail_location'];
        $qty_diff = -$qty;
        $qty_current = $data[0]['quantity'];
        $sql = "INSERT INTO `history`(`upc`, `name`, `device_model`, `color`, `thumbnail_location`, `qty_difference`, `qty_current`)
        VALUES ($upc, '$name', '$device_model', '$color', '$thumbnail', $qty_diff, $qty_current)";
        $result = mysqli_query($conn, $sql);
        $history_sql = "SELECT `history_id` FROM `history`";
        $history_result = mysqli_query($conn, $history_sql);
        while($row = mysqli_fetch_assoc($history_result)){
            $history_data[] = $row;
        }
        $data[0]['history_data'] = $history_data;
        if ($result) {
            echo json_encode($data);
        } else {
            echo "history not recorded: " . mysqli_error($conn);
        }
    }
}