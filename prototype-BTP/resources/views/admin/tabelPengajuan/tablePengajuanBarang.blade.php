<table id="dataMeminjamBawah" class="display table" width="100%">
    <thead class="table-dark">
        <th>No</th>
        <th>Nama Penyewa</th>
        <th>Nama Barang</th>
        <th>Jumlah Barang</th>
        <th>Tanggal Peminjaman</th>
        <th>Tanggal Selesai</th>
        <th>Status</th>
    </thead>

    <tbody>
        <?php $no = 1 ?>
        @foreach ($dataMeminjam as $dM)
        @if($dM->barang)
        <tr>
            <td> {{ $no }} </td>
            <td> {{ $dM->penyewa->nama_lengkap }}</td>
            <td> {{ $dM->barang->nama_barang }} </td>
            <td> {{ $dM->jumlah_barang }} </td>
            <td> {{ $dM->tanggal_peminjaman }} </td>
            <td> {{ $dM->tanggal_selesai }} </td>
            <td>
                @if($dM->status == 'Sedang Menunggu')
                <form action="{{ route('update.pengajuan', $dM->id_peminjaman) }}" method="POST">
                    @csrf
                    <button type="submit" name="pilihan" value="terima" class="btn btn-success fw-bold">Terima</button></a>
                    <button type="submit" name="pilihan" value="tolak" class="btn btn-danger fw-bold">Tolak</button></a>
                </form>
                @elseif($dM->status == 'Diterima')
                <form action="{{ route('update.pengajuan', $dM->id_peminjaman) }}" method="POST">
                    @csrf
                    <button type="submit" name="pilihan" value="tinjau ulang" class="btn btn-success fw-bold">Diterima</button></a>
                </form>
                @elseif($dM->status == 'Ditolak')
                <form action="{{ route('update.pengajuan', $dM->id_peminjaman) }}" method="POST">
                    @csrf
                    <button type="submit" name="pilihan" value="tinjau ulang" class="btn btn-danger fw-bold">Ditolak</button></a>
                </form>
                @elseif(($dM->status == 'Meninjau Kembali Pengajuan'))
                <form action="{{ route('update.pengajuan', $dM->id_peminjaman) }}" method="POST">
                    @csrf
                    <button type="submit" name="pilihan" value="ulang" class="btn btn-warning fw-bold">Meninjau Pengajuan</button></a>
                </form>
                @endif
            </td>
        </tr>
        <?php $no++; ?>
        @endif
        @endforeach
    </tbody>
</table>

