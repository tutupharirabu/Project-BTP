@extends('admin.layouts.mainAdmin')

@section('containAdmin')
    <div class="container-fluid mt-4">
        <!-- title -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="container mx-2">
                    <h4>Edit Ruangan<h4>
                </div>
            </div>
        </div>

        <!-- value -->
        <div class="row justify-content-center mt-4">
            <div class="col-11">
                <div class="card border shadow shadow-md">
                    <div class="card-body">
                        <form>
                            <!-- left from text field -->
                            <div class="row">
                                <div class="col-7">
                                    <div class="form-group row">
                                        <label for="room_id" class="col-md-3 col-form-label text-md-left-right">ID
                                            Ruangan</label>
                                        <div class="col-md-7">
                                            <input type="text" id="room_id" class="form-control" name="room_id"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-md-3 col-form-label text-md-right">Nama
                                            Ruangan</label>
                                        <div class="col-md-7">
                                            <input type="text" id="name" class="form-control" name="name"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="capacity"
                                            class="col-md-3 col-form-label text-md-right">Kapasitas</label>
                                        <div class="col-md-7">
                                            <input type="number" id="capacity" class="form-control" name="capacity"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="location" class="col-md-3 col-form-label text-md-right">Lokasi</label>
                                        <div class="col-md-7">
                                            <input type="text" id="location" class="form-control" name="location"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="price" class="col-md-3 col-form-label text-md-right">Harga</label>
                                        <div class="col-md-7">
                                            <input type="text" id="price" class="form-control" name="price"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="status" class="col-md-3 col-form-label text-md-right">Status</label>
                                        <div class="col-md-7">
                                            <select id="status" class="form-control" name="status">
                                                <option value="">Pilih Status</option>
                                                <option value="available">Available</option>
                                                <option value="booked">Booked</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- right form file -->
                                <div class="col-5">
                                    <div class="form-group row">
                                        <label for="room_image" class="col-md-4 col-form-label text-md-right">Gambar
                                            Ruangan</label>
                                    </div>
                                    <div class="mb-3 text-center" style="margin-right: 0px">
                                        <div class="card shadow">
                                            <div class="card-body">
                                                <div class="dropzone" id="dropzone">
                                                    <!-- <span class="material-symbols-outlined " style="font-size: 4em;">
                                                                    upload_file
                                                                </span> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0 justify-content-end">
                                        <div class="col-auto">
                                            <!-- Menggunakan class col-auto agar kolom menyesuaikan dengan ukuran kontennya -->
                                            <button type="submit" class="btn btn-primary">
                                                Edit
                                            </button>
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
@endsection
