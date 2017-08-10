<?php
session_start();
require"../backend/mysql_conf.php";
if(isset($_SESSION['user_info'])){
    if($_SESSION['privileges']['admin'] || $_SESSION['privileges']['shipping']) {
        include '../components/header/header.php';
        include '../components/sidebar/sidebar.php';
        ?>
        <form>
            <input id="upc" class="form-control col-6" autofocus="autofocus" type="text" name="upc" placeholder="Enter UPC">
            <br>
            <input id="qty" class="form-control col-6" type="text" name="qty" placeholder="Enter Quantity">
            <br>
            <input id="inventory_update" class="btn btn-primary col-2" type="button" value="Update">
        </form>
        <div id="form_response"></div>

        <?php
        include '../components/footer/footer.php';
    }else{
        echo "Permission Denied";
    }
}else{
    header('location: ../login/index.php');
}