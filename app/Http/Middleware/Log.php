<?php

namespace App\Http\Middleware;

use App\LogFacade;
use Closure;

class Log
{
    public function handle($request, Closure $next)
    {
        $next = $next($request);

        LogFacade::info('Выполнение запроса к tochka-api', [
            'ip'     => $request->ip(),
            'method' => $request->method(),
            'url'    => $request->fullUrl(),
        ]);

        LogFacade::info('Запрос завершен', [
            'duration' => number_format(microtime(true) - LARAVEL_START, 3),
        ]);

        return $next;
    }
}
