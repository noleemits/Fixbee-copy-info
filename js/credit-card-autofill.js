document.addEventListener('DOMContentLoaded', function() {
    // Set a delay before attempting to populate the fields
    console.log("Page loaded");
    setTimeout(function() {
        const creditInfo = getCookie('credit_card_info');
        if (creditInfo) {
            const parsedCreditInfo = JSON.parse(creditInfo);
            console.log('Credit Card Information (Checkout Page):', parsedCreditInfo);

            // Now, populate the fields
            const cardNumberField = document.querySelector('#Field-numberInput');
            const expiryField = document.querySelector('#Field-expiryInput');
            const cvcField = document.querySelector('#Field-cvcInput');

            if (cardNumberField) {
                cardNumberField.value = parsedCreditInfo.number;
            }
            if (expiryField) {
                expiryField.value = parsedCreditInfo.expiry;
            }
            if (cvcField) {
                cvcField.value = parsedCreditInfo.cvv;
            }
        } else {
            console.log('No credit card information found in cookie.');
        }
    }, 3000); // 3 seconds delay
});

// Helper function to get cookie by name
function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
