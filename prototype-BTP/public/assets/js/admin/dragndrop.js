document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

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
            const file = e.dataTransfer.files[0];

            // Check file type
            if (!["image/jpeg", "image/png"].includes(file.type)) {
                alert("File harus berupa gambar PNG atau JPG.");
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
                    } else {
                        inputElement.files = e.dataTransfer.files;
                        updateThumbnail(dropZoneElement, file);
                    }
                };
            };
        }

        dropZoneElement.classList.remove("drop-zone--over");
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
}
