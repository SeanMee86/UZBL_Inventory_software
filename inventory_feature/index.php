<?php
session_start();
require"mysql_conf.php";
if(isset($_SESSION['user_info'])){
    include '../components/header/header.php';
    include '../components/sidebar/sidebar.php'; ?>
    <form class="form-inline" action="inventory_search.php" method="post">
        <input class="form-control col-6 inventory_search" type="text" name="search" placeholder="Enter Search Term">
        <input class="btn btn-outline-success search_button" type="submit">
    </form>
    <br>

    <?php

    $sql = "SELECT * FROM `inventory`";

    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }

    foreach ($data as $key => $value) {
        if(!$value['parent_item']) {
            $description = substr($value['description'], 0, 200);
            echo '<div class="item_block" upc="'.$value['upc'].'">';
            echo '<div class="item_name">' . $value['name'] . ' for ' . $value['device_model'] . '</div>';
            echo '<div class="item_price">Price: ' . $value['retail_price'] . '</div>';
            if ($value['thumbnail_location']) {
                echo '<div class="item_thumbnail"><img src="images/' . $value["thumbnail_location"] . '"></div>';
            } else {
                echo '<div class="item_thumbnail">Image goes here</div>';
            }
            echo '<div class="item_description">' . $description . '...</div>';
            echo '<div class="item_quantity">Qty: ' . $value['quantity'] . '</div>';
            echo '<div class="child_container"></div>';
            echo '</div>';
            echo '<br>';
        }
    }
    include '../components/footer/footer.php';
}else{
    header('location: ../login/index.php');
}