<?php
require 'mysql_conf.php';

$upc = $_POST['product_upc'];
$sku = !empty($_POST['product_sku']) ? mysqli_real_escape_string($conn, $_POST['product_sku']) : '';
$qty = !empty($_POST['current_qty']) ? mysqli_real_escape_string($conn, $_POST['current_qty']) : 0;
$dev_model = mysqli_real_escape_string($conn, $_POST['product_dev_model']);
$color = mysqli_real_escape_string($conn, $_POST['product_color']);
$name = mysqli_real_escape_string($conn, $_POST['product_name']);
$tags = !empty($_POST['product_tags']) ? mysqli_real_escape_string($conn, $_POST['product_tags']) : '';
$description = !empty($_POST['product_description']) ? mysqli_real_escape_string($conn, $_POST['product_description']) : '';
$msrp = mysqli_real_escape_string($conn, $_POST['product_msrp']);
$tier1 = !empty($_POST['tier1']) ? mysqli_real_escape_string($conn, $_POST['tier1']) : 0.00;
$tier2 = !empty($_POST['tier2']) ? mysqli_real_escape_string($conn, $_POST['tier2']) : 0.00;
$tier3 = !empty($_POST['tier3']) ? mysqli_real_escape_string($conn, $_POST['tier3']) : 0.00;
$tier4 = !empty($_POST['tier4']) ? mysqli_real_escape_string($conn, $_POST['tier4']) : 0.00;
$tier5 = !empty($_POST['tier5']) ? mysqli_real_escape_string($conn, $_POST['tier5']) : 0.00;
$tier6 = !empty($_POST['tier6']) ? mysqli_real_escape_string($conn, $_POST['tier6']) : 0.00;
$tier7 = !empty($_POST['tier7']) ? mysqli_real_escape_string($conn, $_POST['tier7']) : 0.00;
$tier8 = !empty($_POST['tier8']) ? mysqli_real_escape_string($conn, $_POST['tier8']) : 0.00;
$parent = !empty($_POST['parent_upc']) ? mysqli_real_escape_string($conn, $_POST['parent_upc']) : 'NULL';
$main_img = !empty($_POST['product_main_image']) ? mysqli_real_escape_string($conn, $_POST['product_main_image']) : '';
$back_img = !empty($_POST['product_back_image']) ? mysqli_real_escape_string($conn, $_POST['product_back_image']) : '';
$side_img = !empty($_POST['product_side_image']) ? mysqli_real_escape_string($conn, $_POST['product_side_image']) : '';
$thumbnail_img = !empty($_POST['product_thumbnail_image']) ? mysqli_real_escape_string($conn, $_POST['product_thumbnail_image']) : '';

$sql="SELECT `upc` FROM `inventory` WHERE `upc`=$upc";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0) {

    $sql = "INSERT INTO `inventory`(`upc`, `sku`, `quantity`, `device_model`, `color`, `name`, `tags`, `description`, `retail_price`, `tier1_1-50`, `tier2_51-200`, `tier3_201-349`, `tier4_350-499`, `tier5_500-999`, `tier6_1000-2999`, `tier7_3000-4999`, `tier8_5000`, `parent_item`, `thumbnail_location`, `front_img_location`, `back_img_location`, `side_img_location`) 
        VALUES ($upc, '$sku', $qty, '$dev_model', '$color', '$name', '$tags', '$description', $msrp, $tier1, $tier2, $tier3, $tier4, $tier5, $tier6, $tier7, $tier8,$parent, '$thumbnail_img', '$main_img', '$back_img', '$side_img')";

    $result = mysqli_query($conn, $sql);



}else{

    $sql = "UPDATE `inventory` SET `sku`='$sku',`quantity`=$qty,`device_model`='$dev_model',
    `color`='$color',`name`='$name',`tags`='$tags',`description`='$description',`retail_price`=$msrp,
    `tier1_1-50`=$tier1,`tier2_51-200`=$tier2,`tier3_201-349`=$tier3,`tier4_350-499`=$tier4,
    `tier5_500-999`=$tier5,`tier6_1000-2999`=$tier6,`tier7_3000-4999`=$tier7,`tier8_5000`=$tier8,
    `parent_item`=$parent,`thumbnail_location`='$thumbnail_img',`front_img_location`='$main_img',
    `back_img_location`='$back_img',`side_img_location`='$side_img' WHERE `upc`=$upc";

    $result = mysqli_query($conn, $sql);

}
header('location: ../add_product/index.php');
