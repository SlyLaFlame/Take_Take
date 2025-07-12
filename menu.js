

// Get the toggle password button element
var togglePassword = document.querySelector("#togglePassword");

// Get the password confirmation input element
var passwordConfirmationInput = document.querySelector("#password_confirmation");

// Toggle the password visibility when the button is clicked
togglePassword.addEventListener("click", function () {
  if (passwordConfirmationInput.type === "password") {
    passwordConfirmationInput.type = "text";
    togglePassword.classList.remove("bi-eye");
    togglePassword.classList.add("bi-eye-slash");
  } else {
    passwordConfirmationInput.type = "password";
    togglePassword.classList.remove("bi-eye-slash");
    togglePassword.classList.add("bi-eye");
  }
});

