<?php
namespace Admin\Controller;
use Think\Controller;
class DreamfundController extends Controller {
    public function index(){
        $mod=M("Dreamfund");
        $list=$mod->select();

        $a=array("抢购中","已结束");
        $this->assign("list",$list);
        $this->assign("a",$a);
               
        $this->display();
    }
    public function joindetail(){
        $mod=M("Fundjoindetail");
        $list=$mod->select();
        foreach ($list as $k=>$v) {
            $fundid=$v['fund_id'];
            $userid=$v['user_id'];
            $fund=M("Dreamfund")->where("id=$fundid")->find();
            $user=M("Member")->where("id=$userid")->find();
            $list[$k]['fundname']=$fund['fund_name'];
            $list[$k]['membername']=$user['nickname'];
        }
        $this->assign("list",$list);

        $this->display();
    }
    public function add(){
        if($_POST){
            if($_FILES['fund_pic']['name']){
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
                $map['fund_pic']="/Public/Uploads/".$savepath.$savename;
                unlink($unlink);
            }
            unset($_POST['unlink']);    
            
            $map['perprice']=$_POST['perprice'];
            $map['fund_name']=$_POST['fund_name'];
            
            $map['neednumber']=$_POST['neednumber'];
            $map['joinnumber']=0;
            $map['surplusnumber']=$map['neednumber'];
            $map['starttime']= strtotime($_POST['starttime']);
            $map['endtime']= strtotime($_POST['endtime']);
            $map['status']=$_POST['status'];
            //var_dump($map);exit;
            if($map['starttime']< time() ||$map['endtime']< time()){
                echo 1;exit;
                //$this->error('请选择正确的开始时间或截止时间');
            }else if($map['endtime']<$map['starttime']){
                echo 2;exit;
                //$this->error('截止时间不能在开始时间之前哦！');
            } 
            if($map['status']==1){
                echo 3;exit;
                //$this->error('刚添加的夺宝活动难道就已经结束了吗？');
            }

            $res=M("Dreamfund")->add($map);
            if($res){
                echo 4;
                //$this->success('夺宝活动添加成功！');
            }else{
                echo 5;
                //$this-error('夺宝活动添加失败！');
            }

        }else{
            $this->display();
        }
           
    }
	
    public function edit(){

        if($_GET['eid']){
            $id=$_GET['eid'];
            $list=M("Dreamfund")->where("id=$id")->find();
            $this->assign("list",$list);
            $this->display();
        }

    }
    function delete(){
        $id=$_POST['id'];
        if($id){
            M("Dreamfund")->where("id=$id")->delete($id);
            echo 1;
        }
    }
    public function update(){
        $id=$_POST['id'];

        $map['perprice']=$_POST['perprice'];

        M("Dreamfund")->where("id=$id")->save($map);
        $this->success("修改成功","",3);


    }
    //手动开奖
    public function handstart() {
        if(IS_POST){
            $id=$_POST['id'];
            $winmemberid=$_POST['user_id'];
            $fund=M('Dreamfund')->where("id=$id")->find();
            if($fund['status']==0 && $fund['surplusnumber']!=0){
                for($i=0;$i<$fund['surplusnumber'];$i++){
                    $luckynum[]=substr(time(), 6).rand(1000,9999);
                }
                   
                while (count($luckynum)>0) {
                    if(count($luckynum)>=10){
                        $luckynumber1= array_splice($luckynum, 0,10 );
                        $luckynumber= implode(',', $luckynumber1);
                        
                        $map['fund_id']=$id;
                        $map['buy_count']=10;
                        $map['lucky_number']=$luckynumber;
                        $map['user_id']=7;
                        $map['jointime']=time();
                        $res=M('Fundjoindetail')->add($map);
                    }else {

                        $map['fund_id']=$id;
                        $count=count($luckynum);
                        $map['buy_count']=$count;
                        $luckynumber= implode(',', $luckynum);
                        $map['lucky_number']=$luckynumber;
                        $map['user_id']=7;
                        $map['jointime']=time();
                        $res=M('Fundjoindetail')->add($map);
                        $luckynum=array();
                    }
                
               }
                  $joins=M('Fundjoindetail')->where(array('fund_id'=>$id,'user_id'=>$winmemberid))->select();
                  foreach ($joins as $k1 => $v1) {
                      $numbers.=$v1['lucky_number'].',';
                  }
                  $luckynumbers= explode(',', trim($numbers,','));
                  $i= rand(0, count($luckynumbers)-1);
                  $winnumber=$luckynumbers[$i];
//                $joins=M('Fundjoindetail')->where("fund_id=$id")->select();
//                foreach ($joins as $k1 => $v1) {
//                    $numbers.=$v1['lucky_number'].',';
//
//                }
//                //去除两边多余的逗号，获得参与本次夺宝活动生成的所有幸运码
//                $luckynumbers= explode(',', trim($numbers,','));
//                $randnum= rand(0, $fund['neednumber']-1);
//                //通过一个0到所需夺宝人次的随机下标来生成中奖号码
//                $winnumber=$luckynumbers[$randnum];
                if($winnumber){
                    $map2['joinnumber']=$fund['neednumber'];
                    $map2['surplusnumber']=0;
                    $map2['winnumber']=$winnumber;
                    $map2['status']=1;
                    //把中奖号码添加到本次夺宝活动的字段中，并更改本夺宝活动状态为已结束
                    $res=M('Dreamfund')->where("id=$id")->save($map2);
//                    foreach ($joins as $v2) {
////                      //拿中奖号码跟参与本次夺宝活动的所有幸运码进行比对，找到中奖会员id
//                        $luckynums= explode(',', $v2['lucky_number']);
//                        if($winnumber==$v2['lucky_number'] || in_array($winnumber, $luckynums)){
//                            $winuserid=$v2['user_id'];
//                        }
//                    }
                    $map1['fund_id']=$id;
                    
                    $map1['user_id']=$winmemberid;
                    $map1['wintime']=time();
                    $map1['winnumber']=$winnumber;
                    $map1['status']=1;
                    //var_dump($map1);exit;
                    //添加一条中奖记录
                    $res1=M('Fundwinlog')->add($map1);
                    if($res && $res1){
                        echo 1;exit;
                        //$this->success('本期夺宝活动开奖成功');
                    }
                }else{
                    echo 2;exit;
                    //$this->error('开奖失败');
                }
                }else{
                    echo 0;exit;
                }
        }else{
            $id=$_GET['id'];
            $list=M("Dreamfund")->where("id=$id")->find();
          
            $joinmemberids=M('Fundjoindetail')->where(array('fund_id'=>$id))->field('user_id')->select();
            foreach ($joinmemberids as $k => $v) {
                $membername=M('Member')->where(array('id'=>$v['user_id']))->field('nickname')->find();
                $joinmembers[$k]['id']=$v['user_id'];
                $joinmembers[$k]['nickname']=$membername['nickname'];
            }
            $this->assign("list",$list);
            $this->assign('joinmembers',$joinmembers);
            $this->display();
        }
            
   }
       
}