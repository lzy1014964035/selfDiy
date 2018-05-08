<?php

namespace App\Http\Models\Back\Admin;

use App\Service\ModelCurrencyService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminModel extends Model
{



    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        // 表名
        $this->tableName = 'admin';
        // 列表页要查询的字段
        $this->selectArray = [
            'id',
            'username',
            'nickname'
        ];
        // 列表查询默认携带的字段
        $this->findWhereArray = [
            'is_delete'=>0
        ];
        // 新建时，默认操作的参数
        $this->addDefaultArray = [
            'create_time'=>time(),
        ];
        // 修改时，默认操作的参数
        $this->updateDefaultArray = [
            'update_time'=>time(),
        ];
        // 删除时，默认操作的参数
        $this->deleteDefaultArray = [
            'delete_time'=>time(),
            'is_delete'=>1
        ];
    }


    /**
     * 获取列表
     */
    public function getList($page = 1, $limit = 10, $whereArray = [])
    {
        // 获取附和数据的长度
        $count = ModelCurrencyService::getCountByWhereArray($this->tableName,$whereArray);
        // 计算偏移量
        $offest = ($page - 1) * $limit;
        // 检查偏移量是否合格，如果不合格。页码与偏移量重置
        if ($offest > $count) {
            $page = 1;
            $offest = ($page - 1) * $limit;
        }

        // 获取数据
        $adminObj = DB::table($this->tableName);
        // where
        if (count($whereArray) > 0) {
            $adminObj = $adminObj->where($whereArray);
        }
        // 字段
        if (count($this->selectArray) > 0) {
            $adminObj = $adminObj->select($this->selectArray);
        }
        $adminArray = $adminObj
            ->limit($offest, $limit)
            ->get();

        $data = [
            'count' => $count,
            'data' => $adminArray
        ];

        return json_encode($data);
    }

    /**
     * 获取单一
     */
    public function getOne($whereArray = [])
    {
        $data = DB::table($this->tableName)->where($whereArray)->first();
        if ($data) {
            return json_encode($data);
        }else{
            return jsonError('没有找到对应数据');
        }
    }

    /**
     * 新增admin
     */
    public function add($adminArray = [])
    {
        // 检查是否重复
        $count = ModelCurrencyService::getCountByWhereArray($this->tableName,[
            ['username', '=', $adminArray['username']]
        ]);
        if ($count > 0) return jsonError('该数据已经存在或已被软删，若要恢复数据请查看已删除的列表');

        // 数据整理默认入库
        $adminArray['create_time'] = time();
        // 返回添加的结果
        if (DB::table($this->tableName)->insert($adminArray)) {
            return jsonSuccess('新建成功');
        } else {
            return jsonError('新建失败');
        }
    }




    /**
     * 编辑admin
     */
    public function update($whereArray = [], $updateArray = [])
    {
        $judge = DB::table($this->tableName)->where($whereArray)->update($updateArray);
        if ($judge) {
            return jsonSuccess('修改成功');
        } else {
            return jsonSuccess('修改失败或数据没有改变');
        }
    }

    /**
     * 删除admin
     */
    public function delete($whereArray = [])
    {
        // 检查数据是否存在
        $count = ModelCurrencyService::getCountByWhereArray($this->tableName,[
            ['id', '=', $whereArray['id']],
            ['is_delete','=',0]
        ]);
        if ($count > 0) return jsonError('没有找到该数据');
        // 执行软删
        $judge = DB::table($this->tableName)->where($whereArray)->update([
            'is_delete'=>1,
            'delete_time'=>time()
        ]);
        if ($judge) {
            return jsonSuccess('删除成功');
        } else {
            return jsonSuccess('未知原因，删除失败');
        }
    }

    /**
     * admin恢复
     */
    public function recovery($whereArray = [])
    {
        // 检查数据是否存在
        $count = ModelCurrencyService::getCountByWhereArray($this->tableName,[
            ['id', '=', $whereArray['id']],
            ['is_delete','=',1]
        ]);
        if ($count > 0) return jsonError('没有找到该数据');
        // 执行恢复
        $judge = DB::table($this->tableName)->where($whereArray)->update([
            'is_delete'=>0,
            'delete_time'=>''
        ]);
        if ($judge) {
            return jsonSuccess('恢复成功');
        } else {
            return jsonSuccess('未知原因，恢复失败');
        }
    }


    /**
     * 根据条件获取数据的长度
     */
    public function getCountByWhereArray($whereArray = [])
    {
        $adminObj = DB::table($this->tableName);
        if (count($whereArray) > 0) {
            $adminObj = $adminObj->where($whereArray);
        }
        $count = $adminObj->count();
    }


}
