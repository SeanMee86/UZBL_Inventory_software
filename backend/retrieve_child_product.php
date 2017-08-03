<?php
/**
 * Created by PhpStorm.
 * User: seanm
 * Date: 7/31/2017
 * Time: 12:48 PM
 */
session_start();

require "mysql_conf.php";

if(isset($_SESSION['user_info'])){
    $product_information = json_decode(file_get_contents('php://input'), true);
    $upc = $product_information['upc'];
    $sql = "SELECT `color`, `upc`, `quantity`, `sku`, `thumbnail_location` FROM `inventory` WHERE `parent_item`=$upc OR `upc`=$upc";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $data[]=$row;
    }
    $json_data = json_encode($data);
    echo $json_data;
}else{
    header('location: ../login');
}
