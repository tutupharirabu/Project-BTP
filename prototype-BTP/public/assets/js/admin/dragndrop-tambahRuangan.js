document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    // Handle click to select files
    dropZoneElement.addEventListener("click", (e) => {
        inputElement.click();
    });

    // Handle file selection from dialog
    inputElement.addEventListener("change", (e) => {
        if (inputElement.files.length) {
            processFile(inputElement.files[0], dropZoneElement, inputElement);
        }
    });

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZoneElement.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight drop zone when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZoneElement.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZoneElement.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        dropZoneElement.classList.add('drop-zone--over');
    }

    function unhighlight() {
        dropZoneElement.classList.remove('drop-zone--over');
    }

    // Handle dropped files
    dropZoneElement.addEventListener('drop', (e) => {
        if (e.dataTransfer.files.length) {
            // Create a new DataTransfer object
            const dataTransfer = new DataTransfer();
            // Add the file to it
            dataTransfer.items.add(e.dataTransfer.files[0]);
            // Set the input's files to this DataTransfer's files
            inputElement.files = dataTransfer.files;

            processFile(e.dataTransfer.files[0], dropZoneElement, inputElement);
        }
    });
});

// Process and validate the file
function processFile(file, dropZoneElement, inputElement) {
    console.log("File type:", file.type); // Cek tipe file
    // Check file type
    if (!["image/jpeg", "image/png"].includes(file.type)) {
        alert("File harus berupa gambar PNG atau JPG.");
        inputElement.value = "";
        return;
    }

    // Check file size
    console.log("File size detected:", file.size, "bytes");
    console.log("Maximum allowed:", 2 * 1024 * 1024, "bytes");
    if (file.size > 2 * 1024 * 1024) { // 5MB
        alert("Ukuran file tidak boleh lebih dari 2MB.");
        inputElement.value = "";
        return;
    }

    // Check dimensions
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
        const img = new Image();
        img.src = reader.result;
        img.onload = () => {
            if (img.width < 600 || img.height < 300) {
                alert("Dimensi gambar harus minimal 600 x 300 piksel.");
                inputElement.value = "";
            } else {
                updateThumbnail(dropZoneElement, file);
            }
        };
    };
}

// Update the thumbnail for the drop zone
function updateThumbnail(dropZoneElement, file) {
    // Remove any existing thumbnail
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");
    if (thumbnailElement) {
        thumbnailElement.remove();
    }

    // Remove label text and icon
    const labelElement = dropZoneElement.querySelector(".drop-zone__label");
    const iconElement = dropZoneElement.querySelector(".material-symbols-outlined");

    if (labelElement) {
        dropZoneElement.removeChild(labelElement);
    }

    if (iconElement) {
        dropZoneElement.removeChild(iconElement);
    }

    // Create new thumbnail
    thumbnailElement = document.createElement("div");
    thumbnailElement.classList.add("drop-zone__thumb");
    thumbnailElement.dataset.label = file.name;
    dropZoneElement.appendChild(thumbnailElement);

    // Show thumbnail for image files
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
        thumbnailElement.style.backgroundImage = `url('${reader.result}')`;

        // Add a remove button
        const removeBtn = document.createElement("button");
        removeBtn.innerHTML = "×";
        removeBtn.className = "drop-zone__remove";
        removeBtn.addEventListener("click", (e) => {
            e.stopPropagation(); // Prevent triggering dropZone click
            resetDropZone(dropZoneElement, file);
        });
        thumbnailElement.appendChild(removeBtn);
    };
}

// Reset drop zone to empty state
function resetDropZone(dropZoneElement, file) {
    // Remove thumbnail
    const thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");
    if (thumbnailElement) {
        thumbnailElement.remove();
    }

    // Reset the input
    const inputElement = dropZoneElement.querySelector(".drop-zone__input");
    if (inputElement) {
        inputElement.value = "";
    }

    // Add back the label and icon
    const isMainImage = dropZoneElement.querySelector(".drop-zone__input").id === "gambar-utama";

    const icon = document.createElement("span");
    icon.className = "material-symbols-outlined";
    icon.style.fontSize = isMainImage ? "48px" : "36px";
    icon.style.color = isMainImage ? "#717171" : "";
    icon.textContent = "add_circle";

    const label = document.createElement("span");
    label.className = "drop-zone__label";
    label.classList.add(isMainImage ? "fw-bold" : "fw-normal");
    if (isMainImage) {
        label.style.color = "#717171";
    }

    const originalId = dropZoneElement.querySelector(".drop-zone__input").id;

    if (originalId === "gambar-utama") {
        label.textContent = "Gambar Utama";
    } else if (originalId === "gambar_2") {
        label.textContent = "Gambar 2";
    } else if (originalId === "gambar_3") {
        label.textContent = "Gambar 3";
    } else if (originalId === "gambar_4") {
        label.textContent = "Gambar 4";
    } else if (originalId === "gambar_5") {
        label.textContent = "Gambar 5";
    }

    dropZoneElement.appendChild(icon);
    dropZoneElement.appendChild(label);
}
