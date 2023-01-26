const form = document.querySelector("form");
const usernameInput = form.querySelector('input[name="username"]');
const emailInput = form.querySelector('input[name="email"]');
const passwordInput = form.querySelector('input[name="password"]');
const passwordRepeatedInput = form.querySelector('input[name="passwordRepeated"]');
const submitButton = form.querySelector('.submit-btn');

function isUsernameValid(username) {
    return username !== '' && username.length < 64;
}

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function isPasswordStrong(password) {
    return /^(?=.*[a-z])(?=.*[A-Z]).{8,64}$/.test(password);
}

function arePasswordsSame(password, passwordRepeated) {
    return password === passwordRepeated;
}

function isFormValid() {
    return isUsernameValid(usernameInput.value) &&
        isEmail(emailInput.value) &&
        isPasswordStrong(passwordInput.value) &&
        arePasswordsSame(passwordInput.value, passwordRepeatedInput.value);
}

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

function validateUsername() {
    setTimeout(function () {
            markValidation(usernameInput, isUsernameValid(usernameInput.value));
        },
        1000
    );
}

function validateEmail() {
    setTimeout(function () {
            markValidation(emailInput, isEmail(emailInput.value));
        },
        1000
    );
}

function validatePassword() {
    setTimeout(function () {
            markValidation(passwordInput, isPasswordStrong(passwordInput.value));
        },
        1000
    );
}

function validatePasswordRepeated() {
    setTimeout(function () {
            markValidation(
                passwordRepeatedInput,
                arePasswordsSame(passwordInput.value, passwordRepeatedInput.value)
            );
        },
        1000
    );
}

function validateForm() {
    isFormValid() ? submitButton.classList.remove("disabled") : submitButton.classList.add("disabled");
}

validateForm();

usernameInput.addEventListener('keyup', validateUsername);
emailInput.addEventListener('keyup', validateEmail);
passwordInput.addEventListener('keyup', validatePassword);
passwordRepeatedInput.addEventListener('keyup', validatePasswordRepeated);

usernameInput.addEventListener('keyup', validateForm);
emailInput.addEventListener('keyup', validateForm);
passwordInput.addEventListener('keyup', validateForm);
passwordRepeatedInput.addEventListener('keyup', validateForm);