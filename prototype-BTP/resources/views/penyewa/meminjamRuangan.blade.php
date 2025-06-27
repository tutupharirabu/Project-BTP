@extends('admin.layouts.mainAdmin')

@section('containAdmin')

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('assets/css/penyewa/form.css') }}">
        {{-- <link rel="stylesheet" href="style.css"> --}}
        <script defer src="https://umami-web-analytics.tutupharirabu.cloud/script.js" data-website-id="c5e87046-42e9-4b5f-b09e-acec20d1e4f6"></script>
    </head>

    <div class="container-fluid mt-4">
        <!-- title -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-8">
                <div class="container mx-2">
                    <h4>Peminjaman/Penyewaan Ruangan</h4>
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
                        <a href="{{ route('penyewa.detailRuangan', ['id' => $ruangan->id_ruangan]) }}" class="fw-bolder"
                            style="color: #797979; font-size:12px;">&nbsp;Detail Ruangan ></a>
                    @endif
                    <a href="" class="fw-bolder" style="color: #028391; font-size:12px;">&nbsp;Formulir Peminjaman/Penyewaan
                        Ruangan</a>
                </div>
            </div>
        </div>

        <!-- value -->
        <div class="row justify-content-center mt-2">
            <div class="col m-3">
                <div class="card border shadow shadow-md p-2">
                    <div class="card-body">
                        <form id="rentalForm" action="{{ route('penyewa.postFormPeminjaman') }}" method="POST"
                            class="needs-validation" enctype="multipart/form-data" novalidate>
                            @csrf
                            <div class="row">
                                <!-- left form text field -->
                                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                    <div class="col-md">
                                        <label for="nama_peminjam" class="form-label text-color">Nama Lengkap</label>
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
                                            <input type="hidden" id="hidden_satuan" name="hidden_satuan" value="{{ $ruangan->satuan }}">
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
                                    <div class="col-md mt-4" id="ktpUrlDiv">
                                        <label for="ktp_url" class="form-label text-color">Upload KTP
                                            (JPEG,PNG,JPG)</label>
                                        <input type="file" name="ktp_url" id="ktp_url"
                                            class="date form-control border-color" required>
                                        <div class="invalid-feedback">
                                            Upload KTP Anda!
                                        </div>
                                    </div>
                                    <br>
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
                    <h5 class="modal-title text-white" id="confirmationModalLabel">Rincian Peminjaman\Penyewaan Ruangan</h5>
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
                        <label class="form-label text-color">Tanggal Mulai Peminjaman\Penyewaan</label>
                        <p id="confirm_tanggal_mulai" name="tanggal_mulai" class="bordered-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Tanggal Selesai Peminjaman\Penyewaan</label>
                        <p id="confirm_tanggal_selesai" name="tanggal_selesai" class="bordered-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Jam Mulai Peminjaman\Penyewaan</label>
                        <p id="confirm_jam_mulai" name="jam_mulai" class="bordered-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-color">Jam Selesai Peminjaman\Penyewaan</label>
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
                        <label class="form-label text-color">Catatan Peminjaman\Penyewaan</label>
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

    <!-- Confirmation Popup Modal With Spinner -->
    <div class="modal fade" id="confirmationPopupModal" tabindex="-1" aria-labelledby="confirmationPopupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apakah Pemesanan untuk peminjaman/penyewaan sudah sesuai?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Pastikan pemesanan sesuai dengan permintaan Anda</p>

                    <!-- Spinner -->
                    <div id="spinner" class="d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memproses pemesanan...</p>
                    </div>

                    <!-- Buttons -->
                    <div id="confirmationButtons">
                        <button type="button" class="btn text-white text-capitalize btn-spacing font-btn width-btn"
                            style="background-color:#FF0000" data-bs-dismiss="modal">Tidak</button>
                        <button type="button" class="btn text-white text-capitalize font-btn width-btn"
                            style="background-color:#0DA200" onclick="confirmSubmission(event)">Ya</button>
                    </div>
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
        // console.log('hidden_satuan:', document.getElementById('hidden_satuan')?.value);
        document.addEventListener('DOMContentLoaded', function() {
            var origin = "{{ $origin }}"; // Variabel ini diterima dari controller

            // Attach event listener untuk perubahan role, hanya sekali!
            var roleEl = document.getElementById('role');
            if (roleEl) {
                roleEl.addEventListener('change', function() {
                    if (origin === 'detailRuangan') {
                        fetchRuanganDetails();
                        adjustParticipantLimits();
                    } else {
                        handleRoleChange();
                        // fetchRuanganDetails() dan adjustParticipantLimits() sudah dipanggil oleh onchange select di HTML jika bukan detailRuangan
                    }
                });
            }

            // Attach event listener untuk perubahan ruangan (id_ruangan) hanya jika tidak dari detailRuangan
            if (origin !== 'detailRuangan') {
                const idRuanganElement = document.getElementById('id_ruangan');
                if (idRuanganElement) {
                    idRuanganElement.addEventListener('change', function() {
                        fetchRuanganDetails();
                        adjustParticipantLimits();
                    });
                } else {
                    console.error("Element with id 'id_ruangan' not found");
                }
            }

            // Attach event listener untuk perubahan jumlah peserta
            const pesertaElement = document.getElementById('peserta');
            if (pesertaElement) {
                pesertaElement.addEventListener('change', validateParticipantInput);
            } else {
                console.error("Element with id 'peserta' not found");
            }

            // Initial fetch/load saat page pertama kali dibuka
            fetchRuanganDetails();
            adjustParticipantLimits();
        });

        function getCurrentSatuan() {
            const origin = "{{ $origin }}";
            if (origin === 'detailRuangan') {
                return document.getElementById('hidden_satuan')?.value || '';
            } else {
                const idRuanganElement = document.getElementById('id_ruangan');
                return idRuanganElement?.selectedOptions[0]?.getAttribute('data-satuan') || '';
            }
        }

        function fetchRuanganDetails() {
            const origin = "{{ $origin }}";
            let idRuangan;
            if (origin === 'detailRuangan') {
                const idRuanganElement = document.querySelector('input[name="id_ruangan"]');
                idRuangan = idRuanganElement ? idRuanganElement.value : null;
            } else {
                const idRuanganElement = document.getElementById('id_ruangan');
                idRuangan = idRuanganElement ? idRuanganElement.value : null;
            }
            if (!idRuangan) {
                document.getElementById('harga_ruangan').value = '';
                document.getElementById('total_harga').value = '';
                document.getElementById('lokasi').value = '';
                updateFormContent(document.getElementById('role').value, '');
                return;
            }

            const role = document.getElementById('role').value;
            const hargaInput = document.getElementById('harga_ruangan');
            const ppnInput = document.getElementById('total_harga');
            const lokasiInput = document.getElementById('lokasi');

            fetch(`/getRuanganDetails?id_ruangan=${idRuangan}`)
                .then(response => response.json())
                .then(data => {
                    console.log('DATA RUANGAN:', data); // Pastikan ada data.satuan
                    // Update lokasi
                    lokasiInput.value = data.lokasi || '';
                    // Harga (khusus Pegawai = 0, lainya pakai harga dari data)
                    let hargaRuangan = 0;
                    if (role === 'Pegawai') {
                        hargaRuangan = 0;
                    } else if (role === 'Mahasiswa' || role === 'Umum') {
                        hargaRuangan = parseInt(data.harga_ruangan) || 0;
                    }
                    hargaInput.value = 'Rp ' + hargaRuangan.toLocaleString('id-ID');
                    // Hitung harga total+PPN+2500 jika perlu
                    const ppnRate = 0.11;
                    let totalHarga = hargaRuangan + (hargaRuangan * ppnRate);
                    if (role === 'Mahasiswa' || role === 'Umum') {
                        totalHarga += 2500;
                    }
                    ppnInput.value = 'Rp ' + totalHarga.toLocaleString('id-ID');

                    // PENTING: Panggil updateFormContent hanya dengan satuan dari API!
                    const satuan = data.satuan || '';
                    updateFormContent(role, satuan);
                })
                .catch(error => {
                    hargaInput.value = '';
                    ppnInput.value = '';
                    lokasiInput.value = '';
                    updateFormContent(document.getElementById('role').value, '');
                    console.error('Error fetching ruangan details:', error);
                });
        }

        function adjustParticipantLimits() {
            const origin = "{{ $origin }}";
            let select, min, max;

            if (origin === 'detailRuangan') {
                select = document.querySelector('input[name="id_ruangan"]');
                min = select ? parseInt(select.getAttribute("data-min")) || 0 : 0;
                max = select ? parseInt(select.getAttribute("data-max")) || 0 : 0;
            } else {
                select = document.getElementById("id_ruangan");
                if (select && select.options[select.selectedIndex]) {
                    const selectedOption = select.options[select.selectedIndex];
                    min = parseInt(selectedOption.getAttribute("data-min")) || 0;
                    max = parseInt(selectedOption.getAttribute("data-max")) || 0;
                } else {
                    min = 0;
                    max = 0;
                }
            }
            const pesertaSelect = document.getElementById("peserta");
            if (pesertaSelect) {
                pesertaSelect.innerHTML = '<option selected disabled value="">Pilih jumlah peserta</option>';
                for (let i = min; i <= max; i++) {
                    const option = document.createElement("option");
                    option.value = i;
                    option.text = i;
                    pesertaSelect.appendChild(option);
                }
            }
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

            // Null-safe fetch helper
            function safeValue(selector, fallback = "") {
                const el = document.querySelector(selector);
                return el ? el.value : fallback;
            }

            let idRuanganElement = document.getElementById('id_ruangan');
            if (!idRuanganElement) {
                // Kalau tidak ada, kemungkinan input hidden, ambil by name (khusus detailRuangan)
                idRuanganElement = document.querySelector('input[name="id_ruangan"]');
            }
            const idRuangan = idRuanganElement ? idRuanganElement.value : null;

            const namaPeminjam = safeValue('#nama_peminjam');
            const nomorInduk = safeValue('#nomor_induk');
            const nomorTelepon = safeValue('#nomor_telepon');
            const status = safeValue('#role');
            const lokasi = safeValue('#lokasi');
            const jumlahPeserta = safeValue('#peserta');
            const tanggalMulai = safeValue('#tanggal_mulai');
            const jamMulai = safeValue('#jam_mulai');
            const harga = safeValue('#harga_ruangan');
            const keterangan = safeValue('#keterangan');

            let namaRuangan;
            const origin = "{{ $origin }}";
            if (origin === 'detailRuangan') {
                const namaRuanganInput = document.querySelector('input[name="nama_ruangan"]');
                namaRuangan = namaRuanganInput ? namaRuanganInput.value : "-";
            } else if (idRuanganElement && idRuanganElement.selectedOptions) {
                namaRuangan = idRuanganElement.selectedOptions[0].text;
            } else {
                namaRuangan = "-";
            }

            // Get tanggal selesai if available
            const tanggalSelesai = document.getElementById('tanggal_selesai') ? document.getElementById('tanggal_selesai').value : '';

            // Debug: log key fields
            // console.log({
            //     idRuangan, namaPeminjam, nomorInduk, nomorTelepon, status, lokasi, jumlahPeserta, tanggalMulai, jamMulai, harga, keterangan, namaRuangan, tanggalSelesai
            // });

            // Validate required fields, simple check
            if (!idRuangan || !namaPeminjam || !status || !lokasi || !jumlahPeserta || !tanggalMulai) {
                alert('Pastikan semua data penting sudah diisi!');
                return;
            }

            // Fetch satuan ruangan before showing modal
            if (idRuangan) {
                fetch(`/getRuanganDetails?id_ruangan=${idRuangan}`)
                    .then(response => response.json())
                    .then(data => {
                        const satuan = data.satuan;

                        let jamMulaiDisplay = jamMulai;
                        let jamSelesaiDisplay = '';
                        let tanggalMulaiDisplay = convertToDisplayFormat(tanggalMulai);
                        let tanggalSelesaiDisplay = tanggalSelesai ? convertToDisplayFormat(tanggalSelesai) : tanggalMulaiDisplay;

                        if (status === 'Mahasiswa' || status === 'Umum') {
                            if (satuan === 'Halfday / 4 Jam') {
                                // Per jam
                                const durasiEl = document.getElementById('durasi');
                                if (!durasiEl) {
                                    alert('Durasi wajib diisi!');
                                    return;
                                }
                                const durasi = durasiEl.value;
                                const durasiMenit = parseInt(durasi.split(':')[0]) * 60 + parseInt(durasi.split(':')[1]);
                                const jamMulaiDate = new Date(`1970-01-01T${jamMulai}:00`);
                                const jamSelesaiDate = new Date(jamMulaiDate.getTime() + durasiMenit * 60000);
                                jamSelesaiDisplay = jamSelesaiDate.toTimeString().split(' ')[0].substring(0, 5);
                                tanggalSelesaiDisplay = tanggalMulaiDisplay;
                            } else if (satuan === 'Seat / Hari' || satuan === 'Seat / Bulan') {
                                jamMulaiDisplay = '08:00';
                                jamSelesaiDisplay = '22:00';
                            }
                        } else if (status === 'Pegawai') {
                            jamMulaiDisplay = jamMulai;
                            jamSelesaiDisplay = safeValue('#jam_selesai');
                            tanggalSelesaiDisplay = tanggalSelesai ? convertToDisplayFormat(tanggalSelesai) : tanggalMulaiDisplay;
                        }

                        // Harga & keterangan
                        const cleanedHarga = harga.replace(/[^\d]/g, '');
                        var hargaAwal = parseFloat(cleanedHarga) || 0;
                        var hargaDenganPPN = hargaAwal + (hargaAwal * 0.11) + 2500;
                        var priceAkhir = (status === 'Mahasiswa' || status === 'Umum')
                            ? 'Rp ' + hargaDenganPPN.toLocaleString('id-ID')
                            : 'Rp 0';

                        // Set all modal fields, null-safe
                        const setText = (id, val) => { const el = document.getElementById(id); if (el) el.innerText = val; };
                        setText('confirm_nama_peminjam', namaPeminjam);
                        setText('confirm_nama_ruangan', namaRuangan);
                        setText('confirm_status', status);
                        setText('confirm_nomor_induk', nomorInduk);
                        setText('confirm_nomor_telepon', nomorTelepon);
                        setText('confirm_lokasi', lokasi);
                        setText('confirm_jumlah_peserta', jumlahPeserta);
                        setText('confirm_tanggal_mulai', tanggalMulaiDisplay);
                        setText('confirm_tanggal_selesai', tanggalSelesaiDisplay);
                        setText('confirm_jam_mulai', jamMulaiDisplay);
                        setText('confirm_jam_selesai', jamSelesaiDisplay);
                        setText('confirm_harga', 'Rp ' + hargaAwal.toLocaleString('id-ID'));
                        setText('confirm_harga_dengan_ppn', priceAkhir);
                        setText('confirm_keterangan', keterangan);

                        $('#confirmationModal').modal({
                            backdrop: 'static',
                            keyboard: false
                        }).modal('show');
                    })
                    .catch(error => {
                        console.error('Error fetching ruangan details:', error);
                        alert('Gagal mengambil detail ruangan!');
                    });
            }
        }

        function handleRoleChange() {
            const origin = "{{ $origin }}";
            const role = document.getElementById('role').value;
            const ruanganSelect = document.getElementById('id_ruangan');
            const nomorIndukDiv = document.getElementById('nomorIndukDiv');
            const nomorIndukInput = document.getElementById('nomor_induk');
            const ktpUrlDiv = document.getElementById('ktpUrlDiv');
            const ktpUrlInput = document.getElementById('ktp_url');

            if (origin !== 'detailRuangan') {
                if (role) {
                    ruanganSelect.removeAttribute('disabled');
                } else {
                    ruanganSelect.setAttribute('disabled', true);
                }
            }

            if (role === 'Pegawai' || role === 'Mahasiswa') {
                nomorIndukDiv.style.display = 'block';
                nomorIndukInput.value = '';
                nomorIndukInput.required = true;
            } else {
                nomorIndukDiv.style.display = 'none';
                nomorIndukInput.value = '0';
                nomorIndukInput.required = false;
            }

            if (role === 'Umum' || role === 'Mahasiswa') {
                ktpUrlDiv.style.display = 'block';
                ktpUrlInput.required = true;
            } else {
                ktpUrlDiv.style.display = 'none';
                ktpUrlInput.required = false;
            }

            // Panggil dengan preserveSelection true jika dari detailRuangan
            filterRuanganOptions(origin === 'detailRuangan');
        }
        
        window.onload = function () {
            // Untuk mencegah formData lama terpakai, selalu clear sessionStorage ketika halaman ini dimuat
            sessionStorage.removeItem('formData');

            const origin = "{{ $origin }}";
            const savedData = sessionStorage.getItem('formData'); // Ambil data dari sessionStorage (akan selalu null setelah removeItem, tapi biarkan untuk konsistensi jika di masa depan dipakai ulang)
            if (savedData) {
                const rentalForm = document.getElementById('rentalForm');
                const formData = JSON.parse(savedData);

                // Kosongkan field tertentu
                const fieldsToReset = [
                    'nama_peminjam',
                    'nomor_telepon',
                    'role',
                    'keterangan',
                    'id_ruangan',
                    'jumlah'
                ]; // Reset semuanya untuk semua origin (biar ga nyangkut id_ruangan)

                for (const key in formData) {
                    const input = rentalForm.querySelector(`[name="${key}"]`);
                    if (input) {
                        // Cek jika input file
                        if (input.type === 'file') {
                            input.value = '';
                            continue;
                        }
                        // Reset field yang perlu direset
                        if (!fieldsToReset.includes(key)) {
                            input.value = formData[key];
                        } else {
                            input.value = '';
                        }
                    }
                }
            }
        };
    </script>

@endsection
