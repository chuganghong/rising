<?php /* Smarty version 2.6.14, created on 2013-09-03 17:54:57
         compiled from login.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo @SITE_NAME; ?>
</title>
<link href="css/global.css" rel="stylesheet" type="text/css" />

<?php echo '
<style type="text/css">
body{background-color: #1B5F8C;}
</style>
'; ?>

</head>
<body>
<div style="width:464px; height:184px; left:50%; margin:-92px 0 0 -232px; position:absolute; top:50%; background:url(images/login_bg.gif) no-repeat top left">
<form method="post" action="index.php" name='login' id="login" onsubmit="return (this.user.value!='' && this.pass.value!='' && this.captcha.value!='')">
	<div style="margin:5px 0 5px 7px"><img src="images/login_title.jpg" /></div>
	<table width="86%" border="0" cellspacing="0" cellpadding="0" align="center" style="padding:4px 0 4px 0; color:#FFF">

      <tr>
        <td>用户名:</td>
        <td colspan="2"><input type="text" name="user" id="user" size="32" value="<?php echo $this->_tpl_vars['para']['user']; ?>
" />
        </td>
        <td rowspan="4" align="right">
        <input id="submit" type="image" src="images/login_submit.jpg" class="btn_submit" /></td>
      </tr>
      <tr>
        <td>密&nbsp;&nbsp;&nbsp;&nbsp;码:</td>
        <td colspan="2"><input type="password" name="pass" id="pass" size="32" value="<?php echo $this->_tpl_vars['para']['pass']; ?>
" />
        </td>
      </tr>
      <tr>
        <td>验证码:</td>
        <td><input type="text" name="captcha" class="captcha" size="10" maxlength="4" autocomplete="off" class="captcha" /></td>
        <td><img src="index.php?act=captcha&<?php echo $this->_tpl_vars['random']; ?>
" width="145" height="20" alt="CAPTCHA" border="1" onclick= "this.src='index.php?act=captcha&'+Math.random()" style="cursor: pointer;" title="点击更新验证码" align="absbottom" /></td>
      </tr>
      <!--
      <tr>
        <td>&nbsp;</td>
        <td><label>
          <input type="checkbox" name="autologin" id="autologin" class="radio" value="1" <?php if ($this->_tpl_vars['para']['autologin']): ?> checked="checked"<?php endif; ?> />自动登录
        </label></td>
        <td style="text-align:right; padding-right:10px"><label>
          <input type="checkbox" name="saveuser" id="saveuser" class="radio" value="1" <?php if ($this->_tpl_vars['para']['saveuser']): ?> checked="checked"<?php endif; ?> />记住我
        </label><input type="hidden" name="act" value="signin" /></td>
      </tr>
      -->
      <input type="hidden" name="act" value="signin" />
    </table>
</form>
</div>
<script>
document.forms['login'].elements['user'].focus();
</script>
</body>
</html>