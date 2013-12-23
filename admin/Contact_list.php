<?php
define('IN_LK', true);
@session_start();
require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/cls_category.php');
include_once(ROOT_PATH . 'includes/cls_image.php');
check_admin();

$exc = new exchange($lk->table("contact_us"), $db, 'u_Id', 'u_Name');

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
	$smarty->assign('full_page',    1);
	$smarty->assign('ur_here',      "联系列表");
	
	$Contact = get_Contact();
    $smarty->assign('Contact',           $Contact['list']);
    $smarty->assign('filter',          $Contact['filter']);
    $smarty->assign('record_count',    $Contact['record_count']);
    $smarty->assign('page_count',      $Contact['page_count']);
	$smarty->display('Contact_list.html');
}
elseif ($_REQUEST['act'] == 'query')
{
    $Contact = get_Contact();

    $smarty->assign('Contact',         $Contact['list']);
    $smarty->assign('filter',        $Contact['filter']);
    $smarty->assign('record_count',  $Contact['record_count']);
    $smarty->assign('page_count',    $Contact['page_count']);

    make_json_result($smarty->fetch('Contact_list.html'), '',
        array('filter' => $Contact['filter'], 'page_count' => $Contact['page_count']));
}
if ($_REQUEST['act'] == 'remove')
{
	check_authz_json('Contact_drop');
    $Contact_id   = intval($_GET['id']);
		
	$Contact_name = $exc->get_name($Contact_id, 'u_Name');
	$exc->drop($Contact_id);
	admin_log($Contact_name, 'remove', 'Contact');

    $url = 'Contact_list.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    header("Location: $url\n");
    exit;
}
/* 批量删除 */
elseif ($_REQUEST['act'] == 'batch_drop')
{
	admin_priv('Contact_drop');
	$count = 0;
	foreach ((array)$_POST['checkboxes'] AS $key => $id)
	{
		$result = $exc->drop($id);
		$count++;
	}
	if ($result)
	{
		admin_log($count, 'remove', 'Contact');

		$link[] = array('text' => '返回交易信息列表', 'href' => 'Contact_list.php?act=list');
		sys_msg(sprintf('成功删除了 %d 个交易信息', $count), 0, $link);
	}else{
		$link[] = array('text' => '返回交易信息列表', 'href' => 'Contact_list.php?act=list');
		sys_msg('您没有选择要删除的记录!', 1, $link);	
	}
}

function get_Contact()
{
    $filter = array();
	
    //查询条件
    $where = " WHERE 1 ";
	
	/* 查询参数 */
	if($_REQUEST['searchs'])
	{
		//$where = " WHERE username like '%".$_REQUEST['searchs']."%' OR company_name like '%".$_REQUEST['searchs']."%'";
		$filter['searchs'] = $_REQUEST['searchs'];
		$where .= " and  d.u_Name like '%".$_REQUEST['searchs']."%'";
	}
	
    /* 获得总记录数据 */
  	$sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['lk']->table('contact_us'). ' AS d ' . $where ;
    $filter['record_count'] = $GLOBALS['db']->get_row($sql);
	/* 分页大小 */
    $filter = page_and_size($filter);

    $list = array();
	$sql = "SELECT d.* FROM " .$GLOBALS['lk']->table('contact_us'). " AS d 
			" .$where."
			ORDER BY d.u_Addtime DESC";
	
		
    $res  = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']) ;
    while ($rows = $GLOBALS['db']->fetch_array($res))
    {
		$rows['u_Addtime'] = date('Y-m-d H:i:s', $rows['addtime']);
		
		$list[] = $rows;
    }
    return array('list' => $list, 'filter' => $filter, 'page_count' =>  $filter['page_count'], 'record_count' => $filter['record_count']);
}
?>