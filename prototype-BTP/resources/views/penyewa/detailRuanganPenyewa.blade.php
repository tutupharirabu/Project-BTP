@extends('penyewa.layouts.mainPenyewa')

@section('containPenyewa')
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
  <div class="row justify-content-center mt-3">
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
    <div class="container-fluid">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
