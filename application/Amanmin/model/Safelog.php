<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15
 * Time: 12:40
 */

namespace app\Amanmin\model;


use think\Model;

class Safelog extends  Model
{
    public function getUser(){
        return $this->hasOne('user','id','uid');
    }
    public function getAdmin(){
        return $this->hasOne('admin','id','uid');
    }

    public function getNew(){
        return $this->where('status',0)->count();
    }

    public function getAll($len=30){
        $this->where('status',0)->update(['status'=>1]);
        cache('leftinfo',NULL);
        return $this->order('id','desc')
            ->paginate($len);

    }
}