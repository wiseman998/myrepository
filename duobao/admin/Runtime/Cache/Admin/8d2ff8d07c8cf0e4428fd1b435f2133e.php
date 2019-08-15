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

<title>会员修改</title>
<meta name="keywords" content="">
<meta name="description" content="">
</head>
<body>
<article class="page-container">
	<form  class="form form-horizontal"   id="form-member-edit" >
                <input type="hidden" name="id" value="<?php echo ($list["id"]); ?>">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>会员名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($list["nickname"]); ?>" placeholder="" id="nickname" name="nickname">
			</div>
		</div>
			<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>真实名字：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($list["realname"]); ?>" placeholder="" id="realname" name="realname">
			</div>
		</div>
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>头像：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="file" class="input-text" value="" placeholder=""  name="headimg">
				<input type="hidden" class="input-text" value="<?php echo ($list["headimg"]); ?>" placeholder=""  name="unlink">
			
			</div>
		</div>
	
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($list["mobile"]); ?>" placeholder="" id="mobile" name="mobile">
			</div>
		</div>
		
		
                <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>微信：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($list["weixin"]); ?>" placeholder=""  name="weixin">
			</div>
		</div>
            
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>支付宝：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($list["alipay"]); ?>" placeholder=""  name="alipay">
			</div>
		</div>
            
                <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>VIP状态：</label>
			<div class="formControls col-xs-8 col-sm-9">
                            <input type="hidden" class="value" value="<?php echo ($list["is_vip"]); ?>">
                            <select name="is_vip" class="lists" >
                                <option value="0"  >否</option>
                                <option value="1">是</option> 
                                    
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
			<input class="btn btn-primary" id="submit1" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
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
    
                        var vipvalue = $('.value').val(); 
                        
                        $(".lists option").each(function(){  
                            var value = $(this).val();  
                            //console.log(value); 
                            if(vipvalue == value){ 
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
	
	$("#form-member-edit").validate({
		rules:{
			nickname:{
				required:true,
				minlength:2,
				maxlength:16
			},
			realname:{
				required:true,
				minlength:2,
				maxlength:4
			},
			mobile:{
				required:true,
				isPhone:true,
			},
                       
			
			
			
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type: 'post',
				url: "<?php echo U('Member/update');?>" ,
				success: function(data){
                                    if(data==0){
                                       layer.msg('电话号码为首数字为非0的11位的有效数字哦!',{icon:1,time:3000}); 
                                    }else{
                                        layer.msg('修改成功!',{icon:1,time:1000});
                                    }
					
				},
                error: function(XmlHttpRequest, textStatus, errorThrown){
					layer.msg('error!',{icon:1,time:1000});
				}
			});
			var index = parent.layer.getFrameIndex(window.name);
			parent.$('.btn-refresh').click();
			
                       // parent.location.reload();
                        //parent.layer.close(index);
		}
	});
});
</script> 
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>