<?php

namespace Api\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8");
class MemberController extends Controller {
    
    //获取会员基本信息
    public function getmemberdetail() {
        $success='0';
        $message='参数错误';
        
        $id=$_GET['id'];
        $res=M('Member')->where("id=$id")->find();
        if($res){
            if($res['is_vip']){
            $success=1;
            $message='获取成功';
            $member=array('id'=>$res['id'],'headimg'=> stripslashes(IMG_ROOTPATH.$res['headimg']),'nickname'=> $res['nickname'],'recommendid'=>$res['recommendid'],'balance'=>$res['balance'],'commission'=>$res['commission'],'mark'=> 'VIP会员');
            
        }else{
            $success=1;
            $message='获取成功';
            $member=array('id'=>$res['id'],'headimg'=>stripslashes(IMG_ROOTPATH.$res['headimg']),'nickname'=>$res['nickname'],'recommendid'=>$res['recommendid'],'balance'=>$res['balance'],'commission'=>$res['commission'],'mark'=> '普通会员');
        }
        }else {
            $success=0;
            $message='获取失败';
        }
        $json = array('success' =>$success,'message' => $message,'member'=> $member);
       
        echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
    }
    //实名认证状态需后台管理员审核通过才可更改状态
    public function certification() {
        $success=0;
        $message='参数错误，认证失败';
        $userid=$_GET['id'];
       
        $map['realname']=$_GET['realname'];
        $map['mobile']=$_GET['mobile'];
        //var_dump($_GET);exit;
        if(!preg_match("/^1[34578]{1}\d{9}$/",$map['mobile'])){ 
            $message='手机号格式有误，请重新输入';
            $json=array('success'=>$success,'message'=>$message);
            echo json_encode($json,JSON_UNESCAPED_UNICODE);exit;
        }
        $verify=$_GET['verify'];
        $check=M('Verificationcode')->where(array('receiver'=>$map['mobile']))->find();
        $time=$check['createtime']+$check['expire_time'];
        $time1=time();

        if($verify!=$check['code']){
            $message='验证码错误，请重新输入';
            $json=array('success'=>$success,'message'=>$message);
            echo json_encode($json,JSON_UNESCAPED_UNICODE);exit;
        } else if($time< $time1){
            $message='验证码已过期';
            $json=array('success'=>$success,'message'=>$message);
            echo json_encode($json,JSON_UNESCAPED_UNICODE);exit;
        }
       
        $map['idcard']=$_GET['idcard'];
        $len=strlen($map['idcard']);
        if($len!=18 ){
            $message='身份证号有误，请重新输入';
            $json=array('success'=>$success,'message'=>$message);
            echo json_encode($json,JSON_UNESCAPED_UNICODE);exit;
        }
        //存放身份证正反面照片的路径
        $map['idcard_pic1']= substr($_GET['idcard_pic1'], 27);
        $map['idcard_pic2']= substr($_GET['idcard_pic2'], 27);
        if(empty($map['idcard_pic1'])||empty($map['idcard_pic2'])){
            $message='身份证正反面照片未上传，请再次确认！';
            $json=array('success'=>$success,'message'=>$message);
            echo json_encode($json,JSON_UNESCAPED_UNICODE);exit;
        }
        
        $res=M('Member')->where("id=$userid")->save($map);
        if($res){
            $success=1;
            $message='认证申请成功，待后台管理员审核';
        }
        $json=array('success'=>$success,'message'=>$message);
        echo json_encode($json,JSON_UNESCAPED_UNICODE);
    }
    //加入会员 待完善
    public function joinmember() {
        if(IS_POST){
            $string='HY';
            $userid=$_POST['id'];
            $ma['order_no']=$string.substr(time(), 7).rand(1000, 9999);
            $ma['order_name']='加入一元夺宝VIP会员';
            $ma['user_id']=$userid;
            $memberrank=M('Memberrankset')->where("id=2")->field('price')->find();
            $ma['money']=$memberrank['price'];
            $ma['type']=1;
            $ma['status']=0;
            $ma['addtime']=time();
            $res1=M('Payorder')->add($ma);
            //对接支付宝支付
            
            //支付成功，更改会员状态
            $success=0;
            $message='加入会员失败';
           
            $map['is_vip']=1;
            $map['vip_addtime']=time();
            $map['vip_datetime']=time()+86400*365;
            $res=M('Member')->where("id=$userid")->save($map);
            if($res){
                $success=1;
                $message='加入VIP会员成功';
                $member=M('Member')->where("id=$userid")->field('parentid,pparentid')->find();
                $commission=M('Returnmoneyset')->where("id=1")->field('one_level,two_level')->find();
                if($member['parentid']){
                    $id1= substr($member['parentid'],4);
                    $map['user_id']=$id1;
                    $map['news_name']='返佣消息';
                    $map['news_content']='您有一个新的返佣新消息，请注意查收，不要忘了只有点击领取佣金后才会真正转到你的账户中哦!';
                    $map['money']=$commission['one_level']*1;
                    $map['status']=0;
                    $map['addtime']=time();
                    $res=M('News')->add($map);
                }if($member['pparentid']){
                    $id2= substr($member['pparentid'],4);
                    $map['user_id']=$id2;
                    $map['news_name']='返佣消息';
                    $map['news_content']='您有一个新的返佣新消息，请注意查收，不要忘了只有点击领取佣金后才会真正转到你的账户中哦!';
                    $map['money']=$commission['two_level']*1;
                    $map['status']=0;
                    $map['addtime']=time();
                    $res=M('News')->add($map);
                }
            }
            $json=array('success'=>$success,'message'=>$message);
            echo json_encode($json,JSON_UNESCAPED_UNICODE);
        }else{
           //展示会员价格权益等信息
           $memrank= M('Memrankset')->where("id=2")->field('rankname,price,detail')->find();
           echo json_encode($memrank,JSON_UNESCAPED_UNICODE);
        }
    }
    //充值 待完善
    public function recharge() {
        $success=0;
        $message='充值失败';
        
        //充值成功
        $map['changenum']=$_POST['changenum'];
        if($map['changenum']<=0){
            $message='充值金额无效，请再次确认';
            $json = array('success' =>$success,'message' => $message);
            echo json_encode($json,JSON_UNESCAPED_UNICODE);exit;
        }
        $userid=$_POST['id'];
        $string='CZ';
        $ma['user_id']=$userid;
        $ma['order_no']=$string.substr(time(), 7).rand(1000, 9999);
        $ma['order_name']='余额充值';
        
        $ma['money']=$_POST['changenum'];
        $ma['type']=1;
        $ma['status']=0;
        $ma['addtime']=time();
        $re=M('Payorder')->add($ma);
		
        //支付成功后再做以下处理
        $map['user_id']=$userid;
        $map['type']=0;
        
        $res=M('Member')->where("id=$userid")->setInc('balance',$_POST['changenum']);
		$user=M('Member')->where("id=$userid")->field('balance')->find();
        $map['userbalance']=$user['balance'];
        $map['addtime']=time();
        $res1=M('Balancelog')->add($map);
		
        if($res &&$res1){
            $success=1;
            $message='充值成功';
        }
        $json = array('success' =>$success,'message' => $message);
       
        echo json_encode($json,JSON_UNESCAPED_UNICODE);
        
    }
    //提现 待完善
    public function withdraw() {
        if(IS_POST){
            $success=0;
            $message='提现失败';
            $userid=$_POST['id'];

            $user=M('Member')->where("id=$userid")->find();
            $map['user_id']=$_POST['id'];
            $map['user_headimg']=$user['headimg'];
            $map['user_phone']=$user['mobile'];
            $map['money']=$_POST['money'];
            if($map['money']<=0){
                $message='提现金额无效，请再次确认！';
                $json = array('success' =>$success,'message' => $message);

                echo json_encode($json,JSON_UNESCAPED_UNICODE);exit;
            }
            $map['type1']=$_POST['type1'];
            //余额提现
            if($map['type1']==0){
                if($user['balance']<$map['money']){
                    $message='余额不足，无法提现';
                    $json = array('success' =>$success,'message' => $message);

                    echo json_encode($json,JSON_UNESCAPED_UNICODE);exit;
                }
                //佣金提现
            }else if($map['type1']==1){
                if($user['commission']<$map['money']){
                    $message='佣金不足，无法提现';
                    $json = array('success' =>$success,'message' => $message);

                    echo json_encode($json,JSON_UNESCAPED_UNICODE);exit;
                }
            }
            $fee=M('System')->where("id=1")->field('fee')->find();
            $map['fee']=$map['money']*$fee['fee'];
            $map['realmoney']=$map['money']-$map['fee'];
            //0微信1支付宝
            $map['type2']=$_POST['type2'];
            $map['status']=0;
            $map['applytime']=time();
            $res=M('Withdrawlog')->add($map);
            if($res){
                $success=1;
                $message='提现申请成功';

            }else{
                $message='参数错误，提现申请失败！';
            }
            $json = array('success' =>$success,'message' => $message);

            echo json_encode($json,JSON_UNESCAPED_UNICODE); 
        }else{
            $userid=$_GET['id'];
            $member=M('Member')->where("id=$userid")->field('balance')->find();
            
           echo json_encode($member,JSON_UNESCAPED_UNICODE);  
        }
        
        
        
        
    }
    //我的团队
    public function myteam() {
        $success=0;
        $message='获取失败';
        $string='yydb';
        $userid=$_GET['id'];
        $type=$_GET['type'];
        //一级团队
        if($type==1){
            $onelevel=M('Member')->where(array('parentid'=>$string.$userid))->field('nickname,headimg,recommendid,addtime')->select();
            foreach ($onelevel as $k1 => $v1) {
                $onelevel[$k1]['addtime']=date("Y-m-d H:i",$v1['addtime']);
                $onelevel[$k1]['headimg']=IMG_ROOTPATH.$v1['headimg'];
               
            }
            if(!$onelevel){
                $message='未获取到该会员的推广团队信息';
            }else{
                $success=1;
                $message='一级推广团队信息获取成功';
            }
            $json = array('success' =>$success,'message' => $message,'onelevel'=>$onelevel);
       
            echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
        }else if($type==2){
            $twolevel=M('Member')->where(array('pparentid'=>$string.$userid))->field('nickname,headimg,recommendid,addtime')->select();
            foreach($twolevel as $k2 =>$v2){
                $twolevel[$k2]['addtime']=date("Y-m-d H:i",$v2['addtime']);
                $twolevel[$k2]['headimg']=IMG_ROOTPATH.$v2['headimg'];
            }
            if(!$twolevel){
                $message='未获取到该会员的二级推广团队信息';
            }else{
                $success=1;
                $message='二级推广团队信息获取成功';
            }
            $json = array('success' =>$success,'message' => $message,'twolevel'=>$twolevel);
       
            echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
        }
       
    }
    //获取推广二维码 
    public function spreadcode() {
       
        $success=0;
        $message='获取失败';
        $userid=$_GET['id'];
        $res=M('Member')->where("id=$userid")->field('nickname,is_vip,recommendid,spreadcode')->find();
        if($res['is_vip']==0){
            $message='普通会员暂时无法享有推广二维码权益哦！';
            
        }else{
            if($res['spreadcode']){
                $map['nickname']=$res['nickname'];
                $map['code']=IMG_ROOTPATH.$res['spreadcode'];
                $success=1;
                $message='推广二维码获取成功';
            }else{
                 //根据推广id(yydb+id)生成推广二维码
                $save_path = isset($_GET['save_path'])?$_GET['save_path']:'./Public/qrcode/';  //图片存储的绝对路径
                $web_path = isset($_GET['save_path'])?$_GET['web_path']:'/Public/qrcode/';        //图片在网页上显示的路径
                //扫二维码定向地址需传参appid    new_url中的域名需备案
                //$appid="wx9a089f67993e8d37";
                
                $qr_data = isset($_GET['qr_data'])?$_GET['qr_data']:"http://yg.91chihu.com/index.php/joinduobao/index/recommendid/".$res['recommendid'];
                
                $qr_level = isset($_GET['qr_level'])?$_GET['qr_level']:'H';
                $qr_size = isset($_GET['qr_size'])?$_GET['qr_size']:'10';
                $save_prefix = isset($_GET['save_prefix'])?$_GET['save_prefix']:'ZETA';
                if($filename = createQRcode($save_path,$qr_data,$qr_level,$qr_size,$save_prefix)){
                    $pic = $web_path.$filename;
                }
                //var_dump($pic);exit;
                $update=M('Member')->where("id=$userid")->setField('spreadcode',$pic);
                $map['nickname']=$res['nickname'];
                $map['code']=IMG_ROOTPATH.$pic;
                $success=1;
                $message='推广二维码生成成功';
            }
           
             
        }
       $json = array('success' =>$success,'message' => $message,'map'=>$map);
       
        echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
    }
  
 
    //我参与的夺宝  
    public function myduobao() {
        $success=0;
        $message='数据错误';
        $userid=$_GET['id'];
        $type=$_GET['type'];
        
        $joins=M('Joindetail')->where("user_id=$userid")->field('good_id,good_no,jointime')->select();
        $joins1=M('Fundjoindetail')->where("user_id=$userid")->field('fund_id,jointime')->select();
        if(empty($joins)&& empty($joins1)){
            $message='未找到该会员有关的参与信息';
            $json=array('success'=>$success,'message'=>$message);
            echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
        }else if($type==0){
            //未开奖
            foreach ($joins as $k=>$v) {
               
                $duobaos[$k]=M('Duobao')->where(array('good_id'=>$v['good_id'],'good_no'=>$v['good_no'],'status'=>0))->field('good_name,good_no,good_pic')->find();
                if($duobaos[$k]){
                    $duobaos[$k]['time']=date("Y-m-d H:i",$v['jointime']);
                    $duobaos[$k]['good_pic']=IMG_ROOTPATH.$duobaos[$k]['good_pic'];
                    
                } 
                
            }
            foreach ($joins1 as $k1 => $v1) {
                $funds[$k1]=M('Dreamfund')->where(array('id'=>$v1['fund_id'],'status'=>0))->field('fund_name,fund_pic')->find();
                if(($funds[$k1])){
                    $funds[$k1]['time']=date("Y-m-d H:i",$v1['jointime']);
                    $funds[$k1]['fund_pic']=IMG_ROOTPATH.$funds[$k1]['fund_pic'];
                }
            }
            if($duobaos || $funds){
               
                $success=1;
                $message='该会员未开奖信息获取成功';
            }else{
                $message='未获取到该会员未开奖信息';
            }
            
               
                $json=array('success'=>$success,'message'=>$message,'duobaos'=>$duobaos,'funds'=>$funds);
                echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
            }else if($type==1){
                //未中奖
                foreach ($joins as $k => $v) {
                    
                    $winuserid=M('Winlog')->where(array('good_id'=>$v['good_id'],'good_no'=>$v['good_no']))->field('user_id')->find();
                    //var_dump($winuserid);exit;
                    if($winuserid){
                       if($winuserid['user_id'] != $userid){
                       
                        $duobaos[$k]=M('Duobao')->where(array('good_id'=>$v['good_id'],'good_no'=>$v['good_no'],'status'=>1))->field('good_name,good_no,good_pic')->find();
                        $duobaos[$k]['time']=date("Y-m-d H:i",$v['jointime']);
                        $duobaos[$k]['good_pic']=IMG_ROOTPATH.$duobaos[$k]['good_pic'];
                       
                        
                        }  
                    }
               
                }
                foreach ($joins1 as $k1 => $v1) {
                    $fundwinuserid=M('Fundwinlog')->where(array('fund_id'=>$v1['fund_id']))->field('user_id')->find();
                    if($fundwinuserid){
                        if($fundwinuserid!=$userid){
                            $funds[$k1]=M('Dreamfund')->where(array('id'=>$v1['fund_id'],'status'=>1))->field('fund_name,fund_pic')->find();
                            $funds[$k1]['time']=date("Y-m-d H:i",$v1['jointime']);
                            $funds[$k1]['fund_pic']=IMG_ROOTPATH.$funds[$k1]['fund_pic'];
                        }
                    }
                }
                if($duobaos || $funds){
                    
                    $success=1;
                    $message='该会员未中奖信息获取成功';
                }else{
                    $message='未获取到该会员未中奖信息';
                }
               
                $json=array('success'=>$success,'message'=>$message,'duobaos'=>$duobaos,'funds'=>$funds);
                echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
                }else if($type==2){
                    //中奖
                    $wins=M('Winlog')->where("user_id=$userid")->field('good_id,good_no,wintime')->select();
                    $fundwins=M('Fundwinlog')->where("user_id=$userid")->field('fund_id,wintime')->select();
                    if(empty($wins)&& empty($fundwins)){
                        $message='未获取到该会员中奖信息';
                    }
                    foreach ($wins as $k => $v) {
                    
                    $duobaos[$k]=M('Duobao')->where(array('good_id'=>$v['good_id'],'good_no'=>$v['good_no'],'status'=>1))->field('good_name,good_no,good_pic')->find();
                   if($duobaos[$k]){
                       $duobaos[$k]['time']=date("Y-m-d H:i",$v['wintime']);
                       $duobaos[$k]['good_pic']=IMG_ROOTPATH.$duobaos[$k]['good_pic'];
                      
                   }
                    
                    }
                    foreach ($fundwins as $k1 => $v1) {
                        $funds[$k1]=M('Dreamfund')->where(array('id'=>$v1['fund_id'],'status'=>1))->field('fund_name,fund_pic')->find();
                        if($funds[$k1]){
                            $funds[$k1]['time']=date("Y-m-d H:i",$v1['wintime']);
                            $funds[$k1]['fund_pic']=IMG_ROOTPATH.$funds[$k1]['fund_pic'];
                        }
                    }
                   if($duobaos || $funds){
                    
                    $success=1;
                    $message='该会员中奖信息获取成功';
                    }else{
                        $message='未获取到该会员中奖信息';
                    }

                    $json=array('success'=>$success,'message'=>$message,'duobaos'=>$duobaos,'funds'=>$funds);
                    echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
                }
           
        
    }
    
    //我的中奖纪录
    public function mywinlog() {
        $success=0;
        $message='未找到该会员相关中奖信息';
        $userid=$_GET['id'];
        $wins=M('Winlog')->where("user_id=$userid")->select();
        $fundwins=M('Fundwinlog')->where("user_id=$userid")->select();
        foreach ($wins as $k => $v) {
            $map[$k]=M('Good')->where(array('id'=>$v['good_id']))->field('good_name,good_pic')->find();
            $map[$k]['good_no']=$v['good_no'];
            $map[$k]['wintime']=date("Y-m-d H:i",$v['wintime']);
            $map[$k]['good_pic']=IMG_ROOTPATH.$map[$k]['good_pic'];
        }
        foreach ($fundwins as $k1 => $v1) {
            $map1[$k1]=M('Dreamfund')->where(array('id'=>$v1['fund_id']))->field('fund_name,fund_pic')->find();
            $map1[$k1]['wintime']=date("Y-m-d H:i",$v1['wintime']);
            $map1[$k1]['fund_pic']=IMG_ROOTPATH.$map1[$k1]['fund_pic'];
        }
        if($map || $map1){
            $success=1;
            $message='中奖信息获取成功';
        }
        $json=array('success'=>$success,'message'=>$message,'win'=>$map,'fundwin'=>$map1);
        echo str_replace("\\/", "/", json_encode($json,JSON_UNESCAPED_UNICODE));
    }
    //完善信息
    public function improveinformation() {
        $success=0;
        $message='数据错误';
        $map['nickname']=$_POST['nickname'];
        $map['headimg']=$_POST['headimg'];
        $map['mobile']=$_POST['mobile'];
        if(!preg_match("/^1[34578]{1}\d{9}$/",$map['mobile']) || strlen($map['mobile'])!=11){
            $message='手机号格式有误，请重新输入';
            $json=array('success'=>$success,'message'=>$message);
            echo json_encode($json,JSON_UNESCAPED_UNICODE);exit;
        }
        $map['weixin']=$_POST['weixin'];
        $map['alipay']=$_POST['alipay'];
        $res=M('Member')->where(array('mobile'=>$map['mobile']))->field('id')->find();
        //通过推广码推广的会员
        if($res){
            $res1=M('Member')->where(array('id'=>$res['id']))->save($map);
            if($res1){
                $success=1;
                $message='会员信息完善成功！';
            }
        }else{
            //下载APP直接用微信登录的会员
            $res2=M('Member')->add($map);
            if($res2){
                $string='yydb';
                $res22=M('Member')->where(array('id'=>$res2))->setField('recommendid',$string.$res);
                if($res22){
                    $success=1;
                    $message='会员信息完善成功！';
                }
            }
        }
        $json=array('success'=>$success,'message'=>$message);
        echo json_encode($json,JSON_UNESCAPED_UNICODE);
    }
    //消息列表
    public function newslist() {
        $success=0;
        $message='消息列表获取失败';
        //会员id
        $memberid=$_GET['id'];
        $news=M('News')->where("user_id=$memberid")->select();
        if($news){
            $success=1;
            $message='消息列表获取成功';
            
        }
        $json=array('success'=>$success,'message'=>$message,'news'=>$news);
        echo json_encode($json,JSON_UNESCAPED_UNICODE);
    }
    //具体消息
    public function newsdetail() {
        if(IS_POST){
            $success=0;
            $message='佣金领取失败';
            //消息id
            $id=$_POST['id'];
            $new=M('News')->where("id=$id")->field('status')->find();
            if($new['status']==1){
                $message='该佣金已领取，请勿重复领取';
                $json=array('success'=>$success,'message'=>$message);
                echo json_encode($json,JSON_UNESCAPED_UNICODE);exit;
            }
            $memberid=$_POST['user_id'];
            $money=$_POST['money'];
            $member=M('Member')->where("id=$memberid")->field('commission')->find();
            $usercommission=$member['commission']+$money;
            $res=M('Member')->where("id=$memberid")->setField('commission',$usercommission);
            if($res){
                $res1=M('News')->where("id=$id")->setField('status',1);
                if($res1){
                    $map['user_id']=$memberid;
                    $map['type']=0;
                    $map['changenum']=$money;
                    $map['usercommission']=$usercommission;
                    $map['addtime']=time();
                    $res2=M('Commissionlog')->add($map);
                    if($res2){
                        $success=1;
                        $message='佣金领取成功';
                    }
                }
            }
            $json=array('success'=>$success,'message'=>$message);
            echo json_encode($json,JSON_UNESCAPED_UNICODE);
            
            
        }else{
        $success=0;
        $message='消息获取失败';
        //消息id
        $id=$_GET['id'];
        
        $new=M('News')->where("id=$id")->find();
        if($new){
            $success=1;
            $message='信息获取成功';
        }
        $json=array('success'=>$success,'message'=>$message,'new'=>$new);
        echo json_encode($json,JSON_UNESCAPED_UNICODE);
        }
    }
    
	 
}

