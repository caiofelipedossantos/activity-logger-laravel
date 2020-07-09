<?php

namespace polares552\ActivityLogger\App\Listeners;

use Illuminate\Auth\Events\Attempting;
use polares552\ActivityLogger\App\Http\Traits\ActivityLogger;

class LogAuthenticationAttempt
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
     * @param Attempting $event
     *
     * @return void
     */
    public function handle(Attempting $event)
    {
        if (config('activity-logger.logAuthAttempts')) {
            ActivityLogger::activity('Tentativa autenticada');
        }
    }
}