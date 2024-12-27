<?php

function login_prime_login()
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = $_POST['remember'];
    $creds = array(
        'user_login' => $username,
        'user_password' => $password,
        'remember' => $remember
    );
    $user = wp_signon($creds, false);
    if (is_wp_error($user)) {
        wp_send_json_error($user->get_error_message());
    } else {
        wp_send_json_success(array(
            'message' => 'Login successful',
            'redirect' => home_url()
        ));
    }
    die();
}
add_action('wp_ajax_login_prime_login', 'login_prime_login');
add_action('wp_ajax_nopriv_login_prime_login', 'login_prime_login');


function login_prime_register()
{

    // Sanitize user inputs
    $firstname = sanitize_text_field($_POST['firstname']);
    $lastname = sanitize_text_field($_POST['lastname']);
    $residential_address = sanitize_textarea_field($_POST['residential_address']);
    $primary_mailing_address = sanitize_textarea_field($_POST['primary_mailing_address']);
    $mobile = sanitize_text_field($_POST['mobile']);
    $home_phone = !empty($_POST['home_phone']) ? sanitize_text_field($_POST['home_phone']) : '';
    $email = sanitize_email($_POST['email']);
    $password = sanitize_text_field($_POST['password']);
    $additional_email = !empty($_POST['additional_email']) ? sanitize_email($_POST['additional_email']) : '';

    // Validate email
    if (!is_email($email)) {
        wp_send_json_error('Invalid email address.');
    }

    // Check if email is already registered
    if (email_exists($email)) {
        wp_send_json_error('Email is already registered.');
    }

    // Create a new WordPress user
    $user_id = wp_create_user($email, $password, $email);

    if (is_wp_error($user_id)) {
        wp_send_json_error($user_id->get_error_message());
    }

    // Update user meta data
    update_user_meta($user_id, 'first_name', $firstname);
    update_user_meta($user_id, 'last_name', $lastname);
    update_user_meta($user_id, 'residential_address', $residential_address);
    update_user_meta($user_id, 'primary_mailing_address', $primary_mailing_address);
    update_user_meta($user_id, 'mobile', $mobile);
    if ($home_phone) {
        update_user_meta($user_id, 'home_phone', $home_phone);
    }

    if ($additional_email) {
        update_user_meta($user_id, 'additional_email', $additional_email);
    }

    // Handle file upload
    if (isset($_FILES['profileimage']) && !empty($_FILES['profileimage']['name'])) {
        require_once ABSPATH . 'wp-admin/includes/file.php';

        $uploaded = wp_handle_upload($_FILES['profileimage'], ['test_form' => false]);

        if (isset($uploaded['error'])) {
            wp_send_json_error('Profile image upload failed: ' . $uploaded['error']);
        } else {

            update_user_meta($user_id, 'profile_image', $uploaded['url']);
        }
    }

    // Send success response
    wp_send_json_success(['redirect' => home_url('/welcome')]); // Change redirect URL as needed
}

add_action('wp_ajax_login_prime_register', 'login_prime_register');
add_action('wp_ajax_nopriv_login_prime_register', 'login_prime_register');
function login_prime_save_profile()
{
    $user_id = get_current_user_id();

    // Sanitize user inputs
    //get formdata
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $residential_address = sanitize_textarea_field($_POST['raddress']);
    $primary_mailing_address = sanitize_textarea_field($_POST['pmaddress']);
    $mobile = sanitize_text_field($_POST['mobile']);
    $email = sanitize_text_field($_POST['email']);
    $home_phone = !empty($_POST['work']) ? sanitize_text_field($_POST['work']) : '';
    $additional_email = !empty($_POST['amail']) ? sanitize_email($_POST['amail']) : '';
    $profile_image = !empty($_FILES['profile_image']) ? wp_upload_bits($_FILES['profile_image']['name'], null, file_get_contents($_FILES['profile_image']['tmp_name'])) : '';
    // Update user meta amail
    update_user_meta($user_id, 'first_name', $first_name);
    update_user_meta($user_id, 'last_name', $last_name);
    update_user_meta($user_id, 'residential_address', $residential_address);
    update_user_meta($user_id, 'primary_mailing_address', $primary_mailing_address);
    update_user_meta($user_id, 'mobile', $mobile);
    if ($home_phone) {
        update_user_meta($user_id, 'home_phone', $home_phone);
    }
    if ($additional_email) {
        update_user_meta($user_id, 'additional_email', $additional_email);
    }

    // Handle file upload
    if (isset($_FILES['profile_image']) && !empty($_FILES['profile_image']['name'])) {
        require_once ABSPATH . 'wp-admin/includes/file.php';

        $uploaded = wp_handle_upload($_FILES['profile_image'], ['test_form' => false]);

        if (isset($uploaded['error'])) {
            wp_send_json_error('Profile image upload failed: ' . $uploaded['error']);
        } else {
            update_user_meta($user_id, 'profile_image', $uploaded['url']);
        }
    }

    // Send success response
    wp_send_json_success([  'message' => 'Profile updated successfully'
    ]);
}

add_action('wp_ajax_login_prime_save_profile', 'login_prime_save_profile');
add_action('wp_ajax_nopriv_login_prime_save_profile', 'login_prime_save_profile');
