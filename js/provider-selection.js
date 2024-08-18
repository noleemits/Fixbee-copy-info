document.addEventListener('DOMContentLoaded', function() {
    const providerSelect = document.querySelector('select[name="provider_id"]');
    if (providerSelect) {
        providerSelect.addEventListener('change', function() {
            const provider_id = this.value;
            const ajaxurl = '/wp-admin/admin-ajax.php';

            jQuery.post(
                ajaxurl, 
                {
                    'action': 'populate_and_store_user_credit_info',
                    'provider_id': provider_id
                },
                function(response) {
                    console.log('Server Response:', response);
                }
            );
        });
    }
});
