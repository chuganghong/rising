<?php /* Smarty version 2.6.14, created on 2013-12-13 10:39:09
         compiled from idea_info.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
<link href="../css/color.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery.validationEngine.js" type="text/javascript"></script>
<script src="../js/jquery.validationEngine-cn.js" type="text/javascript"></script>
<?php echo '
<script type="text/javascript">
$(document).ready(function() {
	$("#theForm").validationEngine() 
});
</script>
'; ?>

<div class="main-div" >
<form action="" method="post" name="theForm" id="theForm" enctype="multipart/form-data">
  <table align="left" cellpadding="3" cellspacing="1">
    
    <tr>
      <td width="123" align="left" class="label">分类：</td>
      <td width="563">
        <select name="cat_id" id="cat_id" class="validate[required]" >
          <option value="">请选择案例栏目...</option>
          <?php echo $this->_tpl_vars['Case_cat']; ?>

        </select>
        <font color="red"> * </font></td>
    </tr>
    <tr>
      <td align="left" class="label">标题（简体）：</td>
      <td><input name="title" type="text" id="title" value="<?php echo $this->_tpl_vars['row']['title']; ?>
" style="width:400px" class="validate[required]" />
          <font color="red"> * </font></td>
    </tr>
	<!--
     <tr>
      <td align="left" class="label">标题（英文）：</td>
      <td><input name="title_en" type="text" id="title_en" value="<?php echo $this->_tpl_vars['row']['title_en']; ?>
" style="width:400px" class="validate[required]" />
          <font color="red"> * </font></td>
    </tr>
	 <tr>
        <td class="label">案例LOGO</td>
        <td><input type="file" name="img_file_src" value="" size="34" />
        <br /><span class="notice-span">此模板的图片标准宽度为：186 标准高度为：118</span>
        <?php if ($this->_tpl_vars['row']['g_pic']): ?>
        <br /><img src="../<?php echo $this->_tpl_vars['row']['g_pic']; ?>
" width="186" height="61" />
        <input type="test" name="g_pic" value="<?php echo $this->_tpl_vars['row']['g_pic']; ?>
" />
        <?php endif; ?>
        </td>
      </tr>
	  <tr>
      <td align="left" class="label">关键字（英文）：</td>
      <td><input name="keyword_en" type="text" id="keyword_en" value="<?php echo $this->_tpl_vars['row']['keyword_en']; ?>
" style="width:400px" /></td>
    </tr>
	<tr>
      <td align="left" class="label">内容（英文）：</td>
      <td><?php echo $this->_tpl_vars['content_en']; ?>
</td>
    </tr>
	-->
   
    <tr>
      <td align="left" class="label">关键字（简体）：</td>
      <td><input name="keyword" type="text" id="keyword" value="<?php echo $this->_tpl_vars['row']['keyword']; ?>
" style="width:400px" /></td>
    </tr>   
    <tr>
      <td align="left" class="label">内容（简体）：</td>
      <td><?php echo $this->_tpl_vars['content']; ?>
</td>
    </tr>    
     <tr>
      <td class="label">排序：</td>
      <td><label><input name="sort_order" type="text" id="sort_order" value="<?php echo $this->_tpl_vars['row']['sort_order']; ?>
" size="5" /></label></td>
     </tr>
    
  </table>
  <div class="button-div" style="clear:both">
    <input type="submit" class="button" value=" 确定 " onclick="return check(this.form)" />
    <input type="reset" class="button" value=" 重置 " />
    <input type="hidden" name="act" value="<?php echo $this->_tpl_vars['form_act']; ?>
" />
    <input name="Case_id" type="hidden" id="Case_id" value="<?php echo $this->_tpl_vars['row']['Case_id']; ?>
" />
    <input name="addtime" type="hidden" id="addtime" value="<?php echo $this->_tpl_vars['row']['addtime']; ?>
" />
  </div>
</form>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>