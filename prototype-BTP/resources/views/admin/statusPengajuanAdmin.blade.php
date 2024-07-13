@extends('admin.layouts.mainAdmin')

@section('containAdmin')
    @php
        use Carbon\Carbon;
    @endphp

    <div class="container-fluid mt-4">
        <!-- Judul -->
        <div class="row">
            <div class="col-sm-6 col-md-6 col mb-0">
                <div class="container ml-4">
                    <h4>Pengajuan Ruangan <h4>
                </div>
            </div>
        </div>

        <!-- href ui -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
                <div class="container my-2 mx-2">
                    <a class="" href="" style="color:#028391;font-size:12px;font-weight: bold;">Status Ruangan</a>
                </div>
            </div>
        </div>

        <!-- Inside box status-search-table  -->
        <div class="p-3 border mb-2"
            style="border: 6px solid #61677A; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">

            <!-- Status -->

            <div class="row">
                <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-4 col-sm-2" style="margin-right:98px;">
                    <div class="container d-flex align-items-center">
                        <div class="status-icon left-status text-black d-flex align-items-center justify-content-center shadow"
                            style="background-color: #03FC0C;">
                            <span class="material-symbols-outlined my-0" style="font-size: 3.5em;">
                                check_circle
                            </span>
                        </div>
                        <div class="status-count right-status text-black text-justify shadow d-flex flex-column justify-content-center"
                            style="">
                            <p class="text-center mt-1 mb-2" style="font-size: 18px; margin-top: 8px;font-weight: bold;">
                                Disetujui</p>
                            <p class="text-center" style="font-size: 32px;margin-top: -4px;font-weight: bold;">
                                @php
                                    $bookedCount = $dataPeminjaman->where('status', 'Disetujui')->count();
                                @endphp
                                {{ $bookedCount }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-4 col-sm-2 ml-4" style="margin-right:98px;">
                    <div class="container d-flex align-items-center">
                        <div class="status-icon left-status text-black d-flex align-items-center justify-content-center shadow"
                            style="background-color: #FF0000;">
                            <span class="material-symbols-outlined my-0" style="font-size: 3.5em;">
                                cancel
                            </span>
                        </div>
                        <div class="status-count left-status text-black text-justify shadow d-flex flex-column justify-content-center"
                            style="">
                            <p class="text-center mt-1 mb-2" style="font-size: 18px; margin-top: 8px;font-weight: bold;">
                                Ditolak</p>
                            <p class="text-center" style="font-size: 32px;margin-top: -4px;font-weight: bold;">
                                @php
                                    $bookedCount = $dataPeminjaman->where('status', 'Ditolak')->count();
                                @endphp
                                {{ $bookedCount }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-4 col-sm-2 ml-4" style="margin-right:98px;">
                    <div class="container d-flex align-items-center">
                        <div class="status-icon left-status text-black d-flex align-items-center justify-content-center shadow"
                            style="background-color: #FCE303;">
                            <span class="material-symbols-outlined my-0" style="font-size: 3.5em;">
                                schedule
                            </span>
                        </div>
                        <div
                            class="text-center status-count right-status text-black text-justify shadow d-flex flex-column justify-content-center">
                            <p class="text-center mt-1 mb-2" style="font-size: 18px; margin-top: 8px;font-weight: bold;">
                                Menunggu</p>
                            <p class="text-center" style="font-size: 32px;margin-top: -4px;font-weight: bold;">
                                @php
                                    $bookedCount = $dataPeminjaman->where('status', 'Menunggu')->count();
                                @endphp
                                {{ $bookedCount }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and button add -->
            <div class="container mt-4 mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <input id="searchInput" onkeyup="liveSearch()" type="text" class="form-control"
                            placeholder="Cari pengajuan..."
                            style="width: 434px; height: 36px; border-radius: 6px; color: #070F2B; border: 2px solid #B1B1B1;">
                        {{-- <button id="searchButton" type="button" class="btn btn-md text-white text-center"
                style="margin-left:20px; background-color: #0EB100; border-radius: 6px;">Cari</button> --}}
                    </div>
                </div>
            </div>

            <!-- table edit -->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12">
                    <div class="container ml-4 mt-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center"
                                style="padding: 0.5rem; vertical-align: middle;font-size: 13px;text-transform: capitalize;">
                                <thead style="vertical-align: middle;">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Peminjam</th>
                                        <th scope="col">Nama Ruangan</th>
                                        <th scope="col">Jam Mulai</th>
                                        <th scope="col">Jam Selesai</th>
                                        <th scope="col">Tanggal Mulai</th>
                                        <th scope="col">Tanggal Selesai</th>
                                        <th scope="col" style="width: 230px;">Aksi</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="dataPengajuan">
                                    @foreach ($dataPeminjaman as $data)
                                        <tr>
                                            <td>{{ $loop->iteration + $dataPeminjaman->firstItem() - 1 }}</td>
                                            <td>{{ $data->nama_peminjam }}</td>
                                            <td>{{ $data->ruangan->nama_ruangan }}</td>
                                            <td>{{ Carbon::parse($data->tanggal_mulai)->format('H:i') }}</td>
                                            <td>{{ Carbon::parse($data->tanggal_selesai)->format('H:i') }}</td>
                                            <td>{{ Carbon::parse($data->tanggal_mulai)->format('d-m-Y') }}</td>
                                            <td>{{ Carbon::parse($data->tanggal_selesai)->format('d-m-Y') }}</td>
                                            @if ($data->status == 'Menunggu')
                                                <td class="d-flex justify-content-between" style="align-items: center;">
                                                    <form action="{{ route('update.pengajuan', $data->id_peminjaman) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="pilihan" id="pilihan">
                                                        <button type="button" name="pilihan" value='terima'
                                                            class="btn btn-outline-success"
                                                            style="border-radius:6px;width: 100px;font-size: 13px;text-transform: capitalize;">Setuju</button>
                                                        <button type="button" name="pilihan" value='tolak'
                                                            class="btn btn-outline-danger btn-styl"
                                                            style="border: 2px solid black;border-color: #FF2E26;color: red">Tolak</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a type="button" class="btn text-white btn-warning btn-styl warning"
                                                        style="padding: 8px">Menunggu</a>
                                                </td>
                                            @elseif($data->status == 'Disetujui')
                                                <td class="d-flex justify-content-between">
                                                    <form action="{{ route('update.pengajuan', $data->id_peminjaman) }}"
                                                        method="POST">
                                                        <a type="button" class="btn text-white"
                                                            style="background-color:#0EB100; border-radius:6px; width: 100px; font-size: 13px;text-transform: capitalize;">Setuju</a>
                                                        <a type="button" class="btn btn-outline-danger btn-styl"
                                                            style="">Tolak</a>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a type="button" class="btn text-white"
                                                        style="background-color:#0EB100; border-radius:6px;width: 100px;font-size: 13px;text-transform: capitalize;">Disetujui</a>
                                                </td>
                                            @elseif($data->status == 'Ditolak')
                                                <td class="d-flex justify-content-between">
                                                    <form action="{{ route('update.pengajuan', $data->id_peminjaman) }}"
                                                        method="POST">
                                                        <a type="button" class="btn btn-outline-success btn-styl"
                                                            style="">Setuju</a>
                                                        <a type="button" class="btn text-white btn-styl"
                                                            style="background-color: #FF2E26;">Tolak</a>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a type="button" class="btn text-white"
                                                        style="background-color: #FF2E26; border-radius:6px;width: 100px;font-size: 13px;text-transform: capitalize;">Ditolak</a>
                                                </td>
                                            @endif
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

            <!-- Modal Structure -->
            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Peminjaman</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin <span id="actionType"></span> peminjaman ini?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn text-white" data-bs-dismiss="modal"
                                style="background: #FF0000;">Batal</button>
                            <form id="confirmationForm" method="POST">
                                @csrf
                                <button type="submit" class="btn text-white"
                                    style="background-color: #0DA200;">Ya</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                    var confirmationForm = document.getElementById('confirmationForm');
                    var actionTypeSpan = document.getElementById('actionType');

                    document.querySelectorAll('.btn-outline-success, .btn-outline-danger').forEach(function(button) {
                        button.addEventListener('click', function(event) {
                            event.preventDefault();
                            var action = this.value === 'terima' ? 'menyetujui' : 'menolak';
                            actionTypeSpan.textContent = action;

                            confirmationForm.action = this.form.action;
                            confirmationForm.querySelector('button[type="submit"]').name = this.name;
                            confirmationForm.querySelector('button[type="submit"]').value = this.value;

                            confirmationModal.show();
                        });
                    });
                });
            </script>
            <script>
                function liveSearch() {
                    // Get the input field and its value
                    let input = document.getElementById('searchInput');
                    let filter = input.value.toLowerCase();
                    // Get the table and all table rows
                    let table = document.getElementById('dataPengajuan');
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

            <style>
                .table td,
                .table th {
                    padding: 10px;
                    /* Adjust the padding table */
                }

                .center-text {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 100px;
                }

                .left-status {
                    border-left: 1px;
                    border-right: 0px;
                    border-bottom: 1px;
                    border-top: 1px;
                    border-style: solid;
                    border-color: rgb(187, 187, 187);
                }

                .right-status {
                    border-left: 0px;
                    border-right: 1px;
                    border-bottom: 1px;
                    border-top: 1px;
                    border-style: solid;
                    border-color: rgb(187, 187, 187);
                }

                .status-count {
                    height: 100px;
                    background-color: #FFFFF;
                    padding: 11.5px;
                    width: 120px;
                    border-top-right-radius: 10px;
                    border-bottom-right-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
                }

                .status-icon {
                    height: 100px;
                    width: 80px;
                    padding: 10px;
                    border-right: 5px;
                    border-top-left-radius: 10px;
                    border-bottom-left-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
                }

                .btn-styl {
                    border-radius: 6px;
                    width: 100px;
                    font-size: 13px;
                    text-transform: capitalize;
                }

                .warning {
                    border-color: #ff9800;
                    color: orange;
                }
            </style>
        @endsection
