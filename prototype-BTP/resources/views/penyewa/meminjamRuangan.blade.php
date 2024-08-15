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
                    @if ($origin == 'detailRuangan')
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
                                        {{-- <label for="invoice" class="form-label text-color">Nomor Invoice</label>
                                        <input type="text" name="invoice" id="invoice"
                                            class="date form-control border-color" required hidden>
                                        <div class="invalid-feedback">
                                            Masukkan Invoice anda!
                                        </div> --}}
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
                                        <select name="role" id="role" class="form-select border-color"
                                            onchange="handleRoleChange(); filterRuanganOptions();" required>
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
                                        <input type="text" name="nomor_induk" id="nomor_induk"
                                            class="date form-control border-color" maxlength="15" required>
                                        <div class="invalid-feedback">
                                            Masukkan NIM / NIP Anda!
                                        </div>
                                    </div>

                                    @if (isset($origin) && $origin == 'detailRuangan')
                                        <div class="col-md mt-4">
                                            <label for="ruang" class="form-label text-color">Ruangan</label>
                                            <input type="hidden" name="id_ruangan" value="{{ $ruangan->id_ruangan }}"
                                                data-min="{{ $ruangan->kapasitas_minimal }}"
                                                data-max="{{ $ruangan->kapasitas_maksimal }}">
                                            <input type="text" name="nama_ruangan" value="{{ $ruangan->nama_ruangan }}"
                                                class="form-control border-color" disabled>
                                            <div class="invalid-feedback">
                                                Masukkan pilihan ruangan Anda!
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md mt-4">
                                            <label for="ruang" class="form-label text-color">Ruangan</label>
                                            <select name="id_ruangan" id="id_ruangan" class="form-select border-color"
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
                                    @endif

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
                                        <input type="text" name="total_harga" id="total_harga"
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
                                    <button type="submit" id="submitBtn"
                                        class=" text-white button-style capitalize-first-letter"
                                        style="font-weight:800">Ajukan</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <div>
                    Keterangan<br>
                    <p style="margin-left:20px">*Harga diatas belum termasuk PPN (sesuai dengan ketentuan regulasi yang
                        berlaku)</p>
                    <p style="margin-left:20px">**Untuk informasi lebih lengkap lihat <a
                            href="https://drive.google.com/file/d/1V0KMW2frSiv1uw8X_GSyBiGABFQySqy-/view?usp=sharing">disini</a>
                    </p>

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
                    {{-- <div class="mb-3">
                        <label class="form-label text-color">Nomor Invoice</label>
                        <p id="confirm_invoice" name="invoice" class="bordered-text"></p>
                    </div> --}}
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
                        <p id="confirm_harga_dengan_ppn" class="bordered-text" name="total_harga"></p>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var origin = "{{ $origin }}"; // Variabel ini diterima dari controller

            if (origin === 'detailRuangan') {
                console.log("Running fetchRuanganDetails and adjustParticipantLimits");
                fetchRuanganDetails();
                adjustParticipantLimits();

                document.getElementById('role').addEventListener('change', function() {
                    fetchRuanganDetails(); // Refresh seluruh fungsi saat role berubah
                });
            } else {
                // Pasang event listener untuk perubahan ruangan (id_ruangan) hanya jika tidak dari detailRuangan
                const idRuanganElement = document.getElementById('id_ruangan');
                if (idRuanganElement) {
                    idRuanganElement.addEventListener('change', adjustParticipantLimits);
                } else {
                    console.error("Element with id 'id_ruangan' not found");
                }
            }

            // Pasang event listener untuk perubahan jumlah peserta, terlepas dari asal
            const pesertaElement = document.getElementById('peserta');
            if (pesertaElement) {
                pesertaElement.addEventListener('change', validateParticipantInput);
            } else {
                console.error("Element with id 'peserta' not found");
            }
        });

        function fetchRuanganDetails() {
            const origin = "{{ $origin }}"; // Asumsi variabel ini dikirim dari controller
            let idRuangan;

            if (origin === 'detailRuangan') {
                const idRuanganElement = document.querySelector('input[name="id_ruangan"]');
                if (idRuanganElement) {
                    idRuangan = idRuanganElement.value;
                    console.log("ID Ruangan Dari Detail Ruangan:", idRuangan);
                } else {
                    console.error("ID Ruangan tidak ditemukan");
                    return;
                }
            } else {
                // Menggunakan id_ruangan dari select input jika bukan dari detailRuangan
                const idRuanganElement = document.getElementById('id_ruangan');
                if (idRuanganElement) {
                    idRuangan = idRuanganElement.value;
                    console.log("ID Ruangan dipilih:", idRuangan);
                } else {
                    console.error("Element with id 'id_ruangan' not found");
                    return;
                }
            }

            const role = document.getElementById('role').value;
            const hargaInput = document.getElementById('harga_ruangan');
            const ppnInput = document.getElementById('total_harga');
            const lokasiInput = document.getElementById('lokasi');

            console.log("Selected role:", role);
            console.log("Selected ruangan ID:", idRuangan);

            function updatePrice(data) {
                if (role) {
                    let hargaRuangan;
                    if (role === 'Pegawai') {
                        hargaRuangan = 0;
                        console.log("Internal role, setting price to 0");
                    } else if (role === 'Mahasiswa' || role === 'Umum') {
                        hargaRuangan = parseInt(data.harga_ruangan);
                        console.log("External role, setting price to:", hargaRuangan);
                    }

                    const formattedHargaRuangan = 'Rp ' + hargaRuangan.toLocaleString('id-ID');
                    hargaInput.value = formattedHargaRuangan;
                    console.log("Final formatted price:", formattedHargaRuangan);

                    // Calculate PPN and total price
                    const ppnRate = 0.11; // Assuming PPN is 11%
                    const ppnAmount = hargaRuangan * ppnRate;
                    let totalHarga = hargaRuangan + ppnAmount;

                    // Add an additional 2500 for 'Mahasiswa' and 'Umum'
                    if (role === 'Mahasiswa' || role === 'Umum') {
                        totalHarga += 2500;
                        console.log("Added 2500 to total price for role:", role);
                    }

                    const formattedTotalHarga = 'Rp ' + totalHarga.toLocaleString('id-ID');
                    ppnInput.value = formattedTotalHarga;
                    console.log("Calculated total price including PPN:", formattedTotalHarga);
                } else {
                    hargaInput.value = '';
                    ppnInput.value = '';
                    console.log("Role not selected, price not set");
                }
            }

            if (idRuangan) {
                fetch(`/get-ruangan-details?id_ruangan=${idRuangan}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Fetched data:", data);
                        lokasiInput.value = data.lokasi;
                        updatePrice(data); // Mengisi harga dan lokasi saat pertama kali data di-fetch

                        // Pasang event listener untuk mengupdate harga saat role berubah
                        if (origin === 'detailRuangan') {
                            document.getElementById('role').addEventListener('change', function() {
                                fetchRuanganDetails(); // Refresh seluruh fungsi saat role berubah
                            });
                        }
                    })
                    .catch(error => console.error('Error fetching ruangan details:', error));
            } else {
                lokasiInput.value = '';
                hargaInput.value = '';
                ppnInput.value = '';
                console.log("No ruangan selected, clearing inputs");
            }
        }

        function adjustParticipantLimits() {
            const origin = "{{ $origin }}"; // Asumsi variabel ini dikirim dari controller
            let select, min, max;

            if (origin === 'detailRuangan') {
                // Handle case where the room is pre-selected
                select = document.querySelector('input[name="id_ruangan"]');
                if (select) {
                    min = parseInt(select.getAttribute("data-min")) || 0;
                    max = parseInt(select.getAttribute("data-max")) || 0;
                } else {
                    console.error("Ruangan input not found or missing attributes");
                    return;
                }
            } else {
                // Handle case where the user selects the room
                select = document.getElementById("id_ruangan");
                if (select && select.options[select.selectedIndex]) {
                    const selectedOption = select.options[select.selectedIndex];
                    min = parseInt(selectedOption.getAttribute("data-min")) || 0;
                    max = parseInt(selectedOption.getAttribute("data-max")) || 0;
                } else {
                    console.error("Ruangan select not found or no option selected");
                    return;
                }
            }

            const pesertaSelect = document.getElementById("peserta");
            if (pesertaSelect) {
                // Clear existing options
                pesertaSelect.innerHTML = '<option selected disabled value="">Pilih jumlah peserta</option>';

                // Populate new options based on selected room's capacity
                for (let i = min; i <= max; i++) {
                    const option = document.createElement("option");
                    option.value = i;
                    option.text = i;
                    pesertaSelect.appendChild(option);
                }

                // Display validation message based on room capacity
                const feedback = pesertaSelect.nextElementSibling;
                if (feedback) {
                    feedback.textContent = "Masukkan Jumlah Peserta antara " + min + " dan " + max + "!";
                }
            } else {
                console.error("Peserta select element not found");
            }

            // Initial check for submit button state
            validateParticipantInput();
        }

        function validateParticipantInput() {
            var pesertaSelect = document.getElementById("peserta");
            var submitBtn = document.getElementById("submitBtn");
            var value = parseInt(pesertaSelect.value);

            if (!isNaN(value) && pesertaSelect.selectedIndex > 0) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }

        function showConfirmationModal(event) {
            event.preventDefault();
            //const invoiceNumber = document.getElementById('invoice').value;
            const namaPeminjam = document.getElementById('nama_peminjam').value;
            const nomorInduk = document.getElementById('nomor_induk').value;
            const nomorTelepon = document.getElementById('nomor_telepon').value;
            const status = document.getElementById('role').value;
            const lokasi = document.getElementById('lokasi').value;
            const jumlahPeserta = document.getElementById('peserta').value;
            const tanggalMulai = document.getElementById('tanggal_mulai').value;
            const jamMulai = document.getElementById('jam_mulai').value;
            const harga = document.getElementById('harga_ruangan').value;
            const keterangan = document.getElementById('keterangan').value;

            let namaRuangan; // Mendefinisikan variabel di luar blok if-else

            const origin = "{{ $origin }}";
            if (origin === 'detailRuangan') {
                namaRuangan = document.querySelector('input[name="nama_ruangan"]').value;
                console.log("Nama Ruangan Dari Detail Ruangan:", namaRuangan);
            } else {
                namaRuangan = document.getElementById('id_ruangan').selectedOptions[0].text;
                console.log("Nama Ruangan Tidak Dari Detail Ruangan:", namaRuangan);
            }

            // Menentukan nilai tanggal selesai dan jam selesai berdasarkan pilihan radio button
            if (status === 'Mahasiswa' || status === 'Umum') { // Per Jam
                const durasi = document.getElementById('durasi').value;
                const durasiMenit = parseInt(durasi.split(':')[0]) * 60 + parseInt(durasi.split(':')[1]);
                const jamMulaiDate = new Date(`1970-01-01T${jamMulai}:00`);
                const jamSelesaiDate = new Date(jamMulaiDate.getTime() + durasiMenit * 60000);
                const jamSelesaiFormatted = jamSelesaiDate.toTimeString().split(' ')[0].substring(0, 5);

                document.getElementById('confirm_tanggal_selesai').innerText = convertToDisplayFormat(
                    tanggalMulai); // Tanggal selesai sama dengan tanggal mulai
                document.getElementById('confirm_jam_selesai').innerText =
                    jamSelesaiFormatted; // Jam selesai dihitung dari jam mulai + durasi
            } else if (status === 'Pegawai') { // Per Hari
                const jamSelesai = document.getElementById('jam_selesai').value;
                const tanggalSelesai = document.getElementById('tanggal_selesai').value;

                document.getElementById('confirm_tanggal_selesai').innerText = convertToDisplayFormat(
                    tanggalSelesai); // Tanggal selesai sesuai input
                document.getElementById('confirm_jam_selesai').innerText = jamSelesai; // Jam selesai sesuai input
            }

            // Debugging logs
            console.log("Selected status:", status);
            console.log("Input Harga:", harga);

            const cleanedHarga = harga.replace(/[^\d]/g, '');
            var hargaAwal = parseFloat(cleanedHarga);
            var hargaDenganPPN = hargaAwal + (hargaAwal * 0.11) + 2500;
            var priceAkhir;

            if (status === 'Mahasiswa' || status === 'Umum') {
                priceAkhir = 'Rp ' + hargaDenganPPN.toLocaleString('id-ID');
            } else {
                priceAkhir = 'Rp 0';
            }

            // console.log("Final price:", priceAkhir);

            //document.getElementById('confirm_invoice').innerText = invoiceNumber;
            document.getElementById('confirm_nama_peminjam').innerText = namaPeminjam;
            document.getElementById('confirm_nama_ruangan').innerText = namaRuangan;
            document.getElementById('confirm_status').innerText = status;
            document.getElementById('confirm_nomor_induk').innerText = nomorInduk;
            document.getElementById('confirm_nomor_telepon').innerText = nomorTelepon;
            document.getElementById('confirm_lokasi').innerText = lokasi;
            document.getElementById('confirm_jumlah_peserta').innerText = jumlahPeserta;
            document.getElementById('confirm_tanggal_mulai').innerText = convertToDisplayFormat(tanggalMulai);
            document.getElementById('confirm_jam_mulai').innerText = jamMulai;
            document.getElementById('confirm_harga').innerText = 'Rp ' + hargaAwal.toLocaleString('id-ID');
            document.getElementById('confirm_harga_dengan_ppn').innerText = priceAkhir;
            document.getElementById('confirm_keterangan').innerText = keterangan;

            $('#confirmationModal').modal({
                backdrop: 'static',
                keyboard: false
            }).modal('show');
        }

        function handleRoleChange() {
            const origin = "{{ $origin }}";  // Asumsi variabel ini dikirim dari controller
            const role = document.getElementById('role').value;
            const ruanganSelect = document.getElementById('id_ruangan');
            const nomorIndukDiv = document.getElementById('nomorIndukDiv');
            const nomorIndukInput = document.getElementById('nomor_induk');

            if (origin !== 'detailRuangan') {
                // Enable ruangan select if a valid role is selected
                if (role) {
                    ruanganSelect.removeAttribute('disabled');
                } else {
                    ruanganSelect.setAttribute('disabled', true);
                }
            }

            // Display or hide nomorIndukDiv based on the selected role
            if (role === 'Pegawai' || role === 'Mahasiswa') {
                nomorIndukDiv.style.display = 'block';
                nomorIndukInput.value = ''; // Clear the input value
                nomorIndukInput.required = true; // Make the input required
            } else {
                nomorIndukDiv.style.display = 'none';
                nomorIndukInput.value = '0'; // Set the default value to 0
                nomorIndukInput.required = false; // Make the input not required
            }

            // Call additional functions like filterRuanganOptions()
            filterRuanganOptions();
        }
    </script>

@endsection
