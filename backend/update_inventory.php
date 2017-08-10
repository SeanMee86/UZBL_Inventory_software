<?php
require 'mysql_conf.php';

$inventory_information = json_decode(file_get_contents('php://input'),true);

$upc = mysqli_real_escape_string($conn, $inventory_information['upc']);
$qty = mysqli_real_escape_string($conn, $inventory_information['qty']);

$sql = "UPDATE `inventory` SET `quantity`=$qty WHERE `upc`=$upc";
$result = mysqli_query($conn, $sql);
if($result && !empty($result)){
    echo 'Success, Inventory updated.  New quantity set to: '.$qty;
}else{
    echo 'Update failed';
}