<?php

namespace polares552\ActivityLogger\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use polares552\ActivityLogger\App\Http\Traits\ActivityLogger;


class ActivityLog
{

    use ActivityLogger;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $description = null)
    {
        if ($this->shouldLog($request)) {
            ActivityLogger::activity($description);
        }
        return $next($request);
    }

    /**
     * Determine if the request has a URI that should log.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function shouldLog($request)
    {
        foreach (config('ActivityLogger::activity-logger.loggerMiddlewareExcept', []) as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return false;
            }
        }

        return true;
    }
}
