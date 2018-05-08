<?php

namespace App\Service;


class ModelCurrencyService
{
    /**
     * 根据条件获取数据的长度
     */
    static public function getCountByWhereArray($tableName = '',$whereArray = [])
    {
        $adminObj = DB::table($tableName);
        if (count($whereArray) > 0) {
            $adminObj = $adminObj->where($whereArray);
        }
        $count = $adminObj->count();
    }
}
