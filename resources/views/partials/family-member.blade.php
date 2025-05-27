<li>
    <a href="#" data-bs-toggle="modal" data-bs-target="#PopUpModal{{ $member->id }}">
        <div class="absolute">{{ $member->urutan }}</div>
        @if ($member->photo)
            <div class="d-flex">
                <!-- Foto Anggota -->
                <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto Anggota"
                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">

                <!-- Foto Pasangan atau Foto Default -->
                @if ($member->partner_photo)
                    <img src="{{ asset('storage/' . $member->partner_photo) }}" alt="Foto Pasangan"
                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                @else
                    @if ($member->gender == 'Laki-Laki')
                        <img src="{{ asset('../img/female.png') }}" alt="Foto Default Laki-laki"
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                    @elseif ($member->gender == 'Perempuan')
                        <img src="{{ asset('../img/male.png') }}" alt="Foto Default Perempuan"
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                    @endif
                @endif
            </div>
        @else
            <!-- Jika tidak ada foto anggota, tampilkan foto default berdasarkan gender -->
            @if ($member->gender == 'Laki-Laki')
                <img src="{{ asset('../img/male.png') }}" alt="Foto Default Laki-laki"
                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
            @elseif ($member->gender == 'Perempuan')
                <img src="{{ asset('../img/female.png') }}" alt="Foto Default Perempuan"
                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
            @endif
        @endif
        <span class="capitalize">{{ $member->nama }}</span>
    </a>

    <!-- Jika anggota memiliki anak, tampilkan daftar anak -->
    @if ($member->children->count() > 0)
        <ul>
            @foreach ($member->children->sortBy('urutan') as $child)
                @include('partials.family-member', ['member' => $child])
            @endforeach
        </ul>
    @endif

    <div class="modal fade" id="PopUpModal{{ $member->id }}" tabindex="0" aria-labelledby="PopUpModal{{ $member->id }}" aria-hidden="true">
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
                                        <img src="{{ asset('../assets/img/placeholder/female.png') }}" alt="Foto Default Laki-laki"
                                             style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                                    @elseif ($member->gender == 'Perempuan')
                                        <img src="{{ asset('../assets/img/placeholder/male.png') }}" alt="Foto Default Perempuan"
                                             style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                                    @endif
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Jika tidak ada foto anggota, tampilkan foto default berdasarkan gender -->
                        <div class="d-flex justify-content-center">
                            @if ($member->gender == 'Laki-Laki')
                                <img src="{{ asset('..\img\placeholder\female.png') }}"  alt="Foto Default Laki-laki"
                                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                            @elseif ($member->gender == 'Perempuan')
                                <img src="{{ asset('../img/female.png') }}" alt="Foto Default Perempuan"
                                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                            @endif
                        </div>
                    @endif

                    <div class="container d-flex justify-content-start">
                        <div class="col text-start">
                            <p>Nama nama</p>
                            <p>Tanggal Lahir</p>
                            <p>Jenis Kelamin</p>
                            @if($member->partners->count() > 0)
                                <p>Partner(s)</p>
                            @endif
                            @if($member->children->count() > 0)
                                <p>Anak</p>
                            @endif
                        </div>
                        <div class="col text-start">
                            <p>{{ $member->nama }}</p>
                            <p>{{ \Carbon\Carbon::parse($member->tanggal_lahir)->format('d-m-Y') }}</p>
                            <p>{{ $member->jenis_kelamin }}</p>
                           @if($member->partners->count() > 0)
                                <p>
                                    @foreach($member->partners as $partner)
                                        {{ $partner->nama }}@if(!$loop->last), @endif
                                    @endforeach
                                </p>
                            @endif
                           @if($member->children->count() > 0)
                                <p>
                                    @foreach($member->children as $children)
                                        {{ $children->nama }}@if(!$loop->last), @endif
                                    @endforeach
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal untuk menampilkan biodata anggota -->
</li>