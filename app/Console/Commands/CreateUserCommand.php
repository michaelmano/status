<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:user {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create users for the dashboard. {name} {email} {password}';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = new User();

        $user->name = $this->argument('name');
        $user->email = $this->argument('email');
        $user->password = bcrypt($this->argument('password'));

        $user->save();

        $this->info("User {$user->name} was created successfully!");
    }
}
