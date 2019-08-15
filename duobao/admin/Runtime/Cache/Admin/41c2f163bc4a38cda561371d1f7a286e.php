<?php if (!defined('THINK_PATH')) exit();?><!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="/Public/Admin/favicon.ico" >
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
<!--/meta 作为公共模版分离出去-->

<title>夺宝活动手动开奖</title>
<meta name="keywords" content="">
<meta name="description" content="">
</head>
<body>
<article class="page-container">
	<form  class="form form-horizontal" id="form-duobao-edit" >
                <input hidden="hidden" name="id" value="<?php echo ($list["id"]); ?>">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>商品名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($list["good_name"]); ?>" disabled="disabled" >
			</div>
		</div>
			<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>商品期数：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($list["good_no"]); ?>" disabled="disabled" >
			</div>
		</div>
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>商品图片：</label>
			<div class="formControls col-xs-8 col-sm-9">
                            <img src="<?php echo ($list["good_pic"]); ?>" width="50px" height="50px" />
			</div>
		</div>
                
                
	
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>总需人次：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($list["neednumber"]); ?>" placeholder="" disabled="disabled" >
			</div>
		</div>
                <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>已参与人次：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($list["joinnumber"]); ?>" placeholder="" disabled="disabled" >
			</div>
		</div>
                <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>剩余人次：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($list["surplusnumber"]); ?>" placeholder="" disabled="disabled" >
			</div>
		</div>
                
		
		
                <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>开始时间：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo (date("Y-m-d H:i:s ",$list['starttime'])); ?>" disabled="disabled" >
			</div>
		</div>
            
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>截止时间：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo (date("Y-m-d H:i:s ",$list['endtime'])); ?>" disabled="disabled"  >
			</div>
		</div>
            
                <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>状态：</label>
			<div class="formControls col-xs-8 col-sm-9">
                            <input type="hidden" class="value" value="<?php echo ($list["status"]); ?>">
                            <select name="status" class="lists" disabled="disabled" >
                                <option value="0"  >抢购中</option>
                                <option value="1">已结束</option> 
                                    
                                </select>
			</div>
		</div>
                <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>指定用户中奖：</label>
			<div class="formControls col-xs-8 col-sm-9">
                            
                            <select name="user_id" class="lists"  >
                                <?php if(is_array($joinmembers)): $i = 0; $__LIST__ = $joinmembers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><option value="<?php echo ($user["id"]); ?>"><?php echo ($user["nickname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    
                                </select>
			</div>
		</div>
            
                
		
		
		
		
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary" id="submit" type="submit" style="display:none" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<input class="btn btn-primary" id="submit1" type="submit" value="&nbsp;&nbsp;开奖&nbsp;&nbsp;">
		</div>
	</div>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/Admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/Admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/Public/Admin/static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="/Public/Admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本--> 
<script type="text/javascript" src="/Public/Admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/Public/Admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script> 
<script type="text/javascript" src="/Public/Admin/lib/jquery.validation/1.14.0/validate-methods.js"></script> 
<script type="text/javascript" src="/Public/Admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">

$(function(){
    
                        var statusvalue = $('.value').val(); 
                        
                        $(".lists option").each(function(){  
                            var value = $(this).val();  
                            //console.log(value); 
                            if(statusvalue == value){ 
                                $(this).attr('selected','selected');  
                            }  
                        });  
                        
                   

	$("#submit1").click(function(){
		$("#submit").click();
		//parent.location.reload();
		
	});
	
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	
	$("#form-duobao-edit").validate({
		rules:{
			id:{
                            required:true
                        }
				
			},
			
			
			
			
			
		
		
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type: 'post',
				url: "<?php echo U('Duobao/handstart');?>" ,
				success: function(data){
                                    if(data==0){
                                       layer.msg('该夺宝活动尚不满足手动开奖条件',{icon:1,time:3000}); 
                                    }else if(data==1){
                                        layer.msg('开奖成功',{icon:1,time:1000});
                                    }else if(data==2){
                                        layer.msg('开奖失败',{icon:1,time:2000});
                                    }
					
				},
                error: function(XmlHttpRequest, textStatus, errorThrown){
					layer.msg('开奖错误!',{icon:1,time:1000});
				}
			});
                        var index = parent.layer.getFrameIndex(window.name);
			parent.$('.btn-refresh').click();
		}
	});
});
</script> 
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>