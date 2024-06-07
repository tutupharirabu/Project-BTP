@extends('penyewa.layouts.mainPenyewa')

@section('containPenyewa')
<div class="container-fluid mt-4">
    <!-- Judul -->
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="container mx-2">
            <h4>Daftar Ruangan<h4>
        </div>
        </div>
    </div>

    <!-- href ui -->
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="container my-2 mx-2">
            <h6 href="" style="color: red;font-size:12px;">Daftar Ruangan<h4>
        </div>
        </div>
    </div>

    <!-- Card Room-->
    <div class="container">
        <div class="row justify-content-sm-center text-center text-dark">
            @foreach ($dataRuangan as $ruangan)
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card my-3 mx-2 shadow card-fixed" style="height:22rem; width:18rem;">
                        <img src="https://toffeedev.com/wp-content/uploads/2023/05/image-5.png" class="card-img-top" style="">
                        <div class="card-body">
                            <h5 class="card-title">{{ $ruangan->nama_ruangan }}</h5>
                            <p class="card-text">Rp. 500.000 Halfday/4 Jam</p>
                            <div class="status-group">
                                @if($ruangan->tersedia == '1')
                                    <span class="status-available">Tersedia</span>
                                @else
                                    <span class="status-not-available">Digunakan</span>
                                @endif
                                <a href="{{ route('detailRuanganPenyewa', $ruangan->id_ruangan) }}" class="btn btn-dark shadow-none status-detail">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

  <!-- Style bro -->
  <style>
        .card h5 {
            font-size: 18px;
            margin-top: -1rem;
            margin-bottom: 0.5rem;
        }

        .card img {
        margin-bottom: 0.5rem; /* Mengurangi jarak bawah gambar */
        }

        .status-detail {
            background-color: green;
            margin-bottom: 8px; /* Adjusted margin for spacing between the elements */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0;
            border-radius: 10px;
            height: 36px;
            width: 60%;
        }

        .status-detail {
            background-color: #000;
            margin-bottom: 0; /* Remove bottom margin for the last element */
        }

        .status-group {
            display: flex;
            flex-direction: column; /* Changed to column to stack elements vertically */
            align-items: center;
            margin-top: 0.5rem;
        }

        .status-available {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #071FF2;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 14px;
        }
        .status-not-available {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #717171;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 14px;
        }



    </style>
@endsection
