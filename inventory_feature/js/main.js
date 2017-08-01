/**
 * Apply functionality after document has loaded
 */
$(document).ready(function(){
    apply_click_handler();
});

/**
 * Remove items from inventory based on user inputs
 */
function ship_inventory(){
    let upc = $('#upc').val();
    let qty = $('#qty').val();
    inventory_update(upc, qty);
}

/**
 * Add items to inventory based on user inputs
 */
function receive_inventory(){
    let upc = $('#upc').val();
    let qty = -($('#qty').val());
    inventory_update(upc, qty);
}

/**
 * Send the information to the server
 * @param upc
 * @param qty
 */
function inventory_update(upc, qty){
    axios.post('update_inventory.php', {upc, qty}).then(resp=>{
        if($('#response_message')){
            $('#response_message').remove();
        }
        console.log(resp);
        let response_message = '<div id="response_message">'+resp['data']+'</div>'
        $('#form_response').append(response_message);
    });
    $('#upc').val('');
    $('#qty').val('');
}

/**
 * Get the information to display child products on inventory search page
 */
function getChildProducts(){
    var child_container = $(this).parent('.main_item_container').find('.child_container');
    if(child_container.find('div').length === 0) {
        var upc = $(this).attr('upc');
        axios.post('retrieve_child_product.php', {upc}).then(resp => {
            var products = resp.data;
            for (var i = 0; i < products.length; i++) {
                var single_child = '<div class="child_number'+i+' single_child" upc="'+products[i].upc+'"></div>';
                var color = '<div class="single_child"><div class="child_color">' + products[i].color + '</div>';
                var image = products[i].thumbnail_location ? '<img src="images/'+products[i].thumbnail_location+'">' : '<img src="https://iankbarry.files.wordpress.com/2015/05/91937cf37ba5d6727302ec24851b9a1ff46ae5cdaf1578b7bc7dc2c31a7746b5.jpg" height="150px">';
                var upc = '<div class="child_upc">UPC: ' + products[i].upc + '</div>';
                var sku = '<div class="child_sku">SKU: ' + products[i].sku + '</div>';
                var quantity = '<div class="child_quantity">Qty: ' + products[i].quantity + '</div></div>';
                child_container.append(single_child);
                child_container.find('.child_number'+i).append(color, image, upc, sku, quantity);
            }
            $('.single_child').click(displayProduct);
        })
    }else{
        child_container.children().remove();
    }
}

/**
 * Display Product in side container of inventory section
 */
function displayProduct(){
    $('.product_display').children().remove();
    var upc = $(this).attr('upc');
    axios.post('retrieve_product_for_display.php', {upc}).then(resp => {
        var products = resp.data[0];
        var title = '<div class="product_display_header">'+products.name+' for '+products.device_model+'('+products.color+')</div>';
        var image = '<img class="product_display_front" src="images/' + products.front_img_location + '">' +
            '<img class="product_display_back" src="images/'+products.back_img_location+'">' +
            '<img class="product_display_side" src="images/'+products.side_img_location+'">';
        var description = '<div class="product_display_description_header">Description</div>' +
                '<div class="product_display_description_body">'+products.description+'</div>';
        var product_upc = '<div class="product_display_upc">UPC: '+products.upc+'</div>';
        var sku = '<div class="product_display_sku">SKU: '+products.sku+'</div>';
        var quantity = '<div class="product_display_quantity">On Hand: '+products.quantity+'</div>';
        var retail_price = '<div class="product_display_msrp">MSRP $'+products.retail_price+'</div>';
        $('.product_display').append(title, image, description, product_upc, sku, quantity, retail_price);
    })

}

/**
 * Apply click handlers to buttons
 */
function apply_click_handler(){
    $('#inventory_shipped').click(ship_inventory);
    $('#inventory_received').click(receive_inventory);
    $('.item_block').click(getChildProducts);
}

