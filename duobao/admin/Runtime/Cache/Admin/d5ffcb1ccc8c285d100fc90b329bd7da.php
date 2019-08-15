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
<title>提现管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 提现中心 <span class="c-gray en">&gt;</span> 提现管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	
	
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="20">ID</th>
                                <th width="60">会员名</th> 
                                <th width="60">头像</th>
                                <th width="60">手机号</th>
				<th width="40">提现金额</th>
				<th width="60">手续费</th> 
                                 <th width="60">实际到账金额</th> 
				
                                <th width="80">提现类型</th>
                                 <th width="80">提现方式</th>
                                 <th width="80">状态</th> 
				<th width="80">申请时间</th>
                              
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
				<td><input type="checkbox" value="1" name=""></td>
				<td><?php echo ($vo["id"]); ?></td>
                                <td><?php echo ($vo["name"]); ?></td>
                                <td><img src="<?php echo ($vo["user_headimg"]); ?>" width="50px" height="50px"></td>
                                <td><?php echo ($vo["user_phone"]); ?></td>
				<td><?php echo ($vo["money"]); ?></td>
				<td><?php echo ($vo["fee"]); ?></td>
                                <td><?php echo ($vo["realmoney"]); ?></td>
                                <td><?php echo ($a[$vo['type1']]); ?></td>
                                <td><?php echo ($b[$vo['type2']]); ?></td>
                                <td><?php echo ($c[$vo['status']]); ?></td>
                                <td><?php echo (date("Y-m-d H:i:s ",$vo["applytime"])); ?></td>
                                
                               
				
				<td class="td-manage">
					<a style="text-decoration:none"  href="javascript:void(0);" onclick="withdraw_detail('查看提现详情','<?php echo U('Withdrawlog/detail','id='.$vo['id']);?>','','510')"><span class="label label-success radius">详情</span></a>
					<a style="text-decoration:none"  href="javascript:void(0);" onclick="withdraw_confirm(this,'<?php echo ($vo["id"]); ?>')"><span class="label label-success radius">确认</span></a>
					<a style="text-decoration:none"  href="javascript:void(0);" onclick="withdraw_refuse(this,'<?php echo ($vo["id"]); ?>')"><span class="label label-success radius">拒绝</span></a><?php endforeach; endif; else: echo "" ;endif; ?>
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
		  {"orderable":false,"aTargets":[0,7]}// 制定列不参与排序
		]
	});
	
});

function withdraw_detail(title,url,w,h){
	layer_show(title,url,w,h);
}

/**/
function withdraw_confirm(obj,id){
	layer.confirm('提现信息已无误，真的要批准此次提现申请吗？',function(index){
		$.ajax({
			type: 'POST',
			url: "<?php echo U('Withdrawlog/confirm');?>",
			data:{id:id},
			dataType: 'json',
			success: function(data){
				if(data==1){
                                   layer.msg('已确认!',{icon:1,time:1000}); 
                                }else if(data==0){
                                    layer.msg('确认失败!',{icon:1,time:1000});
                                }else if(data==2){
                                    layer.msg('已拒绝的无法再次确认！',{icon:1,time:2000});
                                }else if(data==3){
                                    layer.msg('请勿重复确认！',{icon:1,time:2000});
                                }
				
			},
			error:function(data) {
				layer.msg('确认失败!',{icon:1,time:1000});
			},
		});		
	});
}

function withdraw_refuse(obj,id){
	layer.confirm('难道你真的要残忍地拒绝此次提现申请吗？',function(index){
		$.ajax({
			type: 'POST',
			url: "<?php echo U('Withdrawlog/refuse');?>",
			data:{id:id},
			dataType: 'json',
			success: function(data){
				if(data==1){
                                    layer.msg('已拒绝!',{icon:1,time:1000});
                                }else if(data==0){
                                    layer.msg('拒绝失败!',{icon:1,time:1000});
                                }else if(data==2){
                                    layer.msg('已确认的无法再次进行拒绝操作!',{icon:1,time:2000});
                                }else if(data==3){
                                    layer.msg('请勿重复拒绝！',{icon:1,time:2000});
                                }
				
			},
			error:function(data) {
				layer.msg('拒绝失败!',{icon:1,time:1000});
			},
		});		
	});
}










</script> 
</body>
</html>