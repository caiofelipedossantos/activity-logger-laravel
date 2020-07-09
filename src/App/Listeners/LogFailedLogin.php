<?php

namespace polares552\ActivityLogger\App\Listeners;

use Illuminate\Auth\Events\Failed;
use polares552\ActivityLogger\App\Http\Traits\ActivityLogger;

class LogFailedLogin
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
     * @param Failed $event
     *
     * @return void
     */
    public function handle(Failed $event)
    {
        if (config('activity-logger.logFailedAuthAttempts')) {
            ActivityLogger::activity('Falha na tentativa de login');
        }
    }
}