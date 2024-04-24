@extends('admin.layouts.mainAdmin')

@section('containAdmin')
<div class="container mt-4">
  <!-- Judul -->
  <div class="row">
    <div class="col pl-2">
      <h4>Daftar Ruangan<h4>
    </div>
  </div>
  <!-- Status -->
  <div class="row">
    <div class="col-1 bg-success text-black text-center p-2">
      <span class="material-symbols-outlined" style="font-size: 4em;">
        check_circle
      </span>
    </div>
    <div class="col-2 text-black pt-3 text-justify" style="background-color: #C4C4C4;">
        <h5>Available</h5>
        <h5>1</h5>
    </div>
    <div class='col-1'>
      <!-- space -->
    </div > 
    <div class="col-1 text-black text-center p-2" style="background-color:  #5B5B5B;" >
      <span class="material-symbols-outlined" style="font-size: 4em;">
        cancel
      </span>
    </div>
    <div class="col-2 text-black pt-3 text-justify" style="background-color:  #C4C4C4;">
        <h5>Booked</h5>
        <h5>3</h5>
    </div>
  </div>

  <!-- button add  -->
  <div class="row mt-4">
    <div class="col-2">
      <button type="button btn-lg" class="btn btn-success text-white text-center"> Add +</button>
    </div>
  </div>

  <!-- table edit -->
  <div class="row mt-4">
    <div class="col-9">
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
              <td><a class="btn btn-sm text-white" style="background : #414141;width: 100px;">Booked</a></td>
              <td>
                <a href="#" class="btn btn-warning btn-sm" style="width: 80px;">Edit</a>
                <a href="#" class="btn btn-danger btn-sm" style="width: 80px;">Delete</a>
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>0012</td>
              <td>Ruang Rapat</td>
              <td>13 Orang</td>
              <td><a class="btn btn-success btn-sm" style="width: 100px;">Available </a></td>
              <td>
                <a href="#" class="btn btn-warning btn-sm" style="width: 80px;">Edit</a>
                <a href="#" class="btn btn-danger btn-sm" style="width: 80px;">Delete</a>
              </td>
            </tr>
          </tbody>
        </table>
    </div>
  </div>
</div>
@endsection



