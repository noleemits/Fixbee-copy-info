// custom-booking-logic/js/credit-card-autofill.js

document.addEventListener('DOMContentLoaded', function() {
    const button = document.querySelector('.fill-credit-info');
    if (button) {
        button.addEventListener('click', function() {
            alert('Button clicked');
            setTimeout(function() {
                const creditInfo = getCookie('credit_card_info');
                if (creditInfo) {
                    const parsedCreditInfo = JSON.parse(creditInfo);
                    console.log('Autofilling Credit Card Information:', parsedCreditInfo);
                    console.log('Attempting to autofill credit card information...');
                    console.log('Credit Card Number:', parsedCreditInfo.number);
                    console.log('Expiration Date:', parsedCreditInfo.expiry);
                    console.log('CVV:', parsedCreditInfo.cvv);


                    // Fill in the fields
                    document.querySelector('#Field-numberInput').value = parsedCreditInfo.number;
                    document.querySelector('#Field-expiryInput').value = parsedCreditInfo.expiry;
                    document.querySelector('#Field-cvcInput').value = parsedCreditInfo.cvv;
                } else {
                    console.log('No credit card information found in cookie.');
                }
            }, 3000); // 3-second delay to ensure fields are loaded
        });
    }

    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
});
