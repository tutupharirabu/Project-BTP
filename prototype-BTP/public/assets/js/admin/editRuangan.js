
function showConfirmationModal() {
    const form = document.getElementById('edit-form');

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
    const form = document.getElementById('edit-form');
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            closeConfirmationModal();
            form.reset();
            form.classList.remove('was-validated');
            showSuccessModal();
        } else {
            console.error('Form submission failed.');
        }
    })
    .catch(error => console.error('Form submission error:', error));
}

function showSuccessModal() {
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

document.getElementById('edit-form').addEventListener('submit', function (e) {
    e.preventDefault();
    showConfirmationModal();
});

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

document.getElementById("status").addEventListener("change", function() {
    var status = this.value;
    var tersediaInput = document.getElementById("tersedia");

    if (status === "Available") {
        tersediaInput.value = 0;
    } else if (status === "Booked") {
        tersediaInput.value = 1;
    } else {
        tersediaInput.value = "";
    }
});

document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", (e) => {
        inputElement.click();
    });

    inputElement.addEventListener("change", (e) => {
        if (inputElement.files.length) {
            updateThumbnail(dropZoneElement, inputElement.files[0]);
        }
    });

    dropZoneElement.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone--over");
    });

    ["dragleave", "dragend"].forEach((type) => {
        dropZoneElement.addEventListener(type, (e) => {
            dropZoneElement.classList.remove("drop-zone--over");
        });
    });

    dropZoneElement.addEventListener("drop", (e) => {
        e.preventDefault();

        if (e.dataTransfer.files.length) {
            inputElement.files = e.dataTransfer.files;
            updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
        }

        dropZoneElement.classList.remove("drop-zone--over");
    });
});

function updateThumbnail(dropZoneElement, file) {
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");
    const uploadedRoomsElement = document.querySelector(".uploadedRooms");

    console.log(file);
    // First time - remove the prompt
    if (dropZoneElement.querySelector(".drop-zone__prompt")) {
        dropZoneElement.querySelector(".drop-zone__prompt").remove();
    }

    // First time - there is no thumbnail element, so lets create it
    if (!thumbnailElement) {
        thumbnailElement = document.createElement("div");
        thumbnailElement.classList.add("drop-zone__thumb");
        dropZoneElement.appendChild(thumbnailElement);
    }

    thumbnailElement.dataset.label = file.name;

    // Show thumbnail for image files
    if (file.type.startsWith("image/")) {
        const reader = new FileReader();

        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
        };
    } else {
        thumbnailElement.style.backgroundImage = null;
    }

    // Update the uploaded file names in a new line
    uploadedRoomsElement.innerHTML += file.name + "<br>";
}