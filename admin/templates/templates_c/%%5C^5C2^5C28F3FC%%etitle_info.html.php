<?php /* Smarty version 2.6.14, created on 2013-12-18 12:07:31
         compiled from etitle_info.html */ ?>
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
	$("#theForm").validationEngine();
	var pid=$("#selMenu").val();
	getPid(pid);
	$("input[name=\'typeid\']").each(function(i){
		$(this).click(function (){
			var check=$(this).attr("checked");
				if(check){
					var val=$(this).val();
					if(val==4){
						$("#customs").show();
						$("#custom").addClass("validate[required]");
					}else{
						$("#customs").hide();
						$("#custom").val(\'\');
						$("#custom").removeClass("validate[required]");
					}
				}
		});
		});
});
function getPid(id)
{
	if(id==0)
	{
		$("#Action_name_tr").show();
		$("#typeid").hide();
		$("#Action_name").addClass("validate[required]");
		eachcheck(id);
		$("#custom").removeClass("validate[required]");
		
	}else
	{
		eachcheck(id);
		$("#Action_name").val(\'\')
		$("#Action_name_tr").hide();
		$("#typeid").show();
		$("#Action_name").removeClass("validate[required]");
	}
}
function eachcheck(id){
	if(id!=0){
		$("input[name=\'typeid\']").each(function(i){
			var check=$(this).attr("checked");
			if(check){
				var val=$(this).val();
				if(val==4){
					$("#customs").show();
					$("#custom").addClass("validate[required]");
				}else{
					$("#customs").hide();
					$("#custom").val(\'\');
					$("#custom").removeClass("validate[required]");
				}
			}
			});
	}else{
		$("#customs").hide();
		$("#custom").val(\'\');
		$("#custom").removeClass("validate[required]");
	}
}
</script>
'; ?>

<div class="main-div">
<form action="" method="post" name="theForm" id="theForm" enctype="multipart/form-data">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">    
    <tr>
      <td class="label">邮件标题：</td>
      <td><input type="text" name="title" id="title" value="<?php echo $this->_tpl_vars['row']['title']; ?>
"  class="validate[required]" /><font color="red"> * </font></td>
    </tr>
   <!--
    <tr>
      <td class="label">SMTP服务器地址:</td>
      <td><input type="text" name="smtp_host" id="smtp_host" value="<?php echo $this->_tpl_vars['row']['smtp_host']; ?>
"  class="validate[required]" /><font color="red"> * </font></td>
    </tr>
	
	<tr>
      <td class="label">SMTP 用户账号:</td>
      <td><input type="text" name="smtp_user" id="smtp_user" value="<?php echo $this->_tpl_vars['row']['smtp_user']; ?>
"  class="validate[required]" /><font color="red"> * </font></td>
    </tr>
	
	<tr>
      <td class="label">SMTP 密码:</td>
      <td><input type="password" name="smtp_pass" id="smtp_pass" value="<?php echo $this->_tpl_vars['row']['smtp_pass']; ?>
"  class="validate[required]" /><font color="red"> * </font></td>
    </tr>
	
	<tr>
      <td class="label">SMTP 端口:</td>
      <td><input type="text" name="smtp_port" id="smtp_port" value="<?php echo $this->_tpl_vars['row']['smtp_port']; ?>
"  class="validate[required]" /><font color="red"> * </font></td>
    </tr>
	
	
    <tr>
      <td class="label">排序:</td>
      <td><input type="text" name="sort_order" id="sort_order" value="<?php echo $this->_tpl_vars['row']['sort_order']; ?>
" /><br />
      <span class="notice-span">降序方式排序</span></td>
    </tr>       
    <tr>
      <td class="label">栏目描述:</td>
      <td><textarea name="cat_desc" id="cat_desc" cols="45" rows="5"><?php echo $this->_tpl_vars['row']['cat_desc']; ?>
</textarea></td>
    </tr>
	<tr>
        <td class="label">Banner</td>
        <td><input type="file" name="img_file_src" value="" size="34" />
        <br /><span class="notice-span">此模板的图片标准宽度为：934 标准高度为：295</span>
        <?php if ($this->_tpl_vars['row']['cat_pic']): ?>
        <br /><img src="../<?php echo $this->_tpl_vars['row']['cat_pic']; ?>
" width="186" height="61" />
        <input type="test" name="cat_pic" value="<?php echo $this->_tpl_vars['row']['cat_pic']; ?>
" />
        <?php endif; ?>
        </td>
      </tr>
	  -->
  </table>
  <div class="button-div">
    <input type="submit" class="button" value=" 确定 " />
    <input type="reset" class="button" value=" 重置 " />
	<span class="button"><a href="http://localhost/rising/index.php/semail/send">发送邮件</a></span>
  </div>
  

    <input type="hidden" name="act" value="<?php echo $this->_tpl_vars['form_act']; ?>
" />    
</form>
</div>
<?php echo '
<script language="JavaScript">
<!--
document.forms[\'theForm\'].elements[\'cat_name\'].focus();
//-->
</script>
'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>