<?php
define('IN_LK', true);
@session_start();
require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/cls_category.php');
include_once(ROOT_PATH . 'includes/cls_image.php');
check_admin();

$times=time();
$image = new cls_image();
$image->fileFormat = array('gif', 'jpg', 'png', 'jpeg', 'bmp');
header("Cache-control: private");  
$exc = new exchange($lk->table("Case"), $db, 'Case_id', 'title');
$Case_cat = new category($lk->table("Case_cat"));

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
	admin_priv('Case_manage');
	$Case_cat = $Case_cat->toSelect(0);
	
	$smarty->assign('content',   createCkedit("content"));
	$smarty->assign('content_tw',   createCkedit("content_tw"));
	$smarty->assign('content_en',   createCkedit("content_en"));
	$smarty->assign('Case_cat', stripslashes_array($Case_cat));
	
	/*设置默认的表单变量*/
	$smarty->assign('row', array('sort_order'=>0));
	
	
	$smarty->assign('action_text',  "返回案例列表");
	$smarty->assign('action_href',  "Case.php?act=list");
	$smarty->assign('ur_here',      "添加案例信息");
	
	$smarty->assign('form_act',     'insert');
	$smarty->display('Case_info.html');
}
if ($_REQUEST['act'] == 'insert')
{
	admin_priv('Case_manage');
	check_badkey($_POST['content']);
	
	/* 初始化变量 */
	$sort_order = $_POST['sort_order'] ? $_POST['sort_order'] : 0;
	$cat_id = empty($_POST['cat_id']) ? 0 : intval($_POST['cat_id']);
	$addtime = time();
	
//	/* 标题是否相同 */
// 	$sql = "SELECT COUNT(*) FROM " . $lk->table('Case') . " 
//			WHERE title = '".$_POST['title']."' AND cat_id = '".$cat_id."' 
//			AND DATE_FORMAT(FROM_UNIXTIME(addtime),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') "
//			;
//	if($db->get_row($sql)) sys_msg("此案例信息今天已添加！", 1);
	
	if ((isset($_FILES['img_file_src']['error']) && $_FILES['img_file_src']['error'] == 0) || (!isset($_FILES['img_file_src']['error']) && isset($_FILES['img_file_src']['tmp_name'] ) && $_FILES['img_file_src']['tmp_name'] != 'none'))
	{
		$dir = 'data/game_logo';
		if ($_FILES['img_file_src']['size'] > 204800)
		{
			sys_msg("错误:图片大小不得超过200KB!", 1);
		}
		if (!$image->make_dir(ROOT_PATH . $dir))
		{
			sys_msg("错误:$image->error_msg()", 1);
		}
		$gallery = ''.$image->upload_image($_FILES['img_file_src'], $dir);
		//$gallery_thumb = $image->make_thumb($gallery, 186,188,ROOT_PATH . $dir.'/');
		//@unlink($gallery);
	}
	
	$set = "title = '".$_POST['title']."',
			keyword  = '".$_POST['keyword']."',
			sort_order  = ".$sort_order.",
			g_pic= '$gallery',
			content  = '".$_POST['content']."',
			title_en  = '".$_POST['title_en']."',
			keyword_en  = '".$_POST['keyword_en']."',
			content_en  = '".$_POST['content_en']."',
			title_tw  = '".$_POST['title_tw']."',
			keyword_tw  = '".$_POST['keyword_tw']."',
			content_tw  = '".$_POST['content_tw']."',
			addtime  = '".$addtime."',
		    author  = '".$_SESSION['admin_true']."',
			cat_id  = '".$cat_id."'";
	$exc->insert($set);

	/*添加链接*/
	$link[0]['text'] = '继续添加案例信息';
	$link[0]['href'] = 'Case.php?act=add';
	$link[1]['text'] = '返回案例列表';
	$link[1]['href'] = 'Case.php?act=list';
	
	admin_log($_POST['title'], 'add', 'Case');   // 记录管理员操作
	sys_msg("添加 [ ".stripslashes($_POST['title'])." ] 案例信息成功", 0, $link);
}

if ($_REQUEST['act'] == 'list')
{
	$cat_id   = isset($_REQUEST['cat_id']) ? intval($_REQUEST['cat_id']) : 0;
    /* 查询类型列表 */
    $cat_list = $Case_cat->toSelect(0,$cat_id);
	$smarty->assign('cat_list',      $cat_list);
	
	$smarty->assign('full_page',    1);
	$smarty->assign('action_text',  "添加案例信息");
	$smarty->assign('action_href',  "Case.php?act=add");
	$smarty->assign('ur_here',      "案例列表");
	
	$Case = get_Case();
    $smarty->assign('Case',           $Case['list']);
    $smarty->assign('filter',          $Case['filter']);
    $smarty->assign('record_count',    $Case['record_count']);
    $smarty->assign('page_count',      $Case['page_count']);
	$smarty->display('Case_list.html');
}
elseif ($_REQUEST['act'] == 'query')
{
    $Case = get_Case();

    $smarty->assign('Case',         $Case['list']);
    $smarty->assign('filter',        $Case['filter']);
    $smarty->assign('record_count',  $Case['record_count']);
    $smarty->assign('page_count',    $Case['page_count']);

    make_json_result($smarty->fetch('Case_list.html'), '',
        array('filter' => $Case['filter'], 'page_count' => $Case['page_count']));
}

if ($_REQUEST['act'] == 'edit')
{
	admin_priv('Case_manage');
	
		$Case_id=$_REQUEST['Case_id'];
		$row = $exc->select('*', $Case_id);
		$Case_cat = $Case_cat->toSelect(0,$row['cat_id']);
		$smarty->assign('Case_cat',stripslashes_array($Case_cat));
		
		$smarty->assign('content',  createCkedit("content",$row['content']));
		$smarty->assign('content_tw',  createCkedit("content_tw",$row['content_tw']));
		$smarty->assign('content_en',  createCkedit("content_en",$row['content_en']));
		$smarty->assign('row',      stripslashes_array($row));
		$smarty->assign('action_text',  "返回案例列表");
		$smarty->assign('action_href',  "Case.php?act=list");

	
	$smarty->assign('ur_here',      "编辑案例信息");
	$smarty->assign('form_act',     'update');
	
	$smarty->display('Case_info.html');
}

if ($_REQUEST['act'] == 'update')
{
	admin_priv('Case_manage');
	
	$Case_id = $_REQUEST['Case_id'];
	
	$addtime = date('Y-m-d',$_POST['addtime']);
	check_badkey($_POST['content']);
	
	$updatetime = time();
	
	///* 标题是否相同 */
//	$sql = "SELECT COUNT(*) FROM " . $lk->table('Case') . " 
//			WHERE title = '".$_POST['title']."' AND cat_id = '".$_POST['cat_id']."' AND Case_id<>$Case_id 
//			AND DATE_FORMAT(FROM_UNIXTIME(addtime),'%Y-%m-%d') = '".$addtime."'";
//	if($db->get_row($sql)) sys_msg("此案例信息今天已添加！", 1);
	
	if ((isset($_FILES['img_file_src']['error']) && $_FILES['img_file_src']['error'] == 0) || (!isset($_FILES['img_file_src']['error']) && isset($_FILES['img_file_src']['tmp_name'] ) && $_FILES['img_file_src']['tmp_name'] != 'none'))
	{
		$dir = 'data/game_logo';
		$sql = "SELECT * FROM " . $lk->table('Case')." where Case_id = '".$Case_id."'";
		$img = $db->get_one($sql);
		if($img['g_pic'])
		{
			@unlink('../'.$img['g_pic']);
		}
		if ($_FILES['img_file_src']['size'] > 204800)
		{
			sys_msg("错误:图片大小不得超过200KB!", 1);
		}
		if (!$image->make_dir(ROOT_PATH . $dir))
		{
			sys_msg("错误:$image->error_msg()", 1);
		}
		$gallery = ''.$image->upload_image($_FILES['img_file_src'], $dir);
		//$gallery_thumb = $image->make_thumb($gallery, 186,118,ROOT_PATH . $dir.'/');
		//@unlink($gallery);
		$set = "g_pic= '".$gallery."'";
		$exc->edit($set,$Case_id);
	}
	else
	{
		$set = "g_pic= '".trim($_POST['g_pic'])."'";
		$exc->edit($set,$Case_id);
	}
	
	
	
	$set="title = '".$_POST['title']."',
			keyword  = '".$_POST['keyword']."',
			sort_order  = '".$_POST['sort_order']."',
			content  = '".$_POST['content']."',
			title_en  = '".$_POST['title_en']."',
			keyword_en  = '".$_POST['keyword_en']."',
			content_en  = '".$_POST['content_en']."',
			title_tw  = '".$_POST['title_tw']."',
			keyword_tw  = '".$_POST['keyword_tw']."',
			content_tw  = '".$_POST['content_tw']."',
			updatetime  = '".$updatetime."',
			cat_id  = '".$_POST['cat_id']."'";
				 
	$exc->edit($set,$Case_id);
	
	$link[0]['text'] = '返回案例列表';
	
	$link[0]['href'] = 'Case.php?act=list';
	
	admin_log($_POST['title'], 'edit', 'Case'); // 记录管理员操作
	sys_msg("修改 [ ".stripslashes($_POST['title'])." ] 案例信息成功", 0, $link);
}
if ($_REQUEST['act'] == 'remove')
{
	check_authz_json('Case_drop');
    $Case_id   = intval($_GET['id']);
		
	$Case_name = $exc->get_name($Case_id, 'title');
	$exc->drop($Case_id);
	admin_log($Case_name, 'remove', 'Case');

    $url = 'Case.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    header("Location: $url\n");
    exit;
}
/* 批量删除 */
elseif ($_REQUEST['act'] == 'batch_drop')
{
	admin_priv('Case_drop');
	$count = 0;
	foreach ((array)$_POST['checkboxes'] AS $key => $id)
	{
		$result = $exc->drop($id);
		$count++;
	}
	if ($result)
	{
		admin_log($count, 'remove', 'Case');

		$link[] = array('text' => '返回交易信息列表', 'href' => 'Case.php?act=list');
		sys_msg(sprintf('成功删除了 %d 个交易信息', $count), 0, $link);
	}else{
		$link[] = array('text' => '返回交易信息列表', 'href' => 'Case.php?act=list');
		sys_msg('您没有选择要删除的记录!', 1, $link);	
	}
}

function get_Case()
{
    $filter = array();
	
    /* 查询参数 */
	if($_REQUEST['cat_id'])
	{
		$filter['cat_id'] = $_REQUEST['cat_id'];
		$category_id = $GLOBALS['Case_cat']->recursive($filter['cat_id']);	
	}
	
    //查询条件
    $where = " WHERE 1 ";
	$where .= (!empty($filter['cat_id'])) ? " AND d.cat_id in ( $category_id ) " : '';
	
	/* 查询参数 */
	if($_REQUEST['searchs'])
	{
		//$where = " WHERE username like '%".$_REQUEST['searchs']."%' OR company_name like '%".$_REQUEST['searchs']."%'";
		$filter['searchs'] = $_REQUEST['searchs'];
		$where .= " and  (d.title like '%".$_REQUEST['searchs']."%' OR d.title_en like '%".$_REQUEST['searchs']."%')";
	}
	
    /* 获得总记录数据 */
  	$sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['lk']->table('Case'). ' AS d ' . $where ;
    $filter['record_count'] = $GLOBALS['db']->get_row($sql);
	/* 分页大小 */
    $filter = page_and_size($filter);

    $list = array();
	$sql = "SELECT d.*, c.cat_name FROM " .$GLOBALS['lk']->table('Case'). " AS d 
			LEFT JOIN " .$GLOBALS['lk']->table('Case_cat'). " AS c 
			ON d.cat_id = c.cat_id " .$where."
			ORDER BY d.addtime DESC";
	
		
    $res  = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']) ;
    while ($rows = $GLOBALS['db']->fetch_array($res))
    {
		$rows['addtime'] = date('Y-m-d H:i:s', $rows['addtime']);
		if($rows['updatetime'])
		{
			$rows['updatetime'] = date('Y-m-d H:i:s', $rows['updatetime']);
		}
		$list[] = $rows;
    }
    return array('list' => $list, 'filter' => $filter, 'page_count' =>  $filter['page_count'], 'record_count' => $filter['record_count']);
}
?>