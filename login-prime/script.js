jQuery(document).ready(function ($) {
    console.log('Init 2.2.1');
    $('.loginprimesubmit').click(function (e) {

        e.preventDefault();
        $(this).text('Please wait...');
        var username = $('#username').val();
        var password = $('#password').val();
        var remember = $('#remember').val();
        console.log(username);
        console.log(password);
        if (username != '') {
            if (password != '') {
            } else {
                $('.loginprme-error').html('Please enter password!').show();
                $(this).text('Sign in');
            }
        } else {
            $('.loginprme-error').html('Please enter username!').show();
            $(this).text('Sign in');

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
            success: function (response) {
                if (response.success) {
                    $('.loginprme-success').html('Login Successfull').show();
                    $('.loginprme-error').hide();
                    $(this).text('Redirecting...');
                    window.location.href = response.redirect;
                } else {
                    $('.loginprme-error').html(response.data).show();
                    $('.loginprme-success').hide();
                    $(this).text('Sign in');
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                $('.loginprme-error').html('Error:' + errorThrown).show();
                $('.loginprme-success').hide();
                $(this).text('Sign in');
            }
        });
    });

    $('.lp-registration-submit').click(function (e) {
        e.preventDefault();
        $(this).text('Please wait...');
        var firstname = $('#first_name').val();
        var lastname = $('#last_name').val();
        var residential_address = $('#residential_address').val();
        var primary_mailing_address = $('#primary_mailing_address').val();
        var profileimage = $('#profile_image')[0].files[0]; // Access the file input
        var mobile = $('#mobile').val();
        var home_phone = $('#home_phone').val();
        var email = $('#email').val();
        var additional_email = $('#additional_email').val();
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();

        console.log(firstname);
        console.log(lastname);
        console.log(residential_address);
        console.log(primary_mailing_address);
        console.log(profileimage ? profileimage.name : 'No file selected');
        console.log(mobile);
        console.log(home_phone);
        console.log(email);
        console.log(password);
        console.log(confirm_password);

        if (firstname != '') {
            if (lastname != '') {
                if (residential_address != '') {
                    if (primary_mailing_address != '') {
                        if (mobile != '') {
                            if (home_phone != '') {
                                if (email != '') {
                                    if (password != '') {
                                        if (confirm_password != '') {
                                            if (password == confirm_password) {
                                                if (profileimage) { // Check if file exists

                                                    var formData = new FormData();
                                                    formData.append('action', 'login_prime_register');
                                                    formData.append('firstname', firstname);
                                                    formData.append('lastname', lastname);
                                                    formData.append('residential_address', residential_address);
                                                    formData.append('primary_mailing_address', primary_mailing_address);
                                                    formData.append('profileimage', profileimage);
                                                    formData.append('mobile', mobile);
                                                    formData.append('home_phone', home_phone);
                                                    formData.append('email', email);
                                                    formData.append('password', password);
                                                    formData.append('confirm_password', confirm_password);
                                                    formData.append('additional_email', additional_email);

                                                    $.ajax({
                                                        type: 'POST',
                                                        url: login_prime_ajax_object.ajax_url, // WordPress AJAX URL provided via wp_localize_script
                                                        data: formData,
                                                        dataType: 'json',
                                                        contentType: false,
                                                        processData: false,
                                                        success: function (response) {
                                                            if (response.success) {
                                                                $('.loginprme-success').html('Registration Successfull').show();
                                                                $('.loginprme-error').hide();
                                                                $(this).text('Redirecting...');
                                                                // window.location.href = response.redirect;
                                                            } else {
                                                                $(this).text('Register');
                                                                $('.loginprme-error').html(response.data).show();
                                                                $('.loginprme-success').hide();
                                                            }
                                                        },
                                                        error: function (xhr, textStatus, errorThrown) {
                                                            $(this).text('Register');
                                                            $('.loginprme-error').html('Error:' + errorThrown).show();
                                                            $('.loginprme-success').hide();
                                                        }
                                                    });

                                                } else {
                                                    $('.loginprme-error').html('Please upload profile image!').show();
                                                    $(this).text('Register');
                                                }
                                            } else {
                                                $('.loginprme-error').html('Password does not match!').show();
                                                $(this).text('Register');
                                            }
                                        } else {
                                            $('.loginprme-error').html('Please enter confirm password!').show();
                                            $(this).text('Register');
                                        }
                                    } else {
                                        $('.loginprme-error').html('Please enter password!').show();
                                        $(this).text('Register');
                                    }
                                } else {
                                    $('.loginprme-error').html('Please enter email!').show();
                                    $(this).text('Register');
                                }
                            } else {
                                $('.loginprme-error').html('Please enter home phone!').show();
                                $(this).text('Register');
                            }
                        } else {
                            $('.loginprme-error').html('Please enter mobile!').show();
                            $(this).text('Register');
                        }
                    } else {
                        $('.loginprme-error').html('Please enter primary mailing address!').show();
                        $(this).text('Register');
                    }
                } else {
                    $('.loginprme-error').html('Please enter residential address!').show();
                    $(this).text('Register');
                }
            } else {
                $('.loginprme-error').html('Please enter last name!').show();
                $(this).text('Register');
            }
        } else {
            $('.loginprme-error').html('Please enter first name!').show();
            $(this).text('Register');
        }
    });

    $(".btn_save_profile").on("click", function () {
        $(this).text('Please wait...');
        // Get all the values
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var raddress = $("#raddress").val();
        var pmaddress = $("#pmaddress").val();
        var mobile = $("#mobile").val();
        var work = $("#work").val();
        var email = $("#email").val();
        var amail = $("#amail").val();
        var profile_image = $('#profile_image')[0].files[0];
        console.log(profile_image ? profile_image.name : 'No file selected');


        var form_data = new FormData();
        form_data.append('action', 'login_prime_save_profile');
        form_data.append('first_name', first_name);
        form_data.append('last_name', last_name);
        form_data.append('raddress', raddress);
        form_data.append('pmaddress', pmaddress);
        form_data.append('mobile', mobile);
        form_data.append('work', work);
        form_data.append('email', email);
        form_data.append('amail', amail);
        form_data.append('profile_image', profile_image);
        $.ajax({
            type: 'POST',
            url: login_prime_ajax_object.ajax_url, // WordPress AJAX URL provided via wp_localize_script
            data: form_data,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) { 
                console.log(response);
                if (response.success) {
                    $(".loginprme-success").text("Profile Saved").show();
                } else {
                    $(".loginprme-error").text(
                        "Error Saving Profile: " + response.data
                    ).show();
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                $(this).text('Register');
                $('.loginprme-error').html('Error:' + errorThrown).show();
                $('.loginprme-success').hide(); 
            }
        });
    });

    $(".img-avatar img, .img-avatar i").on("click", function () {
        $("#profile_image").click();
    });
    // After selectiog the image show the preview
    $("#profile_image").on("change", function () {
        var file = this.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".img-avatar img").attr("src", e.target.result);
        };
        reader.readAsDataURL(file);
    });

});