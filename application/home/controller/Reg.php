<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2019/10/8
 * Time: 22:47
 */

namespace app\home\controller;


use think\Controller;
use app\home\model\Safelog;
class Reg extends Controller
{
    protected function initialize(){

        $result=amanCheck();
        if($result){
            $warn=new Safelog();
            $warn->addLog($result['type'],$result['info']);

        }
    }
    public function index()
    {

        if (request()->isAjax()) {
            $data = [
                'username' => input('username'),
                'email' => input('email'),
                'password' => input('password'),
                'repassword' => input('repassword'),
            ];
            $res = model('user')->add($data);
            if ($res == 1) {
                $this->success("注册成功");
            } else if ($res == 2) {
                $this->success("注册成功，请前往邮箱进行激活", '', '2');
            } else {
                $this->error($res);
            }
        }

        $sys = cache('sysinfo');
        if (!$sys) {
            $sys = model('sys')->getSysInfo();
            cache('sysinfo', $sys, 1800);
        }
        $this->assign('sysinfo', $sys);
        return view();
    }

    public function action()
    {
        $token = input('get.token');

        $result = model('user')->action($token);
        if ($result) {
            $this->success('激活成功！', '/home/login');
        } else {
            $this->error('激活链接无效！', '/home/reg');
        }


    }

}