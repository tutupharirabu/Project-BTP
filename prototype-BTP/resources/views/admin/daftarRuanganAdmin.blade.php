@extends('admin.layouts.mainAdmin')

@section('containAdmin')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.bootstrap5.css" />

    <head>
        <link rel="stylesheet" href="{{ asset('assets/css/admin/daftarRuangan.css') }}">
        <script src="assets/js/admin/daftarRuangan.js"></script>
        <script defer src="https://umami.tutupharirabu.cloud/script.js" data-website-id="6552bf4a-7391-40fb-8e93-e35363bb72f5"></script>
    </head>
    <div class="container-fluid mt-4">
        <!-- Judul -->
        <div class="row">
            <div class="col-sm-6 col-md-6 col mb-0">
                <div class="container ml-4">
                    <h4>Daftar Ruangan<h4>
                </div>
            </div>
        </div>

        <!-- href ui -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
                <div class="container my-2 mx-2">
                    <a class="" href="" style="color: #028391;font-size:12px;font-weight: bold;">Daftar
                        Ruangan</a>
                </div>
            </div>
        </div>

        <!-- Inside box status-search-table  -->
        <div class="p-3 border mb-2"
            style="border: 6px solid #61677A; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">

            <!-- Status -->
            <div class="row">
                <div class="col-12 d-flex justify-content-start" style="margin-left:54px;">
                    <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-4 col-sm-2 mt-2" style="margin-right:98px;">
                        <div class="container d-flex justify-content-md-start justify-content-sm-start">
                            <div class="left-status text-black d-flex align-items-center justify-content-center shadow icon-color"
                                style=" background-color: #071FF2;">
                                <span class="material-symbols-outlined my-0" style="font-size: 3.5em;color:#FFFFFF;">
                                    check_circle
                                </span>
                            </div>
                            <div
                                class="right-status text-black text-justify shadow d-flex flex-column justify-content-center anouncement">
                                <p class="text-center mt-1 mb-2 font-dv">
                                    Tersedia</p>
                                <p class="text-center count">
                                    @php
                                        $bookedCount = $dataRuangan->where('tersedia', '1')->count();
                                    @endphp
                                    {{ $bookedCount }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-4 col-sm-2 ml-4 mt-2" style="margin-right:98px;">
                        <div class="container d-flex align-items-center">
                            <div class="left-status text-black d-flex align-items-center justify-content-center shadow icon-color"
                                style="background-color: #717171;">
                                <span class="material-symbols-outlined my-0" style="font-size: 3.5em;color:#FFFFFF;">
                                    cancel
                                </span>
                            </div>
                            <div
                                class="right-status text-black text-justify shadow d-flex flex-column justify-content-center anouncement">
                                <p class="text-center mt-1 mb-2 font-dv">
                                    Digunakan</p>
                                <p class="text-center count">
                                    @php
                                        $bookedCount = $dataRuangan->where('tersedia', '0')->count();
                                    @endphp

                                    {{ $bookedCount }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and button add -->
            <div class="container mt-4 mb-2">
                <div class="row">
                    {{-- <div class="col-12 col-md-8 col-lg-6 mb-3 mb-md-0 d-flex align-items-center"> --}}
                    {{-- <input id="searchInput" onkeyup="liveSearch()" type="text" class="form-control"
                            placeholder="Cari ruangan..."
                            style="border-radius: 6px; color: #070F2B; border: 2px solid #B1B1B1;"> --}}
                    {{-- <button id="searchButton" type="button" class="btn btn-md text-white text-center"
                            style="margin-left:20px; background-color: #0EB100; border-radius: 6px;">Cari</button> --}}
                    {{-- </div> --}}
                    {{-- <div class="col-md-2 col-lg-4 "></div> --}}
                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                        <a href="/tambahRuanganAdmin"
                            class="btn btn-md text-white text-center text-capitalize w-22 w-md-auto"
                            style="background-color: #0EB100; border-radius: 6px;"> Tambah Ruangan +</a>
                    </div>
                </div>
            </div>
            {{-- <div class="container mt-4 mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <input id="searchInput" onkeyup="liveSearch()" type="text" class="form-control"
                            placeholder="Cari ruangan..."
                            style="width: 434px; height: 36px; border-radius: 6px; color: #070F2B; border: 2px solid #B1B1B1;">
                            <button id="searchButton" type="button" class="btn btn-md text-white text-center"
                            style="margin-left:20px; background-color: #0EB100; border-radius: 6px;">Cari</button>
                    </div>
                    <a href="/tambahRuanganAdmin" class="btn btn-md text-white text-center text-capitalize"
                        style="background-color: #0EB100; border-radius: 6px"> Tambah Ruangan +</a>
                </div>
            </div> --}}

            <!-- table edit -->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-6">
                    <div class="container ml-4 mt-4">
                        <div class="table-responsive">
                            <table id="dataTRuangan" class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No </th>
                                        <th scope="col" class="text-center">Nama Ruangan</th>
                                        <th scope="col" class="text-center">Nama Gedung</th>
                                        {{-- <th scope="col" class="text-center">Ukuran Ruangan</th> --}}
                                        <th scope="col" class="text-center">Minimal Kapasitas</th>
                                        <th scope="col" class="text-center">Maksimal Kapasitas</th>
                                        <th scope="col" class="text-center">Harga </th>
                                        <th scope="col" class="text-center">Gambar </th>
                                        <th scope="col" class="text-center">Fasilitas</th>
                                        <th scope="col" class="text-center">Status </th>
                                        <th scope="col" class="text-center">Perbaharui oleh</th>
                                        <th scope="col" class="text-center">Action </th>
                                    </tr>
                                </thead>
                                <tbody id="dataRuangan">
                                    @foreach ($dataRuangan as $data)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $data->nama_ruangan }}</td>
                                            <td>{{ $data->lokasi }}</td>
                                            {{-- <td>{{ $data->ukuran }}</td> --}}
                                            <td class="text-center">{{ $data->kapasitas_minimal }}</td>
                                            <td class="text-center">{{ $data->kapasitas_maksimal }}</td>
                                            <td>Rp {{ number_format((int) $data->harga_ruangan, 0, ',', '.') }} /
                                                {{ $data->satuan }}
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-success btn-sm text-capitalize"style="background-color: #0EB100;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#imageModal{{ $data->id_ruangan }}">
                                                    Gambar
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="imageModal{{ $data->id_ruangan }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Gambar
                                                                    Ruangan</h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div id="carouselExampleIndicators{{ $data->id_ruangan }}"
                                                                    class="carousel slide" data-bs-ride="carousel">
                                                                    <div class="carousel-indicators">
                                                                        @php
                                                                            // Urutkan gambar berdasarkan indeks dalam public_id (image_1, image_2, dll)
                                                                            $sortedGambar = collect($data->gambar)
                                                                                ->sortBy(function ($gambar) {
                                                                                    // Ekstrak nomor indeks dari URL
                                                                                    preg_match(
                                                                                        '/_image_(\d+)/',
                                                                                        $gambar->url,
                                                                                        $matches,
                                                                                    );
                                                                                    return isset($matches[1])
                                                                                        ? (int) $matches[1]
                                                                                        : 999; // Jika tidak ada pattern, letakkan di akhir
                                                                                })
                                                                                ->values();
                                                                        @endphp
                                                                        @foreach ($sortedGambar as $index => $gambar)
                                                                            <button type="button"
                                                                                data-bs-target="#carouselExampleIndicators{{ $data->id_ruangan }}"
                                                                                data-bs-slide-to="{{ $index }}"
                                                                                class="{{ $index == 0 ? 'active' : '' }}"></button>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="carousel-inner"
                                                                        style="border-radius:5px;">
                                                                        @foreach ($sortedGambar as $index => $gambar)
                                                                            <div
                                                                                class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                                <img src="{{ asset($gambar->url) }}"
                                                                                    class="d-block w-100"
                                                                                    alt="Gambar Ruangan"
                                                                                    style="max-height: 300px;">
                                                                                <!-- Membuat public_id berdasarkan urutan gambar -->
                                                                                <div class="text-center mt-2">
                                                                                    @php
                                                                                        // Ekstrak nomor indeks dari URL untuk menampilkan
                                                                                        preg_match(
                                                                                            '/_image_(\d+)/',
                                                                                            $gambar->url,
                                                                                            $matches,
                                                                                        );
                                                                                        $imageNumber = isset(
                                                                                            $matches[1],
                                                                                        )
                                                                                            ? $matches[1]
                                                                                            : $index + 1;
                                                                                        $public_id =
                                                                                            $data->id_ruangan .
                                                                                            '_' .
                                                                                            'image_' .
                                                                                            $imageNumber;
                                                                                    @endphp
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                    <button class="carousel-control-prev" type="button"
                                                                        data-bs-target="#carouselExampleIndicators{{ $data->id_ruangan }}"
                                                                        data-bs-slide="prev" style="color:#028391">
                                                                        <span class="carousel-control-prev-icon"></span>
                                                                    </button>
                                                                    <button class="carousel-control-next" type="button"
                                                                        data-bs-target="#carouselExampleIndicators{{ $data->id_ruangan }}"
                                                                        data-bs-slide="next" style="color:#028391">
                                                                        <span class="carousel-control-next-icon"></span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-success btn-sm text-capitalize"style="background-color: #0EB100;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $data->id_ruangan }}">
                                                    Fasilitas
                                                </button>

                                                <div class="modal fade" id="exampleModal{{ $data->id_ruangan }}"
                                                    tabindex="-1"
                                                    aria-labelledby="exampleModalLabel{{ $data->id_ruangan }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="exampleModalLabel{{ $data->id_ruangan }}">
                                                                    Fasilitas Ruangan</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {!! nl2br(e($data->keterangan)) !!}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="justify-content: center;">
                                                @if ($data->status == 'Tersedia')
                                                    <a class="btn text-white status"
                                                        style=" background-color: #0EB100; ">Tersedia</a>
                                                @elseif ($data->status == 'Digunakan')
                                                    <a class="btn text-dark status"
                                                        style=" background-color: #B0B0B0; ">Digunakan</a>
                                                @else
                                                    <a class="btn text-white status" style=" background-color: #61677A; ">
                                                        - </a>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach ($data->users as $user)
                                                    {{ $user->username }}
                                                    <br>
                                                @endforeach
                                            </td>
                                            <td>
                                                <div style="display: flex; gap: 5px; justify-content: center;">
                                                    <a href="/editRuanganAdmin/{{ $data->id_ruangan }}/edit"
                                                        class="btn text-white modify"
                                                        style="background-color: #E0AF00;">Edit</a>
                                                    <button class="btn text-white delete-btn modify"
                                                        data-id="{{ $data->id_ruangan }}"
                                                        style="background-color: #FF0000;">Hapus</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                            <span class="material-symbols-outlined"
                                style="font-size: 3.5em; color: #FFFFFF;">delete</span>
                        </div>
                        <p style="margin-top: 10px;">Apakah ruangan ini ingin dihapus?</p>
                        <button type="button" class="btn"
                            style="background-color: #B0B0B0; color: white; margin-right: 30px;"
                            onclick="closeConfirmationModal()">TIDAK</button>
                        <button type="button" class="btn" style="background-color: #FF0000; color: white;"
                            id="confirmDelete">YA</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.1.3/js/dataTables.bootstrap5.js"></script>

        <script>
            $(document).ready(function() {
                $('#dataTRuangan').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": false,
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
                let table = document.getElementById('dataRuangan');
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
