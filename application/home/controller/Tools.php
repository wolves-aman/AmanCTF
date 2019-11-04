<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2019/10/9
 * Time: 18:32
 */

namespace app\home\controller;


class Tools extends Base
{
    public function index(){
        $typelist = model('type')->getList(3, "id,name")->toArray();
        $subjects = model('tools')->getList()->toArray();
        for ($i = 0; $i < count($subjects); $i++) {
            for ($j = 0; $j < count($typelist); $j++) {
                if (!isset($typelist[$j]['list'])) {
                    $typelist[$j]['list'] = [];
                }
                if ($subjects[$i]['type'] == $typelist[$j]['id']) {
                    $typelist[$j]['list'][] = $subjects[$i];
                }

            }

        }
        $this->assign('typelist', $typelist);

        return view();
    }

}