const search = document.querySelector('input[placeholder="search challenge"]');
const challengeContainer = document.querySelector(".challenges");

// search.addEventListener("keyup", function (event) {
//     if (event.key === "Enter") {
//         event.preventDefault();
//
//         const data = {search: this.value};
//
//         fetch("/search", {
//             method: "POST",
//             headers: {
//                 'Content-Type': 'application/json'
//             },
//             body: JSON.stringify(data)
//         }).then(function (response) {
//             return response.json();
//         }).then(function (challenges) {
//             challengeContainer.innerHTML = "";
//             loadChallenges(challenges)
//         });
//     }
// });

function loadChallenges(challenges) {
    challenges.forEach(challenge => {
        createChallenge(challenge);
    });
}

function createChallenge(challenge) {
    const template = document.querySelector("#challenge-template");

    console.log(challenge);

    const clone = template.content.cloneNode(true);
    const h2 = clone.querySelector(".challenge-topic");
    h2.innerHTML = challenge.topic;

    // const div = clone.querySelector("div");
    // div.id = project.id;
    // const image = clone.querySelector("img");
    // image.src = `/public/uploads/${project.image}`;
    // const title = clone.querySelector("h2");
    // title.innerHTML = project.title;
    // const description = clone.querySelector("p");
    // description.innerHTML = project.description;
    // const like = clone.querySelector(".fa-heart");
    // like.innerText = project.like;
    // const dislike = clone.querySelector(".fa-minus-square");
    // dislike.innerText = project.dislike;

    challengeContainer.appendChild(clone);
}
