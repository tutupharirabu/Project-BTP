@extends('admin.layouts.mainAdmin')
@section('containAdmin')
<style>
    .text-warna {
        color: #cccccc;
        font-size: 14px;
        font-weight: 600;
    }
</style>

<head>
    <link rel="stylesheet" href="{{ asset('assets/css/dragndrop.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/editRuangan.css') }}">
</head>

<div class="container-fluid mt-4">
    <!-- title -->
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="container mx-2">
                <h4>Edit Ruangan</h4>
            </div>
        </div>
    </div>

    <!-- href ui -->
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="d-flex container my-2 mx-2">
                <a href="/statusRuanganAdmin" class="fw-bolder" style="color: #797979; font-size:12px;">Daftar Ruangan ></a>
                <a href="" class="fw-bolder" style="color: #028391; font-size:12px;">&nbsp;Edit Ruangan</a>
            </div>
        </div>
    </div>

    <!-- value -->
    <div class="row justify-content-center mt-4 mb-md-8 mb-lg-8 mb-xl-8 mb-sm-4">
        <div class="col-11">
            <div class="card border shadow shadow-md">
                <div class="card-body">
                    <form action="{{ route('update.ruangan', $dataRuangan->id_ruangan) }}" method="POST" enctype="multipart/form-data" id="edit-form" class="row g-3 needs-validation" onsubmit="removeRpPrefix()" novalidate>
                        @csrf
                        @method('PUT')
                        <!-- left form text field -->
                        <div class="col-md-7">
                            <div class="form-group row mb-2">
                                <label for="id_ruangan" class="col-md-3 col-form-label text-md-left-right text-color">ID Ruangan</label>
                                <div class="col-md-7">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="text" id="id_ruangan" class="form-control bordered-text border-color" name="id_ruangan" disabled value="{{ $dataRuangan->id_ruangan }}">
                                    <div class="valid-feedback">Tampilan bagus!</div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="nama_ruangan" class="col-md-3 col-form-label text-md-right text-color">Nama Ruangan</label>
                                <div class="col-md-7">
                                    <input type="text" id="nama_ruangan" class="form-control bordered-text border-color" name="nama_ruangan" value="{{ $dataRuangan->nama_ruangan }}" required>
                                    <div class="invalid-feedback">Silakan masukkan nama ruangan.</div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="kapasitas_minimal" class="col-md-3 col-form-label text-md-right text-color">Minimal kapasitas</label>
                                <div class="col-md-7">
                                    <input type="number" id="kapasitas_minimal" class="form-control bordered-text border-color" name="kapasitas_minimal" value="{{ $dataRuangan->kapasitas_minimal }}" required>
                                    <div class="invalid-feedback">Silakan masukkan minimal kapasitas.</div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="kapasitas_maksimal" class="col-md-3 col-form-label text-md-right text-color">Maksimal kapasitas</label>
                                <div class="col-md-7">
                                    <input type="number" id="kapasitas_maksimal" class="form-control bordered-text border-color" name="kapasitas_maksimal" value="{{ $dataRuangan->kapasitas_maksimal }}" required>
                                    <div class="invalid-feedback">Silakan masukkan maksimal kapasitas.</div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="lokasi" class="col-md-3 col-form-label text-md-right text-color">Lokasi</label>
                                <div class="col-md-7">
                                    <input type="text" id="lokasi" class="form-control bordered-text border-color" name="lokasi" value="{{ $dataRuangan->lokasi }}" required>
                                    <div class="invalid-feedback">Silakan masukkan lokasi.</div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="harga_ruangan" class="col-md-3 col-form-label text-md-right text-color">Harga</label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" id="harga_ruangan" class="bordered-text form-control" name="harga_ruangan" value="{{ $dataRuangan->harga_ruangan }}" required>
                                        <div class="invalid-feedback">Silakan masukkan harga.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="satuan" class="col-md-3 col-form-label text-md-right text-color">Satuan Waktu Penyewaan</label>
                                <div class="col-md-7">
                                    <input type="text" id="satuan" class="form-control bordered-text border-color" name="satuan" value="{{ $dataRuangan->satuan }}" required>
                                    <div class="invalid-feedback">Silakan masukkan satuan waktu.</div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="status" class="col-md-3 col-form-label text-md-right text-color">Status</label>
                                <div class="col-md-7">
                                    <select id="status" class="form-control bordered-text" name="status" required onchange="updateTersedia()">
                                        <option value="{{ $dataRuangan->status }}">{{ $dataRuangan->status }}</option>
                                        <option value="Tersedia">Tersedia</option>
                                        <option value="Digunakan">Digunakan</option>
                                    </select>
                                    <div class="invalid-feedback">Silakan pilih status.</div>
                                    <input type="number" id="tersedia" class="form-control bordered-text" name="tersedia" value="{{ $dataRuangan->tersedia }}" hidden>
                                </div>
                            </div>
                        </div>

                        <!-- right form file -->
                        <div class="col-md-5">
                            <div class="form-group row mb-2">
                                <label for="url" class="col-md-4 col-form-label text-md-right text-color">Gambar Ruangan</label>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="drop-zone">
                                        <span class="drop-zone__prompt" style="color: #717171;">
                                            @if (!empty($dataRuangan->gambar) && $dataRuangan->gambar->isNotEmpty())
                                                <img src="{{ asset('assets/' . $dataRuangan->gambar->first()->url) }}" alt="" width="150" height="100">
                                                @php $gambarExists = true; @endphp
                                            @else
                                                Gambar Utama
                                                @php $gambarExists = false; @endphp
                                            @endif
                                        </span>
                                        <input type="file" for="url" id="url" name="url[]" class="drop-zone__input" @if(!$gambarExists) required @endif>
                                        @if(!$gambarExists)
                                            <div class="invalid-feedback">Silakan upload gambar utama.</div>
                                        @endif
                                    </div>
                                </div>
                                @for ($i = 1; $i <= 4; $i++)
                                    <div class="col-6">
                                        <div class="drop-zone">
                                            <span class="drop-zone__prompt">
                                                @if (!empty($dataRuangan->gambar) && $dataRuangan->gambar->count() > $i)
                                                    <img src="{{ asset('assets/' . $dataRuangan->gambar[$i]->url) }}" alt="" width="150" height="100">
                                                @else
                                                    Gambar {{ $i + 1 }}
                                                @endif
                                            </span>
                                            <input type="file" id="gambar_{{ $i + 1 }}" name="url[]" class="drop-zone__input">
                                        </div>
                                    </div>
                                @endfor
                            </div>
                            <div>
                                <p class="text-warna" style="margin-top: -20px">Pastikan ukuran gambar memiliki format .JPG / .PNG. Dimensi yang direkomendasikan adalah 600x300 pixels.</p>
                                <button type="button" class="btn text-white capitalize-first-letter" style="background-color: #0C9300" onclick="showConfirmationModal()">Edit</button>
                            </div>
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
                    <span class="material-symbols-outlined text-white" style="font-size: 3.5em;">border_color</span>
                </div>
                <p style="margin-top: 10px;">Apakah anda ingin memperbarui ruangan?</p>
                <button type="button" class="btn text-white text-capitalize" style="background-color: #FF3636; margin-right: 30px" onclick="closeConfirmationModal()">TIDAK</button>
                <button type="button" class="btn text-white text-capitalize" style="background-color: #00DE09" onclick="submitForm()">YA</button>
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
                <p id="modalMessage">Ruangan telah ditambahkan</p>
                <button type="button" class="btn text-white" style="background-color:#0066FF;" onclick="closeSuccessModal()">Oke</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/admin/dragndrop-editRuangan.js') }}"></script>
<script src="{{ asset('assets/js/admin/editRuangan.js') }}"></script>
@endsection