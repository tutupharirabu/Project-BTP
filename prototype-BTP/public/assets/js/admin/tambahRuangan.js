document.getElementById('harga_ruangan').addEventListener('input', function (e) {

    let value = this.value.replace(/[^0-9]/g, '');

    if (value === '') {
        value = '0';
    } else if (value.startsWith('0') && value.length > 1) {
        value = value.substring(1);
    }

    this.value = value;
});

document.getElementById('harga_ruangan').addEventListener('focus', function (e) {
    // If the current value is '0', clear it
    if (this.value === '0') {
        this.value = '';
    }
});

document.getElementById('harga_ruangan').addEventListener('blur', function (e) {
    // If the input is empty when it loses focus, set it to '0'
    if (this.value === '') {
        this.value = '0';
    }
});

function showConfirmationModal() {
    const form = document.getElementById('add-form');

    // Periksa validitas form sebelum menampilkan modal konfirmasi
    if (form.checkValidity() === false) {
        form.classList.add('was-validated');
        return;
    }

    toggleConfirmationLoading(false);

    const modal = document.getElementById('confirmationModal');
    modal.style.display = 'block';
    modal.style.position = 'fixed';
    modal.style.top = '50%';
    modal.style.left = '50%';
    modal.style.transform = 'translate(-50%, -50%)';
}

function closeConfirmationModal() {
    toggleConfirmationLoading(false);
    document.getElementById('confirmationModal').style.display = 'none';
}

function submitForm() {
    const form = document.getElementById('add-form');
    const formData = new FormData(form);
    const roomName = formData.get('nama_ruangan');

    // Normalisasi angka harga agar hanya mengirim digit
    if (formData.has('harga_ruangan')) {
        formData.set('harga_ruangan', (formData.get('harga_ruangan') || '').toString().replace(/[^0-9]/g, ''));
    }

    toggleConfirmationLoading(true);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Form submission failed.');
            }
            return response;
        })
        .then(() => {
            closeConfirmationModal();
            form.reset();
            form.classList.remove('was-validated');
            showSuccessModal(roomName);
        })
        .catch(error => {
            console.error('Form submission error:', error);
            alert('Gagal menambahkan ruangan. Silakan coba lagi.');
        })
        .finally(() => {
            toggleConfirmationLoading(false);
        });
}

function showSuccessModal(roomName) {
    // console.log('Room name in showSuccessModal:', roomName); // Debug: Check the room name value

    // Update the modal message
    const modalMessage = document.getElementById('modalMessage');
    modalMessage.textContent = 'Ruangan ' + roomName + ' telah ditambahkan';
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

function toggleConfirmationLoading(isLoading) {
    const spinner = document.getElementById('confirmationSpinner');
    const buttons = document.getElementById('confirmationButtons');

    if (!spinner || !buttons) {
        return;
    }

    if (isLoading) {
        spinner.classList.remove('d-none');
        buttons.classList.add('d-none');
    } else {
        spinner.classList.add('d-none');
        buttons.classList.remove('d-none');
    }
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
