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


    $search_terms = explode(' ', $_POST["search"]);

    $sql = "SELECT `name`, `description`, `device_model`, `retail_price`, `quantity` FROM `inventory` WHERE `tags` LIKE ";
    $count = count($search_terms);
    for($i = 0; $i<$count; $i++){
        if($i === 0) {
            $sql .= "'%" . $search_terms[$i] . "%'";
        }else{
            $sql .= " '%" . $search_terms[$i] . "%'";
        }
    }

    $result = mysqli_query($conn, $sql);
    if($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        foreach ($data as $key => $value) {
            $description = substr($value['description'], 0, 200);
            echo '<div class="item_name">' . $value['name'] . ' for ' . $value['device_model'] . '</div>';
            echo '<div class="item_description">' . $description . '...</div>';
            echo '<div class="item_price">Price: ' . $value['retail_price'] . '</div>';
            echo '<div class="item_quantity">Qty: ' . $value['quantity'] . '</div>';
            echo '<br>';
        }
    }
    include '../components/footer/footer.php';
}else{
    header('location: ../login/index.php');
}