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

        th {
            background-color: #8c8efd !important;
            border-color: #8c8efd !important;
            color: white !important;
            text-align: center !important;
            text-transform: capitalize !important;
        }

        .tree {
            height: auto;
            text-align: center;
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
            border: 1px solid rgb(130, 130, 130);
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
            object-fit: cover;
            aspect-ratio: 1/1;
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
            flex-wrap: wrap;
            padding: 16px;
        }

        .couple-container {
            justify-content: center;
            align-items: flex-start;
            display: flex;
            flex-direction: row;
            width: auto;
            /* background: #000; */
        }

        .partner,
        .main-member {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .main-member span {
            max-width: 100px;
        }

        .partner a {
            border: 1px solid #000;
            padding: 5px;
            border-radius: 5px;
            text-decoration: none;
            max-height: 100px !important;

        }

        .partner a img {
            width: 15px;
            height: 15px;
        }

        .partner a span {
            font-size: 8px !important;
            padding: 3px;
            margin-top: 5px;
            background-color: whitesmoke !important;
        }

        .truncate-name {
            position: relative;
            display: inline-block;
        }

        .tooltip-text {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .high-z-index {
            z-index: 99999 !important;
        }

        @media (max-width: 576px) {
            .table-responsive {
                overflow-y: scroll !important;
            }
        }
    </style>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Sukses!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                container: 'high-z-index' // Kelas custom untuk container
            }
            });
        });
    </script>
    @endif

    <div class="modal-group">
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
                                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control"
                                        required>
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
                                        <input type="text" id="nama_anggota_keluarga_edit" name="nama_anggota_keluarga_edit"
                                            class="form-control" placeholder="Nama Lengkap" value="{{ $anggota->nama }}"
                                            required>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col mb-4">
                                        <label for="jenis_kelamin_edit" class="form-label">Jenis Kelamin</label>
                                        <select id="jenis_kelamin_edit" name="jenis_kelamin_edit" class="form-select" required>
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
                                            class="form-control" value="{{ $anggota->tanggal_lahir }}" required>
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
                                            @for($i = 1; $i <= 14; $i++)
                                                <option value="{{ $i }}" {{ $anggota->urutan == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col mb-4">
                                        <label for="status_kehidupan_edit" class="form-label">Status Kehidupan</label>
                                        <select id="status_kehidupan_edit" name="status_kehidupan_edit" class="form-select" required>
                                            <option value="Hidup" {{ $anggota->status_kehidupan == 'Hidup' ? 'selected' : '' }}>Hidup</option>
                                            <option value="Wafat" {{ $anggota->status_kehidupan == 'Wafat' ? 'selected' : '' }}>Wafat</option>
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
                                                @if ($anggota->photo == null)
                                                    display: none;
                                                @endif" src="{{ asset('storage/' . $anggota->photo) }}">
                                            <input class="form-control edit-file-uploader" type="file" id="keluarga_image_edit"
                                                name="keluarga_image_edit" accept="image/*" onchange="edit_upload()">
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body justify-content-center text-center">
                    <i class="fa-solid fa-triangle-exclamation fa-beat" style="color: #FF0000; font-size: 100px"></i>
                    <span class="d-block mt-5">kamu Yakin Ingin Mengahapus Anggota Keluarga Ini? Data yang terhapus tidak dapat dipulihkan</span>
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
        <div class="modal fade" id="partnerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Tambah Pasangan Anggota Keluarga</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('pasangan.anggota.keluarga.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            @if ($trahs->id)
                                <input type="hidden" name="tree_id" value="{{ $trahs->id }}">
                            @endif
                            <div class="row">
                                <div class="col mb-4">
                                    <label for="nama_pasangan_anggota_keluarga" class="form-label">Nama Pasangan</label>
                                    <input type="text" id="nama_pasangan_anggota_keluarga"
                                        name="nama_pasangan_anggota_keluarga" class="form-control"
                                        placeholder="Nama Lengkap" required>
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
                                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col mb-4">
                                    <label for="partner_id" class="form-label">Pasangan</label>
                                    <select id="partner_id" name="partner_id" class="form-select">
                                        <option value="">Pilih Pasangan</option> <!-- Default empty option -->
                                        @foreach ($existingMembers as $member)
                                            <option value="{{ $member->id }}"
                                                {{ old('partner_id') == $member->id ? 'selected' : '' }}>
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
                                        <label for="partner_image" class="form-label">Upload Avatar</label>
                                        <img src="" class="img-thumbnail image-partner-preview mb-3"
                                            style="display: none; max-width: 100px; max-height: 100px; object-fit: cover; aspect-ratio: 1/1; border-radius: 10px;">
                                        <input class="form-control file-uploader-partner" type="file"
                                            id="partner_image" name="partner_image" accept="image/*"
                                            onchange="uploadpartner()">
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
    </div>

    <div class="nav-align-top">
        <ul class="nav nav-pills mb-4 nav-fill bg-white p-2" role="tablist">
            <li class="nav-item mb-1 mb-sm-0">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home"
                    aria-selected="true">
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
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-justified-messages" aria-controls="navs-pills-justified-messages"
                    aria-selected="false">
                    <span class="d-none d-sm-inline-flex align-items-center"><i
                            class="fa-solid fa-link me-2"></i>Hubungan</span>
                    <i class="fa-solid fa-link icon-sm d-sm-none"></i>
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                <div class="">
                    @if ($trahs->trah_name)
                        <h5 class="card-header d-flex flex-column mb-3">{{ $trahs->trah_name }}
                            @if ($trahs->description)
                                <small class="fw-light">{{ $trahs->description }}</small>
                            @endif
                        </h5>
                    @endif

                    <div class="card-body">
                        <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal"
                            data-bs-target="#familyModal">
                            Tambah Anggota Keluarga
                        </button>
                        <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal"
                            data-bs-target="#partnerModal">
                            Tambah Pasangan
                        </button>

                        <div class="table-responsive md:overflow-auto">
                            <table class="table table-responsive-lg table-bordered table-striped dataTable no-footer"
                                style="" id="datatables" aria-describedby="datatables_info">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center sorting col-no" scope="col" tabindex="0"
                                            aria-controls="datatables" rowspan="1" colspan="1"
                                            aria-label="Nomor: activate to sort column ascending" style="width: 49.7px;">No
                                        </th>
                                        <th class="text-center sorting" scope="col" tabindex="0"
                                            aria-controls="datatables" rowspan="1" colspan="1"
                                            aria-label="Nama: activate to sort column ascending" style="width: 65px;">Nama
                                            Lengkap</th>
                                        <th class="text-center sorting" scope="col" tabindex="0"
                                            aria-controls="datatables" rowspan="1" colspan="1"
                                            aria-label="Pengusul: activate to sort column ascending" style="width: 64px;">
                                            Jenis Kelamin</th>
                                        <th class="text-center sorting" scope="col" tabindex="0"
                                            aria-controls="datatables" rowspan="1" colspan="1"
                                            aria-label="Penerima: activate to sort column ascending" style="width: 40px;">
                                            Tanggal lahir</th>
                                        <th class="text-center sorting" scope="col" tabindex="0"
                                            aria-controls="datatables" rowspan="1" colspan="1"
                                            aria-label="Penerima: activate to sort column ascending" style="width: 67px;">
                                            Status Kehidupan</th>
                                        <th class="text-center sorting" scope="col" tabindex="0"
                                            aria-controls="datatables" rowspan="1" colspan="1"
                                            aria-label="Aksi: activate to sort column ascending" style="width: 130px;">Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($anggota_keluarga as $anggota)
                                        <tr class="odd">
                                            <td class="text-center col-no" style="overflow: hidden;;">
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
                                                    {{ \Carbon\Carbon::parse($anggota->tanggal_lahir)->translatedFormat('d-F-Y') }}
                                                </div>
                                            </td>
                                            <td class="" style="overflow: hidden">
                                                <div class="ellipsis text-center">
                                                    <span
                                                        class="badge 
                                @if ($anggota->status_kehidupan == 'Hidup') text-bg-primary
                                @else
                                    text-bg-danger @endif
                                ">{{ $anggota->status_kehidupan }}</span>
                                                </div>
                                            </td>
                                            <td class="justify-content-center text-center" style="overflow: hidden">
                                                <a class="badge bg-label-warning m-1 py-1" data-bs-toggle="modal"
                                                    data-bs-target="#editMemberModal{{ $anggota->id }}">
                                                    <i class="fa-solid fa-pencil"></i>
                                                </a>
                                                <a class="badge bg-label-danger m-1 py-1" data-bs-toggle="modal"
                                                    data-bs-target="#deleteMemberModal{{ $anggota->id }}">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                <div class="mb-3 overflow-auto">
                    <div class="row justify-center m-5">
                        @if (is_iterable($rootMember))
                            <div class="tree">
                                <ul>
                                    @foreach ($rootMember->sortBy('urutan') as $anggota)
                                        @include('partial.anggota_keluarga', ['member' => $anggota])
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            @include('partial.anggota_keluarga', ['member' => $rootMember])
                        @endif
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
                page 3
            </div>
        </div>
    </div>

    {{-- <div class="card mb-3 overflow-auto">
        <div class="row justify-center m-5">
            @if (is_iterable($rootMember))
                <div class="tree">
                    <ul>
                        @foreach ($rootMember->sortBy('urutan') as $anggota)
                            @include('partial.anggota_keluarga', ['member' => $anggota])
                        @endforeach
                    </ul>
                </div>
            @else
                @include('partial.anggota_keluarga', ['member' => $rootMember])
            @endif
        </div>
    </div>

    <div class="card">
        @if ($trahs->trah_name)
            <h5 class="card-header d-flex flex-column">{{ $trahs->trah_name }}
                @if ($trahs->description)
                    <small class="fw-light">{{ $trahs->description }}</small>
                @endif
            </h5>
        @endif

        <div class="card-body">
            <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#familyModal">
                Tambah Anggota Keluarga
            </button>
            <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#partnerModal">
                Tambah Pasangan
            </button>
            <div class="modal-group">
                <div class="modal fade" id="familyModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel3">Tambah Anggota Keluarga</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('anggota.keluarga.store') }}" method="POST"
                                enctype="multipart/form-data">
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
                                            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col mb-4">
                                            <label for="parent_id" class="form-label">Orang Tua</label>
                                            <select id="parent_id" name="parent_id" class="form-select">
                                                <option value="">Pilih Orang Tua</option>
                                                <!-- Default empty option -->
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
                                            <select id="status_kehidupan" name="status_kehidupan" class="form-select"
                                                required>
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
                                                <input class="form-control file-uploader" type="file"
                                                    id="keluarga_image" name="keluarga_image" accept="image/*"
                                                    onchange="upload()">
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
                <div class="modal fade" id="partnerModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel3">Tambah Pasangan Anggota Keluarga</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('pasangan.anggota.keluarga.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    @if ($trahs->id)
                                        <input type="hidden" name="tree_id" value="{{ $trahs->id }}">
                                    @endif
                                    <div class="row">
                                        <div class="col mb-4">
                                            <label for="nama_pasangan_anggota_keluarga" class="form-label">Nama
                                                Pasangan</label>
                                            <input type="text" id="nama_pasangan_anggota_keluarga"
                                                name="nama_pasangan_anggota_keluarga" class="form-control"
                                                placeholder="Nama Lengkap" required>
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
                                            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col mb-4">
                                            <label for="partner_id" class="form-label">Pasangan</label>
                                            <select id="partner_id" name="partner_id" class="form-select">
                                                <option value="">Pilih Pasangan</option>
                                                <!-- Default empty option -->
                                                @foreach ($existingMembers as $member)
                                                    <option value="{{ $member->id }}"
                                                        {{ old('partner_id') == $member->id ? 'selected' : '' }}>
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
                                            <select id="status_kehidupan" name="status_kehidupan" class="form-select"
                                                required>
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
                                                <label for="partner_image" class="form-label">Upload Avatar</label>
                                                <img src="" class="img-thumbnail image-partner-preview mb-3"
                                                    style="display: none; max-width: 100px; max-height: 100px; object-fit: cover; aspect-ratio: 1/1; border-radius: 10px;">
                                                <input class="form-control file-uploader-partner" type="file"
                                                    id="partner_image" name="partner_image" accept="image/*"
                                                    onchange="uploadpartner()">
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
            </div>

            <table class="table table-responsive-lg table-bordered table-striped dataTable no-footer" style="width: 100%;"
                id="datatables" aria-describedby="datatables_info">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center sorting col-no" scope="col" tabindex="0" aria-controls="datatables"
                            rowspan="1" colspan="1" aria-label="Nomor: activate to sort column ascending"
                            style="width: 49.7px;">No</th>
                        <th class="text-center sorting" scope="col" tabindex="0" aria-controls="datatables"
                            rowspan="1" colspan="1" aria-label="Nama: activate to sort column ascending"
                            style="width: 65px;">Nama Lengkap</th>
                        <th class="text-center sorting" scope="col" tabindex="0" aria-controls="datatables"
                            rowspan="1" colspan="1" aria-label="Pengusul: activate to sort column ascending"
                            style="width: 64px;">Jenis Kelamin</th>
                        <th class="text-center sorting" scope="col" tabindex="0" aria-controls="datatables"
                            rowspan="1" colspan="1" aria-label="Penerima: activate to sort column ascending"
                            style="width: 40px;">Tanggal lahir</th>
                        <th class="text-center sorting" scope="col" tabindex="0" aria-controls="datatables"
                            rowspan="1" colspan="1" aria-label="Penerima: activate to sort column ascending"
                            style="width: 67px;">Status Kehidupan</th>
                        <th class="text-center sorting" scope="col" tabindex="0" aria-controls="datatables"
                            rowspan="1" colspan="1" aria-label="Aksi: activate to sort column ascending"
                            style="width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($anggota_keluarga as $anggota)
                        <tr class="odd">
                            <td class="text-center col-no" style="overflow: hidden;;">
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
                                    {{ \Carbon\Carbon::parse($anggota->tanggal_lahir)->translatedFormat('d-F-Y') }}
                                </div>
                            </td>
                            <td class="" style="overflow: hidden">
                                <div class="ellipsis text-center">
                                    <span
                                        class="badge 
                    @if ($anggota->status_kehidupan == 'Hidup') text-bg-primary
                    @else
                        text-bg-danger @endif
                    ">{{ $anggota->status_kehidupan }}</span>
                                </div>
                            </td>
                            <td class="justify-content-center text-center" style="overflow: hidden">
                                <a class="badge bg-label-warning m-1 py-1" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $anggota->id }}">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <a class="badge bg-label-danger m-1 py-1" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $anggota->id }}">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}


    <script>
        function upload() {
            const fileUploadInput = document.querySelector('.file-uploader');
            const image = fileUploadInput.files[0];

            // Check if file was selected
            if (!image) {
                return alert('Please select an image file!');
            }

            // Validate file type
            if (!image.type.includes('image')) {
                return alert('Only images are allowed!');
            }

            // Validate file size (10MB)
            if (image.size > 10_000_000) {
                return alert('Maximum upload size is 10MB!');
            }

            const fileReader = new FileReader();
            fileReader.readAsDataURL(image);

            fileReader.onload = (fileReaderEvent) => {
                const profilePicture = document.querySelector('.image-preview');
                profilePicture.src = fileReaderEvent.target.result;
                profilePicture.style.display = 'block'; // Show the image
            }
        }

        function uploadpartner() {
            const fileUploadInput = document.querySelector('.file-uploader-partner');
            const image = fileUploadInput.files[0];

            // Check if file was selected
            if (!image) {
                return alert('Please select an image file!');
            }

            // Validate file type
            if (!image.type.includes('image')) {
                return alert('Only images are allowed!');
            }

            // Validate file size (10MB)
            if (image.size > 10_000_000) {
                return alert('Maximum upload size is 10MB!');
            }

            const fileReader = new FileReader();
            fileReader.readAsDataURL(image);

            fileReader.onload = (fileReaderEvent) => {
                const profilePicture = document.querySelector('.image-partner-preview');
                profilePicture.src = fileReaderEvent.target.result;
                profilePicture.style.display = 'block'; // Show the image
            }
        }
        function edit_upload(){
            const fileUploadInput = document.querySelector('.edit-file-uploader');
            const image = fileUploadInput.files[0];

            // Check if file was selected
            if (!image) {
                return alert('Please select an image file!');
            }

            // Validate file type
            if (!image.type.includes('image')) {
                return alert('Only images are allowed!');
            }

            // Validate file size (10MB)
            if (image.size > 10_000_000) {
                return alert('Maximum upload size is 10MB!');
            }

            const fileReader = new FileReader();
            fileReader.readAsDataURL(image);

            fileReader.onload = (fileReaderEvent) => {
                const profilePicture = document.querySelector('.edit-image-preview');
                profilePicture.src = fileReaderEvent.target.result;
                profilePicture.style.display = 'block'; // Show the image
            }
        }
    </script>
@endsection
