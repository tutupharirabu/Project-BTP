@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <h2>Daftar Kata Terlarang</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('blacklisted-words.store') }}">
        @csrf
        <div class="form-group">
            <label for="word">Masukkan kata yang akan diblok berdasarkan input tujuan kegiatan penyewa, misalnya : ITC (sehingga jika penyewa menuliskan "Gathering event untuk ITC" di form tujuan kegiatan maka penyewa tidak bisa melakukan penyewaan)</label>
            <input type="text" name="word" class="form-control" placeholder="Contoh: ARK" required>
        </div>
        <button type="submit" class="btn btn-danger mt-2">Tambah ke Blacklist</button>
    </form>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Kata</th>
                <th>Dimasukkan Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($words as $word)
                <tr>
                    <td>{{ $word->word }}</td>
                    <td>{{ $word->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <form method="POST" action="{{ route('blacklisted-words.destroy', $word->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection