@extends('admin.layouts.mainAdmin')

@section('containAdmin')
    <div class="container-fluid mt-4">
        <!-- title -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="container mx-2">
                    <h4>Tambah Ruangan<h4>
                </div>
            </div>
        </div>

        <!-- value -->
        <div class="row justify-content-center mt-4">
            <div class="col-11">
                <div class="card border shadow shadow-md">
                    <div class="card-body">
                        <form action="{{ route('posts.ruangan') }}" method="POST" enctype="multipart/form-data"
                            id="my-form">
                            @csrf
                            <!-- left from text field -->
                            <div class="row">
                                <div class="col-7">
                                    <div class="form-group row">
                                        <label for="id_ruangan" class="col-md-3 col-form-label text-md-left-right">ID
                                            Ruangan</label>
                                        <div class="col-md-7">
                                            <input type="text" id="id_ruangan" class="form-control" name="id_ruangan"
                                                disabled>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama_ruangan" class="col-md-3 col-form-label text-md-right">Nama
                                                Ruangan</label>
                                            <div class="col-md-7">
                                                <input type="text" id="nama_ruangan" class="form-control" name="nama_ruangan"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kapasitas_ruangan"
                                                class="col-md-3 col-form-label text-md-right">Kapasitas</label>
                                            <div class="col-md-7">
                                                <input type="number" id="kapasitas_ruangan" class="form-control" name="kapasitas_ruangan"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lokasi"
                                                class="col-md-3 col-form-label text-md-right">Lokasi</label>
                                            <div class="col-md-7">
                                                <input type="text" id="lokasi" class="form-control" name="lokasi"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="harga_ruangan"
                                                class="col-md-3 col-form-label text-md-right">Harga</label>
                                            <div class="col-md-7">
                                                <input type="text" id="harga_ruangan" class="form-control" name="harga_ruangan"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="status"
                                                class="col-md-3 col-form-label text-md-right">Status</label>
                                            <div class="col-md-7">
                                                <select id="status" class="form-control" name="status">
                                                    <option value="">Pilih Status</option>
                                                    <option value="available">Available</option>
                                                    <option value="booked">Booked</option>
                                                </select>
                                                <input type="number" id="tersedia" class="form-control" name="tersedia"
                                                    value="" required>
                                            </div>
                                        </div>
                                        <!-- right form file -->

                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group row">
                                        <label for="url" class="col-md-4 col-form-label text-md-right">Gambar
                                            Ruangan</label>
                                    </div>
                                    <div class="mb-3 text-center" style="margin-right: 0px">
                                        <div class="card shadow">
                                            <div class="card-body">
                                                <div id="my-dropzone" class="dropzone">
                                                    <div id="url" name="url">
                                                        <input type="file" name="url[]" multiple required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Menggunakan class col-auto agar kolom menyesuaikan dengan ukuran kontennya -->
                                    <button type="submit" class="btn btn-primary">
                                        Add
                                    </button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    </div>

    <script>
        document.getElementById('status').addEventListener('change', function() {
            var status = this.value;
            var tersediaInput = document.getElementById('tersedia');

            if (status === 'available') {
                tersediaInput.value = 0;
            } else if (status === 'booked') {
                tersediaInput.value = 1;
            } else {
                tersediaInput.value = '';
            }
        });
    </script>
@endsection
