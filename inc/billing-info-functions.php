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

    if ( !$provider_email ) {
        return;
    }

    $user = get_user_by('email', $provider_email);

    if ( !$user ) {
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

    error_log('Credit card info stored in cookie for provider: ' . $provider_id);
}

// Handle the AJAX call to populate and store credit info
function ajax_populate_and_store_user_credit_info() {
    populate_and_store_user_credit_info();
    wp_die();
}

add_action('wp_ajax_populate_and_store_user_credit_info', 'ajax_populate_and_store_user_credit_info');
add_action('wp_ajax_nopriv_populate_and_store_user_credit_info', 'ajax_populate_and_store_user_credit_info');

// Attach the call hook to the JetFormBuilder form
add_action('jet-form-builder/form-handler/before-send', 'populate_and_store_user_credit_info', 10, 2);
