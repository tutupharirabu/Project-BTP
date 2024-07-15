document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", (e) => {
        inputElement.click();
    });

    inputElement.addEventListener("change", (e) => {
        if (inputElement.files.length) {
            const file = inputElement.files[0];

            // Periksa tipe file
            if (!["image/jpeg", "image/png"].includes(file.type)) {
                alert("File harus berupa gambar PNG atau JPG.");
                inputElement.value = "";
                return;
            }

            // Periksa dimensi file
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

// /**
//  * Updates the thumbnail on a drop zone element.
//  *
//  * @param {HTMLElement} dropZoneElement
//  * @param {File} file
//  */
// function updateThumbnail(dropZoneElement, file) {
//     let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

//     console.log(file);
//     // First time - remove the prompt
//     if (dropZoneElement.querySelector(".drop-zone__prompt")) {
//         dropZoneElement.querySelector(".drop-zone__prompt").remove();
//     }

//     // First time - there is no thumbnail element, so lets create it
//     if (!thumbnailElement) {
//         thumbnailElement = document.createElement("div");
//         thumbnailElement.classList.add("drop-zone__thumb");
//         dropZoneElement.appendChild(thumbnailElement);
//     }

//     thumbnailElement.dataset.label = file.name;

//     // Show thumbnail for image files
//     if (file.type.startsWith("image/")) {
//         const reader = new FileReader();

//         reader.readAsDataURL(file);
//         reader.onload = () => {
//             thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
//         };
//     } else {
//         thumbnailElement.style.backgroundImage = null;
//     }
// }

/**
 * Updates the thumbnail on a drop zone element and displays the uploaded file names.
 *
 * @param {HTMLElement} dropZoneElement
 * @param {File} file
 */
function updateThumbnail(dropZoneElement, file) {
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

    // Hapus teks prompt jika ada file
    const labelElement = dropZoneElement.querySelector(".drop-zone__label");
    if (labelElement) {
        labelElement.remove();
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
