@extends('admin.layouts.mainAdmin')

@section('containAdmin')
    <style>
        #drop-area {
            border: 2px dashed #ccc;
            border-radius: 20px;
            width: 100%;
            height: 200px;
            text-align: center;
            padding: 85px;
            /* font-family: Arial, sans-serif; */
            color: #333;
            margin-top: 20px;
            margin-bottom: 20px;
            font-size: 1vw;
            /* font-size: 1vh; */

            .image-container {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                /* Optional: adds space between the images */
                width: 150%;
                /* Make the container take the full width of its parent */
                max-width: 1000px;
                /* Set a max-width if needed, adjust as per your layout */
                margin: 0 auto;
                /* Center the container */
            }

            .image-container img {
                display: block;
                width: 80px;
                /* Ensure the width of each image remains consistent */
                height: auto;
                /* Maintain the aspect ratio of the images */
            }
        }

        #drop-area.highlight {
            border-color: purple;
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
                                        <!-- right form file -->

                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group row mb-2">
                                        <label for="url" class="col-md-4 col-form-label text-md-right">Gambar
                                            Ruangan</label>
                                    </div>
                                    <div class="mb-3 text-center" style="margin-right: 0px">
                                        <div class="card shadow">
                                            <div class="card-body">

                                                <div id="drop-area">
                                                    @if ($dataRuangan->gambar->count() > 0)
                                                        <div class="image-container">
                                                            @foreach ($dataRuangan->gambar as $gambar)
                                                                <img src="{{ asset('assets/' . $gambar->url) }}"
                                                                    alt="Gambar Ruangan" width="100">
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p>Drag and Drop files here</p>
                                                    @endif
                                                </div>
                                                <p>or</p>
                                                <button type="button" onclick="fileInput.click()">Select
                                                    Files</button> <input type="file" id="fileInput" name="url[]"
                                                    @foreach ($dataRuangan->gambar as $gambar) value="{{ $gambar->url }}" @endforeach
                                                    multiple hidden>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Menggunakan class col-auto agar kolom menyesuaikan dengan ukuran kontennya -->
                                    <button type="submit" class="btn btn-primary">
                                        Submit
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
        document.getElementById('status').addEventListener('change', function() {
            var status = this.value;
            var tersediaInput = document.getElementById('tersedia');

            if (status === 'Available') {
                tersediaInput.value = 0;
            } else if (status === 'Booked') {
                tersediaInput.value = 1;
            } else if (status === {{ $dataRuangan->status }}) {
                tersediaInput.value = {{ $dataRuangan->tersedia }};
            } else {
                tersediaInput.value = '';
            }
        });

        document.addEventListener('DOMContentLoaded', (event) => {
            const dropArea = document.getElementById('drop-area');
            const fileInput = document.getElementById('fileInput');

            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            // Highlight drop area when item is dragged over it
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            // Handle dropped files
            dropArea.addEventListener('drop', handleDrop, false);

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function highlight(e) {
                dropArea.classList.add('highlight');
            }

            function unhighlight(e) {
                dropArea.classList.remove('highlight');
            }

            function handleDrop(e) {
                let dt = e.dataTransfer;
                let files = dt.files;

                handleFiles(files);
            }

            function handleFiles(files) {
                ([...files]).forEach(uploadFile);
                fileInput.files = files; // update the hidden file input with the dropped files
            }

            function uploadFile(file) {
                let url = 'YOUR_UPLOAD_URL_HERE';
                let formData = new FormData();
                formData.append('file', file);

                fetch(url, {
                        method: 'POST',
                        body: formData
                    })
                    .then(() => {
                        /* Done. Inform the user */
                    })
                    .catch(() => {
                        /* Error. Inform the user */
                    });
            }
        });
    </script>
@endsection
