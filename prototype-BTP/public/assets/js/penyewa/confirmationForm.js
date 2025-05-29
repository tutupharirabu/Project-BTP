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
// Function confirmSubmission() without spinner
// function confirmSubmission() {
//     const rentalForm = document.getElementById('rentalForm');
//     const formData = new FormData(rentalForm);

//     // Temporarily disable form validation
//     rentalForm.classList.remove('needs-validation');

//     fetch(rentalForm.action, {
//             method: 'POST',
//             body: formData,
//             headers: {
//                 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
//             }
//         })
//         .then(response => {
//             if (response.ok) {
//                 rentalForm.reset();
//                 $('#confirmationPopupModal').modal('hide');
//                 $('#whatsappModal').modal({
//                     backdrop: 'static',
//                     keyboard: false
//                 }).modal('show'); // Show the WhatsApp modal
//             } else {
//                 console.error('Form submission error:', response);
//             }
//         })
//         .catch(error => console.error('Error submitting form:', error))
//         .finally(() => {
//             // Re-enable form validation
//             rentalForm.classList.add('needs-validation');
//         });
// }

// Function confirmSubmission() with spinner
// Function confirmSubmission() with spinner
function confirmSubmission(event) {
    event.preventDefault(); 

    const rentalForm = document.getElementById('rentalForm');
    const formData = new FormData(rentalForm);

    document.getElementById('confirmationButtons').classList.add('d-none');
    document.getElementById('spinner').classList.remove('d-none');

    fetch(rentalForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            }
        })
        .then(response => {
            if (!response.ok) {
                console.error('Error response from API:', response);
                alert('Terjadi kesalahan saat mengirim data');
                return Promise.reject('Failed response');
            }
            return response.json(); // Mengambil response dalam format JSON
        })
        .then(data => {
            if (data.is_sqli) {
                console.log('SQL Injection detected:', data);
                
                let confidencePercent = data.probability * 100;
                
                // Pembulatan khusus: Jika confidence sangat mendekati 100%, bulatkan ke 99.99
                // Ini akan memastikan 0.999999 tidak menjadi 100.00 jika Anda memang tidak ingin 100.00
                if (confidencePercent > 99.99 && confidencePercent < 100) {
                    confidencePercent = 99.99;
                } else {
                    confidencePercent = confidencePercent.toFixed(2); // Bulatkan ke 2 desimal
                }

                const errorMessage = `SQL Injection terdeteksi! Tingkat keyakinan: ${confidencePercent}%`;
                
                let errorElement = document.getElementById('sqliError');
                if (!errorElement) {
                    errorElement = document.createElement('div');
                    errorElement.id = 'sqliError';
                    errorElement.style.color = 'red';
                    errorElement.style.fontWeight = 'bold';
                    document.getElementById('rentalForm').appendChild(errorElement);
                }
                errorElement.textContent = errorMessage;

                const errorData = {
                    errors: {
                        sql_injection: `SQL Injection terdeteksi! Tingkat keyakinan: ${confidencePercent}%`
                    }
                };

                document.getElementById('rentalForm').classList.add('was-validated');
                document.querySelector('.alert-danger').innerHTML = `
                    <ul>
                            <li>${errorData.errors.sql_injection}</li>
                    </ul>
                `;

                const whatsappModal = bootstrap.Modal.getInstance(document.getElementById('whatsappModal'));
                if (whatsappModal) {
                    whatsappModal.hide();
                }

                window.location.href = "#"; 
            } else {
                console.log('Data successfully submitted');

                const confirmationModal = bootstrap.Modal.getInstance(document.getElementById('confirmationPopupModal'));
                if (confirmationModal) {
                    confirmationModal.hide();
                }
                setTimeout(() => {
                    const whatsappModal = new bootstrap.Modal(document.getElementById('whatsappModal'));
                    whatsappModal.show();
                }, 500);
                window.location.href = "/dashboardPenyewa";
            }
        })
        .catch(error => {
            console.error('Error submitting form:', error);
        })
        .finally(() => {
            document.getElementById('spinner').classList.add('d-none');
            document.getElementById('confirmationButtons').classList.remove('d-none');
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
