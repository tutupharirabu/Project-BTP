{{-- resources/views/errors/blocked_admin.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h3>403 - Akses Ditolak</h3>
    <p>IP Anda ({{ $ip }}) telah diblokir oleh administrator.</p>
</div>
@endsection
