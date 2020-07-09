<?php

namespace polares552\ActivityLogger\App\Listeners;

use Illuminate\Auth\Events\Login;
use polares552\ActivityLogger\App\Http\Traits\ActivityLogger;

class LogSuccessLogin
{
    use ActivityLogger;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Login $event
     *
     * @return void
     */
    public function handle(Login $event)
    {
        if (config('activity-logger.logSuccessLogin')) {
            ActivityLogger::activity('Logado');
        }
    }
}