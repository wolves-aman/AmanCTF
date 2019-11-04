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
class Login extends Controller
{
    //防止重复登录
    protected function initialize(){

        if(session('?user.id')){
            $this->redirect('/');
        }

        $result=amanCheck();
        if($result){
            $warn=new Safelog();
            $warn->addLog($result['type'],$result['info']);

        }
    }

    public function index(){

        if(request()->isAjax()){
            $data=[
                'username'=>input('post.username'),
                'password'=>input('post.password'),
            ];
            $result=model('User')->login($data);
            if($result==1){
                $this->success('登录成功！','/');
            }else{
                $this->error($result);
            }

        }
        $sys=cache('sysinfo');
        if(!$sys){
            $sys=model('sys')->getSysInfo();
            cache('sysinfo',$sys,1800);
        }
        $this->assign('sysinfo',$sys);
        return view();
    }

}