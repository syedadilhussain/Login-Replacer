<?php
/*
Plugin Name: Logo Replacer
Description: Replace the WordPress login page logo and admin bar logo with a custom image.
Version: 1.0
Plugin URI: https://github.com/syedadilhussain/Login-Replacer
Author: Syed Adil Hussain
Author URI: https://idealnsoft.com/
*/

// Add custom login page logo
function custom_login_logo() {
    $image_url = get_option('custom_logo_url'); // Retrieve the user-provided image URL
    echo '<style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(' . esc_url($image_url) . ');
            padding-bottom: 30px; // Adjust as needed
        }
    </style>';
}
add_action('login_enqueue_scripts', 'custom_login_logo');

// Add custom admin bar logo
function custom_admin_bar_logo($wp_admin_bar) {
//    $image_url = get_option('custom_logo_url'); // Retrieve the user-provided image URL
    $wp_admin_bar->remove_node('wp-logo'); // Remove the default WordPress logo
   $wp_admin_bar->add_node(array(
        'id'    => 'custom-logo',
//        'title' => '<img src="' . esc_url($image_url) . '" alt="Custom Logo" height="20" width="20" />',
        'href'  => home_url(),
        'meta'  => array('class' => 'custom-logo')
    ));
}
add_action('admin_bar_menu', 'custom_admin_bar_logo', 999);


// Add a custom settings section and fields
function custom_logo_settings() {
    add_settings_section('custom_logo_section', 'Custom Logo Settings', '', 'general');
    add_settings_field('custom_logo_url', 'Custom Logo URL', 'custom_logo_url_field', 'general', 'custom_logo_section');
    register_setting('general', 'custom_logo_url');
}
add_action('admin_init', 'custom_logo_settings');

// Display the input field for custom logo URL
function custom_logo_url_field() {
    $value = get_option('custom_logo_url');
    echo '<input type="text" id="custom_logo_url" name="custom_logo_url" value="' . esc_url($value) . '" class="regular-text" />';
}


?>
