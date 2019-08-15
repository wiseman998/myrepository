<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends AllowController {
    public function index(){
        $mid=$_SESSION['mid'];
        $admin=M("Admin")->where("mid=$mid")->find();
        $this->assign("admin",$admin);
        $this->display();

    }
}