(function() {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                } else {
                    showConfirmationModal(event);
                }

                form.classList.add('was-validated')
            }, false)
        })
})()

// function adjustParticipantLimits() {
//     var select = document.getElementById("id_ruangan");
//     var pesertaInput = document.getElementById("peserta");

//     var selectedOption = select.options[select.selectedIndex];
//     var min = selectedOption.getAttribute("data-min");
//     var max = selectedOption.getAttribute("data-max");

//     pesertaInput.max = max;
//     pesertaInput.min = min;
//     pesertaInput.value = min; // Set the value to min to automatically fill the input

//     // Display validation message based on room capacity
//     var feedback = pesertaInput.nextElementSibling;
//     feedback.textContent = "Masukkan Jumlah Peserta antara " + min + " dan " + max + "!";

//     // Initial check for submit button state
//     validateParticipantInput();
// }

// function validateParticipantInput() {
//     var pesertaInput = document.getElementById("peserta");
//     var submitBtn = document.getElementById("submitBtn");
//     var min = parseInt(pesertaInput.min);
//     var max = parseInt(pesertaInput.max);
//     var value = parseInt(pesertaInput.value);

//     if (value >= min && value <= max && value >= 0) {
//         submitBtn.disabled = false;
//     } else {
//         pesertaInput.value = 1; // Reset value to 1 if out of bounds
//         submitBtn.disabled = true;
//     }
// }

// document.getElementById('id_ruangan').addEventListener('change', adjustParticipantLimits);
// document.getElementById('peserta').addEventListener('input', validateParticipantInput);

function generateInvoice() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const randomNumber = String(Math.floor(Math.random() * 1000)).padStart(3, '0');
    const invoiceNumber = `BTP${year}${month}${day}${hours}${minutes}${seconds}${randomNumber}`;

    document.getElementById('invoice').value = invoiceNumber;
}

document.addEventListener('DOMContentLoaded', (event) => {
    generateInvoice();
});

function generateInvoiceNumber() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const randomNumber = String(Math.floor(Math.random() * 1000)).padStart(3, '0'); // Random 3-digit number

    return `BTP${year}${month}${day}${hours}${minutes}${seconds}${randomNumber}`;
}

function convertToDisplayFormat(dateStr) {
    const parts = dateStr.split('-');
    if (parts.length === 3) {
        return `${parts[2]}-${parts[1]}-${parts[0]}`;
    } else {
        console.error("Invalid date format:", dateStr);
        return dateStr;
    }
}

function toggleConfirmButton() {
    var confirmButton = document.getElementById('confirm_button');
    var checkbox = document.getElementById('confirm_agreement');
    confirmButton.disabled = !checkbox.checked;
}

document.getElementById('confirm_agreement').addEventListener('change', toggleConfirmButton);

function showConfirmationPopup() {
    const checkbox = document.getElementById('confirm_agreement');

    if (!checkbox.checked) {
        alert('Anda harus menyetujui syarat & ketentuan sebelum melanjutkan.');
        return;
    }

    $('#confirmationModal').modal('hide'); // Hide the confirmation modal
    $('#confirmationPopupModal').modal({
        backdrop: 'static',
        keyboard: false
    }).modal('show'); // Show the confirmation popup modal
}

function confirmSubmission() {
    const rentalForm = document.getElementById('rentalForm');
    const formData = new FormData(rentalForm);

    // Temporarily disable form validation
    rentalForm.classList.remove('needs-validation');

    fetch(rentalForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            }
        })
        .then(response => {
            if (response.ok) {
                rentalForm.reset();
                $('#confirmationPopupModal').modal('hide');
                $('#whatsappModal').modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show'); // Show the WhatsApp modal
            } else {
                console.error('Form submission error:', response);
            }
        })
        .catch(error => console.error('Error submitting form:', error))
        .finally(() => {
            // Re-enable form validation
            rentalForm.classList.add('needs-validation');
        });
}

document.getElementById('whatsappButton').addEventListener('click', function() {
    setTimeout(function() {
        window.location.href = "/dashboardPenyewa";
    }, 1000); // Adjust the timeout as needed
});

// Redirect to dashboardPenyewa when the WhatsApp modal is closed
document.querySelector('.whatsapp-close-button').addEventListener('click', function() {
    window.location.href = "/dashboardPenyewa";
});

document.getElementById('nomor_induk').addEventListener('input', function(e) {
    // Remove non-digit characters
    e.target.value = e.target.value.replace(/\D/g, '');
});

document.getElementById('nomor_telepon').addEventListener('input', function(e) {
    // Remove non-digit characters
    e.target.value = e.target.value.replace(/\D/g, '');
});
