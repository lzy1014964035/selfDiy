<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CheckReceiveDataService extends ServiceProvider
{
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
     * 验证单一数据
     */
    static function checkOne($field, $rule, $errorMessage)
    {
        // 规则如果不存在，就默认为不能为空
        if (!$rule) {
            $rule = 'notNull';
        }
        // 动态根据规则加载对应的验证
        if (!self::$rule($field)) {
            return json_encode(['error' => $errorMessage]);
        }
        return true;
    }

    /**
     * 验证二维数据
     */
    static function checkAll($checkArray = [])
    {
        $num = 0;
        // 遍历二维数组 进行 每组的验证
        foreach ($checkArray as $check) {
            // 拿到结果进行比较
            $result = self::checkOne($check[0], $check[1], $check[2]);
            // 如果已经返回了error字符串，就横等于全都
            if ($result !== true) {
             return $result;
            }
        }
        return true;
    }

    /**
     * 规则： 数据不能为空
     */
    static function notNull($field)
    {
        if (!$field) {
            return false;
        }else{
            return true;
        }
    }


}
