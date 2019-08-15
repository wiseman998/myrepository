<?php
namespace Admin\Controller;
use Think\Controller;
class OrderController extends Controller {
    public function index(){
        
       
        $mod=M("Order");
        $list=$mod->select();

        foreach ($list as $k=> $v) {
            $userid=$v['user_id'];

            $user=M("Member")->where("id=$userid")->find();
            $list[$k]['username']=$user['nickname'];


        }
        $a=array("余额","微信","支付宝");

        $b=array("待付款","已付款");

        $this->assign("list",$list); 
        $this->assign("a",$a);
        $this->assign("b",$b);
         
        $this->display();
     
    }
        
    public function index1() {
        $mod=M("Order");
        $list=$mod->where(array("status"=>1))->select();

        foreach ($list as $k=> $v) {
            $userid=$v['user_id'];


            $user=M("Member")->where("id=$userid")->find();
            $list[$k]['username']=$user['nickname'];


        }
        $a=array("余额","微信","支付宝");

        $b=array("待付款","已付款");

        //var_dump($username);exit;


        $this->assign("list",$list); 
        $this->assign("a",$a);
        $this->assign("b",$b);

        $this->display();
    }

}