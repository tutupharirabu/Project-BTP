@extends('penyewa.layouts.mainPenyewa')

@section('containPenyewa')
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/penyewa/daftarRuangan.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/penyewa/overlaydashboard.css') }}">
</head>


<div class="container-fluid mt-4">
    <!-- Judul -->
    <div class="row">
        <div class="col-sm-6 col-md-6 col mb-0">
            <div class="container ml-4">
                <h4>Dashboard</h4>
            </div>
        </div>
    </div>

    <!-- href ui -->
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
            <div class="container my-2 mx-2">
                <a class="" href="" style="color: #028391;font-size:12px;font-weight: bold;">Dashboard</a>
            </div>
        </div>
    </div>
    <div class="p-3 border mb-5"
        style="border: 6px solid #61677A; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">

        <!-- daftar ruangan sebagai carousel -->
        <div id="ruanganCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($RuangDashboard->chunk(3) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row justify-content-sm-center text-center text-dark mt-3">
                            @foreach ($chunk as $ruangan)
                                <div class="col-sm-12 col-md-6 col-lg-4 mt-3">
                                    <div class="position-relative">
                                        <img src="{{ asset('assets/' . $ruangan->gambar->first()->url) }}" class="card-img-top custom-img"
                                            alt="Gambar Ruangan">
                                        <h6 class="card-title title-overlay">{{ $ruangan->nama_ruangan }}</h6>
                                        <a href="{{ route('detailRuanganPenyewa', $ruangan->id_ruangan) }}"
                                            class="btn btn-light shadow-none detail-overlay text-capitalize">Detail</a>
                                        @if ($ruangan->tersedia == '1')
                                            <span class="status-available status-overlay">Tersedia</span>
                                        @else
                                            <span class="status-not-available status-overlay">Digunakan</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#ruanganCarousel" data-bs-slide="prev" style="color:#028391; left: -6%">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#ruanganCarousel" data-bs-slide="next" style="color:#028391; right: -6%;">
                <span class="carousel-control-next-icon" aria-hidden="true" ></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="row mt-4">
            <div class="d-md-flex justify-content-center w-100">
                <a type="button" class="btn btn-sm text-white text-capitalize" style="background-color: #2CA700; font-size: 16px; border-radius: 7px;" href="/daftarRuanganPenyewa">Lihat Ruangan Lainnya</a>
            </div>
        </div>
    </div>

    <div class="p-3 border mb-3"
        style="border: 6px solid #61677A; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">

        <center>
            <h2>Jadwal</h2>
        </center>

        <div id="calendar" class="mx-3"></div>
    </div>
    <br>
</div>

<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header " style="">
        <h5 class="modal-title" id="eventModalLabel">Detail Peminjaman</h5>
      </div>
      <div class="modal-body">
        <p><strong>Peminjam : </strong> <span id="modalTitle"></span></p>
        <p><strong>Mulai    : </strong> <span id="modalStart"></span></p>
        <p><strong>Selesai  :</strong> <span id="modalEnd"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn text-white text-capitalize" data-dismiss="modal" data-bs-dismiss="modal" style="background-color: #0DA200; font-size:15px;">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        var bookings = @json($events);
        console.log(bookings);

        $('#calendar').fullCalendar({
            events: bookings,
            eventClick: function(event) {
                $('#modalTitle').text(event.title);
                $('#modalStart').text(event.start.format('DD-MM-YYYY | HH:mm'));
                if (event.end) {
                    $('#modalEnd').text(event.end.format('DD-MM-YYYY | HH:mm'));
                } else {
                    $('#modalEnd').text('N/A');
                }
                $('#eventModal').modal('show');
            }
        });
    });
</script>
<style>

</style>

@endsection
