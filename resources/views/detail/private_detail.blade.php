@extends('layouts/contentNavbarLayout')

@section('title', 'Detail Keluarga')

@section('page-script')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            padding: 0px;
            margin: 0px;
            box-sizing: border-box;
        }

        body {
            align-items: center;
            font-family: 'Poppins', sans-serif;
            overflow: visible;
        }

        .tree {
            height: auto;
            text-align: center;
            overflow-x: auto;
            white-space: nowrap;
            /* Mencegah konten untuk turun ke baris berikutnya */
            width: 100%;
        }

        .tree ul {
            padding-top: 20px;
            position: relative;
            transition: .5s;
        }

        .tree li {
            display: inline-table;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 10px;
            transition: .5s;
        }

        .tree li::before,
        .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 1px solid #ccc;
            width: 51%;
            height: 10px;
        }

        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 1px solid #ccc;
        }

        .tree li:only-child::after,
        .tree li:only-child::before {
            display: none;
        }

        .tree li:only-child {
            padding-top: 0;
        }

        .tree li:first-child::before,
        .tree li:last-child::after {
            border: 0 none;
        }

        .tree li:last-child::before {
            border-right: 1px solid #ccc;
            border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
        }

        .tree li:first-child::after {
            border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            -moz-border-radius: 5px 0 0 0;
        }

        .tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 1px solid #ccc;
            width: 0;
            height: 20px;
        }

        .tree li a {
            background: whitesmoke;
            border: 1px solid #00963c;
            padding: 10px;
            display: inline-grid;
            border-radius: 5px;
            text-decoration-line: none;
            border-radius: 5px;
            transition: .5s;
        }

        .tree li a img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px !important;
            border-radius: 100px;
            margin: auto;
        }

        .tree li a span {
            border: 1px solid #ccc;
            border-radius: 5px;
            color: #666;
            padding: 8px;
            font-size: 12px;
            text-transform: capitalize;
            letter-spacing: 1px;
            font-weight: 500;
        }

        /*Hover-Section*/
        .tree li a:hover,
        .tree li a:hover i,
        .tree li a:hover span,
        .tree li a:hover+ul li a {
            background: #c8e4f8;
            color: #000;
            border: 1px solid #94a0b4;
        }

        .tree li a:hover+ul li::after,
        .tree li a:hover+ul li::before,
        .tree li a:hover+ul::before,
        .tree li a:hover+ul ul::before {
            border-color: #94a0b4;
        }

        .wrap-text {
            white-space: normal;
            word-wrap: break-word;
            max-width: 200px;
        }

        .container {
            max-width: 100%;
            overflow: hidden;
            padding: 16px;
        }
    </style>

    <div class="modal-pop-up">
        <div class="modal fade" id="familyModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Tambah Anggota Keluarga</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('anggota.keluarga.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            @if ($trahs->id)
                                <input type="hidden" name="tree_id" value="{{ $trahs->id }}">
                            @endif
                            <div class="row">
                                <div class="col mb-4">
                                    <label for="nama_anggota_keluarga" class="form-label">Nama</label>
                                    <input type="text" id="nama_anggota_keluarga" name="nama_anggota_keluarga"
                                        class="form-control" placeholder="Nama Lengkap" required>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col mb-4">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col mb-0">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control">
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col mb-4">
                                    <label for="parent_id" class="form-label">Orang Tua</label>
                                    <select id="parent_id" name="parent_id" class="form-select">
                                        <option value="">Pilih Orang Tua</option> <!-- Default empty option -->
                                        @foreach ($existingMembers as $member)
                                            <option value="{{ $member->id }}"
                                                {{ old('parent_id') == $member->id ? 'selected' : '' }}>
                                                {{ $member->nama }}
                                                @if ($member->jenis_kelamin === 'Laki-Laki')
                                                    (Pak)
                                                @else
                                                    (Ibu)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col mb-0">
                                    <label for="urutan" class="form-label">Urutan</label>
                                    <select id="urutan" name="urutan" class="form-select" required>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col mb-4">
                                    <label for="status_kehidupan" class="form-label">Status Kehidupan</label>
                                    <select id="status_kehidupan" name="status_kehidupan" class="form-select" required>
                                        <option value="Hidup">Hidup</option>
                                        <option value="Wafat">Wafat</option>
                                    </select>
                                </div>
                                <div class="col mb-0">
                                    <label for="tanggal_kematian" class="form-label">Tanggal Kematian</label>
                                    <input type="date" id="tanggal_kematian" class="form-control"
                                        name="tanggal_kematian">
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col mb-4">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" name="alamat" required></textarea>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col mb-4">
                                    <div class="mb-3">
                                        <label for="keluarga_image" class="form-label">Upload Avatar</label>
                                        <img src="" class="img-thumbnail image-preview mb-3"
                                            style="display: none; max-width: 100px; max-height: 100px; object-fit: cover; aspect-ratio: 1/1; border-radius: 10px;">
                                        <input class="form-control file-uploader" type="file" id="keluarga_image"
                                            name="keluarga_image" accept="image/*" onchange="upload()">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @foreach ($anggota_keluarga as $anggota)
            <div class="modal fade" id="editMemberModal{{ $anggota->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel3">Edit Anggota Keluarga</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('anggota.keluarga.update', $anggota->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <input type="hidden" name="tree_id" value="{{ $anggota->tree_id }}">
                                <div class="row">
                                    <div class="col mb-4">
                                        <label for="nama_anggota_keluarga_edit" class="form-label">Nama</label>
                                        <input type="text" id="nama_anggota_keluarga_edit"
                                            name="nama_anggota_keluarga_edit" class="form-control"
                                            placeholder="Nama Lengkap" value="{{ $anggota->nama }}" required>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col mb-4">
                                        <label for="jenis_kelamin_edit" class="form-label">Jenis Kelamin</label>
                                        <select id="jenis_kelamin_edit" name="jenis_kelamin_edit" class="form-select"
                                            required>
                                            <option value="Laki-laki"
                                                {{ $anggota->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                            </option>
                                            <option value="Perempuan"
                                                {{ $anggota->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col mb-0">
                                        <label for="tanggal_lahir_edit" class="form-label">Tanggal Lahir</label>
                                        <input type="date" id="tanggal_lahir_edit" name="tanggal_lahir_edit"
                                            class="form-control" value="{{ $anggota->tanggal_lahir }}">
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col mb-4">
                                        <label for="parent_id_edit" class="form-label">Orang Tua</label>
                                        <select id="parent_id_edit" name="parent_id_edit" class="form-select">
                                            <option value="">Pilih Orang Tua</option>
                                            @foreach ($existingMembers as $member)
                                                <option value="{{ $member->id }}"
                                                    {{ $anggota->parent_id == $member->id || old('parent_id') == $member->id ? 'selected' : '' }}>
                                                    {{ $member->nama }}
                                                    @if ($member->jenis_kelamin === 'Laki-Laki')
                                                        (Pak)
                                                    @else
                                                        (Ibu)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col mb-0">
                                        <label for="urutan_edit" class="form-label">Urutan</label>
                                        <select id="urutan_edit" name="urutan_edit" class="form-select" required>
                                            @for ($i = 1; $i <= 14; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $anggota->urutan == $i ? 'selected' : '' }}>{{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col mb-4">
                                        <label for="status_kehidupan_edit" class="form-label">Status Kehidupan</label>
                                        <select id="status_kehidupan_edit" name="status_kehidupan_edit"
                                            class="form-select" required>
                                            <option value="Hidup"
                                                {{ $anggota->status_kehidupan == 'Hidup' ? 'selected' : '' }}>Hidup
                                            </option>
                                            <option value="Wafat"
                                                {{ $anggota->status_kehidupan == 'Wafat' ? 'selected' : '' }}>Wafat
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col mb-0">
                                        <label for="tanggal_kematian_edit" class="form-label">Tanggal Kematian</label>
                                        <input type="date" id="tanggal_kematian_edit" class="form-control"
                                            name="tanggal_kematian_edit">
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col mb-4">
                                        <label for="alamat_edit" class="form-label">Alamat</label>
                                        <textarea class="form-control" name="alamat_edit" required>{{ $anggota->alamat }}</textarea>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col mb-4">
                                        <div class="mb-3">
                                            <label for="keluarga_image_edit" class="form-label">Upload Avatar</label>
                                            <img class="img-thumbnail edit-image-preview mb-3"
                                                style="max-width: 100px; max-height: 100px; object-fit: cover; aspect-ratio: 1/1; border-radius: 10px; 
                                                @if ($anggota->photo == null) display: none; @endif"
                                                src="{{ asset('storage/' . $anggota->photo) }}">
                                            <input class="form-control edit-file-uploader" type="file"
                                                id="keluarga_image_edit" name="keluarga_image_edit" accept="image/*"
                                                onchange="edit_upload()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteMemberModal{{ $anggota->id }}" data-bs-backdrop="static" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content"> <!-- Ubah dari <form> ke <div> untuk wrapper -->
                        <div class="modal-header text-center">
                            <h5 class="modal-title" id="backDropModalTitle">Delete This Member?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body justify-content-center text-center">
                            <i class="fa-solid fa-triangle-exclamation fa-beat"
                                style="color: #FF0000; font-size: 100px"></i>
                            <span class="d-block mt-5">kamu Yakin Ingin Mengahapus Anggota Keluarga Ini? Data yang terhapus
                                tidak dapat dipulihkan</span>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <form method="POST" action="{{ route('anggota.keluarga.delete', $anggota->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="nav-align-top">
        <ul class="nav nav-pills mb-4 nav-fill bg-white p-2" role="tablist">
            <li class="nav-item mb-1 mb-sm-0">
                <button type="button" class="nav-link {{ !request()->has('compare') ? 'active' : '' }}" role="tab"
                    data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home"
                    aria-selected="{{ !request()->has('compare') ? 'true' : 'false' }}">
                    <span class="d-none d-sm-inline-flex align-items-center">
                        <i class="fa-solid fa-person me-2"></i>Data Keluarga
                    </span>
                    <i class="fa-solid fa-person icon-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item mb-1 mb-sm-0">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile"
                    aria-selected="false">
                    <span class="d-none d-sm-inline-flex align-items-center">
                        <i class="fa-solid fa-sitemap me-2"></i>Pohon Keluarga
                    </span>
                    <i class="fa-solid fa-sitemap icon-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link {{ request()->has('compare') ? 'active' : '' }}" role="tab"
                    data-bs-toggle="tab" data-bs-target="#navs-pills-justified-messages"
                    aria-controls="navs-pills-justified-messages"
                    aria-selected="{{ request()->has('compare') ? 'true' : 'false' }}">
                    <span class="d-none d-sm-inline-flex align-items-center"><i
                            class="fa-solid fa-link me-2"></i>Hubungan</span>
                    <i class="fa-solid fa-link icon-sm d-sm-none"></i>
                </button>
            </li>
        </ul>
    </div>

    <div class="card">
        <div class="tab-content">
            <div class="tab-pane fade {{ !request()->has('compare') ? 'active show' : '' }}" id="navs-pills-justified-home"
                role="tabpanel">
                <div class="row">
                    <div class="nav-align-top">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-top-align-home" aria-controls="navs-top-align-home"
                                    aria-selected="true">
                                    Anggota Keluarga
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-top-align-profile" aria-controls="navs-top-align-profile"
                                    aria-selected="false">
                                    Pasangan Anggota Keluarga
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-top-align-home" role="tabpanel">
                                <div class="card-body">
                                    <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal"
                                        data-bs-target="#familyModal">
                                        Tambah Anggota Keluarga
                                    </button>

                                    <div class="">
                                        <div class="card-body pt-0">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="dataTables_length">
                                                        <label>
                                                            Menampilkan
                                                            <select id="entriesPerPage" class="form-select form-select-sm"
                                                                style="width: 80px; display: inline-block;">
                                                                <option value="5" selected>5</option>
                                                                <option value="10">10</option>
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="100">100</option>
                                                            </select> data
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="dataTables_filter">
                                                        <label class="float-end">
                                                            Search:
                                                            <input type="search" id="searchInput"
                                                                class="form-control form-control-sm"
                                                                style="width: 200px; display: inline-block;"
                                                                placeholder="Type to search...">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Table -->
                                            <div class="table-responsive md:overflow-auto">
                                                <table
                                                    class="table table-responsive-lg table-bordered table-striped dataTable no-footer"
                                                    id="datatables" aria-describedby="datatables_info">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th class="text-center sorting col-no" scope="col"
                                                                tabindex="0" aria-controls="datatables" rowspan="1"
                                                                colspan="1"
                                                                aria-label="Nomor: activate to sort column ascending"
                                                                style="width: 49.7px;">No
                                                            </th>
                                                            <th class="text-center sorting" scope="col" tabindex="0"
                                                                aria-controls="datatables" rowspan="1" colspan="1"
                                                                aria-label="Nama: activate to sort column ascending"
                                                                style="width: 65px;">Nama
                                                                Lengkap</th>
                                                            <th class="text-center sorting" scope="col" tabindex="0"
                                                                aria-controls="datatables" rowspan="1" colspan="1"
                                                                aria-label="Pengusul: activate to sort column ascending"
                                                                style="width: 64px;">
                                                                Jenis Kelamin</th>
                                                            <th class="text-center sorting" scope="col" tabindex="0"
                                                                aria-controls="datatables" rowspan="1" colspan="1"
                                                                aria-label="Penerima: activate to sort column ascending"
                                                                style="width: 40px;">
                                                                Tanggal lahir</th>
                                                            <th class="text-center sorting" scope="col" tabindex="0"
                                                                aria-controls="datatables" rowspan="1" colspan="1"
                                                                aria-label="Penerima: activate to sort column ascending"
                                                                style="width: 67px;">
                                                                Status Kehidupan</th>
                                                            <th class="text-center sorting" scope="col" tabindex="0"
                                                                aria-controls="datatables" rowspan="1" colspan="1"
                                                                aria-label="Aksi: activate to sort column ascending"
                                                                style="width: 130px;">Aksi
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($anggota_keluarga as $anggota)
                                                            <tr class="odd">
                                                                <td class="text-center col-no" style="overflow: hidden;">
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td class="" style="overflow: hidden">
                                                                    <div class="ellipsis text-center">
                                                                        {{ $anggota->nama }}
                                                                    </div>
                                                                </td>
                                                                <td class="" style="overflow: hidden">
                                                                    <div class="ellipsis text-center">
                                                                        {{ $anggota->jenis_kelamin }}
                                                                    </div>
                                                                </td>
                                                                <td class="" style="overflow: hidden">
                                                                    <div class="ellipsis text-center">
                                                                        {{ $anggota->tanggal_lahir ? \Carbon\Carbon::parse($anggota->tanggal_lahir)->translatedFormat('d-F-Y') : 'belum diketahui' }}
                                                                    </div>
                                                                </td>
                                                                <td class="" style="overflow: hidden">
                                                                    <div class="ellipsis text-center">
                                                                        <span
                                                                            class="badge @if ($anggota->status_kehidupan == 'Hidup') text-bg-primary @else text-bg-danger @endif">
                                                                            {{ $anggota->status_kehidupan }}
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td class="justify-content-center text-center"
                                                                    style="overflow: hidden">
                                                                    <a class="badge bg-label-warning m-1 py-1"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editMemberModal{{ $anggota->id }}">
                                                                        <i class="fa-solid fa-pencil"></i>
                                                                    </a>
                                                                    <a class="badge bg-label-danger m-1 py-1"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#deleteMemberModal{{ $anggota->id }}">
                                                                        <i class="fa-solid fa-xmark"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Table Footer -->
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="dataTables_info" id="datatables_info" role="status"
                                                        aria-live="polite">
                                                        Showing 1 to 10 of {{ count($anggota_keluarga) }} entries
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="dataTables_paginate paging_simple_numbers float-end">
                                                        <ul class="pagination" id="pagination">
                                                            <li class="paginate_button page-item previous disabled">
                                                                <a href="#" class="page-link">Previous</a>
                                                            </li>
                                                            <li class="paginate_button page-item active">
                                                                <a href="#" class="page-link">1</a>
                                                            </li>
                                                            <li class="paginate_button page-item next disabled">
                                                                <a href="#" class="page-link">Next</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="navs-top-align-profile" role="tabpanel">
                                <div class="card-body">
                                    <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal"
                                        data-bs-target="#addPartnerModal">
                                        Tambah Pasangan
                                    </button>

                                    <div class="">
                                        <div class="card-body pt-0">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="dataTables_length">
                                                        <label>
                                                            Menampilkan
                                                            <select id="entriesPerPage" class="form-select form-select-sm"
                                                                style="width: 80px; display: inline-block;">
                                                                <option value="5">5</option>
                                                                <option value="10" selected>10</option>
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="100">100</option>
                                                            </select> data
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="dataTables_filter">
                                                        <label class="float-end">
                                                            Search:
                                                            <input type="search" id="searchInput"
                                                                class="form-control form-control-sm"
                                                                style="width: 200px; display: inline-block;"
                                                                placeholder="Type to search...">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Table -->
                                            <div class="table-responsive md:overflow-auto">
                                                <table
                                                    class="table table-responsive-lg table-bordered table-striped dataTable no-footer"
                                                    id="datatables" aria-describedby="datatables_info">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th class="text-center sorting col-no" scope="col"
                                                                tabindex="0" aria-controls="datatables" rowspan="1"
                                                                colspan="1"
                                                                aria-label="Nomor: activate to sort column ascending"
                                                                style="width: 49.7px;">No
                                                            </th>
                                                            <th class="text-center sorting" scope="col" tabindex="0"
                                                                aria-controls="datatables" rowspan="1" colspan="1"
                                                                aria-label="Nama: activate to sort column ascending"
                                                                style="width: 65px;">Nama
                                                                Lengkap</th>
                                                            <th class="text-center sorting" scope="col" tabindex="0"
                                                                aria-controls="datatables" rowspan="1" colspan="1"
                                                                aria-label="Pengusul: activate to sort column ascending"
                                                                style="width: 64px;">
                                                                Jenis Kelamin</th>
                                                            <th class="text-center sorting" scope="col" tabindex="0"
                                                                aria-controls="datatables" rowspan="1" colspan="1"
                                                                aria-label="Penerima: activate to sort column ascending"
                                                                style="width: 40px;">
                                                                Tanggal lahir</th>
                                                            <th class="text-center sorting" scope="col" tabindex="0"
                                                                aria-controls="datatables" rowspan="1" colspan="1"
                                                                aria-label="Penerima: activate to sort column ascending"
                                                                style="width: 67px;">
                                                                Status Kehidupan</th>
                                                            <th class="text-center sorting" scope="col" tabindex="0"
                                                                aria-controls="datatables" rowspan="1" colspan="1"
                                                                aria-label="Aksi: activate to sort column ascending"
                                                                style="width: 130px;">Aksi
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($anggota_keluarga as $anggota)
                                                            @foreach ($anggota->partners as $partner)
                                                                <tr class="odd">
                                                                    <td class="text-center col-no"
                                                                        style="overflow: hidden;">
                                                                        {{ $loop->iteration }}
                                                                    </td>
                                                                    <td class="" style="overflow: hidden">
                                                                        <div class="ellipsis text-center">
                                                                            {{ $partner->nama }}
                                                                        </div>
                                                                    </td>
                                                                    <td class="" style="overflow: hidden">
                                                                        <div class="ellipsis text-center">
                                                                            {{ $partner->jenis_kelamin }}
                                                                        </div>
                                                                    </td>
                                                                    <td class="" style="overflow: hidden">
                                                                        <div class="ellipsis text-center">
                                                                            {{ \Carbon\Carbon::parse($partner->tanggal_lahir)->translatedFormat('d-F-Y') }}
                                                                        </div>
                                                                    </td>
                                                                    <td class="" style="overflow: hidden">
                                                                        <div class="ellipsis text-center">
                                                                            <span
                                                                                class="badge @if ($partner->status_kehidupan == 'Hidup') text-bg-primary @else text-bg-danger @endif">
                                                                                {{ $partner->status_kehidupan }}
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                    <td class="justify-content-center text-center"
                                                                        style="overflow: hidden">
                                                                        <a class="badge bg-label-warning m-1 py-1"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#editPartnerMemberModal{{ $partner->id }}">
                                                                            <i class="fa-solid fa-pencil"></i>
                                                                        </a>
                                                                        <a class="badge bg-label-danger m-1 py-1"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#deletePartnerMemberModal{{ $partner->id }}">
                                                                            <i class="fa-solid fa-xmark"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Table Footer -->
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="dataTables_info" id="datatables_info" role="status"
                                                        aria-live="polite">
                                                        Showing 1 to 10 of {{ count($anggota_keluarga) }} entries
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="dataTables_paginate paging_simple_numbers float-end">
                                                        <ul class="pagination" id="pagination">
                                                            <li class="paginate_button page-item previous disabled">
                                                                <a href="#" class="page-link">Previous</a>
                                                            </li>
                                                            <li class="paginate_button page-item active">
                                                                <a href="#" class="page-link">1</a>
                                                            </li>
                                                            <li class="paginate_button page-item next disabled">
                                                                <a href="#" class="page-link">Next</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab kedua (Pohon Keluarga) -->
            <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                <div class="row">
                    <div class="tree">
                        <ul>
                            @foreach ($rootMember as $member)
                                @include('partials.family-member', ['member' => $member])
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tab ketiga (Hubungan) -->
            <div class="tab-pane fade {{ request()->has('compare') ? 'active show' : '' }}"
                id="navs-pills-justified-messages" role="tabpanel">
                <!-- Konten tab hubungan -->
            </div>
        </div>

    </div>


@endsection
