<?php

namespace Api\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8");
class NoticeController extends Controller {
    public function gettask() {
        $mod=M('Notice');
        $tasks=$mod->where("type=1")->field('title,detail,addtime')->select();
        foreach ($tasks as $k => $v) {
            $tasks[$k]['addtime']= date("Y-m-d H:i", $v['addtime']);
        }
        echo json_encode($tasks,JSON_UNESCAPED_UNICODE);
        
    }
    public function getnotice() {
        $mod=M('Notice');
        $notices=$mod->where("type=0")->field('title,detail,addtime')->select();
        foreach ($notices as $k1 => $v1) {
            $notices[$k1]['addtime']= date("Y-m-d H:i", $v1['addtime']);
        }
        echo json_encode($notices,JSON_UNESCAPED_UNICODE);
    }
}

