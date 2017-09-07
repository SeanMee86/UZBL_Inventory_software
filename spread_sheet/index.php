<?php
session_start();
require "../backend/mysql_conf.php";
if(isset($_SESSION['user_info'])){
    include '../components/header/header.php';
    include '../components/sidebar/sidebar.php';

    $sql = "SELECT `upc`, `quantity`, `device_model`, `color`, `name` FROM `inventory`";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    ?>
    <table class="spread_sheet" style="width: 100%">
        <tr>
            <th>Name</th>
            <th>Device Model</th>
            <th>UPC</th>
            <th>Color</th>
            <th>Quantity</th>
        </tr>
            <?php
                foreach($data as $key => $value){
                    echo '<tr>';
                    echo '<td>'.$value['name'].'</td>';
                    echo '<td>'.$value['device_model'].'</td>';
                    echo '<td>'.$value['upc'].'</td>';
                    echo '<td>'.$value['color'].'</td>';
                    echo '<td>'.$value['quantity'].'</td>';
                    echo '</tr>';
                }
            ?>
    </table>
<?php
    include '../components/footer/footer.php';
}else{
header('location: ../login/index.php');
}
