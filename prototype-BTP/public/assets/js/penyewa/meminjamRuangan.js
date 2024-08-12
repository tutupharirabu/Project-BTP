
function handleRoleChange() {
    const role = document.getElementById('role').value;
    const ruanganSelect = document.getElementById('id_ruangan');
    const nomorIndukDiv = document.getElementById('nomorIndukDiv');
    const nomorIndukInput = document.getElementById('nomor_induk');

    // Enable ruangan select if a valid role is selected
    if (role) {
        ruanganSelect.removeAttribute('disabled');
    } else {
        ruanganSelect.setAttribute('disabled', true);
    }

    // Display or hide nomorIndukDiv based on the selected role
    if (role === 'Pegawai' || role === 'Mahasiswa') {
        nomorIndukDiv.style.display = 'block';
        nomorIndukInput.value = ''; // Clear the input value
        nomorIndukInput.required = true; // Make the input required
    } else {
        nomorIndukDiv.style.display = 'none';
        nomorIndukInput.value = '0'; // Set the default value to 0
        nomorIndukInput.required = false; // Make the input not required
    }

    // Call additional functions like filterRuanganOptions()
    filterRuanganOptions();
}


function filterRuanganOptions() {
    const role = document.getElementById('role').value;
    const ruanganSelect = document.getElementById('id_ruangan');
    const options = ruanganSelect.getElementsByTagName('option');

    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        const ruanganType = option.getAttribute('data-type');

        if (option.value === "") {
            option.style.display = 'block';
            continue;
        }

        if (role === 'Mahasiswa' || role === 'Umum') {
            // Cek apakah ruanganType adalah 'Multimedia' atau 'R Training'
            if (ruanganType === 'Multimedia (A)' || ruanganType === 'R Training (B204)') {
                option.style.display = 'block';  // Tampilkan ruangan yang sesuai
            } else {
                option.style.display = 'none';   // Sembunyikan ruangan yang tidak sesuai
            }
        } else {
            option.style.display = 'block';  // Tampilkan semua untuk role lain
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
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

