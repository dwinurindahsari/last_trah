<li>
    <a href="#" data-bs-toggle="modal" data-bs-target="#PopUpModal{{ $member->id }}">
        <small
            style="
            position: absolute; 
            background-color: {{ $member->jenis_kelamin == 'Laki-Laki' ? '#3b82f6' : '#ec4899' }};
            color: white;
            font-weight: bold;
            padding: 3px 8px; 
            border-radius: 9999px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            font-size: 0.75rem;
            line-height: 1;
            min-width: 24px;
            text-align: center;
            z-index: 100;
            ">{{ $member->urutan }}
        </small>
        @if ($member->jenis_kelamin == 'Laki-Laki')
            <img src="{{ asset('assets/img/placeholder/male.png') }}" alt="Foto Default Laki-laki"
                style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
        @elseif ($member->jenis_kelamin == 'Perempuan')
            <img src="{{ asset('assets/img/placeholder/male.png') }}" alt="Foto Default Perempuan"
                style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
        @endif
        <span class="capitalize">{{ $member->nama }}</span>
    </a>

    <!-- Jika anggota memiliki anak, tampilkan daftar anak -->
    @if ($member->children->count() > 0)
        <ul>
            @foreach ($member->children->sortBy('urutan') as $child)
                @include('family_member', ['member' => $child])
            @endforeach
        </ul>
    @endif

    <!-- Modal untuk menampilkan biodata anggota -->
</li>

<div class="modal fade" id="PopUpModal{{ $member->id }}" tabindex="-1"
    aria-labelledby="PopUpModal{{ $member->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Biodata {{ $member->nama }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($member->photo)
                    <div class="card w-full">
                        <div class="card-body d-flex justify-content-center">
                            <!-- Foto Anggota -->
                            <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto Anggota"
                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">

                            <!-- Foto Pasangan atau Foto Default -->
                            @if ($member->partner_photo)
                                <img src="{{ asset('storage/' . $member->partner_photo) }}" alt="Foto Pasangan"
                                    style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                            @else
                                @if ($member->gender == 'Laki-Laki')
                                    <img src="{{ asset('../img/female.png') }}" alt="Foto Default Laki-laki"
                                        style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                                @elseif ($member->gender == 'Perempuan')
                                    <img src="{{ asset('../img/male.png') }}" alt="Foto Default Perempuan"
                                        style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                                @endif
                            @endif
                        </div>
                    </div>
                @else
                    <!-- Jika tidak ada foto anggota, tampilkan foto default berdasarkan gender -->
                    <div class="d-flex justify-content-center">
                        @if ($member->gender == 'Laki-Laki')
                            <img src="{{ asset('../img/male.png') }}" alt="Foto Default Laki-laki"
                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                        @elseif ($member->gender == 'Perempuan')
                            <img src="{{ asset('../img/female.png') }}" alt="Foto Default Perempuan"
                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                        @endif
                    </div>
                @endif

                <div class="container d-flex justify-content-start">
                    <div class="col text-start">
                        <p>Nama</p>
                        <p>Tanggal Lahir</p>
                        <p>Status Kehidupan</p>
                    </div>
                    <div class="col text-start">
                        <p>{{ $member->nama }}</p>
                        <p>{{ $member->jenis_kelamin }}</p>
                        <p>{{ $member->status_kehidupan }}</p>
                        <p>{{ \Carbon\Carbon::parse($member->birth_date)->format('d-m-Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
