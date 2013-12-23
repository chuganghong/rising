<?php /* Smarty version 2.6.14, created on 2013-10-29 09:39:45
         compiled from admin_logs.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'admin_logs.html', 53, false),)), $this); ?>
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
      <form name="theForm" method="POST" action="admin_logs.php">
      <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
      按IP地址查看
      <select name="admin_ip" onchange="searchAdminIP(this.value)">
      <option value='0'>选择IP地址...</option>
      <?php echo $this->_tpl_vars['ip_list']; ?>

      </select>
      按管理员查看
      <select name="admin_id" onchange="searchAdminID(this.value)">
      <option value='0'>选择管理员...</option>
      <?php echo $this->_tpl_vars['id_list']; ?>

      </select>
      </form>
      </td>
      <td>
      <form name="drop_form" action="admin_logs.php?act=batch_drop" method="POST">
      清除日志
      <select name="log_date">
        <option value='0'>选择清除的日期...</option>
        <option value='1'>一周之前</option>
        <option value='2'>一个月之前</option>
        <option value='3'>三个月之前</option>
        <option value='4'>半年之前</option>
        <option value='5'>一年之前</option>
      </select>
      <input name="drop_type_date" type="submit" value=" 确定 " class="button" />
      </form>
      </td>
    </tr>
</table>
</div>
<form method="POST" action="admin_logs.php?act=batch_drop" name="listForm">
<div class="list-div" id="listDiv">
<?php endif; ?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
    <tr>
      <th><input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox">
 编号</th>
      <th>操作者</th>
      <th>操作日期</th>
      <th>IP地址</th>
      <th>操作记录</th>
    </tr>
    <?php $_from = $this->_tpl_vars['log_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
    <tr>
      <td width="10%"><span><input name="checkboxes[]" type="checkbox" value="<?php echo $this->_tpl_vars['list']['log_id']; ?>
" /> <?php echo $this->_tpl_vars['list']['log_id']; ?>
</span></td>
      <td width="15%" class="first-cell"><span><?php echo ((is_array($_tmp=$this->_tpl_vars['list']['true_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span></td>
      <td width="20%"><span><?php echo $this->_tpl_vars['list']['log_time']; ?>
</span></td>
      <td width="15%"><span><?php echo $this->_tpl_vars['list']['ip_address']; ?>
</span></td>
      <td width="40%"><span><?php echo $this->_tpl_vars['list']['log_info']; ?>
</span></td>
    </tr>
    <?php endforeach; else: ?>
    <tr><td class="no-records" colspan="5">暂无记录</td></tr>
    <?php endif; unset($_from); ?>
    <tr>
      <td colspan="2"><input name="drop_type_id" type="submit" id="btnSubmit" value="清除日志" disabled="true" class="button" /></td>
      <td align="right" nowrap="true" colspan="5"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "page.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
    </tr>
  </table>
<?php if ($this->_tpl_vars['full_page']): ?>
</div>
</form>
<script type="text/javascript" language="javascript">
  <!--
  listTable.recordCount = <?php echo $this->_tpl_vars['record_count']; ?>
;
  listTable.pageCount = <?php echo $this->_tpl_vars['page_count']; ?>
;

  <?php $_from = $this->_tpl_vars['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
  listTable.filter.<?php echo $this->_tpl_vars['key']; ?>
 = '<?php echo $this->_tpl_vars['item']; ?>
';
  <?php endforeach; endif; unset($_from); ?>
  <?php echo '
  /**
   * 查询日志
   */
  function searchAdminIP(admin_ip)
  {
    listTable.filter.admin_ip = admin_ip;
    listTable.filter.page = 1;
    listTable.loadList();
  }
  function searchAdminID(admin_id)
  {
    listTable.filter.admin_id = admin_id;
    listTable.filter.page = 1;
    listTable.loadList();
  }
  '; ?>

  //-->
</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>