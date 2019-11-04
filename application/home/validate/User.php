<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 11:18
 */

namespace app\home\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username|账号' => 'require|chsAlphaNum|length:4,25',
        'email|邮箱'            =>'require|email|unique:user',
        'password|密码'         =>'require|alphaDash|length:6,25',
        'repassword|确认密码'   =>'require|confirm:password',
        'nickname|昵称'         =>'length:4,20|unique:user'
    ];

    //登录验证场景
    protected function sceneLogin(){
        return $this->only(['username','password']);
    }


    public function sceneAdd()
    {
        return $this->only(['username','email','password','repassword'])->append('username','unique:user');
    }

    //用户个人信息验证场景
    protected function sceneInfo(){
        return $this->only(['nickname','password','repassword'])->remove('password','require')->remove('repassword','require');
    }

}