<?php /* Smarty version 2.6.14, created on 2013-09-03 17:56:47
         compiled from db_backup.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['warning']): ?>
<ul style="padding:0; margin: 0; list-style-type:none; color: #CC0000;">
  <li style="border: 1px solid #CC0000; background: #FFFFCC; padding: 10px; margin-bottom: 5px;" ><?php echo $this->_tpl_vars['warning']; ?>
</li>
</ul>
<?php endif; ?>
<form  name="theForm" method="post"  action="database.php" onsubmit="return validate()">
<!-- start  list -->
<div class="list-div" id="listDiv">

<table cellspacing='0' cellpadding='0'  class="table">
  <tr>
    <th colspan="2">备份类型</th>
  </tr>
  <tr>
    <td width="126"><input type="radio" name="type" value="full" class="radio" onclick="findobj('showtables').style.display='none'">全部备份</td>
    <td width="1163">备份数据库所有表</td>
  </tr>
  
  <tr>
    <td><input type="radio" name="type" value="custom" class="radio" onclick="findobj('showtables').style.display=''">自定义备份</td>
    <td>根据自行选择备份数据表</td>
  </tr>
  <tbody id="showtables" style="display:none">
  <tr>
    <td colspan="2">
      <table cellspacing='0' cellpadding='0' class="table" width="100%" style="border:0">
        <tr>
          <td colspan="4" style="border:0"><label><input name="chkall" onclick="checkall(this.form, 'customtables[]')" class="radio" type="checkbox"><b>全选</b></label></td>
        </tr>
        <tr>
        <?php $_from = $this->_tpl_vars['tables']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['table_name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['table_name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['table']):
        $this->_foreach['table_name']['iteration']++;
?>
          <?php if ($this->_foreach['table_name']['iteration'] > 1 && ( $this->_foreach['table_name']['iteration']-1 ) % 4 == 0): ?></tr><tr><?php endif; ?>
          <td style="border:0"><input name="customtables[]" value="<?php echo $this->_tpl_vars['table']; ?>
" class="radio" type="checkbox"><?php echo $this->_tpl_vars['table']; ?>
</td>
        <?php endforeach; endif; unset($_from); ?>
        </tr>
      </table></td>
  </tr>
  </tbody>
</table>

<table cellspacing='0' cellpadding='0'  class="table">
  <tr>
    <th colspan="2">其他选项</th>
  </tr>
  
  <tr>
    <td width="200">分卷备份 - 文件长度限制(kb)</td>
    <td width="1087"><input type="text" name="vol_size" value="<?php echo $this->_tpl_vars['vol_size']; ?>
"></td>
  </tr>
  <tr>
    <td>备份文件名</td>
    <td><input type="text" name="sql_file_name" value="<?php echo $this->_tpl_vars['sql_name']; ?>
"></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="hidden" name="act" value="dumpsql" />
    <input type="submit" value="开始备份" class="button" /></td>
    </tr>
</table>
</div>
<!-- end  list -->
</form>


<?php echo '
<script language="JavaScript">
<!--
function findobj(str)
{
    return document.getElementById(str);
}

function checkall(frm, chk)
{
    for (i = 0; i < frm.elements.length; i++)
    {
        if (frm.elements[i].name == chk)
        {
            frm.elements[i].checked = frm.elements[\'chkall\'].checked;
        }
    }
}
//-->
</script>
'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>