<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2019/10/9
 * Time: 18:32
 */

namespace app\home\controller;


class User extends Base
{
    public function index()
    {

        $id = input('id');
        if (!$id)
            $id = session('user.id');
        $user = model('user')->getUserByID($id);
        if (!$user) {
            $this->error("用户不存在");
        }
        $this->assign('user', $user);

        $list = model('solveLog')->getUserList($id);
        $this->assign('list', $list);

        $typelist = model('type')->getCountByUser($id);

        for ($i = 0; $i < count($list); $i++) {
            for ($j = 0; $j < count($typelist); $j++) {
                if (!isset($typelist[$j]['use'])) {
                    $typelist[$j]['use'] = 0;
                }
                if ($list[$i]['get_subject']['type_id'] == $typelist[$j]['id']) {
                    $typelist[$j]['use'] = $typelist[$j]['use'] + 1;
                }

            }

        }

        $this->assign('typelist', $typelist);


        $res = model('SolveLog')->getCountByDay($id, 15);
        $this->assign('log', $res);

        return view();
    }

    public function edit()
    {
        if (request()->isAjax()) {
            $data = input();
            $result = model('User')->saveinfo($data);
            if ($result == 1) {
                $this->success('保存成功!');
            } else {
                $this->error($result);
            }

        }

    }

    public function uploadcover(){
        $file = request()->file('file');
        if($file){
            $info = $file->validate(['ext'=>'jpg,png,gif,icon'])->move( 'heads');
            if($info){
                $name_path =str_replace('\\',"/",$info->getSaveName());
                $data['cover']='/heads/'.$name_path;
                $user=model('user')->where('id',session('user.id'))->find();
                model('user')->saveinfo($data);
                $a = substr($user->cover,1);
                if($a!='heads/hover.png'){
                    @unlink($a);
                }

                $this->success('保存成功');
            }else{
                return $this->error($file->getError());
            }
        }
    }

}