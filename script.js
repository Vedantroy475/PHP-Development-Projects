// JavaScript code for client-side validation

// Function to validate email format
function validateEmail(email) {
    const re = /\S+@\S+\.\S+/;
    return re.test(email);
}

// Function to validate registration form
function validateRegistrationForm() {
    const username = document.getElementsByName('username')[0].value;
    const email = document.getElementsByName('email')[0].value;
    const password = document.getElementsByName('password')[0].value;

    // Validate username (can be customized as needed)
    if (username.length < 3) {
        alert("Username must be at least 3 characters long");
        return false;
    }

    // Validate email format
    if (!validateEmail(email)) {
        alert("Invalid email format");
        return false;
    }

    // Validate password (can be customized as needed)
    if (password.length < 6) {
        alert("Password must be at least 6 characters long");
        return false;
    }

    // If all validations pass, return true
    return true;
}

// Function to validate login form
function validateLoginForm() {
    const email = document.getElementsByName('email')[1].value;
    const password = document.getElementsByName('password')[1].value;

    // Validate email format
    if (!validateEmail(email)) {
        alert("Invalid email format");
        return false;
    }

    // Validate password (can be customized as needed)
    if (password.length < 6) {
        alert("Password must be at least 6 characters long");
        return false;
    }

    // If all validations pass, return true
    return true;
}
