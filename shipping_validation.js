function validateForm() {
    var email = document.getElementById('email').value;
    var mobile = document.getElementById('mobile').value;
    var date_of_birth = document.getElementById('dob').value;
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

    // Date of birth cannot be in the future
    var today = new Date();
    var dob = new Date(date_of_birth);
    if (dob > today) {
        alert('Date of birth cannot be in the future');
        return false;
    }

    // password and confirm password must match
    var password = document.getElementById('password').value;
    var confirm_password = document.getElementById('confirm_password').value;
    if (password != confirm_password) {
        alert('Passwords do not match');
        return false;
    }

    return true;
}