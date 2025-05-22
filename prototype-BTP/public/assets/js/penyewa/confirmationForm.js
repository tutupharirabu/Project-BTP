(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
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
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const randomNumber = String(Math.floor(Math.random() * 1000)).padStart(3, '0');
    const invoiceNumber = `BTP${year}${month}${day}${hours}${minutes}${seconds}${randomNumber}`;

    // PATCH: cek dulu elemennya ada
    const invoiceInput = document.getElementById('invoice');
    if (invoiceInput) {
        invoiceInput.value = invoiceNumber;
    } else {
        console.warn('Element with id "invoice" not found!');
    }
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

// function confirmSubmission() with spinner
function confirmSubmission(event) {
    event.preventDefault(); // Mencegah submit bawaan

    const rentalForm = document.getElementById('rentalForm');
    const formData = new FormData(rentalForm);

    // Simpan data form ke sessionStorage
    sessionStorage.setItem('formData', JSON.stringify(Object.fromEntries(formData.entries())));

    // Tampilkan spinner dan sembunyikan tombol
    document.getElementById('confirmationButtons').classList.add('d-none');
    document.getElementById('spinner').classList.remove('d-none');

    fetch(rentalForm.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        }
    })
        .then(async response => {
            if (response.ok) {
                // console.log('Data berhasil dikirim');

                // Tutup modal Confirmation
                const confirmationModal = bootstrap.Modal.getInstance(document.getElementById('confirmationPopupModal'));
                if (confirmationModal) {
                    confirmationModal.hide();
                }

                // Tampilkan modal WhatsApp
                setTimeout(() => {
                    const whatsappModal = new bootstrap.Modal(document.getElementById('whatsappModal'));
                    whatsappModal.show();
                }, 500);
            } else {
                // Cek jika error overlap dari backend
                let errMsg = 'Terjadi kesalahan. Silakan coba lagi.';
                if (response.status === 422) {
                    const data = await response.json();
                    errMsg = data.message || errMsg;
                }

                // Opsional: beri delay pendek supaya transisi lebih smooth
                setTimeout(() => {
                    showErrorModal(errMsg);
                }, 5); // bisa diatur ke 50 atau 100 jika ingin transisi benar-benar halus
            }
        })
        .catch(error => {
            console.error('Error submitting form:', error);
            alert('Terjadi kesalahan saat mengirim data.');
        })
        .finally(() => {
            // Sembunyikan spinner dan tampilkan tombol kembali
            document.getElementById('spinner').classList.add('d-none');
            document.getElementById('confirmationButtons').classList.remove('d-none');
        });
}

document.getElementById('whatsappButton').addEventListener('click', function () {
    setTimeout(function () {
        window.location.href = "/dashboardPenyewa";
    }, 1000); // Adjust the timeout as needed
});

// Redirect to dashboardPenyewa when the WhatsApp modal is closed
document.querySelector('.whatsapp-close-button').addEventListener('click', function () {
    window.location.href = "/dashboardPenyewa";
});

document.getElementById('nomor_induk').addEventListener('input', function (e) {
    // Remove non-digit characters
    e.target.value = e.target.value.replace(/\D/g, '');
});

document.getElementById('nomor_telepon').addEventListener('input', function (e) {
    // Remove non-digit characters
    e.target.value = e.target.value.replace(/\D/g, '');
});

function showErrorModal(msg) {
    // Tutup confirmation popup/modal jika masih terbuka
    var confirmationModal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
    if (confirmationModal) {
        confirmationModal.hide();
    }

    var confirmationModal1 = bootstrap.Modal.getInstance(document.getElementById('confirmationPopupModal'));
    if (confirmationModal1) {
        confirmationModal1.hide();
    }

    let errModal = document.getElementById('errorModal');
    if (!errModal) {
        // Buat modal error kalau belum ada
        const modalHtml = `
            <!-- Error Alert Modal -->
            <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="errorModalLabel">Booking Gagal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <span id="errorModalMsg"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn text-white capitalize-first-letter" data-bs-dismiss="modal"
                                style="background-color:#717171;font-size: 14px;">Batalkan</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        errModal = document.getElementById('errorModal');
    }
    document.getElementById('errorModalMsg').innerText = msg;
    var bsModal = new bootstrap.Modal(errModal);
    bsModal.show();
}
