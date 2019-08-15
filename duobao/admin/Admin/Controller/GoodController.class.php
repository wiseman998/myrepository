<?php
namespace Admin\Controller;
use Think\Controller;
class GoodController extends AllowController {
    public function index(){
        if($_GET){
                $id=$_GET['id'];
                $ta=M("Good")->where("id=$id")->find();
                $status=$ta['status'];
                if($status==1){
                        M("Good")->where("id=$id")->setField("status",0);
                        echo "上线";
                }else{
                        M("Good")->where("id=$id")->setField("status",1);
                        echo "下架";
                }
        }else{
                $list=M("Good")->select();
                $this->assign("list",$list);
                $this->display();
        }
    }
    public function add(){
            $this->display();
    }
    public function edit(){

        if(IS_POST){
            if($_FILES['good_pic']['name']){
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
                $_POST['good_pic']="/Public/Uploads/".$savepath.$savename;
                unlink($unlink);
            }
            unset($_POST['unlink']); 
            //var_dump($id);exit;
            if($_POST['good_price'] <= 0 || $_POST['neednumber'] <=0){
                echo 0;exit;
            }else if($_POST['neednumber']<$_POST['good_price']){
                echo 1;exit;
            }
            $id=$_POST['id'];
            $res=M('Good')->where("id=$id")->save($_POST);
            if($res){
                $this->success('修改成功', 'index');
            }

        }else {
            $id=$_GET['id'];
            $good=M("Good")->where("id=$id")->find();
            $this->assign("good",$good);
            $this->display();
        }

    }
	
	
    public function delete(){
        $id=$_GET['id'];
        if(M("Good")->delete($id)){
            echo 1;
        }

    }
    public function insert(){
        if($_FILES['good_pic']['name']){
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
            $_POST['good_pic']="/Public/Uploads/".$savepath.$savename;
            unlink($unlink);
        }
            unset($_POST['unlink']); 
            $_POST['addtime']=time();
            if($_POST['neednumber']<$_POST['good_price']){
                echo 1;exit;
            }
            if(M("Good")->add($_POST)){
                $this->success("商品添加成功");
            }else{
                $this->error("商品添加失败");
            }
    }
}