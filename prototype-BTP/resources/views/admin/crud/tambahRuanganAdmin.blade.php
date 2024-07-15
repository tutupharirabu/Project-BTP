@extends('admin.layouts.mainAdmin')
@section('containAdmin')
    <style>
        .text-warna {
            color: #cccccc;
            font-size: 14px;
            font-weight: 600;
        }

        .input-harga {
            position: relative;
        }

        .input-harga input {
            padding-left: 40px;
        }
        .input-harga::before {
            content: 'Rp. ';
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
    </style>

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
                    <a href="/statusRuanganAdmin" class="fw-bolder" style="color: #797979; font-size:12px;">Daftar Ruangan
                        ></a>
                    <a href="" class="fw-bolder" style="color: #028391; font-size:12px;">&nbsp;Tambah Ruangan</a>
                </div>
            </div>
        </div>

        <!-- value -->
        <div class="row justify-content-center mt-4">
            <div class="col-11">
                <div class="card border shadow shadow-md">
                    <div class="card-body">
                        <form id="add-form" class="row g-1 needs-validation" action="{{ route('posts.ruangan') }}"
                            method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            <!-- left from text field -->
                            <div class="col-md-7">
                                <div class="form-group row mb-2">
                                    {{-- <label for="id_ruangan" class="text-color col-md-3 col-form-label text-md-left-right">ID
                                        Ruangan</label> --}}
                                    <div class="col-md-7">
                                        <input type="text" id="id_ruangan" class="bordered-text form-control"
                                            name="id_ruangan" hidden disabled>
                                        <div class="valid-feedback">Tampilan bagus!</div>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="nama_ruangan" class="text-color col-md-3 col-form-label text-md-right">Nama
                                        Ruangan</label>
                                    <div class="col-md-7">
                                        <input type="text" id="nama_ruangan" class="bordered-text form-control"
                                            name="nama_ruangan" required>
                                        <div id="namaRuanganFeedback" class="invalid-feedback">Silakan masukkan nama
                                            ruangan.</div>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="kapasitas_minimal" class="text-color col-md-3 col-form-label text-md-right">
                                        Minimal kapasitas</label>
                                    <div class="col-md-7">
                                        <input type="number" id="kapasitas_minimal" class="bordered-text form-control"
                                            name="kapasitas_minimal" required>
                                        <div class="invalid-feedback">Silakan masukkan minimal kapasitas.</div>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="kapasitas_maksimal"
                                        class="text-color col-md-3 col-form-label text-md-right">Maksimal kapasitas</label>
                                    <div class="col-md-7">
                                        <input type="number" id="kapasitas_maksimal" class="bordered-text form-control"
                                            name="kapasitas_maksimal" required>
                                        <div class="invalid-feedback">Silakan masukkan maksimal kapasitas.</div>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="lokasi"
                                        class="text-color col-md-3 col-form-label text-md-right">Lokasi</label>
                                    <div class="col-md-7">
                                        <input type="text" id="lokasi" class="bordered-text form-control"
                                            name="lokasi" required>
                                        <div class="invalid-feedback">Silakan masukkan lokasi.</div>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="harga_ruangan"
                                        class="text-color col-md-3 col-form-label text-md-right">Harga</label>
                                    <div class="col-md-7">
                                        <div class=input-harga>
                                            <input type="text" id="harga_ruangan" class="bordered-text form-control rounded-end"
                                            name="harga_ruangan" required>
                                        <div class="invalid-feedback">Silakan masukkan harga.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="satuan"
                                        class="text-color col-md-3 col-form-label text-md-right">Satuan Waktu Penyewaan</label>
                                    <div class="col-md-7">
                                        <input type="text" id="satuan" class="bordered-text form-control"
                                            name="satuan" required>
                                        <div class="invalid-feedback">Silakan masukkan satuan waktu.</div>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="status"
                                        class="text-color col-md-3 col-form-label text-md-right">Status</label>
                                    <div class="col-md-7">
                                        <select id="status" class="form-control bordered-text" name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Tersedia">Tersedia</option>
                                            <option value="Digunakan">Digunakan</option>
                                        </select>
                                        <div class="invalid-feedback">Silakan pilih status.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group row mb-2">
                                    <label for="url" class="text-color col-md-4 col-form-label text-md-right">Gambar
                                        Ruangan</label>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="drop-zone">
                                            <span class="drop-zone__label" style="color: #717171;">Gambar Utama</span>
                                            <input type="file" for="url" id="url" name="url[]"
                                                class="drop-zone__input" required>
                                            <div class="invalid-feedback" style="bottom:-15%">Silakan unggah gambar utama.</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="drop-zone">
                                            <span class="drop-zone__label">Gambar 2</span>
                                            <input type="file" id="gambar_2" name="url[]" class="drop-zone__input">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="drop-zone">
                                            <span class="drop-zone__label">Gambar 3</span>
                                            <input type="file" id="gambar_3" name="url[]" class="drop-zone__input">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="drop-zone">
                                            <span class="drop-zone__label">Gambar 4</span>
                                            <input type="file" id="gambar_4" name="url[]" class="drop-zone__input">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="drop-zone">
                                            <span class="drop-zone__label">Gambar 5</span>
                                            <input type="file" id="gambar_5" name="url[]" class="drop-zone__input">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-warna" style="margin-top: -20px">Pastikan ukuran gambar memiliki format .JPG / .PNG. Dimensi yang
                                        direkomendasikan adalah 600x300 pixels.</p>
                                    <button type="button" class="btn text-white capitalize-first-letter"
                                        style="background-color: #0C9300"
                                        onclick="showConfirmationModal()">Tambah</button>
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
                        <span class="material-symbols-outlined text-white" style="font-size: 4em;">add</span>
                    </div>
                    <p style="margin-top: 10px;">Apakah anda ingin menambahkan ruangan?</p>
                    <button type="button" class="btn text-white text-capitalize"
                        style="background-color: #FF3636; margin-right: 30px"
                        onclick="closeConfirmationModal()">TIDAK</button>
                    <button type="button" class="btn text-white text-capitalize" style="background-color: #00DE09"
                        onclick="submitForm()">YA</button>
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
                    <button type="button" class="btn text-white" style="background-color:#0066FF;"
                        onclick="closeSuccessModal()">Oke</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('nama_ruangan').addEventListener('blur', function() {
            var namaRuangan = this.value;
            if (namaRuangan) {
                fetch('{{ route('check.room.name') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            nama_ruangan: namaRuangan
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            var inputElement = document.getElementById('nama_ruangan');
                            inputElement.setCustomValidity('Nama ruangan sudah ada, silakan pilih nama lain.');
                            inputElement.reportValidity();
                        } else {
                            document.getElementById('nama_ruangan').setCustomValidity('');
                        }
                    });
            }
        });
    </script>

    <script src="{{ asset('assets/js/admin/dragndrop-tambahRuangan.js') }}"></script>
    <script src="{{ asset('assets/js/admin/tambahRuangan.js') }}"></script>
@endsection
