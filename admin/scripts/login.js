// Define the formvalid function
function formvalid() {
    var validpass = document.getElementById("pass").value;
    var validPassMessage = document.getElementById("valid-pass");
    var lowerCaseLetters = /[a-z]/g;
    var upperCaseLetters = /[A-Z]/g;
    var numbers = /[0-9]/g;
    var specialCharacters = /[@#$%&!?]/g;

    // Check if the password meets the criteria
    if (validpass.length < 8 || validpass.length > 20) {
        validPassMessage.innerHTML = "Password must be between 8 and 20 characters";
        return false;
    } else if (!validpass.match(lowerCaseLetters)) {
        validPassMessage.innerHTML = "Password must contain at least one lowercase letter";
        return false;
    } else if (!validpass.match(upperCaseLetters)) {
        validPassMessage.innerHTML = "Password must contain at least one uppercase letter";
        return false;
    } else if (!validpass.match(numbers)) {
        validPassMessage.innerHTML = "Password must contain at least one number";
        return false;
    } else if (!validpass.match(specialCharacters)) {
        validPassMessage.innerHTML = "Password must contain at least one special character (@, #, $, %, &, !, ?)";
        return false;
    } else {
        validPassMessage.innerHTML = "";
        return true; 
    }
}


document.querySelector(".login-form").addEventListener("submit", function(event) {
    if (!formvalid()) {
        event.preventDefault(); 
    }
});

const togglePasswordIcons = document.querySelectorAll(".password-toggle-icon");
togglePasswordIcons.forEach(icon => {
    icon.addEventListener("click", function () {
        const inputField = this.previousElementSibling;
        if (inputField.type === "password") {
            inputField.type = "text";
            this.classList.remove("fa-eye-slash");
            this.classList.add("fa-eye");
        } else {
            inputField.type = "password";
            this.classList.remove("fa-eye");
            this.classList.add("fa-eye-slash");
        }
    });
});
