<?php
//Require our connection to the database
require 'mysql_conf.php';

//Get information from the user and decode it from json format
$inventory_information = json_decode(file_get_contents('php://input'), true);

//Set the information to variables and use escape string to help prevent SQL injection
$upc = mysqli_real_escape_string($conn,$inventory_information['upc']);
$qty = mysqli_real_escape_string($conn, $inventory_information['qty']);

$select_qty_sql = "SELECT `quantity` FROM `inventory` WHERE `upc`=$upc";

$select_qty_result = mysqli_query($conn, $select_qty_sql);

$select_qty_row = mysqli_fetch_assoc($select_qty_result);

$qty_on_hand = $select_qty_row['quantity'];

$new_qty = $qty_on_hand-$qty;

//Query for updating the database inventory based on user info
if($qty_on_hand >= $qty) {
    $update_sql = "UPDATE `inventory` SET `quantity`=$new_qty WHERE `upc`=$upc";

//Send query to the database
    $update_result = mysqli_query($conn, $update_sql);

//Query for selecting updated inventory quantity
    $select_sql = "SELECT `quantity`,`name`,`device_model`,`color` FROM `inventory` WHERE `upc`=$upc";

//Send query to the database
    $select_result = mysqli_query($conn, $select_sql);

//If a result comes back add the data to the select data array and display message informing user of the update
    if ($select_result) {
        while ($select_row = mysqli_fetch_assoc($select_result)) {
            $select_data[] = $select_row;
        }
        echo json_encode($select_data);
    } else {
        echo 'inventory update failed: ' . mysqli_error($conn);
    }
}else{
    $error['is_error']=true;
    $error['error_message']='Insufficient Inventory';
    echo json_encode($error);
}