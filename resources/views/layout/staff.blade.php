<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        /* Slide-in behavior for mobile sidebar */
        #sidebar {
            transition: transform 0.25s ease-in-out;
        }
        @media (max-width: 767px) {
            #sidebar {
            position: fixed;
            inset: 0;
            z-index: 60;
            transform: translateX(-100%);
            }
            #sidebar.open {
            transform: translateX(0);
            }
        }
        #overlay {
            display: none;
        }
        #overlay.open {
            display: block;
        }
    </style>
</head>
<body>
    <div class="flex justify-start gap-10">
        <x-sidbar.staff />
        @yield('content')
    </div>
</body>
</html>