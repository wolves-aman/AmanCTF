<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 11:18
 */

namespace app\Amanmin\validate;


use think\Validate;

class Subject extends Validate
{
    protected $rule = [
        'title|标题' => 'require|length:1,50|unique:subject,title',
        'value|分值' => 'require|number',
        'type_id|分类' => 'require',
        'flag|FLAG' => 'require|length:5,50',
        'content|内容' => 'require|length:5,200',
        'author|作者' => 'length:2,25',
    ];

    public function sceneAdd()
    {
        return $this->only(['title','value','type_id','content','author']);
    }

}