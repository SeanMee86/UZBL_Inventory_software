<?php
session_start();
require"../backend/mysql_conf.php";
if(isset($_SESSION['user_info'])){
    if($_SESSION['privileges']['admin'] || $_SESSION['privileges']['shipping']) {
        include '../components/header/header.php';
        include '../components/sidebar/sidebar.php';
        ?>
        <div class="warning_message">
            <p>Warning: This feature deletes the specified product permanently, this cannot be undone.</p>
        </div>
        <form>
            <input id="upc" class="form-control col-6" autofocus="autofocus" type="text" name="upc" placeholder="Enter UPC">
            <br>
            <input id="delete_product" class="btn btn-danger col-2" type="button" value="Delete">
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
