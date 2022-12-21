<?php
/*
Plugin Name: Watermark Solution
Plugin URI: https://adrianpottinger.com
Description: Allows users to upload an image to use as a watermark on other images throughout the site.
Version: 1.0
Author: Adrian Pottinger
Author URI: https://adrianpottinger.com
License: GPLv2 or later
Text Domain: wp-watermark-solution
*/

function watermark_plugin_settings_page() {
    add_options_page(
        'Watermark Plugin Settings', // Page Title
        'Watermark Plugin', // Menu Title
        'manage_options', // Capability
        'watermark-plugin', // Menu Slug
        'watermark_plugin_display_settings_page' // Callback function
    );
}
add_action('admin_menu', 'watermark_plugin_settings_page');

function watermark_plugin_display_settings_page() {
    // Check user capability
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            // Output security fields
            settings_fields('watermark_plugin_options');
            // Output setting sections
            do_settings_sections('watermark-plugin');
            // Output submit button
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

function watermark_plugin_settings_init() {
    // Register a new setting for "watermark_plugin" page
    register_setting('watermark_plugin_options', 'watermark_plugin_options', 'watermark_plugin_options_validate');
 
    // Register a new section in the "watermark_plugin" page
    add_settings_section(
        'watermark_plugin_section_developers',
        'Watermark Settings',
        'watermark_plugin_section_developers_cb',
        'watermark-plugin'
    );
 
    // Register a new field in the "watermark_plugin_section_developers" section, inside the "watermark_plugin" page
    add_settings_field(
        'watermark_image', // Field ID
        'Watermark Image', // Field Title 
        'watermark_image_cb', // Callback function
        'watermark-plugin', // Menu Slug
        'watermark_plugin_section_developers' // Section ID
    );
}
add_action('admin_init', 'watermark_plugin_settings_init');

// callback functions

function watermark_plugin_section_developers_cb() {
    // Leave this section blank
}

function watermark_image_cb() {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option('watermark_plugin_options');
    // Output the field
    ?>
    <input type="text" name="watermark_plugin_options[watermark_image]" value
