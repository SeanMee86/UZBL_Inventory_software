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
    axios_call(upc, qty);
}

/**
 * Add items to inventory based on user inputs
 */
function receive_inventory(){
    let upc = $('#upc').val();
    let qty = -($('#qty').val());
    axios_call(upc, qty);
}

/**
 * Send the information to the server
 * @param upc
 * @param qty
 */
function axios_call(upc, qty){
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
 * Apply click handlers to buttons
 */
function apply_click_handler(){
    $('#inventory_shipped').click(ship_inventory);
    $('#inventory_received').click(receive_inventory);
}

