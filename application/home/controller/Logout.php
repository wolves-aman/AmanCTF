<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2019/10/10
 * Time: 20:34
 */

namespace app\home\controller;


use think\Controller;

class Logout extends Controller
{
    public function index()
    {
        session('user',NULL);
        $this->success('退出成功', '/index');
    }

}