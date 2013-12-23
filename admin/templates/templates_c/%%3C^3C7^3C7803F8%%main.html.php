<?php /* Smarty version 2.6.14, created on 2013-09-03 17:55:08
         compiled from main.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" charset="utf-8" src="js/library.js"></script>
<div id="board">
	<img src="images/icons/home_48.png" class="logo" />
    <p><SCRIPT type="text/javascript">Hello();</SCRIPT><span class="font_b"><strong><?php echo $_SESSION['admin_true']; ?>
</strong></span>	  
        <br><SCRIPT type="text/javascript">GetDate();</SCRIPT>
        <br>上次登录：<span class="text-key"><?php echo $_SESSION['last_login']; ?>
</span>
    </p>
    <span class="clear"></span>
</div>
<div class="list-div">
<fieldset>
		<legend>统计信息</legend>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
		  	<tr>
				<th colspan="4" >系统信息</th>
	  	    </tr>
            <tr class='line'>
                <td width='120'>服务器操作系统:</td>						
                <td width='222'><?php echo $this->_tpl_vars['sys_info']['os']; ?>
 (<?php echo $this->_tpl_vars['sys_info']['ip']; ?>
)</td>
                <td width='137'>Web 服务器:</td>
                <td><?php echo $this->_tpl_vars['sys_info']['web_server']; ?>
</td>						
            </tr>
            <tr class='line'>
                <td width='120'>PHP 版本:</td>						
                <td><?php echo $this->_tpl_vars['sys_info']['php_ver']; ?>
</td>
                <td>MySQL 版本:</td>
                <td><?php echo $this->_tpl_vars['sys_info']['mysql_ver']; ?>
</td>
            </tr>
            <tr class='line'>
                <td width='120'>安全模式:</td>						
                <td><?php echo $this->_tpl_vars['sys_info']['safe_mode']; ?>
</td>
                <td>安全模式GID:</td>
                <td><?php echo $this->_tpl_vars['sys_info']['safe_mode_gid']; ?>
</td>						
            </tr>
            <tr class='line'>
                <td width='120'>Socket 支持:</td>						
                <td><?php echo $this->_tpl_vars['sys_info']['socket']; ?>
</td>
                <td>时区设置:</td>
                <td><?php echo $this->_tpl_vars['sys_info']['timezone']; ?>
</td>						
            </tr>
            <tr class='line'>
                <td width='120'>GD 版本:</td>						
                <td><?php echo $this->_tpl_vars['sys_info']['gd']; ?>
</td>
                <td>Zlib 支持:</td>						
                <td><?php echo $this->_tpl_vars['sys_info']['zlib']; ?>
</td>
            </tr>
            <tr class='line'>
                <td width='120'>文件上传的最大大小:</td>						
                <td><?php echo $this->_tpl_vars['sys_info']['max_filesize']; ?>
</td>
                <td>编码</td>
                <td><?php echo $this->_tpl_vars['charset']; ?>
</td>						
            </tr>			
			</table>	
		</fieldset>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>