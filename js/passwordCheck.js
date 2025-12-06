function validatePassword() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;
    var errorDiv = document.getElementById("passwordError");

    if (password !== confirmPassword) {
        // Show error message
        errorDiv.style.display = "block";
        return false; // Stop form submission
    } else {
        // Hide error message and allow submission
        errorDiv.style.display = "none";
        return true; 
    }
}