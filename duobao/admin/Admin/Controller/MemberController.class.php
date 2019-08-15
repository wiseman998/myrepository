<?php
namespace Admin\Controller;
use Think\Controller;
class MemberController extends Controller {
    public function index(){
        $mod=M("Member");
        $list=$mod->select();

        $b=array("否","是");
        $this->assign("list",$list);
        $this->assign("a",$a);
        $this->assign("b",$b);
        $this->display();
    }
    public function index1(){
        $mod=M("Member");
        $list=$mod->where("is_vip=1")->select();
        $a=array("正常","禁用");
        $b=array("否","是");
        $this->assign("list",$list);

        $this->assign("b",$b);
        $this->display();
    }
	
	
    public function edit(){

        if($_GET['eid']){
            $id=$_GET['eid'];
            $list=M("Member")->where("id=$id")->find();
            $this->assign("list",$list);
            $this->display();
        }

    }
    function delete(){
        $id=$_POST['id'];
        if($id){
            M("Member")->where("id=$id")->delete($id);

            echo 1;
        }
    }
    public function update(){
        
        if($_FILES['headimg']['name']){
            //实例化Upload
            $unlink=$_POST['unlink'];
            $upload=new \Think\Upload();
            //大小
            $upload->maxSize=1234564589;
            //类型
            $upload->exts=array('jpg','png','jpeg');
            //保存路径
            $upload->rootPath="./Public/Uploads/";
            //是否具有日期目录
            $upload->autoSub=true;
            //执行上传
            $info=$upload->upload();
            if(!$info){

                $this->error($upload->getError);

            }else{
                foreach($info as $file){

                        //日期目录
                        $savepath=$file['savepath'];
                        //获取上传以后的图片名字
                        $savename=$file['savename'];
                }

            }
            $map['headimg']="/Public/Uploads/".$savepath.$savename;
            unlink($unlink);
        }
        unset($_POST['unlink']); 
        $id=$_POST['id'];

        $user=M('Member')->where("id=$id")->find();
        //var_dump($user);exit;
        if($user['is_vip']==0 && $_POST['is_vip']==1){
            $map['is_vip']=1;
            $map['vip_addtime']= time();
            $map['vip_datetime']=time()+86400*365;
        }
        $map['nickname']=$_POST['nickname'];
        $map['realname']=$_POST['realname'];
        $map['mobile']=$_POST['mobile'];
        if(strlen($map['mobile'])!=11 || substr($map['mobile'], 0, 1)==0){
            echo 0;exit;
        }
        $map['weixin']=$_POST['weixin'];
        $map['alipay']=$_POST['alipay'];


        //var_dump($map);exit;
        M("Member")->where("id=$id")->save($map);
        $this->success("修改成功");

    }
    public function xufei(){
        $id=$_GET['id'];
        $map['is_vip']=1;
        $map['vip_addtime']= time();
        $map['vip_datetime']=time()+86400*365;
        M("Member")->where("id=$id")->save($map);
        $this->success("续费成功!");
        echo 1;
    }
    public function certification() {
        if(IS_POST){
            $id=$_POST['id'];
            M('Member')->where("id=$id")->setField('is_certification',1);  
        }else{
            $id=$_GET['id'];
            $list=M('Member')->where("id=$id")->find();
            $this->assign('list', $list);
            $this->display();
        }


    }
}