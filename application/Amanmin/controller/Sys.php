<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15
 * Time: 17:30
 */

namespace app\Amanmin\controller;


class Sys extends Base
{
    public function index(){
       // sendMail('915293740@qq.com','123','h<h2>1111</h2>');
        return view();
    }

    public function save(){
        $result=model('sys')->edit(input());
        if($result==1){
            $this->success('保存成功');
        }else{
            $this->error($result);
        }
    }



}