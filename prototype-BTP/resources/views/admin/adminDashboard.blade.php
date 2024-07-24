@extends('admin.layouts.mainAdmin')
@section('containAdmin')

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/locale/id.js"></script>
</head>

<div class="container-fluid mt-4">
    <!-- Judul -->
    <div class="row">
        <div class="col-sm-6 col-md-6 col mb-0">
            <div class="container ml-4">
                <h4>Penyewaan Ruangan</h4>
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
    <div class="p-3 border mb-3" style="border: 6px solid #61677A; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">

        <center>
            <h2>Informasi Penggunaan Ruangan</h2>
        </center>

        <div id="calendar" class="mx-3"></div>

        <br>
    </div>

    <div class="p-3 border mb-2" style="border: 6px solid #61677A; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">

        <center>
            <h2>Grafik Peminjaman Per Bulan</h2>
        </center>
        <canvas id="occupancyChart" width="200" height="100"></canvas>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header " style="">
                <h5 class="modal-title" id="eventModalLabel">Detail Peminjaman</h5>
            </div>
            <div class="modal-body">
                <p><strong>Nama Peminjam : </strong> <span id="modalTitle"></span></p>
                <p><strong>Nama Ruangan : </strong> <span id="modalRuangan"></span></p>
                <p><strong>Mulai : </strong> <span id="modalStart"></span></p>
                <p><strong>Selesai :</strong> <span id="modalEnd"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-white" data-dismiss="modal" data-bs-dismiss="modal" style="background-color: #0DA200;">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var bookings = @json($events);
        console.log(bookings);

        $('#calendar').fullCalendar({
            locale: 'id',
            events: bookings,
            eventClick: function(event) {
                $('#modalTitle').text(event.title);
                $('#modalRuangan').text(event.ruangan);
                $('#modalStart').text(event.start.format('YYYY-MM-DD | HH:mm'));
                if (event.end) {
                    $('#modalEnd').text(event.end.format('YYYY-MM-DD | HH:mm'));
                } else {
                    $('#modalEnd').text('N/A');
                }
                $('#eventModal').modal('show');
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('occupancyChart').getContext('2d');
        const occupancyPercentage = {{ $occupancyOverallPercentage }};

        const monthNames = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        const occupancyChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: monthNames,
                datasets: [{
                    label: 'Persentase Okupansi',
                    data: Array(12).fill(occupancyPercentage),
                    fill: false,
                    borderColor: '#0d9cad',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Okupansi: ' + context.parsed.y + '%';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
