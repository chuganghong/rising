<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty truncate modifier plugin
 * @author   ÖÜÀÚ
 * @param string
 * @param string
 */
function smarty_modifier_style($title, $style='')
{
	if($style)
	{
		return '<span class="'.$style.'">'.$title.'</span>';	
	}else{
		return $title;
	}
}
/* vim: set expandtab: */

?>
