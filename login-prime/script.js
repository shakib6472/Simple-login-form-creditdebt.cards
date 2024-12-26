jQuery(document).ready(function ($) { 
    console.log('Init 2.1.1');
    $('.loginprimesubmit').click(function (e) {
        e.preventDefault();
        var username = $('#username').val();
        var password = $('#password').val();
        var remember = $('#remember').val();
        console.log(username);
        console.log(password);
        if (username != '') {
            if (password != '') {
            } else {
                $('.loginprme-error').html('Please enter password!').show();
            }
        } else {
            $('.loginprme-error').html('Please enter username!').show();
        }

 
 
        $.ajax({
        type: 'POST',
        url: login_prime_ajax_object.ajax_url, // WordPress AJAX URL provided via wp_localize_script
        data: {
        action: 'login_prime_login', // Action hook to handle the AJAX request in your functions.php
        username: username,
        password: password,
        remember: remember
        },
        dataType: 'json',
        success: function(response) {
            if(response.success){
                $('.loginprme-success').html('Login Successfull').show();
                $('.loginprme-error').hide();
                window.location.href = response.redirect;
            } else {
                $('.loginprme-error').html(response.data).show();
                $('.loginprme-success').hide();
             }
        },
        error: function(xhr, textStatus, errorThrown) { 
        $('.loginprme-error').html('Error:'+ errorThrown).show();
        $('.loginprme-success').hide();
        }
        });
    });
});