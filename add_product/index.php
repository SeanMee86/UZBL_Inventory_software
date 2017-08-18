<?php
session_start();
require"../backend/mysql_conf.php";
if(isset($_SESSION['user_info'])){
    if($_SESSION['privileges']['admin'] || $_SESSION['privileges']['shipping']) {
        include '../components/header/header.php';
        include '../components/sidebar/sidebar.php';
        ?>

        <div id="form_container">
            <form action="../backend/add_product.php" method="post">
                <div id="name_container">
                    <label for="product_name">Product Name</label>
                    <input type="text" id="product_name" name="product_name">
                </div>
                <div id="images_container">
                    <label for="product_images">Images</label>
                    <input type="text" id="product_images" name="product_main_image" placeholder="Main Picture">
                    <input type="text" name="product_side_image" placeholder="Side Picture">
                    <input type="text" name="product_back_image" placeholder="Back Picture">
                    <input type="text" name="product_thumbnail_image" placeholder="Thumbnail Picture">
                </div>
                <div id="parent_upc_container">
                    <label for="parent_upc">Parent UPC(If Child Product)</label>
                    <input type="text" id="parent_upc" name="parent_upc">
                </div>
                <div id="upc_container">
                    <label for="product_upc">UPC</label>
                    <input type="text" id="product_upc" name="product_upc">
                </div>
                <div id="sku_container">
                    <label for="product_sku">SKU</label>
                    <input type="text" id="product_sku" name="product_sku">
                </div>
                <div id="description_container">
                    <label for="product_description">Description</label>
                    <textarea name="product_description" id="product_description"></textarea>
                </div>
                <div id="pricing_container">
                    <div id="msrp_container">
                        <label for="product_msrp">MSRP $</label>
                        <input type="text" id="product_msrp" name="product_msrp">
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
                                <td><input type="text" name="tier1"></td>
                                <td><input type="text" name="tier2"></td>
                                <td><input type="text" name="tier3"></td>
                                <td><input type="text" name="tier4"></td>
                                <td><input type="text" name="tier5"></td>
                                <td><input type="text" name="tier6"></td>
                                <td><input type="text" name="tier7"></td>
                                <td><input type="text" name="tier8"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="qty_container">
                    <label for="product_qty">Current Stock</label>
                    <input type="text" id="product_qty" name="current_qty">
                </div>
                <div id="tags_container">
                    <label for="product_tags">Search Tags(separated by "|")</label>
                    <input type="text" id="product_tags" name="product_tags">
                </div>
                <div id="add_product_btn">
                    <input type="submit" name="submit" value="Add Product">
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
