<?php /* Smarty version 2.6.14, created on 2013-12-06 16:39:43
         compiled from flashplay_add.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery.validationEngine.js" type="text/javascript"></script>
<script src="../js/jquery.validationEngine-cn.js" type="text/javascript"></script>
<?php echo '
<script type="text/javascript">
$(document).ready(function() {
	$("#theForm").validationEngine() 
});
</script>
'; ?>

<div class="main-div">
<form action="flashplay.php" id="theForm" name="theForm" method="post" enctype="multipart/form-data">
<table cellspacing="1" cellpadding="3" width="90%">
  <!--
  <tr>
      <td width="123" align="left" class="label">分类：</td>
      <td width="563">
        <select name="cat_id" id="cat_id" class="validate[required]" >
          <option value="">请选择案例栏目...</option>
           <option value="0">幻灯片</option>
		   <option value="1">Banner</option>
        </select>
        <font color="red"> * </font></td>
    </tr>
	-->
  <tr>
    <td class="label">图片地址</td>
    <td><input type="file" name="img_file_src" value="" size="40" />
    <br /><span class="notice-span">此模板的图片标准宽度为：934 标准高度为：390</span>
	<br /><span class="notice-span">或此模板的图片标准宽度为：981 标准高度为：110</span>
    <?php if ($this->_tpl_vars['row']['img_src']): ?>
    <br /><img src="../<?php echo $this->_tpl_vars['row']['img_src']; ?>
" width="186" height="61" />
    <input type="hidden" name="img_src" value="<?php echo $this->_tpl_vars['row']['img_src']; ?>
" />
    <?php endif; ?>
    </td>
  </tr>
  <tr>
    <td class="label">图片链接</td>
    <td><input name="img_link" type="text" value="<?php echo $this->_tpl_vars['row']['img_link']; ?>
" size="40" /></td>
  </tr>
  <tr>
    <td class="label">类型</td>
    <td> <label><input name="img_type" type="radio" class="typeid" value="1" <?php if ($this->_tpl_vars['row']['img_type'] == 1): ?>checked="checked"<?php endif; ?>/>BANNER</label>
            <label><input name="img_type" type="radio" class="typeid" value="0" <?php if ($this->_tpl_vars['row']['img_type'] == 0): ?>checked="checked"<?php endif; ?>/>幻灯片</label></td>
  </tr>
  
  <!--
  <tr>
    <td class="label">图片标题</td>
    <td><input name="img_title" type="text" value="<?php echo $this->_tpl_vars['row']['img_title']; ?>
" size="40" /></td>
  </tr>
  <tr>
    <td class="label">图片标题(简体)</td>
    <td><input name="img_title_tw" type="text" value="<?php echo $this->_tpl_vars['row']['img_title_tw']; ?>
" size="40" /></td>
  </tr>
  <tr>
    <td class="label">图片标题(英文)</td>
    <td><input name="img_title_en" type="text" value="<?php echo $this->_tpl_vars['row']['img_title_en']; ?>
" size="40" /></td>
  </tr>
  <tr>
    <td class="label">图片说明</td>
    <td><input name="img_alt" type="text" value="<?php echo $this->_tpl_vars['row']['img_alt']; ?>
" size="40" /></td>
  </tr>
  <tr>
    <td class="label">图片说明(简体)</td>
    <td><input name="img_alt_tw" type="text" value="<?php echo $this->_tpl_vars['row']['img_alt_tw']; ?>
" size="40" /></td>
  </tr>
  <tr>
    <td class="label">图片说明(英文)</td>
    <td><input name="img_alt_en" type="text" value="<?php echo $this->_tpl_vars['row']['img_alt_en']; ?>
" size="40" /></td>
  </tr>
  -->
  <tr>
    <td class="label">排序</td>
    <td><input name="img_sort" type="text" value="<?php echo $this->_tpl_vars['row']['img_sort']; ?>
" size="4" maxlength="3"/></td>
  </tr>
  <tr align="center">
    <td colspan="2">
      <input type="hidden"  name="flash_id"       value="<?php echo $this->_tpl_vars['row']['flash_id']; ?>
" />
      <input type="hidden"  name="act"       value="<?php echo $this->_tpl_vars['form_act']; ?>
" />
      <input type="submit" class="button" name="Submit"       value="确定" />
      <input type="reset" class="button"  name="Reset"        value="重置" />
    </td>
  </tr>
</table>
</form>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>