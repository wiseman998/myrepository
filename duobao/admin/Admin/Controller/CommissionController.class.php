<?php
namespace Admin\Controller;
use Think\Controller;
class CommissionController extends AllowController {
    public function index(){
        $mod=M("Commissionlog");
        $list=$mod->select();
        foreach ($list as $k=>$v) {
            $userid=$v['user_id'];
            $user=M("Member")->where("id=$userid")->find();
            $list[$k]['nickname']=$user['nickname'];
        }
        $a=array("推广奖励","任务奖励","提现");

        $this->assign("list",$list);
        $this->assign("a",$a);
               
        $this->display();
    }
        
	
    function delete(){
        $id=$_POST['id'];

        $res=M("Commissionlog")->delete($id);
        if($res){
             echo 1;
        }else{
            echo 0;
        }

    }

}