const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const passwordInput = form.querySelector('input[name="password"]');
const passwordRepeatedInput = form.querySelector('input[name="passwordRepeated"]');

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function arePasswordsSame(password, passwordRepeated) {
    return password === passwordRepeated;
}

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
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
            const condition = arePasswordsSame(
                passwordInput.value,
                passwordRepeatedInput.value
            );
            markValidation(passwordRepeatedInput, condition);
        },
        1000
    );
}

emailInput.addEventListener('keyup', validateEmail);
passwordRepeatedInput.addEventListener('keyup', validatePassword);