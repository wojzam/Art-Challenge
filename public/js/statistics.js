const image = document.querySelector('.overlay');
const voteButton = document.querySelector('.vote-btn');

function popupImage() {
    alert("image");
}

image.addEventListener('click', popupImage);
voteButton.addEventListener('click', (event) => {
    event.stopPropagation();
    alert("vote");
});
