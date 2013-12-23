<?php /* Smarty version 2.6.14, created on 2013-09-03 17:55:08
         compiled from header.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo @SITE_NAME; ?>
 - <?php if ($this->_tpl_vars['ur_here']): ?> - <?php echo $this->_tpl_vars['ur_here']; ?>
 <?php endif; ?></title>
<link href="css/global.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.4.2.pack.js" type="text/javascript"></script>
<script src="js/ajax.js" type="text/javascript"></script>
<script src="js/listtable.js" type="text/javascript"></script>
<script src="js/library.js" type="text/javascript"></script>
<script src="../js/Utils.js" type="text/javascript"></script>
</head>
<body>
<h1>
<?php if ($this->_tpl_vars['action_text2']): ?>
<span class="action-span"><a href="<?php echo $this->_tpl_vars['action_href2']; ?>
"><?php echo $this->_tpl_vars['action_text2']; ?>
</a>&nbsp;&nbsp;</span>
<?php endif; ?>
<?php if ($this->_tpl_vars['action_text']): ?>
<span class="action-span"><a href="<?php echo $this->_tpl_vars['action_href']; ?>
"><?php echo $this->_tpl_vars['action_text']; ?>
</a>&nbsp;&nbsp;</span>
<?php endif; ?>
<span class="action-span1"><a href="main.php?act=main"><?php echo @SITE_NAME; ?>
</a> <?php if ($this->_tpl_vars['ur_here']): ?> - <?php echo $this->_tpl_vars['ur_here']; ?>
 <?php endif; ?></span>
<div style="clear:both"></div>
</h1>