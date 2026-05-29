<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Control de Practicantes - TEG')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E3A8A',
                        secondary: '#3B82F6',
                        accent: '#F59E0B',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen text-gray-800 flex flex-col" x-data="{ sidebarOpen: false }">
    <nav class="bg-primary text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="mr-4 p-2 rounded-md hover:bg-secondary focus:outline-none transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <a href="{{ route('interns.index') }}" class="flex-shrink-0 flex items-center font-bold text-xl tracking-wider gap-2 hidden sm:flex">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        TEG - Control de Practicantes, Horas sociales y Prácticas profesionales
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('interns.index') }}" class="hover:bg-secondary px-3 py-2 rounded-md text-sm font-medium transition-colors">Inicio</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex flex-col md:flex-row flex-grow max-w-7xl mx-auto w-full">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-full md:w-64' : 'hidden md:flex md:w-20'" class="bg-white shadow-md border-r flex-shrink-0 md:min-h-screen transition-all duration-300 overflow-hidden flex flex-col">
            <div class="p-4 border-b h-16 flex items-center justify-center">
                <h2 x-show="sidebarOpen" x-transition class="text-lg font-bold text-gray-700 whitespace-nowrap">Módulos</h2>
                <svg x-show="!sidebarOpen" class="w-6 h-6 text-gray-500 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </div>
            <nav class="p-4 flex flex-col space-y-2 flex-grow overflow-y-auto">
                <a href="{{ route('summary.index') }}" class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('summary.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-blue-50 hover:text-primary' }} rounded-lg font-medium transition-colors whitespace-nowrap overflow-hidden" title="Resumen">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span x-show="sidebarOpen" x-transition>Resumen</span>
                </a>
                <a href="{{ route('interns.index') }}" class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('interns.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-blue-50 hover:text-primary' }} rounded-lg font-medium transition-colors whitespace-nowrap overflow-hidden" title="Practicantes">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span x-show="sidebarOpen" x-transition>Practicantes</span>
                </a>
                <a href="{{ route('time_control.index') }}" class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('time_control.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-blue-50 hover:text-primary' }} rounded-lg font-medium transition-colors whitespace-nowrap overflow-hidden" title="Control de horas">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span x-show="sidebarOpen" x-transition>Control de horas</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow p-4 sm:p-6 lg:p-8 overflow-x-hidden">
            @if(session('success'))
                <div id="alert-success" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex justify-between items-center" role="alert">
                    <p>{{ session('success') }}</p>
                    <button onclick="document.getElementById('alert-success').remove()" class="text-green-700 hover:text-green-900 font-bold">&times;</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <footer class="bg-white border-t py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Tribunal de Ética Gubernamental de El Salvador
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>
