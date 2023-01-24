const deleteButtons = document.querySelectorAll('i');

deleteButtons.forEach(button => button.addEventListener('click', () => {
    const id = button.id;

    if (confirm("Delete user?")) {
        fetch(`/deleteUser/${id}`)
            .then(function () {
                window.location.reload();
            })
    }
}));