<?php
define('IN_LK', true);
@session_start();
require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/cls_category.php');
include_once(ROOT_PATH . 'includes/cls_image.php');
check_admin();

$image = new cls_image();
$image->fileFormat = array('gif', 'jpg', 'png', 'jpeg', 'bmp');
$exc = new exchange($lk->table('news_link'), $db, 'cat_id', 'cat_name');


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
	admin_priv('link_manage');
 	
	/*设置默认的表单变量*/
    $smarty->assign('row', array('sort_order'=>0, 'show_in_nav'=>1));
	
	$smarty->assign('action_text',  "返回案例栏目");
	$smarty->assign('action_href',  "news_link.php?act=list");
	$smarty->assign('ur_here',      "添加案例栏目");
	
	$smarty->assign('form_act',     'insert');
	
	$smarty->display('news_link_info.html');
}
/*此栏目不需要增加数据功能，故不要此段代码
if ($_REQUEST['act'] == 'insert')
{
	admin_priv('link_manage');
	$parent_id = 0;
	$where = "parent_id = ".$parent_id;
	$is_only = $exc->is_only('cat_name', $_POST['cat_name'], 0, $where);

	if($is_only)
	{
		sys_msg("案例栏目已存在！", 1);
	}
	
	// 初始化变量 
	$sort_order = $_POST['sort_order'] ? $_POST['sort_order'] : 0;	
	$tid = 1;   //1友链，0为栏目
	$set = "parent_id = ".$parent_id.",
			cat_name  = '".$_POST['cat_name']."',			
			tid  = ".$tid.",			
			sort_order  = ".$sort_order.",			
            action_name  = '".$_POST['action_name']."'";
	$exc->insert($set);
		
	//添加链接
	$link[0]['text'] = '返回列表';
	$link[0]['href'] = 'news_link.php?act=list';
	
	$link[1]['text'] = '继续添加';
	$link[1]['href'] = 'news_link.php?act=add&Caselocaid='.$selMenu;
	
	admin_log($_POST['cat_name'], 'add', 'case_cat');   // 记录管理员操作
	sys_msg("添加 [ ".stripslashes($_POST['cat_name'])." ] 成功", 0, $link);
}
*/
if ($_REQUEST['act'] == 'list')
{	
	$cat_id = $_REQUEST['cat_id'];
	$Caseloca = get_links($cat_id,$db);
	
	$smarty->assign('Caseloca',$Caseloca);
	$smarty->assign('full_page',    1);
	
	/*不需要增加
	$smarty->assign('action_text',  "添加案例栏目");
	$smarty->assign('action_href',  "news_link.php?act=add");
	*/
	$smarty->assign('ur_here',      "案例栏目列表");
	
	$smarty->display('news_link_list.html');
	
}

if ($_REQUEST['act'] == 'edit')
{
	admin_priv('link_manage');
	$cat_id = $_REQUEST['cat_id'];
	$row = $exc->select(' * ', $cat_id);
	
	$smarty->assign('row',      stripslashes_array($row));
	
	$url = "news_link.php?act=list&cat_id=" . $cat_id;
	
	$smarty->assign('action_text',  "返回案例栏目");
	$smarty->assign('action_href',  $url);
	$smarty->assign('ur_here',      "编辑案例栏目");
	$smarty->assign('form_act',     'update');
	
	$smarty->display('news_link_info.html');
}

if ($_REQUEST['act'] == 'update')
{	
	admin_priv('link_manage');
	$cat_id = $_REQUEST['cat_id'];
	$parent_id = $_REQUEST['parent_id'];
	$cat_desc = $_REQUEST['cat_desc'];   //description of topic
	
	if (empty($cat_id)) sys_msg("参数错误", 1);	
	
	/* 检查栏目是否存在 */
	$where = " cat_id= " . $cat_id;	
	$is_only = $exc->is_only('cat_name', $_POST['cat_name'], $cat_id, $where);

	if($is_only)
	{
		sys_msg("该栏目已存在！", 1);
	}

	
	if ((isset($_FILES['img_file_src']['error']) && $_FILES['img_file_src']['error'] == 0) || (!isset($_FILES['img_file_src']['error']) && isset($_FILES['img_file_src']['tmp_name'] ) && $_FILES['img_file_src']['tmp_name'] != 'none'))
	{
		
		$dir = 'data/game_logo';
		$sql = "SELECT * FROM " . $lk->table('news_link')." where cat_id = '".$cat_id."'";
		$img = $db->get_one($sql);
		
		if($img['pic'])
		{
			@unlink('../'.$img['pic']);
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
		$set = "pic= '".$gallery."',";
		
	}
	else
	{
		$set = "pic= '".trim($_POST['cat_pic'])."',";		
	}
	
	
	$set .=  "cat_name  = '".$_POST['cat_name']."',
			sort_order  = ".$_POST['sort_order'].",	
			cat_desc = '" . $cat_desc . "',
            action_name  = '".$_POST['action_name']."'";	
	
	$exc->edit($set, $cat_id);
	
	
	$url = "news_link.php?act=list&cat_id=" .$parent_id;
	
	
	$link[0]['text'] = '返回列表';
	$link[0]['href'] = $url;
	
	admin_log($_POST['cat_name'], 'edit', 'case_cat'); // 记录管理员操作
	sys_msg("修改 [ ".stripslashes($_POST['cat_name'])." ] 成功", 0, $link);
}

if ($_REQUEST['act'] == 'remove')
{
	check_authz_json('Case_cat_drop');
    /* 初始化分类ID并取得分类名称 */
    $cat_id   = intval($_GET['id']);
	$cat_name = $exc->get_name($cat_id, 'cat_name');
	
	/*这只是链接表，不需要防止其下有子信息而被禁止删除的功能。
    // 当前分类下是否有子信息
    $Case_count = $db->get_row("SELECT COUNT(*) FROM " .$lk->table('link'). " WHERE cat_id = '$cat_id'");

	//如果不存在信息，则删除之
    if ($Case_count == 0)
    {
        // 删除分类
		$exc->drop($cat_id);
		admin_log($cat_name, 'remove', 'Case_cat');
    }
    else
    {
        make_json_error('此分类下还存在有信息,您不能删除!');
    }
	*/
	
	$exc->drop($cat_id);
    $url = 'news_link.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    header("Location: $url\n");
    exit;
}
/*------------------------------------------------------ */
//-- 排序、分页、查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $Caseloca = $Caseloca->showCategory(0);
	$smarty->assign('Caseloca',$Caseloca);

    make_json_result($smarty->fetch('news_link_list.html'));
}

/**
 *获取链接数据
 *@param integer $cat_id 栏目ID
 *@param object $db   数据库类
 *@return array $data 存储数据库查询结果的二维数组
 */
function get_links($parent_id,$db)
{
	$limit = 2;
	$sql = "SELECT * FROM sd_news_link ";
	$sql .= "WHERE parent_id = $parent_id ";
	$sql .= "ORDER BY sort_order DESC,";
	$sql .= "cat_id DESC ";
	$sql .= "LIMIT $limit";
	
	$res = $db->query($sql);
	while($row = mysql_fetch_assoc($res))
	{
		$data[] = $row;
	}
	
	return $data;
	
}
?>