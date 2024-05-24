@extends('admin.layouts.mainAdmin')

@section('containAdmin')
    <div class="container-fluid mt-4">
        <!-- Judul -->
        <div class="row">
            <div class="col-sm-6 col-md-6 col mb-0">
                <div class="container ml-4">
                    <h4>Pengajuan Ruangan <h4>
                </div>
            </div>
        </div>

        <!-- href ui -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
                <div class="container my-2 mx-2">
                    <a class="" href="" style="color: red;font-size:12px;font-weight: bold;">Status Ruangan</a>
                </div>
            </div>
        </div>

     <!-- Inside box status-search-table  -->
     <div class="p-3 border mb-2" style="border: 6px solid #61677A; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">

        <!-- Status -->

        <div class="row">
            <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-4 col-sm-2" style="margin-right:98px;">
                <div class="container d-flex justify-content-md-start justify-content-sm-start">
                    <div class="left-status text-black d-flex align-items-center justify-content-center shadow" style="height: 100px;width: 80px ;padding: 10px; background-color: #03FC0C; border-right:5px; border-top-left-radius: 10px;border-bottom-left-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);">
                        <span class="material-symbols-outlined my-0" style="font-size: 3.5em;">
                            check_circle
                        </span>
                    </div>
                    <div class="right-status text-black text-justify shadow d-flex flex-column justify-content-center" style="height: 100px; background-color: #FFFFF; padding: 11.5px; width: 120px; border-top-right-radius: 10px; border-bottom-right-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        <p class="text-center mt-1 mb-2" style="font-size: 18px; margin-top: 8px;font-weight: bold;">Tersedia</p>
                        <p class="text-center" style="font-size: 32px;margin-top: -4px;font-weight: bold;">
                            7
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-4 col-sm-2 ml-4" style="margin-right:98px;">
                <div class="container d-flex align-items-center">
                    <div class="left-status text-black d-flex align-items-center justify-content-center shadow" style="height: 100px;width: 80px ;padding: 10px; background-color: #FF0000; border-right:5px; border-top-left-radius: 10px;border-bottom-left-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);">
                        <span class="material-symbols-outlined my-0" style="font-size: 3.5em;">
                            cancel
                        </span>
                    </div>
                    <div class="left-status text-black text-justify shadow d-flex flex-column justify-content-center" style="height: 100px; background-color: #FFFFF; padding: 11.5px; width: 120px; border-top-right-radius: 10px; border-bottom-right-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);">
                        <p class="text-center mt-1 mb-2" style="font-size: 18px; margin-top: 8px;font-weight: bold;">Ditolak</p>
                        <p class="text-center" style="font-size: 32px;margin-top: -4px;font-weight: bold;">
                            9
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-4 col-sm-2 ml-4" style="margin-right:98px;">
                <div class="container d-flex align-items-center">
                    <div  class="left-status text-black d-flex align-items-center justify-content-center shadow" style="height: 100px;width: 80px ;padding: 10px; background-color: #FCE303; border-right:5px; border-top-left-radius: 10px;border-bottom-left-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);">
                        <span class="material-symbols-outlined my-0" style="font-size: 5em;">
                            schedule
                        </span>
                    </div>
                    <div class="right-status text-black text-justify shadow d-flex flex-column justify-content-center" style="height: 100px; background-color: #FFFFF; padding: 11.5px; width: 120px; border-top-right-radius: 10px; border-bottom-right-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);">
                        <p class="text-center mt-1 mb-2" style="font-size: 18px; margin-top: 8px;font-weight: bold;">Menunggu</p>
                        <p class="text-center" style="font-size: 32px;margin-top: -4px;font-weight: bold;">
                            5
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and button add -->
        <div class="container mt-4 mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control" placeholder="Cari Ruangan..." style="width: 434px; height: 36px; border-radius: 6px; color: #070F2B; border: 2px solid #B1B1B1;">
                    <button id="searchButton" type="button" class="btn btn-md text-white text-center" style="margin-left:20px; background-color: #0EB100; border-radius: 6px;">Cari</button>
                </div>
            </div>
        </div>

        <!-- table edit -->
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12">
                <div class="container ml-4 mt-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center" style="padding: 0.5rem; vertical-align: middle;font-size: 13px;text-transform: capitalize;">
                            <thead style="vertical-align: middle;">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Peminjam</th>
                                    <th scope="col">Nama Ruangan</th>
                                    <th scope="col">Jam Mulai</th>
                                    <th scope="col">Jam Selesai</th>
                                    <th scope="col">Tanggal Mulai</th>
                                    <th scope="col">Tanggal Selesai</th>
                                    <th scope="col" style="width: 250px;">Aksi</th>
                                    <th scope="col" >Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Budi</td>
                                    <td>MultiMedia</td>
                                    <td>13:00</td>
                                    <td>15:00</td>
                                    <td>01/05/2024</td>
                                    <td>01/05/2024</td>
                                    <td class="d-flex justify-content-between">
                                        <a type="button" class="btn btn-outline-success" style="border-radius:6px;width: 100px;font-size: 13px;text-transform: capitalize;">Setuju</a>
                                        <a type="button" class="btn btn-outline-danger" style="border-radius:6px;width: 100px; font-size: 13px;text-transform: capitalize;">Tolak</a>
                                    </td>
                                    <td>
                                        <a type="button" class="btn btn-warning" style="border-radius:6px;width: 100px; font-size: 13px;text-transform: capitalize;">Menunggu</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Budi</td>
                                    <td>MultiMedia</td>
                                    <td>13:00</td>
                                    <td>15:00</td>
                                    <td>01/05/2024</td>
                                    <td>01/05/2024</td>
                                    <td class="d-flex justify-content-between" >
                                        <a type="button" class="btn btn-outline-success" style="border-radius:6px;width: 100px; font-size: 13px;text-transform: capitalize;">Setuju</a>
                                        <a type="button" class="btn btn-danger" style="border-radius:6px;width: 100px; font-size: 13px;text-transform: capitalize;">Tolak</a>
                                    </td>
                                    <td>
                                        <a type="button" class="btn btn-danger" style="border-radius:6px;width: 100px;font-size: 13px;text-transform: capitalize;">Tolak</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Budi</td>
                                    <td>MultiMedia</td>
                                    <td>13:00</td>
                                    <td>15:00</td>
                                    <td>01/05/2024</td>
                                    <td>01/05/2024</td>
                                    <td class="d-flex justify-content-between">
                                        <a type="button" class="btn text-white" style="background-color:#0EB100; border-radius:6px; width: 100px; font-size: 13px;text-transform: capitalize;">Setuju</a> 
                                        <a type="button" class="btn btn-outline-danger" style="border-radius:6px;;width: 100px;font-size: 13px; text-transform: capitalize;">Tolak</a>
                                    </td>
                                    <td>
                                        <a type="button" class="btn text-white" style="background-color:#0EB100; border-radius:6px;width: 100px;font-size: 13px;text-transform: capitalize;">Disetujui</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>

        <style>
            .table td, .table th {
                padding: 10px; /* Adjust the padding table */
            }
            .center-text {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100px;
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
@endsection
