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

function fetchRuanganDetails() {
    const idRuangan = document.getElementById('id_ruangan').value;
    const role = document.getElementById('role').value;
    const hargaInput = document.getElementById('harga_ruangan');
    const ppnInput = document.getElementById('harga_ppn');
    const lokasiInput = document.getElementById('lokasi');

    console.log("Selected role:", role);
    console.log("Selected ruangan ID:", idRuangan);

    function updatePrice(data) {
        if (role) {
            let hargaRuangan;
            if (role === 'Pegawai') {
                hargaRuangan = 0;
                console.log("Internal role, setting price to 0");
            } else if (role === 'Mahasiswa' || role === 'Umum') {
                hargaRuangan = parseInt(data.harga_ruangan);
                console.log("External role, setting price to:", hargaRuangan);
            }

            const formattedHargaRuangan = 'Rp ' + hargaRuangan.toLocaleString('id-ID');
            hargaInput.value = formattedHargaRuangan;
            console.log("Final formatted price:", formattedHargaRuangan);

            // Calculate PPN and total price
            const ppnRate = 0.11; // Assuming PPN is 10%
            const ppnAmount = hargaRuangan * ppnRate;
            const totalHarga = hargaRuangan + ppnAmount;
            const formattedTotalHarga = 'Rp ' + totalHarga.toLocaleString('id-ID');
            ppnInput.value = formattedTotalHarga;
            console.log("Calculated total price including PPN:", formattedTotalHarga);
        } else {
            hargaInput.value = '';
            ppnInput.value = '';
            console.log("Role not selected, price not set");
        }
    }

    if (idRuangan) {
        fetch(`/get-ruangan-details?id_ruangan=${idRuangan}`)
            .then(response => response.json())
            .then(data => {
                console.log("Fetched data:", data);
                lokasiInput.value = data.lokasi;
                updatePrice(data);
            })
            .catch(error => console.error('Error fetching ruangan details:', error));
    } else {
        lokasiInput.value = '';
        hargaInput.value = '';
        ppnInput.value = '';
        console.log("No ruangan selected, clearing inputs");
    }
}

function adjustParticipantLimits() {
    var select = document.getElementById("id_ruangan");
    var pesertaSelect = document.getElementById("peserta");

    var selectedOption = select.options[select.selectedIndex];
    var min = parseInt(selectedOption.getAttribute("data-min"));
    var max = parseInt(selectedOption.getAttribute("data-max"));

    // Clear existing options
    pesertaSelect.innerHTML = '<option selected disabled value="">Pilih jumlah peserta</option>';

    // Populate new options based on selected room's capacity
    for (var i = min; i <= max; i++) {
        var option = document.createElement("option");
        option.value = i;
        option.text = i;
        pesertaSelect.appendChild(option);
    }

    // Display validation message based on room capacity
    var feedback = pesertaSelect.nextElementSibling;
    feedback.textContent = "Masukkan Jumlah Peserta antara " + min + " dan " + max + "!";

    // Initial check for submit button state
    validateParticipantInput();
}

function validateParticipantInput() {
    var pesertaSelect = document.getElementById("peserta");
    var submitBtn = document.getElementById("submitBtn");
    var value = parseInt(pesertaSelect.value);

    if (!isNaN(value) && pesertaSelect.selectedIndex > 0) {
        submitBtn.disabled = false;
    } else {
        submitBtn.disabled = true;
    }
}

document.getElementById('id_ruangan').addEventListener('change', adjustParticipantLimits);
document.getElementById('peserta').addEventListener('change', validateParticipantInput);


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

function showConfirmationModal(event) {
    event.preventDefault();
    const invoiceNumber = document.getElementById('invoice').value;
    const namaPeminjam = document.getElementById('nama_peminjam').value;
    const nomorInduk = document.getElementById('nomor_induk').value;
    const nomorTelepon = document.getElementById('nomor_telepon').value;
    const namaRuangan = document.getElementById('id_ruangan').selectedOptions[0].text;
    const status = document.getElementById('role').value;
    const lokasi = document.getElementById('lokasi').value;
    const jumlahPeserta = document.getElementById('peserta').value;
    const tanggalMulai = document.getElementById('tanggal_mulai').value;
    const jamMulai = document.getElementById('jam_mulai').value;
    const harga = document.getElementById('harga_ruangan').value;
    const hargaPPN = document.getElementById('harga_ruangan').value;
    const keterangan = document.getElementById('keterangan').value;

    // Menentukan nilai tanggal selesai dan jam selesai berdasarkan pilihan radio button
    if (status === 'Mahasiswa' || status === 'Umum') { // Per Jam
        const durasi = document.getElementById('durasi').value;
        const durasiMenit = parseInt(durasi.split(':')[0]) * 60 + parseInt(durasi.split(':')[1]);
        const jamMulaiDate = new Date(`1970-01-01T${jamMulai}:00`);
        const jamSelesaiDate = new Date(jamMulaiDate.getTime() + durasiMenit * 60000);
        const jamSelesaiFormatted = jamSelesaiDate.toTimeString().split(' ')[0].substring(0, 5);

        document.getElementById('confirm_tanggal_selesai').innerText = convertToDisplayFormat(
            tanggalMulai); // Tanggal selesai sama dengan tanggal mulai
        document.getElementById('confirm_jam_selesai').innerText =
            jamSelesaiFormatted; // Jam selesai dihitung dari jam mulai + durasi
    } else if (status === 'Pegawai') { // Per Hari
        const jamSelesai = document.getElementById('jam_selesai').value;
        const tanggalSelesai = document.getElementById('tanggal_selesai').value;

        document.getElementById('confirm_tanggal_selesai').innerText = convertToDisplayFormat(
            tanggalSelesai); // Tanggal selesai sesuai input
        document.getElementById('confirm_jam_selesai').innerText = jamSelesai; // Jam selesai sesuai input
    }

    // Debugging logs
    console.log("Selected status:", status);
    console.log("Input Harga:", harga);

    const cleanedHarga = harga.replace(/[^\d]/g, '');
    var hargaAwal = parseFloat(cleanedHarga);
    var hargaDenganPPN = hargaAwal + (hargaAwal * 0.11);
    var priceAkhir;

    if (status === 'Mahasiswa' || status === 'Umum') {
        priceAkhir = 'Rp ' + hargaDenganPPN.toLocaleString('id-ID');
    } else {
        priceAkhir = 'Rp 0';
    }

    // console.log("Final price:", priceAkhir);

    document.getElementById('confirm_invoice').innerText = invoiceNumber;
    document.getElementById('confirm_nama_peminjam').innerText = namaPeminjam;
    document.getElementById('confirm_nama_ruangan').innerText = namaRuangan;
    document.getElementById('confirm_status').innerText = status;
    document.getElementById('confirm_nomor_induk').innerText = nomorInduk;
    document.getElementById('confirm_nomor_telepon').innerText = nomorTelepon;
    document.getElementById('confirm_lokasi').innerText = lokasi;
    document.getElementById('confirm_jumlah_peserta').innerText = jumlahPeserta;
    document.getElementById('confirm_tanggal_mulai').innerText = convertToDisplayFormat(tanggalMulai);
    document.getElementById('confirm_jam_mulai').innerText = jamMulai;
    document.getElementById('confirm_harga').innerText = 'Rp ' + hargaAwal.toLocaleString('id-ID');
    document.getElementById('confirm_harga_dengan_ppn').innerText = priceAkhir;
    document.getElementById('confirm_keterangan').innerText = keterangan;

    $('#confirmationModal').modal({
        backdrop: 'static',
        keyboard: false
    }).modal('show');
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