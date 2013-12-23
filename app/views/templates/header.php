<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Rising</title>
<link href="<?php echo $pre; ?>public/css/reset.css" type="text/css" rel="stylesheet" />
<link href="<?php echo $pre; ?>public/css/layout.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $pre; ?>public/js/jquery.min.js"></script>
<script src="<?php echo $pre; ?>public/js/common.js" type="text/javascript"></script>
<script src="<?php echo $pre; ?>public/js/jquery.cookie.js" type="text/javascript"></script>
</head>

<body>
	<div class="wrap">
		<div class="head">
        	<div class="logo"><a href="<?php echo $pre; ?>"><img src="<?php echo $pre; ?>public/images/index_03.jpg" /></a></div>
            <div class="banner">
            	<!--<p>上午好，<a href="#">会员名称</a> 丨 <a href="#">个人中心</a></p>-->				
                <div class="menu">
				<?php foreach($link as $v): ?>
                	<span><a href="<?php echo $v['action_name']; ?>"><?php echo $v['cat_name']; ?></a></span>                    
				<?php endforeach; ?>
                    |<span><a href="#" class="booknow">订阅</a></span>
					
					<div class="book">
                    		<div class="btitle">
                            	<img src="<?php echo $pre; ?>public/images/book_03.jpg" />
                                <span>
                                	<b>订阅登记我们</b>
                                    <p>我们将定期为你发送最新最快的资讯</p>
                                </span>
                            </div>
							<form <!--action="http://localhost/rising/index.php/book/action"--> method="POST" id="bookForm">
                            <table cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td>姓名</td>
                                    <td><input type="text" name="username"  class="btxt" id="username"/></td>
                                </tr>
                                <tr>
                                	<td>公司</td>
                                    <td><input type="text" name="company"   class="btxt" id="company"/></td>
                                </tr>
                                <tr>
                                	<td>职位</td>
                                    <td><input type="text" name="job"  class="btxt" id="job"/></td>
                                </tr>
                                <tr>
                                	<td>电话</td>
                                    <td><input type="text" name="phone"   class="btxt" id="phone"/></td>
                                </tr>
                                <tr>
                                	<td>邮箱</td>
                                    <td><input type="text" name="email"  class="btxt" id="email"/></td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td><input type="button" value="提交"  class="bbutton" id="sbook"/></td>
                                </tr>
                            </table>
							</form>
                    </div>
					
					
                </div>
            </div>
        </div>
        <div class="index">
        	<div class="nav">
			<?php 
			foreach($topic as $k=>$v):
				$ftopic = $v[0];    //一级栏目
				$stopic = $v[1];    //二级栏目
				/*
				if($k==$cur)
				{
					//echo '<span class="cur"  >';
					echo '<span>';
				}
				else
				{
					echo '<span>';
				}
				*/
				echo '<span>';
			?>
				<a href="<?php echo $ftopic['action_name']; ?>"><?php echo $ftopic['cat_name']; ?></a>
                	<div class="subnav">
					<?php
					foreach($stopic as $kk=>$vv):
					if($kk == 0):
					?>
					<p class="cur"><a href="<?php echo $vv['action_name']; ?>"><?php echo $vv['cat_name']; ?></a></p>
					<?php
					else:
					?>
					<p><a href="<?php echo $vv['action_name']; ?>"><?php echo $vv['cat_name']; ?></a></p>
                    <?php
					endif;
					endforeach;
					?>                        
                        <br />
					</div>
                </span>
			<?php endforeach; ?>            	
            </div>