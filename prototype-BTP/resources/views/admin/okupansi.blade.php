@extends('admin.layouts.mainAdmin')

@section('containAdmin')
    @php
        use Carbon\Carbon;
        use Illuminate\Support\Facades\App;

        App::setLocale('id');
    @endphp
    {{-- @foreach ($dataPeminjaman as $data) --}}
    {{-- <h1>{{ $data->id_ruangan }}</h1> --}}
    {{-- @endforeach --}}

    <head>
        <link rel="stylesheet" href="{{ asset('assets/css/admin/daftarRuangan.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.css" />
        <script src="assets/js/admin/daftarRuangan.js"></script>
    </head>
    <div class="container-fluid mt-4">
        <!-- Judul -->
        <div class="row">
            <div class="col-sm-6 col-md-6 col mb-0">
                <div class="container ml-4">
                    <h4>Data Okupansi Peminjaman Ruangan<h4>
                </div>
            </div>
        </div>

        <!-- href ui -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
                <div class="container my-2 mx-2">
                    <a class="" href="/okupansiRuangan" style="color: #028391;font-size:12px;font-weight: bold;">Data
                        Okupansi Peminjaman Ruangan</a>
                </div>
            </div>
        </div>

        <!-- Inside box status-search-table  -->
        <div class="p-3 border mb-2"
            style="border: 6px solid #61677A; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">

            <!-- Search and button add -->
            <div class="container mt-4 mb-2">
                <div class="row">
                    <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
                        <input id="searchInput" onkeyup="liveSearch()" type="text" class="form-control"
                            placeholder="Cari data okupansi peminjaman ruangan..."
                            style="width: 100%; height: 36px; border-radius: 6px; color: #070F2B; border: 2px solid #B1B1B1;">
                        {{-- <button type="button" class="btn btn-md text-white text-center"
                            style="margin-left:20px; background-color: #0EB100; border-radius: 6px;">Cari</button> --}}
                    </div>
                    <div class="col-md-5"></div>
                    <div class="col-12 col-md-2 d-flex justify-content-md-end align-items-center">
                        <a href="{{ route('download.okupansi') }}" class="btn btn-md text-white text-center w-100 w-md-auto"
                            style="background-color: #0EB100; border-radius: 6px">Download CSV</a>
                    </div>
                </div>
            </div>

            <!-- table okupansi -->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-6">
                    <div class="container ml-4 mt-4">
                        <div class="table-responsive">
                            <table id="dataTOkupansi" class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center " rowspan="3">Hari</th>
                                        <th scope="col" class="text-center text-wrap" colspan="8">
                                            Bulan <br>
                                            @php
                                                $bulan = Carbon::now()->translatedFormat('F');
                                                echo $bulan;
                                            @endphp
                                        </th>
                                    </tr>
                                    <tr>
                                        @foreach ($dataRuangan as $dr)
                                            <th class="text-center">
                                                {{ $dr->nama_ruangan }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody id="dataHistory">
                                    @php
                                        $daysOfWeek = [];
                                        for ($i = 0; $i < 7; $i++) {
                                            $daysOfWeek[] = Carbon::now()
                                                ->startOfWeek()
                                                ->addDays($i)
                                                ->translatedFormat('l');
                                        }
                                    @endphp
                                    @foreach ($daysOfWeek as $day)
                                        <tr>
                                            <td>{{ $day }}</td>
                                            @foreach ($dataRuangan as $dr)
                                                <td>
                                                    {{-- Tampilkan jumlah peminjaman untuk hari dan ruangan ini --}}
                                                    {{ $dataByDayAndRoom[$day][$dr->nama_ruangan] ?? 0 }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>Jumlah</td>
                                        @foreach ($dataRuangan as $dr)
                                            <td>
                                                {{-- Tampilkan total peminjaman untuk ruangan ini --}}
                                                {{ $totalByRoom[$dr->nama_ruangan] ?? 0 }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr class="table-active">
                                        <td>
                                            Total
                                        </td>
                                        <td colspan="{{ count($dataRuangan) }}">
                                            {{-- Tampilkan total peminjaman untuk semua ruangan --}}
                                            {{ $totalOverall }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-wrap">Kapasitas penggunaan per ruangan (jumlah orang)</td>
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
                                    <tr class="table-active">
                                        <td>Kapasitas maksimum semua ruangan</td>
                                        @php
                                            $totalCapacityMonthly = $dataRuangan->reduce(function ($carry, $dr) {
                                                return $carry + $dr->kapasitas_maksimal * 3 * 31;
                                            }, 0);
                                        @endphp
                                        <td colspan="{{ count($dataRuangan) }}">{{ $totalCapacityMonthly }}</td>
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
                                    <tr class="table-active">
                                        <td>Okupansi pemakaian ruangan di BTP (dalam %)</td>
                                        @php
                                            $occupancyOverallPercentage =
                                                $totalCapacityMonthly > 0
                                                    ? ($totalOverall / $totalCapacityMonthly) * 100
                                                    : 0;
                                        @endphp
                                        <td colspan="{{ count($dataRuangan) }}">
                                            {{ number_format($occupancyOverallPercentage, 2) }}%
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{-- {{ $dataRuangan->links('vendor.pagination.custom') }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <!-- Confirmation Modal -->
        <div id="confirmationModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="circle-add">
                            <span class="material-symbols-outlined" style="font-size: 3.5em; color: #FFFFFF;">delete</span>
                        </div>
                        <p style="margin-top: 10px;">Apakah ruangan Multimedia ingin dihapus?</p>
                        <button type="button" class="btn"
                            style="background-color: #B0B0B0; color: white; margin-right: 30px;"
                            onclick="closeConfirmationModal()">TIDAK</button>
                        <button type="button" class="btn" style="background-color: #FF0000; color: white;"
                            id="confirmDelete">YA</button>
                    </div>
                </div>
            </div>
        </div> --}}



        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.1.0/js/dataTables.js"></script>

        <script>
            $(document).ready(function() {
                $('#dataTOkupansi').DataTable({
                    "paging": false,
                    "searching": false,
                    "ordering": true,
                    "info": true
                });
            });
        </script>
        <script>
            function liveSearch() {
                // Get the input field and its value
                let input = document.getElementById('searchInput');
                let filter = input.value.toLowerCase();

                // Get the table and all table rows
                let table = document.getElementById('dataHistory');
                let tr = table.getElementsByTagName('tr');

                // Loop through all table rows, and hide those who don't match the search query
                for (let i = 0; i < tr.length; i++) {
                    let td = tr[i].getElementsByTagName('td');
                    let rowContainsFilter = false;

                    // Check each cell in the row
                    for (let j = 0; j < td.length; j++) {
                        if (td[j]) {
                            let textValue = td[j].textContent || td[j].innerText;
                            if (textValue.toLowerCase().indexOf(filter) > -1) {
                                rowContainsFilter = true;
                                break;
                            }
                        }
                    }

                    // Show or hide the row based on the filter
                    if (rowContainsFilter) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        </script>
    @endsection
