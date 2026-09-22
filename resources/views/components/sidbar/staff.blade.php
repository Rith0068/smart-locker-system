<!-- Mobile top bar -->
<div class="md:hidden fixed top-0 left-0 right-0 h-16 flex items-center justify-between px-4 border-b bg-white z-[70]">
  <div class="flex items-center gap-2">
    <img src="{{ asset('images/logo.png') }}" class="w-8 h-8" alt="logo">
    <span class="font-bold text-[16px]">SmartHub locker</span>
  </div>
  <button id="menuBtn" class="p-2" aria-label="Open menu">
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
<aside id="sidebar" class="fixed top-0 left-0 w-72 max-w-[85vw] md:w-80 shrink-0 border-r flex flex-col bg-white h-dvh max-h-dvh z-[65]
       -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out
       pt-16 md:pt-0">
  <div class="hidden md:flex items-center py-6 md:py-10 px-5">
    <img src="{{ asset('images/logo.png') }}" class="w-16 h-16 md:w-20 md:h-20" alt="logo">
    <div class="flex flex-col px-4 py-2">
      <h5 class="font-bold text-[18px]">SmartHub locker</h5>
      <p class="text-[16px]">public locker network</p>
    </div>
  </div>

  <nav class="flex flex-col px-5 gap-2 pt-3">
    <a href="{{ route('admin.dashboard') }}" class="flex justify-start bg-gray-200 px-5 py-3 rounded-lg text-[18px] font-bold hover:bg-gray-100">
      Dashboard
    </a>
    <a href="{{ route('location.index') }}" class="flex justify-start bg-gray-200 px-5 py-3 rounded-lg text-[18px] font-bold hover:bg-gray-100">
    Locations
    </a>
    <a href="{{ route('locker.index') }}" class="flex justify-start bg-gray-200 px-5 py-3 rounded-lg text-[18px] font-bold hover:bg-gray-100">
    Lockers
    </a>
    <a href="#" class="flex justify-start bg-gray-200 px-5 py-3 rounded-lg text-[18px] font-bold hover:bg-gray-100">
      Usage
    </a>
    <a href="{{ route('maintenance.index') }}" class="flex justify-start bg-gray-200 px-5 py-3 rounded-lg text-[18px] font-bold hover:bg-gray-100">
      Maintenance
    </a>
    <a href="#" class="flex justify-start bg-gray-200 px-5 py-3 rounded-lg text-[18px] font-bold hover:bg-gray-100">
      Report
    </a>
  </nav>

  <div class="flex flex-col px-5 pt-10 md:pt-40 pb-5 mt-auto shrink-0">
      <div class="flex justify-start gap-4 mb-4">
        <p class="bg-blue-200 rounded-lg px-2 py-1 text-[14px] md:text-[16px]">{{ auth()->user()->role === 2 ? 'Staff' : 'User' }}</p>
        <p class="bg-gray-100 rounded-lg px-2 py-1 text-[14px] md:text-[16px]">{{ auth()->user()->name }}</p>
      </div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="flex justify-center border border-gray-200 py-2 px-10 rounded-lg hover:bg-red-400 hover:text-gray-100">
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
  }

  function closeMenu() {
    $sidebar.addClass('-translate-x-full');
    $overlay.addClass('opacity-0 pointer-events-none');
    $('#iconHamburger').removeClass('hidden');
    $('#iconClose').addClass('hidden');
  }

  $menuBtn.on('click', function () {
    $sidebar.hasClass('-translate-x-full') ? openMenu() : closeMenu();
  });

  $overlay.on('click', closeMenu);

  $(window).on('resize', function () {
    if ($(window).width() >= 768) closeMenu();
  });
});
</script>