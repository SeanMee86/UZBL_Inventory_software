<?php
require 'mysql_conf.php';

$inventory_information = json_decode(file_get_contents('php://input'),true);

$upc = mysqli_real_escape_string($conn, $inventory_information['upc']);

$sql = "DELETE FROM `inventory` WHERE `upc`=$upc";
$result = mysqli_query($conn, $sql);
if(mysqli_affected_rows($conn)>0){
    echo 'Product deleted from database';
}else{
    echo 'Delete failed';
}