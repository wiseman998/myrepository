<?php
namespace Admin\Controller;
use Think\Controller;
class ReturnmoneysetController extends Controller {
    public function index(){
        $mod=M("Returnmoneyset");
        $list=$mod->select();

        $this->assign("list",$list);
         
        $this->display();
    }
       
    public function edit(){

        if($_GET['eid']){
            $id=$_GET['eid'];
            $list=M("Returnmoneyset")->where("id=$id")->find();

            $this->assign("list",$list);

            $this->display();
        }

    }
	
    public function update(){

        $id=$_POST['id'];
        if($_POST['one_level']<$_POST['two_level'] || $_POST['two_level']<$_POST['three_level']){
            echo 0;exit;
        }

        //var_dump($_POST);exit;
        M("Returnmoneyset")->where("id=$id")->save($_POST);
        $this->success("修改成功");

    }
        
}