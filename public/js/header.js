const loginSignup = document.querySelector('#login-signup');
const hamburgerMenu = document.querySelector('.hamburger-menu');
const userContent = document.querySelectorAll('#user-content');
const usernameField = document.querySelector('#username');

function getLoggedInUsername() {
    return fetch('/username')
        .then(response => {
            let loggedIn = false;
            if (response.status === 200) {
                loggedIn = true;
            }
            return response.text().then(username => {
                return {loggedIn, username};
            });
        })
        .catch(() => {
            return {username: '', loggedIn: false};
        });
}

function applyStyles(loggedIn, username) {
    if (window.innerWidth <= 1000) {
        userContent.forEach(element => element.style.display = "none");
        loginSignup.style.display = "none";
        hamburgerMenu.style.display = "block";
    } else {
        if (loggedIn) {
            userContent.forEach(element => element.style.display = "block");
            loginSignup.style.display = "none";
            usernameField.innerHTML = username;
        } else {
            userContent.forEach(element => element.style.display = "none");
            loginSignup.style.display = "flex";
        }
        hamburgerMenu.style.display = "none";
    }
}

function openMenu() {
    alert("menu"); //TODO open menu
}

getLoggedInUsername().then(({loggedIn, username}) => {
    console.log(username, loggedIn);
    applyStyles(loggedIn, username);

    window.addEventListener("resize", function () {
        applyStyles(loggedIn, username);
    });
});

hamburgerMenu.addEventListener('click', openMenu);