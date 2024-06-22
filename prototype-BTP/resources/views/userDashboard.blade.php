@extends('penyewa.layouts.mainPenyewa')
@section('containPenyewa')

    <div class="container-fluid mt-4">
        <!-- title -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="container">
                    <h4>Dashboard</h4>
                </div>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr id="weekDays">
                    @for ($day = 0; $day < 7; $day++)
                        <th>{{ $weekStart->copy()->addDays($day)->format('D, M d') }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                <tr id="weekData">
                    @for ($day = 0; $day < 7; $day++)
                        <td>
                            @foreach ($dataPeminjaman as $peminjaman)
                                @if (date('Y-m-d', strtotime($peminjaman->tanggal_mulai)) == $weekStart->copy()->addDays($day)->format('Y-m-d'))
                                    <div class="mb-2">
                                        <strong>{{ $peminjaman->ruangan->nama_ruangan }}</strong><br>
                                        {{ date('H:i', strtotime($peminjaman->tanggal_mulai)) }} -
                                        {{ date('H:i', strtotime($peminjaman->tanggal_selesai)) }}<br>
                                        Peminjam: {{ $peminjaman->nama_peminjam }}
                                    </div>
                                    <hr>
                                @endif
                            @endforeach
                        </td>
                    @endfor
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        let currentDate = new Date("{{ $weekStart->format('Y-m-d') }}");

        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="d-flex container my-2 mx-2">
                    <a href="" class="fw-bolder" style="color: red; font-size:12px;">&nbsp;Dashboard </a>
                </div>
            </div>
        </div>

        <div
            class="container mt-2 py-2"style="solid #61677A; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
            <h1>Weekly Schedule</h1>
            @php
                $weekStart = now()->startOfWeek();
            @endphp
            <div class="d-flex justify-content-between mb-3">
                <button id="prevWeek" class="btn btn-primary">Previous Week</button>
                <h2>Week of <span id="weekOf">{{ $weekStart->format('M d, Y') }}</span></h2>
                <button id="nextWeek" class="btn btn-primary">Next Week</button>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr id="weekDays">
                        @for ($day = 0; $day < 7; $day++)
                            <th>{{ $weekStart->copy()->addDays($day)->format('D, M d') }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    <tr id="weekData">
                        @for ($day = 0; $day < 7; $day++)
                            <td>
                                @foreach ($dataPeminjaman as $peminjaman)
                                    @if (date('Y-m-d', strtotime($peminjaman->tanggal_mulai)) == $weekStart->copy()->addDays($day)->format('Y-m-d'))
                                        <div class="mb-2">
                                            <strong>{{ $peminjaman->ruangan->nama_ruangan }}</strong><br>
                                            {{ date('H:i', strtotime($peminjaman->tanggal_mulai)) }} -
                                            {{ date('H:i', strtotime($peminjaman->tanggal_selesai)) }}<br>
                                            Peminjam: {{ $peminjaman->nama_peminjam }}
                                        </div>
                                        <hr>
                                    @endif
                                @endforeach
                            </td>
                        @endfor
                    </tr>
                </tbody>
            </table>
        </div>
        <script>
            let currentDate = new Date("{{ $weekStart->format('Y-m-d') }}");

            document.getElementById('prevWeek').addEventListener('click', function() {
                changeWeek(-7);
            });

            document.getElementById('nextWeek').addEventListener('click', function() {
                changeWeek(7);
            });

            function changeWeek(days) {
                currentDate.setDate(currentDate.getDate() + days);
                fetchWeekData(currentDate);
            }

            function fetchWeekData(date) {
                const formattedDate = date.toISOString().split('T')[0];
                fetch(`/user-dashboard?date=${formattedDate}`)
                    .then(response => response.json())
                    .then(data => {
                        updateTable(data);
                    });
            }

            function updateTable(data) {
                const weekOf = document.getElementById('weekOf');
                const weekDays = document.getElementById('weekDays');
                const weekData = document.getElementById('weekData');

                const startDate = new Date(data.weekStart);
                weekOf.innerText = startDate.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });

                weekDays.innerHTML = '';
                weekData.innerHTML = '';

                for (let day = 0; day < 7; day++) {
                    const currentDay = new Date(startDate);
                    currentDay.setDate(startDate.getDate() + day);
                    const dayHeader = document.createElement('th');
                    dayHeader.innerText = currentDay.toLocaleDateString('en-US', {
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric'
                    });
                    weekDays.appendChild(dayHeader);

                    const dayData = document.createElement('td');
                    const dayString = currentDay.toISOString().split('T')[0];
                    const dayEvents = data.events.filter(event => event.tanggal_mulai.startsWith(dayString));
                    dayEvents.forEach(event => {
                        const eventDiv = document.createElement('div');
                        eventDiv.classList.add('mb-2');
                        eventDiv.innerHTML = `
                    <strong>${event.ruangan.nama_ruangan}</strong><br>
                    ${new Date(event.tanggal_mulai).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })} -
                    ${new Date(event.tanggal_selesai).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })}<br>
                    Peminjam: ${event.nama_peminjam}
                    <hr>
                `;
                        dayData.appendChild(eventDiv);
                    });
                    weekData.appendChild(dayData);
                }
            }
        </script>
    @endsection
