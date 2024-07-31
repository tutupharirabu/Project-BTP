@extends('penyewa.layouts.mainPenyewa')

@section('containPenyewa')
    <div class="container-fluid mt-4">
        <!-- title -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="container mx-2">
                    <h4>Detail Ruangan</h4>
                </div>
            </div>
        </div>
        <!-- href ui -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="d-flex container my-2 mx-2">
                    <a href="/daftarRuanganPenyewa" class="fw-bolder" style="color: #797979; font-size:12px; ">Daftar Ruangan
                        > </a>
                    <a href="" class="fw-bolder" style="color: #028391; font-size:12px;">&nbsp;Detail Ruangan </a>
                </div>
            </div>
        </div>

        <!-- value -->
        <input type="hidden" id="roomId" value="{{ $ruangan->id_ruangan }}">

        <div class="row justify-content-center mt-4">
            <div class="col-lg-6">

                <!-- <img src="https://btp.telkomuniversity.ac.id/wp-content/uploads/2022/09/DSC00331-2048x1365.jpg" class="img-fluid" alt="Responsive image"> -->

                <!-- Carousel -->
                <div id="demo" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach ($ruangan->gambar as $index => $gambar)
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="{{ $index }}"
                                class="{{ $index == 0 ? 'active' : '' }}"></button>
                        @endforeach
                    </div>

                    <div class="carousel-inner" style="border-radius:5px;">
                        @foreach ($ruangan->gambar as $index => $gambar)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('assets/' . $gambar->url) }}" alt="Gambar {{ $index + 1 }}"
                                    class="d-block w-100 custom-carousel-img">
                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev"
                        style="color:#028391; left: -14%;">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next"
                        style="color:#028391; right: -14%">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container-fluid mt-5 w-70 d-flex justify-content-center">
                <table class="table table-striped p-0" style="width: 80%; font-size:20px;">
                    <tbody>
                        <tr>
                            <td class="border border-secondary">Nama Ruangan</td>
                            <td colspan="3" class="border border-secondary">{{ $ruangan->nama_ruangan }}</td>
                        </tr>
                        <tr>
                            <td class="border border-secondary">Kapasitas Minimal</td>
                            <td colspan="3" class="border border-secondary">{{ $ruangan->kapasitas_minimal }}</td>
                        </tr>
                        <tr>
                            <td class="border border-secondary">Kapasitas Maksimal</td>
                            <td colspan="3" class="border border-secondary">{{ $ruangan->kapasitas_maksimal }}</td>
                        </tr>
                        <tr>
                            <td class="border border-secondary">Lokasi</td>
                            <td colspan="3" class="border border-secondary">{{ $ruangan->lokasi }}</td>
                        </tr>
                        <tr>
                            <td class="border border-secondary">Harga</td>
                            <td colspan="3" class="border border-secondary">Rp
                                {{ number_format((int) $ruangan->harga_ruangan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="border border-secondary">Status</td>
                            <td colspan="3" class="border border-secondary">
                                {{-- btn ketersediaan --}}
                                <button type="button boder" class="btn text-white"
                                    style="font-size:16px;background-color: #419343; border-radius: 10px; height: 31.83px; width: 200px; display: flex; align-items: center; justify-content: center;"
                                    data-bs-toggle="modal" data-bs-target="#lihatKetersediaanModal">
                                    Lihat ketersediaan
                                </button>
                                {{-- @if ($ruangan->tersedia == '1')
                                    <div type="button boder" class="btn btn-sm text-white"
                                        style="font-size:16px;background-color: #021BFF; border-radius: 10px; height: 31.83px; width: 120px; display: flex; align-items: center; justify-content: center;">
                                        Tersedia
                                    </div>
                                @elseif($ruangan->tersedia == '0')
                                    <div type="button boder" class="btn btn-sm text-white"
                                        style="font-size:16px;background-color: #555555; border-radius: 10px; height: 31.83px; width: 120px; display: flex; align-items: center; justify-content: center;">
                                        Digunakan
                                    </div>
                                @endif --}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="container-fluid mt-4 mb-6 d-md-flex d-xl-flex d-lg-flex justify-content-between"
                style="width: 80%;">
                <div class="text-black">
                    <p>Keterangan :</p>
                    <p>*Harga di atas belum termasuk PPN 11% (sesuai dengan ketentuan regulasi yang berlaku)</p>
                    <p> **Untuk informasi lebih lengkap lihat <a
                            href="https://drive.google.com/file/d/1V0KMW2frSiv1uw8X_GSyBiGABFQySqy-/view?usp=sharing"
                            target="_blank">disini</a></p>
                </div>
                <!-- <div class="">
                    <a type="button" class="btn btn-sm text-white"
                        style="background-color: #021BFF; font-size: 16px; border-radius: 7px;"
                        href="{{ route('penyewa.peminjamanRuanganDariDetail', ['id' => $ruangan->id_ruangan]) }}">Pinjam
                        Ruangan</a>
                </div> -->
                <div class="">
                    @if ($ruangan->tersedia == '1')
                        <a type="button" class="btn btn-sm text-white"
                            style="background-color: #021BFF; font-size: 16px; border-radius: 7px;"
                            href="{{ route('penyewa.peminjamanRuanganDariDetail', ['id' => $ruangan->id_ruangan]) }}">Pinjam
                            Ruangan</a>
                    @else
                        <a type="button" class="btn btn-sm text-white disabled"
                            style="background-color: #021BFF; font-size: 16px; border-radius: 7px;"
                            href="#">Pinjam Ruangan</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>

    {{-- modal ketersediaan --}}
    <div class="modal fade" id="lihatKetersediaanModal" tabindex="-1" aria-labelledby="lihatKetersediaanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="text-align: center;">
                <div class="modal-header d-flex justify-content-center align-items-center position-relative">
                    <h5 class="modal-title mx-auto" id="lihatKetersediaanModalLabel">Ketersediaan Ruangan</h5>
                    <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="d-flex justify-content-center my-3">
                        <div class="w-50">
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" value="per_minggu" autocomplete="off" checked>
                                <label class="btn btn-outline-black text-capitalize w-50" for="btnradio1" style="font-size:13px;">Per Minggu</label>

                                <input type="radio" class="btn-check" name="btnradio" id="btnradio2" value="per_bulan" autocomplete="off">
                                <label class="btn btn-outline-black text-capitalize w-50" for="btnradio2" style="font-size:13px;">Per Bulan</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="form-content">
                            <!-- Default content for Per Minggu or Per Bulan will be loaded here -->
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center" id="modal-footer-content">
                        <!-- Default content for Footer will be loaded here -->
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal for event details -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header " style="">
                    <h5 class="modal-title" id="eventModalLabel">Detail Peminjaman</h5>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Peminjam : </strong> <span id="modalNamaP"></span></p>
                    <p><strong>Nama Ruangan : </strong> <span id="modalRuangan"></span></p>
                    <p><strong>Mulai : </strong> <span id="modalStart"></span></p>
                    <p><strong>Selesai :</strong> <span id="modalEnd"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn text-white text-capitalize" data-dismiss="modal" data-bs-dismiss="modal" style="background-color: #0DA200; font-size:15px;">Close</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table td,
        .table th {
            font-size: 20px;
            /* Mengubah ukuran teks */
            padding: 0.5rem;
            /* Mengurangi padding */
        }

        .btn {
            font-size: 20px;
            /* Ukuran teks pada tombol */
            text-transform: capitalize;
        }

        .custom-carousel-img {
            width: 600px;
            /* Width of the images */
            height: 400px;
            /* Height of the images */
        }

        /* Modal ketersediaan ruangan */
        .available {
            background-color: #25d366;
            height: 26px;
            width: 76px;
            border-radius: 5px;
            color: #FFFFFF;
            margin-bottom: 10px;
            text-align: center;
        }

        .modal-dialog {
            max-width: 70%;
            /* Atur persentase sesuai kebutuhan */
        }

        @media (max-width: 767.98px) {
            .modal-dialog {
                max-width: 100%;
                /* Atur persentase sesuai kebutuhan */
            }
        }

        .modal-body {
            overflow-x: auto;
            /* Menambahkan penggulung horizontal jika konten terlalu lebar */
        }

        .modal-body .d-flex {
            flex-wrap: wrap;
            /* Membungkus elemen jika terlalu lebar */
        }

        .mark-available {
            background-color: #25d366;
            height: 10px;
            width: 10px;
            margin-right: 10px;
            border-radius: 50%;
        }

        .mark-notavailable {
            background-color: #e3e3e3;
            height: 10px;
            width: 10px;
            margin-right: 10px;
            border-radius: 50%;
        }

        .button-style-ketersediaan {
            background-color: #0C9300;
            font-size: 14px;
        }

        .button-style-ketersediaan:hover {
            background-color: #0A7A00;
        }

        .cek-available {
            background-color: #25d366;
            height: 26px;
            width: 96px;
            border-radius: 5px;
            color: #FFFFFF;
            margin-bottom: 10px;
            text-align: center;
        }

        .cek-notavailable {
            background-color: #d3d3d3;
            color: #000;
            height: 26px;
            width: 96px;
            border-radius: 5px;
            color: #FFFFFF;
            margin-bottom: 10px;
            text-align: center;
        }

    </style>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous">
    </script>

    <script>
      $(document).ready(function() {
        let startDate = new Date().toISOString().split('T')[0];
        let ruanganId = $('#roomId').val();

        // Bookings data for the calendar (assuming this is passed from your backend)
        var bookings = @json($events);
        var dataRuangan = @json($dataRuangan);
        console.log(bookings);

        // Event listener for radio button changes
        $('input[name="btnradio"]').change(function() {
            updateView();
        });

        // Initialize view on modal show
        $('#lihatKetersediaanModal').on('show.bs.modal', function() {
            updateView();
        });

        $('#lihatKetersediaanModal').on('shown.bs.modal', function() {
            if ($('#calendar').hasClass('fc')) {
                $('#calendar').fullCalendar('render');
            }
        });

        function updateView() {
            let selectedView = $('input[name="btnradio"]:checked').val();
            let satuan = getRoomSatuan(ruanganId);

            if (satuan === 'Halfday / 4 Jam') { // Nanti ini sesuaikan dengan satuan yang dah pasti
                if (selectedView === 'per_minggu') {
                    showWeeklyView();
                    showFooter(); // Show the footer content
                } else if (selectedView === 'per_bulan') {
                    showMonthlyView();
                    hideFooter(); // Clear the footer content
                }
            } else if (satuan === 'Seat / Bulan') { // Ini juga sesuaikan dengan satuan yang dah pasti
                showMonthlyView();
                hideFooter(); // Clear the footer content
                $('input[name="btnradio"][value="per_bulan"]').prop('checked', true);
                $('input[name="btnradio"][value="per_minggu"]').prop('disabled', true);
            }
        }

        function getRoomSatuan(ruanganId) {
            // Mencari ruangan dalam array dataRuangan yang memiliki id_ruangan sesuai dengan ruanganId
            let room = dataRuangan.find(room => room.id_ruangan == ruanganId);
            return room ? room.satuan : '';
        }

        function showFooter() {
            var footerContent = `
                <div class="d-flex align-items-center mr-4">
                    <div class="mark-available"></div>
                    <p class="my-auto">Tersedia</p>
                </div>
                <div class="d-flex align-items-center">
                    <div class="mark-notavailable"></div>
                    <p class="my-auto">Tidak tersedia</p>
                </div>
            `;
            $('#modal-footer-content').html(footerContent);
        }

        function hideFooter() {
            $('#modal-footer-content').empty();
        }

        function showWeeklyView() {
            let startDate = new Date().toISOString().split('T')[0];
            let ruanganId = $('#roomId').val();

            $.ajax({
                url: '/get-sediaan-details',
                method: 'GET',
                data: {
                    tanggal_mulai: startDate,
                    tanggal_selesai: new Date(new Date(startDate).setDate(new Date(startDate).getDate() + 6)).toISOString().split('T')[0],
                    ruangan_id: ruanganId
                },
                success: function(response) {
                    var content = '<div id="weeklyContainer" class="d-flex justify-content-center flex-wrap">';
                    var startDateObj = new Date(startDate);
                    for (var i = 0; i < 7; i++) {
                        var currentDateObj = new Date(startDateObj);
                        currentDateObj.setDate(currentDateObj.getDate() + i);

                        var dayName = currentDateObj.toLocaleDateString('id-ID', { weekday: 'long' });
                        var dayDate = currentDateObj.toISOString().split('T')[0];

                        var hoursHtml = getHoursHtml(dayDate, response.usedTimeSlots);

                    var dayHtml = `
                        <div class="mx-2 text-center">
                            <div>
                                <p class="day-name">${dayName}</p>
                                <p class="font-weight-bold date-available">${currentDateObj.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })}</p>
                            </div>
                            <div>
                                ${hoursHtml}
                            </div>
                        </div>
                    `;
                    daysContainer.append(dayHtml);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText); // Debugging error response
            }
        });
    }

        function getHoursHtml(dayDate, usedTimeSlots) {
            var hoursHtml = '';
            var start = new Date(dayDate + 'T08:00:00');
            var end = new Date(dayDate + 'T22:30:00');

            while (start < end) {
                var hour = start.toTimeString().substring(0, 5);
                var isUsed = usedTimeSlots.some(function(slot) {
                    return slot.date === dayDate && slot.time === hour;
                });
                var className = isUsed ? 'cek-notavailable' : 'cek-available';
                hoursHtml += `<div class="${className}"><p>${hour}</p></div>`;
                start.setMinutes(start.getMinutes() + 30);
            }
            return hoursHtml;
        }

        // Initialize default view
        updateView();
    });
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/locale/id.js"></script>
@endsection
