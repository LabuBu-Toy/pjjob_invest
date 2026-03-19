<?php
/**
 * Plugin Name: Sample Shortcode Plugin
 * Description: A simple plugin to demonstrate WordPress shortcodes.
 * Version: 1.0
 * Author: Your Name
 */

// Function to handle the shortcode
function sample_shortcode_function() {
    return '<p>Hello, this is a sample shortcode!</p>';
}

// Register the shortcode
add_shortcode('sample_shortcode', 'sample_shortcode_function');
?>
