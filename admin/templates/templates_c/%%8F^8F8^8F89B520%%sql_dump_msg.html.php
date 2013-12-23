<?php /* Smarty version 2.6.14, created on 2013-09-03 17:56:54
         compiled from sql_dump_msg.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="list-div">
  <div style="background:#FFF; padding: 20px 50px; margin: 2px;">
    <table align="center" width="400">
      <tr>
        <td width="100%" valign="top">
          <img src="images/information.gif" width="32" height="32" border="0" alt="information" />
          <span style="font-size: 14px; font-weight: bold"><?php echo $this->_tpl_vars['title']; ?>
</span>
        </td>
      </tr>
      <tr>
        <td>
         <?php if ($this->_tpl_vars['auto_redirect']): ?>
          <a href="<?php echo $this->_tpl_vars['auto_link']; ?>
"><?php echo $this->_tpl_vars['lang']['backup_notice']; ?>
</a>
          <script>setTimeout("window.location.replace('<?php echo $this->_tpl_vars['auto_link']; ?>
');", 1250);</script>
          <?php else: ?>
            <ul>
              <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['file']):
?>
              <li><a href="<?php echo $this->_tpl_vars['file']['href']; ?>
"><?php echo $this->_tpl_vars['file']['name']; ?>
</li>
              <?php endforeach; endif; unset($_from); ?>
            </ul>
          <?php endif; ?>
        </td>
      </tr>
    </table>
  </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>