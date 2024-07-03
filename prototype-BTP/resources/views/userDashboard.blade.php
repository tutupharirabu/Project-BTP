@extends('penyewa.layouts.mainPenyewa')
@section('containPenyewa')
    <style>
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-template-rows: auto;
            gap: 1px;
            background-color: #ddd;
        }

        .calendar div {
            background-color: #fff;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .calendar .day-name {
            background-color: #f3f3f3;
            font-weight: bold;
        }

        .calendar .day {
            height: 100px;
            position: relative;
        }

        .calendar .event {
            background-color: #e3f2fd;
            border: 1px solid #90caf9;
            padding: 2px;
            margin: 2px 0;
            font-size: 12px;
        }

        .calendar .date {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 12px;
            color: #777;
        }
    </style>

    <h1>Monthly Calendar</h1>
    <div class="calendar">
        <!-- Days of the week -->
        <div class="day-name">Sunday</div>
        <div class="day-name">Monday</div>
        <div class="day-name">Tuesday</div>
        <div class="day-name">Wednesday</div>
        <div class="day-name">Thursday</div>
        <div class="day-name">Friday</div>
        <div class="day-name">Saturday</div>

        <!-- Calendar days -->
        @php
            $daysInMonth = \Carbon\Carbon::now()->daysInMonth;
            $firstDayOfMonth = \Carbon\Carbon::now()->startOfMonth()->dayOfWeek;
            $today = \Carbon\Carbon::now()->format('Y-m-d');
            $events = $peminjamans->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->tanggal_mulai)->format('Y-m-d');
            });
        @endphp

        <!-- Empty days before the first day of the month -->
        @for ($i = 0; $i < $firstDayOfMonth; $i++)
            <div class="day"></div>
        @endfor

        <!-- Days of the month -->
        @for ($day = 1; $day <= $daysInMonth; $day++)
            @php
                $currentDate = \Carbon\Carbon::now()
                    ->startOfMonth()
                    ->addDays($day - 1)
                    ->format('Y-m-d');
            @endphp
            <div class="day">
                <div class="date">{{ $day }}</div>
                @if ($events->has($currentDate))
                    @foreach ($events[$currentDate] as $event)
                        <div class="event">
                            {{ $event->nama_peminjam }}<br>
                            {{ $event->ruangan->nama_ruangan }}<br>
                            {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('H:i') }}
                        </div>
                    @endforeach
                @endif
            </div>
        @endfor
    </div>
    <br>
    <div class="container">
        <center>
            <h2>Grafik Peminjaman Per Bulan</h2>
        </center>
        <canvas id="myLineChart" width="200" height="100"></canvas>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    </script>
@endsection
