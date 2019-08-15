


$(function(){
		 var w= $(window).width();
          var h= $(window).height();
		 $(".fugai").css({width:w+"px",
					   height:h+"px"});
		
		
		 
		   })

//密码判断
function massage(str,url){
	var w=$(window).width();
	$(".fugai").fadeIn(1)
	$(".msg").html(str).css({left:w/2-150+"px",
							display:"block"}).animate({opacity:1,filter:"alpha(opacity=100)",top:"200px"},1000)
	setTimeout(function(){
	$(".msg").animate({opacity:0,filter:"alpha(opacity=0)",top:"400px"},1000).fadeOut(1000);
	$(".fugai").fadeOut(1)
	if (url=='-1'){
		 history.go(-1)
		}else{
		document.location.href=url;
			}
						},3000)

	}

//顶部功能菜单
$(function(){
		$(".top_menu").hover(function(){
		       $(this).find("#t_menu").attr("src","img/t_menu1.png")
			   $(".top_menus").slideDown(100)
									},function(){
				$(this).find("#t_menu").attr("src","img/t_menu.png")	
				$(".top_menus").slideUp(100)
										})   
		   })



