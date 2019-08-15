<?php
namespace Admin\Controller;
use Think\Controller;
class BalanceController extends Controller {
    public function index(){
        $mod=M("Balancelog");
        $list=$mod->select();
        foreach ($list as $k=>$v) {
            $userid=$v['user_id'];
            $user=M("Member")->where("id=$userid")->find();
            $list[$k]['nickname']=$user['nickname'];
        }
        $a=array("充值","消费");

        $this->assign("list",$list);
        $this->assign("a",$a);
               
        $this->display();
    }
       
	
    function delete(){
        $id=$_POST['id'];

        $res=M("Balancelog")->delete($id);
            if($res){
                echo 1;
            }else{
                echo 0;
            }

    }
	
       
}