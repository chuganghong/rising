<?php /* Smarty version 2.6.14, created on 2013-10-29 09:40:00
         compiled from optimize.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- start form -->
<div class="form-div">
<form method="post" action="database.php" name="theForm">
总碎片数:<?php echo $this->_tpl_vars['num']; ?>

<input type="submit" value="开始进行数据表优化" class="button" />
<input type= "hidden" name= "num" value = "<?php echo $this->_tpl_vars['num']; ?>
">
<input type= "hidden" name="act" value = "run_optimize">
</form>
</div>
<!-- end form -->
<!-- start list -->
<div class="list-div" id="listDiv">
<table cellspacing='0' cellpadding='0' id='listTable' class="table">
  <tr>
    <th width="81">数据表</th>
    <th width="85">数据表类型</th>
    <th width="104">记录数</th>
    <th width="101">数据</th>
    <th width="104">碎片</th>
    <th width="95">字符集</th>
    <th width="771">状态</th>
  </tr>
  <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
    <tr>
      <td class="first-cell"><?php echo $this->_tpl_vars['item']['table']; ?>
</td>
      <td align ="left"><?php echo $this->_tpl_vars['item']['type']; ?>
</td>
      <td align ="right"><?php echo $this->_tpl_vars['item']['rec_num']; ?>
</td>
      <td align ="right"><?php echo $this->_tpl_vars['item']['rec_size']; ?>
</td>
      <td align ="right"><?php echo $this->_tpl_vars['item']['rec_chip']; ?>
</td>
      <td align ="left"><?php echo $this->_tpl_vars['item']['charset']; ?>
</td>
      <td align ="left"><?php echo $this->_tpl_vars['item']['status']; ?>
</td>
    </tr>
  <?php endforeach; endif; unset($_from); ?>
</table>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>