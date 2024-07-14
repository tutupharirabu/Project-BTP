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

        // Ambil nilai input sebelum mereset form
        const roomName = document.getElementById('nama_ruangan').value;
        console.log('Room name before reset:', roomName); // Debug: Check the room name value before form reset

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
        console.log('Room name in showSuccessModal:', roomName); // Debug: Check the room name value

        // Update the modal message
        const modalMessage = document.getElementById('modalMessage');
        modalMessage.textContent = 'Ruangan ' + roomName + ' telah ditambahkan';
        console.log('Modal message:', modalMessage.textContent); // Debug: Check the modal message content

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
        window.location.href = '/statusRuanganAdmin';
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
