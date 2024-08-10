
function handleRoleChange() {
    const role = document.getElementById('role').value;
    const nomorIndukDiv = document.getElementById('nomorIndukDiv');
    const nomorIndukInput = document.getElementById('nomor_induk');
    
    // if (role === 'Umum') {
    //     nomorIndukDiv.style.display = 'none';
    //     nomorIndukInput.value = '0';
    //     nomorIndukInput.required = false;
    // } else {
    //     nomorIndukDiv.style.display = 'block';
    //     nomorIndukInput.value = '';
    //     nomorIndukInput.required = true;
    // }
    if(role === 'Pegawai' || role === 'Mahasiswa'){
        nomorIndukDiv.style.display = 'block';
        nomorIndukInput.value = '';
        nomorIndukInput.required = true;
    }else{
        nomorIndukDiv.style.display = 'none';
        nomorIndukInput.value = '0';
        nomorIndukInput.required = false;
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

