<?php

require '../backend/mysql_conf.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

$output = fopen('php://output', 'w');

fputcsv($output, array('ProductSKU', 'Qty In Stock'));

$sql = "SELECT `upc`, `quantity` FROM `inventory`";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){
    fputcsv($output, $row);
}
