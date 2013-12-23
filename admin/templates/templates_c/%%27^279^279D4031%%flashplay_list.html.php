<?php /* Smarty version 2.6.14, created on 2013-12-06 16:44:04
         compiled from flashplay_list.html */ ?>
<?php if ($this->_tpl_vars['full_page']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script type="text/javascript">
$(document).ready(function() {
	$(".player a").mouseover(function(){
		$(this).next().css(\'position\',\'absolute\');	
		$(this).next().show(\'slow\');							   
	});
	$(".player a").mouseout(function(){
		$(this).next().hide(\'slow\');							   
	});
});
</script>
'; ?>

<div class="list-div" id="listDiv">
<?php endif; ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" id="list-table" class="table">
    <tr >	
      <th>图片链接</th>
      <th>图片</th>
     <!-- <th>分类</th>
      <th>图片标题</th>-->
      <th>图片类型</th>
     <!-- <th>图片标题(简体)</th>
      <th>图片标题(英文)</th>
      <th>图片说明</th>
      <th>图片说明(简体)</th>
      <th>图片说明(英文)</th>
      <th>排序</th>-->
      <th>操作</th>
    </tr>
    <?php $_from = $this->_tpl_vars['flash']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <tr>
	  <td><?php echo $this->_tpl_vars['item']['img_link']; ?>
&nbsp;</td>
      <td class="player">
      	<a href="<?php echo $this->_tpl_vars['item']['img_src']; ?>
" target="_blank"><?php echo $this->_tpl_vars['item']['img_src']; ?>
</a>
        <div style="display:none;z-index:2">
        	<img src="../<?php echo $this->_tpl_vars['item']['img_src']; ?>
" border="0" />
        </div>
      </td>
      
      <!--<td><?php echo $this->_tpl_vars['item']['cat_name']; ?>
</td>-->
      <td><?php if ($this->_tpl_vars['item']['img_type'] == 1): ?>BANNER<?php else: ?>幻灯片<?php endif; ?></td>
      <!--<td><a href="<?php echo $this->_tpl_vars['item']['img_link']; ?>
" target="_blank"><?php echo $this->_tpl_vars['item']['img_link']; ?>
</a></td>
      
      <td><?php echo $this->_tpl_vars['item']['img_title_tw']; ?>
&nbsp;</td>
       <td><?php echo $this->_tpl_vars['item']['img_title_en']; ?>
&nbsp;</td>
      <td><?php echo $this->_tpl_vars['item']['img_alt']; ?>
&nbsp;</td>
      <td><?php echo $this->_tpl_vars['item']['img_alt_tw']; ?>
&nbsp;</td>
      <td><?php echo $this->_tpl_vars['item']['img_alt_en']; ?>
&nbsp;</td>
      <td><?php echo $this->_tpl_vars['item']['img_sort']; ?>
&nbsp;</td>-->
      <td>
        <a href="flashplay.php?act=edit&flash_id=<?php echo $this->_tpl_vars['item']['flash_id']; ?>
" title="编辑">编辑</a>
        <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_tpl_vars['item']['flash_id']; ?>
, '您确认要删除这条记录吗?')" title="移除">移除</a>
    </tr>
    <?php endforeach; else: ?>
    <tr><td colspan="4">暂无记录</td></tr>
    <?php endif; unset($_from); ?>
    <tr>
      <td>
    	<input name="add" type="submit" id="btnSubmit" value="<?php echo $this->_tpl_vars['action_link_special']['text']; ?>
" class="button" onclick="location.href='<?php echo $this->_tpl_vars['action_link_special']['href']; ?>
';" />
        <td align="right"  colspan="3"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "page.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
      </td>
    </tr>
  </table>
<?php if ($this->_tpl_vars['full_page']): ?>
</div>

<script language="JavaScript">
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
</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>