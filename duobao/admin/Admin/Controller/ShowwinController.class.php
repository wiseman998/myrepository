<?php
namespace Admin\Controller;
use Think\Controller;
class ShowwinController extends Controller {
    public function index(){
        $mod=M("Showwin");
        $list=$mod->select();
        foreach ($list as $k=>$v) {
            $userid=$v['user_id'];
            $user=M("Member")->where("id=$userid")->find();
            $list[$k]['nickname']=$user['nickname'];
        }

        $this->assign("list",$list);
        $this->display();
    }
    public function edit() {
        $id=$_GET['eid'];
        $list=M("Showwin")->where("id=$id")->find();
        $this->assign("list", $list);
        $this->display();
    }
    public function update() {
        $id=$_POST['id'];
        M("Showwin")->where("id=$id")->save($_POST);
        $this->success("修改成功");
    }
    public function delete() {
        $id=$_POST['id'];
        $res=M("Showwin")->delete($id);
        if($res){
            echo 1;
        }else{
            echo 0;
        }
    }
       
}