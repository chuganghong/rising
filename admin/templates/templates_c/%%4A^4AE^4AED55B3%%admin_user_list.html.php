<?php /* Smarty version 2.6.14, created on 2013-10-29 09:39:46
         compiled from admin_user_list.html */ ?>
<?php if ($this->_tpl_vars['full_page']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="form-div">
<table>
    <tr>
      <td width="50%">
      <form name="theForm" method="POST" action="admin_user.php?act=list">
      <img src="images/icon_search.gif" width="26" height="22" border="0" alt="srarch" />
      按所属角色查看
      <select name="admin_role" onchange="this.form.submit()">
      <option value='0'>选择角色...</option>
		<?php echo $this->_tpl_vars['role_list']; ?>

      </select>
      </td>
</table>
</div>
<div class="list-div" id="listDiv">
<?php endif; ?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
    <tr>
      <th>用户名</th>
      <th>真实姓名</th>
      <th>所属角色组</th>
      <th>Email地址</th>
      <th>加入时间</th>
      <th>最后登录时间</th>
      <th>操作</th>
    </tr>
    <?php $_from = $this->_tpl_vars['admin_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['admin']):
?>
    <tr>
      <td class="first-cell"><?php echo $this->_tpl_vars['admin']['user_name']; ?>
</td>
      <td><?php echo $this->_tpl_vars['admin']['true_name']; ?>
</td>
      <td><?php echo $this->_tpl_vars['admin']['role_name']; ?>
</td>
      <td><?php echo $this->_tpl_vars['admin']['email']; ?>
</td>
      <td align="left"><?php echo $this->_tpl_vars['admin']['add_time']; ?>
</td>
      <td align="left"><?php echo $this->_tpl_vars['admin']['last_login']; ?>
</td>
      <td align="center">
      	<a href="admin_user.php?act=edit&id=<?php echo $this->_tpl_vars['admin']['user_id']; ?>
" title="权限">权限</a> |
        <a href="admin_logs.php?act=list&admin_id=<?php echo $this->_tpl_vars['admin']['user_id']; ?>
" title="日志">日志</a> |
        <a href="admin_user.php?act=edit&id=<?php echo $this->_tpl_vars['admin']['user_id']; ?>
" title="编辑">编辑</a> |
        <a href="admin_user.php?act=pass&id=<?php echo $this->_tpl_vars['admin']['user_id']; ?>
" title="修改密码">修改密码</a> |
        <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_tpl_vars['admin']['user_id']; ?>
, '您确认要删除这要记录吗?')" title="删除">移除</a> 
      </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
  </table>
<!-- end brand list -->
<?php if ($this->_tpl_vars['full_page']): ?>
</div>
<script type="text/javascript">
listTable.filter.admin_role = document.forms['theForm'].elements['admin_role'].value;
</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>