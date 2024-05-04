@extends('admin.layouts.mainAdmin')

@section('containAdmin')
    <div class="container-fluid mt-4">
        <!-- Judul -->
        <div class="row">
            <div class="col-sm-6 col-md-6 col mb-4">
                <div class="container ml-4">
                    <h4>Pengajuan Ruangan<h4>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="row">
            <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-4 ml-4">
                <div class="container d-flex justify-content-md-start justify-content-sm-starts mt-2">
                    <div class="bg-warning text-black text-center p-2 ml-3 w-25 h-25" style="padding: 10px;">
                        <span class="material-symbols-outlined" style="font-size: 4em;">
                            schedule
                        </span>
                    </div>
                    <div class="text-black text-justify w-100 h-25" style="background-color: #C4C4C4; padding: 11.5px;">
                        <h5 class="text-md">Available</h5>
                        <h5 class="text-md">1</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-4 col-xxl-4 col-sm col-md-6 col-sm-4">
                <div class="container d-flex justify-content-md-start justify-content-sm-starts mt-2">
                    <div class="bg-success text-black text-center p-2 ml-3 w-25 h-25" style="padding: 10px;">
                    <span class="material-symbols-outlined" style="font-size: 4em;">
                        check_circle
                    </span>
                    </div>
                    <div class="text-black text-justify w-100 h-25" style="background-color: #C4C4C4; padding: 11.5px;">
                        <h5 class="text-md">Booked</h5>
                        <h5 class="text-md">3</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-4 ml-4">
                <div class="container d-flex justify-content-md-start justify-content-sm-starts mt-2">
                    <div class="bg-danger text-black text-center p-2 ml-3 w-25 h-25" style="padding: 10px;">
                        <span class="material-symbols-outlined" style="font-size: 4em;">
                            cancel
                        </span>
                    </div>
                    <div class="text-black text-justify w-100 h-25" style="background-color: #C4C4C4; padding: 11.5px;">
                        <h5 class="text-md">Available</h5>
                        <h5 class="text-md">1</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- button add  -->
        <div class="row">
            <div class="col-2 col-md-4 col-sm-4">
                <div class="container ml-4 mt-4">
                    <a href="" type="button btn-lg" class="btn btn-success text-white text-center"> Add </a>
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
                                    <th scope="col" class="text-center">Status</th>
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
                                        <a type="button" class="btn btn-success" style="width: 100px;font-size: 13px;text-transform: capitalize;">Approve</a>
                                        <a type="button" class="btn btn-outline-danger" style="width: 100px;font-size: 13px;text-transform: capitalize;">Reject</a>
                                    </td>
                                    <td>
                                        <a type="button" class="btn btn-success" style="width: 100px;font-size: 13px;text-transform: capitalize;">Approve</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
@endsection
