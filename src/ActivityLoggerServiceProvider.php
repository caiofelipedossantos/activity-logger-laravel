<?php

namespace polares552\ActivityLogger;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use polares552\ActivityLogger\App\Http\Middleware\ActivityLog;

class ActivityLoggerServiceProvider extends ServiceProvider{
    
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The event listener mappings for the applications auth scafolding.
     *
     * @var array
     */
    protected $listeners = [

        'Illuminate\Auth\Events\Attempting' => [
            'polares552\ActivityLogger\App\Listeners\LogAuthenticationAttempt',
        ],

        'Illuminate\Auth\Events\Authenticated' => [
            'polares552\ActivityLogger\App\Listeners\LogAuthenticated',
        ],

        'Illuminate\Auth\Events\Login' => [
            'polares552\ActivityLogger\App\Listeners\LogSuccessLogin',
        ],

        'Illuminate\Auth\Events\Failed' => [
            'polares552\ActivityLogger\App\Listeners\LogFailedLogin',
        ],

        'Illuminate\Auth\Events\Logout' => [
            'polares552\ActivityLogger\App\Listeners\LogSuccessLogout',
        ],

        'Illuminate\Auth\Events\Lockout' => [
            'polares552\ActivityLogger\App\Listeners\LogLockout',
        ],

        'Illuminate\Auth\Events\PasswordReset' => [
            'polares552\ActivityLogger\App\Listeners\LogPasswordReset',
        ],

    ];


    public function boot(Router $router){

        //Disponibiliza a publicação do arquivo de configuração das configurações
        $this->publishes([
            __DIR__.'/config/activity-logger.php' => config_path('activity-logger.php'),
        ], 'config');

        //Utiliza o arquivo de configurações
        $this->mergeConfigFrom(__DIR__.'/config/activity-logger.php', 'activity-logger');

        //Disponibiliza a publicação do arquivo das migrations
        if (! class_exists('CreateActivityLoggersTable')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__.'/database/migrations/create_activity_loggers_table.php.stub' => database_path("/migrations/{$timestamp}_create_activity_loggers_table.php"),
            ], 'migrations');
        }

        $router->middlewareGroup('activity', [ActivityLog::class]);
        $this->loadTranslationsFrom(__DIR__.'/resources/lang/', 'ActivityLogger');
    }

    public function register(){
        $this->registerEventListeners();
    }

    /**
     * Get the list of listeners and events.
     *
     * @return array
     */
    private function getListeners()
    {
        return $this->listeners;
    }

    /**
     * Register the list of listeners and events.
     *
     * @return void
     */
    private function registerEventListeners()
    {
        $listeners = $this->getListeners();
        foreach ($listeners as $listenerKey => $listenerValues) {
            foreach ($listenerValues as $listenerValue) {
                \Event::listen(
                    $listenerKey,
                    $listenerValue
                );
            }
        }
    }
}