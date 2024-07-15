document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll(".drop-zone").forEach((dropZoneElement) => {
        const inputElement = dropZoneElement.querySelector(".drop-zone__input");

        dropZoneElement.addEventListener("click", (e) => {
            inputElement.click();
        });

        inputElement.addEventListener("change", (e) => {
            if (inputElement.files.length) {
                const file = inputElement.files[0];

                // Check file type
                if (!["image/jpeg", "image/png"].includes(file.type)) {
                    alert("File harus berupa gambar PNG atau JPG.");
                    inputElement.value = "";
                    return;
                }

                // Check file dimensions
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
        });
    });

    function updateThumbnail(dropZoneElement, file) {
        let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

        // Hapus teks prompt jika ada file
        const promptElement = dropZoneElement.querySelector(".drop-zone__prompt");
        if (promptElement) {
            promptElement.remove();
        }

        // Buat elemen thumbnail jika belum ada
        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("drop-zone__thumb");
            dropZoneElement.appendChild(thumbnailElement);
        }

        thumbnailElement.dataset.label = file.name;

        // Tampilkan thumbnail untuk file gambar
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
        };
    }
});
