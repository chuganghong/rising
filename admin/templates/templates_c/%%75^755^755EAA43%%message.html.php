<?php /* Smarty version 2.6.14, created on 2013-12-05 18:02:06
         compiled from message.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="list-div">
  <div style="background:#FFF; padding: 20px 50px; margin: 2px;border:#FF9900 solid 1px;">
    <table align="center" width="400">
      <tr>
        <td width="50" valign="top">
          <?php if ($this->_tpl_vars['msg_type'] == 0): ?>
          <img src="images/information.gif" width="32" height="32" border="0" alt="information" />
          <?php elseif ($this->_tpl_vars['msg_type'] == 1): ?>
          <img src="images/warning.gif" width="32" height="32" border="0" alt="warning" />
          <?php else: ?>
          <img src="images/confirm.gif" width="32" height="32" border="0" alt="confirm" />
          <?php endif; ?>
        </td>
        <td style="font-size: 14px; font-weight: bold"><?php echo $this->_tpl_vars['msg_detail']; ?>
</td>
      </tr>
      <tr>
        <td></td>
        <td id="redirectionMsg">
          <?php if ($this->_tpl_vars['auto_redirect']): ?>如果您不做出选择，将在 <span id="spanSeconds">3</span> 秒后跳转到第一个链接地址。<?php endif; ?>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <ul style="margin:0; padding:0 10px" class="msg-link">
            <?php $_from = $this->_tpl_vars['links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['link']):
?>
            <li><a href="<?php echo $this->_tpl_vars['link']['href']; ?>
"><?php echo $this->_tpl_vars['link']['text']; ?>
</a></li>
            <?php endforeach; endif; unset($_from); ?>
          </ul>
        </td>
      </tr>
    </table>
  </div>
</div>
<?php if ($this->_tpl_vars['auto_redirect']): ?>
<script language="JavaScript">

<!--
var seconds = 3;
var defaultUrl = "<?php echo $this->_tpl_vars['default_url']; ?>
";

<?php echo '
onload = function()
{
  if (defaultUrl == \'javascript:history.go(-1)\' && window.history.length == 0)
  {
    document.getElementById(\'redirectionMsg\').innerHTML = \'\';
    return;
  }

  window.setInterval(redirection, 1000);
}
function redirection()
{
  if (seconds <= 0)
  {
    window.clearInterval();
    return;
  }

  seconds --;
  document.getElementById(\'spanSeconds\').innerHTML = seconds;

  if (seconds == 0)
  {
    window.clearInterval();
    location.href = defaultUrl;
  }
}
'; ?>

//-->
</script>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>