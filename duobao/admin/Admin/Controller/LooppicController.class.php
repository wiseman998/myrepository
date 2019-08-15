<?php
namespace Admin\Controller;
use Think\Controller;
class LooppicController extends Controller {
    public function index(){
        $mod=M("Looppic");
        $list=$mod->select();

        $this->assign("list",$list);
        $this->display();
    }
        
    public function add(){
        $this->display();
    }
    public function  insert(){
        if($_FILES['pic']['name']){
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
            $map['pic']="/Public/Uploads/".$savepath.$savename;
            unlink($unlink);
        }
        unset($_POST['unlink']);

        $map['title']=$_POST['title'];
        $map['addtime']=time();
        $id=$_POST['id'];
        M("Looppic")->add($map);
        $this->success("添加成功");

    }
    public function edit(){
        $id=$_GET['eid'];
        $list=M("Looppic")->where("id=$id")->find();
        $this->assign("list",$list);
        $this->display();
    }
    function delete(){
        $id=$_POST['id'];

        $res=M("Looppic")->delete($id);
        if($res){
            echo 1;
        }else{
            echo 0;
        }

    }
    public function update(){
        if($_FILES['pic']['name']){
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
            $map['pic']="/Public/Uploads/".$savepath.$savename;
            unlink($unlink);
        }
        unset($_POST['unlink']);

        $map['title']=$_POST['title'];
        //var_dump($map);die;
        $id=$_GET['id'];
        M("Looppic")->where("id=$id")->save($map);
        $this->success("修改成功");


    }
       
}