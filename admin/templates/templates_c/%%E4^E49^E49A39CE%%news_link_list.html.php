<?php /* Smarty version 2.6.14, created on 2013-12-17 10:59:51
         compiled from news_link_list.html */ ?>
<?php if ($this->_tpl_vars['full_page']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="list-div" id="listDiv">
<?php endif; ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" id="list-table" class="table">
    <tr>
      <th>栏目名称</th>
<!--      <th>栏目名称）</th>
-->      <th>URL</th>
      <!--<th>导航栏</th>-->
      <th>排序</th>
      <th>操作</th>
    </tr>
    <?php unset($this->_sections['por']);
$this->_sections['por']['name'] = 'por';
$this->_sections['por']['loop'] = is_array($_loop=$this->_tpl_vars['Caseloca']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['por']['show'] = true;
$this->_sections['por']['max'] = $this->_sections['por']['loop'];
$this->_sections['por']['step'] = 1;
$this->_sections['por']['start'] = $this->_sections['por']['step'] > 0 ? 0 : $this->_sections['por']['loop']-1;
if ($this->_sections['por']['show']) {
    $this->_sections['por']['total'] = $this->_sections['por']['loop'];
    if ($this->_sections['por']['total'] == 0)
        $this->_sections['por']['show'] = false;
} else
    $this->_sections['por']['total'] = 0;
if ($this->_sections['por']['show']):

            for ($this->_sections['por']['index'] = $this->_sections['por']['start'], $this->_sections['por']['iteration'] = 1;
                 $this->_sections['por']['iteration'] <= $this->_sections['por']['total'];
                 $this->_sections['por']['index'] += $this->_sections['por']['step'], $this->_sections['por']['iteration']++):
$this->_sections['por']['rownum'] = $this->_sections['por']['iteration'];
$this->_sections['por']['index_prev'] = $this->_sections['por']['index'] - $this->_sections['por']['step'];
$this->_sections['por']['index_next'] = $this->_sections['por']['index'] + $this->_sections['por']['step'];
$this->_sections['por']['first']      = ($this->_sections['por']['iteration'] == 1);
$this->_sections['por']['last']       = ($this->_sections['por']['iteration'] == $this->_sections['por']['total']);
?>
    <tr align="center" class="<?php echo $this->_tpl_vars['Caseloca'][$this->_sections['por']['index']]['level']; ?>
">
      <td align="left" class="first-cell">

      <img src="images/menu_minus.gif" width="9" height="9" border="0" style="margin-left:<?php echo $this->_tpl_vars['Caseloca'][$this->_sections['por']['index']]['level']; ?>
em" onclick="rowClicked(this)" />

      <span><?php echo $this->_tpl_vars['Caseloca'][$this->_sections['por']['index']]['cat_name']; ?>
</span>
      </td>
     <td><?php echo $this->_tpl_vars['Caseloca'][$this->_sections['por']['index']]['action_name']; ?>
</td>
     <td><?php echo $this->_tpl_vars['Caseloca'][$this->_sections['por']['index']]['sort_order']; ?>
</td>
      <td>
      <a href="news_link.php?act=edit&cat_id=<?php echo $this->_tpl_vars['Caseloca'][$this->_sections['por']['index']]['cat_id']; ?>
">编辑</a> 
      <!--<a href="javascript:;" onclick="listTable.remove(<?php echo $this->_tpl_vars['Caseloca'][$this->_sections['por']['index']]['cat_id']; ?>
, '您确认要删除这条记录吗?')" title="删除">移除</a></td>-->
    </tr>
    <?php endfor; else: ?>
	<tr>
      <td colspan="5">暂无记录</td>
    </tr>
    <?php endif; ?>
  </table>
<?php if ($this->_tpl_vars['full_page']): ?>
</div>
<script language="JavaScript">
<?php echo '
<!--
var imgPlus = new Image();
imgPlus.src = "images/menu_plus.gif";

/**
 * 折叠分类列表
 */
function rowClicked(obj)
{
  var Browser = new Object();
  Browser.isIE = window.ActiveXObject ? true : false;
  obj = obj.parentNode.parentNode;
  
  var url = obj.src;
  var tbl = document.getElementById("list-table");
  var lvl = parseInt(obj.className);
  var fnd = false;

  for (i = 0; i < tbl.rows.length; i++)
  {
      var row = tbl.rows[i];

      if (tbl.rows[i] == obj)
      {
          fnd = true;
      }
      else
      {
          if (fnd == true)
          {
              var cur = parseInt(row.className);
              if (cur > lvl)
              {
                  row.style.display = (row.style.display != \'none\') ? \'none\' : (Browser.isIE) ? \'block\' : \'table-row\';
              }
              else
              {
                  fnd = false;
                  break;
              }
          }
      }
  }

  for (i = 0; i < obj.cells[0].childNodes.length; i++)
  {
      var imgObj = obj.cells[0].childNodes[i];
      if (imgObj.tagName == "IMG" && imgObj.src != \'images/menu_plus.gif\')
      {
          imgObj.src = (imgObj.src == imgPlus.src) ? \'images/menu_minus.gif\' : imgPlus.src;
      }
  }
}
//-->
'; ?>

</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>