<table id="dataRuangan" class="display table" width="100%">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama Ruangan</th>
            <th>Kapasitas Ruangan</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataRuangan as $num => $dR)
        <tr>
            <td>{{ $num + 1 }}</td>
            <td>{{ $dR->nama_ruangan }}</td>
            <td>{{ $dR->kapasitas_ruangan }}</td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-info dropdown-toggle text-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Details
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="/adminRuangan/ruangan/{{$dR->id_ruangan}}/detail"><i class="fa-regular fa-eye"></i> Lihat</a></li>
                      <li><a class="dropdown-item" href="/adminRuangan/ruangan/{{$dR->id_ruangan}}/edit"><i class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                      <li>
                            <form class="form-valid" action="/adminRuangan/ruangan/delete/{{ $dR->id_ruangan }}" method="POST" id="formDeleteHlp-{{$dR->id_ruangan}}">
                                @csrf
                                @method('DELETE')
                                <button class="dropdown-item" type="submit" id="id_helper"><i class="fa-solid fa-trash"></i> Hapus</button>
                            </form>

                      </li>
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
