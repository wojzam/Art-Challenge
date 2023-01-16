const voteButton = document.querySelector('.vote-btn');

voteButton.addEventListener('click', (event) => {
    event.stopPropagation();
    alert("vote");
});
