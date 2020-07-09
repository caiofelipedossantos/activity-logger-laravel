<?php

namespace polares552\ActivityLogger\App\Listeners;

use Illuminate\Auth\Events\Lockout;
use polares552\ActivityLogger\App\Http\Traits\ActivityLogger;

class LogLockout
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
     * @param Lockout $event
     *
     * @return void
     */
    public function handle(Lockout $event)
    {
        if (config('activity-logger.logLockOut')) {
            ActivityLogger::activity('Bloqueado');
        }
    }
}