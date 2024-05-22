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
                <h6 href="" style="color: red;font-size:12px;">Daftar Ruangan<h4>
            </div>
            </div>
        </div>

        <!-- Inside box status-search-table  -->
        <div class="p-3 border mb-2" style="border: 6px solid #61677A; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">


            <!-- Status -->
            <div class="row">
                <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-4 col-sm-2" style="margin-right:98px;">
                    <div class="container d-flex justify-content-md-start justify-content-sm-start">
                        <div class="text-black d-flex align-items-center justify-content-center shadow" style="height: 100px;width: 80px ;padding: 10px; background-color: #03FC0C; border-right:5px; border-top-left-radius: 10px;border-bottom-left-radius: 10px;">
                            <span class="material-symbols-outlined my-0" style="font-size: 4em;">
                                check_circle
                            </span>
                        </div>
                        <div class="text-black text-justify shadow d-flex flex-column justify-content-center" style="height: 100px; background-color: #F1F1F1; padding: 11.5px; width: 120px; border-top-right-radius: 10px; border-bottom-right-radius: 10px;">
                            <p class="font-weight-bold text-center mt-1 mb-2" style="font-size: 20px;">Available</p>
                            <p class="font-weight-bold text-center m-0" style="font-size: 42px;">
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
                        <div  class="text-black d-flex align-items-center justify-content-center shadow" style="height: 100px;width: 80px ;padding: 10px; background-color: #FF0000; border-right:5px; border-top-left-radius: 10px;border-bottom-left-radius: 10px;"">
                            <span class="material-symbols-outlined my-0" style="font-size: 4em;">
                                cancel
                            </span>
                        </div>
                        <div class="text-black text-justify shadow d-flex flex-column justify-content-center" style="height: 100px; background-color: #F1F1F1; padding: 11.5px; width: 120px; border-top-right-radius: 10px; border-bottom-right-radius: 10px;">
                            <p class="font-weight-bold text-center mt-1 mb-2" style="font-size: 20px;">Booked</p>
                            <p class="font-weight-bold text-center m-0" style="font-size: 42px;">
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
                <div class="row">
                    <div class="col d-flex align-items-center">
                        <input type="text" class="form-control" placeholder="Cari Ruangan..." style="width: 434px; height: 36px; border-radius: 6px; color: #070F2B ; border: 2px solid #B1B1B1;">
                        <button type="button" class="btn btn-md text-white text-center" style="margin-left:20px; background-color: #0EB100;">Cari</button>
                    </div>
                    <div class="col-auto d-flex align-items-center">
                        <a href="/tambahRuanganAdmin" class="btn btn-md text-white text-center" style="background-color: #0EB100;"> Tambah Ruangan +</a>
                    </div>
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
                                            <td>Rp {{$data->harga_ruangan}}</td>
                                            <td><a class="text-blue" href=""><u>Gambar</u></a></td>
                                            <td style="display: flex; justify-content: center;">
                                                @if ($data->status == "Available")
                                                    <a class="btn text-white" style="display: flex; align-items: center; justify-content: center; background-color: #0EB100; width:91px; height: 27px;">Tersedia</a>
                                                @elseif ($data->status == "Booked")
                                                    <a class="btn text-dark" style="display: flex; align-items: center; justify-content: center; background-color: #B0B0B0; width:91px; height: 27px;">Digunakan</a>
                                                @else
                                                    <a class="btn text-white" style="display: flex; align-items: center; justify-content: center; background-color: #61677A; width:91px; height: 27px;"> - </a>
                                                @endif
    
                                            </td>
                                            <td>
                                                <div style="display: flex; gap: 5px; justify-content: center;">
                                                    <a href="/editRuanganAdmin/{{$data->id_ruangan}}/edit" class="btn text-white" style="display: flex; align-items: center; justify-content: center;width: 62px; height: 30px; background-color: #E0AF00">Edit</a>
                                                    <a href="daftarRuanganAdmin/{{ $data->id_ruangan }}" class="btn text-white" style="display: flex; align-items: center; justify-content: center;width: 62px; height: 30px; background-color: #FF0000">Hapus</a>
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
            .table td, .table th {
                padding: 10px; /* Adjust the padding as needed */
            }
        </style>

        @endsection
