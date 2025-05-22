document.addEventListener('DOMContentLoaded', function () {
    const hargaInput = document.getElementById('harga_ruangan');

    // Ensure initial value has "Rp. "
    if (!hargaInput.value.startsWith('Rp. ')) {
        hargaInput.value = 'Rp. ' + hargaInput.value;
    }

    hargaInput.addEventListener('input', function (e) {
        let value = this.value.replace(/[^0-9]/g, '');

        if (value === '') {
            value = '0';
        } else if (value.startsWith('0') && value.length > 1) {
            value = value.substring(1);
        }

        this.value = 'Rp. ' + value;
    });

    hargaInput.addEventListener('focus', function (e) {
        // Ensure cursor is always after "Rp. " on focus
        if (e.target.selectionStart < 4) {
            e.target.setSelectionRange(4, 4);
        }

        // If the current value is 'Rp. 0', clear it
        if (this.value === 'Rp. 0') {
            this.value = 'Rp. ';
            e.target.setSelectionRange(4, 4);
        }
    });

    hargaInput.addEventListener('blur', function (e) {
        // If the input is empty when it loses focus, set it to 'Rp. 0'
        if (this.value === 'Rp. ') {
            this.value = 'Rp. 0';
        }
    });

    hargaInput.addEventListener('keydown', function (e) {
        // Prevent backspace and delete from removing "Rp. "
        if ((e.key === 'Backspace' || e.key === 'Delete') && e.target.selectionStart <= 4) {
            e.preventDefault();
        }
    });

    hargaInput.addEventListener('click', function (e) {
        // Ensure cursor does not move before "Rp. "
        if (e.target.selectionStart < 4) {
            e.target.setSelectionRange(4, 4);
        }
    });
});

function removeRpPrefix() {
    const hargaInput = document.getElementById('harga_ruangan');
    hargaInput.value = hargaInput.value.replace(/^Rp\. /, '');
}

function showConfirmationModal() {
    const form = document.getElementById('edit-form');

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
    removeRpPrefix(); // Ensure prefix is removed before submission
    const form = document.getElementById('edit-form');
    const formData = new FormData(form);
    const roomName = document.getElementById('nama_ruangan').value;
    // console.log('Room name before reset:', roomName); // Debug: Check the room name value before form reset

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            closeConfirmationModal();
            form.reset();
            form.classList.remove('was-validated');
            showSuccessModal(roomName); // Pass the roomName to showSuccessModal
        } else {
            console.error('Form submission failed.');
        }
    })
    .catch(error => console.error('Form submission error:', error));
}

function showSuccessModal(roomName) {
    // console.log('Room name in showSuccessModal:', roomName); // Debug: Check the room name value

    // Update the modal message
    const modalMessage = document.getElementById('modalMessage');
    modalMessage.textContent = 'Ruangan ' + roomName + ' telah diperbarui';
    // console.log('Modal message:', modalMessage.textContent); // Debug: Check the modal message content

    // Show and position the success modal
    const modal = document.getElementById('successModal');
    modal.style.display = 'block';
    modal.style.position = 'fixed';
    modal.style.top = '50%';
    modal.style.left = '50%';
    modal.style.transform = 'translate(-50%, -50%)';
}

function closeSuccessModal() {
    document.getElementById('successModal').style.display = 'none';
    window.location.href = '/daftarRuanganAdmin';
}

document.getElementById('edit-form').addEventListener('submit', function (e) {
    e.preventDefault();
    updateTersedia(); // Ensure tersedia is set correctly before submitting
    showConfirmationModal();
});

function updateTersedia() {
    var status = document.getElementById('status').value;
    var tersedia = document.getElementById('tersedia');

    if (status === 'Tersedia') {
        tersedia.value = 1;
    } else if (status === 'Digunakan') {
        tersedia.value = 0;
    }
    // console.log('Tersedia value set to:', tersedia.value);
}

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
