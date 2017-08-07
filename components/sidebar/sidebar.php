<div class="sidebar">
    <ul>
        <li class="sidebar_main"><a href="../dashboard">My Dashboard</a></li>
        <li class="sidebar_main" id="inventory_sidemenu"><a href="../inventory_main/index.php">Inventory</a>
            <?php
            $url = $_SERVER['PHP_SELF'];
            $base_url = "/bizurk_prototype/";
            $privileges = $_SESSION['privileges'];
            if(($url === $base_url."inventory_main/index.php" ||
                $url === $base_url."ship_receive/index.php" ||
                $url === $base_url."inventory_search/index.php" ||
                $url === $base_url."history_feature/index.php") &&
                ($privileges['admin'] || $privileges['shipping'])){;
            ?>
                <ul>
                    <li class="sidebar_sub"><a href="../history_feature/index.php">History</a></li>
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
    <?php
    if($url !== $base_url."history_feature/index.php"){?>
<div class="product_display"></div>
    <?php }; ?>
