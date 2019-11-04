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
class Tools extends Model
{
    protected $dateFormat = 'Y-m-d';

    public function getList(){

        return $this->order(['create_time'=>'desc'])->select();

    }
}