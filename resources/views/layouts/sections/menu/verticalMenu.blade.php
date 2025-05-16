<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo">
    <a href="{{ url('/') }}" class="app-brand-link">
      <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</span>
      <span class="app-brand-text demo menu-text fw-bold ms-2">{{ config('variables.templateName') }}</span>
    </a>

    <!-- Ubah d-xl-none menjadi d-lg-none untuk membuat toggle muncul di md dan sm -->
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-lg-none">
      <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    @foreach ($menuData[0]->menu as $menu)
      @php
        // Enhanced role checking with Spatie support
        $hasAccess = true;
        if (isset($menu->roles)) {
          if (method_exists(auth()->user(), 'hasAnyRole')) {
            // Using Spatie permissions
            $hasAccess = auth()->user()->hasAnyRole($menu->roles);
          } else {
            // Using simple role column
            $hasAccess = in_array(auth()->user()->role, $menu->roles);
          }
        }
      @endphp

      @if ($hasAccess)
        {{-- Menu headers --}}
        @if (isset($menu->menuHeader))
          <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
          </li>
        @else
          {{-- Active menu detection --}}
          @php
            $activeClass = null;
            $currentRouteName = Route::currentRouteName();
            
            // Exact match
            if ($currentRouteName === $menu->slug) {
              $activeClass = 'active';
            }
            // Submenu match
            elseif (isset($menu->submenu)) {
              if (gettype($menu->slug) === 'array') {
                foreach($menu->slug as $slug) {
                  if (str_contains($currentRouteName, $slug) && strpos($currentRouteName, $slug) === 0) {
                    $activeClass = 'active open';
                  }
                }
              } else {
                if (str_contains($currentRouteName, $menu->slug) && strpos($currentRouteName, $menu->slug) === 0) {
                  $activeClass = 'active open';
                }
              }
            }
          @endphp

          {{-- Main menu item --}}
          <li class="menu-item {{ $activeClass }}">
            <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" 
               class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" 
               @if (isset($menu->target) && !empty($menu->target)) target="_blank" @endif>
              @isset($menu->icon)
                <i class="{{ $menu->icon }}"></i>
              @endisset
              <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
              @isset($menu->badge)
                <div class="badge rounded-pill bg-{{ $menu->badge[0] }} text-uppercase ms-auto">
                  {{ $menu->badge[1] }}
                </div>
              @endisset
            </a>

            {{-- Submenu --}}
            @isset($menu->submenu)
              @include('layouts.sections.menu.submenu', [
                'menu' => collect($menu->submenu)->filter(function($subItem) {
                  // Filter submenu items by role
                  if (isset($subItem->roles)) {
                    if (method_exists(auth()->user(), 'hasAnyRole')) {
                      return auth()->user()->hasAnyRole($subItem->roles);
                    }
                    return in_array(auth()->user()->role, $subItem->roles);
                  }
                  return true;
                })->toArray()
              ])
            @endisset
          </li>
        @endif
      @endif
    @endforeach
  </ul>
</aside>