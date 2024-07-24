@extends('admin.layouts.mainAdmin')

@section('containAdmin')
    @php
        use Carbon\Carbon;
    @endphp

    <head>
        <link rel="stylesheet" href="{{ asset('assets/css/admin/daftarRuangan.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.css" />
        <script src="{{ asset('assets/js/admin/daftarRuangan.js') }}"></script>
    </head>
    <div class="container-fluid mt-4">
        <!-- Judul -->
        <div class="row">
            <div class="col-sm-6 col-md-6 col mb-0">
                <div class="container ml-4">
                    <h4>Data Okupansi Peminjaman Ruangan</h4>
                </div>
            </div>
        </div>

        <!-- Month Navigation -->
        <div class="row mt-3">
            <div class="col-md-4">
                <form action="{{ route('admin.okupansi.index') }}" method="GET" class="d-inline">
                    <input type="hidden" name="month"
                        value="{{ Carbon::parse($selectedMonth)->subMonth()->format('Y-m') }}">
                    <button type="submit" class="btn btn-outline-primary">Previous Month</button>
                </form>
                <form action="{{ route('admin.okupansi.index') }}" method="GET" class="d-inline">
                    <input type="hidden" name="month"
                        value="{{ Carbon::parse($selectedMonth)->addMonth()->format('Y-m') }}">
                    <button type="submit" class="btn btn-outline-primary">Next Month</button>
                </form>
            </div>
        </div>

        <!-- Display Current Month -->
        <div class="row mt-3">
            <div class="col-md-12">
                <h5 class="text-center">
                    Data for: {{ Carbon::parse($selectedMonth)->translatedFormat('F Y') }}
                </h5>
            </div>
        </div>

        <!-- Tabel -->
        <div class="row mt-3 justify-content-center">
            <div class="col-md-11">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            @foreach ($dataRuangan as $dr)
                                <th>{{ $dr->nama_ruangan }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataByDayAndRoom as $date => $rooms)
                            <tr>
                                <td>{{ $date }}</td>
                                @foreach ($dataRuangan as $dr)
                                    <td>{{ $rooms[$dr->nama_ruangan] ?? 0 }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                        <tr>
                            <td>Jumlah</td>
                            @foreach ($dataRuangan as $dr)
                                <td>{{ $totalByRoom[$dr->nama_ruangan] ?? 0 }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td colspan="{{ count($dataRuangan) }}">{{ $totalOverall }}</td>
                        </tr>
                        <tr>
                            <td>Kapasitas penggunaan per ruangan (jumlah orang)</td>
                            @foreach ($dataRuangan as $dr)
                                <td>{{ $dr->kapasitas_maksimal }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>1 Sesi 4 Jam, 1 hari 3 sesi</td>
                            @foreach ($dataRuangan as $dr)
                                <td>{{ $dr->kapasitas_maksimal * 3 }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Penggunaan kapasitas maksimum per ruangan dalam 1 bulan (31 hari)</td>
                            @foreach ($dataRuangan as $dr)
                                <td>{{ $dr->kapasitas_maksimal * 3 * 31 }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Kapasitas maksimum semua ruangan</td>
                            <td colspan="{{ count($dataRuangan) }}">
                                @php
                                    $totalCapacityMonthly = $dataRuangan->reduce(function ($carry, $dr) {
                                        return $carry + $dr->kapasitas_maksimal * 3 * 31;
                                    }, 0);
                                @endphp
                            </td>
                        </tr>
                        <tr>
                            <td>Okupansi pemakaian per ruangan di BTP (dalam %)</td>
                            @foreach ($dataRuangan as $dr)
                                @php
                                    $totalCapacity = $dr->kapasitas_maksimal * 3 * 31;
                                    $totalOccupancy = $totalByRoom[$dr->nama_ruangan] ?? 0;
                                    $occupancyPercentage =
                                        $totalCapacity > 0 ? ($totalOccupancy / $totalCapacity) * 100 : 0;
                                @endphp
                                <td>{{ number_format($occupancyPercentage, 2) }}%</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Okupansi pemakaian ruangan di BTP (dalam %)</td>
                            <td colspan="{{ count($dataRuangan) }}">
                                {{ number_format(($totalOverall / $totalCapacityMonthly) * 100, 2) }}%
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
