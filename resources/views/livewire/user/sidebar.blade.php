<div class="fixed left-0 top-16 h-[93vh] w-64 bg-white  p-5 overflow-y-auto ">

    <ul class="space-y-4">

        <li>
            <a href="{{ route('home') }}" class="flex items-center gap-3 text-gray-700 hover:text-purple-600 font-medium">
                <span>🏠</span> Home
            </a>
        </li>

        <li>
            <a href="{{ route('profile') }}"
                class="flex items-center gap-3 text-gray-700 hover:text-purple-600 font-medium">
                <span>👤</span> Profile
            </a>
        </li>

        <li>
            <a href="#" class="flex items-center gap-3 text-gray-700 hover:text-purple-600 font-medium">
                <span>✏️</span> Create Post
            </a>
        </li>

        <li>
            <a href="#" class="flex items-center gap-3 text-gray-700 hover:text-purple-600 font-medium">
                <span>🔔</span> Notifications
            </a>
        </li>

        <li>
            <a href="{{ route('logout') }}"
                class="flex items-center gap-3 text-gray-700 hover:text-purple-600 font-medium">
                <span>🚪</span> Logout
            </a>
        </li>

    </ul>
</div>
