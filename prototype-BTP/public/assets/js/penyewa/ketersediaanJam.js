$(document).ready(function () {
    // Helper untuk ambil role dan satuan sesuai asal (origin)
    function getCurrentRoleAndSatuan() {
        var origin = typeof window.origin !== "undefined" ? window.origin : "{{ $origin ?? '' }}";
        var role = $('#role').val() || '';
        var satuan = '';
        if (origin === 'detailRuangan') {
            satuan = $('#hidden_satuan').val() || $('input[name="hidden_satuan"]').val() || '';
        } else if ($('#id_ruangan').length) {
            satuan = $('#id_ruangan option:selected').data('satuan') || '';
        }
        return { role, satuan };
    }

    // Gantikan semua panggilan updateFormContent dengan versi ini!
    function refreshFormContent() {
        var { role, satuan } = getCurrentRoleAndSatuan();
        // Untuk debug:
        // console.log('[refreshFormContent]', { role, satuan });
        updateFormContent(role, satuan);
    }

    // Bind events menggunakan helper baru
    $('#role').on('change', refreshFormContent);
    if ($('#id_ruangan').length) {
        $('#id_ruangan').on('change', refreshFormContent);
    }
    // Untuk detailRuangan, juga panggil di page load
    if ($('input[name="id_ruangan"]').length) {
        refreshFormContent();
    }
});

function getRuanganNama() {
    // Untuk input hidden
    var nama = $('input[name="nama_ruangan"]').val();
    if (nama) return nama.toLowerCase();
    // Untuk select
    var selected = $('#id_ruangan option:selected');
    if (selected.length) return selected.text().toLowerCase();
    return '';
}

// Fungsi untuk ambil seluruh id ruangan group
function fetchGroupRuanganIds(idRuangan, callback) {
    $.get('/getGroupRuanganIds', { id_ruangan: idRuangan }, function (ids) {
        callback(ids); // ids = array id ruangan dalam group
    });
}

function applyFlatpickrBlockedDates() {
    // Dukung select atau input hidden
    var idRuangan = $('#id_ruangan').val() || $('input[name="id_ruangan"]').val();
    if (!idRuangan) {
        console.warn('applyFlatpickrBlockedDates: idRuangan not found');
        return;
    }

    $.get('/getUnavailableTanggal', { id_ruangan: idRuangan }, function (unavailableDates) {
        // Destroy jika sudah pernah di-init
        if ($('#tanggal_mulai').hasClass('flatpickr-input')) {
            $('#tanggal_mulai')[0]._flatpickr.destroy();
        }
        if ($('#tanggal_selesai').hasClass('flatpickr-input')) {
            $('#tanggal_selesai')[0]._flatpickr.destroy();
        }
        // Init Flatpickr untuk input tanggal mulai
        flatpickr("#tanggal_mulai", {
            dateFormat: "Y-m-d",
            disable: unavailableDates
        });
        // Init Flatpickr untuk input tanggal selesai (kalau ada)
        if ($('#tanggal_selesai').length > 0) {
            flatpickr("#tanggal_selesai", {
                dateFormat: "Y-m-d",
                disable: unavailableDates
            });
        }
    });
}

function applyFlatpickrCoworkingBlockedDates() {
    var idRuangan = $('#id_ruangan').val() || $('input[name="id_ruangan"]').val();
    if (!idRuangan) return;

    fetchGroupRuanganIds(idRuangan, function (groupIds) {
        $.get('/getCoworkingBlockedDates', { id_ruangan: groupIds }, function (blockedDates) {
            if ($('#tanggal_mulai').hasClass('flatpickr-input')) {
                $('#tanggal_mulai')[0]._flatpickr.destroy();
            }
            flatpickr("#tanggal_mulai", {
                dateFormat: "Y-m-d",
                disable: blockedDates
            });
        });
    });
}

function applyFlatpickrCoworkingBlockedDatesForBulan() {
    var idRuangan = $('#id_ruangan').val() || $('input[name="id_ruangan"]').val();
    if (!idRuangan) return;

    // Ambil semua id ruangan dalam group dulu
    fetchGroupRuanganIds(idRuangan, function (groupIds) {
        $.get('/getCoworkingBlockedStartDatesForBulan', { id_ruangan: groupIds }, function (blockedDates) {
            if ($('#tanggal_mulai').hasClass('flatpickr-input')) {
                $('#tanggal_mulai')[0]._flatpickr.destroy();
            }
            flatpickr("#tanggal_mulai", {
                dateFormat: "Y-m-d",
                disable: blockedDates
            });
        });
    });
}

function applyFlatpickrPrivateOfficeBlockedDates() {
    var idRuangan = $('#id_ruangan').val() || $('input[name="id_ruangan"]').val();
    if (!idRuangan) return;

    // Endpoint harus return array tanggal yang sudah terbook (sudah ada peminjaman disetujui dengan rentang overlap)
    $.get('/getPrivateOfficeBlockedDates', { id_ruangan: idRuangan }, function (blockedDates) {
        if ($('#tanggal_mulai').hasClass('flatpickr-input')) {
            $('#tanggal_mulai')[0]._flatpickr.destroy();
        }
        flatpickr("#tanggal_mulai", {
            dateFormat: "Y-m-d",
            disable: blockedDates
        });
    });
}

function updateFormContent(role, satuan) {
    // Cek keduanya sudah ada
    if (!role || !satuan) {
        $('#form-content').html('');
        return;
    }

    // Umum/Mahasiswa + Seat/Hari : form tanggal mulai & selesai saja
    if (
        (role === 'Mahasiswa' || role === 'Umum') &&
        (satuan === 'Seat / Hari') &&
        getRuanganNama().includes('coworking')
    ) {
        $('#form-content').html(`
            <div class="row">
                <div class="col-12">
                    <label for="tanggal_mulai" class="form-label text-color">Tanggal Mulai Penyewaan</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="date form-control border-color" required placeholder="yyyy-mm-dd">
                    <div class="invalid-feedback">Masukkan Tanggal Mulai Penyewaan!</div>
                </div>
                <!-- Hidden input untuk tanggal_selesai (diisi otomatis) -->
                <input type="hidden" name="tanggal_selesai" id="tanggal_selesai">
                <input type="hidden" name="jam_mulai" id="jam_mulai" value="08:00">
                <input type="hidden" name="jam_selesai" id="jam_selesai" value="22:00">
            </div>
        `);

        $('#form-content').on('change', '#tanggal_mulai', function () {
            var tanggalMulai = $(this).val();
            $('#tanggal_selesai').val(tanggalMulai);
        });

        applyFlatpickrCoworkingBlockedDates();
        return;
    }

    // Umum/Mahasiswa + Coworking + Seat/Bulan: form tanggal mulai & pilihan bulan (1-12)
    if (
        (role === 'Mahasiswa' || role === 'Umum') &&
        satuan === 'Seat / Bulan' &&
        getRuanganNama().includes('coworking')
    ) {
        $('#form-content').html(`
            <div class="row">
                <div class="col-12">
                    <label for="tanggal_mulai" class="form-label text-color">Tanggal Mulai Penyewaan</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="date form-control border-color" required placeholder="yyyy-mm-dd">
                    <div class="invalid-feedback">Masukkan Tanggal Mulai Penyewaan!</div>
                </div>
                <!-- Dropdown di-hide/otomatis jadi value 1 -->
                <input type="hidden" name="durasi_bulan" id="durasi_bulan" value="1">
                <input type="hidden" name="tanggal_selesai" id="tanggal_selesai">
                <input type="hidden" name="jam_mulai" id="jam_mulai" value="08:00">
                <input type="hidden" name="jam_selesai" id="jam_selesai" value="22:00">
            </div>
        `);

        function updateTanggalSelesai() {
            var tanggalMulai = $('#tanggal_mulai').val();
            var bulan = 1;
            if (tanggalMulai && bulan) {
                var dateObj = new Date(tanggalMulai + 'T08:00:00');
                dateObj.setMonth(dateObj.getMonth() + bulan);
                dateObj.setDate(dateObj.getDate() - 1);
                var tglSelesai = dateObj.toISOString().slice(0, 10);
                $('#tanggal_selesai').val(tglSelesai);
            } else {
                $('#tanggal_selesai').val('');
            }
        }
        $('#form-content').on('change', '#tanggal_mulai', updateTanggalSelesai);

        // Ini yang penting, panggil flatpickr khusus coworking seat/bulan!
        applyFlatpickrCoworkingBlockedDatesForBulan();

        return;
    }

    // Umum/Mahasiswa + Private + Seat/Bulan: form tanggal mulai & pilihan bulan (1-12)
    if (
        (role === 'Mahasiswa' || role === 'Umum') &&
        satuan === 'Seat / Bulan' &&
        getRuanganNama().includes('private')
    ) {
        $('#form-content').html(`
            <div class="row">
                <div class="col-12">
                    <label for="tanggal_mulai" class="form-label text-color">Tanggal Mulai Penyewaan</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="date form-control border-color" required placeholder="yyyy-mm-dd">
                    <div class="invalid-feedback">Masukkan Tanggal Mulai Penyewaan!</div>
                </div>
                <div class="col-12 mt-4">
                    <label for="durasi_bulan" class="form-label text-color">Durasi Penyewaan (Bulan)</label>
                    <select name="durasi_bulan" id="durasi_bulan" class="form-control border-color" required>
                        ${[...Array(12)].map((_, i) => `<option value="${i + 1}">${i + 1} Bulan</option>`).join('')}
                    </select>
                    <div class="invalid-feedback">Masukkan Durasi Sewa!</div>
                </div>
                <input type="hidden" name="tanggal_selesai" id="tanggal_selesai">
                <input type="hidden" name="jam_mulai" id="jam_mulai" value="08:00">
                <input type="hidden" name="jam_selesai" id="jam_selesai" value="22:00">
            </div>
        `);

        // Isi tanggal_selesai setiap kali tanggal_mulai atau durasi berubah
        function updateTanggalSelesai() {
            var tanggalMulai = $('#tanggal_mulai').val();
            var bulan = parseInt($('#durasi_bulan').val());
            if (tanggalMulai && bulan) {
                // Kalkulasi tanggal selesai (pakai JS Date add months, jam 22:00)
                var dateObj = new Date(tanggalMulai + 'T08:00:00'); // mulai jam 8
                dateObj.setMonth(dateObj.getMonth() + bulan);
                // Kurangi 1 hari agar selesai tepat sebelum jam 22:00 di hari terakhir bulan ke-N
                dateObj.setDate(dateObj.getDate() - 1);
                var tglSelesai = dateObj.toISOString().slice(0, 10);
                $('#tanggal_selesai').val(tglSelesai);
            } else {
                $('#tanggal_selesai').val('');
            }
        }

        $('#form-content').on('change', '#tanggal_mulai, #durasi_bulan', updateTanggalSelesai);

        // Pastikan tanggal mulai tidak overlap booking lain (block pakai flatpickr)
        applyFlatpickrPrivateOfficeBlockedDates();

        return;
    }

    // Pegawai, tampilkan form per hari
    if (role === 'Pegawai') {
        showPerHariForm();
        return;
    }

    // Umum/Mahasiswa + Halfday/4 Jam: tampilkan form per jam (khusus 08/13/18)
    if ((role === 'Mahasiswa' || role === 'Umum') && satuan === 'Halfday / 4 Jam') {
        showPerJamForm();
        return;
    }

    // Default: kosongkan (atau tampilkan pesan)
    $('#form-content').html('');
}

function showPerJamForm() {
    $('#form-content').html(`
        <div class="row">
            <div class="col-12">
                <label for="tanggal_mulai" class="form-label text-color">Tanggal Mulai Penyewaan</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="date form-control border-color" required placeholder="yyyy-mm-dd">
                <div class="invalid-feedback">Masukkan Tanggal Mulai Penyewaan!</div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="jam_mulai" class="form-label text-color">Jam Mulai Penyewaan</label>
                <select name="jam_mulai" id="jam_mulai" class="form-control border-color" required>
                    <option value="">Pilih Jam Mulai Penyewaan</option>
                    <option value="08:00">08:00</option>
                    <option value="13:00">13:00</option>
                    <option value="18:00">18:00</option>
                </select>
                <div class="invalid-feedback">Masukkan Jam Mulai Peminjaman!</div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="durasi" class="form-label text-color">Durasi Penyewaan</label>
                <select name="durasi" id="durasi" class="form-control border-color" disabled>
                    <option value="04:00">240 Menit</option>
                </select>
                <div class="invalid-feedback">Masukkan Durasi Peminjaman!</div>
            </div>
        </div>
    `);

    // Setelah render form, tambahkan event handler:
    $('#form-content').on('change', '#tanggal_mulai', function () {
        var tanggal = $(this).val();
        var idRuangan = $('#id_ruangan').val();
        if (!tanggal || !idRuangan) return;

        // PATCH: Gunakan endpoint khusus Halfday / 4 Jam
        $.get('/getAvailableJamMulaiHalfday', { id_ruangan: idRuangan, tanggal: tanggal }, function (validJamMulai) {
            // Reset semua option
            $('#jam_mulai option').each(function () {
                const jamOpt = $(this).val();
                // Biarkan placeholder tetap enabled
                if (!jamOpt) return;
                // Disable jika TIDAK ada di list jam yang valid
                $(this).prop('disabled', !validJamMulai.includes(jamOpt));
            });
            // Jika option terpilih jadi disabled, reset value
            if ($('#jam_mulai option:selected').prop('disabled')) {
                $('#jam_mulai').val('');
            }
        });
    });

    applyFlatpickrBlockedDates();
}

function showPerHariForm() {
    $('#form-content').html(`
        <div class="row">
            <div class="col-12">
                <label for="tanggal_mulai" class="form-label text-color">Tanggal Mulai Penyewaan</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="date form-control border-color" required placeholder="yyyy-mm-dd">
                <div class="invalid-feedback">Masukkan Tanggal Mulai Penyewaan!</div>
            </div>
            <div class="col-12 mt-4">
                <label for="tanggal_selesai" class="form-label text-color">Tanggal Selesai Penyewaan</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="date form-control border-color" required placeholder="yyyy-mm-dd" disabled>
                <div class="invalid-feedback">Masukkan Tanggal Selesai Penyewaan!</div>
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
                    <option value="21:30">21:30</option>
                    <option value="22:00">22:00</option>
                </select>
                <div class="invalid-feedback">Masukkan Jam Selesai Peminjaman!</div>
            </div>
        </div>
    `);

    $('#form-content').on('change', '#tanggal_mulai', function () {
        var tanggal = $('#tanggal_mulai').val();
        var idRuangan = $('#id_ruangan').val();
        if (!tanggal || !idRuangan) return;

        $.get('/getUnavailableJam', { id_ruangan: idRuangan, tanggal: tanggal }, function (unavailableJam) {
            // Reset semua jam mulai
            $('#jam_mulai option').each(function () {
                $(this).prop('disabled', false).show();
            });

            // Disable/hide jam mulai yang sudah tidak available
            unavailableJam.forEach(function (jam) {
                $('#jam_mulai option').each(function () {
                    if ($(this).val() === jam) {
                        $(this).prop('disabled', true);
                    }
                });
            });

            // Jika option terpilih jadi disabled, reset value
            if ($('#jam_mulai option:selected').prop('disabled')) {
                $('#jam_mulai').val('');
            }
        });
    });

    $('#form-content').on('change', '#tanggal_mulai, #tanggal_selesai, #jam_mulai', function () {
        var tanggalMulai = $('#tanggal_mulai').val();
        var tanggalSelesai = $('#tanggal_selesai').val();
        var jamMulai = $('#jam_mulai').val();
        var idRuangan = $('#id_ruangan').val() || $('input[name="id_ruangan"]').val();

        // Enable tanggal selesai jika tanggal mulai sudah dipilih
        $('#tanggal_selesai').prop('disabled', !tanggalMulai);

        // Enable jam selesai jika jam mulai sudah dipilih
        $('#jam_selesai').prop('disabled', !jamMulai);

        // Reset jam selesai (supaya tidak ada value salah)
        $('#jam_selesai').val('');

        // Validasi jam_selesai
        if (tanggalMulai && tanggalSelesai && jamMulai && idRuangan) {
            // Ambil unavailable jam untuk tanggal_selesai (bukan tanggal_mulai!)
            $.get('/getUnavailableJam', { id_ruangan: idRuangan, tanggal: tanggalSelesai }, function (unavailableJam) {
                $('#jam_selesai option').each(function () {
                    var jamOption = $(this).val();
                    // Default: enable semua
                    var disable = false;

                    // Kasus tanggal_mulai === tanggal_selesai: jam_selesai tidak boleh <= jam_mulai dan tidak boleh unavailable
                    if (tanggalMulai === tanggalSelesai) {
                        if (jamOption && jamMulai && jamOption <= jamMulai) disable = true;
                    }
                    // Di kedua kasus, block juga jam_selesai jika unavailable di tanggal_selesai
                    if (jamOption && unavailableJam.includes(jamOption)) disable = true;

                    $(this).prop('disabled', disable);
                });
            });
        } else {
            // Enable semua jika data kurang
            $('#jam_selesai option').each(function () {
                $(this).prop('disabled', false);
            });
        }
    });

    applyFlatpickrBlockedDates();
}
