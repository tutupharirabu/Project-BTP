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
      <div class="d-flex container my-2 mx-2">
        <a href="/daftarRuanganPenyewa" class="fw-bolder" style="color: #797979; font-size:12px; ">Daftar Ruangan ></a>
        <a href="" class="fw-bolder" style="color: #028391; font-size:12px;">&nbsp;Detail Ruangan </a>
      </div>
    </div>
  </div>

  <!-- value -->
  <div class="card border shadow shadow-md mb-4">
      <div class="row justify-content-center mt-4">
          <div class="col-lg-6">
          <!-- <img src="https://btp.telkomuniversity.ac.id/wp-content/uploads/2022/09/DSC00331-2048x1365.jpg" class="img-fluid" alt="Responsive image"> -->
            
          <!-- Carousel -->
            <div id="demo" class="carousel slide" data-bs-ride="carousel">
      
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
              </div>
      
              
              <div class="carousel-inner" style="border-radius:5px;">
                <div class="carousel-item active">
                  <img src="https://btp.telkomuniversity.ac.id/wp-content/uploads/2022/07/profile-btp-03.jpg" alt="Los Angeles" class="d-block w-100 custom-carousel-img">
                </div>
                <div class="carousel-item">
                  <img src="https://btp.telkomuniversity.ac.id/wp-content/uploads/2022/07/profile-btp-02.jpg" alt="Chicago" class="d-block w-100 custom-carousel-img">
                </div>
                <div class="carousel-item">
                  <img src="https://cdnpt01.viewbug.com/media/mediafiles/2020/07/28/90338160_large.jpg" alt="New York" class="d-block w-100 custom-carousel-img">
                </div>
              </div>
              
              <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev" style="color:#028391; left: -14%;">
                <span class="carousel-control-prev-icon" style=""></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next" style="color:#028391; right: -14%">
                <span class="carousel-control-next-icon"></span>
              </button>
            </div>
          </div>
        </div>
      
      <div class="row">
          <div class="container-fluid mt-5 w-70 d-flex justify-content-center">
              <table class="table table-striped p-0" style="width: 80%; font-size:20px;">
                  <tbody>
                      <tr>
                          <td class="border border-secondary">Nama Ruangan</td>
                          <td colspan="3" class="border border-secondary">{{ $ruangan->nama_ruangan }}</td>
                      </tr>
                      <tr>
                          <td class="border border-secondary">Kapasitas Maksimal</td>
                          <td colspan="3" class="border border-secondary">{{ $ruangan->kapasitas_ruangan }}</td>
                      </tr>
                      <tr>
                          <td class="border border-secondary">Kapasitas Minimal</td>
                          <td colspan="3" class="border border-secondary">{{ $ruangan->kapasitas_ruangan }}</td>
                      </tr>
                      <tr>
                          <td class="border border-secondary">Lokasi</td>
                          <td colspan="3" class="border border-secondary">{{ $ruangan->lokasi }}</td>
                      </tr>
                      <tr>
                          <td class="border border-secondary">Harga</td>
                          <td colspan="3" class="border border-secondary">Rp {{ number_format((int)$ruangan->harga_ruangan, 0, ',', '.') }}</td>
                      </tr>
                      <tr>
                          <td class="border border-secondary">Status</td>
                          <td colspan="3" class="border border-secondary">
                              @if($ruangan->tersedia == '1')
                              <div type="button boder" class="btn btn-sm text-white" style="font-size:16px;background-color: #021BFF; border-radius: 10px; height: 31.83px; width: 120px; display: flex; align-items: center; justify-content: center;">
                                  Tersedia
                              </div>
                              @elseif($ruangan->tersedia == '0')
                              <div type="button boder" class="btn btn-sm text-white" style="font-size:16px;background-color: #555555; border-radius: 10px; height: 31.83px; width: 120px; display: flex; align-items: center; justify-content: center;">
                                  Digunakan
                              </div>
                              @endif
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <div class="container-fluid mt-4 mb-6 d-md-flex d-xl-flex d-lg-flex justify-content-between" style="width: 80%;">
              <div class="text-black">
                  <p>Keterangan :</p>
                  <p>*Harga Diatas belum termasuk PPN (sesuai dengan ketentuan regulasi yang berlaku)</p>
                  <p> **Harap membaca Syarat & ketentuan  yang berlaku </p>
              </div>
              <div class="">
                <a type="button" class="btn btn-sm text-white" style="background-color: #021BFF; font-size: 16px; border-radius: 7px;" href="/meminjamRuangan" >Pinjam Ruangan</a>
              </div>
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

    .custom-carousel-img {
        width: 600px; /* Width of the images */
        height: 400px; /* Height of the images */
    }
</style>

@endsection
