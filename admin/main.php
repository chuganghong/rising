<?php
define('IN_LK', true);

require(dirname(__FILE__) . '/includes/init.php');
@session_start();
check_admin();
/*------------------------------------------------------ */
//-- 框架
/*------------------------------------------------------ */
if ($_REQUEST['act'] == '')
{
	$smarty->display('index.html');
}

/*------------------------------------------------------ */
//-- 顶部框架的内容
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'top')
{
	if($_SESSION['role_id'])
	{
		$sql = "SELECT role_name FROM " . $lk->table('role') . "WHERE role_id = '".$_SESSION['role_id']."'";
		$role = $db->get_row($sql);	
	}else{
		$role = '超级管理员';	
	}
	
	$smarty->assign('role',      $role);
	$smarty->display('top.html');
}
/*------------------------------------------------------ */
//-- 计算器
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'calculate')
{
	$smarty->display('calculate.html');
}
/*------------------------------------------------------ */
//-- 清除缓存
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'clear_cache')
{
    clear_all_files();

    sys_msg('页面缓存已经清除成功');
}
/*------------------------------------------------------ */
//-- 左边的框架
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'menu')
{
	// 权限对照表
	include_once('ini/inc_priv.php');
	include_once('ini/inc_menu.php');
	
	foreach ($modules AS $key => $val)
    {
        $menus[$key]['label'] = $_LANG[$key];
        if (is_array($val))
        {
            foreach ($val AS $k => $v)
            {
                if ( isset($purview[$k]))
                {
                    if (is_array($purview[$k]))
                    {
                        $boole = false;
                        foreach ($purview[$k] as $action)
                        {
                             $boole = $boole || admin_priv($action, '', false);
                        }
                        if (!$boole)
                        {
                            continue;
                        }

                    }
                    else
                    {
                        if (! admin_priv($purview[$k], '', false))
                        {
                            continue;
                        }
                    }
                }

                $menus[$key]['children'][$k]['label']  = $_LANG[$k];
                $menus[$key]['children'][$k]['action'] = $v;
            }
        }
        else
        {
            $menus[$key]['action'] = $val;
        }

        // 如果children的子元素长度为0则删除该组
        if(empty($menus[$key]['children']))
        {
            unset($menus[$key]);
        }
    }

	$smarty->assign('menus',     $menus);
	$smarty->display('menu.html');	
}

/*------------------------------------------------------ */
//-- 主窗口，起始页
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'main')
{
	$gd = gd_version();
	$mysql_ver = $db->version();
	/* 系统信息 */
    $sys_info['os']            = PHP_OS;
	$sys_info['ip']            = $_SERVER['SERVER_ADDR'];
    $sys_info['web_server']    = $_SERVER['SERVER_SOFTWARE'];
    $sys_info['php_ver']       = PHP_VERSION;
    $sys_info['mysql_ver']     = $mysql_ver;
    $sys_info['zlib']          = function_exists('gzclose') ? '是':'否';
    $sys_info['safe_mode']     = (boolean) ini_get('safe_mode') ?  '是':'否';
    $sys_info['safe_mode_gid'] = (boolean) ini_get('safe_mode_gid') ? '是':'否';
    $sys_info['timezone']      = $timezone ? $timezone : function_exists("date_default_timezone_get") ? date_default_timezone_get() : '无需设置';
    $sys_info['socket']        = function_exists('fsockopen') ? '是':'否';

    if ($gd == 0)
    {
        $sys_info['gd'] = 'N/A';
    }
    else
    {
        if ($gd == 1)
        {
            $sys_info['gd'] = 'GD1';
        }
        else
        {
            $sys_info['gd'] = 'GD2';
        }

        $sys_info['gd'] .= ' (';

        /* 检查系统支持的图片类型 */
        if ($gd && (imagetypes() & IMG_JPG) > 0)
        {
            $sys_info['gd'] .= ' JPEG';
        }

        if ($gd && (imagetypes() & IMG_GIF) > 0)
        {
            $sys_info['gd'] .= ' GIF';
        }

        if ($gd && (imagetypes() & IMG_PNG) > 0)
        {
            $sys_info['gd'] .= ' PNG';
        }

        $sys_info['gd'] .= ')';
    }
	/* 允许上传的最大文件大小 */
    $sys_info['max_filesize'] = ini_get('upload_max_filesize');
	$smarty->assign('charset',  strtoupper(GS_CHARSET));
    $smarty->assign('sys_info', $sys_info);
	
	$smarty->assign('ur_here',   "系统信息");
	$smarty->display('main.html');
}

/*------------------------------------------------------ */
//-- 拖动的帧
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'drag')
{
	$smarty->display('drag.html');
}

/*------------------------------------------------------ */
//-- 检查信息
/*------------------------------------------------------ */
//elseif ($_REQUEST['act'] == 'check_msg')
//{
//	/* 会员人数 */
//    $sql = 'SELECT COUNT(*) FROM ' . $lk->table('member') . ' WHERE 1';
//    $arr['member_num'] = $db->get_row($sql);
//	if(!$arr['member_num']) $arr['member_num'] = 0;   
//   
//    if (!(is_numeric($arr['member_num'])))
//    {
//        make_json_error($db->error());
//    }
//    else
//    {
//        make_json_result('', '', $arr);
//    }
//}
?>