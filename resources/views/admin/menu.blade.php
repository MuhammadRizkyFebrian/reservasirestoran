@extends('admin.layouts.admin')

@section('title', 'Daftar Menu')
@section('page-title', 'Data Menu')

@section('content')
<!-- Alert Berhasil/Gagal -->
@if(session('success'))
<div role="alert" class="alert alert-success shadow-lg mb-4 flex items-center gap-2">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
  </svg>
  <span>{{ session('success') }}</span>
  <button class="btn btn-sm btn-circle btn-ghost ml-auto" onclick="this.parentElement.style.display='none'">×</button>
</div>
@endif

@if(session('error'))
<div role="alert" class="alert alert-error shadow-lg mb-4 flex items-center gap-2">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
  </svg>
  <span>{{ session('error') }}</span>
  <button class="btn btn-sm btn-circle btn-ghost ml-auto" onclick="this.parentElement.style.display='none'">×</button>
</div>
@endif

<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">
            <i class='bx bx-food-menu mr-2 text-primary'></i> 
            Daftar Menu
        </h2>
        <!-- Trigger Modal -->
        <label for="modalTambah" class="btn btn-primary">+ Tambah Menu</label>
    </div>

    <!-- Tabel Menu -->
    <div class="overflow-x-auto">
        <table class="table-data-table bg-base-100">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Menu</th>
                    <th>Gambar</th>
                    <th>Kategori</th>
                    <th>Tipe</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $index => $menu)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $menu->nama }}</td>
                        <td>
                            <img src="{{ asset('storage/menu/' . $menu->gambar) }}" alt="{{ $menu->nama }}" class="w-16 h-16 object-cover rounded" />
                        </td>
                        <td>{{ $menu->kategori }}</td>
                        <td>{{ ucfirst($menu->tipe) }}</td>
                        <td>
                            <button onclick="document.getElementById('modal-desc-{{ $menu->id_menu }}').showModal()" class="btn btn-xs btn-info">Lihat</button>

                            <dialog id="modal-desc-{{ $menu->id_menu }}" class="modal">
                                <div class="modal-box">
                                <h3 class="font-bold text-lg mb-2">Deskripsi Menu: {{ $menu->nama }}</h3>
                                <p class="mb-4">{{ $menu->deskripsi }}</p>
                                <div class="modal-action">
                                    <form method="dialog">
                                    <button class="btn">Tutup</button>
                                    </form>
                                </div>
                                </div>
                            </dialog>
                        </td>
                        <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                        <td>
                            <button onclick="document.getElementById('modal-edit-{{ $menu->id_menu }}').showModal()" class="btn btn-sm btn-warning">Edit</button>
                            <form action="{{ route('menus.destroy', $menu->id_menu) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-error" onclick="return confirm('Yakin ingin menghapus menu ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <dialog id="modal-edit-{{ $menu->id_menu }}" class="modal">
                      <div class="modal-box max-w-3xl">
                        <h3 class="font-bold text-lg mb-4">Edit Menu: {{ $menu->nama }}</h3>
                        <form action="{{ route('menus.update', $menu->id_menu) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label" for="nama-{{ $menu->id_menu }}">Nama Menu</label>
                                    <input type="text" name="nama" id="nama-{{ $menu->id_menu }}" class="input input-bordered" value="{{ old('nama', $menu->nama) }}" required>
                                </div>

                                <div class="form-control">
                                    <label class="label" for="kategori-{{ $menu->id_menu }}">Kategori</label>
                                    <input type="text" name="kategori" id="kategori-{{ $menu->id_menu }}" class="input input-bordered" value="{{ old('kategori', $menu->kategori) }}" required>
                                </div>

                                <div class="form-control">
                                    <label class="label" for="tipe-{{ $menu->id_menu }}">Tipe</label>
                                    <select name="tipe" id="tipe-{{ $menu->id_menu }}" class="select select-bordered" required>
                                        <option value="makanan" {{ old('tipe', $menu->tipe) == 'makanan' ? 'selected' : '' }}>Makanan</option>
                                        <option value="minuman" {{ old('tipe', $menu->tipe) == 'minuman' ? 'selected' : '' }}>Minuman</option>
                                    </select>
                                </div>

                                <div class="form-control">
                                    <label class="label" for="harga-{{ $menu->id_menu }}">Harga</label>
                                    <input type="number" name="harga" id="harga-{{ $menu->id_menu }}" class="input input-bordered" value="{{ old('harga', $menu->harga) }}" required>
                                </div>

                                <div class="form-control md:col-span-2">
                                    <label class="label" for="deskripsi-{{ $menu->id_menu }}">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi-{{ $menu->id_menu }}" class="textarea textarea-bordered" rows="3" required>{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                                </div>

                                <div class="form-control md:col-span-2">
                                    <label class="label" for="gambar-{{ $menu->id_menu }}">Ganti Gambar</label>
                                    <input type="file" name="gambar" id="gambar-{{ $menu->id_menu }}" class="file-input file-input-bordered">
                                    <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti gambar</p>
                                </div>
                            </div>

                            <div class="modal-action mt-4 flex justify-between">
                                <button type="button" class="btn" onclick="document.getElementById('modal-edit-{{ $menu->id_menu }}').close()">Batal</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                      </div>
                    </dialog>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Menu -->
<input type="checkbox" id="modalTambah" class="modal-toggle" />
<div class="modal" role="dialog">
  <div class="modal-box max-w-3xl">
    <h3 class="font-bold text-lg mb-4">Tambah Menu Baru</h3>
    <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-control">
                <label class="label" for="nama">Nama Menu</label>
                <input type="text" name="nama" id="nama" class="input input-bordered" value="{{ old('nama') }}" required>
                @error('nama') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="form-control">
                <label class="label" for="kategori">Kategori</label>
                <input type="text" name="kategori" id="kategori" class="input input-bordered" value="{{ old('kategori') }}" required>
                @error('kategori') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="form-control">
                <label class="label" for="tipe">Tipe</label>
                <select name="tipe" id="tipe" class="select select-bordered" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="makanan" {{ old('tipe') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="minuman" {{ old('tipe') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                </select>
                @error('tipe') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="form-control">
                <label class="label" for="harga">Harga</label>
                <input type="number" name="harga" id="harga" class="input input-bordered" value="{{ old('harga') }}" required>
                @error('harga') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="form-control md:col-span-2">
                <label class="label" for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="textarea textarea-bordered" rows="3" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="form-control md:col-span-2">
                <label class="label" for="gambar">Gambar</label>
                <input type="file" name="gambar" id="gambar" class="file-input file-input-bordered" required>
                @error('gambar') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="modal-action mt-4">
            <label for="modalTambah" class="btn">Batal</label>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
  </div>
</div>
@endsection
