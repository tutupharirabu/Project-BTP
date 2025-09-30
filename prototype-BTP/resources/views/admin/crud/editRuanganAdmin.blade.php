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
        <link rel="stylesheet" href="{{ asset('assets/css/admin/editRuangan.css') }}">
        <script defer src="https://umami-web-traffic-analysis.tutupharirabu.cloud/script.js"
            data-website-id="e379e174-3600-4866-9ed9-a33d3750d016"></script>
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
                    <a href="/daftarRuanganAdmin" class="fw-bolder" style="color: #797979; font-size:12px;">Daftar Ruangan
                        ></a>
                    <a href="" class="fw-bolder" style="color: #028391; font-size:12px;">&nbsp;Edit Ruangan</a>
                </div>
            </div>
        </div>

        <!-- value -->
        <div class="row justify-content-center mt-4 mb-md-8 mb-lg-8 mb-xl-8 mb-sm-4">
            <div class="col-11">
                <div class="card border shadow-md">
                    <div class="card-body">
                        <form action="{{ route('ruangan.updateDataRuangan', $dataRuanganEdit->id_ruangan) }}" method="POST"
                            enctype="multipart/form-data" id="edit-form" class="row g-3 needs-validation"
                            onsubmit="removeRpPrefix()" novalidate>
                            @csrf
                            @method('PUT')
                            <!-- left form text field -->
                            <div class="col-md-7">
                                <div class="form-group row mb-2">
                                    {{-- <label for="id_ruangan"
                                        class="col-md-3 col-form-label text-md-left-right text-color">ID
                                        Ruangan</label> --}}
                                    <div class="col-md-7">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <input type="text" id="id_ruangan" class="form-control bordered-text border-color"
                                            name="id_ruangan" disabled value="{{ $dataRuanganEdit->id_ruangan }}" hidden>
                                        <div class="valid-feedback">Tampilan bagus!</div>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="nama_ruangan" class="col-md-3 col-form-label text-md-right text-color">Nama
                                        dan Nomor Ruangan</label>
                                    <div class="col-md-7">
                                        <div id="" class="form-text">
                                            Contoh: Coworking space (B02)
                                        </div>
                                        <input type="text" id="nama_ruangan" class="form-control bordered-text border-color"
                                            name="nama_ruangan" value="{{ $dataRuanganEdit->nama_ruangan }}" required>
                                        <div class="invalid-feedback">Silakan masukkan nama dan nomor ruangan.</div>
                                    </div>
                                </div>
                                {{-- <div class="form-group row mb-2">
                                    <label for="ukuran"
                                        class="col-md-3 col-form-label text-md-right text-color">Ukuran</label>
                                    <div class="col-md-7">
                                        <div id="" class="form-text">
                                            Contoh: 5 x 5
                                        </div>
                                        <input type="text" id="ukuran" class="form-control bordered-text border-color"
                                            name="ukuran" value="{{ $dataRuangan->ukuran }}" required>
                                        <div class="invalid-feedback">Silakan masukkan ukuran ruangan.</div>
                                    </div>
                                </div> --}}
                                <div class="form-group row mb-2">
                                    <label for="kapasitas_minimal"
                                        class="col-md-3 col-form-label text-md-right text-color">Minimal kapasitas</label>
                                    <div class="col-md-7">
                                        <input type="number" id="kapasitas_minimal"
                                            class="form-control bordered-text border-color" name="kapasitas_minimal"
                                            value="{{ $dataRuanganEdit->kapasitas_minimal }}" required>
                                        <div class="invalid-feedback">Silakan masukkan minimal kapasitas.</div>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="kapasitas_maksimal"
                                        class="col-md-3 col-form-label text-md-right text-color">Maksimal kapasitas</label>
                                    <div class="col-md-7">
                                        <input type="number" id="kapasitas_maksimal"
                                            class="form-control bordered-text border-color" name="kapasitas_maksimal"
                                            value="{{ $dataRuanganEdit->kapasitas_maksimal }}" required>
                                        <div class="invalid-feedback">Silakan masukkan maksimal kapasitas.</div>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="lokasi"
                                        class="col-md-3 col-form-label text-md-right text-color">Lokasi</label>
                                    <div class="col-md-7">
                                        {{-- <input type="text" id="lokasi" class="form-control bordered-text border-color"
                                            name="lokasi" value="{{ $dataRuangan->lokasi }}" required> --}}
                                        <select class="bordered-text form-control" name="lokasi" id="lokasi" required>
                                            <option>{{ $dataRuanganEdit->lokasi }}</option>
                                            @if ($dataRuanganEdit->lokasi != 'Gedung A')
                                                <option value="Gedung A">Gedung A</option>
                                            @endif
                                            @if ($dataRuanganEdit->lokasi != 'Gedung B')
                                                <option value="Gedung B">Gedung B</option>
                                            @endif
                                            @if ($dataRuanganEdit->lokasi != 'Gedung C')
                                                <option value="Gedung C">Gedung C</option>
                                            @endif
                                            @if ($dataRuanganEdit->lokasi != 'Gedung D')
                                                <option value="Gedung D">Gedung D</option>
                                            @endif
                                        </select>
                                        <div class="invalid-feedback">Silakan masukkan lokasi.</div>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="harga_ruangan"
                                        class="col-md-3 col-form-label text-md-right text-color">Harga</label>
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <input type="text" id="harga_ruangan" class="bordered-text form-control"
                                                name="harga_ruangan" value="{{ $dataRuanganEdit->harga_ruangan }}" required>
                                            <div class="invalid-feedback">Silakan masukkan harga.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="satuan" class="col-md-3 col-form-label text-md-right text-color">Satuan
                                        Waktu Penyewaan</label>
                                    <div class="col-md-7">
                                        {{-- <input type="text" id="satuan" class="form-control bordered-text border-color"
                                            name="satuan" value="{{ $dataRuangan->satuan }}" required> --}}
                                        <select class="bordered-text form-control" name="satuan" id="satuan" required>
                                            <option>{{ $dataRuanganEdit->satuan }}</option>
                                            @if ($dataRuanganEdit->satuan != 'Seat / Bulan')
                                                <option value="Seat / Bulan">Seat / Bulan</option>
                                            @endif
                                            @if ($dataRuanganEdit->satuan != 'Seat / Hari')
                                                <option value="Seat / Hari">Seat / Hari</option>
                                            @endif
                                            @if ($dataRuanganEdit->satuan != 'Halfday / 4 Jam')
                                                <option value="Halfday / 4 Jam">Halfday / 4 Jam</option>
                                            @endif
                                        </select>
                                        <div class="invalid-feedback">Silakan masukkan satuan waktu.</div>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="status"
                                        class="col-md-3 col-form-label text-md-right text-color">Status</label>
                                    <div class="col-md-7">
                                        <select id="status" class="form-control bordered-text" name="status" required
                                            onchange="updateTersedia()">
                                            <option value="{{ $dataRuanganEdit->status }}">{{ $dataRuanganEdit->status }}
                                            </option>
                                            @if ($dataRuanganEdit->status != 'Tersedia')
                                                <option value="Tersedia">Tersedia</option>
                                            @endif
                                            @if ($dataRuanganEdit->status != 'Digunakan')
                                                <option value="Digunakan">Digunakan</option>
                                            @endif
                                        </select>
                                        <div class="invalid-feedback">Silakan pilih status.</div>
                                        <input type="number" id="tersedia" class="form-control bordered-text"
                                            name="tersedia" value="{{ $dataRuanganEdit->tersedia }}" hidden>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="keterangan" class="col-md-3 col-form-label text-md-right text-color">
                                        Fasilitas Ruangan
                                        {{-- <span class="form-text">
                                            (Opsional)
                                        </span> --}}
                                    </label>
                                    <div class="col-md-7">
                                        {{-- <input type="text" id="nama_ruangan"
                                            class="form-control bordered-text border-color" name="nama_ruangan"
                                            value="{{ $dataRuangan->nama_ruangan }}" required> --}}
                                        <textarea name="keterangan" id="keterangan" onkeyup="handleInput(event)" cols="30"
                                            rows="10"
                                            class="bordered-text form-control">{{ $dataRuanganEdit->keterangan }}</textarea>
                                        <div class="invalid-feedback">Silakan masukkan fasilitas ruangan.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- right form file -->
                            <div class="col-md-5">
                                <div class="form-group row mb-2">
                                    <label for="url" class="col-md-4 col-form-label text-md-right text-color">Gambar
                                        Ruangan</label>
                                </div>
                                <div class="row">
                                    @php
                                        // Urutkan gambar berdasarkan indeks dalam public_id (image_1, image_2, dll)
                                        $sortedGambar = !empty($dataRuanganEdit->gambars)
                                            ? $dataRuanganEdit->gambars
                                                ->sortBy(function ($gambar) {
                                                    // Ekstrak nomor indeks dari URL
                                                    preg_match('/_image_(\d+)/', $gambar->url, $matches);
                                                    return isset($matches[1]) ? (int) $matches[1] : 999; // Jika tidak ada pattern, letakkan di akhir
                                                })
                                                ->values()
                                            : collect([]);
                                        $gambarExists = $sortedGambar->isNotEmpty();
                                    @endphp

                                    <div class="col-12">
                                        <div class="drop-zone">
                                            <span class="drop-zone__prompt" style="color: #717171;">
                                                @if ($gambarExists)
                                                    <img src="{{ asset($sortedGambar[0]->url) }}" alt="" width="150"
                                                        height="100">
                                                @else
                                                    <span class="material-symbols-outlined"
                                                        style="color: #717171; font-size: 48px;">
                                                        add_circle
                                                    </span>
                                                    <span>Gambar Utama</span>
                                                @endif
                                            </span>
                                            <input type="file" for="url" id="gambar_utama" name="url[]"
                                                class="drop-zone__input" @if (!$gambarExists) required @endif>
                                            @if (!$gambarExists)
                                                <div class="invalid-feedback">Silakan upload gambar utama.</div>
                                            @endif
                                        </div>
                                    </div>

                                    @for ($i = 1; $i <= 4; $i++)
                                        <div class="col-6">
                                            <div class="drop-zone">
                                                <span class="drop-zone__prompt"
                                                    style="display: flex; flex-direction: column; align-items: center;">
                                                    @if ($sortedGambar->count() > $i)
                                                        <img src="{{ asset($sortedGambar[$i]->url) }}" alt="" width="150"
                                                            height="100">
                                                    @else
                                                        <span class="material-symbols-outlined" style="font-size: 36px;">
                                                            add_circle
                                                        </span>
                                                        <span>Gambar {{ $i + 1 }}</span>
                                                    @endif
                                                </span>
                                                <input type="file" id="gambar_{{ $i + 1 }}" name="url[]"
                                                    class="drop-zone__input">
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                <div>
                                    <p class="text-warna" style="margin-top: -20px">Pastikan ukuran gambar memiliki format
                                        .JPG / .PNG. Dimensi yang direkomendasikan adalah 600x300 pixels.</p>
                                    <button type="button" class="btn text-white capitalize-first-letter"
                                        style="background-color: #0C9300" onclick="showConfirmationModal()">Edit</button>
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('assets/js/admin/dragndrop-editRuangan.js') }}"></script>
    <script src="{{ asset('assets/js/admin/editRuangan.js') }}"></script>

    <script>
        //buat bullet
        const bullet = "\u2022";
        const bulletWithSpace = `${bullet} `;
        const enter = 13;

        const handleInput = (event) => {
            const {
                keyCode,
                target
            } = event;
            const {
                selectionStart,
                value
            } = target;

            if (keyCode === enter) {
                const lines = value.split('\n');
                const currentLine = value.substr(0, selectionStart).split('\n').length - 1;

                lines[currentLine] = `${bulletWithSpace}${lines[currentLine].trim()}`;

                target.value = lines.join('\n');

                target.selectionStart = target.selectionEnd = selectionStart + bulletWithSpace.length;
            }

            if (value[0] !== bullet) {
                target.value = `${bulletWithSpace}${value}`;
            }
        }
        //endbullet
        // function formatRoomSize(input) {
        //     let value = input.value.replace(/\s/g, '').replace(/[^\d]/g, ''); // Remove spaces and non-numeric characters
        //     if (value.length >= 2) {
        //         const mid = Math.ceil(value.length / 2);
        //         value = value.slice(0, mid) + ' x ' + value.slice(mid);
        //     }
        //     input.value = value;
        // }

        // document.getElementById('ukuran').addEventListener('input', function () {
        //     formatRoomSize(this);
        // });
    </script>
@endsection
