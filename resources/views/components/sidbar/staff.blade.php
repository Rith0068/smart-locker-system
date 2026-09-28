@php
    $maintenanceCount = \App\Models\Locker::where('status', 'maintenance')->count();

    // route = null means the page is not built yet (shown as "Soon")
    $navItems = [
        [
            'label'  => 'Dashboard',
            'route'  => 'admin.dashboard',
            'active' => 'admin.dashboard',
            'icon'   => ['M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ],
        [
            'label'  => 'Locations',
            'route'  => 'location.index',
            'active' => 'location.*',
            'icon'   => [
                'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z',
                'M15 11a3 3 0 11-6 0 3 3 0 016 0z',
            ],
        ],
        [
            'label'  => 'Lockers',
            'route'  => 'locker.index',
            'active' => 'locker.*',
            'icon'   => ['M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
        ],
        [
            'label'  => 'Usage',
            'route'  => null,
            'active' => 'usage.*',
            'icon'   => ['M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
        ],
        [
            'label'  => 'Maintenance',
            'route'  => 'maintenance.index',
            'active' => 'maintenance.*',
            'badge'  => $maintenanceCount,
            'icon'   => [
                'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
                'M15 12a3 3 0 11-6 0 3 3 0 016 0z',
            ],
        ],
        [
            'label'  => 'Report',
            'route'  => null,
            'active' => 'report.*',
            'icon'   => ['M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ],
    ];

    $user     = auth()->user();
    $roleName = $user->role === 2 ? 'Staff' : 'User';
    $initial  = mb_strtoupper(mb_substr($user->name, 0, 1));
@endphp

<!-- Mobile top bar -->
<div class="md:hidden fixed top-0 left-0 right-0 h-16 flex items-center justify-between px-4 border-b border-gray-200 bg-white z-[70]">
  <div class="flex items-center gap-2.5">
    <img src="{{ asset('images/logo.png') }}" class="w-8 h-8" alt="SmartHub locker logo">
    <span class="font-bold text-[16px] text-gray-800">SmartHub locker</span>
  </div>
  <button id="menuBtn" type="button"
          class="p-2 rounded-lg text-gray-700 hover:bg-gray-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
          aria-label="Open menu" aria-controls="sidebar" aria-expanded="false">
    <svg id="iconHamburger" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
    <svg id="iconClose" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>
  </button>
</div>

<!-- Overlay for mobile -->
<div id="overlay" class="md:hidden fixed inset-0 bg-black/40 z-[60] opacity-0 pointer-events-none transition-opacity duration-300"></div>

<!-- Sidebar -->
<aside id="sidebar"
       class="fixed top-0 left-0 w-72 max-w-[85vw] md:w-80 shrink-0 border-r border-gray-200 flex flex-col bg-white h-dvh max-h-dvh z-[65]
              -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out pt-16 md:pt-0">

  <!-- Brand (desktop) -->
  <a href="{{ route('admin.dashboard') }}" class="hidden md:flex items-center gap-4 px-6 py-8 border-b border-gray-100">
    <img src="{{ asset('images/logo.png') }}" class="w-14 h-14" alt="SmartHub locker logo">
    <div class="flex flex-col leading-tight">
      <span class="font-bold text-[18px] text-gray-800">SmartHub locker</span>
      <span class="text-sm text-gray-500">Public locker network</span>
    </div>
  </a>

  <!-- Navigation -->
  <nav class="flex-1 overflow-y-auto px-4 py-5 flex flex-col gap-1" aria-label="Main navigation">
    @foreach ($navItems as $item)
      @php
        $isActive = request()->routeIs($item['active']);
        $base     = 'group relative flex items-center gap-3 px-4 py-3 rounded-lg text-[16px] font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500';
        $state    = $isActive
            ? 'bg-blue-50 text-blue-700'
            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900';
      @endphp

      @if ($item['route'])
        <a href="{{ route($item['route']) }}"
           class="{{ $base }} {{ $state }}"
           @if ($isActive) aria-current="page" @endif>
          @if ($isActive)
            <span class="absolute left-0 top-2 bottom-2 w-1 rounded-r-full bg-blue-600"></span>
          @endif

          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 {{ $isActive ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"
               fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            @foreach ($item['icon'] as $path)
              <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}" />
            @endforeach
          </svg>

          <span class="flex-1">{{ $item['label'] }}</span>

          @if (!empty($item['badge']))
            <span class="min-w-[1.5rem] text-center px-2 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-700"
                  title="{{ $item['badge'] }} locker(s) under maintenance">
              {{ $item['badge'] }}
            </span>
          @endif
        </a>
      @else
        <span class="{{ $base }} text-gray-400 cursor-not-allowed" aria-disabled="true">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-gray-300"
               fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            @foreach ($item['icon'] as $path)
              <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}" />
            @endforeach
          </svg>
          <span class="flex-1">{{ $item['label'] }}</span>
          <span class="px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-500">Soon</span>
        </span>
      @endif
    @endforeach
  </nav>

  <!-- User -->
  <div class="shrink-0 border-t border-gray-100 p-4">
    <div class="flex items-center gap-3 mb-3">
      <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold shrink-0" aria-hidden="true">
        {{ $initial }}
      </div>
      <div class="min-w-0">
        <p class="text-sm font-semibold text-gray-800 truncate">{{ $user->name }}</p>
        <p class="text-xs text-gray-500">{{ $roleName }}</p>
      </div>
    </div>

    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit"
              class="w-full inline-flex items-center justify-center gap-2 border border-gray-200 py-2.5 rounded-lg text-sm font-medium text-gray-700
                     hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        Log out
      </button>
    </form>
  </div>
</aside>

<script>
$(function () {
  const $sidebar = $('#sidebar');
  const $overlay = $('#overlay');
  const $menuBtn = $('#menuBtn');

  function openMenu() {
    $sidebar.removeClass('-translate-x-full');
    $overlay.removeClass('opacity-0 pointer-events-none');
    $('#iconHamburger').addClass('hidden');
    $('#iconClose').removeClass('hidden');
    $menuBtn.attr({ 'aria-expanded': 'true', 'aria-label': 'Close menu' });
    $('body').addClass('overflow-hidden');
  }

  function closeMenu() {
    $sidebar.addClass('-translate-x-full');
    $overlay.addClass('opacity-0 pointer-events-none');
    $('#iconHamburger').removeClass('hidden');
    $('#iconClose').addClass('hidden');
    $menuBtn.attr({ 'aria-expanded': 'false', 'aria-label': 'Open menu' });
    $('body').removeClass('overflow-hidden');
  }

  $menuBtn.on('click', function () {
    $sidebar.hasClass('-translate-x-full') ? openMenu() : closeMenu();
  });

  $overlay.on('click', closeMenu);

  // Close with the Escape key
  $(document).on('keydown', function (e) {
    if (e.key === 'Escape' && !$sidebar.hasClass('-translate-x-full')) closeMenu();
  });

  // Close after tapping a link on mobile
  $sidebar.find('nav a').on('click', function () {
    if ($(window).width() < 768) closeMenu();
  });

  $(window).on('resize', function () {
    if ($(window).width() >= 768) closeMenu();
  });
});
</script>