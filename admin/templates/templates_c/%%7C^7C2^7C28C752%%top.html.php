<?php /* Smarty version 2.6.14, created on 2013-09-03 17:55:08
         compiled from top.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo @SITE_NAME; ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/global.css" rel="stylesheet" type="text/css" />
<?php echo '
<style type="text/css">
#header{ height:52px; background:url(images/bg.png) 0 0 repeat-x; overflow:hidden; padding:5px;}

	#header a{color:#45649E;}
	#header span{color:#FF6600;}
	#header strong{color:#333333; font-size:14px;}

	#header-logo{float:left; margin:-5px 0; background:url(images/bg.png) 0 -80px repeat-x; width:170px; height:42px; padding:10px; font-family:"Microsoft YaHei"; color:#999; padding-top:31px; text-align:center; margin-left:-5px }
		
	#header-info{ float:left;margin:3px 0; line-height:22px; width:400px; color:#666;}
		
	#header-tool{text-align:right; width:350px; float:right;margin:3px;color:#999; line-height:22px;}
		#header-tool .extra{ background:url(images/bg.png) -100px -600px repeat-x; width:75px; height:23px; text-align:center; line-height:23px; display:block; float:left; position:absolute;}
	
	#header-menu{ position:absolute; padding:3px; overflow:auto; overflow-x:hidden; border:#599CE0 solid 1px; background:#fff;  background_:#fff url(images/bg.png) -10px -640px no-repeat;}
		#header-menu div{ background:#E9F3FD; padding:5px; clear:both; font-weight:bold;}
		#header-menu ul{ margin:5px 0; line-height:20px; clear:both; width:300px; background:#fff;}
			#header-menu ul li{ float:left; width:25%; text-align:center; background:#fff;}
			#header-menu ul li.active{ background:#ccc;}
			#header-menu ul li a{ text-decoration:underline;}
</style>
<script type="text/javascript">
function modalDialog(url, name, width, height)
{
  if (width == undefined)
  {
    width = 400;
  }
  if (height == undefined)
  {
    height = 300;
  }

  if (window.showModalDialog)
  {
    window.showModalDialog(url, name, \'dialogWidth=\' + (width) + \'px; dialogHeight=\' + (height+5) + \'px; status=off\');
  }
  else
  {
    x = (window.screen.width - width) / 2;
    y = (window.screen.height - height) / 2;

    window.open(url, name, \'height=\'+height+\', width=\'+width+\', left=\'+x+\', top=\'+y+\', toolbar=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, modal=yes\');
  }
}
</script>
'; ?>

</head>
<body>
<div id="header">
	<div id="header-logo"></div>
    <div id="header-info">
    	<div id="header-status"><strong><?php echo $_SESSION['admin_true']; ?>
</strong> 
        	<span><?php echo $this->_tpl_vars['role']; ?>
</span> | 
            <a href="index.php?act=logout" target="_top" class="fix-submenu">退出</a>
        </div>
        <a href="message.php?act=list" target="main-frame">管理员留言</a>
        - <a href="admin_user.php?act=pass&id=<?php echo $_SESSION['admin_id']; ?>
" target="main-frame">修改密码</a>
		- <a href="javascript:window.top.frames['main-frame'].document.location.reload();window.top.frames['header-frame'].document.location.reload();window.top.frames['menu-frame'].document.location.reload()">刷新</a>
    </div>
    <div id="header-tool">
    	<a href="http://site.mopland.com" target="_blank"><span>网址导航</span></a>
        | <a href="http://www.taobao.com/" target="_blank">淘宝</a>
		| <a href="http://www.google.com/" target="_blank">Google</a>
		<a href="http://adsense.google.com/" target="_blank">Adsense</a>
		<a href="http://www.gmail.com/" target="_blank">Gmail</a>
        | <a href="http://www.baidu.com/" target="_blank">百度</a> 
		<a href="http://image.baidu.com/" target="_blank">图片</a> 
		<br>
        <a href="../" target="_blank"><span>查看网站</span></a>
        | <a href="javascript:modalDialog('main.php?act=calculate', 'calculator', 340, 250)">计算器</a>
        | <a href="main.php?act=clear_cache" target="main-frame"><span>清除缓存</span></a>
    </div>
</div>
<div id="load-div" style="padding:5px; margin:0 auto; width:140px; margin-top:-40px;text-align:center; display:none; color: #FF9900; background-color:#003399">
	<img src="images/top_loader.gif" width="16" height="16" alt="正在处理您的请求..." style="vertical-align: middle" /> &nbsp;&nbsp;正在处理您的请求...
</div>
</body>
</html>