<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 10:49
 */

namespace app\home\model;


use think\Model;

class Safelog extends Model
{
    public function getUser(){
        return $this->hasOne('user','id','uid');
    }
    public function getAdmin(){
        return $this->hasOne('admin','id','uid');
    }

    //添加日志
    public function addLog($type,$info){
        $usertype=0;
        $data=[];
        if(session('?user.id')){
            $usertype=1;
            $data['uid']=(int)session('user.id');
        }


        $data['ip']=request()->ip();
        $data['url']=request()->domain().request()->url();
        $data['agent']=request()->header()['user-agent'];
        $data['method']=request()->method();
        $data['cookie']=request()->header()['cookie'];
        $data['data']=json_encode(request()->post());
        $data['usertype']= $usertype;
        $data['type']= $type;
        $data['info']= $info;
        $this->save($data);
    }
}