@extends('penyewa.layouts.mainPenyewa')

@section('containPenyewa')
<div class="container-fluid mt-4">
  <!-- title -->
  <div class="row">
    <div class="col-sm-12 col-md-6 col-lg-4">
      <div class="container mx-2">
        <h4>Detail Ruangan</h4>
      </div>
    </div>
  </div>

  <!-- href ui -->
  <div class="row">
    <div class="col-sm-12 col-md-6 col-lg-4">
      <div class="container my-2 mx-2 d-flex">
        <a href="" style="color: #797979;font-size:12px;">Daftar Ruangan > </a> 
        <a style="color: #FF0000;font-size:12px;">Detail Ruangan</a>
      </div>
    </div>
  </div>

  <!-- value -->
  <div class="row justify-content-center mt-4">
  <div class="col-lg-6">
    <!-- Carousel -->
    <div id="demo" class="carousel slide" data-bs-ride="carousel">

      <!-- Indicators/dots -->
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
      </div>

      <!-- The slideshow/carousel -->
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="https://media.designcafe.com/wp-content/uploads/2021/04/26164735/l-shaped-home-office-images-with-attahced-bookshelf.jpg" alt="Los Angeles" class="d-block w-100">
        </div>
        <div class="carousel-item">
          <img src="https://media.designcafe.com/wp-content/uploads/2021/04/26164735/l-shaped-home-office-images-with-attahced-bookshelf.jpg" alt="Chicago" class="d-block w-100">
        </div>
        <div class="carousel-item">
          <img src="https://media.designcafe.com/wp-content/uploads/2021/04/26164735/l-shaped-home-office-images-with-attahced-bookshelf.jpg" alt="New York" class="d-block w-100">
        </div>
      </div>

      <!-- Left and right controls/icons -->
      <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </div>
</div>

<div class="row">
    <div class="container-fluid mt-5 w-70 d-flex justify-content-center">
        <table class="table table-striped p-0" style="width: 80%;">
            <tbody>
                <tr>
                    <td class="border border-secondary">Nama Ruangan</td>
                    <td colspan="3" class="border border-secondary">Multimedia</td>
                </tr>
                <tr>
                    <td class="border border-secondary">Kapasitas</td>
                    <td colspan="3" class="border border-secondary">50 Orang</td>
                </tr>
                <tr>
                    <td class="border border-secondary">Lokasi</td>
                    <td colspan="3" class="border border-secondary">Gedung A</td>
                </tr>
                <tr>
                    <td class="border border-secondary">Harga</td>
                    <td colspan="3" class="border border-secondary">Rp70000</td>
                </tr>
                <tr>
                    <td class="border border-secondary">Status</td>
                    <td colspan="3" class="border border-secondary"><button type="button boder" class="btn btn-sm text-white" style="background-color: #00DB09; border-radius: 10px; ">Tersedia</button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="container-fluid mt-4 mb-6 d-flex justify-content-between" style="width: 80%;">
        <div class="text-black">
            <p>Keterangan :</p>
            <p>*Harga Diatas belum termasuk PPN (sesuai dengan ketentuan regulasi yang berlaku)</p>
            <p> **Harap membaca Syarat & ketentuan  yang berlaku </p>
        </div>
        <div class="">
          <button type="button" class="btn btn-sm text-white" style="background-color: #00DB09; font-size: 20px; border-radius: 7px;">Pinjam Ruangan</button>
        </div>
    </div>
  </div>
</div>

<style>
    .table td, .table th {
        font-size: 20px; /* Mengubah ukuran teks */
        padding: 0.5rem; /* Mengurangi padding */
    }

    .btn {
        font-size: 20px; /* Ukuran teks pada tombol */
        text-transform: capitalize;
    }
</style>

@endsection
