<?php
session_start();
require"mysql_conf.php";
if(isset($_SESSION['user_info'])){
        include '../components/header/header.php';
        include '../components/sidebar/sidebar.php'; ?>
        <div class="row">
            <input class="form-control col-4 inventory_search" type="text" placeholder="Enter Search Term">
            <input class="btn btn-outline-success search_button" type="submit">
        </div>
        <br>

        <?php

        $sql = "SELECT `name`, `description`, `device_model`, `retail_price`, `quantity` FROM `inventory`";

        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        foreach($data as $key => $value){
            $description = substr($value['description'], 0, 200);
            echo '<div class="item_name">' . $value['name'] . ' for ' . $value['device_model'] . '</div>';
            echo '<div class="item_description">' . $description . '...</div>';
            echo '<div class="item_price">Price: ' . $value['retail_price'] . '</div>';
            echo '<div class="item_quantity">Qty: ' . $value['quantity'] . '</div>';
            echo '<br>';
        }
        include '../components/footer/footer.php';
}else{
    header('location: ../login/index.php');
}