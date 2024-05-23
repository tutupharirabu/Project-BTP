@extends('admin.layouts.mainAdmin')

@section('containAdmin')
    <div class="container-fluid mt-4">
        <!-- Judul -->
        <div class="row">
            <div class="col-sm-6 col-md-6 col mb-4">
                <div class="container ml-4">
                    <h4>Pengajuan Ruangan <h4>
                </div>
            </div>
        </div>

     <!-- Inside box status-search-table  -->
     <div class="p-3 border mb-2" style="border: 6px solid #61677A; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">

        <!-- Status -->

        <div class="row">
            <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-4 col-sm-2" style="margin-right:98px;">
                <div class="container d-flex justify-content-md-start justify-content-sm-start">
                    <div class="text-black d-flex align-items-center justify-content-center shadow" style="height: 100px;width: 80px ;padding: 10px; background-color: #03FC0C; border-right:5px; border-top-left-radius: 10px;border-bottom-left-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);">
                        <span class="material-symbols-outlined my-0" style="font-size: 3.5em;">
                            check_circle
                        </span>
                    </div>
                    <div class="text-black text-justify shadow d-flex flex-column justify-content-center" style="height: 100px; background-color: #FFFFF; padding: 11.5px; width: 120px; border-top-right-radius: 10px; border-bottom-right-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        <p class="font-weight-bold text-center mt-1 mb-2" style="font-size: 18px;">Available</p>
                        <p class="font-weight-bold text-center m-0" style="font-size: 32px;">
                            7
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-4 col-sm-2 ml-4" style="margin-right:98px;">
                <div class="container d-flex align-items-center">
                    <div  class="text-black d-flex align-items-center justify-content-center shadow" style="height: 100px;width: 80px ;padding: 10px; background-color: #FF0000; border-right:5px; border-top-left-radius: 10px;border-bottom-left-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);">
                        <span class="material-symbols-outlined my-0" style="font-size: 3.5em;">
                            cancel
                        </span>
                    </div>
                    <div class="text-black text-justify shadow d-flex flex-column justify-content-center" style="height: 100px; background-color: #FFFFF; padding: 11.5px; width: 120px; border-top-right-radius: 10px; border-bottom-right-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);">
                        <p class="font-weight-bold text-center mt-1 mb-2" style="font-size: 18px;">Ditolak</p>
                        <p class="font-weight-bold text-center m-0" style="font-size: 38px;">
                            9
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-4 col-sm-2 ml-4" style="margin-right:98px;">
                <div class="container d-flex align-items-center">
                    <div  class="text-black d-flex align-items-center justify-content-center shadow" style="height: 100px;width: 80px ;padding: 10px; background-color: #FCE303; border-right:5px; border-top-left-radius: 10px;border-bottom-left-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);">
                        <span class="material-symbols-outlined my-0" style="font-size: 5em;">
                            schedule
                        </span>
                    </div>
                    <div class="text-black text-justify shadow d-flex flex-column justify-content-center" style="height: 100px; background-color: #FFFFF; padding: 11.5px; width: 120px; border-top-right-radius: 10px; border-bottom-right-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);">
                        <p class="font-weight-bold text-center mt-1 mb-2" style="font-size: 18px;">Menunggu</p>
                        <p class="font-weight-bold text-center m-0" style="font-size: 32px;">
                            9
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
                                    <th scope="col" style="width: 250px;">Action</th>
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
                                        <a type="button" class="btn btn-outline-success" style="width: 100px;font-size: 13px;text-transform: capitalize;">Approve</a>
                                        <a type="button" class="btn btn-outline-danger" style="width: 100px; font-size: 13px;text-transform: capitalize;">Reject</a>
                                    </td>
                                    <td>
                                        <a type="button" class="btn btn-warning" style="width: 100px; font-size: 13px;text-transform: capitalize;">Waiting</a>
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
                                        <a type="button" class="btn btn-outline-success" style="width: 100px; font-size: 13px;text-transform: capitalize;">Approve</a>
                                        <a type="button" class="btn btn-danger" style="width: 100px; font-size: 13px;text-transform: capitalize;">Reject</a>
                                    </td>
                                    <td>
                                        <a type="button" class="btn btn-danger" style="width: 100px;font-size: 13px;text-transform: capitalize;">Reject</a>
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
                                        <a type="button" class="text-white center-text" style="background-color:#0EB100; border-radius:6px;">Tersedia</a>
                                        <a type="button" class="btn btn-outline-danger" style="width: 100px;font-size: 13px;text-transform: capitalize;">Tolak</a>
                                    </td>
                                    <td>
                                        <a type="button" class="text-white center-text" style="background-color:#0EB100; border-radius:6px;">Disetujui</a>
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
        </style>
@endsection
