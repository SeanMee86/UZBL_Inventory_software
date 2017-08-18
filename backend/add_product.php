<?php
require 'mysql_conf.php';

$upc = $_POST['product_upc'];
$sku = !empty($_POST['product_sku']) ? $_POST['product_sku'] : '';
$qty = !empty($_POST['current_qty']) ? $_POST['current_qty'] : 0;
$dev_model = $_POST['product_dev_model'];
$color = $_POST['product_color'];
$name = $_POST['product_name'];
$tags = !empty($_POST['product_tags']) ? $_POST['product_tags'] : '';
$description = !empty($_POST['product_description']) ? $_POST['product_description'] : '';
$msrp = $_POST['product_msrp'];
$tier1 = !empty($_POST['tier1']) ? $_POST['tier1'] : 0.00;
$tier2 = !empty($_POST['tier2']) ? $_POST['tier2'] : 0.00;
$tier3 = !empty($_POST['tier3']) ? $_POST['tier3'] : 0.00;
$tier4 = !empty($_POST['tier4']) ? $_POST['tier4'] : 0.00;
$tier5 = !empty($_POST['tier5']) ? $_POST['tier5'] : 0.00;
$tier6 = !empty($_POST['tier6']) ? $_POST['tier6'] : 0.00;
$tier7 = !empty($_POST['tier7']) ? $_POST['tier7'] : 0.00;
$tier8 = !empty($_POST['tier8']) ? $_POST['tier8'] : 0.00;
$parent = !empty($_POST['parent_upc']) ? $_POST['parent_upc'] : 'NULL';
$main_img = !empty($_POST['product_main_image']) ? $_POST['product_main_image'] : '';
$back_img = !empty($_POST['product_back_image']) ? $_POST['product_back_image'] : '';
$side_img = !empty($_POST['product_side_image']) ? $_POST['product_side_image'] : '';
$thumbnail_img = !empty($_POST['product_thumbnail_image']) ? $_POST['product_thumbnail_image'] : '';
echo'<pre>';
print_r($_POST);
echo'</pre>';



$sql = "INSERT INTO `inventory`(`upc`, `sku`, `quantity`, `device_model`, `color`, `name`, `tags`, `description`, `retail_price`, `tier1_1-50`, `tier2_51-200`, `tier3_201-349`, `tier4_350-499`, `tier5_500-999`, `tier6_1000-2999`, `tier7_3000-4999`, `tier8_5000`, `parent_item`, `thumbnail_location`, `front_img_location`, `back_img_location`, `side_img_location`) 
        VALUES ($upc, '$sku', $qty, '$dev_model', '$color', '$name', '$tags', '$description', $msrp, $tier1, $tier2, $tier3, $tier4, $tier5, $tier6, $tier7, $tier8,$parent, '$thumbnail_img', '$main_img', '$back_img', '$side_img')";

echo $sql.'<hr>';

$result = mysqli_query($conn, $sql);

echo mysqli_error($conn);

header('location: http://localhost/bizurk_prototype/add_product/index.php');
