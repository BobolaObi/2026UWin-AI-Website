<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-admin {email : User email to grant admin access}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grant admin access to a user by email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = (string) $this->argument('email');

        /** @var \App\Models\User|null $user */
        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            $this->error("No user found with email: {$email}");
            return self::FAILURE;
        }

        if ($user->is_admin) {
            $this->info("User is already admin: {$email}");
            return self::SUCCESS;
        }

        $user->is_admin = true;
        $user->save();

        $this->info("Granted admin access to: {$email}");
        return self::SUCCESS;
    }
}
