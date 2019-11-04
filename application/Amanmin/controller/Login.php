<?php

namespace app\Amanmin\controller;

use think\Controller;

class Login extends Controller
{
    protected function initialize()
    {
        parent::initialize();
        if(session('?admin.id')){
            $this->redirect('/amanmin/index');
        }
        $sys=cache('sysinfo');
        if(!$sys){
            $sys=model('sys')->getSysInfo();
            cache('sysinfo',$sys,1800);
        }
        $this->assign('sysinfo',$sys);
    }

    public function index()
    {
        if (request()->isAjax()) {

            $data=[
                'username'=>input('username'),
                'password'=>input('password')
            ];
            $result = model('admin')->login($data);
            if($result==1){

                $data=[
                    'usertype'=>2,
                    'uid'=>session('admin.id'),
                    'type'=>"后台登录",
                    'info'=>"登录成功",
                    'result'=>1,
                    'data'=>'作者觉得不能让你看到'
                ];
                model('syslog')->addLog($data);
                $this->success('登录成功','/amanmin/index');
            }else{
                $data=[
                    'usertype'=>0,
                    'uid'=>'',
                    'type'=>"后台登录",
                    'info'=>$result,
                    'result'=>0,
                ];
                model('syslog')->addLog($data);
                $this->error($result);
            }
        }
        return view();
    }

}
