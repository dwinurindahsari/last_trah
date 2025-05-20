<li>
    <div class="couple-container gap-1">
        <div class="main-member">
            <a href="">
                @if ($anggota->urutan)
                    <small style="position: absolute; background-color:
                    @if ($anggota->jenis_kelamin == 'Laki-Laki')
                        blue;
                    @else  
                        pink;  
                    @endif
                    padding: 2px 5px; border-radius: 100px;">{{ $anggota->urutan }}</small>
                @endif

                {{-- Main Member Photo --}}
                @if ($anggota->photo)
                    <img style="@if ($anggota->status_kehidupan == 'Wafat') filter: grayscale(100%) !important; @endif" 
                         src="{{ asset('storage/' . $anggota->photo) }}" 
                         alt="{{ $anggota->nama }}">
                @else
                    <img style="@if ($anggota->status_kehidupan == 'Wafat') filter: grayscale(100%) !important; @endif" 
                         src="{{ asset('assets/img/placeholder/' . ($anggota->jenis_kelamin == 'Laki-Laki' ? 'male' : 'female') . '.png') }}" 
                         alt="{{ $anggota->nama }}">
                @endif

                {{-- Member Name with Tooltip --}}
                @if ($anggota->nama)
                    <span class="truncate-name">
                        {{ Str::of($anggota->nama)->before(' ') }}
                        @if (Str::contains($anggota->nama, ' '))
                            <span class="tooltip-text" alt>{{ $anggota->nama }}</span>
                        @endif
                    </span>
                @endif
            </a>
        </div>

        {{-- Partner Section --}}
        @foreach ($anggota->partners as $partner)
            @if ($partner->anggota_keluarga_id == $anggota->id)
                <div class="partner">
                    <a href="#">
                        @if ($partner->photo)
                            <img src="{{ asset('storage/' . $partner->photo) }}" alt="{{ $partner->nama }}">
                        @else
                            <img src="{{ asset('assets/img/placeholder/' . ($partner->jenis_kelamin == 'Laki-Laki' ? 'male' : 'female') . '.png') }}" 
                                 alt="{{ $partner->nama }}">
                        @endif
                        <span>{{ $partner->nama }}</span>
                    </a>
                </div>
            @endif
        @endforeach
    </div>

    {{-- Children Section --}}
    @if ($anggota->children->count() > 0)
        <ul>
            @foreach ($anggota->children->sortBy('urutan') as $child)
                @include('partial.anggota_keluarga', ['anggota' => $child])
            @endforeach
        </ul>
    @endif
</li>