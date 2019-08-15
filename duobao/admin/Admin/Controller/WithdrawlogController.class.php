<?php
namespace Admin\Controller;
use Think\Controller;
class WithdrawlogController extends Controller {
    public function index(){
        
       
        $mod=M("Withdrawlog");
        $list=$mod->select();

        foreach ($list as $k=> $v) {
            $userid=$v['user_id'];
            $user=M("Member")->where("id=$userid")->find();
            $list[$k]['name']=$user['nickname'];

        }
        $a=array("余额","佣金");
        $b=array("微信","支付宝");
        $c=array("审核中","已打款","已拒绝");

        $this->assign("list",$list); 
        $this->assign("a",$a);
        $this->assign("b",$b);
        $this->assign("c",$c);
	
        $this->display();
     
    }
    public function index1() {
        $mod=M("Withdrawlog");
        $list=$mod->where(array("status"=>1))->select();

        foreach ($list as $k=> $v) {
            $userid=$v['user_id'];
            $user=M("Member")->where("id=$userid")->find();
            $list[$k]['name']=$user['nickname'];

        }
        $a=array("余额","佣金");
        $b=array("微信","支付宝");
        $c=array("审核中","已打款","已拒绝");

        $this->assign("list",$list); 
        $this->assign("a",$a);
        $this->assign("b",$b);
        $this->assign("c",$c);

        $this->display();
    }
    public function detail(){
        $id=$_GET['id'];
        $list=M("Withdrawlog")->where("id=$id")->find();
        $userid=$list['user_id'];
        $username=M("Member")->where("id=$userid")->find();
        $a=array("余额","佣金");
        $b=array("微信","支付宝");
        $c=array("审核中","已打款","已拒绝");
        $this->assign("list",$list); 
        $this->assign("a",$a);
        $this->assign("b",$b);
        $this->assign("c",$c);
        $this->assign("username",$username);
        $this->display();
    }

    public function confirm(){
        $id=$_POST['id'];
        $withdraw=M("Withdrawlog")->where("id=$id")->find();
        //避免已拒绝的提现申请进行确认操作
        if($withdraw['status']==2){
            echo 2;exit;
           //避免重复确认
        }else if($withdraw['status']==1){
            echo 3;exit;
        }else{
            $map['status']=1;
            $map['paytime']=time();
            //var_dump($map);exit;
            $res=M("Withdrawlog")->where("id=$id")->save($map);
            if($res){
                //增加一条余额提现流水
                if($withdraw['type1']==0){
                    $map1['user_id']=$withdraw['user_id'];
                    $user=M('Member')->where(array('id'=>$map1['user_id']))->field('balance')->find();
                    $map1['withdraw_id']=$id;
                    $map1['type']=2;
                    $map1['changenum']=$withdraw['money'];
                    $map1['userbalance']=$user['balance']-$map1['changenum'];
                    $map1['addtime']=time();
                    $res1=M('Balancelog')->add($map1);
                    if($res1){
                        //更新会员余额数据
                        $res11=M('Member')->where(array('id'=>$map1['user_id']))->setField("balance",$map1['userbalance']);
                        if($res11){
                            echo 1;
                        }
                    }
                }else if($withdraw['type1']==1){
                    //增加一条佣金提现流水
                    $map2['user_id']=$withdraw['user_id'];
                    $user=M('Member')->where(array('id'=>$map2['user_id']))->field('commission')->find();
                    $map2['withdraw_id']=$id;
                    $map2['type']=2;
                    $map2['changenum']=$withdraw['money'];
                    $map2['usercommission']=$user['commission']-$map2['changenum'];
                    $map2['addtime']=time();
                    $res1=M('Commissionlog')->add($map2);
                    if($res1){
                        //更新会员佣金数据
                        $res11=M('Member')->where(array('id'=>$map2['user_id']))->setField("commission",$map2['usercommission']);
                        if($res11){
                            echo 1;
                        }
                    }
                }
               
            }else{
                echo 0;
            }
        }

    }
    public function refuse(){
        $id=$_POST['id'];
        $withdraw=M("Withdrawlog")->where("id=$id")->find();
        //避免已确认的提现申请被拒绝操作
        if($withdraw['status']==1){
            echo 2;exit;
            //避免重复拒绝
        }else if($withdraw['status']==2){
            echo 3;exit;
        }else{
            $map['status']=2;
            $map['refusetime']=time();
            $res=M("Withdrawlog")->where("id=$id")->save($map);
            if($res){
                echo 1;
            }else{
                echo 0;
            }
    }
            
    }
 
}