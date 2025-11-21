<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | HPMS Delhi</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen">

    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <div class="flex items-center gap-3">
                    <img src="{{ asset('HPMS.png') }}" alt="HPMS Logo" class="h-14 w-auto object-contain">
                    <div class="flex flex-col leading-tight">
                        <span class="font-bold text-gray-900 text-lg tracking-tight">HPMS Delhi</span>
                        <span class="text-xs text-gray-500 font-medium uppercase tracking-wider">Heatpump Management System</span>
                    </div>
                </div>

                <div class="flex items-center">
                    <a href="#" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium text-white transition-colors duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M19.95 21q-3.125 0-6.175-1.362t-5.55-3.863t-3.862-5.55T3 4.05q0-.45.3-.75t.75-.3H8.1q.35 0 .625.238t.325.562l.65 3.5q.05.4-.025.675T9.4 8.45L6.975 10.9q.5.925 1.187 1.787t1.513 1.663q.775.775 1.625 1.438T13.1 17l2.35-2.35q.225-.225.588-.337t.712-.063l3.45.7q.35.1.575.363T21 15.9v4.05q0 .45-.3.75t-.75.3" />
                        </svg>
                        Call Support
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @include('partials.flash')

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-2 border-b">

            <div>
                <nav class="flex text-sm text-gray-500 mb-1" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">

                        {{-- 1. Always Start with Dashboard --}}
                        <li class="inline-flex items-center">
                            <a href="{{ url('/') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
                        </li>
                        @if(request()->is("/") == false)

                        
                        {{-- 2. Middle Links (Injected by child pages) --}}
                        @hasSection('breadcrumbs')
                        <li><span class="mx-1 text-gray-400">/</span></li>
                        @yield('breadcrumbs')
                        @endif

                        {{-- 3. Current Page (Active) --}}
                        <li>
                            <span class="mx-1 text-gray-400">/</span>
                        </li>
                        <li aria-current="page">
                            <span class="font-medium text-gray-800">@yield('title')</span>
                        </li>
                        @endif
                    </ol>
                </nav>

                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                    @yield('title')
                </h1>
            </div>

            <div class="flex shrink-0">
                @yield('action_button')
            </div>
        </div>

        <div class="">
            @yield('content')
        </div>

    </div>

</body>

</html>