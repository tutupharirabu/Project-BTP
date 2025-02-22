document.addEventListener('DOMContentLoaded', function () {
    // Simpan URL gambar asli untuk setiap dropzone saat halaman dimuat
    document.querySelectorAll(".drop-zone").forEach((dropZoneElement) => {
        const inputElement = dropZoneElement.querySelector(".drop-zone__input");
        const promptElement = dropZoneElement.querySelector(".drop-zone__prompt");
        const imgElement = promptElement ? promptElement.querySelector("img") : null;

        if (imgElement && imgElement.src) {
            // Simpan URL gambar asli sebagai data attribute pada dropzone
            dropZoneElement.dataset.originalImage = imgElement.src;
        }

        // Handle click to select files
        dropZoneElement.addEventListener("click", (e) => {
            // Hanya trigger click jika bukan click pada gambar atau elemen lain dalam thumbnail
            if (e.target.closest('.drop-zone__thumb') === null && e.target !== inputElement) {
                inputElement.click();
            }
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

        // Highlight drop zone when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZoneElement.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZoneElement.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        dropZoneElement.addEventListener('drop', (e) => {
            if (e.dataTransfer.files.length) {
                // Create a new DataTransfer object
                const dataTransfer = new DataTransfer();
                // Add the file to it
                dataTransfer.items.add(e.dataTransfer.files[0]);
                // Set the input's files to this DataTransfer's files
                inputElement.files = dataTransfer.files;

                // Process the dropped file
                processFile(e.dataTransfer.files[0], dropZoneElement, inputElement);
            }
        });
    });

    // Utility functions
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight() {
        this.classList.add('drop-zone--over');
    }

    function unhighlight() {
        this.classList.remove('drop-zone--over');
    }

    // Process and validate file
    function processFile(file, dropZoneElement, inputElement) {
        console.log("Processing file:", file.name);
        console.log("File type:", file.type);
        console.log("File size:", file.size, "bytes");

        // Check file type
        if (!["image/jpeg", "image/png", "image/jpg"].includes(file.type)) {
            alert("File harus berupa gambar PNG atau JPG.");
            inputElement.value = "";
            return;
        }

        // Check file size (5MB limit)
        if (file.size > 2 * 1024 * 1024) {
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
                console.log("Image dimensions:", img.width, "x", img.height);
                if (img.width < 600 || img.height < 300) {
                    alert("Dimensi gambar harus minimal 600 x 300 piksel.");
                    inputElement.value = "";
                } else {
                    updateThumbnail(dropZoneElement, file);
                }
            };
        };
    }

    // Update thumbnail
    function updateThumbnail(dropZoneElement, file) {
        let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

        // Remove the prompt element (which contains the text and icon)
        const promptElement = dropZoneElement.querySelector(".drop-zone__prompt");
        if (promptElement) {
            promptElement.remove();
        }

        // If there's no thumbnail element, create one
        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("drop-zone__thumb");
            dropZoneElement.appendChild(thumbnailElement);
        }

        // Set the label for the thumbnail showing filename
        thumbnailElement.dataset.label = file.name;

        // Show thumbnail preview
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbnailElement.style.backgroundImage = `url('${reader.result}')`;

            // Add a remove button if it doesn't exist
            if (!thumbnailElement.querySelector('.drop-zone__remove')) {
                const removeBtn = document.createElement("button");
                removeBtn.innerHTML = "×";
                removeBtn.className = "drop-zone__remove";
                removeBtn.addEventListener("click", (e) => {
                    e.stopPropagation(); // Prevent triggering dropZone click
                    resetDropZone(dropZoneElement);
                });
                thumbnailElement.appendChild(removeBtn);
            }
        };
    }

    // Reset drop zone to empty state
    function resetDropZone(dropZoneElement) {
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

        // Cek apakah ada gambar asli yang disimpan
        const originalImageUrl = dropZoneElement.dataset.originalImage;

        // Recreate the prompt element
        const promptDiv = document.createElement("span");
        promptDiv.className = "drop-zone__prompt";
        promptDiv.style.display = "flex";
        promptDiv.style.flexDirection = "column";
        promptDiv.style.alignItems = "center";

        // Jika ada gambar asli, tampilkan gambar tersebut
        if (originalImageUrl) {
            const imgElement = document.createElement("img");
            imgElement.src = originalImageUrl;
            imgElement.alt = "";
            imgElement.width = 150;
            imgElement.height = 100;
            promptDiv.appendChild(imgElement);

            // Jika ini adalah input yang required, hapus atribut required karena sudah ada gambar
            if (inputElement.id === "url") {
                inputElement.removeAttribute("required");
            }
        } else {
            // Tidak ada gambar asli, tampilkan ikon dan teks
            const inputId = inputElement.id;
            let promptText;
            let iconSize;

            if (inputId === "gambar_utama") {
                promptText = "Gambar Utama";
                iconSize = "48px";
                promptDiv.style.color = "#717171";
                // Tambahkan atribut required karena tidak ada gambar
                inputElement.setAttribute("required", "");
            } else {
                const match = inputId.match(/gambar_(\d+)/);
                if (match) {
                    promptText = `Gambar ${match[1]}`;
                    iconSize = "36px";
                } else {
                    promptText = "Gambar";
                    iconSize = "36px";
                }
            }

            // Create icon
            const icon = document.createElement("span");
            icon.className = "material-symbols-outlined";
            icon.style.fontSize = iconSize;
            if (inputId === "url") {
                icon.style.color = "#717171";
            }
            icon.textContent = "add_circle";

            // Create text
            const text = document.createElement("span");
            text.textContent = promptText;

            // Add icon and text to prompt
            promptDiv.appendChild(icon);
            promptDiv.appendChild(text);
        }

        // Add prompt to drop zone
        dropZoneElement.appendChild(promptDiv);
    }

    // Add form submit validation
    const form = document.querySelector("form");
    if (form) {
        form.addEventListener("submit", function (e) {
            // Pastikan form memiliki enctype yang benar
            form.setAttribute("enctype", "multipart/form-data");

            // Check if a required image is missing
            const mainInput = document.getElementById("url");
            if (mainInput && mainInput.hasAttribute('required') && (!mainInput.files || !mainInput.files.length)) {
                e.preventDefault();
                alert("Gambar utama wajib diunggah.");
                return false;
            }

            // Log all files for debugging before submission
            console.log("Submitting form with files:");
            document.querySelectorAll('input[name="url[]"]').forEach(input => {
                console.log(input.id + " contains " + (input.files ? input.files.length : 0) + " files");
            });
        });
    }
});
