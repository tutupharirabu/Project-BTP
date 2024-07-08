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
                <a class="" href="" style="color: red;font-size:12px;font-weight: bold;">Dashboard</a>
            </div>
        </div>
    </div>
    <div class="p-3 border mb-3"
        style="border: 6px solid #61677A; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">

        <!-- <center>
            <h2>Daftar Ruangan</h2>
        </center> -->
        
        <!-- daftar ruangan -->
        <div class="row justify-content-sm-center text-center text-dark mt-3">
            @foreach ($RuangDashboard->take(3) as $ruangan)
                <div class="col-sm-12 col-md-6 col-lg-4">
                    @foreach ($ruangan->gambar as $gambar)
                        <div class="position-relative">
                            <img src="{{ asset('assets/' . $gambar->url) }}" class="card-img-top custom-img"
                                alt="Gambar Ruangan" style="border-radius: 5px;">
                            <h6 class="card-title position-absolute title-overlay">{{ $ruangan->nama_ruangan }}</h6>
                            <a href="{{ route('detailRuanganPenyewa', $ruangan->id_ruangan) }}"
                                class="btn btn-light shadow-none position-absolute detail-overlay text-capitalize"">Detail</a>
                            @if ($ruangan->tersedia == '1')
                                <span class="status-available position-absolute status-overlay">Tersedia</span>
                            @else
                                <span class="status-not-available position-absolute status-overlay">Digunakan</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        
        <div class="row mt-4">
            <div class="d-flex justify-content-center w-100">
                <a type="button" class="btn btn-sm text-white text-capitalize" style="background-color: #2CA700; font-size: 16px; border-radius: 7px;" href="/daftarRuanganPenyewa" >Lihat Ruangan Lainnya</a>
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

<script>
    $(document).ready(function() {
        var bookings = @json($events);
        console.log(bookings);

        $('#calendar').fullCalendar({
            events: bookings
        });
    });
</script>
    {{-- <script src="{{ asset('assets/js/dashboard.js') }}"></script> --}}

    {{-- Chart JS --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const peminjamanData = @json($peminjamanPerBulan);

            // Array nama bulan
            const monthNames = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];

            const labels = monthNames;

            // Hitung total keseluruhan peminjaman
            const totalPeminjaman = peminjamanData.reduce((sum, item) => sum + item.total, 0);

            // Ubah nilai peminjaman menjadi persentase
            const values = peminjamanData.map(item => ((item.total / totalPeminjaman) * 100).toFixed(2));

            const ctx = document.getElementById('myLineChart').getContext('2d');
            const myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Persentase Peminjaman',
                        data: values,
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value +
                                        '%'; // Tambahkan simbol persentase ke setiap nilai pada sumbu y
                                }
                            }
                        }
                    }
                }
            });
        });
    </script> --}}

@endsection
