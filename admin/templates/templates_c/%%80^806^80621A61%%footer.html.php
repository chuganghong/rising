<?php /* Smarty version 2.6.14, created on 2013-09-03 17:55:08
         compiled from footer.html */ ?>
<!--页脚-->
<?php if (! $this->_tpl_vars['flag']): ?>
<?php echo '
<script type="text/javascript">
$(document).ready(function() {
	/* 检查新消息 */
	//startCheckMsg();
});
</script>
'; ?>

<?php endif; ?>
<div id="footer">
版权所有 &copy; 2012 zcppsj.com Copyright inc.
</div>
<div id="popMsg">
</div>
<?php echo '
<script language="javascript">

if(document.getElementById("listDiv"))
{
	document.getElementById("listDiv").onclick = function(e)
	{
		var obj = Utils.srcElement(e);
		
		if (obj.tagName == "INPUT" && obj.type == "checkbox")
		{
		  if (!document.forms[\'listForm\'])
		  {
			return;
		  }
		  var nodes = document.forms[\'listForm\'].elements;
		  var checked = false;
		
		  for (i = 0; i < nodes.length; i++)
		  {
			if (nodes[i].checked)
			{
			   checked = true;
			   break;
			 }
		  }
		  if(document.getElementById("btnSubmit"))
		  {
			document.getElementById("btnSubmit").disabled = !checked;
		  }
		  for (i = 1; i <= 10; i++)
		  {
			if (document.getElementById("btnSubmit" + i))
			{
			  document.getElementById("btnSubmit" + i).disabled = !checked;
			}
		  }
		}
	}
}
</script>
'; ?>

</body>
</html>