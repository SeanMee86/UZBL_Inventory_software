<?php
/**
 * Created by PhpStorm.
 * User: seanm
 * Date: 7/26/2017
 * Time: 12:39 PM
 */
session_start();

require '../backend/mysql_conf.php';

$user_information = json_decode(file_get_contents('php://input'), true);


$user_name = mysqli_real_escape_string($conn, $user_information['username']);
$password = mysqli_real_escape_string($conn, md5($user_information['password']));

$sql = "SELECT * FROM `users` WHERE `username`='$user_name' AND `password`='$password'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$admin_priv = $row['is_admin'];
$ship_priv = $row['is_shipper'];
$sales_priv = $row['is_sales'];

$_SESSION['privileges'] = [
    "admin" => $admin_priv ? true : false,
    "shipping" => $ship_priv ? true : false,
    "sales" => $sales_priv ? true : false
];

$_SESSION['user_info'] = [
    "first_name" => $row['first_name'],
    "user_id" => $row['user_id']
];

if($row){
    echo json_encode(["authorized" => true]);
}else{
    echo json_encode(["authorized" => false]);
}



