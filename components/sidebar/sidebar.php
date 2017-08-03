<div class="sidebar">
    <ul>
        <li class="sidebar_main"><a href="../dashboard">My Dashboard</a></li>
        <li class="sidebar_main" id="inventory_sidemenu"><a href="../inventory_main/index.php">Inventory</a>
            <?php if(($_SERVER['PHP_SELF'] === "/bizurk_prototype/inventory_main/index.php" ||
                $_SERVER['PHP_SELF'] === "/bizurk_prototype/ship_receive/index.php" ||
                $_SERVER['PHP_SELF'] === "/bizurk_prototype/inventory_search/index.php") &&
                ($_SESSION['privileges']['admin'] || $_SESSION['privileges']['shipping'])){;?>
            <ul>
                <li class="sidebar_sub">History</li>
                <li class="sidebar_sub"><a href="../ship_receive/index.php">Updater</a></li>
                <li class="sidebar_sub">New Product</li>
            </ul>
            <?php }; ?>
        </li>
        <li class="sidebar_main">Messages</li>
        <li class="sidebar_main">Update Sales Leads</li>
    </ul>
</div>
<div class="inventory_container">
<div class="product_display"></div>
