<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="/Public/favicon.ico" >
<link rel="Shortcut Icon" href="/Public/Admin/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/Admin/lib/html5shiv.js"></script>
<script type="text/javascript" src="/Public/Admin/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/Public/Admin/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="/Public/Admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>一元夺宝后台管理系统</title>
</head>
<body>
<header class="navbar-wrapper">
	<div class="navbar navbar-fixed-top">
		<div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="">一元夺宝后台管理系统</a> <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="/aboutHui.shtml">定生缘</a> 
			<a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
		<nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
			<ul class="cl">
				<li>超级管理员</li>
				<li class="dropDown dropDown_hover">
					<a href="#" class="dropDown_A"><?php echo ($admin["username"]); ?> <i class="Hui-iconfont">&#xe6d5;</i></a>
					<ul class="dropDown-menu menu radius box-shadow">
						<li><a href="<?php echo U('Login/logout');?>">退出</a></li>
				</ul>
			</li>
				<li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
					<ul class="dropDown-menu menu radius box-shadow">
						<li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
						<li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
						<li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
						<li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
						<li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
						<li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
					</ul>
				</li>
				
			</ul>
		</nav>
	</div>
</div>
</header>
<aside class="Hui-aside">
	<div class="menu_dropdown bk_2">
		<dl id="menu-tongji">
			<dt><i class="Hui-iconfont">&#xe62d;</i>数据统计<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="<?php echo U('Picture/index');?>" data-title="数据统计" href="javascript:void(0)">数据统计</a></li>
					
				</ul>
			</dd>
		</dl>
		
		<dl id="menu-admin">
			<dt><i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="<?php echo U('Admin/index');?>" data-title="管理员列表" href="javascript:void(0)">管理员列表</a></li>
					
				</ul>
			</dd>
		</dl>
		
		<dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 会员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="<?php echo U('Member/index');?>" data-title="会员列表" href="javascript:;">会员列表</a></li>
                                        <li><a data-href="<?php echo U('Member/index1');?>" data-title="VIP会员列表" href="javascript:;">VIP会员列表</a></li>
					
					
				</ul>
			</dd>
		</dl>
		
		
		
		
		
		
		
		<dl id="menu-withdraw">
			<dt><i class="Hui-iconfont">&#xe620;</i> 提现管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
						
					<li><a data-href="<?php echo U('Withdrawlog/index');?>" data-title="提现列表" href="javascript:void(0)">提现列表</a></li>
					<li><a data-href="<?php echo U('Withdrawlog/index1');?>" data-title="已提现" href="javascript:void(0)">已提现</a></li>
		 			
				</ul>
			</dd>
		</dl>
                
                <dl id="menu-order">
			<dt><i class="Hui-iconfont">&#xe620;</i> 订单管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
						
					<li><a data-href="<?php echo U('Order/index');?>" data-title="订单列表" href="javascript:void(0)">订单列表</a></li>
					<li><a data-href="<?php echo U('Order/index1');?>" data-title="已付款订单" href="javascript:void(0)">已付款订单</a></li>
					
				</ul>
			</dd>
		</dl>
		
		<dl id="menu-good">
			<dt><i class="Hui-iconfont">&#xe616;</i> 商品管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul> 
					<li><a data-href="<?php echo U('Good/index');?>" data-title="商品管理" href="javascript:void(0)">商品管理</a></li>
				</ul>
			</dd>
		</dl>
                <dl id="menu-duobao">
			<dt><i class="Hui-iconfont">&#xe616;</i> 夺宝管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul> 
					<li><a data-href="<?php echo U('Duobao/index');?>" data-title="夺宝管理" href="javascript:void(0)">夺宝管理</a></li>
                                        <li><a data-href="<?php echo U('Duobao/joindetail');?>" data-title="参与明细管理" href="javascript:void(0)">参与明细管理</a></li>
                                        <li><a data-href="<?php echo U('Win/index');?>" data-title="中奖管理" href="javascript:void(0)">中奖管理</a></li>
                                        <li><a data-href="<?php echo U('Showwin/index');?>" data-title="晒单管理" href="javascript:void(0)">晒单管理</a></li>
				</ul>
			</dd>
		</dl>
                <dl id="menu-dreamfund">
			<dt><i class="Hui-iconfont">&#xe616;</i> 梦想基金管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul> 
					<li><a data-href="<?php echo U('Dreamfund/index');?>" data-title="梦想基金管理" href="javascript:void(0)">梦想基金管理</a></li>
                                        <li><a data-href="<?php echo U('Dreamfund/joindetail');?>" data-title="参与明细管理" href="javascript:void(0)">参与明细管理</a></li>
                                        <li><a data-href="<?php echo U('Fundwin/index');?>" data-title="中奖管理" href="javascript:void(0)">中奖管理</a></li>
                                        <li><a data-href="<?php echo U('Fundshowwin/index');?>" data-title="晒单管理" href="javascript:void(0)">晒单管理</a></li> 
				</ul>
			</dd>
		</dl>
                
                 <dl id="menu-log">
			<dt><i class="Hui-iconfont">&#xe616;</i> 流水管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul> 
					<li><a data-href="<?php echo U('Balance/index');?>" data-title="余额流水管理" href="javascript:void(0)">余额流水管理</a></li>
                                        <li><a data-href="<?php echo U('Commission/index');?>" data-title="佣金流水管理" href="javascript:void(0)">佣金流水管理</a></li>
                                        
                                        
				</ul>
			</dd>
		</dl>
		
		<dl id="menu-notice">
			<dt><i class="Hui-iconfont">&#xe616;</i> 公告系统<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="<?php echo U('Notice/index');?>" data-title="公告/任务管理" href="javascript:void(0)">公告/任务管理</a></li>
				</ul>
			</dd>
		</dl>
		
		
		
		
                <dl id="menu-looppic">
			<dt><i class="Hui-iconfont">&#xe616;</i> 轮播图管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="<?php echo U('Looppic/index');?>" data-title="轮播图管理" href="javascript:void(0)">轮播图管理</a></li>
					
				</ul>
			</dd>
		</dl>
                <dl id="menu-sysset">
			<dt><i class="Hui-iconfont">&#xe616;</i> 系统设置<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="<?php echo U('Memrankset/index');?>" data-title="会员等级设置" href="javascript:void(0)">会员等级设置</a></li>
					<li><a data-href="<?php echo U('Returnmoneyset/index');?>" data-title="分销返佣设置" href="javascript:void(0)">分销返佣设置</a></li>
                                        <li><a data-href="<?php echo U('System/setpayparam');?>" data-title="支付参数设置" href="javascript:void(0)">支付参数设置</a></li>
                                        <li><a data-href="<?php echo U('System/setfee');?>" data-title="提现手续费设置" href="javascript:void(0)">提现手续费设置</a></li>
                                        <li><a data-href="<?php echo U('System/setweixin');?>" data-title="客服微信设置" href="javascript:void(0)">客服微信设置</a></li>
                                        <li><a data-href="<?php echo U('System/setabout');?>" data-title="平台信息设置" href="javascript:void(0)">平台信息设置</a></li>
				</ul>
			</dd>
		</dl>
	
		
	
	
		
		<!-- <dl id="menu-system">
			<dt><i class="Hui-iconfont">&#xe62e;</i> 系统管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="system-base.html" data-title="系统设置" href="javascript:void(0)">系统设置</a></li>
					<li><a data-href="system-category.html" data-title="栏目管理" href="javascript:void(0)">栏目管理</a></li>
					<li><a data-href="system-data.html" data-title="数据字典" href="javascript:void(0)">数据字典</a></li>
					<li><a data-href="system-shielding.html" data-title="屏蔽词" href="javascript:void(0)">屏蔽词</a></li>
					<li><a data-href="system-log.html" data-title="系统日志" href="javascript:void(0)">系统日志</a></li>
			</ul>
		</dd>
	</dl> -->
</div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<section class="Hui-article-box">
	<div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
		<div class="Hui-tabNav-wp">
			<ul id="min_title_list" class="acrossTab cl">
				<li class="active">
					<span title="我的桌面" data-href="welcome.html">我的桌面</span> 
					<em></em></li>
		</ul>
	</div>
		<div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
</div>
	<div id="iframe_box" class="Hui-article">
		<div class="show_iframe">
			<div style="display:none" class="loading"></div>
			<iframe scrolling="yes" frameborder="0" src="<?php echo U('Picture/index');?>"></iframe>
	</div>
</div>
</section>

<div class="contextMenu" id="Huiadminmenu">
	<ul>
		<li id="closethis">关闭当前 </li>
		<li id="closeall">关闭全部 </li>
</ul>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/Admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/Public/Admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/Public/Admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/Admin/lib/jquery.contextmenu/jquery.contextmenu.r2.js"></script>
<script type="text/javascript">
$(function(){
	/*$("#min_title_list li").contextMenu('Huiadminmenu', {
		bindings: {
			'closethis': function(t) {
				console.log(t);
				if(t.find("i")){
					t.find("i").trigger("click");
				}		
			},
			'closeall': function(t) {
				alert('Trigger was '+t.id+'\nAction was Email');
			},
		}
	});*/
});
/*个人信息*/
function myselfinfo(){
	layer.open({
		type: 1,
		area: ['300px','200px'],
		fix: false, //不固定
		maxmin: true,
		shade:0.4,
		title: '查看信息',
		content: '<div>管理员信息</div>'
	});
}

/*资讯-添加*/
function article_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*图片-添加*/
function picture_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*产品-添加*/
function product_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*用户-添加*/
function member_add(title,url,w,h){
	layer_show(title,url,w,h);
}


</script> 

<!--此乃百度统计代码，请自行删除-->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?080836300300be57b7f34f4b3e97d911";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<!--/此乃百度统计代码，请自行删除-->
</body>
</html>