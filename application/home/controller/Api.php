<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2019/10/8
 * Time: 22:13
 */

namespace app\home\controller;


class Api extends Base
{
    public function challenges(){
        if(request()->isAjax()){
            $typelist=model('type')->getList(1,"id,name")->toArray();
            $subjects=model('subject')->getList()->toArray();
            for($i=0;$i<count($subjects);$i++){
                for($j=0;$j<count($typelist);$j++){

                    if($subjects[$i]['type_id']==$typelist[$j]['id']){
                        $typelist[$j]['data'][]=&$subjects[$i];
                    }

                }

            }
           $this->success('ok','',$typelist);

        }


    }
}