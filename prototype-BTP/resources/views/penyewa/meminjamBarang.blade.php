@extends('penyewa.layouts.mainPenyewa')
@section('containPenyewa')
    <script type="text/javascript">
        $(function() {
            $('#datetimepicker1').datetimepicker();
        });
    </script>
    <div class="d-flex align-items-center py-4 font-monospace">
        <div class="container-sm">
            <h1 class="text-center pb-3">Form Sewa Barang</h1>
            <form class="row g-3 needs-validation" action="{{ route('posts.daftarPenyewa') }}" method="POST" class="form-valid"
                enctype="multipart/form-data" novalidate>

                @csrf
                <div class="col-md-6">
                    <label for="barang" class="form-label">Barang</label>
                    <select name="barang" id="barang" class="form-select">
                        <option selected disabled value="">Pilih barang</option>
                        {{-- <option value="penyewa">Penyewa</option>
                            <option value="petugas">Petugas</option> --}}
                    </select>
                    <div class="invalid-feedback">
                        Masukkan barang anda!
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" class="date form-control" max="50"
                        min="0" placeholder="Masukkan Jumlah Barang" required>
                    <div class="invalid-feedback">
                        Masukkan Jumlah Barang!
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" name="startDate" id="startDate" class="date form-control"
                        placeholder="Masukkan tanggal mulai" required>
                    <div class="invalid-feedback">
                        Masukkan tanggal mulai!
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" name="endDate" id="endDate" class="date form-control"
                        placeholder="Masukkan tanggal selesai" required>
                    <div class="invalid-feedback">
                        Masukkan tanggal selesai!
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
