<?php

namespace polares552\ActivityLogger\App\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use polares552\ActivityLogger\App\Http\Traits\ActivityLogger;

class LogPasswordReset
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
     * @param PasswordReset $event
     *
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        if (config('activity-logger.logPasswordReset')) {
            ActivityLogger::activity('Redefinir senha');
        }
    }
}