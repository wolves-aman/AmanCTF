<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 11:18
 */

namespace app\Amanmin\validate;


use think\Validate;

class Tools extends Validate
{
    protected $rule = [
        'title|标题' => 'require|length:1,50|unique:tools,title',
        'type|分类' => 'require|number',
        'des|描述' => 'require|length:1,200',
        'url|链接' => 'require',
        'footurl|底部链接' => 'url',
    ];

    public function sceneAdd()
    {
        return $this->only(['title','type','des','url','footurl']);
    }

}