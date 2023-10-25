<?php

namespace App\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;

class Create extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User create';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('What is your name?');
        $username = $this->ask('What is your username?');
        $password = $this->secret('What is your password?');

        $user = User::create(compact('name', 'username', 'password'));

        $this->info("User {$user->name} created successfully!");
    }
}
