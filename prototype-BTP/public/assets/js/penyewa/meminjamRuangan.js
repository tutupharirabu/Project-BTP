// function filterRuanganOptions() {
//     const role = document.getElementById('role').value;
//     const ruanganSelect = document.getElementById('id_ruangan');
//     const lokasiInput = document.getElementById('lokasi');
//     const hargaInput = document.getElementById('harga_ruangan');
//     const jumlahPesertaInput = document.getElementById('peserta');
//     const options = ruanganSelect.getElementsByTagName('option');

//     // Aktifkan select ruangan jika disabled
//     ruanganSelect.disabled = false;

//     // Reset pilihan ruangan sebelumnya
//     ruanganSelect.value = "";
//     lokasiInput.value = "";
//     hargaInput.value = "";
//     jumlahPesertaInput.value ="";

//     for (let i = 0; i < options.length; i++) {
//         const option = options[i];
//         const ruanganType = option.getAttribute('data-type');

//         if (option.value === "") {
//             option.style.display = 'block';
//             continue;
//         }

//         if (role === 'Mahasiswa' || role === 'Umum') {
//             // Cek apakah ruanganType adalah 'Multimedia' atau 'R Training'
//             if (ruanganType === 'Coworking Space (B103)' || ruanganType === 'R Training (B204)') {
//                 option.style.display = 'block';  // Tampilkan ruangan yang sesuai
//             } else {
//                 option.style.display = 'none';   // Sembunyikan ruangan yang tidak sesuai
//             }
//         } else {
//             option.style.display = 'block';  // Tampilkan semua untuk role lain
//         }
//     }
// }

function filterRuanganOptions(preserveSelection = false) {
    const ruanganSelect = document.getElementById('id_ruangan');
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

    console.log("Semua ruangan tersedia untuk semua role.");
}

document.addEventListener('DOMContentLoaded', function () {
    // Initialize state
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

