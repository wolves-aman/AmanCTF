<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 11:18
 */

namespace app\Amanmin\validate;


use think\Validate;

class Type extends Validate
{
    protected $rule = [
        'name|标题' => 'require|length:1,25|unique:type,name^type',
        'order|排序' => 'number'
    ];

    public function sceneAdd()
    {
        return $this->only(['name','order']);
    }


}