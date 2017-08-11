/**
 * Created by seanm on 7/26/2017.
 */
$(document).ready(function(){
    applyClickHandler();
});

function user_login(){
    var username = $('#username').val();
    var password = $('#password').val();
    axios.post('login_user.php',{username, password}).then(resp=>{
        if(resp.data.authorized === true){
            document.location.href = '../dashboard/index.php';
        }else{
            $('.error_message').empty();
            var error = $('<div>',{
                'class': 'error_text',
                'text': 'username / password invalid'
            });

            $('.error_message').append(error);
        }
    })
}

function applyClickHandler(){
    $('#login_submit').click(user_login);
    $('#password').keydown(function(e){
        if(e.which === 13){
            user_login();
        }
    })
}