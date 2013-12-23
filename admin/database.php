<?php
define('IN_LK', true);
@session_start();
require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH .   'admin/includes/cls_sql_dump.php');

check_admin();
@ini_set('memory_limit', '64M');

/* 备份页面 */
if ($_REQUEST['act'] == 'backup')
{
	admin_priv('db_backup');
    $tables= $db->get_col("SHOW TABLES LIKE '" . mysql_like_quote($lk->prefix) . "%'");
	$allow_max_size = ini_get(@ini_get('upload_max_filesize')); // 单位为字节
    $allow_max_size = $allow_max_size / 1024; // 转换单位为 KB

    /* 权限检查 */
    $path = ROOT_PATH . DATA_DIR . '/sqldata';
    $mask = file_mode_info($path);
    if ($mask === false)
    {
        mkdirs($path);
    }
    $smarty->assign('tables',   $tables);
    $smarty->assign('vol_size', $allow_max_size);
    $smarty->assign('sql_name', cls_sql_dump::get_random_name() . '.sql');
    $smarty->assign('ur_here',  "数据备份");
	$smarty->assign('action_text',  "数据恢复");
	$smarty->assign('action_href',  "database.php?act=restore");
	$smarty->display('db_backup.html');
}

/* 备份恢复页面 */
if ($_REQUEST['act'] == 'restore')
{
	admin_priv('db_backup');
    $list = array();
    $path = ROOT_PATH . DATA_DIR . '/sqldata/';

    /* 检查目录 */
    $mask = file_mode_info($path);
    if ($mask === false)
    {
        mkdirs($path);
    }
    elseif (($mask & 1) < 1)
    {
        $warning = $path . '&nbsp;&nbsp; 不可读';
        $smarty->assign('warning', $warning);
    }
    else
    {
        /* 获取文件列表 */
        $real_list = array();
        $folder = opendir($path);
        while ($file = readdir($folder))
        {
            if (strpos($file,'.sql') !== false)
            {
                $real_list[] = $file;
            }
        }
        natsort($real_list);

        $match = array();
        foreach ($real_list AS $file)
        {
            if (preg_match('/_([0-9])+\.sql$/', $file, $match))
            {
                if ($match[1] == 1)
                {
                    $mark = 1;
                }
                else
                {
                    $mark = 2;
                }
            }
            else
            {
                $mark = 0;
            }

            $file_size = filesize($path . $file);
            $info = cls_sql_dump::get_head($path . $file);
			
            $list[] = array('name' => $file, 'ver' => $info['lk_ver'], 'add_time' => $info['date'], 'vol' => $info['vol'], 'file_size' => num_bitunit($file_size), 'mark' => $mark);
        }
    }
    $smarty->assign('ur_here',  "数据恢复");
	$smarty->assign('action_text',  "数据备份");
	$smarty->assign('action_href',  "database.php?act=backup");
    $smarty->assign('list',$list);
    $smarty->display('db_restore.html');
}

/* 开始备份 */
if ($_REQUEST['act'] == 'dumpsql')
{
	admin_priv('db_backup');
   /* 检查目录权限 */
    $path = ROOT_PATH . DATA_DIR . '/sqldata';
    $mask = file_mode_info($path);
    if ($mask === false)
    {
        mkdirs($path);
    }

    /* 设置最长执行时间为5分钟 */
    @set_time_limit(300);

    /* 初始化 */
    $dump = new cls_sql_dump($db);
    $run_log = ROOT_PATH . DATA_DIR . '/sqldata/run.log';

    /* 初始化输入变量 */
    if (empty($_REQUEST['sql_file_name']))
    {
        $sql_file_name = $dump->get_random_name();
    }
    else
    {
        $sql_file_name = str_replace("0xa", '', trim($_REQUEST['sql_file_name'])); // 过滤 0xa 非法字符
        $pos = strpos($sql_file_name, '.sql');
        if ($pos !== false)
        {
            $sql_file_name = substr($sql_file_name, 0, $pos);
        }
    }

    $max_size = empty($_REQUEST['vol_size']) ? 0 : intval($_REQUEST['vol_size']);
    $vol = empty($_REQUEST['vol']) ? 1 : intval($_REQUEST['vol']);
	
    /* 变量验证 */
    $allow_max_size = intval(@ini_get('upload_max_filesize')); //单位M
    if ($allow_max_size > 0 && $max_size > ($allow_max_size * 1024))
    {
        $max_size = $allow_max_size * 1024; //单位K
    }

    if ($max_size > 0)
    {
        $dump->max_size = $max_size * 1024;
    }

    /* 获取要备份数据列表 */
    $type = empty($_POST['type']) ? '' : trim($_POST['type']);
    $tables = array();

    switch ($type)
    {
        case 'full':
            $temp = $db->get_col("SHOW TABLES LIKE '" . mysql_like_quote($lk->prefix) . "%'");
            foreach ($temp AS $table)
            {
                $tables[$table] = -1;
            }

            $dump->put_tables_list($run_log, $tables);
            break;

        case 'custom':
            foreach ($_POST['customtables'] AS $table)
            {
                $tables[$table] = -1;
            }
            $dump->put_tables_list($run_log, $tables);
            break;
    }

    /* 开始备份 */
    $tables = $dump->dump_table($run_log, $vol);

    if ($tables === false)
    {
        die($dump->errorMsg());
    }
	

    if (empty($tables))
    {
        /* 备份结束 */
        if ($vol > 1)
        {
            /* 有多个文件 */
            if (!@file_put_contents(ROOT_PATH . DATA_DIR . '/sqldata/' . $sql_file_name . '_' . $vol . '.sql', $dump->dump_sql))
            {
                sys_msg(sprintf("备份文件 %s 无法写入", $sql_file_name . '_' . $vol . '.sql'), 1, array(array('text'=>"数据备份", 'href'=>'database.php?act=backup')), false);
            }
            $list = array();
            for ($i = 1; $i <= $vol; $i++)
            {
                $list[] = array('name'=>$sql_file_name . '_' . $i . '.sql', 'href'=>'../' . DATA_DIR . '/sqldata/' . $sql_file_name . '_' . $i . '.sql');
            }

            $smarty->assign('list',  $list);
            $smarty->assign('title', "备份成功");
            $smarty->display('sql_dump_msg.html');
        }
        else
        {
            /* 只有一个文件 */
            if (!@file_put_contents(ROOT_PATH . DATA_DIR . '/sqldata/' . $sql_file_name . '.sql', $dump->dump_sql))
            {
                sys_msg(sprintf('备份文件 %s 无法写入', $sql_file_name . '_' . $vol . '.sql'), 1, array(array('text'=>"数据备份", 'href'=>'database.php?act=backup')), false);
            };

            $smarty->assign('list',  array(array('name' => $sql_file_name . '.sql', 'href' => '../' . DATA_DIR . '/sqldata/' . $sql_file_name . '.sql')));
            $smarty->assign('title', "备份成功");
            $smarty->display('sql_dump_msg.html');
        }
    }
    else
    {
        /* 下一个页面处理 */
        if (!@file_put_contents(ROOT_PATH . DATA_DIR . '/sqldata/' . $sql_file_name . '_' . $vol . '.sql', $dump->dump_sql))
        {
            sys_msg(sprintf('备份文件 %s 无法写入', $sql_file_name . '_' . $vol . '.sql'), 1, array(array('text'=>'数据备份', 'href'=>'database.php?act=backup')), false);
        }

        $lnk = 'database.php?act=dumpsql&sql_file_name=' . $sql_file_name . '&vol_size=' . $max_size . '&vol=' . ($vol+1);
        $smarty->assign('title',         sprintf("数据文件 %s 成功创建,程序将自动继续", '#' . $vol));
        $smarty->assign('auto_redirect', 1);
        $smarty->assign('auto_link',     $lnk);
        $smarty->display('sql_dump_msg.html');
    }
}

/* 删除备份 */
if ($_REQUEST['act'] == 'remove')
{
	admin_priv('db_restore');
 	 if (isset($_POST['file']))
    	{
        $m_file = array(); //多卷文件
        $s_file = array(); //单卷文件

        $path = ROOT_PATH . DATA_DIR . '/sqldata/';

        foreach ($_POST['file'] AS $file)
        {
            if (preg_match('/_[0-9]+\.sql$/', $file))
            {
                $m_file[] = substr($file, 0, strrpos($file, '_'));
            }
            else
            {
                $s_file[] = $file;
            }
        }

        if ($m_file)
        {
            $m_file = array_unique ($m_file);

            /* 获取文件列表 */
            $real_file = array();

            $folder = opendir($path);
            while ($file = readdir($folder))
            {
                if ( preg_match('/_[0-9]+\.sql$/', $file) && is_file($path . $file))
                {
                    $real_file[] = $file;
                }
            }

            foreach ($real_file AS $file)
            {
                $short_file = substr($file, 0, strrpos($file, '_'));
                if (in_array($short_file, $m_file))
                {
                    @unlink($path . $file);
                }
            }
        }

        if ($s_file)
        {
            foreach ($s_file AS $file)
            {
                @unlink($path . $file);
            }
        }
    }

    sys_msg("删除成功" , 0, array(array('text'=>"恢复备份", 'href'=>'database.php?act=restore')));
}

/* 从服务器上导入数据 */
if ($_REQUEST['act'] == 'import')
{
	admin_priv('db_restore');
    $is_confirm = empty($_GET['confirm']) ? false : true;
    $file_name = empty($_GET['file_name']) ? '': trim($_GET['file_name']);
    $path = ROOT_PATH . DATA_DIR . '/sqldata/';

    /* 设置最长执行时间为5分钟 */
    @set_time_limit(300);

    if (preg_match('/_[0-9]+\.sql$/', $file_name))
    {
        /* 多卷处理 */
        if ($is_confirm == false)
        {
            /* 提示用户要求确认 */
			sys_msg('导入一个分卷可能导致数据不完整，是否一起导入其他分卷数据', 1, array(array('text'=>"是，我要导入其他分卷数据", 'href'=>'database.php?act=import&confirm=1&file_name=' . $file_name)), false);
        }

        $short_name = substr($file_name, 0, strrpos($file_name, '_'));

        /* 获取文件列表 */
        $real_file = array();
        $folder = opendir($path);
        while ($file = readdir($folder))
        {
            if (is_file($path . $file) && preg_match('/_[0-9]+\.sql$/', $file))
            {
                $real_file[] = $file;
            }
        }

        /* 所有相同分卷数据列表 */
        $post_list = array();
        foreach ($real_file AS $file)
        {
            $tmp_name = substr($file, 0, strrpos($file, '_'));
            if ($tmp_name == $short_name)
            {
                $post_list[] = $file;
            }
        }

        natsort($post_list);

        /* 开始恢复数据 */
        foreach ($post_list AS $file)
        {
            $info = cls_sql_dump::get_head($path . $file);
            if ($info['lk_ver'] != VERSION )
            {
                sys_msg(sprintf(' 当前版本%s与备份数据版本%s不同，备份恢复失败', VERSION, $sql_info['lk_ver']));
            }
            if (!sql_import($path . $file))
            {
                sys_msg('你上传的sql文件执行出错，备份恢复失败', 1);
            }
        }

        sys_msg('恢复成功', 0, array(array('text'=>'恢复备份', 'href'=>'database.php?act=restore')));
    }
    else
    {
        /* 单卷 */
        $info = cls_sql_dump::get_head($path . $file_name);
        if ($info['lk_ver'] != VERSION )
        {
            sys_msg(sprintf('当前mysql版本%s与备份数据的mysql版本%s不同，你确认要导入该备份文件吗?', VERSION, $sql_info['lk_ver']));
        }

        if (sql_import($path . $file_name))
        {
			sys_msg('恢复成功', 0, array(array('text'=>'恢复备份', 'href'=>'database.php?act=restore')));
        }
        else
        {
             sys_msg("你上传的sql文件执行出错，备份恢复失败", 1);
        }
    }
}

/*------------------------------------------------------ */
//-- 上传sql 文件
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'upload_sql')
{
    admin_priv('db_restore');
    $sql_file = ROOT_PATH .   'data/upload_database_bak.sql';

    if (empty($_GET['mysql_ver_confirm']))
    {
        if (empty($_FILES['sqlfile']))
        {
            sys_msg('你上传了一个空文件', 1);
        }

        $file = $_FILES['sqlfile'];

        /* 检查上传是否成功 */
        if ((isset($file['error']) && $file['error'] > 0) || (!isset($file['error']) && $file['tmp_name'] =='none'))
        {
            sys_msg('文件上传失败',1);
        }

        /* 检查文件格式 */
        if ($file['type'] == 'application/x-zip-compressed')
        {
            sys_msg('服务器不支持zip格式，请将文件解压后再上传', 1);
        }

        if (!preg_match("/\.sql$/i" , $file['name']))
        {
            sys_msg('你上传的好象不是sql文件，如果文件确实是sql文件，请将文件扩展名改为.sql',1);
        }

        /* 将文件移动到临时目录，避免权限问题 */
        @unlink($sql_file);
        if (!move_upload_file($file['tmp_name'] , $sql_file ))
        {
            sys_msg('文件上传移动失败', 1);
        }
    }

    /* 获取sql文件头部信息 */
    $sql_info = cls_sql_dump::get_head($sql_file);
	

    /* 如果备份文件的系统与现有商城系统版本不同则拒绝执行 */
    if (empty($sql_info['lk_ver']))
    {
        sys_msg('不能识别备份sql', 1);
    }
    else
    {
        if ($sql_info['lk_ver']!= VERSION)
        {
            sys_msg(sprintf('备份恢复失败', VERSION, $sql_info['lk_ver']));
        }
    }

    /* 检查数据库版本是否正确 */
	
    if (empty($_GET['mysql_ver_confirm']))
    {
        if (empty($sql_info['mysql_ver']))
        {
            sys_msg('不能识别备份sql的mysql版本');
			
        }
        else
        {
            $mysql_ver_arr = $db->version();
			
            if ($sql_info['mysql_ver'] != $mysql_ver_arr)
            {
                $lnk = array();
                $lnk[] = array('text' => '是，确认导入', 'href' => 'database.php?act=upload_sql&mysql_ver_confirm=1');
                $lnk[] = array('text' =>'否，取消导入', 'href'=> 'database.php?act=restore');
                sys_msg(sprintf('当前mysql版本%s与备份数据的mysql版本%s不同，你确认要导入该备份文件吗?', $mysql_ver_arr, $sql_info['mysql_ver']), 0, $lnk, false);
            }
        }
    }

    /* 设置最长执行时间为5分钟 */
    @set_time_limit(300);

    if (sql_import($sql_file))
    {
        //clear_all_files();
        @unlink($sql_file);
        sys_msg('恢复成功', 0, array());
    }
    else
    {
        @unlink($sql_file);
        sys_msg('你上传的sql文件执行出错，备份恢复失败', 1);
    }
}

/*------------------------------------------------------ */
//-- 优化页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'optimize')
{
	admin_priv('db_optimize');
    /* 初始化数据 */
    $db_ver_arr = $db->version();
    $db_ver = $db_ver_arr;
    $ret = $db ->query("SHOW TABLE STATUS LIKE '" . mysql_like_quote($lk->prefix) . "%'");

    $num = 0;
    $list= array();
    while ($row = $db->fetch_array($ret))
    {
        if (strpos($row['Name'], '_session') !== false)
        {
            $res['Msg_text'] = 'Ignore';
            $row['Data_free'] = 'Ignore';
        }
        else
        {
            $res = $db->get_one('CHECK TABLE ' . $row['Name']);
            $num += $row['Data_free'];
        }
        $type = $db_ver >= '4.1' ? $row['Engine'] : $row['Type'];
        $charset = $db_ver >= '4.1' ? $row['Collation'] : 'N/A';
        $list[] = array('table' => $row['Name'], 'type' => $type, 'rec_num' => $row['Rows'], 'rec_size' => sprintf(" %.2f KB", $row['Data_length'] / 1024), 'rec_index' => $row['Index_length'],  'rec_chip' => $row['Data_free'], 'status' => $res['Msg_text'], 'charset' => $charset);
    }
    unset($ret);
    /* 赋值 */
    
    $smarty->assign('list',    $list);
    $smarty->assign('num',     $num);
    $smarty->assign('ur_here', '数据优化');
    $smarty->display('optimize.html');
}

if ($_REQUEST['act'] == 'run_optimize')
{
	admin_priv('db_optimize');
    $tables = $db->get_col("SHOW TABLES LIKE '" . mysql_like_quote($lk->prefix) . "%'");
    foreach ($tables AS $table)
    {
        if ($row = $db->get_one('OPTIMIZE TABLE ' . $table))
        {
            /* 优化出错，尝试修复 */
            if ($row['Msg_type'] =='error' && strpos($row['Msg_text'], 'repair') !== false)
            {
                $db->query('REPAIR TABLE ' . $table);
            }
        }
    }

    sys_msg(sprintf("数据表优化成功，共清理碎片 %d", $_POST['num']), 0, array(array('text'=>'返回数据优化列表', 'href'=>'database.php?act=optimize')));
}

/**
 *
 *
 * @access  public
 * @param
 *
 * @return void
 */
function sql_import($sql_file)
{
  
   $db_ver  = $GLOBALS['db']->version();
	
    $sql_str = array_filter(file($sql_file),"remove_comment");
	
    $sql_str = str_replace("\r", '', implode('', $sql_str));
	

    $ret = explode(";\n", $sql_str);
    $ret_count = count($ret);
    

    /* 执行sql语句 */
     if ($db_ver > '4.1')
     {
        for($i = 0; $i < $ret_count; $i++)
        {
            $ret[$i] = trim($ret[$i], " \r\n;"); //剔除多余信息
            if (!empty($ret[$i]))
            {
                if ((strpos($ret[$i], 'CREATE TABLE') !== false) && (strpos($ret[$i], 'DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ' )=== false))
                {
                    /* 建表时缺 DEFAULT CHARSET=utf8 */
                    $ret[$i] = $ret[$i] ;
                }
				
                 $GLOBALS['db']->query($ret[$i]);
			} 
	   }
	   
    }
    else
    {
        for($i = 0; $i < $ret_count; $i++)
        {
            $ret[$i] = trim($ret[$i], " \r\n;"); //剔除多余信息
            if ((strpos($ret[$i], 'CREATE TABLE') !== false) && (strpos($ret[$i], 'DEFAULT CHARSET='. str_replace('-', '', lk_CHARSET) )!== false))
            {
                $ret[$i] = str_replace('DEFAULT CHARSET='. str_replace('-', '', lk_CHARSET), '', $ret[$i]);
            }
            if (!empty($ret[$i]))
            {
               $GLOBALS['db']->query($ret[$i]);
            }
        }
    }
	
    return true;
}

/**
 * 将字节转成可阅读格式
 *
 * @access  public
 * @param
 *
 * @return void
 */
function num_bitunit($num)
{
    $bitunit = array(' B',' KB',' MB',' GB');
    for ($key = 0, $count = count($bitunit); $key < $count; $key++)
    {
       if ($num >= pow(2, 10 * $key) - 1) // 1024B 会显示为 1KB
       {
           $num_bitunit_str = (ceil($num / pow(2, 10 * $key) * 100) / 100) . " $bitunit[$key]";
       }
    }

    return $num_bitunit_str;
}

/**
 *
 *
 * @access  public
 * @param
 * @return  void
 */
function remove_comment($var)
{
    return (substr($var, 0, 2) != '--');
}

?>
