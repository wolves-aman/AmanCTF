<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 10:49
 */

namespace app\home\model;


use think\Model;

class Notice extends Model
{

    public function getList($len=15){

        if($len==-1){
            return $this
                ->order('create_time','desc')

                ->select();
        }else{
            return $this
                ->order('create_time','desc')
                ->limit($len)
                ->select();
        }
    }

    public function getNotice($id){
        return $this->where('id',$id)->find();
    }

}