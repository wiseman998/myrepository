<?php


//允许前台跨域访问
header("Access-Control-Allow-Origin:*"); 
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 定义应用目录
define('APP_PATH','./api/');
//默认的访问模块
define('BIND_MODULE','Api'); 
define('REDICT_PATH','http://192.168.1.192/duobao/api.php/public/');
define('IMG_ROOTPATH','http://192.168.1.192/duobao');
// 引入ThinkPHP入口文件
require ('./ThinkPHP/ThinkPHP.php');

// 亲^_^ 后面不需要任何代码了 就是如此简单



