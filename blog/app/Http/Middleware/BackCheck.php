<?php

namespace App\Http\Middleware;

use App\Providers\BackCheckLoginService;
use Closure;

class BackCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 登陆验证
        $checkResult = BackCheckLoginService::checkLogin();
        // 检测验证结果
        if ($checkResult !== true) return $checkResult;

        return $next($request);
    }
}
