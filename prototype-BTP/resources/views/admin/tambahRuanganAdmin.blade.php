@extends('admin.layouts.mainAdmin')

@section('containAdmin')

<head>
    <link rel="stylesheet" href="assets/css/dragndrop.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/tambahruangan.css') }}">
</head>

<div class="container-fluid mt-4">
    <!-- title -->
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="container mx-2">
                <h4>Tambah Ruangan</h4>
            </div>
        </div>
    </div>

    <!-- href ui -->
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="d-flex container my-2 mx-2">
                <a href="/statusRuanganAdmin" class="fw-bolder" style="color: #797979; font-size:12px;">Daftar Ruangan ></a>
                <a href="" class="fw-bolder" style="color: red; font-size:12px;">&nbsp;Tambah Ruangan</a>
            </div>
        </div>
    </div>

    <!-- value -->
    <div class="row justify-content-center mt-4">
        <div class="col-11">
            <div class="card border shadow shadow-md">
                <div class="card-body">
                    <form id="add-form" class="row g-3 needs-validation" action="{{ route('posts.ruangan') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <!-- left from text field -->
                        <div class="col-md-7">
                            <div class="form-group row mb-2">
                                <label for="id_ruangan" class="text-color col-md-3 col-form-label text-md-left-right">ID Ruangan</label>
                                <div class="col-md-7">
                                    <input type="text" id="id_ruangan" class="bordered-text form-control" name="id_ruangan" disabled>
                                    <div class="valid-feedback">Tampilan bagus!</div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="nama_ruangan" class="text-color col-md-3 col-form-label text-md-right">Nama Ruangan</label>
                                <div class="col-md-7">
                                    <input type="text" id="nama_ruangan" class="bordered-text form-control" name="nama_ruangan" required>
                                    <div class="invalid-feedback">Silakan masukkan nama ruangan.</div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="kapasitas_ruangan" class="text-color col-md-3 col-form-label text-md-right">Kapasitas</label>
                                <div class="col-md-7">
                                    <input type="number" id="kapasitas_ruangan" class="bordered-text form-control" name="kapasitas_ruangan" required>
                                    <div class="invalid-feedback">Silakan masukkan kapasitas.</div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="lokasi" class="text-color col-md-3 col-form-label text-md-right">Lokasi</label>
                                <div class="col-md-7">
                                    <input type="text" id="lokasi" class="bordered-text form-control" name="lokasi" required>
                                    <div class="invalid-feedback">Silakan masukkan lokasi.</div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="harga_ruangan" class="text-color col-md-3 col-form-label text-md-right">Harga</label>
                                <div class="col-md-7">
                                    <input type="text" id="harga_ruangan" class="bordered-text form-control" name="harga_ruangan" required>
                                    <div class="invalid-feedback">Silakan masukkan harga.</div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="status" class="text-color col-md-3 col-form-label text-md-right">Status</label>
                                <div class="col-md-7">
                                    <select id="status" class="form-control bordered-text" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Available">Available</option>
                                        <option value="Booked">Booked</option>
                                    </select>
                                    <div class="invalid-feedback">Silakan pilih status.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group row mb-2">
                                <label for="url" class="text-color col-md-4 col-form-label text-md-right">Gambar Ruangan</label>
                            </div>
                            <div class="drop-zone">
                                <span class="drop-zone__prompt" style="color: #717171;">Drop file here or click to upload</span>
                                <input type="file" for="url" id="url" name="url[]" class="drop-zone__input" multiple required>
                                <div class="invalid-feedback" style="margin-bottom: 50px;">Silakan upload gambar.</div>
                            </div>
                            <strong>Uploaded Files</strong>
                            <p class="uploadedRooms"></p>
                            <button type="button" class="btn text-white capitalize-first-letter" style="background-color: #0C9300" onclick="showConfirmationModal()">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="circle-add">
                    <span class="material-symbols-outlined text-white" style="font-size: 4em;">add</span>
                </div>
                <p style="margin-top: 10px;">Apakah anda ingin menambahkan ruangan?</p>
                <button type="button" class="btn text-white" style="background-color: #FF3636; margin-right: 30px" onclick="closeConfirmationModal()">TIDAK</button>
                <button type="button" class="btn text-white" style="background-color: #00DE09" onclick="submitForm()">YA</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="circle-add">
                    <span class="material-symbols-outlined text-white" style="font-size: 4em;">check_circle</span>
                </div>
                <p>Ruangan Multimedia telah ditambahkan</p>
                <button type="button" class="btn btn-primary" onclick="closeSuccessModal()">Oke</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/admin/dragndrop.js"></script>
<script src="{{ asset('assets/js/admin/tambahRuangan.js') }}"></script>
@endsection
