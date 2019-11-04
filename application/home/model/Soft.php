<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 10:49
 */

namespace app\home\model;


use think\Model;
use app\admin\validate\Soft as SoftValidate;
class Soft extends Model
{
    protected $dateFormat = 'Y-m-d';
    public function getType(){
        return $this->hasOne('type','id','type');
    }
    public function getList(){

        return $this->order(['update_time'=>'desc','id'=>'asc'])->select();

    }
}