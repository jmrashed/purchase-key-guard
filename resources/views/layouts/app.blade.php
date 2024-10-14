<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Purchase Key Guard')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <script>
        // Dark mode toggle
        document.addEventListener('alpine:init', () => {
            Alpine.data('themeToggle', () => ({
                darkMode: localStorage.getItem('dark-mode') === 'true',
                toggle() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('dark-mode', this.darkMode);
                }
            }));
        });
    </script>
</head>

<body class="bg-gray-100" x-data="themeToggle()" :class="{ 'bg-gray-900': darkMode, 'bg-gray-100': !darkMode }">
    <div class="container mx-auto px-4">
        <!-- Navbar -->
        <nav class="bg-white p-4 shadow-md rounded-lg dark:bg-gray-800 transition duration-300">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800 dark:text-white">Purchase Key Guard</h1>
                <div class="flex items-center">
                    <button @click="toggle()"
                        class="p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span x-show="!darkMode" class="material-icons">light_mode</span>
                        <span x-show="darkMode" class="material-icons">dark_mode</span>
                    </button>
                </div>
            </div>
            <div class="mt-4">
                <ul class="flex space-x-4">
                    <li><a href="{{ route('purchase-key.install') }}"
                            class="text-gray-800 dark:text-white hover:text-blue-500">Install</a></li>
                    <li><a href="{{ route('purchase-key.status') }}"
                            class="text-gray-800 dark:text-white hover:text-blue-500">Status</a></li>
                    <li><a href="{{ route('purchase-key.revalidate.form') }}"
                            class="text-gray-800 dark:text-white hover:text-blue-500">Revalidate</a></li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white p-4 shadow-md rounded-lg dark:bg-gray-800 mt-6">
            <p class="text-center text-gray-600 dark:text-gray-400">&copy; {{ date('Y') }} Purchase Key Guard. All
                Rights Reserved.</p>
        </footer>
    </div>
</body>

</html>
