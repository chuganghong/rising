<?php
define('IN_LK', true);
@session_start();
require(dirname(__FILE__) . '/includes/init.php');
check_admin();
/* 初始化 $exc 对象 */
$exc = new exchange($lk->table("role"), $db, 'role_id', 'role_name');

/* act操作项的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'login';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}
/*------------------------------------------------------ */
//-- 角色列表页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    $smarty->assign('ur_here',     '角色列表');
	$smarty->assign('action_text', '添加角色');
	$smarty->assign('action_href', 'role.php?act=add');
    $smarty->assign('full_page',   1);
    $smarty->assign('role_list',   get_role_list());
    $smarty->display('role_list.html');
}

/*------------------------------------------------------ */
//-- 查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $smarty->assign('role_list',  get_role_list());

    make_json_result($smarty->fetch('role_list.html'));
}

/*------------------------------------------------------ */
//-- 添加角色页面
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add')
{
	admin_priv('role_manage');
	include_once('ini/priv_action.php');
	
	$priv_str = '';
	
    /* 获取权限的分组数据 */
    $sql_query = "SELECT action_id, parent_id, action_code FROM " .$lk->table('admin_action').
                 " WHERE parent_id = 0";
    $res = $db->query($sql_query);
    while ($rows = $db->fetch_array($res))
    {
        $priv_arr[$rows['action_id']] = $rows;
    }

    /* 按权限组查询底级的权限名称 */
    $sql = "SELECT action_id, parent_id, action_code FROM " .$lk->table('admin_action').
           " WHERE parent_id " .db_create_in(array_keys($priv_arr));
    $result = $db->query($sql);
    while ($priv = $db->fetch_array($result))
    {
        $priv_arr[$priv["parent_id"]]["priv"][$priv["action_code"]] = $priv;
    }

    /* 将同一组的权限使用 "," 连接起来，供JS全选 */
    foreach ($priv_arr AS $action_id => $action_group)
    {
        $priv_arr[$action_id]['priv_list'] = join(',', @array_keys($action_group['priv']));

        foreach ($action_group['priv'] AS $key => $val)
        {
            $priv_arr[$action_id]['priv'][$key]['cando'] = (strpos($priv_str, $val['action_code']) !== false || $priv_str == 'all') ? 1 : 0;
        }
    }

	$smarty->assign('priv_arr',    $priv_arr);
	$smarty->assign('count',       $count); //用来计算频道权限的数量
	$smarty->assign('lang',        $_LANG);
	$smarty->assign('ur_here',     '添加角色');
	$smarty->assign('action_text', '角色列表');
	$smarty->assign('action_href', 'role.php?act=list');
    $smarty->assign('form_act',    'insert');
    $smarty->assign('action',      'add');
    $smarty->display('role_info.html');
}

/*------------------------------------------------------ */
//-- 添加角色的处理
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'insert')
{
	admin_priv('role_manage');
	
	if($_POST['checkall'])
	{
		$act_list = 'all';
		$cat_list = 'all';
	}else{
		$act_list = @join(",", $_POST['action_code']);
		if ($_POST['count'] == count($_POST['cat_code'])) 
			$cat_list = 'all';
		else
			$cat_list = @join(",", $_POST['cat_code']);
	}
	
	$set = "role_name = '".trim($_POST['role_name'])."', action_list ='".$act_list."', 
			role_describe     = '".trim($_POST['role_describe'])."'";
	$exc->insert($set);
	
	admin_log($_POST['role_name'], 'add', 'role');
	
	/*添加链接*/
	$link[0]['text'] = '返回列表';
	$link[0]['href'] = 'role.php?act=list';
	
	$link[1]['text'] = '继续添加';
	$link[1]['href'] = 'role.php?act=add';
	
	sys_msg("添加 [ ".stripslashes($_POST['role_name'])." ] 角色成功", 0, $link);
}

/*------------------------------------------------------ */
//-- 编辑角色信息
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit')
{
	admin_priv('role_manage');
	include_once('ini/priv_action.php');
    $_REQUEST['id'] = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	
	$priv_str =  $db->get_row("SELECT action_list FROM " .$lk->table('role'). " WHERE role_id = '$_GET[id]'");
	$role_info = $exc->select('role_id, role_name, role_describe', $_REQUEST['id']);
	
	/* 获取权限的分组数据 */
    $sql_query = "SELECT action_id, parent_id, action_code FROM " .$lk->table('admin_action').
                 " WHERE parent_id = 0";
    $res = $db->query($sql_query);
    while ($rows = $db->fetch_array($res))
    {
        $priv_arr[$rows['action_id']] = $rows;
    }

    /* 按权限组查询底级的权限名称 */
    $sql = "SELECT action_id, parent_id, action_code FROM " .$lk->table('admin_action').
           " WHERE parent_id " .db_create_in(array_keys($priv_arr));
    $result = $db->query($sql);
    while ($priv = $db->fetch_array($result))
    {
        $priv_arr[$priv["parent_id"]]["priv"][$priv["action_code"]] = $priv;
    }

    /* 将同一组的权限使用 "," 连接起来，供JS全选 */
    foreach ($priv_arr AS $action_id => $action_group)
    {
        $priv_arr[$action_id]['priv_list'] = join(',', @array_keys($action_group['priv']));

        foreach ($action_group['priv'] AS $key => $val)
        {
            $priv_arr[$action_id]['priv'][$key]['cando'] = (strpos($priv_str, $val['action_code']) !== false || $priv_str == 'all') ? 1 : 0;
        }
    }
	
	
    $smarty->assign('role_info',   $role_info);
	$smarty->assign('lang',        $_LANG);
    $smarty->assign('priv_arr',    $priv_arr);
	$smarty->assign('count',       $count);
    $smarty->assign('form_act',    'update');
    $smarty->assign('action',      'edit');
    $smarty->assign('ur_here',     '编辑角色');
    $smarty->assign('action_text', '角色列表');
	$smarty->assign('action_href', 'role.php?act=add');

    $smarty->display('role_info.html');
}

/*------------------------------------------------------ */
//-- 更新角色信息
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'update')
{
	admin_priv('role_manage');
	
	if($_POST['checkall'])
	{
		$act_list = 'all';
		$cat_list = 'all';
	}else{
		$act_list = @join(",", $_POST['action_code']);
		if ($_POST['count'] == count($_POST['cat_code'])) 
			$cat_list = 'all';
		else
			$cat_list = @join(",", $_POST['cat_code']);
	}
	
	$set = "role_name = '". trim($_POST['role_name']) ."', action_list ='".$act_list."', 
			role_describe = '". $_POST['role_describe'] ."'";
	$exc->edit($set, $_POST['role_id']);
	admin_log($role_name, 'edit', 'role');
	
    $link[] = array('text' => '返回列表', 'href'=>'role.php?act=list');
	sys_msg("修改 [ ".stripslashes($_POST['role_name'])." ] 角色成功", 0, $link);
}

/*------------------------------------------------------ */
//-- 删除一个角色
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
	check_authz_json('role_manage');
    $id = intval($_GET['id']);
    $num_sql = "SELECT count(*) FROM " .$lk->table('admin_user'). " WHERE role_id = '$_GET[id]'";
    $remove_num = $db->get_row($num_sql);
    if($remove_num > 0)
    {
        make_json_error('此角色有管理员在使用,暂时不能删除!');
    }
    else
    {
		$role_name = $exc->get_name($id);
        $exc->drop($id);
		admin_log($role_name, 'remove', 'role');
        $url = 'role.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
    }

    header("Location: $url\n");
    exit;
}

/* 获取角色列表 */
function get_role_list()
{
    $list = array();
	
	$sql = "SELECT r.*, COUNT(au.user_id) AS num 
			FROM ". $GLOBALS['lk']->table('role') ." AS r
			LEFT JOIN ". $GLOBALS['lk']->table('admin_user') ." AS au
			ON r.role_id = au.role_id GROUP BY r.role_id 
			ORDER BY r.role_id";
	$result = $GLOBALS['db']->query($sql);
	while ($row = $GLOBALS['db']->fetch_array($result))
	{
		$row['num'] = $row['num'] ? $row['num'] : 0;
		$list[] = $row;
	}
    return $list;
}
?>
