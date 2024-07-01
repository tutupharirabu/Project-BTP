
function showConfirmationModal() {
    const form = document.getElementById('add-form');

    // Periksa validitas form sebelum menampilkan modal konfirmasi
    if (form.checkValidity() === false) {
        form.classList.add('was-validated');
        return;
    }

    const modal = document.getElementById('confirmationModal');
    modal.style.display = 'block';
    modal.style.position = 'fixed';
    modal.style.top = '50%';
    modal.style.left = '50%';
    modal.style.transform = 'translate(-50%, -50%)';
}

function closeConfirmationModal() {
    document.getElementById('confirmationModal').style.display = 'none';
}

function submitForm() {
    const form = document.getElementById('add-form');
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            closeConfirmationModal();
            form.reset();
            form.classList.remove('was-validated');
            showSuccessModal();
        } else {
            console.error('Form submission failed.');
        }
    })
    .catch(error => console.error('Form submission error:', error));
}

function showSuccessModal() {
    const modal = document.getElementById('successModal');
    modal.style.display = 'block';
    modal.style.position = 'fixed';
    modal.style.top = '50%';
    modal.style.left = '50%';
    modal.style.transform = 'translate(-50%, -50%)';
}

function closeSuccessModal() {
    document.getElementById('successModal').style.display = 'none';
    window.location.href = '/statusRuanganAdmin';
}

document.getElementById('add-form').addEventListener('submit', function (e) {
    e.preventDefault();
    showConfirmationModal();
});

// Bootstrap form validation
(function () {
    'use strict';
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();