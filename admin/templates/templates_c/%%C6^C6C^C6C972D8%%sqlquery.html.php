<?php /* Smarty version 2.6.14, created on 2013-10-29 09:40:01
         compiled from sqlquery.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

  <form name="sqlFrom" method="post" action="" onsubmit="return validate()">
  <table class="table" border="0" cellpadding="0" cellspacing="0">
    <tr><th width="1385">运行 SQL 查询</th>
    </tr>
    <tr><td><span style="color: rgb(255, 0, 0);"><strong>执行SQL将直接操作数据库，请谨慎使用</strong></span></td></tr>
    <tr><td><textarea name="sql" rows="6" cols="80"><?php echo $this->_tpl_vars['sql']; ?>
</textarea></td></tr>
    <tr><td><input type="hidden" name="act" value="query"> <input type="submit" name="button" id="button" class="button" value=" 提交查询 " /></td>
    </tr>
  </table>
  </form>


<!-- start SQL list -->
<div class="list-div" id="listDiv">
  <?php if ($this->_tpl_vars['type'] == 0): ?>
  <!-- 出错提示-->
  <span style="color: rgb(255, 0, 0);"><strong>:</strong></span><br />
  <?php echo $this->_tpl_vars['error']; ?>

  <?php endif; ?>
  <?php if ($this->_tpl_vars['type'] == 1): ?>
  <!-- 执行成功-->
  <center><h3>SQL执行成功</h3></center>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['type'] == 2): ?>
  <!--有返回值-->
    <?php echo $this->_tpl_vars['result']; ?>

  <?php endif; ?>
</div>
<script language="JavaScript">
<!--
<?php echo '
document.forms[\'sqlFrom\'].elements[\'sql\'].focus();



/**
 * 检查表单输入的数据
 */
function validate()
{
  var frm = document.forms[\'sqlFrom\'];
  var sql = frm.elements[\'sql\'].value;
  var msg =\'\';

  if (sql.length == 0 )
  {
    msg += "SQL语句不能为空\\n";
  }

  if (msg.length > 0)
  {
    alert (msg);
    return false;
  }

  return true;
}
//-->
'; ?>

</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>