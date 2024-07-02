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

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endsection
