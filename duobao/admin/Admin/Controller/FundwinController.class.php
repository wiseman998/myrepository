<?php
namespace Admin\Controller;
use Think\Controller;
class FundwinController extends Controller {
    public function index(){
        $mod=M("Fundwinlog");
        $list=$mod->select();
        foreach ($list as $k=>$v) {
            $userid=$v['user_id'];
            $user=M("Member")->where("id=$userid")->find();
            $list[$k]['nickname']=$user['nickname'];
            $fundid=$v['fund_id'];
            $fund=M("Dreamfund")->where("id=$fundid")->find();
            $list[$k]['fundname']=$fund['fund_name'];
        }
        $a=array("异常","正常");
        $this->assign("list",$list);
        $this->assign("a", $a);
		
        $this->display();
    }
       
    
    function delete(){
        $id=$_POST['id'];
        if($id){
            M("Fundwinlog")->where("id=$id")->delete($id);

            echo 1;
        }
    }
    
        
}