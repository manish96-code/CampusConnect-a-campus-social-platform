<div class="fixed left-0 top-16 h-[93vh] w-64 bg-white p-5 overflow-y-auto">
    <ul class="space-y-4">

        <li>
            <a href="{{ route('home') }}"
                class="flex items-center gap-3 font-medium
               {{ request()->routeIs('home') ? 'text-purple-600 font-semibold' : 'text-gray-700 hover:text-purple-600' }}">
                <span>🏠</span> Home
            </a>
        </li>

        <li>
            <a href="{{ route('profile') }}"
                class="flex items-center gap-3 font-medium
               {{ request()->routeIs('profile') ? 'text-purple-600 font-semibold' : 'text-gray-700 hover:text-purple-600' }}">
                <span>👤</span> Profile
            </a>
        </li>

        <li>
            <a href="" class="flex items-center gap-3 font-medium text-gray-700 hover:text-purple-600">
                <span>✏️</span> Create Post
            </a>
        </li>

        <li>
            <a href="#" class="flex items-center gap-3 font-medium text-gray-700 hover:text-purple-600">
                <span>🔔</span> Notifications
            </a>
        </li>

        <li>
            <a href="{{ route('find-friends') }}"
                class="flex items-center gap-3 font-medium
               {{ request()->routeIs('find-friends') ? 'text-purple-600 font-semibold' : 'text-gray-700 hover:text-purple-600' }}">
                <span>👥</span> Find Friend
            </a>
        </li>

        <li>
            <a href="{{ route('logout') }}"
                class="flex items-center gap-3 font-medium text-gray-700 hover:text-purple-600">
                <span>🚪</span> Logout
            </a>
        </li>

    </ul>
</div>
