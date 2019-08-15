<?php

namespace Api\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8");
class SystemController extends Controller{
    //获取轮播图
    public function getlooppic() {
        $looppic=M('Looppic')->field('title,pic')->select();
        foreach ($looppic as $k => $v) {
            $looppic[$k]['pic']=IMG_ROOTPATH.$v['pic'];
        }
        echo str_replace("\\/", "/", json_encode($looppic,JSON_UNESCAPED_UNICODE));
    }
    //获取平台客服微信号及二维码
    public function getkefuweixin() {
       $kefu=M('System')->where("id=1")->field('weixincode,weixin')->find();
       
      
            $kefu['weixincode']=IMG_ROOTPATH.$kefu['weixincode'];
        
       //var_dump($kefu);exit;
       echo str_replace("\\/", "/", json_encode($kefu,JSON_UNESCAPED_UNICODE));
    }
    //关于平台信息
    public function about() {
       $about=M('About')->where("id=1")->field('title,detail')->find();
       echo json_encode($about, JSON_UNESCAPED_UNICODE);
    }
    
   
    
}

