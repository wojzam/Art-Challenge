const loginSignup = document.querySelector('#login-signup');
const hamburgerMenu = document.querySelector('.hamburger-menu');
const userContent = document.querySelectorAll('#user-content');
const adminContent = document.querySelectorAll('#admin-content');
const usernameField = document.querySelector('#username');

function getLoggedInUsername() {
    return fetch('/user')
        .then(response => response.json())
        .then(data => {
            return data;
        })
        .catch(() => {
            return {loggedIn: false, username: '', role: ''};
        });
}

function applyStyles(user) {
    if (window.innerWidth <= 1000) {
        userContent.forEach(element => element.style.display = "none");
        loginSignup.style.display = "none";
        hamburgerMenu.style.display = "block";
    } else {
        if (user.loggedIn) {
            userContent.forEach(element => element.style.display = "block");
            loginSignup.style.display = "none";
            usernameField.innerHTML = user.username;
        } else {
            userContent.forEach(element => element.style.display = "none");
            loginSignup.style.display = "flex";
        }
        hamburgerMenu.style.display = "none";
    }
    if (user.role === 'admin') {
        adminContent.forEach(element => element.style.display = "block");
    } else {
        adminContent.forEach(element => element.style.display = "none");
    }
}

function openMenu() {
    alert("menu");
}

getLoggedInUsername().then((user) => {
    applyStyles(user);

    window.addEventListener("resize", function () {
        applyStyles(user);
    });
});

hamburgerMenu.addEventListener('click', openMenu);
