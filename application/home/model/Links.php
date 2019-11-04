<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 10:49
 */

namespace app\home\model;


use think\Model;
use app\admin\validate\Links as LinksValidate;

class Links extends Model
{

    public function getList(){
        return $this
            ->where(['hide'=>'0'])
            ->order('order','asc')
            ->select();
    }

}