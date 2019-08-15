<?php
return array(
	//'配置项'=>'配置值'
    'DB_TYPE'               =>  'mysqli',
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'duobao',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '123456',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'ydb_',    // 数据库表前缀
    'DB_CHARSET'            => 'utf8',	//数据库使用编码
    
    'SESSION_OPTIONS'         =>  array(
       'expire'              =>  24*3600*30,                      //SESSION保存30天
        'use_trans_sid'       =>  1,                               //跨页传递
        'use_only_cookies'    =>  0,                               //是否只开启基于cookies的session的会话方式
    ),
	
);