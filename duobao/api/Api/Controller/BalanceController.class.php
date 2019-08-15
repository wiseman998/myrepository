<?php

namespace Api\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8");
class BalanceController extends Controller{
    public function getbalance() {
        $userid=$_GET['id'];
        $balances=M('Balancelog')->where("user_id=$userid")->field('changenum,type,userbalance,addtime')->select();
        foreach ($balances as $k => $v) {
            $balances[$k]['addtime']= date("Y-m-d H:i", $v['addtime']);
        }
        
        echo json_encode($balances,JSON_UNESCAPED_UNICODE);
        
    }
}

