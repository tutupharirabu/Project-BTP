@extends('admin.layouts.mainAdmin')

@section('containAdmin')
    @php
        use Carbon\Carbon;
    @endphp
    @foreach ($dataPeminjaman as $data)
        {{-- <h1>{{ $data->id_ruangan }}</h1> --}}
    @endforeach

    <head>
        <link rel="stylesheet" href="{{ asset('assets/css/admin/daftarRuangan.css') }}">
        <script src="assets/js/admin/daftarRuangan.js"></script>
    </head>
    <div class="container-fluid mt-4">
        <!-- Judul -->
        <div class="row">
            <div class="col-sm-6 col-md-6 col mb-0">
                <div class="container ml-4">
                    <h4>Riwayat Peminjaman Ruangan<h4>
                </div>
            </div>
        </div>

        <!-- href ui -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
                <div class="container my-2 mx-2">
                    <a class="" href="/riwayatRuangan" style="color: red;font-size:12px;font-weight: bold;">Riwayat</a>
                </div>
            </div>
        </div>

        <!-- Inside box status-search-table  -->
        <div class="p-3 border mb-2"
            style="border: 6px solid #61677A; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">

            <!-- Search and button add -->
            <div class="container mt-4 mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <input id="searchInput" onkeyup="liveSearch()" type="text" class="form-control"
                            placeholder="Cari riwayat..."
                            style="width: 434px; height: 36px; border-radius: 6px; color: #070F2B; border: 2px solid #B1B1B1;">
                        {{-- <button type="button" class="btn btn-md text-white text-center"
                            style="margin-left:20px; background-color: #0EB100; border-radius: 6px;">Cari</button> --}}
                    </div>
                    <a href="{{ route('download.riwayat') }}" class="btn btn-md text-white text-center"
                        style="background-color: #0EB100; border-radius: 6px">Download CSV</a>
                </div>
            </div>

            <!-- table edit -->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-6">
                    <div class="container ml-4 mt-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Peminjam</th>
                                        <th scope="col">Tanggal Mulai</th>
                                        <th scope="col">Tanggal Selesai</th>
                                        <th scope="col">Ruangan</th>
                                        <th scope="col">Kapasitas</th>
                                    </tr>
                                </thead>
                                <tbody id="dataHistory">
                                    @foreach ($dataPeminjaman as $data)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $data->nama_peminjam }}
                                            </td>
                                            <td>
                                                {{ Carbon::parse($data->tanggal_mulai)->format('d-m-y') }}
                                            </td>
                                            <td>
                                                {{ Carbon::parse($data->tanggal_selesai)->format('d-m-y') }}
                                            </td>
                                            <td>
                                                {{ $data->ruangan->nama_ruangan }}
                                            </td>
                                            <td>
                                                {{ $data->jumlah }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $dataPeminjaman->links('vendor.pagination.custom') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
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
        </div>



        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
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
