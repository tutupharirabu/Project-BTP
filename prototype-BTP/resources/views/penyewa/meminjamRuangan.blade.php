@extends('penyewa.layouts.mainPenyewa')

@section('containPenyewa')

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('assets/css/penyewa/form.css') }}">
        {{-- <link rel="stylesheet" href="style.css"> --}}
    </head>

    <div class="container-fluid mt-4">
        <!-- title -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="container mx-2">
                    <h4>Formulir Peminjaman Ruangan</h4>
                </div>
            </div>
        </div>

        <!-- href ui -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="d-flex container my-2 mx-2">
                    @if ($origin == 'dashboard')
                        <a href="/dashboardPenyewa" class="fw-bolder" style="color: #797979; font-size:12px;">Dashboard
                            ></a>
                    @elseif ($origin == 'detailRuangan')
                        <a href="/daftarRuanganPenyewa" class="fw-bolder" style="color: #797979; font-size:12px;">Daftar
                            Ruangan > </a>
                        <a href="{{ route('detailRuanganPenyewa', ['id' => $ruangan->id_ruangan]) }}" class="fw-bolder"
                            style="color: #797979; font-size:12px;">&nbsp;Detail Ruangan ></a>
                    @endif
                    <a href="" class="fw-bolder" style="color: #028391; font-size:12px;">&nbsp;Formulir Peminjaman
                        Ruangan</a>
                </div>
            </div>
        </div>


        <!-- value -->
        <div class="row justify-content-center mt-2">
            <div class="col m-3">
                <div class="card border shadow shadow-md p-2">
                    <div class="card-body">
                        <form id="rentalForm" action="{{ route('posts.peminjamanRuangan') }}" method="POST"
                            class="needs-validation" enctype="multipart/form-data" novalidate>
                            @csrf
                            <div class="row">
                                <!-- left form text field -->
                                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                    <div class="col-md">
                                        {{-- <label for="invoice" class="form-label text-color">Nomor Invoice</label> --}}
                                        <input type="text" name="invoice" id="invoice"
                                            class="date form-control border-color" required hidden>
                                        <div class="invalid-feedback">
                                            Masukkan Invoice anda!
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <label for="nama_peminjam" class="form-label text-color">Nama Peminjam</label>
                                        <input type="text" name="nama_peminjam" id="nama_peminjam"
                                            class="date form-control border-color" required>
                                        <div class="invalid-feedback">
                                            Masukkan nama Anda!
                                        </div>
                                    </div>


                                    <div class="col-md mt-4">
                                        <label for="nomor_telepon" class="form-label text-color">Nomor Telepon</label>
                                        <input type="text" name="nomor_telepon" id="nomor_telepon"
                                            class="date form-control border-color" maxlength="13" required>
                                        <div class="invalid-feedback">
                                            Masukkan nomor telepon Anda!
                                        </div>
                                    </div>

                                    <div class="col-md mt-4">
                                        <label for="role" class="form-label text-color">Status</label>
                                        <select name="role" id="role" class="form-select border-color" onchange="handleRoleChange(); filterRuanganOptions();" required>
                                            <option value="" disabled selected>Pilih Status</option>
                                            <option value="Pegawai">Pegawai</option>
                                            <option value="Mahasiswa">Mahasiswa</option>
                                            <option value="Umum">Umum</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Pilih status Anda!
                                        </div>
                                    </div>

                                    <div class="col-md mt-4" id="nomorIndukDiv">
                                        <label for="nomor_induk" class="form-label text-color">NIM / NIP</label>
                                        <input type="text" name="nomor_induk" id="nomor_induk" class="date form-control border-color" maxlength="15" required>
                                        <div class="invalid-feedback">
                                            Masukkan NIM / NIP Anda!
                                        </div>
                                    </div>

                                    <div class="col-md mt-4">
                                        <label for="ruang" class="form-label text-color">Ruangan</label>
                                        <select name="id_ruangan" id="id_ruangan" class="form-select border-color" disabled
                                            onchange="fetchRuanganDetails(); adjustParticipantLimits()" required>
                                            <option selected disabled value="">Pilih ruangan</option>
                                            @foreach ($dataRuangan as $dr)
                                                <option value="{{ $dr->id_ruangan }}"
                                                    data-min="{{ $dr->kapasitas_minimal }}"
                                                    data-max="{{ $dr->kapasitas_maksimal }}"
                                                    data-type="{{ $dr->nama_ruangan }}"
                                                    {{ isset($ruangan) && $ruangan->id_ruangan == $dr->id_ruangan ? 'selected' : '' }}>
                                                    {{ $dr->nama_ruangan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Masukkan pilihan ruangan Anda!
                                        </div>
                                    </div>

                                    <div class="col-md mt-4">
                                        <label for="lokasi" class="form-label text-color">Lokasi</label>
                                        <input type="text" name="lokasi" id="lokasi"
                                            class="date form-control border-color" disabled required>
                                        <div class="invalid-feedback">
                                            Masukkan Lokasi!
                                        </div>
                                    </div>

                                    <div class="col-md mt-4">
                                        <label for="harga_ruangan" class="form-label text-color">Harga</label>
                                        <input type="text" name="harga_ruangan" id="harga_ruangan"
                                            class="date form-control border-color" disabled required>
                                        <div class="invalid-feedback">
                                            Masukkan Harga!
                                        </div>
                                    </div>

                                    <div class="col-md mt-4">
                                        {{-- <label for="harga_ppn" class="form-label text-color">Harga PPN</label> --}}
                                        <input type="text" name="harga_ppn" id="harga_ppn"
                                            class="date form-control border-color" required hidden>
                                    </div>

                                    <div class="col-md mt-4">
                                        <label for="jumlah" class="form-label text-color">Jumlah Peserta</label>
                                        <select name="jumlah" id="peserta" class="form-select border-color" required>
                                            <option selected disabled value="">Pilih jumlah peserta</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Masukkan jumlah peserta!
                                        </div>
                                    </div>
                                </div>

                                <!-- right form file -->
                                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7">
                                    <div id="form-content">
                                        <!-- Konten untuk Isi Tanggal Sewa akan dimuat di sini secara default -->
                                    </div>
                                    <div class="col-md">
                                        <div class="form-group">
                                            <label for="keterangan" class="mb-2 text-color">Catatan</label>
                                            <textarea class="form-control border-color" name="keterangan" id="keterangan" rows="8" maxlength="254"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md mt-4">
                            <div class="d-grid gap-2 d-flex justify-content-end">
                                    <button type="submit" id="submitBtn" class=" text-white button-style capitalize-first-letter" style="font-weight:800">Ajukan</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <div>
                    Keterangan<br><p style="margin-left:20px">*Harga diatas belum termasuk PPN (sesuai dengan ketentuan regulasi yang berlaku</p>
                    <p style="margin-left:20px">**Untuk informasi lebih lengkap lihat <a href="https://drive.google.com/file/d/1V0KMW2frSiv1uw8X_GSyBiGABFQySqy-/view?usp=sharing">disini</a></p>
                    Fasilitas<p style="margin-left:20px">*Full AC, Toilet, Free Parking, Sound System (Speaker & 2 Mic), Screen, LCD Projector, Whiteboard,
                    Listrik standar (penggunaan listrik di luar yang telah disediakan wajib melaporkan kepada manajemen
                    BTP dan menambahkan daya menggunakan genset dengan biaya yang ditanggung oleh penyewa).</p>

                    @if (isset($errors) && count($errors))
                        There were {{ count($errors->all()) }} Error(s)
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }} </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#419343;">
                    <h5 class="modal-title text-white" id="confirmationModalLabel">Rincian Peminjaman Ruangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-color">Nomor Invoice</label>
                        <p id="confirm_invoice" name="invoice" class="bordered-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Nama Peminjam</label>
                        <p id="confirm_nama_peminjam" name="nama_peminjam" class="bordered-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Nomor Telepon</label>
                        <p id="confirm_nomor_telepon" name="nomor_telepon" class="bordered-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Nama Ruangan</label>
                        <p id="confirm_nama_ruangan" name="id_ruangan" class="bordered-text"></p>
                    </div>
                    <div id="nomorIndukDisplayDiv" class="mb-3">
                        <label class="form-label text-color">NIM / NIP</label>
                        <p id="confirm_nomor_induk" name="nomor_induk" class="bordered-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Status</label>
                        <p id="confirm_status" name="role" class="bordered-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Lokasi</label>
                        <p id="confirm_lokasi" name="lokasi" class="bordered-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Jumlah Peserta</label>
                        <p id="confirm_jumlah_peserta" name="jumlah" class="bordered-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Tanggal Mulai Peminjaman</label>
                        <p id="confirm_tanggal_mulai" name="tanggal_mulai" class="bordered-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Tanggal Selesai Peminjaman</label>
                        <p id="confirm_tanggal_selesai" name="tanggal_selesai" class="bordered-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Jam Mulai Peminjaman</label>
                        <p id="confirm_jam_mulai" name="jam_mulai" class="bordered-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Jam Selesai Peminjaman</label>
                        <p id="confirm_jam_selesai" name="jam_selesai" class="bordered-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Harga</label>
                        <p id="confirm_harga" class="bordered-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Harga (Termasuk PPN 11% dan biaya Virtual Account)</label>
                        <p id="confirm_harga_dengan_ppn" class="bordered-text" name="harga_ppn"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Catatan Peminjaman</label>
                        <p id="confirm_keterangan" class="bordered-text"></p>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="confirm_agreement">
                        <label class="form-check-label" for="confirm_agreement" style="font-size: 14px; color: #717171;">
                            Saya telah membaca, mengerti, dan menyetujui syarat & ketentuan yang berlaku.
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn text-white capitalize-first-letter" data-bs-dismiss="modal"
                        style="height: 41px; background-color:#717171;font-size: 14px;">Batal</button>
                    <button type="button" class=" button-style text-white capitalize-first-letter"
                        onclick="showConfirmationPopup()">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Popup Modal -->
    <div class="modal fade" id="confirmationPopupModal" tabindex="-1" aria-labelledby="confirmationPopupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apakah Pemesanan untuk peminjaman sudah sesuai?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Pastikan pemesanan sesuai dengan permintaan anda</p>
                    <button type="button" class="btn text-white text-capitalize btn-spacing font-btn width-btn"
                        style="background-color:#FF0000" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn text-white text-capitalize font-btn width-btn "
                        style="background-color:#0DA200" onclick="confirmSubmission()">Ya</button>
                </div>
            </div>
        </div>
    </div>

    <!-- WhatsApp Modal -->
    <div class="modal fade p-1" id="whatsappModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="whatsappModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title">Silahkan menghubungi Admin untuk melakukan pembayaran</h5>
                    <button type="button" class="btn-close whatsapp-close-button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Konfirmasi pembayaran dapat dilakukan via WA, klik tombol di bawah</p>
                    <a id="whatsappButton" href="https://wa.me/+6282127644368"
                        class="btn text-white text-capitalize btn-spacing font-btn mx-auto"
                        style="background-color:#0DA200" target="_blank">WhatsApp</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/penyewa/confirmationForm.js') }}"></script>
    <script src="{{ asset('assets/js/penyewa/ketersediaanJam.js') }}"></script>
    <script src="{{ asset('assets/js/penyewa/meminjamRuangan.js') }}"></script>

@endsection
