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
            	<p>上午好，<a href="#">会员名称</a> 丨 <a href="#">个人中心</a></p>
                <div class="menu">
				<?php foreach($link as $v): ?>
                	<span><a href="<?php echo $v['action_name']; ?>"><?php echo $v['cat_name']; ?></a></span>                    
				<?php endforeach; ?>
                    |<span><a href="#">订阅</a></span>
                </div>
            </div>
        </div>
        <div class="index">
        	<div class="nav">
			<?php 
			foreach($topic as $k=>$v):
				$ftopic = $v[0];    //一级栏目
				$stopic = $v[1];    //二级栏目
				if($k==$cur)
				{
					echo '<span class="cur"  >';
				}
				else
				{
					echo '<span>';
				}
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