<?php /* Smarty version 2.6.14, created on 2013-12-13 10:59:36
         compiled from idea_list.html */ ?>
<?php if ($this->_tpl_vars['full_page']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="../css/color.css" rel="stylesheet" type="text/css" />
<div class="form-div">
<table>
    <tr>
      <td width="50%">
    <form name="theForm" method="POST" action="javascript:searchData()" >
      <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
       请输入标题:
      <input type="text" name="searchs" />
      
      按分类查看
      <select name="cat_id" onchange="searchCateID(this.value)">
      <option value='0'>选择栏目...</option>
      <?php echo $this->_tpl_vars['cat_list']; ?>

      </select> 
        <input type="submit" value=" 搜索 " class="button" />
	</form>
      </td>
    </tr>
</table>
<?php echo '
<script language="JavaScript"> 
function searchData()
{
	listTable.filter.searchs = document.forms[\'theForm\'].elements[\'searchs\'].value;
	listTable.filter.cat_id = document.forms[\'theForm\'].elements[\'cat_id\'].value;
	listTable.filter[\'page\'] = 1;
	listTable.loadList();
}
 function batch_drop()
  {
	if(confirm(\'您确认要批量删除这些记录吗?\'))
	{
		document.listForm.act.value=\'batch_drop\';	
		document.listForm.submit();
	}
  }
</script>
'; ?>

</div>
<form method="POST" action="join.php?act=batch_drop" name="listForm">
<div class="list-div" id="listDiv">
<?php endif; ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" id="list-table" class="table">
    <tr>
      <th><input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox">编号</th>
      <th>分类</th>
      <th>标题</th>
<!--      <th>标题（简体）</th>
     <th>标题（英文）</th>--> 
      <th>添加时间</th>
      <th>最后修改时间</th>
      <th>排序</th>
      <th>编辑</th>
    </tr>
    <?php unset($this->_sections['por']);
$this->_sections['por']['name'] = 'por';
$this->_sections['por']['loop'] = is_array($_loop=$this->_tpl_vars['Case']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
    <tr>
      <td><span><input name="checkboxes[]" type="checkbox" value="<?php echo $this->_tpl_vars['Case'][$this->_sections['por']['index']]['Case_id']; ?>
" /> <?php echo $this->_tpl_vars['Case'][$this->_sections['por']['index']]['Case_id']; ?>
</span></td>
      <td><?php echo $this->_tpl_vars['Case'][$this->_sections['por']['index']]['cat_name']; ?>
</td>
       <td><?php echo $this->_tpl_vars['Case'][$this->_sections['por']['index']]['title']; ?>
</td>
       <!--<td><?php echo $this->_tpl_vars['Case'][$this->_sections['por']['index']]['title_tw']; ?>
</td>
       <td><?php echo $this->_tpl_vars['Case'][$this->_sections['por']['index']]['title_en']; ?>
</td>-->
      <td><?php echo $this->_tpl_vars['Case'][$this->_sections['por']['index']]['addtime']; ?>
</td>
      <td><?php if ($this->_tpl_vars['Case'][$this->_sections['por']['index']]['updatetime']):  echo $this->_tpl_vars['Case'][$this->_sections['por']['index']]['updatetime'];  else: ?>N/A<?php endif; ?></td>
      
      <td><?php echo $this->_tpl_vars['Case'][$this->_sections['por']['index']]['sort_order']; ?>
</td>
      <td align="center">
    
      <a href="join.php?act=edit&Case_id=<?php echo $this->_tpl_vars['Case'][$this->_sections['por']['index']]['Case_id']; ?>
">编辑</a> | 
      <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_tpl_vars['Case'][$this->_sections['por']['index']]['Case_id']; ?>
, '您确认要删除这条记录吗?')" title="删除">移除</a></td>
    </tr>
    <?php endfor; else: ?>
	<tr>
      <td colspan="10">暂无记录</td>
    </tr>
    <?php endif; ?>
    <tr>
    <td >
    <input type="hidden" name="act" value="" />
    <input name="swap_type_id" type="button" id="btnSubmit1" value="批量删除" disabled="disabled" class="button" onClick="batch_drop();"  />
    </td>
    <td colspan="10" align="right"><?php $_smarty_tpl_vars = $this->_tpl_vars;
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
  
  

  -->
</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>