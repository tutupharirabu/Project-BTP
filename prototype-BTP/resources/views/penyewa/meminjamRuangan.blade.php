@extends('penyewa.layouts.mainPenyewa')
@section('containPenyewa')
    <script type="text/javascript">
        $(function() {
            $('#datetimepicker1').datetimepicker();
        });
    </script>

    <div class="container-fluid mt-4">
        <!-- title -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="container mx-2">
                    <h4>Form Sewa Ruangan</h4>
                    <h4>
                    </h4>
                </div>
            </div>
        </div>

        <!-- value -->
        <div class="row justify-content-center mt-4">
            <div class="col-11">
                <div class="card border shadow shadow-md">
                    <div class="card-body">
                        <form action="/meminjamRuangan/posts" method="POST" class="form-valid" enctype="multipart/form-data">
                            @csrf
                            <!-- left from text field -->
                            <div class="row needs-validation">
                                <div class="col-5">
                                    <div class="col-md">
                                        <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                                        <input type="text" name="nama_peminjam" id="nama_peminjam"
                                            class="date form-control">
                                        <div class="invalid-feedback">
                                            Masukkan Nama Peminjam!
                                        </div>
                                    </div>
                                    {{-- <div class="col-md mt-4">
                                        <label for="ruang" class="form-label">Ruangan</label>
                                        <select name="id_ruangan" id="id_ruangan" class="form-select">
                                            <option selected disabled value="">Pilih ruangan</option>
                                            @foreach ($dataRuangan as $dr)
                                                <option value="{{ $dr->id_ruangan }}">{{ $dr->nama_ruangan }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Masukkan ruangan anda!
                                        </div>
                                    </div>
                                    <div class="col-md mt-4">
                                        <label for="lokasi" class="form-label">Lokasi</label>
                                        <input type="text" name="lokasi" id="lokasi" class="date form-control"
                                            @foreach ($dataRuangan as $dr)
                                                value="{{ $dr->lokasi }}" @endforeach
                                            disabled required>
                                        <div class="invalid-feedback">
                                            Masukkan Lokasi!
                                        </div>
                                    </div>
                                    <div class="col-md mt-3">
                                        <label for="harga_ruangan" class="form-label">Harga</label>
                                        <input type="text" name="harga_ruangan" id="harga_ruangan"
                                            class="date form-control"
                                            @foreach ($dataRuangan as $dr)
                                                value="{{ $dr->harga_ruangan }}" @endforeach
                                            disabled required>
                                        <div class="invalid-feedback">
                                            Masukkan Harga!
                                        </div>
                                    </div>
                                    <div class="col-md mt-3">
                                        <label for="jumlah" class="form-label">Jumlah Peserta</label>
                                        <input type="number" name="jumlah" id="peserta" class="date form-control"
                                            max="100" min="0" required>
                                        <div class="invalid-feedback">
                                            Masukkan Jumlah Peserta!
                                        </div>
                                    </div> --}}

                                    <div class="col-md mt-4">
                                        <label for="ruang" class="form-label">Ruangan</label>
                                        <select name="id_ruangan" id="id_ruangan" class="form-select"
                                            onchange="fetchRuanganDetails()">
                                            <option selected disabled value="">Pilih ruangan</option>
                                            @foreach ($dataRuangan as $dr)
                                                <option value="{{ $dr->id_ruangan }}">{{ $dr->nama_ruangan }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Masukkan ruangan anda!
                                        </div>
                                    </div>
                                    <div class="col-md mt-3">
                                        <label for="lokasi" class="form-label">Lokasi</label>
                                        <input type="text" name="lokasi" id="lokasi" class="date form-control"
                                            disabled required>
                                        <div class="invalid-feedback">
                                            Masukkan Lokasi!
                                        </div>
                                    </div>
                                    <div class="col-md mt-3">
                                        <label for="harga_ruangan" class="form-label">Harga</label>
                                        <input type="text" name="harga_ruangan" id="harga_ruangan"
                                            class="date form-control" disabled required>
                                        <div class="invalid-feedback">
                                            Masukkan Harga!
                                        </div>
                                    </div>
                                    <div class="col-md mt-3">
                                        <label for="jumlah" class="form-label">Jumlah Peserta</label>
                                        <input type="number" name="jumlah" id="peserta" class="date form-control"
                                            max="100" min="0" required>
                                        <div class="invalid-feedback">
                                            Masukkan Jumlah Peserta!
                                        </div>
                                    </div>

                                </div>
                                <!-- right form file -->
                                <div class="col">
                                    <div class="row">
                                        <div class="col-md ">
                                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai Peminjaman</label>
                                            <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                                class="date form-control" required>
                                            <div class="invalid-feedback">
                                                Masukkan Mulai Peminjaman!
                                            </div>
                                        </div>
                                        <div class="col-md col-3">
                                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai
                                                Peminjaman</label>
                                            <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                                class="date form-control" required>
                                            <div class="invalid-feedback">
                                                Masukkan Selesai Peminjaman!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md ">
                                            <label for="jam_mulai" class="form-label">Jam Mulai Peminjaman</label>
                                            <input type="time" name="jam_mulai" id="tanggal_mulai" class=" form-control"
                                                required>
                                            <div class="invalid-feedback">
                                                Masukkan Mulai Peminjaman!
                                            </div>
                                        </div>
                                        <div class="col-md col-3">
                                            <label for="jam_selesai" class="form-label">Jam Selesai Peminjaman</label>
                                            <input type="time" name="jam_selesai" id="jam_selesai" class=" form-control"
                                                required>
                                            <div class="invalid-feedback">
                                                Masukkan Selesai Peminjaman!
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md mt-4 ">
                                        {{-- <label for="namaPeminjam" class="form-label">Nama Peminjam</label>
                                        <input type="text" name="namaPeminjam" id="namaPeminjam"
                                            class="date form-control" required>
                                        <div class="invalid-feedback">
                                            Masukkan Nama Peminjam!
                                        </div> --}}
                                        <div class="form-group">
                                            <label for="keterangan" class="mb-2">Catatan</label>
                                            <textarea class="form-control" name="keterangan" id="keterangan" id="" rows="8"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md mt-4">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <h>Keterangan<br>*Harga Diatas belum termasuk PPN (sesuai dengan ketentuan regulasi yang berlaku)<br>**Harap
                    membaca <a href="https://www.google.co.id/webhp?hl=en">Syarat & ketentuan</a> yang berlaku</h>
            </div>
        </div>
    </div>
    <script>
        function fetchRuanganDetails() {
            const idRuangan = document.getElementById('id_ruangan').value;
            if (idRuangan) {
                fetch(`/get-ruangan-details?id_ruangan=${idRuangan}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('lokasi').value = data.lokasi;
                        document.getElementById('harga_ruangan').value = data.harga_ruangan;
                    })
                    .catch(error => console.error('Error fetching ruangan details:', error));
            }
        }
    </script>
@endsection
