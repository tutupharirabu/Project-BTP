@extends('admin.layouts.mainAdmin')

@section('containAdmin')
    <div class="container-fluid mt-4">
        <!-- Judul -->
        <div class="row">
            <div class="col-sm-6 col-md-6 col mb-4">
                <div class="container ml-4">
                    <h4>Daftar Ruangan<h4>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="row">
            <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-4 ml-4">
                <div class="container d-flex justify-content-md-start justify-content-sm-start ">
                    <div class="bg-success text-black text-center p-2 ml-3 w-25 h-25" style="padding: 10px;">
                        <span class="material-symbols-outlined" style="font-size: 4em;">
                            check_circle
                        </span>
                    </div>
                    <div class="text-black text-justify w-50 h-25" style="background-color: #C4C4C4; padding: 11.5px;">
                        <h5 class="text-md">Available</h5>
                        <h5 class="text-md">1</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-4 col-xxl-4 col-sm col-md-6 col-sm-4">
                <div class="container d-flex align-items-center">
                    <div class="text-black text-center p-2 ml-3 w-25 h-25" style="padding: 10px;background-color: #5B5B5B;">
                        <span class="material-symbols-outlined" style="font-size: 4em;">
                            check_circle
                        </span>
                    </div>
                    <div class="text-black text-justify w-50 h-25" style="background-color: #C4C4C4; padding: 11.5px;">
                        <h5 class="text-md">Booked</h5>
                        <h5 class="text-md">3</h5>
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
            <div class="col-lg-10 col-xl-10 col-xxl-10 col-md-12 col-sm-6">
                <div class="container ml-4 mt-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">No Ruangan</th>
                                    <th scope="col">Nama Ruangan</th>
                                    <th scope="col">Kapasitas</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>5</td>
                                    <td>0012</td>
                                    <td>Ruang Rapat</td>
                                    <td>13 Orang</td>
                                    <td><a class="btn text-white" style="background : #414141; width: 100px;">Booked</a>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-warning" style="width: 80px;">Edit</a>
                                        <a href="#" class="btn btn-danger" style="width: 80px;">Delete</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>0012</td>
                                    <td>Ruang Rapat</td>
                                    <td>13 Orang</td>
                                    <td><a class="btn btn-success" style="width: 100px;">Available </a></td>
                                    <td>
                                        <a href="#" class="btn btn-warning" style="width: 80px;">Edit</a>
                                        <a href="#" class="btn btn-danger" style="width: 80px;">Delete</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
@endsection
