@extends('admin.layouts.mainAdmin')

@section('containAdmin')
    <style>
        /* #drop-area {
                                border: 2px dashed #ccc;
                                border-radius: 20px;
                                width: 100%;
                                height: 200px;
                                text-align: center;
                                padding: 85px;
                                color: #333;
                                margin-top: 20px;
                                margin-bottom: 20px;
                                font-size: 1vw;
                            }

                            #drop-area.highlight {
                                border-color: purple;
                            } */

        /* batas */

        .drop-zone {
            width: 95%;
            height: 200px;
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-family: Arial, sans-serif;
            font-weight: 500;
            font-size: 20px;
            cursor: pointer;
            color: #cccccc;
            border: 4px dashed #eeeeee;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .drop-zone--over {
            border-style: solid;
        }

        .drop-zone__input {
            display: none;
        }

        .drop-zone__thumb {
            width: 100%;
            height: 100%;
            border-radius: 10px;
            overflow: hidden;
            background-color: #cccccc;
            background-size: cover;
            position: relative;
        }

        .drop-zone__thumb::after {
            content: attr(data-label);
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 5px 0;
            color: #ffffff;
            background: rgba(0, 0, 0, 0.75);
            font-size: 10px;
            text-align: center;
        }
    </style>

    <div class="container-fluid mt-4">
        <!-- title -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="container mx-2">
                    <h4>Edit Ruangan<h4>
                </div>
            </div>
        </div>

        <!-- href ui -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="d-flex container my-2 mx-2">
                    <a href="/statusRuanganAdmin" class="fw-bolder" style="color: #797979; font-size:12px; ">Daftar Ruangan
                        ></a>
                    <a href="" class="fw-bolder" style="color: red; font-size:12px;">&nbsp;Edit Ruangan </a>
                </div>
            </div>
        </div>

        <!-- value -->
        <div class="row justify-content-center mt-4">
            <div class="col-11">
                <div class="card border shadow shadow-md">
                    <div class="card-body">
                        <form action="{{ route('update.ruangan', $dataRuangan->id_ruangan) }}" method="POST"
                            enctype="multipart/form-data" id="my-form">
                            @csrf
                            @method('PUT')
                            <!-- left from text field -->
                            <div class="row">
                                <div class="col-7">
                                    <div class="form-group row">
                                        <div class="form-group row mb-2 ">
                                            <label for="id_ruangan" class="col-md-3 col-form-label text-md-left-right">ID
                                                Ruangan</label>
                                            <div class="col-md-7">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <input type="text" id="id_ruangan" class="form-control" name="id_ruangan"
                                                    style="" disabled value="{{ $dataRuangan->id_ruangan }}">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label for="nama_ruangan" class="col-md-3 col-form-label text-md-right">Nama
                                                Ruangan</label>
                                            <div class="col-md-7">
                                                <input type="text" id="nama_ruangan" class="form-control"
                                                    name="nama_ruangan" value="{{ $dataRuangan->nama_ruangan }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label for="kapasitas_ruangan"
                                                class="col-md-3 col-form-label text-md-right">Kapasitas</label>
                                            <div class="col-md-7">
                                                <input type="number" id="kapasitas_ruangan" class="form-control"
                                                    name="kapasitas_ruangan" value="{{ $dataRuangan->kapasitas_ruangan }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label for="lokasi"
                                                class="col-md-3 col-form-label text-md-right">Lokasi</label>
                                            <div class="col-md-7">
                                                <input type="text" id="lokasi" class="form-control" name="lokasi"
                                                    value="{{ $dataRuangan->lokasi }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label for="harga_ruangan"
                                                class="col-md-3 col-form-label text-md-right">Harga</label>
                                            <div class="col-md-7">
                                                <input type="text" id="harga_ruangan" class="form-control"
                                                    name="harga_ruangan" value="{{ $dataRuangan->harga_ruangan }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label for="status"
                                                class="col-md-3 col-form-label text-md-right">Status</label>
                                            <div class="col-md-7">
                                                <select id="status" class="form-control" name="status">
                                                    <option value="{{ $dataRuangan->status }}">{{ $dataRuangan->status }}
                                                    </option>
                                                    <option value="Available">Available</option>
                                                    <option value="Booked">Booked</option>
                                                </select>
                                                <input type="number" id="tersedia" class="form-control" name="tersedia"
                                                    value="{{ $dataRuangan->tersedia }}" required hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- right form file -->

                                <div class="col-5">
                                    <div class="form-group row mb-2">
                                        <label for="url" class="col-md-4 col-form-label text-md-right">Gambar
                                            Ruangan</label>
                                    </div>

                                    <div class="drop-zone">
                                        <span class="drop-zone__prompt">Drop file here or click to upload</span>
                                        <input type="file" for="url" id="url" name="url[]"
                                            class="drop-zone__input" multiple>
                                    </div>

                                    <strong>Uploaded Files</strong>
                                    <p class="uploadedRooms"></p>

                                    <!-- Menggunakan class col-auto agar kolom menyesuaikan dengan ukuran kontennya -->
                                    <button type="submit" class="btn btn-primary" style="background-color: #0C9300">
                                        Update
                                    </button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

    <script>
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
    </script>
@endsection
