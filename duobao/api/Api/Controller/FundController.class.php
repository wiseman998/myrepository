<?php

namespace Api\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8");
class FundController extends Controller {
    //梦想基金列表
    public function fund() {
       $success=0;
       $message='梦想基金获取失败';
       $type=$_GET['type'];
       if($type==0){
           $funds=M('Dreamfund')->where("status=0")->select();
           foreach ($funds as $k => $v) {
           $funds[$k]['fund_pic']=IMG_ROOTPATH.$v['fund_pic'];
            $success=1;
           $message='正在抢购中梦想基金获取成功';
           
           }
       }else if($type==1){
           $funds=M('Dreamfund')->where("status=1")->select();
           foreach ($funds as $k1 => $v1) {
           $funds[$k1]['fund_pic']=IMG_ROOTPATH.$v1['fund_pic'];
           $success=1;
           $message='已结束梦想基金获取成功';
           }
       }
       
       
      
          
       
       $json=array('success'=>$success,'message'=>$message,'funds'=>$funds);
       echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
    }
    public function funddetail() {
        $success=0;
        $message='该项梦想基金获取失败';
        $fundid=$_GET['id'];
        $fund=M('Dreamfund')->where("id=$fundid")->find();
        $fund['fund_pic']=IMG_ROOTPATH.$fund['fund_pic'];
        if($fund){
            $success=1;
            $message='该项梦想基金获取成功';
            
        }
        $json=array('success'=>$success,'message'=>$message,'fund'=>$fund);
        echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
        
        
    }
    //参与夺宝 待完善(支付还未写)
    public function fundjoin() {
        $success=0;
        $message='参与失败';
        $userid=$_GET['userid'];
        $fundid=$_GET['fundid'];
        
        $fund=M('Dreamfund')->where("id=$fundid")->find();
        if($fund['status']==1){
            $message='该梦想基金已结束，无法参与';
        }else {
            $string='DF';
            $member=M('Member')->where("id=$userid")->field('nickname')->find();
            $map['order_no']=$string.substr(time(), 7).rand(1000,9999);
            $map['order_name']=$fund['fund_name'].$member['nickname'];
            $map['user_id']=$_GET['userid'];
            $map['duobao_id']=$_GET['fundid'];
            $map['buy_num']=$_POST['num'];
            //支付方式0余额1微信2支付宝
            $map['type']=$_POST['type'];
            for($i=0;$i<$map['buy_num'];$i++){
                $luckynum[]=substr(time(), 6).rand(1000,9999);
            }
            $map['lucky_number']= implode(",", $luckynum);
            $map['money']=$map['buy_num']*$fund['perprice'];
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
                $map1['fund_id']=$fundid;
                
                $map1['buy_count']=$_POST['num'];
                $map1['lucky_number']=implode(",", $luckynum);
                $map1['user_id']=$_GET['userid'];
                $map1['jointime']=time();
                $res1=M('Fundjoindetail')->add($map1);
                $map3['joinnumber']=$fund['joinnumber']+$map1['buy_count'];
                $map3['surplusnumber']=$fund['surplusnumber']-$map1['buy_count'];
                $res3=M('Dreamfund')->where("id=$fundid")->save($map3);
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
                $map1['fund_id']=$fund['id'];
               
                $map1['buy_count']=$_POST['num'];
                $map1['lucky_number']=implode(",", $luckynum);
                $map1['user_id']=$_GET['userid'];
                $map1['jointime']=time();
                $res1=M('Fundjoindetail')->add($map1);
                $map3['joinnumber']=$fund['joinnumber']+$map1['buy_count'];
                $map3['surplusnumber']=$fund['surplusnumber']-$map1['buy_count'];
                $res3=M('Dreamfund')->where("id=$fundid")->save($map3);
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
        $message='没查询到该梦想基金的往期开奖信息';
        $fundid=$_GET['id'];
        $nowfund=M('Dreamfund')->where("id=$fundid")->field('id,fund_name,fund_pic,endtime,summoney,status')->find();
        //$goodid=$nowduobao['good_id'];
        
        //var_dump($nowduobao);exit;
        if($nowfund['status']==0){
           
            //$nowduobao['time']=timeconvert($nowduobao['endtime']-time());
            $nowfund['fund_pic']=IMG_ROOTPATH.$nowfund['fund_pic'];
            
            $funds=M('Dreamfund')->where(array('status'=>1))->field('id,fund_pic,winnumber')->select();
            if($funds){
                foreach ($funds as $k => $v) {
                    $winnumber=$v['winnumber'];
                    $win=M('Fundwinlog')->where("winnumber=$winnumber")->field('user_id,wintime')->find();
                    $userid=$win['user_id'];
                    $member=M('Member')->where("id=$userid")->field('mobile,headimg')->find();
                   
                    $map[$k]['fund_pic']=IMG_ROOTPATH.$v['fund_pic'];
                    $map[$k]['winnumber']=$v['winnumber'];
                    $map[$k]['wintime']= date("Y-m-d H:i", $win['wintime']);
                    $map[$k]['headimg']=IMG_ROOTPATH.$member['headimg'];
                    $map[$k]['mobile']=$member['mobile'];
                    $fundid=$v['id'];
                   
                    
                    $counts=M('Fundjoindetail')->where(array('fund_id'=>$fundid,'user_id'=>$userid))->field('buy_count')->select();
                    //var_dump($counts);exit;
                    $count=0;
                    foreach ($counts as $v1) {
                        $count+=$v1['buy_count'];
                        
                    }
                    $map[$k]['count']=$count;
                
                }
                $success=1;
                $message='已获取该梦想基金的往期开奖信息';
                $json=array('success'=>$success,'message'=>$message,'nowfund'=>$nowfund,'pastshow'=>$map);
                echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
               
                
            }else{
                $success=1;
                $message='未获取该梦想基金的往期开奖信息';
                $json=array('success'=>$success,'message'=>$message,'nowfund'=>$nowfund);
                echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
            }
            
            
            
        }else{
            $funds=M('Dreamfund')->where(array('status'=>1))->field('id,fund_pic,winnumber')->select();
            if($funds){
                foreach ($funds as $k => $v) {
                    $winnumber=$v['winnumber'];
                    $win=M('Fundwinlog')->where("winnumber=$winnumber")->field('user_id,wintime')->find();
                    $userid=$win['user_id'];
                    $member=M('Member')->where("id=$userid")->field('mobile,headimg')->find();
                   
                    $map[$k]['fund_pic']=IMG_ROOTPATH.$v['fund_pic'];
                    $map[$k]['winnumber']=$v['winnumber'];
                    $map[$k]['wintime']= date("Y-m-d H:i", $win['wintime']);
                    $map[$k]['headimg']=IMG_ROOTPATH.$member['headimg'];
                    $map[$k]['mobile']=$member['mobile'];
                    $fundid=$v['id'];
                   
                    
                    $counts=M('Fundjoindetail')->where(array('fund_id'=>$fundid,'user_id'=>$userid))->field('buy_count')->select();
                    //var_dump($counts);exit;
                    $count=0;
                    foreach ($counts as $v1) {
                        $count+=$v1['buy_count'];
                        
                    }
                    $map[$k]['count']=$count;
                
                }
                $success=1;
                $message='已获取该梦想基金的往期开奖信息';
                $json=array('success'=>$success,'message'=>$message,'pastshow'=>$map);
                echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
            }else{
                $success=1;
                $message='未获取该梦想基金的往期开奖信息';
                $json=array('success'=>$success,'message'=>$message);
                echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
            }
            
        }
        
        
    }
    
    //晒单分享
    public function showwin() {
        $list=M('Fundshowwin')->select();
        foreach ($list as $k => $v) {
            $list[$k]['addtime']=date("Y-m-d H:i",$v['addtime']);
            $list[$k]['fund_pic']= IMG_ROOTPATH.$v['fund_pic'] ;
            $userid=$v['user_id'];
            $member=M('Member')->where("id=$userid")->field('nickname,headimg')->find();
            $list[$k]['nickname']=$member['nickname'];
            $list[$k]['headimg']= IMG_ROOTPATH.$member['headimg']; 
            
        }
        //var_dump($list);
        echo str_replace("\\/", "/", json_encode($list,JSON_UNESCAPED_UNICODE));
    }
    
   
}

