@extends('admin.layouts.mainAdmin')

@section('containAdmin')
<div class="container-fluid mt-4">
  <!-- title -->
  <div class="row">
    <div class="col-sm-12 col-md-6 col-lg-4">
      <div class="container mx-2">
        <h4>Detail Ruangan<h4>
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
        <div class="container-fluid mt-5 mb-4  w-70 d-flex justify-content-center">
            <table class="table table-striped p-0" style="width: 80%; font-size: 18px;">
                <thead>
                    <tr>
                        <th class="border border-secondary" style="width: 33.33%;">Detail Ruangan</th>
                        <th class="border-bottom border-secondary" colspan="2"></th>
                    </tr>
                </thead>
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
                        <td colspan="3" class="border border-secondary"><button type="button" class="btn btn-success btn-sm" style="font-size: 18px; text-transform: capitalize;">Tersedia</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
