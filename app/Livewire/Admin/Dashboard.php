<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\UserPost;
use App\Models\Event;
use App\Models\Course;
use App\Models\PostComment;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalPosts' => UserPost::count(),
            'activeEvents' => Event::where('event_date', '>=', Carbon::today())->count(),
            'totalCourses' => Course::count(),

            // Growth percentages (mocked for now, or could calculate vs last month)
            'userGrowth' => '+12%',
            'postGrowth' => '+5%',
            'eventGrowth' => '+2',
            'courseGrowth' => '+1',
        ];

        $recentUsers = User::latest()->take(5)->get();

        // Activity for today
        $todayActivity = UserPost::whereDate('created_at', Carbon::today())->count() +
            PostComment::whereDate('created_at', Carbon::today())->count();

        // Data for the breakdown chart (mock percentages for now based on actual counts)
        $totalItems = $stats['totalPosts'] + $stats['activeEvents'] + Course::count();
        $breakdown = [
            'posts' => $totalItems > 0 ? round(($stats['totalPosts'] / $totalItems) * 100) : 0,
            'events' => $totalItems > 0 ? round(($stats['activeEvents'] / $totalItems) * 100) : 0,
            'courses' => $totalItems > 0 ? round((Course::count() / $totalItems) * 100) : 0,
        ];

        return view('livewire.admin.dashboard', compact('stats', 'recentUsers', 'todayActivity', 'breakdown'));
    }
}
