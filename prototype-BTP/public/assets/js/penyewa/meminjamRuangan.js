function filterRuanganOptions(preserveSelection = false) {
    const ruanganSelect = document.getElementById('id_ruangan');
    if (!ruanganSelect || typeof ruanganSelect.getElementsByTagName !== 'function') {
        // Bisa di-comment/hapus log jika tidak perlu
        // console.debug('filterRuanganOptions: #id_ruangan select not found, skip filtering');
        return;
    }

    const lokasiInput = document.getElementById('lokasi');
    const hargaInput = document.getElementById('harga_ruangan');
    const jumlahPesertaInput = document.getElementById('peserta');
    const options = ruanganSelect.getElementsByTagName('option');

    // Aktifkan select ruangan jika sebelumnya disabled
    ruanganSelect.disabled = false;

    // Reset input
    if (!preserveSelection) {
        ruanganSelect.value = "";
        lokasiInput.value = "";
    }

    hargaInput.value = "";
    jumlahPesertaInput.value = "";

    // Tampilkan semua ruangan
    for (let i = 0; i < options.length; i++) {
        options[i].style.display = 'block';
    }

    // console.log("Semua ruangan tersedia untuk semua role.");
}

document.addEventListener('DOMContentLoaded', function () {
    handleRoleChange();
});

function checkNomorInduk() {
    const confirmNomorInduk = document.getElementById('confirm_nomor_induk').textContent;
    const nomorIndukDiv = document.getElementById('nomorIndukDisplayDiv');

    if (confirmNomorInduk === '0') {
        nomorIndukDiv.style.display = 'none';
    } else {
        nomorIndukDiv.style.display = 'block';
    }
}

// Example of usage, update this as needed in your project
document.getElementById('confirm_nomor_induk').textContent = '0'; // Example: set the value to 0
checkNomorInduk(); // Check and hide/show the div accordingly

