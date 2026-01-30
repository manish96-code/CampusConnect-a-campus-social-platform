<div class="space-y-8">
    <!-- Welcome Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Welcome back, {{ auth()->user()->first_name }}!</h1>
            <p class="text-slate-500 mt-1">Here's what's happening on Campus Connect today.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.courses') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                <x-heroicon-o-plus class="w-5 h-5" />
                Manage Courses
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                    <x-heroicon-o-users class="w-6 h-6" />
                </div>
                <span class="text-xs font-bold text-emerald-500 px-2 py-1 bg-emerald-50 rounded-lg">{{ $stats['userGrowth'] }}</span>
            </div>
            <h3 class="text-slate-500 font-medium text-sm">Total Users</h3>
            <p class="text-2xl font-extrabold text-slate-800">{{ number_format($stats['totalUsers']) }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                    <x-heroicon-o-document-text class="w-6 h-6" />
                </div>
                <span class="text-xs font-bold text-emerald-500 px-2 py-1 bg-emerald-50 rounded-lg">{{ $stats['postGrowth'] }}</span>
            </div>
            <h3 class="text-slate-500 font-medium text-sm">Total Posts</h3>
            <p class="text-2xl font-extrabold text-slate-800">{{ number_format($stats['totalPosts']) }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                    <x-heroicon-o-calendar-days class="w-6 h-6" />
                </div>
                <span class="text-xs font-bold text-indigo-500 px-2 py-1 bg-indigo-50 rounded-lg">{{ $stats['eventGrowth'] }} New</span>
            </div>
            <h3 class="text-slate-500 font-medium text-sm">Active Events</h3>
            <p class="text-2xl font-extrabold text-slate-800">{{ $stats['activeEvents'] }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                    <x-heroicon-o-chat-bubble-left-right class="w-6 h-6" />
                </div>
                <span class="text-xs font-bold text-emerald-500 px-2 py-1 bg-emerald-50 rounded-lg">Live</span>
            </div>
            <h3 class="text-slate-500 font-medium text-sm">Today's Activity</h3>
            <p class="text-2xl font-extrabold text-slate-800">{{ $todayActivity }}</p>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Table Area -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden text-sm">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Recent Registrations</h3>
                <a href="{{ route('admin.users') }}" class="text-indigo-600 hover:underline font-semibold text-xs">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 uppercase text-[10px] font-extrabold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Contact</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentUsers as $user)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-[10px] ring-2 ring-white">
                                        @if($user->dp)
                                            <img src="{{ $user->dp }}" class="w-full h-full rounded-full object-cover">
                                        @else
                                            {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <span class="font-bold text-slate-700">{{ $user->first_name }} {{ $user->last_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-medium">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if($user->is_admin)
                                    <span class="px-2 py-1 bg-amber-50 text-amber-600 rounded-lg font-bold text-[10px] uppercase">Admin</span>
                                @else
                                    <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg font-bold text-[10px] uppercase">Student</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-400 text-xs">{{ $user->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Side Stats -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-4">Platform Breakdown</h3>
                <div class="space-y-4">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-slate-500">Posts Contribution</span>
                            <span class="text-slate-700">{{ $breakdown['posts'] }}%</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $breakdown['posts'] }}%"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-slate-500">Active Events</span>
                            <span class="text-slate-700">{{ $breakdown['events'] }}%</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $breakdown['events'] }}%"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-slate-500">Available Courses</span>
                            <span class="text-slate-700">{{ $breakdown['courses'] }}%</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-rose-500 rounded-full" style="width: {{ $breakdown['courses'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-indigo-600 to-violet-600 p-6 rounded-2xl text-white shadow-lg shadow-indigo-200">
                <h3 class="font-bold mb-2">Internal Systems</h3>
                <p class="text-indigo-100 text-sm mb-4">All core systems are operational. Backup completed 2 hours ago.</p>
                <div class="flex items-center gap-2 text-xs font-bold bg-white/10 p-2 rounded-lg">
                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                    System Status: Healthy
                </div>
            </div>
        </div>
    </div>
</div>