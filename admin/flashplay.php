<?php
define('IN_LK', true);
@session_start();
require(dirname(__FILE__) . '/includes/init.php');
check_admin();
$exc = new exchange($lk->table("flash_play"), $db, 'flash_id', 'img_title');
$allow_suffix = array('gif', 'jpg', 'png', 'jpeg', 'bmp');
require(ROOT_PATH . 'includes/cls_category.php');
include_once(ROOT_PATH . 'includes/cls_image.php');
$image = new cls_image();
$image->fileFormat = array('gif', 'jpg', 'png', 'jpeg', 'bmp');
$Case_cat = new category($lk->table("Case_cat"));

if ($_REQUEST['act']== 'list')
{
    $data_list = get_flash();
	
	$smarty->assign('full_page',    '1');
	$smarty->assign('flash',        $data_list['list']);
    $smarty->assign('filter',       $data_list['filter']);
    $smarty->assign('record_count', $data_list['record_count']);
    $smarty->assign('page_count',   $data_list['page_count']);
	
	$smarty->assign('ur_here', '轮播图片列表');
    $smarty->assign('action_link_special', array('text' => '添加图片', 'href' => 'flashplay.php?act=add'));
    $smarty->display('flashplay_list.html');
}
elseif ($_REQUEST['act'] == 'add')
{
	admin_priv('flash_manage');
	
	$row = array('img_link'=>'http://','img_sort'=>'0');
	$smarty->assign('action_text',  "轮播图片列表");
	$smarty->assign('action_href',  "flashplay.php?act=list");
	$smarty->assign('row', $row);
	$smarty->assign('form_act',     'insert');
	$smarty->assign('ur_here',      '添加轮播图片');
	$Case_cat = $Case_cat->toSelect(0);
	$smarty->assign('Case_cat', stripslashes_array($Case_cat));
	$smarty->display('flashplay_add.html');
}
elseif($_REQUEST['act'] == 'insert')
{
	admin_priv('flash_manage');
	//if ($_POST['img_link'] == 'http://')
//	{
//		$links[] = array('text' =>'添加图片', 'href' => 'flashplay.php?act=add');
//		sys_msg('请填写链接地址', 1, $links);
//	}
	
	//if (!empty($_FILES['img_file_src']['name']))
//	{
//		if(!get_file_suffix($_FILES['img_file_src']['name'], $allow_suffix))
//		{
//			sys_msg('您上传的图片格式不正确');
//		}
//		$name = date('Ymd');
//		for ($i = 0; $i < 6; $i++)
//		{
//			$name .= chr(mt_rand(97, 122));
//		}
//		$name .= '.' . end(explode('.', $_FILES['img_file_src']['name']));
//		$target = ROOT_PATH . DATA_DIR . '/afficheimg/' . $name;
//		if (move_upload_file($_FILES['img_file_src']['tmp_name'], $target))
//		{
//			$src = DATA_DIR . '/afficheimg/' . $name;
//		}
        
        if ((isset($_FILES['img_file_src']['error']) && $_FILES['img_file_src']['error'] == 0) || (!isset($_FILES['img_file_src']['error']) && isset($_FILES['img_file_src']['tmp_name'] ) && $_FILES['img_file_src']['tmp_name'] != 'none'))
	{
		$dir = 'data/game_logo';
		if ($_FILES['img_file_src']['size'] > 2004800)
		{
			sys_msg("错误:图片大小不得超过2M!", 1);
		}
		if (!$image->make_dir(ROOT_PATH . $dir))
		{
			sys_msg("错误:$image->error_msg()", 1);
		}
		$gallery = ''.$image->upload_image($_FILES['img_file_src'], $dir);
        if($_POST['img_type']==1){
            $gallery_thumb = $image->make_thumb(ROOT_PATH .$gallery, 1002,433,ROOT_PATH . $dir.'/');
            @unlink(ROOT_PATH .$gallery);
            $src=$gallery_thumb;
        }else{
            $src=$gallery;
        }
         
        
	}else{
		$links[] = array('text' =>'添加图片', 'href' => 'flashplay.php?act=add');
		sys_msg('轮播图片不能为空', 1, $links);
	}
	
	$set = "img_src = '".$src."',
			img_link = '".$_POST['img_link']."',
            img_type = '".$_POST['img_type']."',
			img_title  = '".$_POST['img_title']."',
			img_alt  = '".$_POST['img_alt']."',
			cat_id  = '".$_POST['cat_id']."',
			img_title_en  = '".$_POST['img_title_en']."',
			img_alt_en  = '".$_POST['img_alt_en']."',
			img_title_tw  = '".$_POST['img_title_tw']."',
			img_alt_tw  = '".$_POST['img_alt_tw']."',
			img_sort = '".$_POST['img_sort']."'";
	$exc->insert($set);
	
	/*添加链接*/
	$links[0]['text'] = '返回轮播图片列表';
	$links[0]['href'] = 'flashplay.php?act=list';
	
	$links[1]['text'] = '继续添加轮播图片';
	$links[1]['href'] = 'flashplay.php?act=add';
	
	admin_log($_POST['img_title'], 'add', 'flashplay'); // 记录管理员操作
	sys_msg("添加 [ ".stripslashes($_POST['img_title'])." ] 轮播图片成功", 0, $links);
}
elseif ($_REQUEST['act'] == 'edit')
{
	admin_priv('flash_manage');
	$flash_id = empty($_REQUEST['flash_id']) ? 0 : intval($_REQUEST['flash_id']);
	$row = $exc->select('*', $flash_id);
    $Case_cat = $Case_cat->toSelect(0,$row['cat_id']);
	$smarty->assign('Case_cat',stripslashes_array($Case_cat));
	$smarty->assign('row',      stripslashes_array($row));
	$smarty->assign('action_text',  "返回轮播图片列表");
	$smarty->assign('action_href',  "flashplay.php?act=list");
	$smarty->assign('ur_here',      "编辑轮播图片信息");
	$smarty->assign('form_act',     'update');
	
	$smarty->display('flashplay_add.html');
}
elseif ($_REQUEST['act'] == 'update')
{
	admin_priv('flash_manage');
	$flash_id = empty($_POST['flash_id']) ? 0 : intval($_POST['flash_id']);
	
	//if ($_POST['img_link'] == 'http://')
//	{
//		sys_msg('请填写链接地址', 1);
//	}
	
	//if (!empty($_FILES['img_file_src']['name']))
//	{
//		if(!get_file_suffix($_FILES['img_file_src']['name'], $allow_suffix))
//		{
//			sys_msg('您上传的图片格式不正确');
//		}
//		$name = date('Ymd');
//		for ($i = 0; $i < 6; $i++)
//		{
//			$name .= chr(mt_rand(97, 122));
//		}
//		$name .= '.' . end(explode('.', $_FILES['img_file_src']['name']));
//		$target = ROOT_PATH . DATA_DIR . '/afficheimg/' . $name;
//		if (move_upload_file($_FILES['img_file_src']['tmp_name'], $target))
//		{
//			$src = DATA_DIR . '/afficheimg/' . $name;
//			/* 如果有新图片上传则删除旧图片 */
//			$img_src = $_POST['img_src'];
//			@unlink(ROOT_PATH . $img_src);
//		}
//	}else{
//		$src = $_POST['img_src'];
//	}
	
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
        if($_POST['img_type']==1){
            $gallery_thumb = $image->make_thumb(ROOT_PATH .$gallery, 1002,433,ROOT_PATH . $dir.'/');
            @unlink(ROOT_PATH .$gallery);
            $src=$gallery_thumb;
        }else{
            $src=$gallery;
        }
        
		$set = "img_src= '".$src."'";
		$exc->edit($set,$flash_id);
        
	}
	else
	{
		$set = "img_src= '".trim($_POST['img_src'])."'";
		$exc->edit($set,$flash_id);
	}
    
    
	$set = "
			img_link = '".$_POST['img_link']."',
            img_type = '".$_POST['img_type']."',
			img_title  = '".$_POST['img_title']."',
			img_alt  = '".$_POST['img_alt']."',
			cat_id  = '".$_POST['cat_id']."',
			img_title_en  = '".$_POST['img_title_en']."',
			img_alt_en  = '".$_POST['img_alt_en']."',
			img_title_tw  = '".$_POST['img_title_tw']."',
			img_alt_tw  = '".$_POST['img_alt_tw']."',
			img_sort = '".$_POST['img_sort']."'";
	$exc->edit($set, $flash_id);
	
	$link[0]['text'] = '返回轮播图片列表';
	$link[0]['href'] = 'flashplay.php?act=list';
	
	admin_log($_POST['img_title'], 'edit', 'flashplay'); // 记录管理员操作
	sys_msg("修改 [ ".stripslashes($_POST['img_title'])." ] 轮播图片成功", 0, $link);
}
elseif ($_REQUEST['act'] == 'query')
{
    $data_list = get_flash();
	$smarty->assign('action_link_special', array('text' => '添加图片', 'href' => 'flashplay.php?act=add'));
	$smarty->assign('flash',        $data_list['list']);
    $smarty->assign('filter',       $data_list['filter']);
    $smarty->assign('record_count', $data_list['record_count']);
    $smarty->assign('page_count',   $data_list['page_count']);
	
    make_json_result($smarty->fetch('flashplay_list.html'), '',
        array('filter' => $data_list['filter'], 'page_count' => $data_list['page_count']));
}
elseif ($_REQUEST['act'] == 'remove')
{
	check_authz_json('flash_manage');
    $id = intval($_GET['id']);
    $img_src = $exc->get_name($id, 'img_src');
	$img_title = $exc->get_name($id, 'img_title');
    $exc->drop($id);

	@unlink(ROOT_PATH . $img_src);

    admin_log($img_title, 'remove', 'flashplay');

    $url = 'flashplay.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    header("Location: $url\n");
    exit;
}
function get_flash()
{
	$uri = $GLOBALS['lk']->url();
    $filter = array();
	

    //查询条件
	$cat_id = 0;
    $where = " WHERE 1 ";
	$where .= " AND cat_id = $cat_id ";    //首页幻灯片和banner的cat_id=0;

    /* 获得总记录数据 */
    $sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['lk']->table('flash_play'). ' AS fp ' . $where;
    $filter['record_count'] = $GLOBALS['db']->get_row($sql);
	
	/* 分页大小 */
    $filter = page_and_size($filter);

    /* 获取记录 */
    $list = array();
	/*
    $sql  = 'SELECT fp.*, c.cat_name FROM ' .$GLOBALS['lk']->table('flash_play'). ' AS fp
			LEFT JOIN '.$GLOBALS['lk']->table('Case_cat'). ' AS c 
			ON fp.cat_id = c.cat_id where 1 order by flash_id desc';
	*/
	//将非首页的图片排除在外
	$sql  = 'SELECT fp.*, c.cat_name FROM ' .$GLOBALS['lk']->table('flash_play'). ' AS fp
			LEFT JOIN '.$GLOBALS['lk']->table('Case_cat'). ' AS c 
			ON fp.cat_id = c.cat_id where 1 ';
	$cat_id = 0;   //首页的图片的cat_id=0
	$sql .= 'AND fp.cat_id = ' . $cat_id;
	$sql .= ' order by flash_id desc';

    $res  = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);
    while ($rows = $GLOBALS['db']->fetch_array($res))
    {
		
		if (strpos($rows['img_link'], 'http') === false)
        {
           
		   $rows['img_link'] = $uri . $rows['img_link'];
        }
		$list[] = $rows;
    }

    return array('list' => $list, 'filter' => $filter, 'page_count' =>  $filter['page_count'], 'record_count' => $filter['record_count']);	
}
?>