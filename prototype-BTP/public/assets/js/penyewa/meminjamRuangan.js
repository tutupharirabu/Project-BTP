
function handleRoleChange() {
    const role = document.getElementById('role').value;
    const nomorIndukDiv = document.getElementById('nomorIndukDiv');
    const nomorIndukInput = document.getElementById('nomor_induk');
    
    if (role === 'Umum') {
        nomorIndukDiv.style.display = 'none';
        nomorIndukInput.value = '0';
        nomorIndukInput.required = false;
    } else {
        nomorIndukDiv.style.display = 'block';
        nomorIndukInput.value = '';
        nomorIndukInput.required = true;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize state
    handleRoleChange();
});