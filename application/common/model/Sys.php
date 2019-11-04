<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2019/10/3
 * Time: 15:10
 */
namespace app\common\model;


use think\Model;

class Sys extends Model
{
    public function getSysInfo(){
        return $this->where('id',1)->find();
    }
    public function edit($data){

        $sys=$this->where('id','1')->find();
        if($sys){
            if($sys->allowField(true)->save($data)){
                cache('sysinfo',$sys,1800);
                return 1;
            }else{
                return "保存失败";
            }

        }else{
            return "保存失败";
        }


    }
}