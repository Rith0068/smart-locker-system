@php
    $justRegistered = session('registered', false);

    if ($justRegistered) {
        $alertClass = 'border-green-200 bg-green-50 text-green-800';
        $alertIcon  = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
        $alertText  = 'You are registered.';
    } elseif (auth()->check()) {
        $alertClass = 'border-green-200 bg-green-50 text-green-800';
        $alertIcon  = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
        $alertText  = 'You are logged in.';
    } else {
        $alertClass = 'border-blue-200 bg-blue-50 text-blue-800';
        $alertIcon  = 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z';
        $alertText  = null;
    }
@endphp

<div id="authAlert" role="status"
     class="mb-3 flex items-start gap-2 rounded-lg border px-3 py-2.5 transition-opacity duration-500 {{ $alertClass }}">
    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0 {{ $justRegistered || auth()->check() ? 'text-green-600' : 'text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $alertIcon }}" />
    </svg>

    @if ($alertText)
        <p class="text-sm font-medium">{{ $alertText }}</p>
    @else
        <p class="text-sm font-medium">
            You are not logged in. Please
            <a href="{{ route('login') }}" class="underline hover:opacity-70">login</a>
            or
            <a href="{{ route('register') }}" class="underline hover:opacity-70">register</a>.
        </p>
    @endif
</div>

<script>
    (function () {
        const alert = document.getElementById('authAlert');
        if (!alert) return;

        setTimeout(() => {
            alert.classList.add('opacity-0');
            setTimeout(() => alert.remove(), 500);
        }, 2000);
    })();
</script>
