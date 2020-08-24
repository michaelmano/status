<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Console\Command;

class Status extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'signin:overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sign in overdue employees. Use manually. Also Used by task scheduler.';

    /**
     * Create a new command instance.
     *
     * @return void
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
        // Call StatusController->destroy with request POST data containing
        // key/value 'bulk' = 'overdue'
        $message = "*** Status cleared overdue employees using console command signin:overdue via daily kernal task.";
        $request = new Request();
        $request->setMethod('POST');
        $request->request->add(['bulk' => 'overdue']);
        app('\App\Http\Controllers\Admin\StatusController')->destroy($request);
        Log::info($message);
    }
}
