const voteButtons = document.querySelectorAll('.vote-btn');

voteButtons.forEach(button => button.addEventListener('click', (event) => {
    event.stopPropagation();
    alert("vote");
}));