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

    // Enqueue the JavaScript for logging credit info
    wp_enqueue_script(
        'log-credit-info',
        get_stylesheet_directory_uri() . '/custom-booking-logic/js/log-credit-info.js',
        array('jquery'),
        null,
        true
    );

    // Conditionally enqueue the credit card autofill script on the checkout page
    if (is_checkout()) {
        wp_enqueue_script(
            'credit-card-autofill',
            get_stylesheet_directory_uri() . '/custom-booking-logic/js/credit-card-autofill.js',
            array('jquery'),
            null,
            true
        );
    }
}

add_action('wp_enqueue_scripts', 'custom_booking_logic_enqueue_scripts');
