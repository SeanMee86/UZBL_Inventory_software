<?php
session_start();
if(isset($_SESSION['user_info'])){
    if($_SESSION['privileges']['admin'] || $_SESSION['privileges']['shipping']) {
        include'../components/header/header.php';
        include'../components/sidebar/sidebar.php';
        ?>

        <form>
            <input id="upc" autofocus="autofocus" type="text" name="upc">
            <br><br>
            <input id="qty" type="text" name="qty">
            <br><br>
            <input id="inventory_shipped" type="button" value="Send"><input id="inventory_received" type="button"
                                                                            value="Receive">
        </form>
        <div id="form_response"></div>

        <?php
        include'../components/footer/footer.php';
    }else {
        echo "Permission Denied";
    }
}else{
    header('location: ../login/index.php');
}