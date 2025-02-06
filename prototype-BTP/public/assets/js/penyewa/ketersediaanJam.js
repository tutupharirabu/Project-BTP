$(document).ready(function() {
    $('#role').change(function() {
        updateFormContent();
    });
});

function updateFormContent() {
    const role = $('#role').val();
    if (role === 'Pegawai') {
        showPerHariForm();
    } else if (role === 'Mahasiswa' || role === 'Umum') {
        showPerJamForm();
    }
}

function showPerJamForm() {
    $('#form-content').html(`
    <div class="row">
        <div class="col-12">
            <label for="tanggal_mulai" class="form-label text-color">Tanggal Mulai Penyewaan</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="date form-control border-color" required>
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
}

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

    $('#tanggal_mulai, #jam_mulai').on('change', function() {
        var tanggalMulai = $('#tanggal_mulai').val();
        var jamMulai = $('#jam_mulai').val();

        if (tanggalMulai) {
            $('#tanggal_selesai').prop('disabled', false);
        } else {
            $('#tanggal_selesai').prop('disabled', true);
        }

        if (jamMulai) {
            $('#jam_selesai').prop('disabled', false);
        } else {
            $('#jam_selesai').prop('disabled', true);
        }
    });
}
