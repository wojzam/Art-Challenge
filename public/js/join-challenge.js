const challengesContainer = document.querySelector("#challenges");

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

    challengesContainer.appendChild(clone);
}

fetch('/ongoingChallenges')
    .then(response => response.json())
    .then(data => {
        loadChallenges(data);
    });
