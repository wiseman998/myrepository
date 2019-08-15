<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function login(){
	   
        $this->display();
    }
    //加载验证码
    public function verify(){
	   
        //实例化验证码
        $verify=new \Think\Verify();
        //字体大小
        $verify->fontSize=20;
        //是否采用杂点
        $verify->useNoise=true;
        //验证码的位数
        $verify->length=4;
        //是否采用中文验证码
        $verify->zhSet="郑州二七";
        //写入验证码
        $verify->entry();
    }
    //执行登录
    public function dologin(){
        //获取验证码
        $fcode=$_POST['fcode'];
        //s实例化验证码类
        $verify=new \Think\Verify();
        if($verify->check($fcode,"")){
            //获取登陆的的用户和密码
            $username=$_POST["username"];
            $password= md5($_POST["password"]);
            //实例化model
            $mod=M("Admin");
            $row=$mod->where("username='{$username}' and password='{$password}'")->find();
            if($row){
                //把用户的信息存储在session
                $_SESSION['username']=$username;
                $_SESSION['id']=$row['id'];
                $_SESSION['islogin']=2;
                //用户权限
                //1.获取当前登录用户的所能访问的节点信息
                $list=$mod->query("select n.mname,n.aname from __PREFIX__admin_role ar,__PREFIX__role_node rn,__PREFIX__node n where ar.rid=rn.rid and rn.nid=n.id and ar.aid={$row['id']}");
                //后台首页访问权限
                $nodelist['index'][]="index";
                $nodelist['welcome'][]="index";
                //遍历$list
                foreach($list as $key=>$v){
                    $nodelist[$v['mname']][]=$v['aname'];
                    //如果有add把insert权限写进去
                    /* if($v['aname']=="add"){
                            $nodelist['mname'][]="insert";
                    }
                    //如果有edit 把update写入
                    if($v['aname']=="edit"){
                            $nodelist['mname'][]="update";
                    } */

                }
                //dump($nodelist);exit;
                //2.存储在session数组里 
                session("nodelist",$nodelist);

                //跳转
                $this->success("登录成功",U('Index/index'));

            }else{
                $this->error("用户名或者密码有误",U("Login/login"));
            }
	   }else{
                $this->error("验证码有误",U('Login/login'));
	   }
    }
    //退出
    public function logout(){
        setcookie(session_name(),'',time()-100,'/');
        $_SESSION=array();
        session_destroy();
        $this->success("退出成功",U("Login/login"));
    }
}