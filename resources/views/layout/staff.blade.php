<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css"></script>
</head>
<body>
    <div class="flex justify-start gap-10">
        <x-sidbar.staff />
        <main class="flex-1 min-w-0 w-full pt-16 md:pt-0">
            @yield('content')
        </main>
    </div>
</body>
</html>