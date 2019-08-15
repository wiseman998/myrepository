<?php
namespace Admin\Controller;
use Think\Controller;
class DuobaoscriptController extends Controller{
    //夺宝自动开奖
    public function autolottery() {
        $duobaos=M('Duobao')->where("status=0")->select();
        foreach ($duobaos as $k => $v) {
            //自动开奖条件 参与人次达到总需人次且剩余人次为0，当前时间还未到活动截止时间
            if($v['joinnumber']==$v['neednumber'] && $v['surplusnumber']==0 && $v['endtime']<=time()){
                $joins=M('Joindetail')->where(array('good_id'=>$v['good_id'],'good_no'=>$v['good_no']))->field('lucky_number')->select();
                foreach ($joins as $k1 => $v1) {
                    $numbers.=$v1['lucky_number'].',';
                    
                }
                //去除两边多余的逗号，获得参与本次夺宝活动生成的所有幸运码 
                $luckynumbers= explode(',', trim($numbers,','));
                $randnum= rand(0, $v['neednumber']-1);
                //通过一个0到所需夺宝人次的随机下标来生成中奖号码
                $winnumber=$luckynumbers[$randnum];
                if($winnumber){
                    $map['winnumber']=$winnumber;
                    $map['status']=1;
                    //把中奖号码添加到本次夺宝活动的字段中，并更改本夺宝活动状态为已结束
                    $res=M('Duobao')->where(array('id'=>$v['id']))->save($map);
                    foreach ($joins as $v2) {
//                      //拿中奖号码跟参与本次夺宝活动的所有幸运码进行比对，找到中奖会员id
                        $luckynums= explode(',', $v2['lucky_number']);
                        if($winnumber==$v2['lucky_number'] || in_array($winnumber,  $luckynums)){
                            $winuserid=$v2['user_id'];
                        }
                    }
                    $map1['good_id']=$v['good_id'];
                    $map1['good_no']=$v['good_no'];
                    $map1['user_id']=$winuserid;
                    $map1['wintime']=time();
                    $map1['winnumber']=$winnumber;
                    $map1['status']=1;
                    //添加一条中奖记录
                    $res1=M('Winlog')->add($map1);
                    if($res && $res1){
                        $this->success('本期夺宝活动开奖成功');
                    }
                }else{
                    $this->error('开奖失败');
                }
                
            }
        }
    }
    //梦想基金自动开奖
    public function autolottery1() {
        $funds=M('Dreamfund')->where("status=0")->select();
        foreach ($funds as $k => $v) {
            //自动开奖条件 参与人次达到总需人次且剩余人次为0，当前时间还未到活动截止时间
            if($v['joinnumber']==$v['neednumber'] && $v['surplusnumber']==0 && $v['endtime']<=time()){
                $joins=M('Fundjoindetail')->where(array('fund_id'=>$v['id']))->field('lucky_number')->select();
                foreach ($joins as $k1 => $v1) {
                    $numbers.=$v1['lucky_number'].',';
                    
                }
                //去除两边多余的逗号，获得参与本次夺宝活动生成的所有幸运码
                $luckynumbers= explode(',', trim($numbers,','));
                $randnum= rand(0, $v['neednumber']-1);
                //通过一个0到所需夺宝人次的随机下标来生成中奖号码
                $winnumber=$luckynumbers[$randnum];
                if($winnumber){
                    $map['winnumber']=$winnumber;
                    $map['status']=1;
                    //把中奖号码添加到本次夺宝活动的字段中，并更改本夺宝活动状态为已结束
                    $res=M('Dreamfund')->where(array('id'=>$v['id']))->save($map);
                    foreach ($joins as $v2) {
//                      //拿中奖号码跟参与本次夺宝活动的所有幸运码进行比对，找到中奖会员id
                        $luckynums= explode(',', $v2['lucky_number']);
                        if($winnumber==$v2['lucky_number'] || in_array($winnumber,  $luckynums)){
                            $winuserid=$v2['user_id'];
                        }
                    }
                    $map1['fund_id']=$v['id'];
                   
                    $map1['user_id']=$winuserid;
                    $map1['wintime']=time();
                    $map1['winnumber']=$winnumber;
                    $map1['status']=1;
                    //添加一条中奖记录
                    $res1=M('Fundwinlog')->add($map1);
                    if($res && $res1){
                        $this->success('本期梦想基金开奖成功');
                    }
                }else{
                    $this->error('开奖失败');
                }
                
            }
        }
    }
    //自动检测返佣，但会先通知会员，APP上领取才会给其会员账户真实返佣
//    public function autoreturnmoney() {
//        $string='yydb';
//        $members=M('Member')->where("is_vip=1")->select();
//        foreach ($members as $k => $v) {
//            //推广的一级个数
//            $onecount=0;
//            $onecommission=0;
//            //推广的二级个数
//            $twocount=0;
//            $twocommission=0;
//            //推广的会员必须是VIP付费会员才会返佣
//            $onelevels=M('Member')->where(array('parentid'=>$string.$v['id'],'is_vip'=>1))->select();
//           
//           foreach ($onelevels as $k1 => $v1) {
//               //当前时间2小时以内的新推广付费会员才会计数实现返佣
//               if($v1['vip_addtime']>time()-7200){
//                   
//                   $onecount=$onecount+1;
//               }
//           }
//           $onereturn=M('Returnmoneyset')->where("id=1")->field('one_level')->find();
//           //一级返佣金额
//           $onecommission=$onecount*$onereturn['one_level'];
//            //推广的会员必须是VIP付费会员才会返佣
//           $twolevels=M('Member')->where(array('pparentid'=>$string.$v['id'],'is_vip'=>1))->select();
//           foreach ($twolevels as $k2 => $v2) {
//               if($v2['vip_addtime']>time()-7200){
//                   
//                   $twocount=$twocount+1;
//               }
//           }
//           
//           $tworeturn=M('Returnmoneyset')->where("id=1")->field('two_level')->find();
//           //二级返佣金额
//           $twocommission=$twocount*$tworeturn['two_level'];
//           //总返佣收入
//           $members[$v['id']]['income']=$onecommission+$twocommission;
//        }
//    }
    public function checkvip() {
        //建议执行间隔时间为一天
        $members=M('Member')->where("is_vip=1")->select();
        foreach ($members as $k=> $v) {
            if($v['vip_datetime']<time()){
                $map['is_vip']=0;
                $map['vip_addtime']=0;
                $map['vip_datetime']=0;
                $res=M('Member')->where("id=$k")->save($map);
                if($res){
                    $this->success('会员VIP状态更新成功');
                }
            }
        }
        exit;
    }
}


