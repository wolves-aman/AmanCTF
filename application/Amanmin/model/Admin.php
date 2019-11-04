<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 10:49
 */

namespace app\Amanmin\model;


use think\Model;
use app\Amanmin\validate\Admin as AdminValidate;

class Admin extends Model
{
    public function login($data){
        $validate=new AdminValidate();
        if(!$validate->scene('login')->check($data)){
            return $validate->getError();
        }
        $data['password']=md5($data['password']);
        $result=$this->where($data)->find();
        if($result){
            $this->createSession($result);
            return 1;
        }else{
            return '账号或密码错误';
        }
    }
    public function edit($data){
        $admin=$this->where(['id'=>session('admin.id'),'password'=>md5($data['oldpass'])])->find();
        if($admin){
            $tmp['username']=$admin['username'];
            $tmp['password']=$data['password'];
            $validate=new AdminValidate();
            if(!$validate->scene('login')->check($tmp)){
                return $validate->getError();
            }
            $data['password']=md5($data['password']);
            $admin->allowField(true)->save($data);
            $this->createSession($admin);
            return 1;
        }else{
            return "旧密码错误";
        }
    }



    private function createSession($admin){
        $admin=$admin->toArray();
        session('admin',$admin);
    }

}