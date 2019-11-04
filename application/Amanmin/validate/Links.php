<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 11:18
 */

namespace app\Amanmin\validate;


use think\Validate;

class Links extends Validate
{
    protected $rule = [
        'title|标题' => 'require|length:1,50|unique:links,title',
        'url|链接' => 'require|url|unique:links,url',
        'logo|LOGO' => 'url',
        'order|排序' => 'number',
        'checkurl|底部链接' => 'url',
    ];

    public function sceneAdd()
    {
        return $this->only(['title','url','logo','order','checkurl']);
    }

}