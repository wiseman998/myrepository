<?php
namespace Admin\Controller;
use Think\Controller;
class WinController extends Controller {
    public function index(){
        $mod=M("Winlog");
        $list=$mod->select();
        foreach ($list as $k=>$v) {
            $userid=$v['user_id'];
            $user=M("Member")->where("id=$userid")->find();
            $list[$k]['nickname']=$user['nickname'];
            $goodid=$v['good_id'];
            $good=M("Good")->where("id=$goodid")->find();
            $list[$k]['goodname']=$good['good_name'];
        }
        $a=array("异常","正常");
        $this->assign("list",$list);
        $this->assign("a", $a);
		
        $this->display();
    }
       
    
    function delete(){
        $id=$_POST['id'];
        if($id){
            M("Winlog")->where("id=$id")->delete($id);

            echo 1;
        }
    }
    
        
}