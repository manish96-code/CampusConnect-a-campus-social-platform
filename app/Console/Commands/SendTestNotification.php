<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Console\Command;

class SendTestNotification extends Command
{
    protected $signature = 'app:send-test-notification {email?}';
    protected $description = 'Send a test notification to a specific user or all users';

    public function handle()
    {
        $email = $this->argument('email');

        if ($email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->notify(new SystemNotification('Welcome!', 'Thanks for being part of Campus Connect.', 'heroicon-o-sparkles'));
                $this->info("Notification sent to {$email}");
            } else {
                $this->error("User not found: {$email}");
            }
        } else {
            $users = User::all();
            foreach ($users as $user) {
                $user->notify(new SystemNotification('System Update', 'New features have been added to your dashboard.', 'heroicon-o-rocket-launch'));
            }
            $this->info("Notifications sent to all users.");
        }
    }
}
