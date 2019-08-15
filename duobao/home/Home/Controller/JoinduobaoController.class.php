<?php

namespace Home\Controller;
use Think\Controller;
class JoinduobaoController extends Controller{
    public function index() {
        if(IS_POST){
            $string='yydb';
            $map['parentid']=$_POST['recommendid'];
            $id= substr($map['parentid'],4);
            echo $id;exit;
            $pparentid=M('Member')->where("id=$id")->field('parentid')->find();
            //判断新加入会员的父父级id是否存在
            if($pparentid['parentid']){
                $map['pparentid']=$pparentid['parentid'];
            }
            $map['mobile']=$_POST['mobile'];
            if(!preg_match("/^1[34578]{1}\d{9}$/",$map['mobile'])|| strlen($map['mobile'])!=11){
                echo 2;exit;
            }
            $check=M('Member')->where(array('mobile'=>$map['mobile']))->find();
            if($check){
                echo 3;exit;
            }
            $map['addtime']= time();
            $res=M('Member')->add($map);
            if($res){
                $res1=M('Member')->where("id=$res")->setField('recommendid',$string.$res);
                if($res1){
                   echo 1;exit; 
                }
                
            }else{
                echo 0;exit;
            }
            
        }else{
            $recommendid=$_GET['recommendid'];
            $this->assign('recommendid', $recommendid);
            $this->display();
        }
    }
}

