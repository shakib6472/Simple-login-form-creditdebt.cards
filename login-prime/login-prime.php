<?php
/*
 * Plugin Name:      Login Prime
* Plugin URI:        https://github.com/shakib6472/
* Description:       A simple plugin to customize the WordPress login feature.
* Version:           1.0.0
* Requires at least: 5.2
* Requires PHP:      7.2
* Author:            Shakib Shown
* Author URI:        https://github.com/shakib6472/
* License:           GPL v2 or later
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain:       core-helper
* Domain Path:       /languages
*/
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
// Define the plugin path
define('LOGIN_PRIME_PLUGIN_PATH', plugin_dir_path(__FILE__));
// Define the plugin URL
define('LOGIN_PRIME_PLUGIN_URL', plugin_dir_url(__FILE__));
require_once(LOGIN_PRIME_PLUGIN_PATH . 'ajax.php');

// Enqueue the plugin styles
function login_prime_styles() {
    wp_enqueue_style('login-prime-styles', LOGIN_PRIME_PLUGIN_URL . 'style.css');
    wp_enqueue_script('jquery');
    wp_enqueue_script('login-prime-scripts', LOGIN_PRIME_PLUGIN_URL . 'script.js', array('jquery'), '1.0', true);
    wp_enqueue_script('login-prime-scripts-font-owesome',  'https://kit.fontawesome.com/46882cce5e.js', array(), '1.0', true);
    wp_localize_script('login-prime-scripts', 'login_prime_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'login_prime_styles'); // Enqueue the styles


// Add a shortcode to display the login form
function login_prime_login_form_shortcode()
{
    ob_start();
?>

    <div class="login-form-container">
      <form class="login-form"   method="post">
        <div class="lp-form-group">
          <label for="username"> Username</label>
          <div class="lp-boreder-box">
            <span class="icon"><i class="fas fa-user"></i></span>
            <input
              type="text"
              id="username"
              name="username"
              placeholder="Username"
            />
          </div>
          <label for="rememberme" class="remember-me-label">
            <input type="checkbox" id="rememberme" name="remember-me" />
            Remember me
            <span class="tooltip"><i class="fas fa-info"></i></span>
          </label>
        </div>
        <div class="lp-form-group">
          <label for="password"> Password</label>
          <div class="lp-boreder-box">
            <span class="icon">🔒</span>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Password"
            />
          </div>
          <a href="<?php echo home_url('reset-password'); ?>" class="forgot-link">Forgot username or password?</a>
        </div>
        <div class="button-form-group"> 
          <button type="button" class="loginprimesubmit submit-btn">Sign in</button>
          <a href="<?php echo home_url('register'); ?>" class="register-link">Don't have any account? Register</a>
        </div>
      </form>
      <div class="loginprme-error"></div>
      <div class="loginprme-success"></div>
    </div>


<?php
    return ob_get_clean();
}
add_shortcode('login_prime_login_form', 'login_prime_login_form_shortcode');
