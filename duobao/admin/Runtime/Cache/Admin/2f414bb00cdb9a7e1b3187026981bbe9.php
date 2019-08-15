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
<title>夺宝管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 夺宝中心 <span class="c-gray en">&gt;</span> 夺宝管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="duobao_add('添加夺宝活动','<?php echo U('Duobao/add');?>','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加夺宝活动</a></span>  </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="20">ID</th>
				<th width="40">商品名称</th>
				<th width="60">商品期数</th> 
                                 <th width="60">商品图片</th> 
                                 <th width="60">每人次参与价格</th>
				<th width="10">总需人次</th>
				<th width="90">已参与</th>
                                <th width="90">剩余</th>
				<th width="100">开始时间</th>
                                <th width="70">截止时间</th>
				
				
				
				<th width="50">状态</th>
                                <th width="80">中奖号码</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
				<td><input type="checkbox" value="1" name=""></td>
				<td><?php echo ($vo["id"]); ?></td>
				<td><?php echo ($vo["good_name"]); ?></td>
				<td><?php echo ($vo["good_no"]); ?></td>
                                <td><img src="<?php echo ($vo["good_pic"]); ?>" width="50" height="50"></td>
                                <td><?php echo ($vo["perprice"]); ?></td>
                                <td><?php echo ($vo["neednumber"]); ?></td>
                                <td><?php echo ($vo["joinnumber"]); ?></td>
                                <td><?php echo ($vo["surplusnumber"]); ?></td>
			
				<td><?php echo (date("Y-m-d H:i:s ",$vo['starttime'])); ?></td>
                                <td><?php echo (date("Y-m-d H:i:s ",$vo['endtime'])); ?></td>
                               
				<td class="td1"><?php echo ($a[$vo['status']]); ?></td>
                                <td><?php echo ($vo["winnumber"]); ?></td>
				<td class="td-manage">
					<a style="text-decoration:none"  href="javascript:void(0);" onclick="duobao_edit('修改夺宝活动','<?php echo U('Duobao/edit','eid='.$vo['id']);?>','','510')"><span class="label label-success radius">编辑</span></a>
					<a style="text-decoration:none"  href="javascript:void(0);" onclick="duobao_del(this,'<?php echo ($vo["id"]); ?>')"><span class="label label-success radius">删除</span></a>
					<a style="text-decoration:none"  href="javascript:void(0);" onclick="duobao_edit('夺宝活动手动开奖','<?php echo U('Duobao/handstart','id='.$vo['id']);?>','','510')"><span class="label label-success radius">手动开奖</span></a><?php endforeach; endif; else: echo "" ;endif; ?>
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
		"aaSorting": [[ 1, "desc" ]],//默认第几个排序
		"bStateSave": true,//状态保存
		"aoColumnDefs": [
		  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
		  {"orderable":false,"aTargets":[0,8,9]}// 制定列不参与排序
		]
	});
	
});
/**/
function duobao_edit(title,url,w,h){
	layer_show(title,url,w,h);
}
function duobao_add(title,url,w,h){
	layer_show(title,url,w,h);
}





/*夺宝活动-删除*/
function duobao_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: "<?php echo U('Duobao/delete');?>",
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