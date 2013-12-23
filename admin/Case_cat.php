<?php
define('IN_LK', true);
@session_start();
require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/cls_category.php');
include_once(ROOT_PATH . 'includes/cls_image.php');

check_admin();

$image = new cls_image();
$image->fileFormat = array('gif', 'jpg', 'png', 'jpeg', 'bmp');
$exc = new exchange($lk->table("case_cat"), $db, 'cat_id', 'cat_name');
$Caseloca = new category($lk->table("case_cat"));

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
	admin_priv('Case_cat_manage');
 	$Caselocaid = empty($_REQUEST['Caselocaid']) ? 0 : $_REQUEST['Caselocaid'];
	$Caseloca = $Caseloca->toSelect(0,$Caselocaid);

	$smarty->assign('Caseloca',     stripslashes_array($Caseloca));
	
	/*设置默认的表单变量*/
    $smarty->assign('row', array('sort_order'=>0, 'show_in_nav'=>1));
	
	$smarty->assign('action_text',  "返回案例栏目");
	$smarty->assign('action_href',  "Case_cat.php?act=list");
	$smarty->assign('ur_here',      "添加案例栏目");
	
	$smarty->assign('form_act',     'insert');
	
	$smarty->display('Case_cat_info.html');
}

if ($_REQUEST['act'] == 'insert')
{
	admin_priv('Case_cat_manage');
	/* 检查商品分类是否存在 */
	$selMenu = $_POST['selMenu'];
	$where = "parent_id = '".$selMenu."'";
	$is_only = $exc->is_only('cat_name', $_POST['cat_name'], 0, $where);

	if($is_only)
	{
		sys_msg("案例栏目已存在！", 1);
	}
	
	$is_action=checkAction($_POST['Action_name']);
	if($is_action=='NO' && $_POST['Action_name'] && $_POST['Action_name']!='daohang')
	{
		sys_msg("不存在模块名！", 1);
	}
	
	/* 初始化变量 */
	$sort_order = $_POST['sort_order'] ? $_POST['sort_order'] : 0;
	//$typeid=($_POST['selMenu']==0)?'3':$_POST['typeid'];
	$typeid=$_POST['typeid'];
	
	
	//上传图片
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
	
	$set = "parent_id = ".$_POST['selMenu'].",
			cat_name  = '".$_POST['cat_name']."',
			cat_name_en  = '".$_POST['cat_name_en']."',
			keywords_en  = '".$_POST['keywords_en']."',
			cat_desc_en  = '".$_POST['cat_desc_en']."',
			cat_pic  = '". $gallery ."',
			keywords_tw  = '".$_POST['keywords_tw']."',
			cat_desc_tw  = '".$_POST['cat_desc_tw']."',
			
			typeid  = '".$typeid."',
			stype  = '".$_POST['stype']."',
			sort_order  = ".$sort_order.",
			keywords  = '".$_POST['keywords']."',
			cat_desc  = '".$_POST['cat_desc']."',
            action_name  = '".$_POST['Action_name']."'";
	$exc->insert($set);
		
	/*添加链接*/
	$link[0]['text'] = '返回案例栏目列表';
	$link[0]['href'] = 'Case_cat.php?act=list';
	
	$link[1]['text'] = '继续添加案例栏目';
	$link[1]['href'] = 'Case_cat.php?act=add&Caselocaid='.$selMenu;
	
	admin_log($_POST['cat_name'], 'add', 'Case_cat');   // 记录管理员操作
	sys_msg("添加 [ ".stripslashes($_POST['cat_name'])." ] 案例成功", 0, $link);
}

if ($_REQUEST['act'] == 'list')
{
	$Caseloca = $Caseloca->showCategory();
	$smarty->assign('Caseloca',$Caseloca);
	$smarty->assign('full_page',    1);
	
	$smarty->assign('action_text',  "添加案例栏目");
	$smarty->assign('action_href',  "Case_cat.php?act=add");
	$smarty->assign('ur_here',      "案例栏目列表");
	$smarty->display('Case_cat_list.html');
}

if ($_REQUEST['act'] == 'edit')
{
	admin_priv('Case_cat_manage');
	$cat_id = $_REQUEST['cat_id'];
	$row = $exc->select(' * ', $cat_id);
	
	$Caseloca = $Caseloca->toSelect(0,$row['parent_id']);
	
	$smarty->assign('Caseloca', stripslashes_array($Caseloca));
	$smarty->assign('row',      stripslashes_array($row));
	
	$smarty->assign('action_text',  "返回案例栏目");
	$smarty->assign('action_href',  "Case_cat.php?act=list");
	$smarty->assign('ur_here',      "编辑案例栏目");
	$smarty->assign('form_act',     'update');
	
	$smarty->display('Case_cat_info.html');
}

if ($_REQUEST['act'] == 'update')
{
	admin_priv('Case_cat_manage');
	$cat_id = $_REQUEST['cat_id'];
	$selMenu = $_REQUEST['selMenu'];
	if (empty($cat_id)) sys_msg("参数错误", 1);
	
	/* 检查栏目是否存在 */
	$where = "parent_id = '".$selMenu."'";
	$is_only = $exc->is_only('cat_name', $_POST['cat_name'], $cat_id, $where);

	if($is_only)
	{
		sys_msg("该栏目已存在！", 1);
	}
	
	
//	$typeid=($_POST['selMenu']==0)?'3':$_POST['typeid'];
    $typeid=$_POST['typeid'];
	
	
	if ((isset($_FILES['img_file_src']['error']) && $_FILES['img_file_src']['error'] == 0) || (!isset($_FILES['img_file_src']['error']) && isset($_FILES['img_file_src']['tmp_name'] ) && $_FILES['img_file_src']['tmp_name'] != 'none'))
	{
		
		$dir = 'data/game_logo';
		$sql = "SELECT * FROM " . $lk->table('case_cat')." where cat_id = '".$cat_id."'";
		$img = $db->get_one($sql);
		if($img['cat_pic'])
		{
			@unlink('../'.$img['cat_pic']);
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
		$set = "cat_pic= '".$gallery."',";
		
	}
	else
	{
		$set = "cat_pic= '".trim($_POST['cat_pic'])."',";		
	}	
	
	$set .= "parent_id = ".$selMenu.",
			cat_name  = '".$_POST['cat_name']."',
			sort_order  = ".$_POST['sort_order'].",			
			keywords_tw  = '".$_POST['keywords_tw']."',
			cat_desc_tw  = '".$_POST['cat_desc_tw']."',
			cat_name_en  = '".$_POST['cat_name_en']."',
			keywords_en  = '".$_POST['keywords_en']."',
			
			typeid  = '".$typeid."',
			stype  = '".$_POST['stype']."',
			cat_desc_en  = '".$_POST['cat_desc_en']."',
			keywords  = '".$_POST['keywords']."',
			cat_desc = '".$_POST['cat_desc']."',
            action_name  = '".$_POST['action_name']."'";
	//var_dump($set);exit;		
	$exc->edit($set, $cat_id);
	
	$link[0]['text'] = '返回案例栏目列表';
	$link[0]['href'] = 'Case_cat.php?act=list';
	
	admin_log($_POST['cat_name'], 'edit', 'Case_cat'); // 记录管理员操作
	sys_msg("修改 [ ".stripslashes($_POST['cat_name'])." ] 栏目成功", 0, $link);
}

if ($_REQUEST['act'] == 'remove')
{
	check_authz_json('Case_cat_drop');
    /* 初始化分类ID并取得分类名称 */
    $cat_id   = intval($_GET['id']);
	$cat_name = $exc->get_name($cat_id, 'cat_name');

    /* 当前分类下是否有子信息 */
    $Case_count = $db->get_row("SELECT COUNT(*) FROM " .$lk->table('Case'). " WHERE cat_id = '$cat_id'");

	/* 如果不存在信息，则删除之 */
    if ($Case_count == 0)
    {
        /* 删除分类 */
		$exc->drop($cat_id);
		admin_log($cat_name, 'remove', 'Case_cat');
    }
    else
    {
        make_json_error('此分类下还存在有信息,您不能删除!');
    }

    $url = 'Case_cat.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

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

    make_json_result($smarty->fetch('Case_cat_list.html'));
}
?>