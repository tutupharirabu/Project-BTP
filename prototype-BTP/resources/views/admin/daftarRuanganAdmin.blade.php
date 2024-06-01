@extends('admin.layouts.mainAdmin')

@section('containAdmin')
    @foreach ($dataRuangan as $data)
        {{-- <h1>{{ $data->id_ruangan }}</h1> --}}
    @endforeach

    <div class="container-fluid mt-4">
        <!-- Judul -->
        <div class="row">
            <div class="col-sm-6 col-md-6 col mb-0">
                <div class="container ml-4">
                    <h4>Daftar Ruangan<h4>
                </div>
            </div>
        </div>

        <!-- href ui -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
                <div class="container my-2 mx-2">
                    <a class="" href="" style="color: red;font-size:12px;font-weight: bold;">Daftar Ruangan</a>
                </div>
            </div>
        </div>

        <!-- Inside box status-search-table  -->
        <div class="p-3 border mb-2"
            style="border: 6px solid #61677A; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">


            <!-- Status -->
            <div class="row">
                <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-4 col-sm-2" style="margin-right:98px;">
                    <div class="container d-flex justify-content-md-start justify-content-sm-start">
                        <div class="left-status text-black d-flex align-items-center justify-content-center shadow"
                            style="height: 100px;width: 80px ;padding: 10px; background-color: #03FC0C; border-right:5px; border-top-left-radius: 10px;border-bottom-left-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);">
                            <span class="material-symbols-outlined my-0" style="font-size: 3.5em;">
                                check_circle
                            </span>
                        </div>
                        <div class="right-status text-black text-justify shadow d-flex flex-column justify-content-center"
                            style="height: 100px; background-color: #FFFFF; padding: 11.5px; width: 120px; border-top-right-radius: 10px; border-bottom-right-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                            <p class="text-center mt-1 mb-2" style="font-size: 18px; margin-top: 8px;font-weight: bold;">
                                Tersedia</p>
                            <p class="text-center" style="font-size: 32px;margin-top: -4px;font-weight: bold;">
                                @php
                                    $bookedCount = $dataRuangan->where('status', 'Available')->count();
                                @endphp
                                {{ $bookedCount }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-4 col-sm-2 ml-4" style="margin-right:98px;">
                    <div class="container d-flex align-items-center">
                        <div class="left-status text-black d-flex align-items-center justify-content-center shadow"
                            style="height: 100px;width: 80px ;padding: 10px; background-color: #FF0000; border-right:5px; border-top-left-radius: 10px;border-bottom-left-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);">
                            <span class="material-symbols-outlined my-0" style="font-size: 3.5em;">
                                cancel
                            </span>
                        </div>
                        <div class="right-status text-black text-justify shadow d-flex flex-column justify-content-center"
                            style="height: 100px; background-color: #FFFFF; padding: 11.5px; width: 120px; border-top-right-radius: 10px; border-bottom-right-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);">
                            <p class="text-center mt-1 mb-2" style="font-size: 18px; margin-top: 8px;font-weight: bold;">
                                Digunakan</p>
                            <p class="text-center" style="font-size: 32px;margin-top: -4px;font-weight: bold;">
                                @php
                                    $bookedCount = $dataRuangan->where('status', 'Booked')->count();
                                @endphp

                                {{ $bookedCount }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and button add -->
            <div class="container mt-4 mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control" placeholder="Cari Ruangan..."
                            style="width: 434px; height: 36px; border-radius: 6px; color: #070F2B; border: 2px solid #B1B1B1;">
                        <button id="searchButton" type="button" class="btn btn-md text-white text-center"
                            style="margin-left:20px; background-color: #0EB100; border-radius: 6px;">Cari</button>
                    </div>
                    <a href="/tambahRuanganAdmin" class="btn btn-md text-white text-center"
                        style="background-color: #0EB100; border-radius: 6px"> Tambah Ruangan +</a>
                </div>
            </div>


            <!-- table edit -->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-6">
                    <div class="container ml-4 mt-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">No Ruangan</th>
                                        <th scope="col">Nama Ruangan</th>
                                        <th scope="col">Kapasitas</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Gambar</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataRuangan as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->id_ruangan }}</td>
                                            <td>{{ $data->nama_ruangan }}</td>
                                            <td>{{ $data->kapasitas_ruangan }}</td>
                                            <td>Rp {{ $data->harga_ruangan }}</td>
                                            <td>
                                                <a class="text-blue" href="#" data-toggle="modal"
                                                    data-target="#imageModal{{ $data->id_ruangan }}"><u>Gambar</u></a>

                                                <!-- Modal -->
                                                <div class="modal fade" id="imageModal{{ $data->id_ruangan }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Gambar
                                                                    Ruangan</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="https://images.squarespace-cdn.com/content/v1/634457628ffbff6e2a1ded77/1665611068776-H63ADZG7MYAIM3Y29WN5/image-asset.jpeg"
                                                                    alt="Gambar Ruangan" class="img-fluid">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="display: flex; justify-content: center;">
                                                @if ($data->status == 'Available')
                                                    <a class="btn text-white"
                                                        style="display: flex; align-items: center; justify-content: center; background-color: #0EB100; width:91px; height: 27px; border-radius: 6px">Tersedia</a>
                                                @elseif ($data->status == 'Booked')
                                                    <a class="btn text-dark"
                                                        style="display: flex; align-items: center; justify-content: center; background-color: #B0B0B0; width:91px; height: 27px; border-radius: 6px">Digunakan</a>
                                                @else
                                                    <a class="btn text-white"
                                                        style="display: flex; align-items: center; justify-content: center; background-color: #61677A; width:91px; height: 27px; border-radius: 6px">
                                                        - </a>
                                                @endif
                                            </td>
                                            <td>
                                                <div style="display: flex; gap: 5px; justify-content: center;">
                                                    <a href="/editRuanganAdmin/{{ $data->id_ruangan }}/edit"
                                                        class="btn text-white"
                                                        style="display: flex; align-items: center; justify-content: center;width: 62px; height: 30px; background-color: #E0AF00;border-radius: 6px">Edit</a>
                                                    <a href="daftarRuanganAdmin/{{ $data->id_ruangan }}"
                                                        class="btn text-white"
                                                        style="display: flex; align-items: center; justify-content: center;width: 62px; height: 30px; background-color: #FF0000;border-radius: 6px">Hapus</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .table td,
            .table th {
                padding: 10px;
                /* Adjust the padding table */
            }

            .left-status {
                border-left: 1px;
                border-right: 0px;
                border-bottom: 1px;
                border-top: 1px;
                border-style: solid;
                border-color: rgb(187, 187, 187);
            }

            .right-status {
                border-left: 0px;
                border-right: 1px;
                border-bottom: 1px;
                border-top: 1px;
                border-style: solid;
                border-color: rgb(187, 187, 187);
            }
        </style>

        <script>
            document.getElementById('searchButton').addEventListener('click', function(event) {
                event.preventDefault();
                let searchTerm = document.getElementById('searchInput').value;
                console.log('Mencari ruangan:', searchTerm);
            });
        </script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    @endsection
