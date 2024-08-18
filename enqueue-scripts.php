<?php
// Include the billing info functions
require_once get_stylesheet_directory() . '/custom-booking-logic/inc/billing-info-functions.php';

function custom_booking_logic_enqueue_scripts() {
    // Enqueue the JavaScript for provider selection
    wp_enqueue_script(
        'provider-selection',
        get_stylesheet_directory_uri() . '/custom-booking-logic/js/provider-selection.js',
        array('jquery'),
        null,
        true
    );

}

add_action('wp_enqueue_scripts', 'custom_booking_logic_enqueue_scripts');
