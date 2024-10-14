<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Purchase Key Guard')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

</head>

<body class="bg-gray-100" x-data="themeToggle()" :class="{ 'bg-gray-900': darkMode, 'bg-gray-100': !darkMode }">
    <div class="flex items-center justify-center min-h-screen">
        <div class="container mx-auto px-4">
            <!-- Main Content -->
            <main class="py-6">
                @yield('content')
            </main>
        </div>
    </div>


		<script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
        <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
        {!! Toastr::message() !!}
</body>

</html>
