<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15
 * Time: 12:40
 */

namespace app\Amanmin\model;


use think\Model;

class Syslog extends  Model
{
    public function getUser(){
        return $this->hasOne('user','id','uid');
    }
    public function getAdmin(){
        return $this->hasOne('admin','id','uid');
    }

    //添加日志
    public function addLog($data){
        $data['ip']=request()->ip();
        $data['url']=request()->domain()."/".request()->path();
        $data['agent']=request()->header()['user-agent'];
        $data['method']=request()->method();
        $data['cookie']=request()->header()['cookie'];
        if(!isset($data['data']))
        $data['data']=json_encode(request()->post());
        $this->save($data);
    }
    public function getAll($len=20){
        return $this->order('id','desc')
            ->paginate($len);
    }

}