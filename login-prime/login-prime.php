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
function login_prime_styles()
{
  wp_enqueue_style('login-prime-styles', LOGIN_PRIME_PLUGIN_URL . 'style.css');
  wp_enqueue_style('login-prime-styles-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
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
    <form class="login-form" method="post">
      <div class="lp-form-group">
        <label for="username"> Username</label>
        <div class="lp-boreder-box">
          <span class="icon"><i class="fas fa-user"></i></span>
          <input
            type="text"
            id="username"
            name="username"
            placeholder="Username" />
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
            placeholder="Password" />
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
// Now for registration form
function login_prime_registration_form_shortcode()
{
  ob_start();
?>
  <div class="loginprime-form-container">
    <form action="" method="post" enctype="multipart/form-data" class="loginprime-form">
      <div class="form-grid">


        <!-- Full Name -->
        <div class="name-fields">
          <label for="first_name">First Name</label>
          <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
        </div>
        <div class="name-fields">
          <label for="last_name">Last Name</label>
          <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
        </div>

        <!-- Residential Address -->
        <div>
          <label for="residential_address">Residential Address</label>
          <textarea id="residential_address" name="residential_address" rows="2" placeholder="Enter your residential address" required></textarea>
        </div>

        <!-- Primary Mailing Address -->
        <div>
          <label for="primary_mailing_address">Primary Mailing Address</label>
          <textarea id="primary_mailing_address" name="primary_mailing_address" rows="2" placeholder="Enter your primary mailing address" required></textarea>
        </div>
        <!-- Profile Image -->
        <div class="">
          <label for="profile_image">Profile Image</label>
          <input type="file" id="profile_image" name="profile_image" accept="image/*">
        </div>
        <div class="">
          <div class="image-preview-wrapper">
            <img id="image_preview" src="" alt="Image Preview" style="display: none; max-width: 100px; max-height: 100px; border: 1px solid #ddd; margin-bottom: 10px;" />
          </div>
        </div>

        <!-- Mobile Phone -->
        <div>
          <label for="mobile">Mobile</label>
          <input type="text" id="mobile" name="mobile" placeholder="Mobile Number" required>
        </div>

        <!-- Home Phone -->
        <div>
          <label for="home_phone">Home Phone</label>
          <input type="text" id="home_phone" name="home_phone" placeholder="Home Phone Number">
        </div>



        <!-- Email -->
        <div>
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>

        <!-- Additional Email -->
        <div>
          <label for="additional_email">Additional Email</label>
          <input type="email" id="additional_email" name="additional_email" placeholder="Enter additional email (optional)">
        </div>

        <!-- Password -->
        <div>
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>

        <!-- Confirm Password -->
        <div>
          <label for="confirm_password">Confirm Password</label>
          <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
        </div>
      </div>
      <div class="loginprme-error"></div>
      <div class="loginprme-success"></div>
      <!-- Submit Button -->
      <div class="form-submit">
        <button type="button" class="lp-registration-submit submit-btn">Register</button>
      </div>
    </form>
  </div>
  <script>
    document.getElementById('profile_image').addEventListener('change', function(event) {
      const file = event.target.files[0];
      const preview = document.getElementById('image_preview');

      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
          preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
      } else {
        preview.src = '';
        preview.style.display = 'none';
      }
    });
  </script>
<?php
  return ob_get_clean();
}
add_shortcode('login_prime_registration_form', 'login_prime_registration_form_shortcode');



function login_prime_user_profile_page()
{
  if (!is_user_logged_in()) {
    return '<p>You must be logged in to view this page.</p>';
  }
  $current_user = wp_get_current_user();
  $user_id = $current_user->ID;
  $first_name = get_user_meta($user_id, 'first_name', true);
  $last_name = get_user_meta($user_id, 'last_name', true);
  $residential_address = get_user_meta($user_id, 'residential_address', true);
  $primary_mailing_address = get_user_meta($user_id, 'primary_mailing_address', true);
  $mobile = get_user_meta($user_id, 'mobile', true);
  $home_phone = get_user_meta($user_id, 'home_phone', true);
  $email = $current_user->user_email;
  $additional_email = get_user_meta($user_id, 'additional_email', true);
  $profile_image = get_user_meta($user_id, 'profile_image', true);
  ob_start();
?>
  <div class="container">
    <div class="heading">
      <h3>Profile</h3>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="img text-center">
          <div class="img-avatar">
            <img
              src="<?php echo $profile_image; ?>"
              alt=""
              height="150px"
              width="150px" />
            <!-- edit icon -->
            <i class="fa-solid fa-pen-to-square"></i>
            <input
              type="file"
              name="profile_image"
              id="profile_image"
              class="d-none" />
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="name">
        <div class="col-md-12">
          <label class="mb-2" for="name">Name</label>
          <div class="d-flex gap-4">

            <div class="col-md-6">
              <div class="form-group mb-3">
                <input
                  type="text"
                  class="form-control"
                  id="first_name"
                  placeholder="Enter your first name" value="<?php echo $first_name; ?>" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <input
                  type="text"
                  class="form-control"
                  id="last_name"
                  placeholder="Enter your last name" value="<?php echo $last_name; ?>" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="heading">
        <h4>Address</h4>
      </div>
      <div class="form-group mb-3">
        <label class="mb-2" for="">Residential Address</label>
        <textarea
          type="text"
          class="form-control"
          id="raddress"
          placeholder="Enter your Residential Address">
          <?php echo $residential_address; ?>
        </textarea>
      </div>
      <div class="form-group mb-3">
        <label class="mb-2" for="pmaddress">Primary Mailing Address</label>
        <textarea
          type="text"
          class="form-control"
          id="pmaddress"
          placeholder="Enter your Primary Mailing Address">
          <?php echo $primary_mailing_address; ?>
        </textarea>
      </div>
    </div>
    <div class="row">
      <div class="heading">
        <h4>Phone</h4>
      </div>
      <div class="form-group mb-3">
        <label class="mb-2" for="mobile">Mobile</label>
        <input
          type="text"
          class="form-control"
          id="mobile"
          placeholder="Enter your Mobile Number" value="<?php echo $mobile; ?>" />
      </div>
      <div class="form-group mb-3">
        <label class="mb-2" for="work">Work Mobile</label>
        <input
          type="text"
          class="form-control"
          id="work"
          placeholder="Enter your Work Mobile Number" value="<?php echo $home_phone; ?>" />
      </div>
    </div>
    <div class="row">
      <div class="heading">
        <h4>Personal Email</h4>
      </div>
      <div class="form-group mb-3">
        <label class="mb-2" for="email">Email</label>
        <input
          type="email"
          class="form-control"
          id="email"
          placeholder="Enter your Email Address" value="<?php echo $email; ?>" />
      </div>
      <div class="form-group mb-3">
        <label class="mb-2" for="amail">Additional Mail</label>
        <input
          type="text"
          class="form-control"
          id="amail"
          placeholder="Enter your Additionbal Email Address" value="<?php echo $additional_email; ?>" />
      </div>
    </div>
    <!-- Save button -->
    <div class="row">
      <div class="loginprme-error mb-3"></div>
      <div class="loginprme-success mb-3"></div>

      <div class="col-md-12 text-center">
        <button class="btn btn_save_profile btn-primary w-100">Save</button>
      </div>
    </div>
  </div>
<?php

  return ob_get_clean();
}

add_shortcode('login_prime_user_profile', 'login_prime_user_profile_page');
