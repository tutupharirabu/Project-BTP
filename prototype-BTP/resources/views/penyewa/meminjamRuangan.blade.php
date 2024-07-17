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
                <h4>Form Sewa Ruangan</h4>
            </div>
        </div>
    </div>

    <!-- href ui -->
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="d-flex container my-2 mx-2">
                @if ($origin == 'dashboard')
                    <a href="/dashboardPenyewa" class="fw-bolder" style="color: #797979; font-size:12px;">Dashboard ></a>
                @elseif ($origin == 'detailRuangan')
                    <a href="/daftarRuanganPenyewa" class="fw-bolder" style="color: #797979; font-size:12px;">Daftar Ruangan > </a>
                    <a href="{{ route('detailRuanganPenyewa', ['id' => $ruangan->id_ruangan]) }}" class="fw-bolder" style="color: #797979; font-size:12px;">&nbsp;Detail Ruangan ></a>
                @endif
                <a href="" class="fw-bolder" style="color: #028391; font-size:12px;">&nbsp;Form Peminjaman Ruangan</a>
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
                                    <label for="nama_peminjam" class="form-label text-color">Nama Peminjam</label>
                                    <input type="text" name="nama_peminjam" id="nama_peminjam"
                                        class="date form-control border-color" required>
                                    <div class="invalid-feedback">
                                        Masukkan Nama Peminjam!
                                    </div>
                                </div>

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
                                                {{ $dr->nama_ruangan }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Masukkan ruangan anda!
                                    </div>
                                </div>

                                <div class="col-md mt-3">
                                    <label for="role" class="form-label text-color">Status</label>
                                    <select name="role" id="role" class="form-control border-color"
                                        onchange="fetchRuanganDetails()" required>
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="Pegawai">Pegawai</option>
                                        <option value="Mahasiswa">Mahasiswa</option>
                                        <option value="Umum">Umum</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Pilih Status!
                                    </div>
                                </div>

                                <div class="col-md mt-3">
                                    <label for="lokasi" class="form-label text-color">Lokasi</label>
                                    <input type="text" name="lokasi" id="lokasi"
                                        class="date form-control border-color" disabled required>
                                    <div class="invalid-feedback">
                                        Masukkan Lokasi!
                                    </div>
                                </div>

                                <div class="col-md mt-3">
                                    <label for="harga_ruangan" class="form-label text-color">Harga</label>
                                    <input type="text" name="harga_ruangan" id="harga_ruangan"
                                        class="date form-control border-color" disabled required>
                                    <div class="invalid-feedback">
                                        Masukkan Harga!
                                    </div>
                                </div>

                                <div class="col-md mt-3">
                                    <label for="jumlah" class="form-label text-color">Jumlah Peserta</label>
                                    <input type="number" name="jumlah" id="peserta"
                                        class="date form-control border-color" max="100" min="0" required>
                                    <div class="invalid-feedback">
                                        Masukkan Jumlah Peserta!
                                    </div>
                                </div>
                            </div>

                            <!-- right form file -->
                            <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7">
                                <div class="col-12 btn-group btn-group-md " role="group" style="">
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" value="per_jam" autocomplete="off" checked style="height:20px; width:20px;">
                                    <label class="btn btn-outline-black text-capitalize" for="btnradio1" style="font-size:13px;" >Per Jam</label>

                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" value="per_hari" autocomplete="off">
                                    <label class="btn btn-outline-black text-capitalize" for="btnradio2" style="font-size:13px;">Per Hari</label>
                                </div>

                                <div id="form-content">
                                    <!-- Konten untuk Per Jam akan dimuat di sini secara default -->
                                </div>

                                <div class="col-md mt-4">
                                    <div class="form-group">
                                        <label for="keterangan" class="mb-2 text-color">Catatan</label>
                                        <textarea class="form-control border-color" name="keterangan" id="keterangan" rows="8" maxlength="254"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md mt-4">
                            <div class="d-grid gap-2 d-flex justify-content-end">
                                <button type="submit"
                                    class="btn text-white button-style capitalize-first-letter">Ajukan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div>
                Keterangan<br>*Harga diatas belum termasuk PPN (sesuai dengan ketentuan regulasi yang
                berlaku)<br>**Harap
                membaca <a href="https://www.google.co.id/webhp?hl=en">syarat & ketentuan</a> yang berlaku

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
                    <label class="form-label text-color">Nama Peminjam</label>
                    <p id="confirm_nama_peminjam" name="nama_peminjam" class="bordered-text"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-color">Nama Ruangan</label>
                    <p id="confirm_nama_ruangan" name="id_ruangan" class="bordered-text"></p>
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
                    <p id="confirm_harga_dengan_ppn" class="bordered-text"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-color">Catatan Peminjaman</label>
                    <p id="confirm_keterangan" class="bordered-text"></p>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="confirm_agreement">
                    <label class="form-check-label" for="confirm_agreement" style="font-size: 10px; color: #717171;">
                        Saya telah membaca, mengerti, dan menyetujui syarat & ketentuan yang berlaku.
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-white capitalize-first-letter" data-bs-dismiss="modal"
                    style="height: 41px; background-color:#717171;font-size: 14px;">Batal</button>
                <button type="button" class="btn button-style text-white capitalize-first-letter"
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

@php
    Carbon\Carbon::setLocale('id');
@endphp

<!-- lihat Ketersediaan -->
<div class="modal fade" id="lihatKetersediaanModal" tabindex="-1" aria-labelledby="lihatKetersediaanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center align-items-center position-relative">
                <h5 class="modal-title mx-auto" id="lihatKetersediaanModalLabel">Ketersediaan Ruangan</h5>
                <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center flex-wrap" id="daysContainer">
                    <!-- Dynamic days content will be inserted here -->
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <div class="d-flex align-items-center mr-4">
                    <div class="mark-available"></div>
                    <p class="my-auto">Tersedia</p>
                </div>
                <div class="d-flex align-items-center">
                    <div class="mark-notavailable"></div>
                    <p class="my-auto">Tidak tersedia</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script type="text/javascript">
    (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    } else {
                        showConfirmationModal(event);
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()

    function fetchRuanganDetails() {
        const idRuangan = document.getElementById('id_ruangan').value;
        const role = document.getElementById('role').value;
        const hargaInput = document.getElementById('harga_ruangan');
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
            } else {
                hargaInput.value = '';
                console.log("Role not selected, price not set");
            }
        }

        if (idRuangan) {
            fetch(`/get-ruangan-details?id_ruangan=${idRuangan}`)
                .then(response => response.json())
                .then(data => {
                    console.log("Fetched data:", data);
                    lokasiInput.value = data.lokasi;
                    updatePrice(data);
                })
                .catch(error => console.error('Error fetching ruangan details:', error));
        } else {
            lokasiInput.value = '';
            hargaInput.value = '';
            console.log("No ruangan selected, clearing inputs");
        }
    }

    function adjustParticipantLimits() {
        var select = document.getElementById("id_ruangan");
        var pesertaInput = document.getElementById("peserta");

        var selectedOption = select.options[select.selectedIndex];
        var min = selectedOption.getAttribute("data-min");
        var max = selectedOption.getAttribute("data-max");

        pesertaInput.max = max;
        pesertaInput.min = min;
        pesertaInput.value = min; // Set the value to min to automatically fill the input

        // Display validation message based on room capacity
        var feedback = pesertaInput.nextElementSibling;
        feedback.textContent = "Masukkan Jumlah Peserta antara " + min + " dan " + max + "!";
    }

    document.getElementById('id_ruangan').addEventListener('change', adjustParticipantLimits);

    function showConfirmationModal(event) {
        event.preventDefault();
        const namaPeminjam = document.getElementById('nama_peminjam').value;
        const namaRuangan = document.getElementById('id_ruangan').selectedOptions[0].text;
        const status = document.getElementById('role').value;
        const lokasi = document.getElementById('lokasi').value;
        const jumlahPeserta = document.getElementById('peserta').value;
        const tanggalMulai = document.getElementById('tanggal_mulai').value;
        const jamMulai = document.getElementById('jam_mulai').value;
        const harga = document.getElementById('harga_ruangan').value;
        const keterangan = document.getElementById('keterangan').value;

        // Menentukan nilai tanggal selesai dan jam selesai berdasarkan pilihan radio button
        if (document.getElementById('btnradio1').checked) { // Per Jam
            const durasi = document.getElementById('durasi').value;
            const durasiMenit = parseInt(durasi.split(':')[0]) * 60 + parseInt(durasi.split(':')[1]);
            const jamMulaiDate = new Date(`1970-01-01T${jamMulai}:00`);
            const jamSelesaiDate = new Date(jamMulaiDate.getTime() + durasiMenit * 60000);
            const jamSelesaiFormatted = jamSelesaiDate.toTimeString().split(' ')[0].substring(0, 5);

            document.getElementById('confirm_tanggal_selesai').innerText = convertToDisplayFormat(tanggalMulai); // Tanggal selesai sama dengan tanggal mulai
            document.getElementById('confirm_jam_selesai').innerText = jamSelesaiFormatted; // Jam selesai dihitung dari jam mulai + durasi
        } else if (document.getElementById('btnradio2').checked) { // Per Hari
            const jamSelesai = document.getElementById('jam_selesai').value;
            const tanggalSelesai = document.getElementById('tanggal_selesai').value;

            document.getElementById('confirm_tanggal_selesai').innerText = convertToDisplayFormat(tanggalSelesai); // Tanggal selesai sesuai input
            document.getElementById('confirm_jam_selesai').innerText = jamSelesai; // Jam selesai sesuai input
        }

        // Debugging logs
        console.log("Selected status:", status);
        console.log("Input Harga:", harga);

        const cleanedHarga = harga.replace(/[^\d]/g, '');
        var hargaAwal = parseFloat(cleanedHarga);
        var hargaDenganPPN = hargaAwal + (hargaAwal * 0.11);
        var priceAkhir;

        if (status === 'Mahasiswa' || status === 'Umum') {
            priceAkhir = 'Rp ' + hargaDenganPPN.toLocaleString('id-ID');
        } else {
            priceAkhir = 'Rp 0';
        }

        console.log("Final price:", priceAkhir);

        document.getElementById('confirm_nama_peminjam').innerText = namaPeminjam;
        document.getElementById('confirm_nama_ruangan').innerText = namaRuangan;
        document.getElementById('confirm_status').innerText = status;
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

    function convertToDisplayFormat(dateStr) {
        const parts = dateStr.split('-');
        if (parts.length === 3) {
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        } else {
            console.error("Invalid date format:", dateStr);
            return dateStr;
        }
    }

    function toggleConfirmButton() {
        var confirmButton = document.getElementById('confirm_button');
        var checkbox = document.getElementById('confirm_agreement');
        confirmButton.disabled = !checkbox.checked;
    }

    document.getElementById('confirm_agreement').addEventListener('change', toggleConfirmButton);

    function showConfirmationPopup() {
        const checkbox = document.getElementById('confirm_agreement');

        if (!checkbox.checked) {
            alert('Anda harus menyetujui syarat & ketentuan sebelum melanjutkan.');
            return;
        }

        $('#confirmationModal').modal('hide'); // Hide the confirmation modal
        $('#confirmationPopupModal').modal({
            backdrop: 'static',
            keyboard: false
        }).modal('show'); // Show the confirmation popup modal
    }


    function confirmSubmission() {
        const rentalForm = document.getElementById('rentalForm');
        const formData = new FormData(rentalForm);

        // Temporarily disable form validation
        rentalForm.classList.remove('needs-validation');

        fetch(rentalForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                }
            })
            .then(response => {
                if (response.ok) {
                    rentalForm.reset();
                    $('#confirmationPopupModal').modal('hide');
                    $('#whatsappModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show'); // Show the WhatsApp modal
                } else {
                    console.error('Form submission error:', response);
                }
            })
            .catch(error => console.error('Error submitting form:', error))
            .finally(() => {
                // Re-enable form validation
                rentalForm.classList.add('needs-validation');
            });
    }

    document.getElementById('whatsappButton').addEventListener('click', function() {
        setTimeout(function() {
            window.location.href = "/dashboardPenyewa";
        }, 1000); // Adjust the timeout as needed
    });

    // Redirect to dashboardPenyewa when the WhatsApp modal is closed
    document.querySelector('.whatsapp-close-button').addEventListener('click', function() {
        window.location.href = "/dashboardPenyewa";
    });
</script>

<script>
    $(document).ready(function() {
        var tanggalMulai;

        $('#tanggal_mulai').on('change', function() {
            tanggalMulai = $(this).val();
            if (tanggalMulai) {
                $('#ketersediaanRow').show();
                updateDays(tanggalMulai);
            } else {
                $('#ketersediaanRow').hide();
            }
        });

        function updateDays(startDate) {
            $.ajax({
                url: '/get-ketersediaan-details',
                method: 'GET',
                data: {
                    tanggal_mulai: startDate
                },
                success: function(response) {
                    var daysContainer = $('#daysContainer');
                    daysContainer.empty();

                    var startDateObj = new Date(startDate);
                    for (var i = 0; i < 7; i++) {
                        var currentDateObj = new Date(startDateObj);
                        currentDateObj.setDate(startDateObj.getDate() + i);

                        var dayName = currentDateObj.toLocaleDateString('id-ID', { weekday: 'long' });
                        var dayDate = currentDateObj.toISOString().split('T')[0];

                        var hoursHtml = getHoursHtml(dayDate, response.usedTimeSlots);

                        var dayHtml = `
                            <div class="mx-2 text-center">
                                <div>
                                    <p class="day-name">${dayName}</p>
                                    <p class="font-weight-bold date-available">${currentDateObj.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })}</p>
                                </div>
                                <div>
                                    ${hoursHtml}
                                </div>
                            </div>
                        `;
                        daysContainer.append(dayHtml);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        function getHoursHtml(dayDate, usedTimeSlots) {
            var hoursHtml = '';
            var start = new Date(dayDate + 'T08:00:00');
            var end = new Date(dayDate + 'T17:30:00');

            while (start < end) {
                var hour = start.toTimeString().substring(0, 5);
                var isUsed = usedTimeSlots.some(function(slot) {
                    return slot.date === dayDate && slot.time === hour;
                });
                var className = isUsed ? 'cek-notavailable' : 'cek-available';
                hoursHtml += `<div class="${className}"><p>${hour}</p></div>`;
                start.setMinutes(start.getMinutes() + 30);
            }
            return hoursHtml;
        }

        // Fungsi untuk menampilkan form Per Jam
        function showPerJamForm() {
            $('#form-content').html(`
                <div class="row">
                    <div class="col-12">
                        <label for="tanggal_mulai" class="form-label text-color">Tanggal Mulai Penyewaan</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="date form-control border-color" required>
                        <div class="invalid-feedback">Masukkan Tanggal Mulai Penyewaan!</div>
                    </div>
                </div>
                <div class="row mt-4" id="ketersediaanRow" style="display: none;">
                    <div class="col-6 d-flex justify-content-center align-items-center">
                        <i class="material-symbols-outlined me-2">calendar_month</i>
                        <span>Ketersediaan Jam</span>
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button type="button" class="btn button-style-ketersediaan text-white capitalize-first-letter btn-md" data-bs-toggle="modal" data-bs-target="#lihatKetersediaanModal">
                            Lihat Ketersediaan
                        </button>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label for="jam_mulai" class="form-label text-color">Jam Mulai Penyewaan</label>
                        <select name="jam_mulai" id="jam_mulai" class="form-control border-color" required>
                            <option value="">Pilih Jam Mulai Penyewaan</option>
                            <option value="08:00">08:00</option>
                            <option value="08:30">08:30</option>
                            <option value="09:00">09:00</option>
                            <option value="09:30">09:30</option>
                            <option value="10:00">10:00</option>
                            <option value="10:30">10:30</option>
                            <option value="11:00">11:00</option>
                            <option value="11:30">11:30</option>
                            <option value="12:00">12:00</option>
                            <option value="12:30">12:30</option>
                            <option value="13:00">13:00</option>
                            <option value="13:30">13:30</option>
                            <option value="14:00">14:00</option>
                            <option value="14:30">14:30</option>
                            <option value="15:00">15:00</option>
                            <option value="15:30">15:30</option>
                            <option value="16:00">16:00</option>
                            <option value="16:30">16:30</option>
                            <option value="17:00">17:00</option>
                        </select>
                        <div class="invalid-feedback">Masukkan Jam Mulai Peminjaman!</div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label for="durasi" class="form-label text-color">Durasi Penyewaan</label>
                        <select name="durasi" id="durasi" class="form-control border-color" required disabled>
                            <option value="">Pilih Durasi Penyewaan</option>
                            <option value="00:30">30 Menit</option>
                            <option value="01:00">60 Menit</option>
                            <option value="01:30">90 Menit</option>
                            <option value="02:00">120 Menit</option>
                            <option value="02:30">150 Menit</option>
                            <option value="03:00">180 Menit</option>
                            <option value="03:30">210 Menit</option>
                            <option value="04:00">240 Menit</option>
                        </select>
                        <div class="invalid-feedback">Masukkan Durasi Peminjaman!</div>
                    </div>
                </div>
            `);

            if (tanggalMulai) {
                $('#tanggal_mulai').val(tanggalMulai).trigger('change');
            }

            $('#tanggal_mulai').on('change', function() {
                var tanggalMulai = $(this).val();
                if (tanggalMulai) {
                    $('#ketersediaanRow').show();
                    updateDays(tanggalMulai);
                } else {
                    $('#ketersediaanRow').hide();
                }
            });

            $('#jam_mulai').on('change', function() {
                var jamMulai = $(this).val();
                if (jamMulai) {
                    $('#durasi').prop('disabled', false);
                } else {
                    $('#durasi').prop('disabled', true);
                }
            });
        }

        // Fungsi untuk menampilkan form Seharian
        function showPerHariForm() {
            $('#form-content').html(`
                <div class="row">
                    <div class="col-12">
                        <label for="tanggal_mulai" class="form-label text-color">Tanggal Mulai Penyewaan</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="date form-control border-color" required>
                        <div class="invalid-feedback">Masukkan Tanggal Mulai Penyewaan!</div>
                    </div>
                    <div class="col-12 mt-4">
                        <label for="tanggal_selesai" class="form-label text-color">Tanggal Selesai Penyewaan</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="date form-control border-color" required disabled>
                        <div class="invalid-feedback">Masukkan Tanggal Selesai Penyewaan!</div>
                    </div>
                </div>
                <div class="row mt-4" id="ketersediaanRow" style="display: none;">
                    <div class="col-6 d-flex justify-content-center align-items-center">
                        <i class="material-symbols-outlined me-2">calendar_month</i>
                        <span>Ketersediaan Jam</span>
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button type="button" class="btn button-style-ketersediaan text-white capitalize-first-letter btn-md" data-bs-toggle="modal" data-bs-target="#lihatKetersediaanModal">
                            Lihat Ketersediaan
                        </button>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label for="jam_mulai" class="form-label text-color">Jam Mulai Penyewaan</label>
                        <select name="jam_mulai" id="jam_mulai" class="form-control border-color" required>
                            <option value="">Pilih Jam Mulai Penyewaan</option>
                            <option value="08:00">08:00</option>
                            <option value="08:30">08:30</option>
                            <option value="09:00">09:00</option>
                            <option value="09:30">09:30</option>
                            <option value="10:00">10:00</option>
                            <option value="10:30">10:30</option>
                            <option value="11:00">11:00</option>
                            <option value="11:30">11:30</option>
                            <option value="12:00">12:00</option>
                            <option value="12:30">12:30</option>
                            <option value="13:00">13:00</option>
                            <option value="13:30">13:30</option>
                            <option value="14:00">14:00</option>
                            <option value="14:30">14:30</option>
                            <option value="15:00">15:00</option>
                            <option value="15:30">15:30</option>
                            <option value="16:00">16:00</option>
                            <option value="16:30">16:30</option>
                            <option value="17:00">17:00</option>
                            <option value="17:30">17:30</option>
                            <option value="18:00">18:00</option>
                            <option value="18:30">18:30</option>
                            <option value="19:00">19:00</option>
                            <option value="19:30">19:30</option>
                            <option value="20:00">20:00</option>
                            <option value="20:30">20:30</option>
                            <option value="21:00">21:00</option>
                        </select>
                        <div class="invalid-feedback">Masukkan Jam Mulai Peminjaman!</div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label for="jam_selesai" class="form-label text-color">Jam Selesai Penyewaan</label>
                        <select name="jam_selesai" id="jam_selesai" class="form-control border-color" required disabled>
                            <option value="">Pilih Jam Selesai Penyewaan</option>
                            <option value="08:00">08:00</option>
                            <option value="08:30">08:30</option>
                            <option value="09:00">09:00</option>
                            <option value="09:30">09:30</option>
                            <option value="10:00">10:00</option>
                            <option value="10:30">10:30</option>
                            <option value="11:00">11:00</option>
                            <option value="11:30">11:30</option>
                            <option value="12:00">12:00</option>
                            <option value="12:30">12:30</option>
                            <option value="13:00">13:00</option>
                            <option value="13:30">13:30</option>
                            <option value="14:00">14:00</option>
                            <option value="14:30">14:30</option>
                            <option value="15:00">15:00</option>
                            <option value="15:30">15:30</option>
                            <option value="16:00">16:00</option>
                            <option value="16:30">16:30</option>
                            <option value="17:00">17:00</option>
                            <option value="17:30">17:30</option>
                            <option value="18:00">18:00</option>
                            <option value="18:30">18:30</option>
                            <option value="19:00">19:00</option>
                            <option value="19:30">19:30</option>
                            <option value="20:00">20:00</option>
                            <option value="20:30">20:30</option>
                            <option value="21:00">21:00</option>
                        </select>
                        <div class="invalid-feedback">Masukkan Durasi Peminjaman!</div>
                    </div>
                </div>
            `);

            if (tanggalMulai) {
                $('#tanggal_mulai').val(tanggalMulai).trigger('change');
            }

            $('#tanggal_mulai').on('change', function() {
                var tanggalMulai = $(this).val();
                if (tanggalMulai) {
                    $('#ketersediaanRow').show();
                    $('#tanggal_selesai').prop('disabled', false);
                    updateDays(tanggalMulai);
                } else {
                    $('#ketersediaanRow').hide();
                    $('#tanggal_selesai').prop('disabled', true);
                }
            });

            $('#jam_mulai').on('change', function() {
                var jamMulai = $(this).val();
                if (jamMulai) {
                    $('#jam_selesai').prop('disabled', false);
                } else {
                    $('#jam_selesai').prop('disabled', true);
                }
            });
        }

        // Set default form
        showPerJamForm();

        // Event listener untuk radio button
        $('input[name="btnradio"]').on('change', function() {
            if ($('#btnradio1').is(':checked')) {
                showPerJamForm();
            } else if ($('#btnradio2').is(':checked')) {
                showPerHariForm();
            }
        });

        // Event listener untuk tombol lihat ketersediaan
        $('#lihatKetersediaanButton').on('click', function(event) {
            var tanggalMulai = $('#tanggal_mulai').val();
            if (!tanggalMulai) {
                event.preventDefault();
                alert('Harap isi Tanggal Mulai Penyewaan terlebih dahulu.');
            }
        });
    });
</script>

@endsection
