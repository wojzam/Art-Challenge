const challengesContainer = document.querySelector("#challenges");
const counterContainers = document.querySelectorAll(".counter");

function calculateTimeLeft(endTime) {
    const timeLeft = endTime - new Date();
    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
    let timeLeftString = "";
    if (days > 0) {
        timeLeftString += days + "d ";
    }
    if (hours > 0) {
        timeLeftString += hours + "h ";
    }
    if (minutes > 0) {
        timeLeftString += minutes + "m ";
    }
    if (seconds > 0) {
        timeLeftString += seconds + "s ";
    }
    return timeLeftString;
}

function getEndDate(challenge) {
    const endTime = new Date(challenge.start_date);
    const start_day = endTime.getDate();
    endTime.setDate(start_day + challenge.duration);
    return endTime;
}

function updateCounter(counter, endTime, button) {
    const timeLeft = calculateTimeLeft(endTime);
    if (timeLeft === '') {
        counter.innerHTML = "Completed";
        counter.style.color = "red";
        button.classList.add("disabled");
    } else {
        counter.innerHTML = "Time left: " + timeLeft;
    }
}

function loadChallenges(challenges) {
    challenges.forEach(challenge => {
        createChallenge(challenge);
    });
}

function createChallenge(challenge) {
    const template = document.querySelector("#challenge-template");
    const clone = template.content.cloneNode(true);

    const idInput = clone.querySelector("#id_challenge");
    idInput.value = challenge.id;
    const title = clone.querySelector("h2");
    title.innerHTML = challenge.topic;
    const image = clone.querySelector("img");
    image.src = `/public/img/${challenge.image}`;
    const button = clone.querySelector(".submit-btn");
    const counter = clone.querySelector("#time-left");

    const endTime = getEndDate(challenge);
    updateCounter(counter, endTime, button);

    setInterval(function () {
        updateCounter(counter, endTime, button);
    }, 1000);

    challengesContainer.appendChild(clone);
}

fetch('/ongoingChallenges')
    .then(response => response.json())
    .then(data => {
        loadChallenges(data);
        counterContainers.forEach(element => element.style.display = "block");
    });
