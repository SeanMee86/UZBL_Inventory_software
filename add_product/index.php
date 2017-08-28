<?php
session_start();
require"../backend/mysql_conf.php";

//$model_sql = "SELECT `device_model` FROM `inventory` GROUP BY `device_model`";
//
//$model_result = mysqli_query($conn, $model_sql);
//
//while($model_row = mysqli_fetch_assoc($model_result)){
//    $model_data[] = $model_row;
//}
//$color_sql = "SELECT `color` FROM `inventory` GROUP BY `color`";
//
//$color_result = mysqli_query($conn, $color_sql);
//
//while($color_row = mysqli_fetch_assoc($color_result)){
//    $color_data[] = $color_row;
//}

function sqlFetch($column){
    global $conn;
    $sql = "SELECT `$column` FROM `inventory` GROUP BY `$column`";

    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    return $data;
}

function dropDownItems($val, $selected, $data)
{
    foreach ($data as $key => $value) {
        $option = '<option value="' . $value[$val] . '">' . $value[$val] . '</option>';
        $default_option = '<option value="' . $value[$val] . '" selected>' . $value[$val] . '</option>';
        if ($value[$val] === $selected) {
            echo $default_option;
        } else {
            echo $option;
        }
    }
}

if(isset($_SESSION['user_info'])){
    if($_SESSION['privileges']['admin'] || $_SESSION['privileges']['shipping']) {
        include '../components/header/header.php';
        include '../components/sidebar/sidebar.php';
        ?>

        <div id="main_form_container">
            <form action="../backend/add_product.php" method="post">
                <div id="upc_container">
                    <label for="product_upc">Please Enter a UPC</label>
                    <input type="text" id="product_upc" name="product_upc" required>
                    <input type="button" id="enter_upc" value="Enter UPC">
                </div>
                <div id="form_container">
                    <div id="name_container">
                        <select name="product_name">
                            <?php
                            dropDownItems('name', 'ShockWave', sqlFetch('name'));
                            ?>
                        </select>
                    </div>
                    <div id="images_container">
                        <label for="product_images">Images</label>
                        <input type="text" id="product_images" name="product_main_image" placeholder="Main Picture">
                        <input type="text" id="product_side_image" name="product_side_image" placeholder="Side Picture">
                        <input type="text" id="product_back_image" name="product_back_image" placeholder="Back Picture">
                        <input type="text" id="product_thumbnail_image" name="product_thumbnail_image" placeholder="Thumbnail Picture">
                    </div>
                    <div id="parent_upc_container">
                        <label for="parent_upc">Parent UPC(If Child Product)</label>
                        <input type="text" id="parent_upc" placeholder="Enter Parent UPC" name="parent_upc">
                        <!--                        <input type="text" id="product_dev_model" placeholder="Enter Device Model" name="product_dev_model" required><span class="required">*</span>-->
                        <select name="product_dev_model">
                        <?php
                            dropDownItems('device_model', '2017 iPad 9.7', sqlFetch('device_model'));
                        ?>
                        </select>
<!--                        <input type="text" id="product_color" placeholder="Enter Color" name="product_color">-->
                        <select name="product_color">
                            <?php
                            dropDownItems('color', 'Black', sqlFetch('color'));
                            ?>
                        </select>
                    </div>
                    <div id="sku_container">
                        <label for="product_sku">SKU</label>
                        <input type="text" id="product_sku" placeholder="Enter SKU" name="product_sku">
                    </div>
                    <div id="description_container">
                        <label for="product_description">Description</label>
                        <textarea name="product_description" placeholder="Product Description..." id="product_description"></textarea>
                    </div>
                    <div id="pricing_container">
                        <div id="msrp_container">
                            <label for="product_msrp">MSRP $</label>
                            <input type="text" id="product_msrp" placeholder="Retail Price" name="product_msrp" required><span class="required">*</span>
                        </div>
                        <p id="bulk_header">Bulk Pricing</p>
                        <div id="wholesale_table">
                            <table>
                                <tr>
                                    <th>1-50</th>
                                    <th>51-200</th>
                                    <th>201-349</th>
                                    <th>350-499</th>
                                    <th>500-999</th>
                                    <th>1000-2999</th>
                                    <th>3000-4999</th>
                                    <th>5000+</th>
                                </tr>
                                <tr>
                                    <td><input type="text" id="product_tier1" name="tier1"></td>
                                    <td><input type="text" id="product_tier2" name="tier2"></td>
                                    <td><input type="text" id="product_tier3" name="tier3"></td>
                                    <td><input type="text" id="product_tier4" name="tier4"></td>
                                    <td><input type="text" id="product_tier5" name="tier5"></td>
                                    <td><input type="text" id="product_tier6" name="tier6"></td>
                                    <td><input type="text" id="product_tier7" name="tier7"></td>
                                    <td><input type="text" id="product_tier8" name="tier8"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="qty_container">
                        <label for="product_qty">Current Stock</label>
                        <input type="text" id="product_qty" name="current_qty" placeholder="Quantity On Hand" required><span class="required">*</span>
                    </div>
                    <div id="tags_container">
                        <label for="product_tags">Search Tags(separated by "|")</label>
                        <input type="text" id="product_tags" placeholder="Search Terms" name="product_tags">
                    </div>
                    <div id="add_product_btn">
                        <input type="submit" name="submit" value="Add Product">
                    </div>
                </div>
            </form>
        </div>

        <?php
        include '../components/footer/footer.php';
    }else{
        echo "Permission Denied";
    }
}else{
    header('location: ../login/index.php');
}
