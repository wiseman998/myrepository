<?php
namespace Api\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8");
class WeixinController extends Controller{
    public function getcode()
    {
        $success=0;
        if (!empty($_GET['code'])) {
            $code = $_GET['code'];
            /*获取code后，请求以下链接获取access_token：  https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code*/
            /*appid	是	APP的唯一标识
            secret	是	APP的appsecret
            code	是	填写第一步获取的code参数
            grant_type	是	填写为authorization_code*/

            /*正确时返回的JSON数据包如下：

            {
                "access_token":"ACCESS_TOKEN",
                "expires_in":7200,
                "refresh_token":"REFRESH_TOKEN",
                "openid":"OPENID",
                "scope":"SCOPE"
             }*/

            $appid = "wx9a089f67993e8d37";
            $secret = "3fff2d5b4ec8677ddc6f1d4a3453f236";
            $grant_type = "authorization_code";

            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=$grant_type";

            $token = cmf_curl_get($url);


            // die;
            /*{
            "access_token":"ACCESS_TOKEN",
            "expires_in":7200,
            "refresh_token":"REFRESH_TOKEN",
            "openid":"OPENID",
            "scope":"SCOPE"
             }*/


            $token_arr = json_decode($token, true);

            //dump($token_arr);
            //die;
            /*if (array_key_exists('errcode', $token_arr)) {
                return $this->exitJson('0', 'code无效');
            }*/
            //获取用户信息

            $user_info = $this->get_userinfo($token_arr['access_token'], $token_arr['openid']);
            if ($user_info) {
                $user_arr = json_decode($user_info, true);
                $map['nickname']=$user_arr['nickname'];
                $map['headimg']=$user_arr['headimgurl'];
                $success=1;
                $message='用户信息获取成功';

                /*79441966
				array(9) {
				  ["openid"] => string(28) "oY40r6B17lOWha3J7VF-e-qnhEiM"
				  ["nickname"] => string(9) "郭起"
				  ["sex"] => int(1)
				  ["language"] => string(5) "zh_CN"
				  ["city"] => string(0) ""
				  ["province"] => string(0) ""
				  ["country"] => string(6) "埃及"
				  ["headimgurl"] => string(135) "http://thirdwx.qlogo.cn/mmopen/vi_32/oEicpuoN6vAdFuvIicibn6OsSzGF3sUa2U56OIa6ibwLxxibB4SkEPUvTmfuOECAfxicT36CiaJkgA2k1uGicoMQPjBz6w/132"
				  ["privilege"] => array(0) {
				  }
				}*/

                //die;
               // $auth_obj = new AuthController();
               // return $auth_obj->wx_login($user_info['openid'], $user_info['nickname'], $user_info['sex'], $user_info['headimgurl'], $number);

            }else{
                
                $message='未能获取到微信用户昵称头像等信息';
            }

            


        } else {
           
            $message='信息错误,获取code失败';
        }
        $json=array('success'=>$success,'message'=>$message,'map'=>$map);
        echo json_encode($json,JSON_UNESCAPED_UNICODE);

    }

    /*第四步：拉取用户信息(需scope为 snsapi_userinfo)

如果网页授权作用域为snsapi_userinfo，则此时开发者可以通过access_token和openid拉取用户信息了。

请求方法

http：GET（请使用https协议） https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN*/

    public function get_userinfo($access_token, $openid)
    {


        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";

        $json_info = cmf_curl_get($url);
        return json_decode($json_info, true);
    }
}

