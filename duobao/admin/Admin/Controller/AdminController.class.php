<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller {
    public function index(){
        if($_GET){
            $type=$_GET['type'];
            $id=$_GET['id'];
            if($type=='stop'){
                    M("Admin")->where("id=$id")->setField("status",1);
                    echo 1;
            }elseif($type='start'){
                    M("Admin")->where("id=$id")->setField("status",0);
                    echo 0;
            }
        }else{
            $mod=M("Admin");

            $list=$mod->select();
            $a=array("启用","未启用");
            $this->assign("list",$list);
            $this->assign("a",$a);
            $this->display();
        }
    }
    public function add(){

            $this->display();
    }
    public function insert(){
        $map['username']=$_POST['username'];
        $map['realname']=$_POST['realname'];
        $map['password']= md5($_POST['password']);
        $map['phone']=$_POST['phone'];
        if(strlen($map['phone'])!=11 || substr($map['phone'], 0, 1)==0){
            echo 2;exit;
        }
        $map['add_time']=time();
        $map['status']=0;
        $newid=M("Admin")->add($map);
        if($newid){
            echo 1;
        }else{
            echo 0;
        }

    }
    public function edit(){
        if($_POST){

            $aid=$_POST['id'];
            $map['username']=$_POST['username'];
            $map['realname']=$_POST['realname'];
            $map['phone']=$_POST['phone'];
            if(strlen($map['phone'])!=11 || substr($map['phone'], 0, 1)==0){
                echo 0;exit;
            }
            $map['password']= md5($_POST['password']);
            //var_dump($map);exit;
            M('Admin')->where("id=$aid")->save($map);

        }else{
            $aid=$_GET['id'];

            $ar=M("Admin")->where("id=$aid")->find();
            $this->assign("ar",$ar);


            $this->assign("aid",$aid);
            $this->display();
        }

    }
    public function delete(){

        $id=$_POST['id'];
        if(M("Admin")->delete($id)){
                echo 3;
        }
    }
	
	
}	