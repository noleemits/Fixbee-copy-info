document.addEventListener('DOMContentLoaded', function() {
    const creditInfo = getCookie('credit_card_info');
    if (creditInfo) {
        const parsedCreditInfo = JSON.parse(creditInfo);
        console.log('Credit Card Information:', parsedCreditInfo);
    } else {
        console.log('No credit card information found in cookie.');
    }
});

// Helper function to get cookie by name
function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
