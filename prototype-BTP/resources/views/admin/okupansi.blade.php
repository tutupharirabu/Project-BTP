@extends('admin.layouts.mainAdmin')

@section('containAdmin')
    @php
        use Carbon\Carbon;
    @endphp

    <head>
        <link rel="stylesheet" href="{{ asset('assets/css/admin/daftarRuangan.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.css" />
        <script src="{{ asset('assets/js/admin/daftarRuangan.js') }}"></script>
        <script defer src="https://umami-web-analytics.tutupharirabu.cloud/script.js"
            data-website-id="7a76e24b-1d1b-4594-8a26-7fcc2765570a"></script>
    </head>
    <div class="container-fluid mt-4">
        <!-- Judul -->
        <div class="row">
            <div class="col-sm-6 col-md-6 col mb-0">
                <h4>Data Okupansi Peminjama/Penyewaan Ruangan</h4>
            </div>
        </div>

        <!-- Month Navigation -->
        <div class="row mt-3">
            <div class="col-md-10">
                <form action="{{ route('admin.okupansi.index') }}" method="GET" class="d-inline">
                    <input type="hidden" name="month"
                        value="{{ Carbon::parse($selectedMonth)->subMonth()->format('Y-m') }}">
                    <button type="submit" class="btn btn-outline-primary text-capitalize mb-2">Bulan Sebelumnya</button>
                </form>
                <form action="{{ route('admin.okupansi.index') }}" method="GET" class="d-inline">
                    <input type="hidden" name="month"
                        value="{{ Carbon::parse($selectedMonth)->addMonth()->format('Y-m') }}">
                    <button type="submit" class="btn btn-outline-primary text-capitalize mb-2">Bulan Selanjutnya</button>
                </form>
            </div>
            <div class="col-md-2 justify-content-md-end">
                <a href="{{ route('download.okupansi') }}" class="btn btn-md text-white text-center w-100 w-md-auto mb-2"
                    style="background-color: #0EB100; border-radius: 6px">Download CSV</a>
            </div>
        </div>

        <!-- Display Current Month -->
        <div class="row mt-3">
            <div class="col-md-12">
                <h5 class="text-center">
                    Bulan {{ Carbon::parse($selectedMonth)->translatedFormat('F Y') }}
                </h5>
            </div>
        </div>

        <!-- Tabel -->
        <div class="row mt-3 justify-content-center">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered table-striped ">
                    <thead>
                        <tr>
                            <th class="text-center">Hari</th>
                            @foreach ($dataRuangan as $dr)
                                <th>{{ $dr->nama_ruangan }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dayOrder as $day)
                            <tr>
                                <td>{{ $day }}</td>
                                @foreach ($dataRuangan as $dr)
                                    <td class="text-center">{{ $dataByDayAndRoom[$day][$dr->nama_ruangan] ?? 0 }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                        <tr>
                            <td>Jumlah</td>
                            @foreach ($dataRuangan as $dr)
                                <td class="text-center">{{ $totalByRoom[$dr->nama_ruangan] ?? 0 }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td colspan="{{ count($dataRuangan) }}" class="text-center">{{ $totalOverall }}</td>
                        </tr>
                        <tr>
                            <td>Kapasitas ruangan</td>
                            @foreach ($dataRuangan as $dr)
                                <td class="text-center">{{ $dr->kapasitas_maksimal }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>1 Sesi 4 Jam, 1 hari 3 sesi</td>
                            @foreach ($dataRuangan as $dr)
                                <td class="text-center">{{ $dr->kapasitas_maksimal * 3 }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Penggunaan kapasitas maksimum per ruangan dalam 1 bulan (31 hari)</td>
                            @foreach ($dataRuangan as $dr)
                                <td class="text-center">{{ $dr->kapasitas_maksimal * 3 * 31 }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Kapasitas maksimum semua ruangan</td>
                            @php
                                $totalCapacityMonthly = $dataRuangan->reduce(function ($carry, $dr) {
                                    return $carry + $dr->kapasitas_maksimal * 3 * 31;
                                }, 0);
                            @endphp
                            <td colspan="{{ count($dataRuangan) }}" class="text-center">{{ $totalCapacityMonthly }}</td>
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
                                                    <td class="text-center">{{ number_format($occupancyPercentage, 2) }}%</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Okupansi pemakaian ruangan di BTP (dalam %)</td>
                            <td colspan="{{ count($dataRuangan) }}" class="text-center">
                                {{ number_format(($totalOverall / $totalCapacityMonthly) * 100, 2) }}%
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const aaa = {{ $totalOverall }};
        console.log(aaa);
    </script>
@endsection