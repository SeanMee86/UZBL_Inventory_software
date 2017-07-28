<div class="sidebar">
    <ul>
        <li><a href="../dashboard">My Dashboard</a></li>
        <li id="inventory_sidemenu"><a href="../inventory_feature/index.php">Inventory</a>
            <?php if(($_SERVER['PHP_SELF'] === "/bizurk_prototype/inventory_feature/index.php" ||
                $_SERVER['PHP_SELF'] === "/bizurk_prototype/inventory_feature/ship_receive.php" ||
                $_SERVER['PHP_SELF'] === "/bizurk_prototype/inventory_feature/inventory_search.php") &&
                ($_SESSION['privileges']['admin'] || $_SESSION['privileges']['shipping'])){;?>
            <ul>
                <li>History</li>
                <li><a href="../inventory_feature/ship_receive.php">Updater</a></li>
                <li>New Product</li>
            </ul>
            <?php }; ?>
        </li>
        <li>Messages</li>
        <li>Update Sales Leads</li>
    </ul>
</div>
<div class="inventory_container">
