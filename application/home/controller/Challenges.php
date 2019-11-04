<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2019/10/8
 * Time: 21:56
 */

namespace app\home\controller;


class Challenges extends Base
{
    public function index()
    {
        $typelist = model('type')->getList(1, "id,name")->toArray();
        $subjects = model('subject')->getList()->toArray();
        for ($i = 0; $i < count($subjects); $i++) {
            for ($j = 0; $j < count($typelist); $j++) {
                if (!isset($typelist[$j]['list'])) {
                    $typelist[$j]['list'] = [];
                }
                if ($subjects[$i]['type_id'] == $typelist[$j]['id']) {
                    $typelist[$j]['list'][] = $subjects[$i];
                }

            }

        }
        $this->assign('typelist', $typelist);
        return view();
    }

    public function submitFlag(){
        if (request()->isAjax()) {
            $id = input('id');
            $flag=input('flag');
            $res = model('subject')->where('id',$id)->find();
            if($res){
                if($res['flag']==$flag){
                    $data=[
                        'user_id'=>session('user.id'),
                        'subject_id'=>$res['id'],
                        'coin'=>$res['coin'],
                        'first_coin'=>$res['first_coin'],
                    ];
                    if($res['first']==''){
                        $data['first']='1';
                        model('subject')->addFirst($id);
                    }
                    model('solveLog')->addLog($data);

                    $this->success("恭喜您，FLAG正确");
                }else{
                    $this->error('FLAG不正确');
                }
            }else{
                $this->error('数据不存在','','-1');
            }
        }
    }


    public function getSubject()
    {
        if (request()->isAjax()) {
            $id = input('id');
            $res = model('subject')->getSubjectById($id);
            if ($res) {
                $model = '';
                $model .= '<div class="aman-model-bk">';
                $model .= '<div class="aman-model">';
                $model .= '<span class="close">&times;</span>';
                $model .= '<p class="title">' . $res['title'] . '</p>';
                $model .= '<div class="content">';
                $model .= '<p style="display: flex;justify-content: space-between">';
                $model .= '<span>分数:' . $res['value'] . '</span>';
                $model .= '<span>一血: ' . ($res['first'] != '' ? $res['user']['nickname'] : '无') . '</span>';
                $model .= '<span>解决:' . $res->get_count_count . '</span>';
                $model .= '</p>';
                $model .= '<p style="display: flex;justify-content: space-between">';
                $model .= '<span>作者:' . $res['author'] . '</span>';
                $model .= '<span>金币:' . ($res['coin'] + 0) . '</span>';
                $model .= '<span>一血奖励: ' . ($res['first_coin'] + 0) . '</span>';
                $model .= '</p>';
                $model .= '<p>HINT:' . ($res['hint'] != '' ? $res['hint'] : '暂无') . '</p>';

                $model .= '<p style="height: 80px;line-height: 25px;margin: 0;overflow: hidden;margin-bottom: 10px;">' . $res['content'] . '</p>';
                if ($res['url'] != '') {
                    $model .= '<a target="_blank" class="aman-btn am-btn" href="'.$res['url'].'">'.($res['urltitle']==''?'下载':$res['urltitle']).'</a>';
                }
                $model .= '</div>';
                $model .= '<div class="foot">';
                $model .= '<input id="flag" type="text" placeholder="input flag" class="input"><button data-id="'.$res['id'].'"  id="submit" class="aman-btn am-btn">提交</button>';
                $model .= '<p class="hint success" style="display: none"></p>';
                $model .= '</div>';
                $model .= '</div>';
                $model .= '</div>';
                model('solveLog')->add(['user_id'=>session('user.id'),'subject_id'=>$res['id']]);
                $this->success('ok', '', $model);
            } else {
                $this->error('获取数据出错');
            }
        }
    }
}