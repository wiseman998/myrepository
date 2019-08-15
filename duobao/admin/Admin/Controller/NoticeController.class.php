<?php
namespace Admin\Controller;
use Think\Controller;
class NoticeController extends Controller {
    public function index(){
		
	$list=M("Notice")->select();
        $a=array("公告","任务");
        $this->assign("a",$a);
	$this->assign("list",$list);
	$this->display();
		
    }
    public function add(){
        $this->display();
    }
    public function edit(){
        $id=$_GET['id'];

        $notice=M("Notice")->where("id=$id")->find();
         //var_dump($notice);exit;
        $this->assign("notice",$notice);
        $this->display();
    }
	
    public function update(){

        if(M("Notice")->save($_POST)){
            $this->success("编辑成功");
        }

    }
    public function delete(){
        $id=$_GET['id'];
        if(M("Notice")->delete($id)){
                echo 1;
        }

    }
    public function insert(){
        $_POST['addtime']=time();
        if(M("Notice")->add($_POST)){
                $this->success("添加成功");
        }else{
                $this->error("添加失败");
        }
    }
}