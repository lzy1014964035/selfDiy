<?php

namespace App\Http\Controllers\Back\Admin;

use App\Http\Models\Back\Admin\AdminModel;
use App\Providers\CheckReceiveDataService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    /**
     * 用户登录
     */
    public function adminLogin()
    {
        return view('back.admin.login');
    }

    /**
     * 用户登录-处理
     */
    public function adminLoginDeal()
    {
        // 接受表单数据
        $userItem = Input::get();

        // 指定验证规则
        $checkArray = [
            [$userItem['username'], 'notNull', '用户名不能为空'],
            [$userItem['password'], 'notNull', '密码不能为空'],
        ];
        // 执行验证
        $checkResult = \App\Service\CheckReceiveDataService::checkAll($checkArray);
        // 检测验证结果
        if ($checkResult !== true) return $checkResult;

        // 数据库验证
        $userData = DB::table('admin')
            // ->select(['id', 'username', 'password'])
            ->where([
                ['username', '=', $userItem['username']]
            ])
            ->first();

        if (!$userData) {
            return jsonError('用户名或密码错误');
        }
        if ($userData->password !== md5($userItem['password'])) {
            return jsonError('用户名或密码错误');
        }

        // 挂载session
        session(['userData' => $userData]);
        return jsonSuccess('登陆成功');
    }

    /**
     * 登陆注销-处理
     */
    public function adminCancelLogin()
    {
        // 挂载session
        session(['userData' => false]);
        // 重定向
        return redirect('/back/adminLogin');
    }

    /**
     * 管理员列表
     */
    public function getList()
    {
        return view('back.admin.list');
    }

    /**
     * 新建管理员
     */
    public function add()
    {
        return view('back.admin.add');
    }

    /**
     * 新建管理员-处理
     */
    public function addDeal()
    {
        // 接受表单数据
        $userItem = Input::get();
        // 指定验证规则
        $checkArray = [
            [$userItem['username'], 'notNull', '用户名不能为空'],
            [$userItem['password'], 'notNull', '密码不能为空'],
        ];
        // 执行验证
        $checkResult = \App\Service\CheckReceiveDataService::checkAll($checkArray);
        // 检测验证结果
        if ($checkResult !== true) return $checkResult;

        // 执行新增 并返回结果
        return (new AdminModel())->add($userItem);
    }

    /**
     * 编辑管理员
     */
    public function update()
    {
        return view('back.admin.update');
    }

    /**
     * 获取单一数据
     */
    public function getOneData() {
        // 接受表单数据
        $userItem = Input::get();

        // 指定验证规则
        $checkArray = [
            [$userItem['id'], 'notNull', '缺失关键数据'],
        ];
        // 执行验证
        $checkResult = \App\Service\CheckReceiveDataService::checkAll($checkArray);
        // 检测验证结果
        if ($checkResult !== true) return $checkResult;

        // 执行修改并返回结果
        return (new AdminModel())->getOne([['id', '=', $userItem['id']]]);
    }

    /**
     * 编辑管理员-处理
     */
    public function updateDeal()
    {
        // 接受表单数据
        $userItem = Input::get();

        // 指定验证规则
        $checkArray = [
            [$userItem['username'], 'notNull', '用户名不能为空'],
            [$userItem['password'], 'notNull', '密码不能为空'],
        ];
        // 执行验证
        $checkResult = \App\Service\CheckReceiveDataService::checkAll($checkArray);
        // 检测验证结果
        if ($checkResult !== true) return $checkResult;

        // 执行修改并返回结果
        return (new AdminModel())->update([['id', '=', $userItem['id']]], $userItem);
    }

    /**
     * 删除管理员
     */
    public function delete()
    {
        // 接受表单数据
        $userItem = Input::get();

        // 指定验证规则
        $checkArray = [
            [$userItem['id'], 'notNull', '缺失关键数据'],
        ];
        // 执行验证
        $checkResult = \App\Service\CheckReceiveDataService::checkAll($checkArray);
        // 检测验证结果
        if ($checkResult !== true) return $checkResult;

        // 执行修改并返回结果
        return (new AdminModel())->delete([['id', '=', $userItem['id']]]);
    }

    /**
     * 恢复管理员
     */
    public function recovery()
    {
        // 接受表单数据
        $userItem = Input::get();

        // 指定验证规则
        $checkArray = [
            [$userItem['id'], 'notNull', '缺失关键数据'],
        ];
        // 执行验证
        $checkResult = \App\Service\CheckReceiveDataService::checkAll($checkArray);
        // 检测验证结果
        if ($checkResult !== true) return $checkResult;

        // 执行修改并返回结果
        return (new AdminModel())->recovery([['id', '=', $userItem['id']]]);
    }
}
