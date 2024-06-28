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
