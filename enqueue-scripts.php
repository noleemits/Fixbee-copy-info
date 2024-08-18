<?php

function enqueue_credit_card_autofill_script() {
    if (is_checkout()) {
        wp_enqueue_script('credit-card-autofill', get_stylesheet_directory_uri() . '/custom-booking-logic/js/credit-card-autofill.js', array('jquery'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_credit_card_autofill_script');
