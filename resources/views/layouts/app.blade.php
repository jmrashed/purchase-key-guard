<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Purchase Key Guard is a Laravel package designed to protect your Laravel application from unauthorized use by validating a purchase key. Ideal for commercial or licensed applications.">
    <meta name="keywords" content="Laravel, Purchase Key Guard, validate purchase key, Laravel middleware, licensing protection, commercial applications, software licensing, Laravel package">
    <meta name="author" content="Your Name or Company">
    <meta name="robots" content="index, follow">
    <title>@yield('title', 'Purchase Key Guard')</title>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

    <!-- Your custom stylesheets -->
    <link href="{{ asset('vendor/purchase-key-guard/css/style.css') }}" rel="stylesheet">
    <script src="{{ asset('vendor/purchase-key-guard/js/app.js') }}"></script>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
</head>

<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="container mx-auto px-4">
            <!-- Main Content -->
            <main class="py-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

    <!-- Toastr Messages -->
    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @elseif($errors->any())
            toastr.error("{{ $errors->first() }}");
        @endif
    </script>

    {!! Toastr::message() !!}  <!-- For other Toastr messages -->
</body>

</html>


