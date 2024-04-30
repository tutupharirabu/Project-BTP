<table id="dataMeminjamBawah" class="display table" width="100%">
    <thead class="table-dark">
        <th>No</th>
        <th>Nama Barang</th>
        <th>Jumlah Barang</th>
        <th>Tanggal Peminjaman</th>
        <th>Tanggal Selesai</th>
        <th>Status</th>
    </thead>

    <tbody>
        <?php $no = 1; ?>
        @foreach ($dataPeminjaman as $num => $dM)
            @if (Auth::guard('penyewa')->user() && $dM->meminjam_barang)
                @if (Auth::guard('penyewa')->user()->id_penyewa == $dM->meminjam_barang->id_penyewa)
                    <tr>
                        <td> {{ $no }} </td>
                        <td> {{ $dM->barang->nama_barang }} </td>
                        <td> {{ $dM->jumlah_barang }} </td>
                        <td> {{ $dM->tanggal_peminjaman }} </td>
                        <td> {{ $dM->tanggal_selesai }} </td>
                        <td>
                            @if ($dM->status == 'Sedang Menunggu')
                                <button class="btn btn-primary fw-bold">{{ $dM->status }}</button>
                            @elseif($dM->status == 'Diterima')
                                <button class="btn btn-success fw-bold">{{ $dM->status }}</button>
                            @elseif($dM->status == 'Ditolak')
                                <button class="btn btn-danger fw-bold">{{ $dM->status }}</button>
                            @elseif($dM->status == 'Meninjau Kembali Pengajuan')
                                <button class="btn btn-warning fw-bold">{{ $dM->status }}</button>
                            @endif
                        </td>
                    </tr>
                    <?php $no++; ?>
                @endif
            @endif
        @endforeach
    </tbody>
</table>
