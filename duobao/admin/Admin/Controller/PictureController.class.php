<?php
namespace Admin\Controller;
use Think\Controller;
class PictureController extends Controller {
    public function index() {
        $onetime=M('Member')->min('addtime');
        $firsttime=date('m-d',$onetime);
        $nowtime=time();
        $dayss=($nowtime-$onetime)/86400;
        for($i=0;$i<=$dayss+1;$i++){
            $days[]= date('m-d', $onetime+$i*86400);
        }
        //历史注册用户数以天为单位
        $times=M('Member')->field('addtime')->select();
        foreach ($times as $k => $v) {
            $dayaddtime= date('m-d', $v['addtime']);
            if(in_array($dayaddtime, $days)){
                $user[$dayaddtime]+=1;
            }
        }
        for($i=0;$i<=$dayss;$i++){
            if(empty($user[$days[$i]])){
                $user[$days[$i]]=0;
            }
        }
        $res1=ksort($user);
       
        //历史加入会员数以天为单位
        $membertimes=M('Member')->field('vip_addtime')->select();
        foreach ($membertimes as $k1 => $v1) {
            $memberaddtime=date('m-d',$v1['vip_addtime']);
            if(in_array($memberaddtime, $days)){
                $member[$memberaddtime]+=1;
            }
        }
        for($j=0;$j<=$dayss;$j++){
            if(empty($member[$days[$j]])){
                $member[$days[$j]]=0;
            }
        }
        $res2= ksort($member);
        
        //var_dump($member);
        //历史充值金额以天为单位
        $rechargetimes=M('Balancelog')->where("type=0")->field('changenum,addtime')->select();
        foreach ($rechargetimes as $k2 => $v2) {
            $rechargetime=date('m-d',$v2['addtime']);
            if(in_array($rechargetime, $days)){
                $rechargemoney[$rechargetime]+=$v2['changenum'];
            }
        }
        for($q=0;$q<=$dayss;$q++){
            if(empty($rechargemoney[$days[$q]])){
                $rechargemoney[$days[$q]]=0;
            }
        }
       
        //历史加入会员金额以天为单位
        $price=M('Memrankset')->where("id=2")->field('price')->find();
        
        for($m=0;$m<=$dayss;$m++){
            $vipmoney[$days[$m]]=$member[$days[$m]]*$price['price'];
        }
       //历史参与（夺宝、梦想基金）金额以天为单位
        $joins=M('Order')->where(array('status'=>1,'type'=>2))->field('money,addtime')->select();
        foreach ($joins as $k3 => $v3) {
            $jointime=date('m-d',$v3['addtime']);
            if(in_array($jointime, $days)){
                $joinmoneys[$jointime]+=$v3['money'];
            }
        }
        for($n=0;$n<=$dayss;$n++){
            if(empty($joinmoneys[$days[$n]])){
                $joinmoneys[$days[$n]]=0;
            }
        }
        
        //历史付费金额以天为单位
        for($p=0;$p<=$dayss;$p++){
            $moneys[$days[$p]]=$vipmoney[$days[$p]]+$rechargemoney[$days[$p]]+$joinmoneys[$days[$p]];
        }
        $res3= ksort($moneys);
       
        //今日注册用户数以小时为单位
        $todaytime=date('m-d',time());
        foreach ($times as $k4 => $v4) {
            $dayaddtime1=date('m-d',$v4['addtime']);
            if($dayaddtime1==$todaytime){
                $houraddtime[]= date('H', $v4['addtime']);
                
            }
            
        }
       
        $hours=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24);
        $len= count($houraddtime);
        for($i1=0;$i1<$len;$i1++){
            if(in_array($houraddtime[$i1], $hours)){
                $userhour[$houraddtime[$i1]]+=1;
            }
        }
        for($j1=1;$j1<=24;$j1++){
            if(empty($userhour[$j1])){
                $userhour[$j1]=0;
            }
        }
        
         //今日加入会员数以小时为单位
        foreach ($membertimes as $k5 => $v5) {
            $memberaddtime1= date('m-d', $v5['vip_addtime']);
            if($memberaddtime1==$todaytime){
                $hourmemaddtime[]=date('H',$v5['vip_addtime']);
                
            }
        }
        $len1=count($hourmemaddtime);
        for($m1=0;$m1<$len1;$m1++){
            if(in_array($hourmemaddtime[$m1], $hours)){
                $memberhour[$hourmemaddtime[$m1]]+=1;
            }
        }
        for($n1=1;$n1<=24;$n1++){
            if(empty($memberhour[$n1])){
                $memberhour[$n1]=0;
            }
        }
        //$res5= ksort($memberhour);
        //var_dump($memberhour);
        //今日充值金额以小时为单位
        $map['addtime']=array('gt',strtotime(date("Y-m-d"),time()));
        $rechargetimes1=M('Balancelog')->where("type=0")->where($map)->select();
        
        foreach ($rechargetimes1 as $k6 => $v6) {
            
            $hourrechargeaddtime= date('H', $v6['addtime']);
            if(in_array($hourrechargeaddtime, $hours)){
                $rechargehour[$hourrechargeaddtime]+=$v6['changenum'];
            }
            
        }
        
        
        //今日加入会员金额以小时为单位
        $map1['vip_addtime']=array('gt',strtotime(date("Y-m-d"),time()));
        $todaymember=M('Member')->where("is_vip=1")->where($map1)->select();
        foreach ($todaymember as $k7 => $v7) {
            $hourvipaddtime=date('H',$v7['vip_addtime']);
            if(in_array($hourvipaddtime, $hours)){
                $viphour[$hourvipaddtime]+=$price['price'];
            }
        }
        $todayjoin=M('Order')->where(array('status'=>1,'type'=>2))->where($map)->select();
        foreach ($todayjoin as $k8 => $v8) {
            $hourjoinaddtime=date('H',$v8['addtime']);
            if(in_array($hourjoinaddtime, $hours)){
                $joinhour[$hourjoinaddtime]+=$v8['money'];
            }
        }
        for($q1=1;$q1<=24;$q1++){
            if(empty($rechargehour[$q1])){
                $rechargehour[$q1]=0;
            }
            if(empty($viphour[$q1])){
                $viphour[$q1]=0;
            }
            if(empty($joinhour[$q1])){
                $joinhour[$q1]=0;
            }
        }
        for($a=1;$a<=24;$a++){
            $moneyhour[$a]=$rechargehour[$a]+$viphour[$a]+$joinhour[$a];
        }
       $res6= ksort($moneyhour);
       $arr1 = array();
       $arr2 = array();
       $arr3 = array();
       $arr4 = array();
       $arr5 = array();
       $arr6 = array();
       $i = 0;
       $j=0;
       $q=0;
       $m=0;
       $n=0;
       $s=0;
       foreach ($user as $k => $v) {
           $arr1[$i] = $k;
           $arr2[$i] = $v;
           $i++;
       }
       foreach ($member as $k => $v) {
          
           $arr3[$j] = $v;
           $j++;
       }
       foreach ($moneys as $k => $v) {
          
           $arr4[$q] = $v;
           $q++;
       }
       foreach ($userhour as $k => $v) {
           $arr5[$m] = $k;
           $arr6[$m] = $v;
           $m++;
       }
       foreach ($memberhour as $k => $v) {
          
           $arr7[$n] = $v;
           $n++;
       }
       foreach ($moneyhour as $k => $v) {
          
           $arr8[$s] = $v;
           $s++;
       }

        $re1= json_encode($arr1);
        $re2 = json_encode($arr2);
        $re3 = json_encode($arr3);
        $re4 = json_encode($arr4);
        $re5 = json_encode($arr5);
        $re6 = json_encode($arr6);
        $re7 = json_encode($arr7);
        $re8 = json_encode($arr8);
       
       $this->assign('arr1', $re1);
       $this->assign('arr2',$re2);
       
       $this->assign('arr3',$re3);
       $this->assign('arr4',$re4);
       $this->assign('arr5',$re5);
       $this->assign('arr6',$re6);
       $this->assign('arr7',$re7);
       $this->assign('arr8',$re8);

       $this->display();
    }


    //透明度
    public function add(){
        if($_POST){
            $list=M("Opacity")->select();
            if($list){
                M("Opacity")->where("id=1")->save($_POST);
                echo $_POST['opacity'];
            }else{
                M("Opacity")->add($_POST);
                echo $_POST['opacity'];
            }
        }else{
            $opacity=M("Opacity")->find();
            $this->assign("opacity",$opacity);
            $this->display();
        }

    }
   
    
}