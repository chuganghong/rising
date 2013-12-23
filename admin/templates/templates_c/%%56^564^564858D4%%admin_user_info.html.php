<?php /* Smarty version 2.6.14, created on 2013-12-05 17:10:05
         compiled from admin_user_info.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery.validationEngine.js" type="text/javascript"></script>
<script src="../js/jquery.validationEngine-cn.js" type="text/javascript"></script>
<?php echo '
<script type="text/javascript">
$(document).ready(function() {
	$("#theForm").validationEngine();
});
</script>
'; ?>

<div class="main-div">
<form method="post" id="theForm">
<table cellspacing="1" cellpadding="3" width="90%">
  <?php if ($this->_tpl_vars['action'] == 'add' || $this->_tpl_vars['action'] == 'edit'): ?>
  <tr>
    <td class="label">用户名</td>
    <td><input type="text" name="user_name" id="user_name" maxlength="20" size="34" value="<?php echo $this->_tpl_vars['user']['user_name']; ?>
" class="validate[required,custom[noSpecialCaracters],length[0,20],ajax[ajaxUser]]" /><font color="red"> * </font></td>
  </tr>
  <tr>
    <td class="label">真实名称</td>
    <td><input type="text" name="true_name" id="true_name" maxlength="20" size="34" value="<?php echo $this->_tpl_vars['user']['true_name']; ?>
" class="validate[required,custom[chinese],length[0,20]]" /><font color="red"> * </font></td>
  </tr>
  <tr>
    <td class="label">Email地址</td>
    <td><input type="text" name="email" id="email" size="34" value="<?php echo $this->_tpl_vars['user']['email']; ?>
" /></td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['action'] == 'add'): ?>
  <tr>
    <td class="label">密  码</td>
    <td><input type="password" name="password" id="password" maxlength="32" size="34" class="validate[required,length[6,11]]" /><font color="red"> * </font></td>
  </tr>
  <tr>
    <td class="label">确认密码</td>
    <td><input type="password" name="pwd_confirm" id="pwd_confirm" maxlength="32" size="34" class="validate[required,confirm[password]]" /><font color="red"> * </font></td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['action'] == 'add' || $this->_tpl_vars['action'] == 'edit'): ?>
  <tr>
    <td class="label">所属角色</td>
    <td>
      <select name="admin_role" id="admin_role" class="validate[required]">
        <option value=''>选择角色...</option>
		<?php echo $this->_tpl_vars['role_list']; ?>

      </select><font color="red"> * </font>
    </td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['action'] == 'pass'): ?>
  <tr>
    <td class="label">旧密码</td>
    <td><input type="password" name="old_password" id="old_password" maxlength="32" size="34" class="validate[required,length[6,11],ajax[ajaxPass]]" /><font color="red"> * </font><br /><span class="notice-span">如果要修改密码,请先填写旧密码</span></</td>
  </tr>
  <tr>
    <td class="label">新密码</td>
    <td><input type="password" name="new_password" id="new_password" maxlength="32" size="34" class="validate[required,length[6,11]]" /><font color="red"> * </font></td>
  </tr>
  <tr>
    <td class="label">确认密码</td>
    <td><input type="password" name="pwd_confirm" id="pwd_confirm" maxlength="32" size="34" class="validate[required,confirm[new_password]]" /><font color="red"> * </font></td>
  </tr>
  <?php endif; ?>
  <tr>
    <td colspan="2" align="center"><br />
      <input type="submit" class="button" value="确定" />
      <input type="reset" class="button" value="重置" />
      <input type="hidden" name="act" value="<?php echo $this->_tpl_vars['form_act']; ?>
" />
      <input type="hidden" name="id" id="admin_id" value="<?php echo $this->_tpl_vars['user']['user_id']; ?>
" />
    </td>
  </tr>
</table>
</form>
</div>
<script language="JavaScript">
<!--
<?php if ($this->_tpl_vars['action'] != 'pass'): ?>
document.forms['theForm'].elements['user_name'].focus();
/**
 * 检查表单输入的数据
 */
<?php endif; ?>
//-->
</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>