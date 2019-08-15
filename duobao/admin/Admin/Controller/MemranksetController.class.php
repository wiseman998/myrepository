<?php
namespace Admin\Controller;
use Think\Controller;
class MemranksetController extends Controller {
    public function index(){
        $mod=M("Memrankset");
        $list=$mod->select();

        $this->assign("list",$list);
         
        $this->display();
    }
       
    public function edit(){

        if($_GET['eid']){
            $id=$_GET['eid'];
            $list=M("Memrankset")->where("id=$id")->find();

            $this->assign("list",$list);

            $this->display();
        }

    }
	
    public function update(){

        $id=$_POST['id'];

        M("Memrankset")->where("id=$id")->save($_POST);
        $this->success("修改成功");

    }
        
}