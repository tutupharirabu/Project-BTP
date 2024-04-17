@extends('admin.layouts.mainAdmin')

{{-- datatable --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />

@section('containAdmin')
    <div class="container">
        <div class="card my-3">
            <div class="card-header text-bg-light">
                <a href="#" class="text-none align-middle text-dark fw-bold">List Pengajuan Ruangan</a>
            </div>
        </div>

        <div class="card my-3">
            <div class="card-body">
                @include('admin.tabelPengajuan.tablePengajuanRuangan')
            </div>
        </div>

        <br>

        <div class="card my-3">
            <div class="card-body">
                <a href="#" class="text-none align-middle text-dark fw-bold">List Pengajuan Barang</a>
            </div>
        </div>

        <div class="card my-3">
            <div class="card-body">
                @include('admin.tabelPengajuan.tablePengajuanBarang')
            </div>
        </div>
    </div>

{{-- jquery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

{{-- datatable --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

{{-- js --}}
<script src="{{ asset('assets/js/admin/pengajuan.js') }}"></script>
@endsection
