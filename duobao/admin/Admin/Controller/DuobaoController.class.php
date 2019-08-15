<?php
namespace Admin\Controller;
use Think\Controller;
class DuobaoController extends Controller {
    public function index(){
        $mod=M("Duobao");
        $list=$mod->select();

        $a=array("抢购中","已结束");
        $this->assign("list",$list);
        $this->assign("a",$a);
               
        $this->display();
    }
    public function joindetail(){
        $mod=M("Joindetail");
        $list=$mod->select();
        foreach ($list as $k=>$v) {
            $goodid=$v['good_id'];
            $userid=$v['user_id'];
            $good=M("Good")->where("id=$goodid")->find();
            $user=M("Member")->where("id=$userid")->find();
            $list[$k]['goodname']=$good['good_name'];
            $list[$k]['membername']=$user['nickname'];
        }
        $this->assign("list",$list);

        $this->display();
    }
    public function add(){
        if($_POST){
                
            $goodid=$_POST['good_id'];
            $check=M("Duobao")->where(array('good_id'=>$goodid,'good_no'=>$_POST['good_no']))->select();
            if($check){
                echo 0;exit;
                //$this->error("该商品该期数下的夺宝活动已存在，请勿重复添加！");
            }
            $good=M("Good")->where("id=$goodid")->find();
            $map['good_id']=$_POST['good_id'];
            $map['good_no']=$_POST['good_no'];
            $map['perprice']=$_POST['perprice'];
            $map['good_name']=$good['good_name'];
            $map['good_pic']=$good['good_pic'];
            $map['neednumber']=$good['neednumber'];
            $map['joinnumber']=0;
            $map['surplusnumber']=$good['neednumber'];
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

            $res=M("Duobao")->add($map);
            if($res){
                echo 4;
                //$this->success('夺宝活动添加成功！');
            }else{
                echo 5;
                //$this-error('夺宝活动添加失败！');
            }

        }else{
            $goods=M("Good")->select();
           
            $this->assign("goods", $goods);
            $this->display();
       }
           
    }
	
    public function edit(){

        if($_GET['eid']){
            $id=$_GET['eid'];
            $list=M("Duobao")->where("id=$id")->find();
            $this->assign("list",$list);
            $this->display();
        }

    }
    function delete(){
        $id=$_POST['id'];
        if($id){
            M("Duobao")->where("id=$id")->delete($id);
            echo 1;
        }
    }
    public function update(){
        $id=$_POST['id'];

        $map['perprice']=$_POST['perprice'];

        M("Duobao")->where("id=$id")->save($map);
        $this->success("修改成功","",3);


    }
    //手动开奖
    public function handstart() {
        if(IS_POST){
            $id=$_POST['id'];
            $winmemberid=$_POST['user_id'];
            $duobao=M('Duobao')->where("id=$id")->find();
            if($duobao['status']==0 && $duobao['surplusnumber']!=0){
                for($i=0;$i<$duobao['surplusnumber'];$i++){
                    $luckynum[]=substr(time(), 6).rand(1000,9999);
                }
                   
                while (count($luckynum)>0) {
                    if(count($luckynum)>=10){
                        $luckynumber1= array_splice($luckynum, 0,10 );
                        $luckynumber= implode(',', $luckynumber1);
                        $map['good_id']=$duobao['good_id'];
                        $map['good_no']=$duobao['good_no'];
                        $map['buy_count']=10;
                        $map['lucky_number']=$luckynumber;
                        $map['user_id']=7;
                        $map['jointime']=time();
                        $res=M('Joindetail')->add($map);
                    }else {

                        $map['good_id']=$duobao['good_id'];
                        $map['good_no']=$duobao['good_no'];
                        $count=count($luckynum);
                        $map['buy_count']=$count;
                        $luckynumber= implode(',', $luckynum);
                        $map['lucky_number']=$luckynumber;
                        $map['user_id']=7;
                        $map['jointime']=time();
                        $res=M('Joindetail')->add($map);
                        $luckynum=array();
                    }
                
               }
               $joins=M('Joindetail')->where(array('good_id'=>$duobao['good_id'],'good_no'=>$duobao['good_no'],'user_id'=>$winmemberid))->select();
               foreach ($joins as $k1 => $v1) {
                   $numbers.=$v1['lucky_number'].',';
               }
               $luckynumbers= explode(',', trim($numbers,','));
               $i= rand(0, count($luckynumbers)-1);
               $winnumber=$luckynumbers[$i];
                   
//                $joins=M('Joindetail')->where(array('good_id'=>$duobao['good_id'],'good_no'=>$duobao['good_no']))->select();
//                foreach ($joins as $k1 => $v1) {
//                    $numbers.=$v1['lucky_number'].',';
//
//                }
//                //去除两边多余的逗号，获得参与本次夺宝活动生成的所有幸运码
//                $luckynumbers= explode(',', trim($numbers,','));
//                $randnum= rand(0, $duobao['neednumber']-1);
//                //通过一个0到所需夺宝人次的随机下标来生成中奖号码
//                $winnumber=$luckynumbers[$randnum];
                if($winnumber){
                    $map2['joinnumber']=$duobao['neednumber'];
                    $map2['surplusnumber']=0;
                    $map2['winnumber']=$winnumber;
                    $map2['status']=1;
                    //把中奖号码添加到本次夺宝活动的字段中，并更改本夺宝活动状态为已结束
                    $res=M('Duobao')->where("id=$id")->save($map2);
//                    foreach ($joins as $v2) {
////                      //拿中奖号码跟参与本次夺宝活动的所有幸运码进行比对，找到中奖会员id
//                        $luckynums= explode(',', $v2['lucky_number']);
//                        if($winnumber==$v2['lucky_number'] || in_array($winnumber, $luckynums)){
//                            $winuserid=$v2['user_id'];
//                        }
//                    }
                    $map1['good_id']=$duobao['good_id'];
                    $map1['good_no']=$duobao['good_no'];
                    $map1['user_id']=$winmemberid;
                    $map1['wintime']=time();
                    $map1['winnumber']=$winnumber;
                    $map1['status']=1;
                    //var_dump($map1);exit;
                    //添加一条中奖记录
                    $res1=M('Winlog')->add($map1);
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
            $list=M("Duobao")->where("id=$id")->find();
            $goodid=$list['good_id'];
            $goodno=$list['good_no'];
            $joinmemberids=M('Joindetail')->where(array('good_id'=>$goodid,'good_no'=>$goodno))->field('user_id')->select();
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