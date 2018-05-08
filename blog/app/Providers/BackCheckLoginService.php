<?php

namespace App\Providers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\ServiceProvider;

class BackCheckLoginService extends ServiceProvider
{
    /**
     * 允许不被检验的路由
     */
    static public $noLoginUrlArray = [
        '/back/adminLogin',
        '/back/adminLoginDeal',
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * 检查当前路由下用户时候登陆，如果没有登录，则跳转到login页面
     */
    static public function checkLogin()
    {
        // 获取当前请求的url
        $requestUrl = self::getRequestUrl();
        // 如果用户没有登录 并且 请求的为危险Url 则跳转到登录页
        if (!session('userData') and !self::checkSafetyRange($requestUrl)) {
            return redirect('/back/adminLogin');
        } else {
            return true;
        }
    }

    /**
     * 获取到当前请求的url
     * @return mixed
     */
    static public function getRequestUrl()
    {
        // 获取当前请求的url
        $url = $_SERVER['DOCUMENT_URI'];
        if (strpos($url, 'index.php')) {
            $url = explode('index.php', $url)[1];
        }
        return $url;
    }

    /**
     * 检查当前请求的url是否在可不登录的范围
     */
    static public function checkSafetyRange($requestUrl)
    {
        // 检测请求的url是否合法
        if (!$requestUrl) {
            return false;
        }
        // 检测请求的url是否在安全url集合中
        foreach (self::$noLoginUrlArray as $url) {
            if ($requestUrl === $url) {
                return true;
            }
        }
        // 如果不在，则返回错误
        return false;
    }
}
