<?php
define('IN_LK', true);
@session_start();
require(dirname(__FILE__) . '/includes/init.php');
check_admin();

$exc = new exchange($lk->table("static_page"), $db, 'id', 'title');

/* act操作项的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}
if ($_REQUEST['act'] == 'add')
{
	admin_priv('page_manage');

	$smarty->assign('content',  createCkedit("content"));	
	$smarty->assign('action_text',  "返回单个页面列表");
	$smarty->assign('action_href',  "static_page.php?act=list");
	$smarty->assign('ur_here',      "添加单个页面");
	
	$smarty->assign('form_act',     'insert');
	$smarty->display('static_page_info.html');
}
elseif ($_REQUEST['act'] == 'insert')
{
	admin_priv('page_manage');
	/* 标题是否相同 */
	if($exc->is_only('title', $_POST['title']))
	{
		sys_msg("此页面已存在！", 1);
	}
	check_badkey($_POST['content']);
	
	$set = "title = '".$_POST['title']."',
			keyword  = '".$_POST['keyword']."',
			content  = '".$_POST['content']."',
			addtime  = '".time()."',
			author  = '".$_SESSION['admin_true']."'";
	$exc->insert($set);

	/*添加链接*/
	$link[0]['text'] = '返回单个页面列表';
	$link[0]['href'] = 'static_page.php?act=list';
	
	$link[1]['text'] = '继续添加单个页面';
	$link[1]['href'] = 'static_page.php?act=add';
	
	admin_log($_POST['title'], 'add', 'static_page');   // 记录管理员操作
	sys_msg("添加 [ ".stripslashes($_POST['title'])." ] 单个页面成功", 0, $link);
}

elseif ($_REQUEST['act'] == 'list')
{
	$smarty->assign('full_page',    1);
	$smarty->assign('action_text',  "添加单个页面");
	$smarty->assign('action_href',  "static_page.php?act=add");
	$smarty->assign('ur_here',      "单个页面列表");
	
	$static = get_static();

    $smarty->assign('static',          $static['list']);
    $smarty->assign('filter',          $static['filter']);
    $smarty->assign('record_count',    $static['record_count']);
    $smarty->assign('page_count',      $static['page_count']);
	$smarty->display('static_page_list.html');
}
elseif ($_REQUEST['act'] == 'query')
{
    $static = get_static();

    $smarty->assign('static',        $static['list']);
    $smarty->assign('filter',        $static['filter']);
    $smarty->assign('record_count',  $static['record_count']);
    $smarty->assign('page_count',    $static['page_count']);

    make_json_result($smarty->fetch('static_page_list.html'), '',
        array('filter' => $static['filter'], 'page_count' => $static['page_count']));
}

elseif ($_REQUEST['act'] == 'edit')
{
	admin_priv('page_manage');
	
	$id = $_REQUEST['id'] ? $_REQUEST['id'] : 0;	
	$row = $exc->select('*', $id);

	$smarty->assign('content',  createCkedit("content",$row['content']));	
	$smarty->assign('row',      stripslashes_array($row));
	$smarty->assign('action_text',  "返回单个页面列表");
	$smarty->assign('action_href',  "static_page.php?act=list");
	$smarty->assign('ur_here',      "编辑单个页面");
	$smarty->assign('form_act',     'update');
	
	$smarty->display('static_page_info.html');
}

elseif ($_REQUEST['act'] == 'update')
{
	admin_priv('page_manage');
	$id = $_REQUEST['id'] ? $_REQUEST['id'] : 0;
	/* 标题是否相同 */
	if($exc->is_only('title', $_POST['title'], $id))
	{
		sys_msg("此页面已存在！", 1);
	}
	check_badkey($_POST['content']);
	
	$set="title = '".$_POST['title']."',
			keyword  = '".$_POST['keyword']."',
			content  = '".$_POST['content']."'";
				 
	$exc->edit($set,$id);
	
	$link[0]['text'] = '返回单个页面列表';
	$link[0]['href'] = 'static_page.php?act=list';
	
	admin_log($_POST['title'], 'edit', 'static_page'); // 记录管理员操作
	sys_msg("修改 [ ".stripslashes($_POST['title'])." ] 单个页面成功", 0, $link);
}

elseif ($_REQUEST['act'] == 'remove')
{
	check_authz_json('page_manage');
    $id   = intval($_GET['id']);
	$static_name = $exc->get_name($id, 'title');
	
	$exc->drop($id);
	admin_log($static_name, 'remove', 'static_page');

    $url = 'static_page.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    header("Location: $url\n");
    exit;
}

function get_static()
{
    $filter = array();
	
    /* 获得总记录数据 */
    $sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['lk']->table('static_page');
    $filter['record_count'] = $GLOBALS['db']->get_row($sql);
	
	/* 分页大小 */
    $filter = page_and_size($filter);

    $list = array();
	
	$sql = "SELECT * FROM " .$GLOBALS['lk']->table('static_page') ." 
			ORDER BY addtime DESC";
    $res  = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']) ;

    while ($rows = $GLOBALS['db']->fetch_array($res))
    {
		$rows['addtime'] = date('Y-m-d H:i:s', $rows['addtime']);
		$list[] = $rows;
    }
    return array('list' => $list, 'filter' => $filter, 'page_count' =>  $filter['page_count'], 'record_count' => $filter['record_count']);
}
?>