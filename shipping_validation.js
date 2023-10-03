function validateForm() {
    var email = document.getElementById('email').value;
    var mobile = document.getElementById('mobile').value;

    // Email validation using a regular expression
    var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!email.match(emailRegex)) {
        alert('Please enter a valid email address');
        return false;
    }

    var mobileRegex = /^(\+\d*)$/;
    if (!mobile.match(mobileRegex)) {
        alert('Please include your country code in the mobile number');
        return false;
    }

    return true;
}