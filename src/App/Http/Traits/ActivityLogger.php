<?php

namespace polares552\ActivityLogger\App\Http\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Jaybizzle\LaravelCrawlerDetect\Facades\LaravelCrawlerDetect as Crawler;
use polares552\ActivityLogger\App\Models\ActivityLoggerModel;
use Validator;

trait ActivityLogger{

    public static function activity($description = null){

        $userType = trans('ActivityLogger::activity-logger.userTypes.guest');
        $userId = null;
        $paramns = json_encode(Request::all());
        $controller = self::filterController(Request::route()->getAction()['controller']);
        $method = self::filterMethod(Request::route()->getAction()['controller']);

        if (\Auth::check()) {
            $userType = trans('ActivityLogger::activity-logger.userTypes.registered');
            $userIdField = config('activity-logger.defaultUserIDField','id');
            $userId = Request::user()->{$userIdField};
        }

        if (Crawler::isCrawler()) {
            $userType = trans('ActivityLogger::activity-logger.userTypes.crawler');
            $description = $userType.' '.trans('activity-logger.verbTypes.crawled').' '.Request::fullUrl();
        }

        if (!$description) {
            switch (strtolower(Request::method())) {
                case 'post':
                    $verb = trans('ActivityLogger::activity-logger.verbTypes.created');
                    break;

                case 'patch':
                case 'put':
                    $verb = trans('ActivityLogger::activity-logger.verbTypes.edited');
                    break;

                case 'delete':
                    $verb = trans('ActivityLogger::activity-logger.verbTypes.deleted');
                    break;

                case 'get':
                default:
                    $verb = trans('ActivityLogger::activity-logger.verbTypes.viewed');
                    break;
            }

            $description = $verb.' . URL: '.Request::path();
        }

        $data = [
            config('activity-logger.table.columns.description', 'description')       => $description,
            config('activity-logger.table.columns.userType', 'userType')             => $userType,
            config('activity-logger.table.columns.userId', 'userId')                 => $userId,
            config('activity-logger.table.columns.route', 'route')                   => Request::fullUrl(),
            config('activity-logger.table.columns.controller', 'controller')         => $controller,
            config('activity-logger.table.columns.method', 'method')                 => $method,
            config('activity-logger.table.columns.paramns', 'paramns')               => $paramns,
            config('activity-logger.table.columns.ipAddress', 'ipAddress')           => Request::ip(),
            config('activity-logger.table.columns.userAgent', 'userAgent')           => Request::header('user-agent'),
            config('activity-logger.table.columns.locale', 'locale')                 => Request::header('accept-language'),
            config('activity-logger.table.columns.referer', 'referer')               => Request::header('referer'),
            config('activity-logger.table.columns.methodType', 'methodType')         => Request::method(),
        ];

        // Validation Instance
        $validator = Validator::make($data, ActivityLoggerModel::Rules([]));
        if ($validator->fails()) {
            $errors = self::prepareErrorMessage($validator->errors(), $data);
            if (config('ActivityLoggeractivity-logger.logDBActivityLoggerFailuresToFile')) {
                Log::error('Falha ao registrar o evento de atividade. Falha na validação: '.$errors);
            }
        } else {
            self::storeActivity($data);
        }
    }


    /**
     * Store activity entry to database.
     *
     * @param array $data
     *
     * @return void
     */
    private static function storeActivity($data)
    {
        ActivityLoggerModel::create([
            config('activity-logger.table.columns.description', 'description')     => $data[config('activity-logger.table.columns.description', 'description')],
            config('activity-logger.table.columns.userType', 'userType')           => $data[config('activity-logger.table.columns.userType', 'userType')],
            config('activity-logger.table.columns.userId', 'userId')               => $data[config('activity-logger.table.columns.userId', 'userId')],
            config('activity-logger.table.columns.route', 'route')                 => $data[config('activity-logger.table.columns.route', 'route')],
            config('activity-logger.table.columns.controller', 'controller')       => $data[config('activity-logger.table.columns.controller', 'controller')],
            config('activity-logger.table.columns.method', 'method')               => $data[config('activity-logger.table.columns.method', 'method')],
            config('activity-logger.table.columns.paramns', 'paramns')             => $data[config('activity-logger.table.columns.paramns', 'paramns')],
            config('activity-logger.table.columns.ipAddress', 'ipAddress')         => $data[config('activity-logger.table.columns.ipAddress', 'ipAddress')],
            config('activity-logger.table.columns.userAgent', 'userAgent')         => $data[config('activity-logger.table.columns.userAgent', 'userAgent')],
            config('activity-logger.table.columns.locale', 'locale')               => $data[config('activity-logger.table.columns.locale', 'locale')],
            config('activity-logger.table.columns.referer', 'referer')             => $data[config('activity-logger.table.columns.referer', 'referer')],
            config('activity-logger.table.columns.methodType', 'methodType')       => $data[config('activity-logger.table.columns.methodType', 'methodType')],
        ]);
    }

    /**
     * Prepare Error Message (add the actual value of the error field).
     *
     * @param $validator
     * @param $data
     *
     * @return string
     */
    private static function prepareErrorMessage($validatorErrors, $data)
    {
        $errors = json_decode(json_encode($validatorErrors, true));
        array_walk($errors, function (&$value, $key) use ($data) {
            array_push($value, "Value: $data[$key]");
        });

        return json_encode($errors, true);
    }

    private static function filterController($controller){
        $controller = explode('@', $controller);
        return preg_replace('/.*\\\/', '', $controller[0]);
    }

    private static function filterMethod($method){
        $method = explode('@', $method);
        return $method[1];
    }
}