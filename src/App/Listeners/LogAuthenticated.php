<?php

namespace polares552\ActivityLogger\App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use polares552\ActivityLogger\App\Http\Traits\ActivityLogger;

class LogAuthenticated
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
     * Handle ANY authenticated event.
     *
     * @param Authenticated $event
     *
     * @return void
     */
    public function handle(Authenticated $event)
    {
        if (config('activity-logger.logAllAuthEvents')) {
            ActivityLogger::activity('Atividade autenticada');
        }
    }
}