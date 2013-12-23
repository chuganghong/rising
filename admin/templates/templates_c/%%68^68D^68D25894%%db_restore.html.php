<?php /* Smarty version 2.6.14, created on 2013-10-29 09:39:58
         compiled from db_restore.html */ ?>
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
<!-- start list -->
<div class="list-div" id="listDiv">
  <form method="post" action="database.php" enctype="multipart/form-data">
  <table cellpadding='0' cellspacing='0' class="table" width="100%">
  <tr>
    <th colspan="2">恢复备份</th>
  </tr>
  <tr>
    <td width="100">本地SQL文件</td>
    <td><input type="file" name="sqlfile" size="50"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="hidden" name = "act" value = "upload_sql"><input type="submit" value=上传并执行SQL语言 class="button"></td>
  </tr>
  </table>
  </form>

</div>
<br />
<br />
<div class="list-div" id="listDiv">
<form action="database.php" name="file_list" method="POST" onsubmit="return confirm('你确定要删除选中数据吗？');" >
<table class="table" cellspacing='0' cellpadding='0' width="100%">
  <tr>
    <th colspan='7'>服务器上备份文件</th>
  </tr>
  <tr>
    <th width='50'><label><input type="checkbox" class="radio" name="chkall" onclick="checkall(this.form, 'file[]')">移除</label></th>
    <th>文件名</th>
    <th width="71">版本</th>
    <th width="208">时间</th>
    <th width="99">大小</th>
    <th width="91">卷</th>
    <th width="30" align="center">操作</th>
  </tr>
  <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
  <tr <?php if ($this->_tpl_vars['item']['mark'] == 2): ?>style="display:none"<?php endif; ?>>
   <td><input type="checkbox" class="radio" name="file[]" value="<?php echo $this->_tpl_vars['item']['name']; ?>
" /></td>
   <td><?php if ($this->_tpl_vars['item']['mark'] == 1): ?><img src="images/menu_plus.gif" onclick="rowClicked(this)"><?php endif;  if ($this->_tpl_vars['item']['mark'] == 2): ?><img src="images/menu_arrow.gif"><?php endif; ?><a href="../data/sqldata/<?php echo $this->_tpl_vars['item']['name']; ?>
"> <?php echo $this->_tpl_vars['item']['name']; ?>
 </a></td>
   <td><?php echo $this->_tpl_vars['item']['ver']; ?>
</td>
   <td><?php echo $this->_tpl_vars['item']['add_time']; ?>
</td>
   <td><?php echo $this->_tpl_vars['item']['file_size']; ?>
</td>
   <td>vol:<?php echo $this->_tpl_vars['item']['vol']; ?>
</td>
   <td align="center"><?php if ($this->_tpl_vars['item']['mark'] != 2): ?><a href="database.php?act=import&file_name=<?php echo $this->_tpl_vars['item']['name']; ?>
">[导入]</a><?php else: ?>&nbsp;<?php endif; ?></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?>
  <tr>
    <td height="23" colspan='7' align="center"><input type="hidden" name="act" value="remove"><input type="submit" value="删除" class="button" /></td>
  </tr>
</table>
</form>
</div>
<?php echo '
<script language="JavaScript">
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

function rowClicked(obj)
{
  var row = obj.parentNode.parentNode;
  var tbl = row.parentNode.parentNode;
  var test = false;
  var img = \'\';

  if (obj.src.substr(obj.src.lastIndexOf(\'/\') + 1) == "menu_minus.gif")
  obj.src = "images/menu_plus.gif";
  else
  obj.src = "images/menu_minus.gif";



  for (i = 0; i < tbl.rows.length; i++)
  {
    var cell = tbl.rows[i].cells[1];

    if (cell && cell.childNodes[0].src)
    {
      img = cell.childNodes[0].src.substr(cell.childNodes[0].src.lastIndexOf(\'/\') + 1);
    }
    else
    {
      img = \'\';
    }

    if (test && img)
    {
      if (img == "menu_arrow.gif")
      {
        tbl.rows[i].style.display = tbl.rows[i].style.display != \'none\' ? \'none\' : (Browser.isIE) ? \'block\' : \'table-row\';
      }
      else
      {
        test=false;
      }
    }

    if (tbl.rows[i] == row)
    {
      test = true;
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