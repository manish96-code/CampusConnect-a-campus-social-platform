<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Page Title' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-purple-50">

    <header class="bg-purple-600 shadow-md py-4 px-[10%] fixed top-0 w-full z-50">
        <div class="max-w-8xl mx-auto px-4 flex justify-between items-center">

            <a href="{{ route('home') }}">
                <h1 class="text-2xl font-extrabold text-white tracking-wide">Social App</h1>
            </a>

            <div>
                {{-- <input type="text" placeholder="Search..."
                class="px-3 py-2 rounded-lg border bg-purple-300 focus:ring-2 focus:ring-purple-300 w-72"> --}}
                <form action="{{ route('find-friends') }}" method="get">
                    <input type="text" name="query" placeholder="Search people"
                        class="bg-[#f0f2f5] px-4 py-2 rounded-full pl-10 focus:outline-none w-60 text-[15px]"
                        autocomplete="off">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-500"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>
            </div>
            <div>

                <h2 class="text-xl font-bold text-white drop-shadow-sm capitalize">
                    Hello, {{ auth()->user()->first_name }}
                </h2>

            </div>

            {{-- <nav>
                <ul class="flex space-x-6 text-white font-medium">
                    <li><a href="{{ route('home') }}" class="hover:text-purple-200 transition">Home</a></li>
                    <li><a href="#" class="hover:text-purple-200 transition">Profile</a></li>
                    <li><a href="#" class="hover:text-purple-200 transition">Settings</a></li>
                    <li>
                        <a href="{{ route('logout') }}"
                           class="hover:text-purple-200 transition">
                            Logout
                        </a>
                    </li>
                </ul>
            </nav> --}}

        </div>
    </header>

    <div class="mt-20">
        {{ $slot }}
    </div>

</body>

</html>
