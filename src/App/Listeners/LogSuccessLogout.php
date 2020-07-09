<?php

namespace polares552\ActivityLogger\App\Listeners;

use Illuminate\Auth\Events\Logout;
use polares552\ActivityLogger\App\Http\Traits\ActivityLogger;

class LogSuccessLogout
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
     * @param Logout $event
     *
     * @return void
     */
    public function handle(Logout $event)
    {
        if (config('activity-logger.logSuccessLogout')) {
            ActivityLogger::activity('Desconectado');
        }
    }
}