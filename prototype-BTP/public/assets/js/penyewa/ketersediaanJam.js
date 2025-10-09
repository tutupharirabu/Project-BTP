$(document).ready(function () {
    // Helper untuk ambil role dan satuan sesuai asal (origin)
    function getCurrentRoleAndSatuan() {
        var origin = typeof window.origin !== "undefined" ? window.origin : "{{ $origin ?? '' }}";
        var role = $('#role').val() || '';
        var satuan = '';

        if (origin === 'detailRuangan') {
            satuan = $('#hidden_satuan').val() || $('input[name="hidden_satuan"]').val() || '';
            // PENTING: Jangan fallback ke select!
            if (!satuan) {
                console.error('Satuan tidak ditemukan di hidden_satuan!');
            }
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

function setDateInputsMinToday() {
    var today = new Date().toISOString().split('T')[0];
    $('#form-content').find('input[type="date"]').each(function () {
        $(this).attr('min', today);
    });
}

const HALF_DAY_SESSIONS = [
    { start: '08:00', end: '12:00' },
    { start: '13:00', end: '17:00' },
    { start: '18:00', end: '22:00' },
];
let halfDayAvailableSessions = [];
let selectedHalfdaySessions = [];
let sessionSelectionRequired = false;

function formatLocalDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function timeToMinutes(timeStr) {
    const [hours, minutes] = timeStr.split(':').map(Number);
    return (hours * 60) + minutes;
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
        var config = {
            dateFormat: "Y-m-d",
            disable: unavailableDates,
            minDate: "today"
        };
        // Init Flatpickr untuk input tanggal mulai
        flatpickr("#tanggal_mulai", config);
        // Init Flatpickr untuk input tanggal selesai (kalau ada)
        if ($('#tanggal_selesai').length > 0) {
            flatpickr("#tanggal_selesai", config);
        }
        setDateInputsMinToday();
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
                disable: blockedDates,
                minDate: "today"
            });
            setDateInputsMinToday();
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
                disable: blockedDates,
                minDate: "today"
            });
            setDateInputsMinToday();
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
            disable: blockedDates,
            minDate: "today"
        });
        setDateInputsMinToday();
    });
}


function updateFormContent(role, satuan) {
    // Default: sesi halfday tidak wajib sampai form khususnya aktif
    sessionSelectionRequired = false;

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

        setDateInputsMinToday();

        $('#form-content').on('change', '#tanggal_mulai', function () {
            this.classList.remove('is-invalid');
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

        setDateInputsMinToday();

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
        $('#form-content').on('change', '#tanggal_mulai', function () {
            this.classList.remove('is-invalid');
            updateTanggalSelesai();
        });

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

        setDateInputsMinToday();

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

        $('#form-content').on('change', '#tanggal_mulai, #durasi_bulan', function (event) {
            if (event.target.id === 'tanggal_mulai') {
                event.target.classList.remove('is-invalid');
            }
            updateTanggalSelesai();
        });

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
    sessionSelectionRequired = true;
    selectedHalfdaySessions = [];
    halfDayAvailableSessions = [];

    $('#form-content').html(`
        <div class="row">
            <div class="col-12">
                <label for="tanggal_mulai" class="form-label text-color">Tanggal Mulai Penyewaan</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="date form-control border-color" required placeholder="yyyy-mm-dd">
                <div class="invalid-feedback">Masukkan Tanggal Mulai Penyewaan!</div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <label class="form-label text-color">Sesi Dipilih</label>
                <div id="selectedSessionsList" class="d-flex flex-wrap gap-2"></div>
                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="addSessionBtn">
                    <span class="fw-bold">+</span> Tambah Sesi
                </button>
                <div id="sessionPickerWrapper" class="d-flex flex-wrap gap-2 mt-2 d-none">
                    <select id="sessionPicker" class="form-select form-select-sm" aria-label="Pilih Jadwal Waktu"></select>
                    <button type="button" class="btn btn-success btn-sm" id="confirmAddSessionBtn">Tambah</button>
                    <button type="button" class="btn btn-outline-danger btn-sm" id="cancelAddSessionBtn">Batal</button>
                </div>
                <div class="mt-3">
                    <label class="form-label text-color">Pilihan Jam</label>
                    <div id="availableSessionsList" class="d-flex flex-column gap-1 small"></div>
                    <div id="availableSessionsFeedback" class="mt-2 small"></div>
                </div>
            </div>
        </div>
        <input type="hidden" name="jumlah_sesi" id="jumlah_sesi" value="0">
        <input type="hidden" name="jam_mulai" id="jam_mulai" required>
        <input type="hidden" name="durasi" id="durasi" value="04:00">
        <div id="selectedSessionsContainer"></div>
    `);

    setDateInputsMinToday();

    $('#form-content')
        .off('change', '#tanggal_mulai')
        .on('change', '#tanggal_mulai', function () {
            this.classList.remove('is-invalid');
            selectedHalfdaySessions = [];
            syncSelectedHalfdaySessions();
            loadAvailableHalfdaySessions();
        })
        .off('click', '#addSessionBtn')
        .on('click', '#addSessionBtn', function () {
            showSessionPicker();
        })
        .off('click', '#confirmAddSessionBtn')
        .on('click', '#confirmAddSessionBtn', function () {
            confirmAddSession();
        })
        .off('click', '#cancelAddSessionBtn')
        .on('click', '#cancelAddSessionBtn', function () {
            hideSessionPicker();
        })
        .off('click', '.remove-session-btn')
        .on('click', '.remove-session-btn', function () {
            var start = $(this).data('sessionStart');
            removeHalfdaySession(start);
        });

    loadAvailableHalfdaySessions();
    applyFlatpickrBlockedDates();
    updatePricingBySessionCount();
    validateParticipantInput();
}

function sessionOrderIndex(start) {
    return HALF_DAY_SESSIONS.findIndex(function (session) {
        return session.start === start;
    });
}

function sortSelectedSessions() {
    selectedHalfdaySessions.sort(function (a, b) {
        return sessionOrderIndex(a) - sessionOrderIndex(b);
    });
}

function loadAvailableHalfdaySessions() {
    var tanggal = $('#tanggal_mulai').val();
    var idRuangan = $('#id_ruangan').val() || $('input[name="id_ruangan"]').val();

    if (!tanggal || !idRuangan) {
        renderHalfdaySessionOptions([]);
        if (!tanggal) {
            syncSelectedHalfdaySessions({ skipFeedback: true });
            updateHalfdaySessionFeedback('Pilih tanggal terlebih dahulu untuk melihat sesi.', false);
        } else {
            syncSelectedHalfdaySessions();
        }
        return;
    }

    $.get('/getAvailableJamMulaiHalfday', { id_ruangan: idRuangan, tanggal: tanggal }, function (validJamMulai) {
        renderHalfdaySessionOptions(validJamMulai || [], tanggal);
        syncSelectedHalfdaySessions();
    });
}

function normalizeTimeString(value) {
    return String(value).slice(0, 5);
}

function renderHalfdaySessionOptions(validJamMulai, tanggalDipilih) {
    var availableSet = new Set((validJamMulai || []).map(normalizeTimeString));
    const todayLocal = formatLocalDate(new Date());
    const isTodaySelected = tanggalDipilih === todayLocal;
    const currentMinutes = new Date().getHours() * 60 + new Date().getMinutes();

    halfDayAvailableSessions = HALF_DAY_SESSIONS.map(function (session) {
        let status = 'unknown';
        let available = false;

        if (availableSet.has(session.start)) {
            status = 'available';
            available = true;
        } else if (tanggalDipilih) {
            status = 'booked';
        }

        if (isTodaySelected && available) {
            const sessionStartMinutes = timeToMinutes(session.start);
            if (sessionStartMinutes <= currentMinutes) {
                available = false;
                status = 'expired';
            }
        }

        return {
            start: session.start,
            end: session.end,
            available: available,
            status: status,
        };
    });
    selectedHalfdaySessions = selectedHalfdaySessions.filter(function (start) {
        return halfDayAvailableSessions.some(function (session) {
            return session.available && session.start === start;
        });
    });
    renderAvailableSessionsList();
    refreshSessionPickerOptions();
    renderSelectedSessionsList();
    updateHalfdaySessionFeedback();
}

function renderAvailableSessionsList() {
    var listEl = $('#availableSessionsList');
    if (!listEl.length) return;

    if (!halfDayAvailableSessions.length) {
        listEl.html('<span class="text-muted">Tidak ada informasi ketersediaan sesi.</span>');
        return;
    }

    var html = halfDayAvailableSessions
        .map(function (session) {
            var label = formatHalfdaySessionRange(session.start);
            if (selectedHalfdaySessions.includes(session.start)) {
                return `<div><span class="badge bg-secondary text-white me-2">Dipilih</span>${label}</div>`;
            }
            if (!session.available) {
                var badgeLabel = session.status === 'booked' ? 'Telah di Booking' : 'Tidak tersedia';
                return `<div><span class="badge bg-secondary me-2">${badgeLabel}</span>${label}</div>`;
            }
            return `<div><span class="badge bg-success text-white fw-semibold me-2">Tersedia</span>${label}</div>`;
        })
        .join('');

    listEl.html(html);
}

function refreshSessionPickerOptions() {
    var pickerWrapper = $('#sessionPickerWrapper');
    var picker = $('#sessionPicker');

    if (!picker.length) return;

    var remaining = halfDayAvailableSessions.filter(function (session) {
        return session.available && !selectedHalfdaySessions.includes(session.start);
    });

    picker.empty();
    picker.append('<option value="" selected disabled>Pilih jadwal</option>');
    remaining.forEach(function (session) {
        picker.append(`<option value="${session.start}">${formatHalfdaySessionRange(session.start)}</option>`);
    });

    $('#addSessionBtn').prop('disabled', remaining.length === 0);
    $('#addSessionBtn').toggleClass('btn-outline-success', remaining.length > 0);
    $('#addSessionBtn').toggleClass('btn-outline-secondary', remaining.length === 0);
    if (remaining.length === 0) {
        hideSessionPicker();
    }

    if (!$('#tanggal_mulai').val()) {
        $('#addSessionBtn').prop('disabled', true);
        $('#addSessionBtn').removeClass('btn-outline-success').addClass('btn-outline-secondary');
        hideSessionPicker();
    }
}

function showSessionPicker() {
    var remaining = halfDayAvailableSessions.filter(function (session) {
        return session.available && !selectedHalfdaySessions.includes(session.start);
    });

    if (!remaining.length) {
        updateHalfdaySessionFeedback('Semua sesi tersedia sudah dipilih.', false);
        return;
    }

    refreshSessionPickerOptions();
    $('#sessionPickerWrapper').removeClass('d-none');
}

function hideSessionPicker() {
    $('#sessionPickerWrapper').addClass('d-none');
    $('#sessionPicker').val('');
}

function confirmAddSession() {
    var picker = $('#sessionPicker');
    if (!picker.length) return;

    var selected = picker.val();
    if (!selected) {
        picker.focus();
        return;
    }

    if (!selectedHalfdaySessions.includes(selected)) {
        selectedHalfdaySessions.push(selected);
        sortSelectedSessions();
    }

    hideSessionPicker();
    renderSelectedSessionsList();
    renderAvailableSessionsList();
    syncSelectedHalfdaySessions();
}

function removeHalfdaySession(start) {
    selectedHalfdaySessions = selectedHalfdaySessions.filter(function (item) {
        return item !== start;
    });
    renderSelectedSessionsList();
    renderAvailableSessionsList();
    syncSelectedHalfdaySessions();
}

function renderSelectedSessionsList() {
    var listEl = $('#selectedSessionsList');
    if (!listEl.length) return;

    listEl.empty();

    if (!selectedHalfdaySessions.length) {
        listEl.append('<span class="text-muted">Belum ada sesi dipilih.</span>');
        return;
    }

    selectedHalfdaySessions.forEach(function (start) {
        var label = formatHalfdaySessionRange(start);
        listEl.append(`
            <span class="badge bg-success text-white d-flex align-items-center gap-2">
                ${label}
                <button type="button" class="btn btn-light btn-sm text-success px-2 py-0 border-0 remove-session-btn" data-session-start="${start}" aria-label="Hapus ${label}">&times;</button>
            </span>
        `);
    });
}

function syncSelectedHalfdaySessions(config) {
    config = config || {};
    var skipFeedback = !!config.skipFeedback;

    sortSelectedSessions();

    var container = $('#selectedSessionsContainer');
    if (container.length) {
        container.empty();
        selectedHalfdaySessions.forEach(function (value) {
            container.append('<input type="hidden" name="jam_mulai_sessions[]" value="' + value + '">');
        });
    }

    $('#jam_mulai').val(selectedHalfdaySessions[0] || '');
    $('#jumlah_sesi').val(selectedHalfdaySessions.length);

    refreshSessionPickerOptions();
    if (!skipFeedback) {
        updateHalfdaySessionFeedback();
    }
    updatePricingBySessionCount();
    validateParticipantInput();
}

function getSelectedHalfdaySessions() {
    return selectedHalfdaySessions.slice();
}

function updateHalfdaySessionFeedback(customMessage, isError) {
    var feedbackEl = $('#availableSessionsFeedback');
    if (!feedbackEl.length) return;

    var availableCount = halfDayAvailableSessions.filter(function (session) {
        return session.available;
    }).length;
    var selectedCount = selectedHalfdaySessions.length;

    var message = customMessage || '';
    feedbackEl.removeClass('text-danger text-success text-muted');

    if (customMessage) {
        feedbackEl
            .addClass(isError ? 'text-danger' : 'text-muted')
            .text(customMessage)
            .show();
        return;
    }

    if (!availableCount) {
        var hasDate = !!$('#tanggal_mulai').val();
        feedbackEl
            .addClass('text-danger')
            .text(hasDate ? 'Tidak ada sesi tersedia pada tanggal ini.' : 'Belum memilih tanggal.')
            .show();
        return;
    }

    if (!selectedCount) {
        feedbackEl
            .addClass('text-danger')
            .text('Belum memilih sesi.')
            .show();
        return;
    }

    var remaining = availableCount - selectedCount;
    feedbackEl
        .addClass(remaining === 0 ? 'text-success' : 'text-muted')
        .text(`Sesi terpilih ${selectedCount} dari ${availableCount} yang tersedia.`)
        .show();
}

function isSessionSelectionValid() {
    if (!sessionSelectionRequired) {
        return true;
    }

    updateHalfdaySessionFeedback();

    var availableCount = halfDayAvailableSessions.filter(function (session) {
        return session.available;
    }).length;

    if (!availableCount) {
        return false;
    }

    return selectedHalfdaySessions.length > 0;
}

function updatePricingBySessionCount() {
    var hargaInput = document.getElementById('harga_ruangan');
    var totalInput = document.getElementById('total_harga');
    if (!hargaInput || !totalInput) {
        return;
    }

    var perSessionBase = parseInt(hargaInput.dataset.perSession || hargaInput.dataset.basePrice || '0', 10);
    var perSessionTotal = parseInt(totalInput.dataset.perSession || totalInput.value || '0', 10);
    var selectedCount = selectedHalfdaySessions.length;
    var subtotal = perSessionBase * selectedCount;
    var total = perSessionTotal * selectedCount;

    hargaInput.value = 'Rp ' + (subtotal || 0).toLocaleString('id-ID');
    totalInput.value = String(Math.round(total || 0));
}

function calculateHalfdayEndTime(jamMulai) {
    if (!jamMulai) return '';
    var match = HALF_DAY_SESSIONS.find(function (session) {
        return session.start === jamMulai;
    });
    if (match) {
        return match.end;
    }
    var parts = jamMulai.split(':');
    var hour = parseInt(parts[0], 10);
    var minute = parseInt(parts[1] || '0', 10);
    hour += 4;
    if (hour >= 24) {
        hour = hour % 24;
    }
    return String(hour).padStart(2, '0') + ':' + String(minute).padStart(2, '0');
}

function formatHalfdaySessionRange(jamMulai) {
    var end = calculateHalfdayEndTime(jamMulai);
    return `${jamMulai} - ${end}`;
}

window.getSelectedHalfdaySessions = getSelectedHalfdaySessions;
window.formatHalfdaySessionRange = formatHalfdaySessionRange;

function showPerHariForm() {
    sessionSelectionRequired = false;

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
                    ${generateTimeOptions('08:00', '18:00')}
                </select>
                <div class="invalid-feedback">Masukkan Jam Mulai Peminjaman!</div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label for="jam_selesai" class="form-label text-color">Jam Selesai Penyewaan</label>
                <select name="jam_selesai" id="jam_selesai" class="form-control border-color" required disabled>
                    <option value="">Pilih Jam Selesai Penyewaan</option>
                    ${generateTimeOptions('08:00', '22:00')}
                </select>
                <div class="invalid-feedback">Masukkan Jam Selesai Peminjaman!</div>
            </div>
        </div>
    `);

    setDateInputsMinToday();
    $('#form-content').on('change', '#tanggal_mulai, #tanggal_selesai, #jam_mulai', function (event) {
        var tanggalMulai = $('#tanggal_mulai').val();
        var tanggalSelesai = $('#tanggal_selesai').val();
        var jamMulai = $('#jam_mulai').val();

        if (event.target.id === 'tanggal_mulai') {
            if (tanggalMulai) {
                $('#tanggal_mulai').removeClass('is-invalid');
                $('#tanggal_selesai').attr('min', tanggalMulai);
            } else {
                $('#tanggal_selesai').attr('min', null);
            }
        }

        if (event.target.id === 'tanggal_selesai' && tanggalSelesai) {
            $('#tanggal_selesai').removeClass('is-invalid');
        }

        // Enable tanggal selesai jika tanggal mulai sudah dipilih
        $('#tanggal_selesai').prop('disabled', !tanggalMulai);

        // Enable jam selesai jika jam mulai sudah dipilih
        $('#jam_selesai').prop('disabled', !jamMulai);
        if (jamMulai) {
            $('#jam_selesai option').each(function () {
                var value = $(this).val();
                if (!value) {
                    $(this).prop('disabled', false);
                    return;
                }
                $(this).prop('disabled', value <= jamMulai);
            });

            if ($('#jam_selesai option:selected').prop('disabled')) {
                $('#jam_selesai').val('');
            }
        } else {
            $('#jam_selesai option').prop('disabled', false);
            $('#jam_selesai').val('');
        }
    });

    $('#form-content').on('change', '#jam_selesai', function () {
        if ($(this).val()) {
            $(this).removeClass('is-invalid');
        }
    });
}

function generateTimeOptions(startTime, endTime) {
    var options = [];
    var start = timeToMinutes(startTime);
    var end = timeToMinutes(endTime);

    for (var minutes = start; minutes <= end; minutes += 30) {
        var hours = Math.floor(minutes / 60);
        var mins = minutes % 60;
        var value = String(hours).padStart(2, '0') + ':' + String(mins).padStart(2, '0');
        options.push(`<option value="${value}">${value}</option>`);
    }

    return options.join('');
}
