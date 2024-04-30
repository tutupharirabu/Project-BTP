<table id="dataBarang" class="display table" width="100%">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jumlah Barang</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($dataBarang as $num => $dB)
        <tr>
            <td> {{$num + 1}} </td>
            <td> {{$dB->nama_barang}} </td>
            <td> {{$dB->jumlah_barang}} </td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-info dropdown-toggle text-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Details
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="/adminBarang/{{$dB->id_barang}}/detail"><i class="fa-regular fa-eye"></i> Lihat</a></li>
                      <li><a class="dropdown-item" href="/adminBarang/{{$dB->id_barang}}/edit"><i class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                      <li>
                            <form class="form-valid" action="/adminBarang/delete/{{$dB->id_barang}}" method="POST" id="formDeleteBarang-{{$dB->id_barang}}">
                                @csrf
                                @method('DELETE')
                                <button class="dropdown-item" type="submit" id="id_ruangan"><i class="fa-solid fa-trash"></i> Hapus</button>
                            </form>

                      </li>
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
