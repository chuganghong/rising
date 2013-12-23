<?php
define('IN_LK', true);
@session_start();
require(dirname(__FILE__) . '/includes/init.php');
check_admin();
$exc = new exchange($lk->table("flash_works"), $db, 'flash_id', 'img_title');
$allow_suffix = array('gif', 'jpg', 'png', 'jpeg', 'bmp');
require(ROOT_PATH . 'includes/cls_category.php');
include_once(ROOT_PATH . 'includes/cls_image.php');
$image = new cls_image();
$image->fileFormat = array('gif', 'jpg', 'png', 'jpeg', 'bmp');
$Case_cat = new category($lk->table("Case_cat"));

if ($_REQUEST['act']== 'brand_list')
{
    $cat_id = 14;   //合作品牌的栏目ID是14
	$data_list = get_flash($cat_id);
	//var_dump($data_list);exit;
	
	$bc = 'brand';    //是brand还是case
	$smarty->assign('bc',    $bc);

	
	$smarty->assign('full_page',    '1');
	$smarty->assign('flash',        $data_list['list']);
    $smarty->assign('filter',       $data_list['filter']);
    $smarty->assign('record_count', $data_list['record_count']);
    $smarty->assign('page_count',   $data_list['page_count']);
	
	$smarty->assign('which',   false);    //控制是否显示分页符等,false--不显示
	
	$smarty->assign('ur_here', '轮播图片列表');
    //$smarty->assign('action_link_special', array('text' => '添加图片', 'href' => 'javascript:;'));
    $smarty->display('brand_list.html');
}
elseif ($_REQUEST['act'] == 'add')
{	
	admin_priv('flash_manage');
	
	$width = 691;$height = 344;
	$msg = '此模板的图片标准宽度为：' . $width . ' 标准高度为：' . $height;
	
	$smarty->assign('which',  true);
	
	$smarty->assign('msg',  $msg);
	$row = array('img_link'=>'http://','img_sort'=>'0');
	$smarty->assign('action_text',  "轮播图片列表");
	$smarty->assign('action_href',  "works.php?act=list");
	$smarty->assign('row', $row);
	$smarty->assign('form_act',     'insert');
	$smarty->assign('ur_here',      '添加轮播图片');
	/*
	$Case_cat = $Case_cat->toSelect(0);
	$smarty->assign('Case_cat', stripslashes_array($Case_cat));
	*/
	$smarty->display('brand_add.html');
}
elseif($_REQUEST['act'] == 'insert')
{
	admin_priv('flash_manage');
	//if ($_POST['img_link'] == 'http://')
//	{
//		$links[] = array('text' =>'添加图片', 'href' => 'works.php?act=add');
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
		/*
        if($_POST['img_type']==1){
            $gallery_thumb = $image->make_thumb(ROOT_PATH .$gallery, 1002,433,ROOT_PATH . $dir.'/');
            @unlink(ROOT_PATH .$gallery);
            $src=$gallery_thumb;
        }else{
            $src=$gallery;
        }
		*/
         $src=$gallery;
        
	}else{
		$links[] = array('text' =>'添加图片', 'href' => 'works.php?act=add');
		sys_msg('轮播图片不能为空', 1, $links);
	}
	
	$cat_id = 15;   //经典案例的栏目ID是15
	
	$set = "img_src = '".$src."',
			cat_id = " . $cat_id . ",			
			img_link = '".$_POST['img_link']."',
            img_type = '".$_POST['img_type']."',
			img_title  = '".$_POST['img_title']."',
			img_alt  = '".$_POST['img_alt']."',			
			img_title_en  = '".$_POST['img_title_en']."',
			img_alt_en  = '".$_POST['img_alt_en']."',
			img_title_tw  = '".$_POST['img_title_tw']."',
			img_alt_tw  = '".$_POST['img_alt_tw']."',
			img_sort = '".$_POST['img_sort']."'";
	
	$exc->insert($set);
	
	
	/*添加链接*/
	$links[0]['text'] = '返回轮播图片列表';
	$links[0]['href'] = 'works.php?act=case_list';
	
	$links[1]['text'] = '继续添加轮播图片';
	$links[1]['href'] = 'works.php?act=add';
	
	admin_log($_POST['img_title'], 'add', 'flashplay'); // 记录管理员操作
	sys_msg("添加 [ ".stripslashes($_POST['img_title'])." ] 轮播图片成功", 0, $links);
}
elseif ($_REQUEST['act'] == 'edit')
{
	admin_priv('flash_manage');
	$flash_id = empty($_REQUEST['flash_id']) ? 0 : intval($_REQUEST['flash_id']);
	$row = $exc->select('*', $flash_id);
    $Case_cat = $Case_cat->toSelect(0,$row['cat_id']);
	
	$width = 691;
	$height = 344;
	switch($flash_id)
	{
		case 1:
			$width = '138';
			$height = '190';
			break;
		case 2:
			$width = '207';
			$height = '96';
			break;
		case 3:
			$width = 206;$height = 96;
			break;
		case 4:
			$width = 140;$height = 96;
			break;
		case 5:
			$width = 140;$height = 192;
			break;
		case 6:
			$width = 206;$height = 94;
			break;
		case 7:
			 $width = 203;$height = 94;
			break;
		case 8:
			$width = 138;$height = 98;
			break;
		case 9:
			$width = 203;$height = 98;
			break;
		case 10:
			$width = 207;$height = 98;
			break;
	}
	
	$msg = '此模板的图片标准宽度为：' . $width . ' 标准高度为：' . $height;

	$smarty->assign('msg',      $msg);
	
	$bc = $_REQUEST['bc'];

	if($bc == 'brand')
	{
		$url1 = "works.php?act=brand_list";
	}
	else if($bc == 'case')
	{
		$url1 = "works.php?act=case_list";
	}
	
	$smarty->assign('bc',     $bc);

	$smarty->assign('Case_cat',stripslashes_array($Case_cat));
	$smarty->assign('row',      stripslashes_array($row));
	$smarty->assign('action_text',  "返回轮播图片列表");
	$smarty->assign('action_href',  $url1);
	$smarty->assign('ur_here',      "编辑轮播图片信息");
	$smarty->assign('form_act',     'brand_update');
	
	$smarty->display('brand_add.html');
}
elseif ($_REQUEST['act'] == 'brand_update')
{	
	admin_priv('flash_manage');
	$flash_id = empty($_POST['flash_id']) ? 0 : intval($_POST['flash_id']);
	
    if ((isset($_FILES['img_file_src']['error']) && $_FILES['img_file_src']['error'] == 0) || (!isset($_FILES['img_file_src']['error']) && isset($_FILES['img_file_src']['tmp_name'] ) && $_FILES['img_file_src']['tmp_name'] != 'none'))
	{
		$dir = 'data/game_logo';
		$sql = "SELECT * FROM " . $lk->table('flash_works')." where flash_id = '".$flash_id."'";
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
		/*不生成缩略图
        if($_POST['img_type']==1){
            $gallery_thumb = $image->make_thumb(ROOT_PATH .$gallery, 1002,433,ROOT_PATH . $dir.'/');
            @unlink(ROOT_PATH .$gallery);
            $src=$gallery_thumb;
        }else{
            $src=$gallery;
        }
		*/
        $src=$gallery;
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
			img_title_en  = '".$_POST['img_title_en']."',
			img_alt_en  = '".$_POST['img_alt_en']."',
			img_title_tw  = '".$_POST['img_title_tw']."',
			img_alt_tw  = '".$_POST['img_alt_tw']."',
			img_sort = '".$_POST['img_sort']."'";
	//var_dump($set);exit;
	$exc->edit($set, $flash_id);
	
	$link[0]['text'] = '返回轮播图片列表';
	
	$bc = $_REQUEST['bc'];	
	if($bc == 'brand')
	{
		$link[0]['href'] = "works.php?act=brand_list";
	}
	else if($bc == 'case')
	{
		$link[0]['href'] = "works.php?act=case_list";
	}
	
	admin_log($_POST['img_title'], 'edit', 'flashplay'); // 记录管理员操作
	sys_msg("修改 [ ".stripslashes($_POST['img_title'])." ] 轮播图片成功", 0, $link);
}
elseif ($_REQUEST['act'] == 'query')
{
    $data_list = get_flash();
	$smarty->assign('action_link_special', array('text' => '添加图片', 'href' => 'works.php?act=add'));
	$smarty->assign('flash',        $data_list['list']);
    $smarty->assign('filter',       $data_list['filter']);
    $smarty->assign('record_count', $data_list['record_count']);
    $smarty->assign('page_count',   $data_list['page_count']);
	
    make_json_result($smarty->fetch('brand_list.html'), '',
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

    $url = 'works.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    header("Location: $url\n");
    exit;
}
else if ($_REQUEST['act']== 'case_list')
{
    $cat_id = 15;   //经典案例的栏目ID是15

	$data_list = get_flash($cat_id);
	//var_dump($data_list);exit;
	
	$smarty->assign('bc',    'case');
	$smarty->assign('full_page',    '1');
	$smarty->assign('flash',        $data_list['list']);
    $smarty->assign('filter',       $data_list['filter']);
    $smarty->assign('record_count', $data_list['record_count']);
    $smarty->assign('page_count',   $data_list['page_count']);
	
	$smarty->assign('which',   true);    //控制是否显示分页符等,true--显示
	
	$smarty->assign('ur_here', '轮播图片列表');
    $smarty->assign('action_link_special', array('text' => '添加图片', 'href' => 'works.php?act=add'));
    $smarty->display('brand_list.html');
}






function get_flash($cat_id)
{
	$uri = $GLOBALS['lk']->url();
    $filter = array();
	

    //查询条件
    $where = " WHERE 1 ";
	$where .= " AND fp.cat_id = $cat_id ";

    /* 获得总记录数据 */
    $sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['lk']->table('flash_works'). ' AS fp ' . $where;
    $filter['record_count'] = $GLOBALS['db']->get_row($sql);
	
	/* 分页大小 */
    $filter = page_and_size($filter);

    /* 获取记录 */
    $list = array();
	/*有问题
    $sql  = 'SELECT fp.*, c.cat_name FROM ' .$GLOBALS['lk']->table('flash_works'). ' AS fp
			LEFT JOIN '.$GLOBALS['lk']->table('Case_cat'). ' AS c 
			ON fp.cat_id = c.cat_id where 1 order by flash_id desc';
	*/
	 $sql  = 'SELECT fp.*, c.cat_name FROM ' .$GLOBALS['lk']->table('flash_works'). ' AS fp
			LEFT JOIN '.$GLOBALS['lk']->table('Case_cat'). ' AS c 
			ON fp.cat_id = c.cat_id ' . $where . ' order by flash_id desc';
    $res  = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);
    while ($rows = $GLOBALS['db']->fetch_array($res))
    {
		
		if (strpos($rows['img_link'], 'http') === false)
        {
           
		   $rows['img_link'] = $uri . $rows['img_link'];
        }
		$list[] = $rows;
    }
	//var_dump($list);exit;
    return array('list' => $list, 'filter' => $filter, 'page_count' =>  $filter['page_count'], 'record_count' => $filter['record_count']);	
}
?>