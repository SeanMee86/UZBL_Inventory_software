<?php
//Require our connection to the database
require 'mysql_conf.php';


//Get information from the user and decode it from json format
$inventory_information = json_decode(file_get_contents('php://input'), true);

//Set the information to variables and use escape string to help prevent SQL injection
$upc = mysqli_real_escape_string($conn,$inventory_information['upc']);
$qty = mysqli_real_escape_string($conn, $inventory_information['qty']);

//Query for updating the database inventory based on user info
$update_sql = "UPDATE `inventory` SET `on_hand`=(SELECT `on_hand` WHERE `upc`=$upc)-$qty WHERE `upc`=$upc";

//Send query to the database
$update_result = mysqli_query($conn, $update_sql);

//Query for selecting updated inventory quantity
$select_sql = "SELECT `on_hand`,`pending`,`name` FROM `inventory` WHERE `upc`=$upc";

//Send query to the database
$select_result = mysqli_query($conn, $select_sql);

//If a result comes back add the data to the select data array and
if($select_result) {
    while ($select_row = mysqli_fetch_assoc($select_result)) {
        $select_data[] = $select_row;
    }
    $item = $select_data[0]['name'];
    $on_hand = $select_data[0]['on_hand'];
    $pending = $select_data[0]['pending'];
    if($qty > $on_hand){
        echo 'not enough stock';
    }else {
        echo 'inventory successfully updated, new On Hand for ' . $item . ' = ' . $on_hand . ($pending !== null ? ' pending orders = ' . $pending : ' no pending orders');
    }
}else{
    echo 'inventory update failed: ' . mysqli_error($conn);
}