<?php 

function login_prime_login (){
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
        wp_send_json_success( array(
            'message' => 'Login successful',
            'redirect' => home_url()
        ));  
        }
    die();

}
add_action('wp_ajax_login_prime_login', 'login_prime_login');
add_action('wp_ajax_nopriv_login_prime_login', 'login_prime_login');

