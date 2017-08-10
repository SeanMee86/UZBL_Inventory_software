/**
 * Apply functionality after document has loaded
 */
$(document).ready(function(){
    apply_click_handler();
    restrictKeyPress();
});

/**
 * Restrict unwanted key presses in quantity input for Shipping/Receiving feature
 */
function restrictKeyPress(){
    $('#qty').keydown(function(e){
        return (e.which <= 57 && e.which >= 48) || (e.which <= 40 && e.which >= 37) || (e.which <= 105 && e.which >= 96) || e.which === 8 || e.which === 46;
    })
}

/**
 * Remove items from inventory based on user inputs
 */
function ship_inventory(){
    let upc = $('#upc').val();
    let qty = $('#qty').val();
    ship_receive(upc, qty);
}

/**
 * Add items to inventory based on user inputs
 */
function receive_inventory(){
    let upc = $('#upc').val();
    let qty = -($('#qty').val());
    ship_receive(upc, qty);
}

function update_inventory(){
    let upc = $('#upc').val();
    let qty = $('#qty').val();
    axios.post('../backend/update_inventory.php', {upc, qty}).then(resp=>{
        $('#form_response').empty();
        $('#form_response').append('<div>'+resp.data+'</div>')
    });
    $('#upc').val('').focus();
    $('#qty').val('');
}

/**
 * Send the information to the server for updating inventory from shipping and receiving feature
 * @param upc
 * @param qty
 */
function ship_receive(upc, qty){
    axios.post('../backend/ship_receive.php', {upc, qty}).then(resp=>{
        $('#response_message').remove();
        if(resp['data']['is_error']){
            let response_message = '<div id="response_message">'+resp['data']['error_message']+'</div>';
            $('#form_response').append(response_message);

        }else {
            let response_message = '<div id="response_message">' + resp['data'] + '</div>';
            $('#form_response').append(response_message);
            record_history(upc, qty);
        }
    });
    $('#upc').val('').focus();
    $('#qty').val('');
}

/**
 * Record the shipping and receiving history from inventory updater
 * @param upc
 * @param qty
 */
function record_history(upc, qty){
    axios.post('../backend/record_history.php', {upc, qty});
}
/**
 * Get the information to display child products on inventory search page
 */
function getChildProducts(){
    var child_container = $(this).parent('.main_item_container').find('.child_container');
    if(child_container.find('div').length === 0) {
        var upc = $(this).attr('upc');
        axios.post('../backend/retrieve_child_product.php', {upc}).then(resp => {
            var products = resp.data;
            for (var i = 0; i < products.length; i++) {
                var single_child = '<div class="child_number'+i+' single_child" upc="'+products[i].upc+'"></div>';
                var color = '<div class="child_color">' + products[i].color + '</div>';
                var image = products[i].thumbnail_location ? '<img src="../public/images/'+products[i].thumbnail_location+'">' : '<img src="https://iankbarry.files.wordpress.com/2015/05/91937cf37ba5d6727302ec24851b9a1ff46ae5cdaf1578b7bc7dc2c31a7746b5.jpg" height="150px">';
                var upc = '<div class="child_upc">UPC: ' + products[i].upc + '</div>';
                var sku = '<div class="child_sku">SKU: ' + products[i].sku + '</div>';
                var quantity = '<div class="child_quantity">Qty: ' + products[i].quantity + '</div>';
                var child_text = '<div class="child_text">'+color+upc+sku+quantity+'</div>';
                child_container.append(single_child);
                child_container.find('.child_number'+i).append(image, child_text);
            }
            $('.single_child').unbind('click').click(displayProduct);

        });
        $(this).addClass('selected');
    }else{
        child_container.children().remove();
        $('.product_display').children().remove();
        $(this).removeClass('selected');
    }
}

/**
 * Display Product in side container of inventory section
 */
function displayProduct(){
    $('.product_display').children().remove();
    $('.single_child').removeClass('selected');
    $(this).addClass('selected');
    if($(this).attr('upc')){
        var upc = $(this).attr('upc');
    }else{
        upc = $('#upc').val();
    }
    var display_container = '<div class="product_display_container"></div>';
    axios.post('../backend/retrieve_product_for_display.php', {upc}).then(resp => {
        var products = resp.data[0];
        if(products) {
            var title = '<div class="product_display_header">' + products.name + ' for ' + products.device_model + '(' + products.color + ')</div>';
            if(products.back_img_location && products.side_img_location) {
                var image = '<div class="product_display_all_images">' +
                    '<img class="product_display_front" src="../public/images/' + products.front_img_location + '">' +
                    '<div class="product_display_small_images">' +
                    '<img class="product_display_back" src="../public/images/' + products.back_img_location + '">' +
                    '<img class="product_display_side" src="../public/images/' + products.side_img_location + '">' +
                    '</div>' +
                    '</div>';
            }else{
                image = '<div class="product_display_all_images">' +
                    '<img class="product_display_front" src="../public/images/' + products.front_img_location + '">' +
                    '</div>';
            }
            var description = '<div class="product_display_description_header">Description</div>' +
                '<div class="product_display_description_body">' + products.description + '</div>';
            var product_upc = '<div class="product_display_upc">UPC: ' + products.upc + '</div>';
            var sku = '<div class="product_display_sku">SKU: ' + products.sku + '</div>';
            var quantity = '<div class="product_display_quantity"><span class="in_stock">In Stock</span> <span class="in_stock_amount">' + products.quantity + '</span></div>';
            var price_container = '<div class="product_price_container"></div>';
            var retail_price = '<div class="product_display_msrp">MSRP $' + products.retail_price + '</div>';
            var wholesale_table = '<div class="product_display_wholesale">' +
                '<table style="width: 100%">' +
                '<tr>' +
                '<th>QTY:</th>' +
                '<th>1-50</th>' +
                '<th>51-200</th>' +
                '<th>201-349</th>' +
                '<th>350-499</th>' +
                '<th>500-999</th>' +
                '<th>1000-2999</th>' +
                '<th>3000-4999</th>' +
                '<th>5000+</th>' +
                '</tr>' +
                '<tr>' +
                '<td></td>' +
                '<td>$' + products["tier1_1-50"] + '</td>' +
                '<td>$' + products["tier2_51-200"] + '</td>' +
                '<td>$' + products["tier3_201-349"] + '</td>' +
                '<td>$' + products["tier4_350-499"] + '</td>' +
                '<td>$' + products["tier5_500-999"] + '</td>' +
                '<td>$' + products["tier6_1000-2999"] + '</td>' +
                '<td>$' + products["tier7_3000-4999"] + '</td>' +
                '<td>$' + products["tier8_5000"] + '</td>' +
                '</tr>' +
                '</table>' +
                '</div>';
            $('.product_display').append(display_container);
            $('.product_display_container').append(title, image, description, product_upc, sku, quantity, price_container);
            $('.product_price_container').append('<div><b>Pricing</b></div>',retail_price, wholesale_table)
        }else if($('#upc').val() !== ''){
            title = '<div class="product_display_header">Item Not Found</div>';
            image = '<img class="item_not_found_image" src="../public/images/placeholder1080-min.png">';
            var errorMessage = '<div class ="upc_not_found">The UPC You Have Entered Does Not Exist</div>';
            $('.product_display').append(display_container);
            $('.product_display_container').append(title, image, errorMessage);
        }
    });
}

/**
 * Apply click handlers to buttons
 */
function apply_click_handler(){
    $('#inventory_shipped').click(ship_inventory);
    $('#inventory_received').click(receive_inventory);
    $('.item_block').click(getChildProducts);
    $('#inventory_update').click(update_inventory);
    $('#upc').blur(displayProduct);
}

