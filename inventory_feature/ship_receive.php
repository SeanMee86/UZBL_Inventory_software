<?php
session_start();
if(isset($_SESSION['user_info'])){
    if($_SESSION['privileges']['admin'] || $_SESSION['privileges']['shipping']) {
        include '../components/header/header.php';
        include '../components/sidebar/sidebar.php';
        ?>

        <form>
            <input id="upc" class="form-control col-2" autofocus="autofocus" type="text" name="upc" placeholder="Enter UPC">
            <br>
            <input id="qty" class="form-control col-2" type="text" name="qty" placeholder="Enter Quantity">
            <br>
            <input id="inventory_received" class="btn btn-info col-1" type="button" value="Receive">
            <br><br>
            <input id="inventory_shipped" class="btn col-1" type="button" value="Send">
        </form>
        <div id="form_response"></div>

        <?php
        include '../components/footer/footer.php';
    }else {
        echo "Permission Denied";
    }
}else{
    header('location: ../login/index.php');
}