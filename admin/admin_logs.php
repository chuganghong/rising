<?php

define('IN_LK', true);
@session_start();

require(dirname(__FILE__) . '/includes/init.php');
check_admin();

/* act操作项的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

/* 初始化 $exc 对象 */
$exc = new exchange($lk->table("admin_log"), $db, 'log_id', 'log_info');

/*------------------------------------------------------ */
//-- 获取所有日志列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
	admin_priv('logs_manage');
	$sel_ip = isset($_REQUEST['admin_ip']) ? intval($_REQUEST['admin_ip']) : 0;
	$sel_id = isset($_REQUEST['admin_id']) ? intval($_REQUEST['admin_id']) : 0;

    /* 查询IP地址列表 */
    $ip_list = '';
    $res = $db->query("SELECT DISTINCT ip_address FROM " .$lk->table('admin_log'));
	
	while ($row = $db->fetch_array($res))
    {
        $ip_list .= "<option value='$row[ip_address]'";
        $ip_list .= ($sel_ip == $row['ip_address']) ? ' selected="true"' : '';
        $ip_list .= '>' . $row['ip_address']. '</option>';
    }
	
	/* 查询管理员列表 */
    $id_list = '';
	$sql = "SELECT DISTINCT al.user_id, au.true_name 
			FROM " .$lk->table('admin_log') . " AS al 
			LEFT JOIN " .$lk->table('admin_user') . " AS au 
			ON al.user_id = au.user_id ";
    $res = $db->query($sql);

	while ($row = $db->fetch_array($res))
    {
        $id_list .= "<option value='$row[user_id]'";
        $id_list .= ($sel_id == $row['user_id']) ? ' selected="true"' : '';
        $id_list .= '>' . $row['true_name']. '</option>';
    }

    $smarty->assign('ur_here',   '管理员日志');
    $smarty->assign('ip_list',   $ip_list);
	$smarty->assign('id_list',   $id_list);
    $smarty->assign('full_page', 1);

    $log_list = get_admin_logs();

    $smarty->assign('log_list',        $log_list['list']);
    $smarty->assign('filter',          $log_list['filter']);
    $smarty->assign('record_count',    $log_list['record_count']);
    $smarty->assign('page_count',      $log_list['page_count']);

    $smarty->display('admin_logs.html');
}

/*------------------------------------------------------ */
//-- 排序、分页、查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $log_list = get_admin_logs();

    $smarty->assign('log_list',        $log_list['list']);
    $smarty->assign('filter',          $log_list['filter']);
    $smarty->assign('record_count',    $log_list['record_count']);
    $smarty->assign('page_count',      $log_list['page_count']);

    make_json_result($smarty->fetch('admin_logs.html'), '',
        array('filter' => $log_list['filter'], 'page_count' => $log_list['page_count']));
}

/*------------------------------------------------------ */
//-- 批量删除日志记录
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'batch_drop')
{
	admin_priv('logs_drop');
    $drop_type_date = isset($_POST['drop_type_date']) ? $_POST['drop_type_date'] : '';

    /* 按日期删除日志 */
    if ($drop_type_date)
    {
        if ($_POST['log_date'] == '0')
        {
            header("Location: admin_logs.php?act=list\n");
            exit;
        }
        elseif ($_POST['log_date'] > '0')
        {
            $where = " WHERE 1 ";
            switch ($_POST['log_date'])
            {
                case '1':
                    $a_week = time()-(3600 * 24 * 7);
                    $where .= " AND log_time <= '".$a_week."'";
                    break;
                case '2':
                    $a_month = time()-(3600 * 24 * 30);
                    $where .= " AND log_time <= '".$a_month."'";
                    break;
                case '3':
                    $three_month = time()-(3600 * 24 * 90);
                    $where .= " AND log_time <= '".$three_month."'";
                    break;
                case '4':
                    $half_year = time()-(3600 * 24 * 180);
                    $where .= " AND log_time <= '".$half_year."'";
                    break;
                case '5':
                    $a_year = time()-(3600 * 24 * 365);
                    $where .= " AND log_time <= '".$a_year."'";
                    break;
            }
            $sql = "DELETE FROM " .$lk->table('admin_log').$where;
            $res = $db->query($sql);
            if ($res)
            {
                if($db->affected_rows()) admin_log('','remove', 'adminlog');

                $link[] = array('text' => '返回日志列表', 'href' => 'admin_logs.php?act=list');
                sys_msg('操作成功', 1, $link);
            }
        }
    }
    /* 如果不是按日期来删除, 就按ID删除日志 */
    else
    {
        $count = 0;
        foreach ($_POST['checkboxes'] AS $key => $id)
        {
			$result = $exc->drop($id);
            $count++;
        }
        if ($result)
        {
            admin_log('', 'remove', 'adminlog');

            $link[] = array('text' => '返回日志列表', 'href' => 'admin_logs.php?act=list');
            sys_msg(sprintf('成功删除了 %d 个日志记录', $count), 0, $link);
        }
    }
}

/* 获取管理员操作记录 */
function get_admin_logs()
{

    $filter = array();
	
	/* 查询参数 */
	if($_REQUEST['admin_ip']) $filter['admin_ip'] = $_REQUEST['admin_ip'];
	if($_REQUEST['admin_id']) $filter['admin_id'] = $_REQUEST['admin_id'];
	
    $filter['sort_by']     = empty($_REQUEST['sort_by']) ? 'al.log_id' : trim($_REQUEST['sort_by']);
    $filter['sort_order']  = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

    //查询条件
    $where = " WHERE 1 ";
	$where .= (!empty($filter['admin_ip'])) ? " AND al.ip_address = '$filter[admin_ip]' " : '';
	$where .= (!empty($filter['admin_id'])) ? " AND al.user_id = '$filter[admin_id]' " : '';

    /* 获得总记录数据 */
    $sql = 'SELECT COUNT(*) AS record FROM ' .$GLOBALS['lk']->table('admin_log'). ' AS al ' . $where;
    $filter['record_count'] = $GLOBALS['db']->get_row($sql);
	
	/* 分页大小 */
    $filter = page_and_size($filter);

    /* 获取管理员日志记录 */
    $list = array();
    $sql  = 'SELECT al.*, u.true_name FROM ' .$GLOBALS['lk']->table('admin_log'). ' AS al '.
            'LEFT JOIN ' .$GLOBALS['lk']->table('admin_user'). ' AS u ON u.user_id = al.user_id '.
            $where .' ORDER by '.$filter['sort_by'].' '.$filter['sort_order'];
    $res  = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    while ($rows = $GLOBALS['db']->fetch_array($res))
    {
        $rows['log_time'] = date('Y-m-d H:i:s', $rows['log_time']);

        $list[] = $rows;
    }

    return array('list' => $list, 'filter' => $filter, 'page_count' =>  $filter['page_count'], 'record_count' => $filter['record_count']);
}

?>