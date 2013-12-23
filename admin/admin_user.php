<?php
define('IN_LK', true);
@session_start();
require(dirname(__FILE__) . '/includes/init.php');

check_admin();

/* 初始化 $exc 对象 */
$exc = new exchange($lk->table("admin_user"), $db, 'user_id', 'user_name');

/* act操作项的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'list')
{	
	$admin_role = isset($_REQUEST['admin_role']) ? intval($_REQUEST['admin_role']) : 0;
	
	/* 查询角色列表 */
    $role_list = '';
    $res = $db->query("SELECT * FROM " .$lk->table('role'));
	
	while ($row = $db->fetch_array($res))
    {
        $role_list .= "<option value='$row[role_id]'";
        $role_list .= ($admin_role == $row['role_id']) ? ' selected="true"' : '';
        $role_list .= '>' . $row['role_name']. '</option>';
    }

	$smarty->assign('full_page',   1);
    $smarty->assign('admin_list',  get_admin_userlist());
	$smarty->assign('role_list',   $role_list);
	
	$smarty->assign('action_text',  "添加管理员");
	$smarty->assign('action_href',  "admin_user.php?act=add");
	$smarty->assign('ur_here',      "管理员列表");
	$smarty->display('admin_user_list.html');
}

/*------------------------------------------------------ */
//-- 查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $smarty->assign('admin_list',  get_admin_userlist());

    make_json_result($smarty->fetch('admin_user_list.html'));
}

if ($_REQUEST['act'] == 'add')
{
	admin_priv('admin_manage');
	/* 查询角色列表 */
    $role_list = '';
    $res = $db->query("SELECT * FROM " .$lk->table('role'));
	
	while ($row = $db->fetch_array($res))
    {
        $role_list .= "<option value='$row[role_id]'";
        $role_list .= '>' . $row['role_name']. '</option>';
    }
	$user['user_id'] = $_SESSION['admin_id'];
	$smarty->assign('user',        $user);
	$smarty->assign('role_list',   $role_list);
	$smarty->assign('action',      'add');	
	$smarty->assign('action_text',  "管理员列表");
	$smarty->assign('action_href',  "admin_user.php?act=list");
	$smarty->assign('ur_here',      "添加管理员");	
	$smarty->assign('form_act',     'insert');
	
	$smarty->display('admin_user_info.html');
}

if ($_REQUEST['act'] == 'insert')
{
	admin_priv('admin_manage');
	/* 判断管理员是否已经存在 */
    if (!empty($_POST['user_name']))
    {
		$is_only = $exc->is_only('user_name', $_POST['user_name']);
		if ($is_only)
        {
            sys_msg(sprintf('该管理员 [%s] 已存在!', stripslashes($_POST['user_name'])), 1);
        }
	}
	
	$set = "user_name = '".trim($_POST['user_name'])."', 
			true_name = '".trim($_POST['true_name'])."',
			email     = '".$_POST['email']."', 
			password  = '".md5(trim($_POST['password']))."', 
			role_id   = '".$_POST['admin_role']."',
			add_time  = ".time();
	$exc->insert($set);
	admin_log($_POST['user_name'], 'add', 'admin_user');
	
	/*添加链接*/
	$link[0]['text'] = '返回列表';
	$link[0]['href'] = 'admin_user.php?act=list';
	
	$link[1]['text'] = '继续添加';
	$link[1]['href'] = 'admin_user.php?act=add';

	sys_msg("添加 [ ".stripslashes($_POST['user_name'])." ] 管理员成功", 0, $link);
}

if ($_REQUEST['act'] == 'edit')
{
	admin_priv('admin_manage');
	$id = $_REQUEST['id'];
	$set = 'user_id, user_name, true_name, email, password, role_id';
	$user_info = $exc->select($set, $id);

	/* 查询角色列表 */
    $role_list = '';
    $res = $db->query("SELECT * FROM " .$lk->table('role'));
	
	while ($row = $db->fetch_array($res))
    {
        $role_list .= "<option value='$row[role_id]'";
        $role_list .= ($user_info['role_id'] == $row['role_id']) ? ' selected="true"' : '';
        $role_list .= '>' . $row['role_name']. '</option>';
    }

	$smarty->assign('user',         $user_info);
	$smarty->assign('role_list',    $role_list);
	
	$smarty->assign('ur_here',      "编辑管理员");
	$smarty->assign('action_text',  "管理员列表");
	$smarty->assign('action_href',  "admin_user.php?act=list");
	$smarty->assign('form_act',     'update');
	$smarty->assign('action',       'edit');
	
	$smarty->display('admin_user_info.html');
}

if ($_REQUEST['act'] == 'update')
{
	admin_priv('admin_manage');
	/* 变量初始化 */
    $id    = !empty($_REQUEST['id'])        ? intval($_REQUEST['id'])      : 0;
    $user_name  = !empty($_REQUEST['user_name']) ? trim($_REQUEST['user_name']) : '';
	$true_name  = !empty($_REQUEST['true_name']) ? trim($_REQUEST['true_name']) : '';
    $email = !empty($_REQUEST['email'])     ? trim($_REQUEST['email'])     : '';
	$role_id     = !empty($_REQUEST['admin_role']) ? intval($_REQUEST['admin_role']) : 0;
	
	/* 判断管理员是否已经存在 */
    if (!empty($user_name))
    {
		$is_only = $exc->is_only('user_name', $user_name, $id);
		if ($is_only)
        {
            sys_msg(sprintf('该管理员 [%s] 已存在!', stripslashes($user_name)), 1);
        }
	}
	
	/* 更新管理员信息 */
	$set = "user_name = '$user_name', true_name = '$true_name', email = '$email' ,role_id = '$role_id' ";
	$exc->edit($set, $id);
	if($db->affected_rows()) admin_log($user_name, 'edit', 'admin_user');

	/* 提示信息 */
   $link[] = array('text' => '返回管理员列表', 'href'=>'admin_user.php?act=list');
   sys_msg("您已经成功的修改了个人帐号信息!<script>parent.document.getElementById('header-frame').contentWindow.document.location.reload();</script>", 0, $link);
}

/* 修改密码 */
if ($_REQUEST['act'] == 'pass')
{
	admin_priv('admin_pass');
	$id = $_REQUEST['id'];
	$user_info = $exc->select('user_id', $id);

	$smarty->assign('user',         $user_info);
	
	$smarty->assign('ur_here',      "编辑管理员");
	$smarty->assign('action_text',  "管理员列表");
	$smarty->assign('action_href',  "admin_user.php?act=list");
	$smarty->assign('form_act',     'update_pass');
	$smarty->assign('action',       'pass');
	
	$smarty->display('admin_user_info.html');
}

if ($_REQUEST['act'] == 'update_pass')
{
	admin_priv('admin_pass');
	$id = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	if (!empty($_POST['new_password']))
    {
        /* 查询旧密码并与输入的旧密码比较是否相同 */
		$sql = "SELECT * FROM ". $GLOBALS['lk']->table('admin_user') ." WHERE user_id = '$id'";
		$row = $db->get_one($sql);
        if ($row['password'] <> (md5($_POST['old_password'])))
        {
           $link[] = array('text' => '返回', 'href'=>'javascript:history.back(-1)');
           sys_msg('您输入的旧密码错误!', 0, $link);
        }

        /* 比较新密码和确认密码是否相同 */
        if ($_POST['new_password'] <> $_POST['pwd_confirm'])
        {
           $link[] = array('text' => '返回', 'href'=>'javascript:history.back(-1)');
           sys_msg('两次输入的密码不一致!', 0, $link);
        }
    }
	
	/* 更新管理员信息 */
	$set = "password = '".md5($_POST['new_password'])."' ";
	$exc->edit($set, $id);
	if($db->affected_rows()) admin_log($row['user_name'], 'edit', 'admin_user');

	/* 提示信息 */
   $link[] = array('text' => '返回管理员列表', 'href'=>'admin_user.php?act=list');
   sys_msg("您已经成功的修改了个人帐号密码!<script>parent.document.getElementById('header-frame').contentWindow.document.location.reload();</script>", 0, $link);
}
/* ajax 验证用户名 */
if ($_REQUEST['act'] == 'ajaxUser')
{
	$validateValue=$_POST['validateValue'];
	$validateId=$_POST['validateId'];
	$validateError=$_POST['validateError'];
	$id = $_REQUEST['id'];
	
	$arrayToJs = array();
	$arrayToJs[0] = $validateId;
	$arrayToJs[1] = $validateError;
	
	/* 判断管理员是否已经存在*/
	if ($exc->is_only('user_name', $validateValue, $id))
	{
		$arrayToJs[2] = "false";
		echo '{"jsonValidateReturn":'.json_encode($arrayToJs).'}';
	}else{
		$arrayToJs[2] = "true";
		echo '{"jsonValidateReturn":'.json_encode($arrayToJs).'}';	
	}
}
/* ajax 验证密码 */
if ($_REQUEST['act'] == 'ajaxPass')
{
	$validateValue=$_POST['validateValue'];
	$validateId=$_POST['validateId'];
	$validateError=$_POST['validateError'];
	$id = $_REQUEST['id'];
	
	$arrayToJs = array();
	$arrayToJs[0] = $validateId;
	$arrayToJs[1] = $validateError;
	
	/* 查询旧密码并与输入的旧密码比较是否相同 */
	$old_password = $exc->get_name($id, 'password');

	if ($old_password <> (md5($validateValue)))
	{
		$arrayToJs[2] = "false";
		echo '{"jsonValidateReturn":'.json_encode($arrayToJs).'}';
	}else{
		$arrayToJs[2] = "true";
		echo '{"jsonValidateReturn":'.json_encode($arrayToJs).'}';
	}
}
if ($_REQUEST['act'] == 'remove')
{
	check_authz_json('admin_drop');
	$id = intval($_GET['id']);
	
	/* ID为1的不允许删除 */
    if ($id == 1)
    {
        make_json_error('该管理员为超级管理员,不能删除');
    }

    /* 管理员不能删除自己 */
    if ($id == $_SESSION['admin_id'])
    {
        make_json_error('当前管理员不允许删除!');
    }
	$name = $exc->get_name($id);
	$exc->drop($id);
	if($db->affected_rows()) admin_log($name, 'remove', 'admin_user');
	
	$url = 'admin_user.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
	
	header("Location: $url\n");
    exit;
}

/* 获取管理员列表 */
function get_admin_userlist()
{
	if($_REQUEST['admin_role']) $where = " WHERE au.role_id = '". $_REQUEST['admin_role'] ."'"; 
	
    $list = array();
	$sql = "SELECT au.*, r.role_name FROM ". $GLOBALS['lk']->table('admin_user') ." AS au 
			LEFT JOIN ". $GLOBALS['lk']->table('role') ." AS r 
			ON au.role_id = r.role_id 
			$where  ORDER BY au.user_id DESC";
	
    $list = $GLOBALS['db']->getAll($sql);

    foreach ($list AS $key=>$val)
    {
        $list[$key]['add_time']     = date('Y-m-d H:i:s', $val['add_time']);
        $list[$key]['last_login']   = $val['last_login'] ? date('Y-m-d H:i:s',$val['last_login']) : 'N/A';
    }

    return $list;
}
?>