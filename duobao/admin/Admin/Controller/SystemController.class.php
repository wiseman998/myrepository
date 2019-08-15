<?php

namespace Admin\Controller;
use Think\Controller;
class SystemController extends Controller{
    public function setfee(){
        if(IS_POST){
           $fee=$_POST['fee'];
           if($fee<=0){
               echo 0;exit;
                
           }else if($fee>=1){
               echo 1;exit;
              
           }else{
               $res=M('System')->where("id=1")->setField('fee',$fee);
               if($res){
                echo 2;exit; 
                
                }else{
                echo 3;exit;
                
                } 
           }
            
        }else{
            $system=M('System')->where("id=1")->field('fee')->find();
            $fe=$system['fee'];
            $this->assign('fee', $fe);
            $this->display();
        }
        
    }
    public function setweixin() {
        if(IS_POST){
            if($_FILES['weixincode']['name']){
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
                $_POST['weixincode']="/Public/Uploads/".$savepath.$savename;
                unlink($unlink);
            }
            unset($_POST['unlink']); 
            M("System")->where("id=1")->save($_POST);
        }else{
            $system=M('System')->where("id=1")->field('weixincode,weixin')->find();
            $this->assign('system', $system);
            $this->display();
        }
    }
    public function setabout() {
        if(IS_POST){
            $res=M('About')->where("id=1")->save($_POST);
            if($res){
                $this->success('信息修改成功');
            }else{
                $this->error('信息修改失败');
            }
        }else{
            $about=M('About')->where("id=1")->field('title,detail')->find();
            $this->assign('about', $about);
            $this->display();
        }
    }
    //支付参数设置
    public function setpayparam() {
        if(IS_POST){
            $map['appid']=$_POST['appid'];
            $map['appsecretkey']=$_POST['appsecretkey'];
            $map['alipaykey']=$_POST['alipaykey'];
            if(empty($map['appid']) || empty($map['appsecretkey']) || empty($map['alipaykey'])){
                echo 0;exit;
            }else{
                $res=M('System')->where("id=1")->save($map);
                if($res){
                    echo 1;exit;
                }else{
                    echo 2;exit;
                }
            }
        }else{
            $system=M('System')->where("id=1")->field('appid,appsecretkey,alipaykey')->find();
            $this->assign('system', $system);
            $this->display();
        }
    }
}
