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
$exc = new exchange($lk->table("case_about"), $db, 'Case_id', 'title');


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
	$smarty->assign('action_href',  "about.php?act=list");
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
	$link[0]['href'] = 'about.php?act=add';
	$link[1]['text'] = '返回案例列表';
	$link[1]['href'] = 'about.php?act=list';
	
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
	$smarty->assign('action_href',  "about.php?act=add");
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
    $cat_id = $_REQUEST['cat_id'];
	if(empty($cat_id))
	{
		$cat_id = $_SESSION['cat_id'];
	}
	
	$Case = get_Case($cat_id);

    $smarty->assign('Case',         $Case['list']);
    $smarty->assign('filter',        $Case['filter']);
    $smarty->assign('record_count',  $Case['record_count']);
    $smarty->assign('page_count',    $Case['page_count']);

    make_json_result($smarty->fetch('c_txt_list.html'), '',
        array('filter' => $Case['filter'], 'page_count' => $Case['page_count']));
}

if ($_REQUEST['act'] == 'intro')  //日先简介
{
	admin_priv('Case_manage');
	
		$Case_id=1;//日先简介ID为1
		$row = $exc->select('*', $Case_id);
		//var_dump(mysql_error());
		//var_dump($row);exit;
		//$Case_cat = $Case_cat->toSelect(0,$row['cat_id']);
		$smarty->assign('Case_id',$Case_id);
		
		$smarty->assign('content',  createCkedit("content",$row['content']));
		$smarty->assign('content_tw',  createCkedit("content_tw",$row['content_tw']));
		$smarty->assign('content_en',  createCkedit("content_en",$row['content_en']));
		$smarty->assign('row',      stripslashes_array($row));
		$smarty->assign('action_text',  "返回案例列表");
		$smarty->assign('action_href',  "about.php?act=list");

	
	$smarty->assign('ur_here',      "编辑案例信息");
	$smarty->assign('form_act',     'intro_update');
	
	$smarty->display('intro_info.html');
}
else if($_REQUEST['act'] == 'intro_update')  //日先简介
{
	admin_priv('Case_manage');
	
	$Case_id = $_REQUEST['Case_id'];
	
	$addtime = date('Y-m-d',$_POST['addtime']);
	check_badkey($_POST['content']);
	
	$updatetime = time();
	
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
	
	$link[0]['href'] = 'about.php?act=intro';
	
	//echo time();exit;		
	
	admin_log($_POST['title'], 'edit', 'Case'); // 记录管理员操作
	sys_msg("修改 [ ".stripslashes($_POST['title'])." ] 案例信息成功", 0, $link);
}


if ($_REQUEST['act'] == 'honor')  //日先荣誉
{
	admin_priv('Case_manage');
	
		$Case_id=3;//日先荣誉ID为3
		$row = $exc->select('*', $Case_id);
		//var_dump(mysql_error());
		//var_dump($row);exit;
		//$Case_cat = $Case_cat->toSelect(0,$row['cat_id']);
		$smarty->assign('Case_id',$Case_id);
		
		$smarty->assign('content',  createCkedit("content",$row['content']));
		$smarty->assign('content_tw',  createCkedit("content_tw",$row['content_tw']));
		$smarty->assign('content_en',  createCkedit("content_en",$row['content_en']));
		$smarty->assign('row',      stripslashes_array($row));
		$smarty->assign('action_text',  "返回案例列表");
		$smarty->assign('action_href',  "about.php?act=list");

	
	$smarty->assign('ur_here',      "编辑案例信息");
	$smarty->assign('form_act',     'honor_update');
	
	$smarty->display('intro_info.html');
}
else if($_REQUEST['act'] == 'honor_update')  //日先简介
{
	admin_priv('Case_manage');
	
	$Case_id = $_REQUEST['Case_id'];
	
	$addtime = date('Y-m-d',$_POST['addtime']);
	check_badkey($_POST['content']);
	
	$updatetime = time();
	
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
	
	$link[0]['href'] = 'about.php?act=honor';
	
	//echo time();exit;		
	
	admin_log($_POST['title'], 'edit', 'Case'); // 记录管理员操作
	sys_msg("修改 [ ".stripslashes($_POST['title'])." ] 案例信息成功", 0, $link);
}



if ($_REQUEST['act'] == 'idea')  //日先理念
{
	admin_priv('Case_manage');
	
		$Case_id=4;//日先理念ID为4
		$row = $exc->select('*', $Case_id);
		//var_dump(mysql_error());
		//var_dump($row);exit;
		//$Case_cat = $Case_cat->toSelect(0,$row['cat_id']);
		$smarty->assign('Case_id',$Case_id);
		
		$smarty->assign('content',  createCkedit("content",$row['content']));
		$smarty->assign('content_tw',  createCkedit("content_tw",$row['content_tw']));
		$smarty->assign('content_en',  createCkedit("content_en",$row['content_en']));
		$smarty->assign('row',      stripslashes_array($row));
		$smarty->assign('action_text',  "返回案例列表");
		$smarty->assign('action_href',  "about.php?act=list");

	
	$smarty->assign('ur_here',      "编辑案例信息");
	$smarty->assign('form_act',     'idea_update');
	
	$smarty->display('intro_info.html');
}
else if($_REQUEST['act'] == 'idea_update')  //日先理念
{
	admin_priv('Case_manage');
	
	$Case_id = $_REQUEST['Case_id'];
	
	$addtime = date('Y-m-d',$_POST['addtime']);
	check_badkey($_POST['content']);
	
	$updatetime = time();
	
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
	
	$link[0]['href'] = 'about.php?act=idea';
	
	//echo time();exit;		
	
	admin_log($_POST['title'], 'edit', 'Case'); // 记录管理员操作
	sys_msg("修改 [ ".stripslashes($_POST['title'])." ] 案例信息成功", 0, $link);
}

if ($_REQUEST['act'] == 'course_main')  //日先足迹--主体文字部分
{
	admin_priv('Case_manage');
	
		$Case_id=2;//日先足迹ID为4
		$row = $exc->select('*', $Case_id);
		//var_dump(mysql_error());
		//var_dump($row);exit;
		//$Case_cat = $Case_cat->toSelect(0,$row['cat_id']);
		$smarty->assign('Case_id',$Case_id);
		
		$smarty->assign('content',  createCkedit("content",$row['content']));
		$smarty->assign('content_tw',  createCkedit("content_tw",$row['content_tw']));
		$smarty->assign('content_en',  createCkedit("content_en",$row['content_en']));
		$smarty->assign('row',      stripslashes_array($row));
		$smarty->assign('action_text',  "返回案例列表");
		$smarty->assign('action_href',  "about.php?act=list");

	
	$smarty->assign('ur_here',      "编辑案例信息");
	$smarty->assign('form_act',     'idea_update');
	
	$smarty->display('intro_info.html');
}
else if($_REQUEST['act'] == 'cm_update')  //日先足迹--主体文字部分
{
	admin_priv('Case_manage');
	
	$Case_id = $_REQUEST['Case_id'];
	
	$addtime = date('Y-m-d',$_POST['addtime']);
	check_badkey($_POST['content']);
	
	$updatetime = time();
	
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
	
	$link[0]['href'] = 'about.php?act=idea';
	
	//echo time();exit;		
	
	admin_log($_POST['title'], 'edit', 'Case'); // 记录管理员操作
	sys_msg("修改 [ ".stripslashes($_POST['title'])." ] 案例信息成功", 0, $link);
}
else if($_REQUEST['act'] == 'c_pic')  //日先足迹--图片
{
	admin_priv('flash_manage');
	//$flash_id = empty($_REQUEST['flash_id']) ? 0 : intval($_REQUEST['flash_id']);
	
	//$row = $exc->select('*', $flash_id);
	
	$cat_id = 7;    //日先足迹的cat_id 是7
	$sql = "SELECT * FROM sd_flash_play ";
	$sql .= "WHERE cat_id = $cat_id ";
	$sql .= "LIMIT 1";
	$result = $db->query($sql);
	$row = mysql_fetch_array($result);
	//var_dump($row);exit;    
	
	$smarty->assign('row',      stripslashes_array($row));
	$smarty->assign('action_text',  "返回轮播图片列表");
	$smarty->assign('action_href',  "about.php?act=c_pic");
	$smarty->assign('ur_here',      "编辑轮播图片信息");
	$smarty->assign('form_act',     'c_pic_update');
	
	$smarty->display('c_pic_add.html');
}
else if($_REQUEST['act'] == 'c_pic_update')  //日先足迹--图片--update
{

	admin_priv('flash_manage');
	
	$exc2 = new exchange($lk->table("flash_play"), $db, 'flash_id', 'cat_id');

	$flash_id = empty($_POST['flash_id']) ? 0 : intval($_POST['flash_id']);
	
	var_dump($flash_id);exit;
	
	
    if ((isset($_FILES['img_file_src']['error']) && $_FILES['img_file_src']['error'] == 0) || (!isset($_FILES['img_file_src']['error']) && isset($_FILES['img_file_src']['tmp_name'] ) && $_FILES['img_file_src']['tmp_name'] != 'none'))
	{
		$dir = 'data/game_logo';
		$sql = "SELECT * FROM " . $lk->table('flash_play')." where flash_id = '".$flash_id."'";
		$img = $db->get_one($sql);
		if($img['img_src'])
		{
			@unlink('../'.$img['img_src']);
		}
       if ($_FILES['img_file_src']['size'] > 2004800)
		{
			sys_msg("错误:图片大小不得超过2M!", 1);
		}
		if (!$image->make_dir(ROOT_PATH . $dir))
		{
			sys_msg("错误:$image->error_msg()", 1);
		}
		$gallery = ''.$image->upload_image($_FILES['img_file_src'], $dir);        
        $src=$gallery;
		$set = "img_src= '".$src."'";
		$exc2->edit($set,$flash_id);
        
	}
	else
	{
		$set = "img_src= '".trim($_POST['img_src'])."'";
		$exc2->edit($set,$flash_id);
	}
    
    
	$set = "
			img_link = '".$_POST['img_link']."',
            img_type = '".$_POST['img_type']."',
			img_title  = '".$_POST['img_title']."',
			img_alt  = '".$_POST['img_alt']."',			
			img_title_en  = '".$_POST['img_title_en']."',
			img_alt_en  = '".$_POST['img_alt_en']."',
			img_title_tw  = '".$_POST['img_title_tw']."',
			img_alt_tw  = '".$_POST['img_alt_tw']."',
			img_sort = '".$_POST['img_sort']."'";
			
	$exc2->edit($set, $flash_id);
	
	
	
	$link[0]['text'] = '返回';
	$link[0]['href'] = 'about.php?act=c_pic';
	
	admin_log($_POST['img_title'], 'edit', 'flashplay'); // 记录管理员操作
	sys_msg("修改图片成功", 0,$link);
}

if($_REQUEST['act'] == 'c_txt_list')   //日先足迹--其他
{
	$cat_id = $_REQUEST['cat_id'];
	
	$_SESSION['cat_id'] = $cat_id;
	
	$url = "about.php?act=c_txt_add&cat_id=" . $cat_id;
	
	$smarty->assign('full_page',    1);
	$smarty->assign('action_text',  "添加案例信息");
	$smarty->assign('action_href',  $url);
	$smarty->assign('ur_here',      "案例列表");	
	
	
	$Case = get_Case($cat_id);
	//var_dump($Case);exit;
	
    $smarty->assign('Case',           $Case['list']);
    $smarty->assign('filter',          $Case['filter']);
    $smarty->assign('record_count',    $Case['record_count']);
    $smarty->assign('page_count',      $Case['page_count']);
	$smarty->display('c_txt_list.html');
}
else if($_REQUEST['act'] == 'c_txt_add')  //日先足迹--其他
{
	//echo sprintf('%s','c_txt_add');
	
	admin_priv('Case_manage');
	//$Case_cat = $Case_cat->toSelect(0);
	//var_dump($Case_cat);exit;
	
	$cat_id = $_REQUEST['cat_id'];
	//var_dump($cat_id);exit;
	
	$smarty->assign('content',   createCkedit("content"));
	$smarty->assign('content_tw',   createCkedit("content_tw"));
	$smarty->assign('content_en',   createCkedit("content_en"));
	$smarty->assign('cat_id', $cat_id);
	
	/*设置默认的表单变量*/
	$smarty->assign('row', array('sort_order'=>0));
	
	
	$smarty->assign('action_text',  "返回案例列表");
	$url = "about.php?act=c_txt_list&cat_id=" . $cat_id;
	$smarty->assign('action_href',  $url);
	$smarty->assign('ur_here',      "添加案例信息");
	
	$smarty->assign('form_act',     'c_txt_insert');
	$smarty->display('c_txt_add.html');
}
else if($_REQUEST['act'] == 'c_txt_edit')  //日先足迹--其他
{	
	
	admin_priv('Case_manage');
	
		$Case_id=$_REQUEST['Case_id'];
		
		
		$row = $exc->select('*', $Case_id);
		
		
		$smarty->assign('content',  createCkedit("content",$row['content']));
		$smarty->assign('content_tw',  createCkedit("content_tw",$row['content_tw']));
		$smarty->assign('content_en',  createCkedit("content_en",$row['content_en']));
		$smarty->assign('row',      stripslashes_array($row));
		$smarty->assign('action_text',  "返回案例列表");
		$smarty->assign('action_href',  "trends.php?act=list");

	
	$smarty->assign('ur_here',      "编辑案例信息");
	$smarty->assign('form_act',     'c_txt_update');
	
	$smarty->display('c_txt_add.html');
}
else if($_REQUEST['act'] == 'c_txt_insert')  //日先足迹--其他--insert
{
	admin_priv('Case_manage');
	check_badkey($_POST['content']);
	
	
	/* 初始化变量 */
	$sort_order = $_POST['sort_order'] ? $_POST['sort_order'] : 0;
	//$cat_id = 7;   //日先足迹的cat_id是7
	
	$cat_id = $_REQUEST['cat_id'];
	if(empty($cat_id))
	{
		$cat_id = $_SESSION['cat_id'];
	}
	
	$addtime = time();	

	/*代码正确，但此页面不需要上传图片功能
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
	*/
	$set = "title = '".$_POST['title']."',
			keyword  = '".$_POST['keyword']."',
			sort_order  = ".$sort_order.",			
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
	//echo sprintf('%s',$set);exit;
	$exc->insert($set);

	/*添加链接*/
	$link[0]['text'] = '继续添加案例信息';
	$link[0]['href'] = 'about.php?act=c_txt_add';
	$link[1]['text'] = '返回案例列表';
	$link[1]['href'] = 'about.php?act=c_txt_list';
	
	admin_log($_POST['title'], 'add', 'Case');   // 记录管理员操作
	sys_msg("添加 [ ".stripslashes($_POST['title'])." ] 案例信息成功", 0, $link);
}
else if($_REQUEST['act'] == 'c_txt_update')  //日先足迹--其他--update
{
	
	admin_priv('Case_manage');
	
	$Case_id = $_REQUEST['Case_id'];
	
	//$cat_id = 7;   //日先足迹的cat_id是7
	
	$cat_id = $_REQUEST['cat_id'];
	if(empty($cat_id))
	{
		$cat_id = $_SESSION['cat_id'];
	}
	
	$addtime = date('Y-m-d',$_POST['addtime']);
	check_badkey($_POST['content']);
	
	$updatetime = time();
	/*
	if ((isset($_FILES['img_file_src']['error']) && $_FILES['img_file_src']['error'] == 0) || (!isset($_FILES['img_file_src']['error']) && isset($_FILES['img_file_src']['tmp_name'] ) && $_FILES['img_file_src']['tmp_name'] != 'none'))
	{
		$dir = 'data/game_logo';
		$sql = "SELECT * FROM " . $lk->table('case_trends')." where Case_id = '".$Case_id."'";
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
			cat_id  = '".$cat_id."'";
	*/
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
			updatetime  = '".$updatetime."'";
		
	$exc->edit($set,$Case_id);
	
	
	$link[0]['text'] = '返回案例列表';
	
	$link[0]['href'] = 'about.php?act=c_txt_list&cat_id=' . $cat_id;
	
	admin_log($_POST['title'], 'edit', 'Case'); // 记录管理员操作
	sys_msg("修改 [ ".stripslashes($_POST['title'])." ] 案例信息成功", 0, $link);
}



if ($_REQUEST['act'] == 'update')
{
	admin_priv('Case_manage');
	
	$Case_id = $_REQUEST['Case_id'];
	
	$addtime = date('Y-m-d',$_POST['addtime']);
	check_badkey($_POST['content']);
	
	$updatetime = time();
	
	///* 标题是否相同 */
//	$sql = "SELECT COUNT(*) FROM " . $lk->table('case_about') . " 
//			WHERE title = '".$_POST['title']."' AND cat_id = '".$_POST['cat_id']."' AND Case_id<>$Case_id 
//			AND DATE_FORMAT(FROM_UNIXTIME(addtime),'%Y-%m-%d') = '".$addtime."'";
//	if($db->get_row($sql)) sys_msg("此案例信息今天已添加！", 1);
	
	if ((isset($_FILES['img_file_src']['error']) && $_FILES['img_file_src']['error'] == 0) || (!isset($_FILES['img_file_src']['error']) && isset($_FILES['img_file_src']['tmp_name'] ) && $_FILES['img_file_src']['tmp_name'] != 'none'))
	{
		$dir = 'data/game_logo';
		$sql = "SELECT * FROM " . $lk->table('case_about')." where Case_id = '".$Case_id."'";
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
	
	$link[0]['href'] = 'about.php?act=list';
	
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

    $url = 'about.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

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
		
		$cat_id = $_REQUEST['cat_id'];
		if(empty($cat_id))
		{
			$cat_id = $_SESSION['cat_id'];
		}
		
		$url = 'about.php?act=c_txt_list&cat_id=' . $cat_id;

		$link[] = array('text' => '返回交易信息列表', 'href' => $url);
		sys_msg(sprintf('成功删除了 %d 个交易信息', $count), 0, $link);
	}else{
		$link[] = array('text' => '返回交易信息列表', 'href' => $url);
		sys_msg('您没有选择要删除的记录!', 1, $link);	
	}
}

function get_Case($cat_id)
{
    $filter = array();
	
	/*note
    $cat_id = 7;   //日先足迹的cat_id=7;
	$cat_id = 8;   //关于我们的cat_id=8;
	*/
	
	
    //查询条件
    $where = " WHERE 1 ";
	//$where .= (!empty($filter['cat_id'])) ? " AND d.cat_id in ( $category_id ) " : '';
	$where .= " AND cat_id = $cat_id ";
	
	/* 查询参数 */
	if($_REQUEST['searchs'])
	{
		//$where = " WHERE username like '%".$_REQUEST['searchs']."%' OR company_name like '%".$_REQUEST['searchs']."%'";
		$filter['searchs'] = $_REQUEST['searchs'];
		$where .= " and  (d.title like '%".$_REQUEST['searchs']."%' OR d.title_en like '%".$_REQUEST['searchs']."%')";
	}
	
    /* 获得总记录数据 */
  	$sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['lk']->table('case_about'). ' AS d ' . $where ;
    $filter['record_count'] = $GLOBALS['db']->get_row($sql);
	/* 分页大小 */
    $filter = page_and_size($filter);

    $list = array();
	$sql = "SELECT * FROM " .$GLOBALS['lk']->table('case_about') . "AS d " . 
			$where.
			" ORDER BY addtime DESC";
	
		
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