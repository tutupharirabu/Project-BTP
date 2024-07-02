document.addEventListener('DOMContentLoaded', function () {
    let deleteButtons = document.querySelectorAll('.delete-btn');
    let confirmDeleteButton = document.getElementById('confirmDelete');
    let deleteUrl = '';

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            deleteUrl = 'daftarRuanganAdmin/' + this.getAttribute('data-id');
            showConfirmationModal();
        });
    });

    confirmDeleteButton.addEventListener('click', function () {
        window.location.href = deleteUrl;
    });
});

function showConfirmationModal() {
    const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    modal.show();
}

function closeConfirmationModal() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
    modal.hide();
}