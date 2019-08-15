<?php
return array(
        //'配置项'=>'配置值'
	'DB_TYPE'				=>  'mysqli',
	'DB_HOST'               =>  'localhost', // 服务器地址
        'DB_NAME'               =>  'duobao',          // 数据库名
        'DB_USER'               =>  'root',      // 用户名
        'DB_PWD'                =>  '123456',          // 密码
        'DB_PORT'               =>  '3306',        // 端口
        'DB_PREFIX'             =>  'ydb_',    // 数据库表前缀
	'DB_CHARSET' 			=> 'utf8',	//数据库使用编码
    
    'Ali_SMS' =>array(
        'sms_temp' =>'SMS_167396569',
        'sms_sign' =>'梦想APP',
        'appkey'   =>'LTAI6RmncDy23w6p',
        'secretKey'=>'7cMUz5SZqIti3vx7OLxbQiJLmPM7Zq',
    ),
    'Alipay'=>array (	
		//应用ID,您的APPID。
		'app_id' => "2019061065487752",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEAzQ283yfU/ZoikvVNEfSYl6jkm9cLfxNzw0ta7vJRx/XOmlDkz8omzTSLbUROQ7eiRHeUd+t+fi6t/0+kOG/U/UjT/k7I+fS7BTQevh9mDRQCCxMvPmTXO5k1lZp8HlOyhJrzdfJphNtPWg22MJBO6QO3LVn52UrjU8lgXqFgdhhv8DOXmTdKhjEm4bKiEufc8iNifr29vZ3PeB58DhzCm+DzLHooD+NnByyt1inSW6VeLM30H4n8M0vFVBUl7yxhGJaTrSBUX8jkTUf1I/3abxM1ygRtkwv2qJLqtySqzEKU04q7JaLD2BA+f1T9uv4XEvvpUT9At/UwyehPjB9v6QIDAQABAoIBAQCiCeIgAm0Ivt3lfd0afEx9RGTrVaNrFycaxBimzGyd9HwAbD50iY3iCUzI2vpx/tJHAqwbm8gI1MCBCiF+y7jnMr77rqyZAbEsqoREv7E4UoBO2ikySCPhn++9OigtGvzuVzhfE2IZL+lkA4PempsQ/fOp7flHoitEUdVK0oHUr46BEPIYZYuPuTk8VGEW+qI/Xyg6nxGa195S0pIqiXhshnoU8SY4caHd2Q3qZugEzLswscoNRK5mKqisYSjDq3BKhZTVqpXHdNcd5wSh9a9K2qRpDf6pCwavF7CO94rV5QK5RIiVHeTb45CB91gD5d7o6LC28FW0La/6WDipXLa1AoGBAO/LzWFyDEBLDkobEb1MsRzmiXR4c/dS7x3Zn+ujbjp4zGBVjkmyDz+9vtjSlXqz+WpZW8TW4dWGgWHVu+fGAYKahO1ykJTfKZVCSOWrhDDOW+h16DGnHpEOhvTxz0zp9rJz9DxExq2P3ATPpURx/II+ABQ2Q/csCaH43UBrW76LAoGBANro7l6PuiJQCCjoRft9u+rHWDAlIH5rn8tdT07ND9Pj/dtc9pRf72sTGXQ115Yzr+1BImEJQzBu920kcZZIbUU7E0TXxBVxjXTOCXQE3lujJfuEJ9J6ueVNVlnbLn6xwCsgBJR4wUQFni3xlspquU8KevT3OkeIPE7jCQR+Dy3bAoGBAKQF56or9K1VqaSO94dgmhWGq6b7bXdTRzRH09e+pntgfYu3eeh2329ePtjY0l5oFMbl8Jun0DnaE030gN981TOctiglIThznWH3QR24QGeR/9P2MqkkAwh9w1pwvLeDobdXEUzYTn4R1RGFZyp2PZ5pAmzQ4ZSEjuI39D9IMC0ZAoGALNl6NM93kB4bfd4QsHTTMkfDLqH8pUoBhBXK8NccfgoA8Zd7QWziTWqtVVzOnYxbZ91nYMAYDu09LhRAXUzbbkqrKPiXyNjp5VttHmL894NWfdBWpE3Wlj8hCOnZ/cUHHQ7DQXP4DKql/L25aiExdBsuk8+vFga4bGUhbNUy4O8CgYA50g9J/QVnOYw3jKmQtPqQSVPdFyCw4GT2KN3WS5CxyxkQNHYTkSq1JB7mNafqMLNG/ztEJ73EbYKbq8LMxoVNuELNjeTbewLKub/jST2+/RCfqZFvm3j2Oq6rp4lOgI0MCQ0HZVINow9heCHICxXDpcHn/pfjumf3uTY5vEu5/A==",
		
		//异步通知地址
		'notify_url' => "http://yg.91chihu.com/alipay.trade.wap.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://yg.91chihu.com/alipay.trade.wap.pay-PHP-UTF-8/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "",
		
	
),
	
);