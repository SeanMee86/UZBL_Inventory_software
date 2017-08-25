/**
 * Apply functionality after document has loaded
 */
$(document).ready(function(){
    apply_event_handler();
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
 * Ship items from inventory based on user inputs from shipping and receiving feature
 */
function ship_inventory(){
    const upc = $('#upc').val();
    const qty = $('#qty').val();
    ship_receive(upc, qty);
}

/**
 * Receive items into inventory based on user inputs from shipping and receiving feature
 */
function receive_inventory(){
    const upc = $('#upc').val();
    const qty = -($('#qty').val());
    ship_receive(upc, qty);
}

/**
 * Send the information to the server for updating inventory from shipping and receiving feature
 * @param upc
 * @param qty
 */
function ship_receive(upc, qty){
    axios.post('../backend/ship_receive.php', {upc, qty}).then(resp=>{
        $('#response_message').remove();
        let response_message;
        if(resp['data']['is_error']){
            response_message = '<div id="response_message">'+resp['data']['error_message']+'</div>';
            $('#form_response').append(response_message);

        }else {
            const data = resp.data[0];
            response_message = '<div id="response_message">inventory successfully updated, new On Hand for the ' + data['name'] + ' for ' + data['device_model'] + ' (' + data['color'] + ')' + ' = ' + data['quantity'] + '</div>';
            $('#form_response').append(response_message);
            updateLive(data['quantity']);
            record_history(upc, qty);
        }
    });
    $('#upc').val('').focus();
    $('#qty').val('');
}

/**
 * Displays the new total amount after shipping or receiving inventory
 */
function updateLive(qty){
    $('.in_stock_amount').text(qty);
}

/**
 * Record the shipping and receiving history from inventory updater and append short term (st) history underneath form.
 * @param upc
 * @param qty
 */
function record_history(upc, qty){
    axios.post('../backend/record_history.php', {upc, qty}).then(resp=>{
        const history_data = resp.data[0].history_data;
        const history_id = history_data[history_data.length-1].history_id;
        const qty_difference = -qty;
        const name_of_product = resp.data[0].name;
        const undo_button = '<input class="undo_ship_receive" type="button" value="Undo">';
        const history_container = '<div class="history_container"></div>';
        if($('.history_container').length === 0) $('.inventory_container').append(history_container);
        $('.history_container').append(
            '<div class="st_history">' +
            '<span class="history_id" style="display: none">'+history_id+'</span>' +
            '<span class="undo_upc">' + upc + '</span>' +
            ' ' + '<span class="undo_quantity">' + (qty_difference>0 ? '+' : '') + qty_difference + '</span>' +
            ' ' + '<span class="undo_product_name">'+ name_of_product + '</span>'+
            ' ' + '<span class="undo_btn">' + undo_button + '</span>' +
            '</div>'
        );
        $('.undo_ship_receive').unbind('click').click(undo_history);
    });
}

/**
 * Undoes a recent shipping and receiving error
 * @param upc
 * @param qty
 * @param id
 */
function undo_history(upc, qty, id){
    upc = parseInt($(this).parent().find('.undo_upc').text());
    qty = parseInt($(this).parent().find('.undo_quantity').text());
    id = parseInt($(this).parent().find('.history_id').text());
    axios.post('../backend/ship_receive.php', {upc, qty}).then(()=>{
        $('#response_message').remove();
        $(this).parent().remove();
        delete_history(id);
    });
}

/**
 * Deletes Ship/Receive Update from history table if undone due to user error
 * @param id
 */
function delete_history(id){
    axios.post('../backend/delete_history.php', {id})
}

/**
 * Sends UPC to server to get information to build child product displays on main inventory page
 * @param upc
 * @param child_container
 */
function callAxiosForChild(upc, child_container){
    axios.post('../backend/retrieve_child_product.php', {upc}).then(resp => {
        const products = resp.data;
        for (let i = 0; i < products.length; i++) {
            const single_child = '<div class="child_number'+i+' single_child" upc="'+products[i].upc+'"></div>';
            const color = '<div class="child_color">' + products[i].color + '</div>';
            const image = products[i].thumbnail_location ? '<img src="../public/images/'+products[i].thumbnail_location+'">' : '<img src="../public/images/placeholder150-min.png" height="150px">';
            const upc = '<div class="child_upc">UPC: ' + products[i].upc + '</div>';
            const sku = '<div class="child_sku">SKU: ' + products[i].sku + '</div>';
            const quantity = '<div class="child_quantity">Qty: ' + products[i].quantity + '</div>';
            const child_text = '<div class="child_text">'+color+upc+sku+quantity+'</div>';
            child_container.append(single_child);
            child_container.find('.child_number'+i).append(image, child_text);
        }
        $('.single_child').unbind('click').click(displayProductFromChild);
    });
}

/**
 * Get the information to display child products on inventory search page
 */
function getChildProducts(){
    const child_container = $(this).parent('.main_item_container').find('.child_container');
    if(child_container.find('div').length === 0) {
        $('.child_container').empty();
        $('.item_block').removeClass('selected');
        const upc = $(this).attr('upc');
        callAxiosForChild(upc, child_container);
        $(this).addClass('selected');
    }else{
        child_container.children().remove();
        $('.product_display').children().remove();
        $(this).removeClass('selected');
    }
}

/**
 * Send UPC to Server to retrieve product information from database
 * @param upc
 */
function callAxiosForDisplay(upc){
    axios.post('../backend/retrieve_product_for_display.php', {upc}).then(resp => {
        const product = resp.data[0];
        if(product) {
            createDisplay(product);
        }else if($('#upc').val() !== ''){
            const display_container = '<div class="product_display_container"></div>';
            const title = '<div class="product_display_header">Item Not Found</div>';
            const image = '<img class="item_not_found_image" src="../public/images/placeholder1080-min.png">';
            const errorMessage = '<div class ="upc_not_found">The UPC You Have Entered Does Not Exist</div>';
            $('.product_display').append(display_container);
            $('.product_display_container').append(title, image, errorMessage);
        }
        if(!$(this).hasClass('selected') && $(this).hasClass('item_block')){
            $('.product_display').children().remove();
        }
    });
}

/**
 * Display Product in side container of inventory section after clicking a child element on the main inventory page
 */
function displayProductFromChild(){
    $('.product_display').children().remove();
    $('.single_child').removeClass('selected');
    if($(this).hasClass('single_child')) {
        $(this).addClass('selected');
    }
    const upc = $(this).attr('upc');
    callAxiosForDisplay(upc);
}

/**
 * Display Product in side container of inventory section after entering upc into input on ship/receive, delete,
 * and add/update features.
 */
function displayProductFromInput(){
    $('.product_display').children().remove();
    let upc;
    if($('#product_upc').val()){
        upc = $('#product_upc').val();
    }else{
        upc = $('#upc').val();
    }
    callAxiosForDisplay(upc);
}

/**
 * Create product display from information retrieved from database
 * @param products
 */
function createDisplay(products){
    const display_container = '<div class="product_display_container"></div>';
    const title = '<div class="product_display_header">' + products.name + ' for ' + products.device_model + '(' + products.color + ')</div>';
    let image;
    if(products.back_img_location && products.side_img_location) {
        image = '<div class="product_display_all_images">' +
            '<img class="product_display_front" src="../public/images/' + products.front_img_location + '">' +
            '<div class="product_display_small_images">' +
            '<img class="product_display_back" src="../public/images/' + products.back_img_location + '">' +
            '<img class="product_display_side" src="../public/images/' + products.side_img_location + '">' +
            '</div>' +
            '</div>';
    }else if(products.front_img_location){
        image = '<div class="product_display_all_images">' +
            '<img class="product_display_front" src="../public/images/' + products.front_img_location + '">' +
            '</div>';
    }else{
        image = '<div class="product_display_all_images">' +
            '<img class="product_display_front" src="../public/images/placeholder150-min.png">' +
            '</div>';
    }
    const description = '<div class="product_display_description_header">Description</div>' +
        '<div class="product_display_description_body">' + products.description + '</div>';
    const product_upc = '<div class="product_display_upc">UPC: ' + products.upc + '</div>';
    const sku = '<div class="product_display_sku">SKU: ' + products.sku + '</div>';
    const quantity = '<div class="product_display_quantity"><span class="in_stock">In Stock</span><span class="in_stock_amount">' + products.quantity + '</span></div>';
    const price_container = '<div class="product_price_container"></div>';
    const retail_price = '<div class="product_display_msrp">MSRP $' + products.retail_price + '</div>';
    const wholesale_table = '<div class="product_display_wholesale">' +
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
}

/**
 * Deletes a product from the database
 */
function delete_product(){
    const upc = $('#upc').val();
    const confirm_delete = confirm('This will delete the product from the database entirely.  Are you sure you want to continue?');
    if(confirm_delete === true){
        axios.post('../backend/delete_product.php', {upc}).then(resp=>{
            $('#form_response').empty().append('<div id="response_message">'+resp.data+'</div>');
        });
        $('#upc').val('').focus();
    }
}

/**
 * Fills the inputs on the add/update product feature if the upc entered is found in the database,
 * otherwise loads blank form for adding product.
 */
function fillUpdateInputs(){
    const checkUpc = /^[0-9]{12}$/;

    const upc = $('#product_upc').val();
    if(checkUpc.test(upc)) {
        $('.error_message').remove();
        axios.post('../backend/retrieve_product_for_display.php', {upc}).then(resp => {
            if (resp.data) {
                displayProductFromInput();
                $('#upc_container').css('display', 'none');
                $('#form_container').css('display', 'block');
                $('#product_name').val(resp.data[0]['name']);
                $('#product_images').val(resp.data[0]['front_img_location']);
                $('#product_side_image').val(resp.data[0]['side_img_location']);
                $('#product_back_image').val(resp.data[0]['back_img_location']);
                $('#product_thumbnail_image').val(resp.data[0]['thumbnail_location']);
                $('#parent_upc').val(resp.data[0]['parent_item']);
                $('#product_dev_model').val(resp.data[0]['device_model']);
                $('#product_color').val(resp.data[0]['color']);
                $('#product_sku').val(resp.data[0]['sku']);
                $('#product_description').val(resp.data[0]['description']);
                $('#product_msrp').val(resp.data[0]['retail_price']);
                $('#product_tier1').val(resp.data[0]['tier1_1-50']);
                $('#product_tier2').val(resp.data[0]['tier2_51-200']);
                $('#product_tier3').val(resp.data[0]['tier3_201-349']);
                $('#product_tier4').val(resp.data[0]['tier4_350-499']);
                $('#product_tier5').val(resp.data[0]['tier5_500-999']);
                $('#product_tier6').val(resp.data[0]['tier6_1000-2999']);
                $('#product_tier7').val(resp.data[0]['tier7_3000-4999']);
                $('#product_tier8').val(resp.data[0]['tier8_5000']);
                $('#product_qty').val(resp.data[0]['quantity']);
                $('#product_tags').val(resp.data[0]['tags']);
                $('#add_product_btn input').val('Update Product');
            } else {
                $('#upc_container').css('display', 'none');
                $('#form_container').css('display', 'block');
                $('.product_display').remove();
                $('.inventory_container').css({
                    'max-width': '70vw',
                });
            }
        })
    }else{
        $('.error_message').remove();
        $('.inventory_container').append('<div class="error_message">Not a valid UPC d[^_^]b</div>');
    }
}

/**
 * Apply click handlers to buttons
 */
function apply_event_handler(){
    $('#inventory_shipped').click(ship_inventory);
    $('#inventory_received').click(receive_inventory);
    $('.item_block').click(getChildProducts).click(displayProductFromChild);
    $('#upc').blur(displayProductFromInput);
    $('#delete_product').click(delete_product);
    $('#enter_upc').click(fillUpdateInputs);
}

