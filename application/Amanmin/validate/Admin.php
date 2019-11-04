<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 11:18
 */

namespace app\Amanmin\validate;


use think\Validate;

class Admin extends Validate
{
    protected $rule=[
      'username|账号'=>'require|length:5,25',
      'password|密码'=>'require',
    ];
    public function sceneLogin(){
        return $this->only(['username','password']);
    }

}