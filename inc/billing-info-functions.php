<?php
// Populate and store user credit info
function populate_and_store_user_credit_info( $form_id = null, $form_fields = null ) {
    if ( $form_id && $form_fields ) {
        $provider_id = isset($form_fields['provider_id']) ? $form_fields['provider_id'] : '';
    } else {
        $provider_id = isset($_POST['provider_id']) ? intval($_POST['provider_id']) : '';
    }

    if (!$provider_id) {
        return;
    }

    setcookie('credit_card_info', '', time() - 3600, '/');

    $provider_email = get_post_meta($provider_id, 'select_user', true);

    if (!$provider_email) {
        return;
    }

    $user = get_user_by('email', $provider_email);

    if (!$user) {
        return;
    }

    $related_user_id = $user->ID;

    $creditcard_number = get_user_meta( $related_user_id, 'creditcard_number', true );
    $credit_card_expiration_date = get_user_meta( $related_user_id, 'credit_card_expiration_date', true );
    $credit_card_cvv_number = get_user_meta( $related_user_id, 'credit_card_cvv_number', true );

    $credit_info = json_encode(array(
        'number' => $creditcard_number,
        'expiry' => $credit_card_expiration_date,
        'cvv' => $credit_card_cvv_number
    ));

    setcookie('credit_card_info', $credit_info, time() + 3600, '/');
}

// Attach the call hook to the JetFormBuilder form
add_action('jet-form-builder/form-handler/before-send', 'populate_and_store_user_credit_info', 10, 2);

// Handle the AJAX call to populate and store credit info
function ajax_populate_and_store_user_credit_info() {
    populate_and_store_user_credit_info();
    wp_die();
}

add_action('wp_ajax_populate_and_store_user_credit_info', 'ajax_populate_and_store_user_credit_info');
add_action('wp_ajax_nopriv_populate_and_store_user_credit_info', 'ajax_populate_and_store_user_credit_info');

// Attach the call hook to the JetFormBuilder form
add_action('jet-form-builder/form-handler/before-send', 'populate_and_store_user_credit_info', 10, 2);

//Create shortcode for a button
function display_user_credit_info_from_cookie_shortcode() {
    // Check if the 'credit_card_info' cookie is set
    if (isset($_COOKIE['credit_card_info'])) {
        $credit_info = json_decode(stripslashes($_COOKIE['credit_card_info']), true);

        if ($credit_info) {
            // Format the display
            $output = '<div class="user-credit-info">';
            $output .= '<p><strong>Credit Card Number:</strong> ' . esc_html( $credit_info['number'] ) . '</p>';
            $output .= '<p><strong>Expiration Date:</strong> ' . esc_html( $credit_info['expiry'] ) . '</p>';
            $output .= '<p><strong>CVV:</strong> ' . esc_html( $credit_info['cvv'] ) . '</p>';
            $output .= '</div>';

            return $output;
        } else {
            return 'No valid credit card information found in the cookie.';
        }
    } else {
        return 'No credit card information found.';
    }
}
add_shortcode( 'user_credit_info', 'display_user_credit_info_from_cookie_shortcode' );
