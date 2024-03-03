<div class="container">
    @if ($errors->any())
        <div class="pt-3">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="pt-3">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif
    <!-- START FORM -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <form wire:submit.prevent="store" enctype="multipart/form-data">
            <div class="mb-3 row">
                <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" wire:model="gambar">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="judul">
                </div>
            </div>
            <div class="mb-3 row">
                <label for=penulis" class="col-sm-2 col-form-label">Penulis</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="penulis">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="tahun__terbit" class="col-sm-2 col-form-label">Tahun Terbit</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" wire:model="tahun_terbit">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    <button type="button" class="btn btn-secondary" wire:click="clear()">Clear</button>
                    @if ($update == false)
                        <button type="button" class="btn btn-primary" wire:click="store()">Simpan</button>
                    @else
                        <button type="button" class="btn btn-success" wire:click="updatebook()">Update</button>
                    @endif
                </div>
            </div>
        </fo>
    </div>
    <!-- AKHIR FORM -->

    <!-- START DATA -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Data Buku</h1>
        <div class="d-flex justify-content-end">
            <input type="text" class="form-control mb-3 w-25" wire:model.live="search" placeholder="Search...">
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="col-md-1">No</th>
                    <th class="col-md-2">Gambar</th>
                    <th class="col-md-2">Judul</th>
                    <th class="col-md-2">Penulis</th>
                    <th class="col-md-2">Tahun Terbit</th>
                    <th class="col-md-2">Log</th>
                    <th class="col-md-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($books->count() == 0)
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data buku</td>
                    </tr>
                @endif
                @foreach ($books as $key => $book)
                    <tr>
                        <td>{{ $books->firstItem() + $key }}</td>
                        <td><img src="{{ asset('storage/' . $book->gambar) }}" alt="" width="100"></td>
                        <td>{{ $book->judul }}</td>
                        <td>{{ $book->penulis }}</td>
                        <td>{{ $book->tahun_terbit }}</td>
                        <td>{{ date('d-m-Y H:i:s', strtotime($book->created_at)) }}</td>
                        <td>
                            <a class="btn btn-warning btn-sm" wire:click="edit({{ $book->id }})">Edit</a>
                            <a class="btn btn-danger btn-sm" wire:click="destroy_confirm({{ $book->id }})"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">Del</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex gap-2 items-content-center">
            <div>{{ $books->links() }}</div>
        </div>
    </div>
    <!-- AKHIR DATA -->

    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmasi Delete</h5>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-danger" wire:click="destroy()"
                        data-bs-dismiss="modal">Ya</button>
                </div>
            </div>
        </div>
    </div>
</div>
