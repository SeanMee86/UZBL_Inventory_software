<?php

session_start();

require"mysql_conf.php";

if(isset($_SESSION['user_info'])){
    $history_information = json_decode(file_get_contents('php://input'), true);
    $history_id = $history_information['id'];

    $sql = "DELETE FROM `history` WHERE `history_id`=$history_id";
    $result = mysqli_query($conn, $sql);
    if(mysqli_affected_rows($conn)>0){
        echo 'history deleted';
    }else{
        echo mysqli_error($conn);
    }

}