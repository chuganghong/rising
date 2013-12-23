<?php /* Smarty version 2.6.14, created on 2013-10-29 09:39:44
         compiled from role_list.html */ ?>
<?php if ($this->_tpl_vars['full_page']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="list-div" id="listDiv">
<?php endif; ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <th>角色名称</th>
    <th>角色描述</th>
    <th>人数</th>
    <th>操作</th>
  </tr>
  <?php $_from = $this->_tpl_vars['role_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
  <tr>
    <td><?php echo $this->_tpl_vars['list']['role_name']; ?>
</td>
    <td><?php echo $this->_tpl_vars['list']['role_describe']; ?>
</td>
    <td><?php echo $this->_tpl_vars['list']['num']; ?>
</td>
    <td align="center">
      <a href="admin_user.php?act=list&admin_role=<?php echo $this->_tpl_vars['list']['role_id']; ?>
" title="成员列表">成员列表</a> | 
      <a href="role.php?act=edit&id=<?php echo $this->_tpl_vars['list']['role_id']; ?>
" title="编辑">编辑</a> | 
      <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_tpl_vars['list']['role_id']; ?>
, '您确定要删除这条记录吗?')" title="移除">移除</a></td>
  </tr>
  <?php endforeach; else: ?>
  <tr><td class="no-records" colspan="4">暂无记录</td></tr>
  <?php endif; unset($_from); ?>
</table>

<?php if ($this->_tpl_vars['full_page']): ?>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>