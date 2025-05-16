<li>
    <div class="couple-container">
        <div class="main-member">
            <a href="">
                @if ($anggota->urutan)
                    <small style="position: absolute">{{ $anggota->urutan }}</small>
                @endif
                @if ($anggota->photo)
                    <img src="{{ asset('storage/' . $anggota->photo) }}" alt="{{ $anggota->nama }}">
                @else
                    @if ($anggota->jenis_kelamin == 'Laki-Laki')
                        <img src="https://asset.kompas.com/crops/uZOdrkZyXddUoXgGtdPHf1iwxQE=/0x0:900x600/1200x800/data/photo/2022/03/18/623445ec8d057.png"
                            alt="{{ $anggota->nama }}">
                    @else
                        <img src="https://wallpapercat.com/w/full/e/e/a/2433482-2048x1156-desktop-hd-sana-twice-wallpaper-image.jpg"
                            alt="{{ $anggota->nama }}">
                    @endif
                @endif
                @if ($anggota->nama)
                    <span class="truncate-name">
                        {{ Str::of($anggota->nama)->before(' ') }} <!-- Ambil kata pertama saja -->
                        @if (Str::contains($anggota->nama, ' '))
                            <!-- Jika ada spasi (nama panjang) -->
                            <span class="tooltip-text">{{ $anggota->nama }}</span> <!-- Tooltip untuk nama lengkap -->
                        @endif
                    </span>
                @endif
            </a>
        </div>
        @foreach ($anggota->partners as $partner)
            @if ($partner->anggota_keluarga_id == $anggota->id)
                <div class="partner">
                    <a href="#">
                        @if ($partner->photo)
                            <img src="{{ asset('storage/' . $partner->photo) }}" alt="{{ $partner->nama }}">
                        @else
                            @if ($partner->jenis_kelamin == 'Laki-Laki')
                               <img src="https://asset.kompas.com/crops/uZOdrkZyXddUoXgGtdPHf1iwxQE=/0x0:900x600/1200x800/data/photo/2022/03/18/623445ec8d057.png"
                                alt="{{ $partner->nama }}">
                            @else
                                <img src="https://wallpapercat.com/w/full/e/e/a/2433482-2048x1156-desktop-hd-sana-twice-wallpaper-image.jpg"
                                alt="{{ $partner->nama }}">
                            @endif
                        @endif
                        <span>{{ $partner->nama }}</span>
                    </a>
                </div>
            @endif
        @endforeach
    </div>

    @if ($anggota->children->count() > 0)
        <ul>
            @foreach ($anggota->children->sortBy('urutan') as $child)
                @include('partial.anggota_keluarga', ['anggota' => $child])
            @endforeach
        </ul>
    @endif
</li>
