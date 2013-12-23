<?php /* Smarty version 2.6.14, created on 2013-09-03 17:55:08
         compiled from menu.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo @SITE_NAME; ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/global.css" rel="stylesheet" type="text/css" /> 
<script src="js/jquery-1.4.2.pack.js" type="text/javascript"></script>
<?php echo '
<style>
body{background:#FFFFFF}
#sidebar-search{ padding:5px; line-height:25px;}
	#sidebar-search ul{ padding:0; margin:0;}
		#sidebar-search li{ float:left; width:33.333%; text-align:center;}
		#sidebar-search img{ width:16px;}
		
#sidebar-menu{}		
	#menu-title{ background:#DEEAF8; border-top:#4C94EA solid 1px; padding:5px 10px 0 10px; font-weight:bold; overflow:hidden;}
		#menu-title strong{ background:#fff; float:left; padding:5px 10px; color:#666666;}
		#menu-title span{ float:right; cursor:pointer; width:8px; height:9px; margin:6px 5px; background:url(images/bg.png) -10px -160px no-repeat}
		#menu-title span.active{background:url(images/bg.png) -10px -200px no-repeat;}

/*link*/
.menu-link{margin:3px 5px; overflow:auto; overflow-x:hidden; color:#1E5494; clear:both; }
	
	.menu-link div{font-weight:bold;line-height:25px;border-bottom:#ddd solid 1px;padding-left:20px;cursor:pointer;background:url(images/bg.png) -165px -193px no-repeat;}
	.menu-link div.active{ background:url(images/bg.png) -165px -153px no-repeat; }
	
	.menu-link ul{ display:none;}
		.menu-link ul li{line-height:25px;}
			.menu-link ul li a{ text-decoration:none; display:block;width:100%; text-indent:20px;}
				.menu-link ul li a:hover{ background:#CCE0F5 url(images/bg.png) right -220px no-repeat;}
				
		.menu-link ul li.active a{color:#fff; text-decoration:none;}
			.menu-link ul li.active a:hover,.menu-link ul li.active a:link,.menu-link ul li.active a:visited{background-color:#1E5494;}
</style>
'; ?>

<script>
<?php echo '
$(document).ready(function(){					   
	$("#menu-title span").click(
		function(){
			if ($(".menu-link div").attr("class") == "active"){
					$(".menu-link ul").hide();
					$(".menu-link div").each(function(i){
						$(".menu-link div").eq(i).removeClass("active");
					});
					$(this).attr("class","");
					$(this).attr("title","点击展开全部菜单")}
			else {
					$(".menu-link ul").show();
					$(".menu-link div").each(function(i){
						$(".menu-link div").eq(i).addClass("active");
					});
					$(this).attr("class","active");
					$(this).attr("title","点击收缩全部菜单")}
		}
	);
	$(".menu-link div").click(
		function(){
			if ($(this).attr("class") == "active" ) {
				$(this).removeClass("active");
				$(this).next().css("display","none");
			}
			else {
				$(this).addClass("active");
				$(this).next().css("display","block");
			}
		}
	);
	$(".menu-link a").click(
		function(){
			window.top.frames["main-frame"].location.href=$(this).attr("rel");
			$(".menu-link li").each(function(i){
				if ($(".menu-link li").eq(i).attr("class") == "active")
					$(".menu-link li").eq(i).removeClass("active");
			});
			$(this).blur();
			$(this).parent().addClass("active");
			$(this).parent().parent().css("display","block");
		}	  
	)
})
/*
function changeMenu(obj,url)
{
	if (url)
	{
		var u=url.toLowerCase();
		window.top.frames["main-frame"].location.href=url;
	}
	var li=document.getElementById("menu-link").getElementsByTagName("li");
	var len = li.length;
	for(var i=0;i<len;i++){
		var Tag_a=li[i].getElementsByTagName("a")[0];
		if(Tag_a){
			li[i].className=\'\';
		}
	}

	obj.blur();
	var li=obj.parentNode;
	li.className=\'active\';
	var ul=li.parentNode;
	if(ul.previousSibling && ul.previousSibling.nodeName !="#text"){
		if(ul.tagName=="UL"){
			ul.style.display="block";
		}
	}	
}*/
'; ?>

</script>
</head>
<body>
<div id="sidebar-search">
	<ul>
    	<li>
        <img src="images/icons/home_16.png" title="" alt="" align="absmiddle"  />
        <a href='main.php?act=main' target="main-frame">首页</a></li>
        <li>
        <img src="images/icons/folder_16.png" title="" alt="" align="absmiddle"  />
        <a href="#" target="main-frame">文件</a></li>
        <li>
        <img src="images/icons/user_16.png" title="" alt="" align="absmiddle"  />
        <a href="member.php?act=list" target="main-frame">用户</a></li>
    </ul>
</div>
<div class="clear"></div>
<div id="sidebar-menu">
    <div id="menu-title">
        <span></span>
        <strong>-系统管理菜单-</strong>
    </div>
    <?php $_from = $this->_tpl_vars['menus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['menu']):
?>
    <div class="menu-link">
    	<div><span><?php echo $this->_tpl_vars['menu']['label']; ?>
</span></div>
        <?php if ($this->_tpl_vars['menu']['children']): ?>
        <ul>
        	<?php $_from = $this->_tpl_vars['menu']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?>
            <li><a href='javascript:void(0);' rel='<?php echo $this->_tpl_vars['child']['action']; ?>
'><?php echo $this->_tpl_vars['child']['label']; ?>
</a></li>
            <?php endforeach; endif; unset($_from); ?>
        </ul>
        <?php endif; ?>
    </div>
    <?php endforeach; endif; unset($_from); ?>
</div>
</body>
</html>
