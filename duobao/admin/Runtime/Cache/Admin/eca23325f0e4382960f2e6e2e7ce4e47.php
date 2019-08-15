<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
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
<title>会员管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 会员中心 <span class="c-gray en">&gt;</span> 会员管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	
	
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="20">ID</th>
				<th width="40">会员名</th>
				 
				<th width="10">头像</th>
				<th width="90">手机</th>
				<th width="100">注册时间</th>
                                <th width="70">微信</th>
				<th width="70">支付宝</th>
				
				<th width="60">VIP状态</th> 
				<th width="50">实名认证状态</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
				<td><input type="checkbox" value="1" name=""></td>
				<td><?php echo ($vo["id"]); ?></td>
				<td><?php echo ($vo["nickname"]); ?></td>
				
				<td><img src="<?php echo ($vo["headimg"]); ?>" width="50px" height="50px"></td>
				<td><?php echo ($vo["mobile"]); ?></td>
				<td><?php echo (date("Y-m-d H:i:s ",$vo['addtime'])); ?></td>
                                <td><?php echo ($vo["weixin"]); ?>
				<td><?php echo ($vo["alipay"]); ?></td>
				<td class="td1"><?php echo ($b[$vo['is_vip']]); ?></td>
				<td class="td1"><?php echo ($b[$vo['is_certification']]); ?></td>
				<td class="td-manage">
					<a style="text-decoration:none"  href="javascript:void(0);" onclick="member_edit('会员修改','<?php echo U('Member/edit','eid='.$vo['id']);?>','','510')"><span class="label label-success radius">编辑</span></a>
					<a style="text-decoration:none"  href="javascript:void(0);" onclick="member_del(this,'<?php echo ($vo["id"]); ?>')"><span class="label label-success radius">删除</span></a>
					
					
					<a style="text-decoration:none"  href="javascript:void(0)" onclick="member_certification('认证确认','<?php echo U('Member/certification','id='.$vo['id']);?>','','510')"><span class="label label-success radius">认证确认</span></a></td><?php endforeach; endif; else: echo "" ;endif; ?>
			</tr>
		</tbody>
	</table>
	</div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/Admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/Public/Admin/static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="/Public/Admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/Admin/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="/Public/Admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="/Public/Admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
$(function(){
	$('.table-sort').dataTable({
		"aaSorting": [[ 1, "asc" ]],//默认第几个排序
		"bStateSave": true,//状态保存
		"aoColumnDefs": [
		  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
		  {"orderable":false,"aTargets":[0,8,9]}// 制定列不参与排序
		]
	});
	
});
/*用户-添加*/
function member_add(title,url,w,h){
	layer_show(title,url,w,h);
}




/*用户-编辑*/
function member_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*认证确认*/
function member_certification(title,url,id,w,h){
	layer_show(title,url,w,h);
}

/*用户-删除*/
function member_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: "<?php echo U('Member/delete');?>",
			data:{id:id},
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			},
			error:function(data) {
				layer.msg('删除失败!',{icon:1,time:1000});
			},
		});		
	});
}









</script> 
</body>
</html>