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
    var child_container = $(this).find('.child_container');
    if(child_container.find('div').length === 0) {
        var upc = $(this).attr('upc');
        axios.post('retrieve_child_product.php', {upc}).then(resp => {
            var products = resp.data;
            for (var i = 0; i < products.length; i++) {
                var color = '<div class="child_color">' + products[i].color + '</div>';
                var image = products[i].thumbnail_location ? '<img src="images/'+products[i].thumbnail_location+'">' : '<img src="https://iankbarry.files.wordpress.com/2015/05/91937cf37ba5d6727302ec24851b9a1ff46ae5cdaf1578b7bc7dc2c31a7746b5.jpg" height="150px">';
                var upc = '<div class="child_upc">UPC: ' + products[i].upc + '</div>';
                var sku = '<div class="child_sku">SKU: ' + products[i].sku + '</div>';
                var quantity = '<div class="child_quantity">Qty: ' + products[i].quantity + '</div>';
                $(this).find('.child_container').append(color, image, upc, sku, quantity);
            }
        })
    }else{
        child_container.children().remove();
    }
}

/**
 * Apply click handlers to buttons
 */
function apply_click_handler(){
    $('#inventory_shipped').click(ship_inventory);
    $('#inventory_received').click(receive_inventory);
    $('.item_block').click(getChildProducts);
}

