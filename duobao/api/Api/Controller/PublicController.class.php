<?php

namespace Api\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8");
class PublicController extends Controller{
   //手机短信验证码发送接口
    public function sendmessage() {
        Vendor('alisms.Alisms'); 
       
        $mobile =$_GET['mobile'];
        $minTime=60;
        $send_info = M('Verificationcode')->where(['receiver'=>$mobile])->find();
        if (!empty($send_info)) {
            if (time() - $send_info['createtime'] < $minTime) {
            
            $info['info']   = '短信已发送！60秒内有效,请勿重新获取！';
            $info['status'] = 0;
            echo json_encode($info,JSON_UNESCAPED_UNICODE);
            exit;
            
            }
        }
        $alisms = new \Alisms(C('Ali_SMS.appkey'),C('Ali_SMS.secretKey'));
        $temp_code   = C('Ali_SMS.sms_temp');
        $code=substr(time(), 6).rand(10,99);
        $paramString = '{"code":"'.$code.'"}';
        $alisms->signName = C('Ali_SMS.sms_sign');
        $re = $alisms->smsend($mobile,$temp_code,$paramString);
        
        if($re['Code'] =='OK'){
            $info['status'] = 1;
            $info['info']   = '短信发送成功！';
            $send_info = M('Verificationcode')->where(['receiver'=>$mobile])->find();
            if(empty($send_info)){
                $map['receiver']=$mobile;
                $map['createtime']=time();
                $map['code']=$code;
                $map['total']=1;
                $map['expire_time']=300;
               
                M('Verificationcode')->add($map);
                echo json_encode($info,JSON_UNESCAPED_UNICODE);
                exit;
            }else{
                $map['createtime']=time();
                $map['code']=$code;
                $map['total']=$send_info['total']+1;
                M('Verificationcode')->where(array('receiver'=>$mobile))->save($map);
                echo json_encode($info,JSON_UNESCAPED_UNICODE);
                exit;
                
            }
            
            
        }else{
            $info['info']   = '短信发送失败';
            $info['status'] = 0;
            echo json_encode($info,JSON_UNESCAPED_UNICODE);
            exit;
        }
   }

    //上传图片
    public function uploadimg() {
        //echo $_FILES['image'];exit;
        //echo $_FILES['image']['name'];exit; 
        if($_FILES['image']){
            
           
            //实例化Upload
            $unlink=$_POST['unlink'];
            $upload=new \Think\Upload();
            //大小
            $upload->maxSize=123456789;
            //类型
            $upload->exts=array('jpg','png','jpeg');
            //保存路径
            $upload->rootPath="./Public/idcard/";
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
            $map['image']=IMG_ROOTPATH."/Public/idcard/".$savepath.$savename;
            unlink($unlink);
        }
        unset($_POST['unlink']); 
       echo str_replace("\\/", "/", json_encode($map,JSON_UNESCAPED_UNICODE));
    }
   
    
    
}

