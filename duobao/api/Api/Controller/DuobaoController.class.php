<?php

namespace Api\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8");
class DuobaoController extends Controller {
    //夺宝列表
    public function duobao() {
       $success=0;
       $message='夺宝活动获取失败';
       $type=$_GET['type'];
       if($type==0){
           $duobaos=M('Duobao')->where("status=0")->select();
           foreach ($duobaos as $k => $v) {
           $duobaos[$k]['good_pic']=IMG_ROOTPATH.$v['good_pic'];
           $success=1;
           $message='正在抢购中夺宝活动获取成功';
           
           }
       }else if($type==1){
           $duobaos=M('Duobao')->where("status=1")->select();
           foreach ($duobaos as $k1 => $v1) {
           $duobaos[$k1]['good_pic']=IMG_ROOTPATH.$v1['good_pic'];
           $success=1;
           $message='已结束夺宝活动获取成功';
           }
       }
       
       
      
          
       
       $json=array('success'=>$success,'message'=>$message,'duobaos'=>$duobaos);
       echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
    }
    public function duobaodetail() {
        $success=0;
        $message='该项夺宝活动获取失败';
        $duobaoid=$_GET['id'];
        $duobao=M('Duobao')->where("id=$duobaoid")->find();
        $duobao['good_pic']=IMG_ROOTPATH.$duobao['good_pic'];
        if($duobao){
            $success=1;
            $message='该项夺宝活动获取成功';
            
        }
        $json=array('success'=>$success,'message'=>$message,'duobao'=>$duobao);
        echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
        
        
    }
    //参与夺宝 待完善(支付还未写)
    public function duobaojoin() {
        $success=0;
        $message='参与失败';
        $userid=$_GET['userid'];
        $duobaoid=$_GET['duobaoid'];
        
        $duobao=M('Duobao')->where("id=$duobaoid")->find();
        if($duobao['status']==1){
            $message='该夺宝活动已结束，无法参与';
        }else {
            $string='DB';
            $member=M('Member')->where("id=$userid")->field('nickname')->find();
            $map['order_no']=$string.substr(time(), 7).rand(1000,9999);
            $map['order_name']=$duobao['good_name'].$duobao['good_no'].$member['nickname'];
            $map['user_id']=$_GET['userid'];
            $map['duobao_id']=$_GET['duobaoid'];
            $map['buy_num']=$_POST['num'];
            //支付方式0余额1微信2支付宝
            $map['type']=$_POST['type'];
            for($i=0;$i<$map['buy_num'];$i++){
                $luckynum[]=substr(time(), 6).rand(1000,9999);
            }
            $map['lucky_number']= implode(",", $luckynum);
            $map['money']=$map['buy_num']*$duobao['perprice'];
            $map['status']=0;
            $map['addtime']=time();
            $res=M('Order')->add($map);
            //付款成功后执行下面操作 会员参与明细添加一条数据，更新夺宝活动剩余参与人次
            //余额支付
            if($_POST['type']==0){
                //增加一条余额流水并且更新会员余额信息
                M('Order')->where("id=$res")->setField('status',1);
                $map2['user_id']=$_GET['userid'];
                $map2['type']=1;
                $map2['changenum']=$map['money'];
                $member=M('Member')->where("id=$userid")->field('balance')->find();
                $map2['userbalance']=$member['balance']-$map2['changenum'];
                $res22=M('Member')->where('id=$userid')->save(array('balance'=>$map2['userbalance']));

                $map2['addtime']=time();
                $res2=M('Balancelog')->add($map2);
                //增加一条用户参与明细并更新该夺宝活动的参与人次及剩余参与人次信息
                $map1['good_id']=$duobao['good_id'];
                $map1['good_no']=$duobao['good_no'];
                $map1['buy_count']=$_POST['num'];
                $map1['lucky_number']=implode(",", $luckynum);
                $map1['user_id']=$_GET['userid'];
                $map1['jointime']=time();
                $res1=M('Joindetail')->add($map1);
                $map3['joinnumber']=$duobao['joinnumber']+$map1['buy_count'];
                $map3['surplusnumber']=$duobao['surplusnumber']-$map1['buy_count'];
                $res3=M('Duobao')->where("id=$duobaoid")->save($map3);
                if($res2 && $res22){
                    if($res1 && $res3){
                        $success=1;
                        $message='参与成功';
                    }
                
                }
            }else if($_POST['type']==2){
                //支付宝支付
                //付款完成后执行以下操作
                M('Order')->where("id=$res")->setField('status',1);
                //增加一条用户参与明细并更新该夺宝活动的参与人次及剩余参与人次信息
                $map1['good_id']=$duobao['good_id'];
                $map1['good_no']=$duobao['good_no'];
                $map1['buy_count']=$_POST['num'];
                $map1['lucky_number']=implode(",", $luckynum);
                $map1['user_id']=$_GET['userid'];
                $map1['jointime']=time();
                $res1=M('Joindetail')->add($map1);
                $map3['joinnumber']=$duobao['joinnumber']+$map1['buy_count'];
                $map3['surplusnumber']=$duobao['surplusnumber']-$map1['buy_count'];
                $res3=M('Duobao')->where("id=$duobaoid")->save($map3);
                if($res1 && $res3){
                    $success=1;
                    $message='参与成功';
                }
            }
        
        }
            
        $json=array('success'=>$success,'message'=>$message);
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        
    }
    //往期揭晓
    public function pastshow() {
        $success=0;
        $message='没查询到该商品的往期开奖信息';
        $duobaoid=$_GET['id'];
        $nowduobao=M('Duobao')->where("id=$duobaoid")->field('good_id,good_name,good_no,good_pic,endtime,status')->find();
        $goodid=$nowduobao['good_id'];
        
        //var_dump($nowduobao);exit;
        if($nowduobao['status']==0){
            $good=M('Good')->where("id=$goodid")->field('good_price')->find();
            $nowduobao['price']=$good['good_price'];
            
            //$nowduobao['time']=timeconvert($nowduobao['endtime']-time());
            $nowduobao['good_pic']=IMG_ROOTPATH.$nowduobao['good_pic'];
            
            $duobaos=M('Duobao')->where(array('good_id'=>$goodid,'status'=>1))->field('good_id,good_no,good_pic,winnumber')->select();
            if($duobaos){
                foreach ($duobaos as $k => $v) {
                    $winnumber=$v['winnumber'];
                    $win=M('Winlog')->where("winnumber=$winnumber")->field('user_id,wintime')->find();
                    $userid=$win['user_id'];
                    $member=M('Member')->where("id=$userid")->field('mobile,headimg')->find();
                   
                    $map[$k]['good_pic']=IMG_ROOTPATH.$v['good_pic'];
                    $map[$k]['winnumber']=$v['winnumber'];
                    $map[$k]['wintime']= date("Y-m-d H:i", $win['wintime']);
                    $map[$k]['headimg']=IMG_ROOTPATH.$member['headimg'];
                    $map[$k]['mobile']=$member['mobile'];
                    $goodid=$v['good_id'];
                    $goodno=$v['good_no'];
                    
                    $counts=M('Joindetail')->where(array('good_id'=>$goodid,'good_no'=>$goodno,'user_id'=>$userid))->field('buy_count')->select();
                    //var_dump($counts);exit;
                    $count=0;
                    foreach ($counts as $v1) {
                        $count+=$v1['buy_count'];
                        
                    }
                    $map[$k]['count']=$count;
                
                }
                $success=1;
                $message='已获取该商品的往期开奖信息';
                $json=array('success'=>$success,'message'=>$message,'nowduobao'=>$nowduobao,'pastshow'=>$map);
                echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
               
                
            }else{
                $success=1;
                $message='未获取该商品的往期揭晓信息';
                $json=array('success'=>$success,'message'=>$message,'nowduobao'=>$nowduobao);
                echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
            }
            
            
            
        }else{
            $duobaos=M('Duobao')->where(array('good_id'=>$goodid,'status'=>1))->field('good_id,good_no,good_pic,winnumber')->select();
            
            if($duobaos){
                foreach ($duobaos as $k => $v) {
                    $winnumber=$v['winnumber'];
                    $win=M('Winlog')->where("winnumber=$winnumber")->field('user_id,wintime')->find();
                    $userid=$win['user_id'];
                    $member=M('Member')->where("id=$userid")->field('mobile,headimg')->find();
                   
                    $map[$k]['good_pic']=IMG_ROOTPATH.$v['good_pic'];
                    $map[$k]['winnumber']=$v['winnumber'];
                    $map[$k]['wintime']= date("Y-m-d H:i", $win['wintime']);
                    $map[$k]['headimg']=IMG_ROOTPATH.$member['headimg'];
                    $map[$k]['mobile']=$member['mobile'];
                    $map[$k]['good_no']=$v['good_no'];
                    $goodid=$v['good_id'];
                    $goodno=$v['good_no'];
                    
                    $counts=M('Joindetail')->where(array('good_id'=>$goodid,'good_no'=>$goodno,'user_id'=>$userid))->field('buy_count')->select();
                    //var_dump($counts);exit;
                    $count=0;
                    foreach ($counts as $v1) {
                        $count+=$v1['buy_count'];
                        
                    }
                    $map[$k]['count']=$count;
                
                }
                $success=1;
                $message='已获取该商品的往期开奖信息';
                $json=array('success'=>$success,'message'=>$message,'pastshow'=>$map);
                echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
            }
            
        }
        
        
    }
    
    //晒单分享
    public function showwin() {
        $list=M('Showwin')->select();
        foreach ($list as $k => $v) {
            $list[$k]['addtime']=date("Y-m-d H:i",$v['addtime']);
            $list[$k]['good_pic']= IMG_ROOTPATH.$v['good_pic'] ;
            $userid=$v['user_id'];
            $member=M('Member')->where("id=$userid")->field('nickname,headimg')->find();
            $list[$k]['nickname']=$member['nickname'];
            $list[$k]['headimg']= IMG_ROOTPATH.$member['headimg']; 
            
        }
        //var_dump($list);
        echo str_replace("\\/", "/", json_encode($list,JSON_UNESCAPED_UNICODE));
    }
    
   
}

