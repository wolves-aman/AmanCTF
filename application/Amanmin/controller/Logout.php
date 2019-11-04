<?php

namespace app\Amanmin\controller;

use think\Controller;

class Logout extends Controller
{

    public function index()
    {
        session('admin',NULL);
        $this->success('退出成功','/amanmin/login');
    }

}
