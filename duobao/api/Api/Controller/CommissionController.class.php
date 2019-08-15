<?php

namespace Api\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8");
class CommissionController extends Controller{
    public function getcommission() {
        $userid=$_GET['id'];
        $commissions=M('Commissionlog')->where("user_id=$userid")->field('changenum,type,usercommission,addtime')->select();
        foreach ($commissions as $k => $v) {
            $commissions[$k]['addtime']= date("Y-m-d H:i", $v['addtime']);
        }
        echo json_encode($commissions,JSON_UNESCAPED_UNICODE);
    }
}

