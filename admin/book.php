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
$exc = new exchange($lk->table("users"), $db, 'user_id', 'user_name');
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
	admin_priv('user_manage');
	
	
	$sex = '<input type="radio" name="sex" value="0" checked="true" />男
		   <input type="radio" name="sex" value="1"  />女';
	$smarty->assign('sex',$sex);	
	
	$smarty->assign('action_text',  "返回会员列表");
	$smarty->assign('action_href',  "book.php?act=list");
	$smarty->assign('ur_here',      "添加会员信息");
	
	$smarty->assign('form_act',     'insert');
	$smarty->display('user_info.html');
}
if ($_REQUEST['act'] == 'insert')
{
	admin_priv('user_manage');
	
	$user_id = $_REQUEST['user_id'];
	$user_name = $_REQUEST['user_name'];
	$office_phone = $_REQUEST['office_phone'];
	$rank_points = $_REQUEST['rank_points'];
	$email = $_REQUEST['email'];
	$sex = $_REQUEST['sex'];
	
	$sql = "INSERT INTO wm_users (user_name,office_phone,rank_points,email,sex) VALUES ('$user_name','$office_phone','$rank_points','$email','$sex')";
	
	$db->query($sql);	

	/*添加链接*/
	$link[0]['text'] = '继续添加会员信息';
	$link[0]['href'] = 'book.php?act=add';
	$link[1]['text'] = '返回会员列表';
	$link[1]['href'] = 'book.php?act=list';	
	
	sys_msg("添加 [ ".stripslashes($_POST['user_name'])." ] 会员信息成功", 0, $link);
}

if ($_REQUEST['act'] == 'list')
{
	$cat_id   = isset($_REQUEST['cat_id']) ? intval($_REQUEST['cat_id']) : 0;	
    /* 查询类型列表 */
    $cat_list = $Case_cat->toSelect(0,$cat_id);
	$smarty->assign('cat_list',      $cat_list);
	
	$smarty->assign('full_page',    1);
	$smarty->assign('action_text',  "添加会员信息");
	$smarty->assign('action_href',  "book.php?act=add");
	$smarty->assign('ur_here',      "会员列表");
	
	$Case = user_list();	
    $smarty->assign('Case',           $Case['user_list']);
    $smarty->assign('filter',          $Case['filter']);
    $smarty->assign('record_count',    $Case['record_count']);
    $smarty->assign('page_count',      $Case['page_count']);
	$smarty->display('users_list.html');
}
elseif ($_REQUEST['act'] == 'query')
{
    $Case = user_list();

    $smarty->assign('Case',         $Case['user_list']);
    $smarty->assign('filter',        $Case['filter']);
    $smarty->assign('record_count',  $Case['record_count']);
    $smarty->assign('page_count',    $Case['page_count']);

    make_json_result($smarty->fetch('users_list.html'), '',
        array('filter' => $Case['filter'], 'page_count' => $Case['page_count']));
}
elseif($_REQUEST['act'] == 'level')    //会员星级设定页面输出
{
	$sql = "SELECT point FROM wm_point_config LIMIT 1";
	$res = $db->query($sql);
	$row = mysql_fetch_assoc($res);	
	$smarty->assign('row',     $row);
	$smarty->assign('form_act',     'level_update');
	$smarty->display('level_info.html');
}
elseif($_REQUEST['act'] == 'level_update')   // 处理会员星级积分设定值
{
	$point = $_REQUEST['point'];
	$sql = "UPDATE wm_point_config ";
	$sql .= "SET point=$point";
	$db->query($sql);
	
	$link = array();
	
	sys_msg("修改积分值成功", 0, $link);
}

if ($_REQUEST['act'] == 'send')
{
	admin_priv('users_manage');	
	
	$user_id = $_REQUEST['user_id'];	
	$set = "isbook=1";    //发送
	$result = $exc->edit($set,$user_id);
	
	$link[0]['text'] = '返回会员列表';
	
	$link[0]['href'] = 'book.php?act=list';
	
	sys_msg("修改 [ ".stripslashes($_POST['user_name'])." ] 会员信息成功", 0, $link);
}
if ($_REQUEST['act'] == 'send_no')
{
	admin_priv('users_manage');	
	
	$user_id = $_REQUEST['user_id'];	
	$set = "isbook=0";    //发送
	$result = $exc->edit($set,$user_id);
	
	$link[0]['text'] = '返回会员列表';
	
	$link[0]['href'] = 'book.php?act=list';
	
	sys_msg("修改 [ ".stripslashes($_POST['user_name'])." ] 会员信息成功", 0, $link);
}

if ($_REQUEST['act'] == 'update')
{
	admin_priv('users_manage');	
	
	$user_id = $_REQUEST['user_id'];
	$user_name = $_REQUEST['user_name'];
	$office_phone = $_REQUEST['office_phone'];
	$rank_points = $_REQUEST['rank_points'];
	$email = $_REQUEST['email'];
	$sex = $_REQUEST['sex'];	
	
	$sql = "UPDATE wm_users SET user_name='$user_name',office_phone = '$office_phone',rank_points = '$rank_points',email = '$email',sex = '$sex' WHERE user_id=$user_id";
	
	$db->query($sql);
	
	$link[0]['text'] = '返回会员列表';
	
	$link[0]['href'] = 'book.php?act=list';
	
	sys_msg("修改 [ ".stripslashes($_POST['user_name'])." ] 会员信息成功", 0, $link);
}
if ($_REQUEST['act'] == 'remove')
{
	check_authz_json('Case_drop');
    $Case_id   = $_REQUEST['id'];		
	
	//$exc->drop($Case_id);
	$sql = "DELETE FROM wm_users WHERE user_id=$Case_id";
	$db->query($sql);
	
    $url = 'book.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    header("Location: $url\n");
    exit;
}
/* 批量发送 */
elseif ($_REQUEST['act'] == 'batch_drop')
{	
	admin_priv('Case_drop');
	$count = 0;	
	foreach ((array)$_POST['checkboxes'] AS $key => $id)
	{
		//$result = $exc->drop($id);
		$set = "isbook=1";    //发送
		$result = $exc->edit($set,$id);
		$count++;
	}
	if ($result)
	{
		//admin_log($count, 'remove', 'Case');

		$link[] = array('text' => '返回会员列表', 'href' => 'book.php?act=list');
		sys_msg(sprintf('成功设置 %d 个会员', $count), 0, $link);
	}else{
		$link[] = array('text' => '返回会员列表', 'href' => 'book.php?act=list');
		sys_msg('您没有选择要删除的记录!', 1, $link);	
	}
}
/* 批量不发送 */
elseif ($_REQUEST['act'] == 'batch_drop_no')
{	
	admin_priv('Case_drop');
	$count = 0;	
	foreach ((array)$_POST['checkboxes'] AS $key => $id)
	{
		$set = "isbook=0";    //不发送
		$result = $exc->edit($set,$id);
		$count++;
	}
	if ($result)
	{
		//admin_log($count, 'remove', 'Case');

		$link[] = array('text' => '返回会员列表', 'href' => 'book.php?act=list');
		sys_msg(sprintf('成功取消了 %d 个会员', $count), 0, $link);
	}else{
		$link[] = array('text' => '返回会员列表', 'href' => 'book.php?act=list');
		sys_msg('您没有选择要取消的记录!', 1, $link);	
	}
}
/*会员详情*/
elseif ($_REQUEST['act'] == 'detail')
{	
	$user_id = $_REQUEST['Case_id'];
	$sql = "SELECT * FROM wm_users WHERE user_id=$user_id";
	$res = $db->query($sql);
	$row = mysql_fetch_assoc($res);
	
	//var_dump($row);
	
	if($row['sex']==0)
	{
		$sex = '<input type="radio" name="sex" value="0" checked="true" />男
		   <input type="radio" name="sex" value="1"  />女';
	}
	elseif($row['sex']==1)
	{
		$sex = '<input type="radio" name="sex" value="0"  />男
		   <input type="radio" name="sex" value="1"  checked="true" />女';
	}
	
	$smarty->assign('row',$row);
	$smarty->assign('sex',$sex);
	
	$smarty->assign('action_text',  "返回会员列表");
	$smarty->assign('action_href',  "book.php?act=list");
	$smarty->assign('ur_here',      "会员详情");
	
	$smarty->assign('form_act',     'update');
	$smarty->display('user_info.html');
}


//发送邮件配置

if ($_REQUEST['act'] == 'email')
{
	admin_priv('user_manage');		
	
	$sql = "SELECT * FROM sd_email_config ";
	$sql .= "LIMIT 1";
	
	$res = $db->query($sql);
	
	$row = mysql_fetch_assoc($res);
	
	$smarty->assign('row',     $row);
	
	$smarty->assign('form_act',     'email_update');	
	
	$smarty->display('email_info.html');
	
}
else if ($_REQUEST['act'] == 'email_update')
{
	
	$set = "UPDATE sd_email_config ";
	$set .= "SET ";
	
	$set .="protocol  = '".$_POST['protocol']."',
			smtp_host  = '".$_POST['smtp_host']."',
			smtp_user  = '".$_POST['smtp_user']."',
			smtp_pass  = '".$_POST['smtp_pass']."',
			smtp_port  = '".$_POST['smtp_port']."'";				 
	
	$db->query($set);
	
	$link[0]['text'] = '返回案例列表';
	
	$link[0]['href'] = 'book.php?act=email';
	
	admin_log($_POST['title'], 'edit', 'Case'); // 记录管理员操作
	sys_msg("修改成功", 0, $link);
	
}

//邮件配置

if ($_REQUEST['act'] == 'etitle')
{
	admin_priv('user_manage');		
	
	$sql = "SELECT title FROM sd_email_config ";
	$sql .= "LIMIT 1";
	
	$res = $db->query($sql);
	
	$row = mysql_fetch_assoc($res);
	
	$smarty->assign('row',     $row);
	
	$smarty->assign('form_act',     'etitle_update');	
	
	$smarty->display('etitle_info.html');
	
}
else if ($_REQUEST['act'] == 'etitle_update')
{
	
	$set = "UPDATE sd_email_config ";
	$set .= "SET ";
	
	$set .="title  = '".$_POST['title']."'";							 
	
	$db->query($set);
	
	$link[0]['text'] = '返回案例列表';
	
	$link[0]['href'] = 'book.php?act=etitle';
	
	admin_log($_POST['title'], 'edit', 'Case'); // 记录管理员操作
	sys_msg("修改成功", 0, $link);
	
}

/**
 *  返回用户列表数据
 *
 * @access  public
 * @param
 *
 * @return void
 */
function user_list()
{
    $result = get_filter();
    if ($result === false)
    {
        /* 过滤条件 */
        $filter['keywords'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keywords'] = json_str_iconv($filter['keywords']);
        }
       
        $filter['sort_by'] = 'user_id';
		$filter['sort_order'] = 'DESC';

        $ex_where = ' WHERE 1 ';
		
		
		/* 查询参数 */
		if($_REQUEST['searchs'])
		{			
			$filter['searchs'] = $_REQUEST['searchs'];
			$ex_where .= " and  user_name like '%".$_REQUEST['searchs']."%'";
		}
		
        if ($filter['keywords'])
        {
            $ex_where .= " AND user_name LIKE '%" . mysql_like_quote($filter['keywords']) ."%'";
        }
        


        $filter_record = $GLOBALS['db']->get_one("SELECT COUNT(*) FROM " . $GLOBALS['lk']->table('users') . $ex_where);
        
        $filter['record_count'] = $filter_record['COUNT(*)'];

        /* 分页大小 */
        $filter = page_and_size($filter);
        $sql = "SELECT * ".
                " FROM " . $GLOBALS['lk']->table('users') . $ex_where .
                " ORDER by " . $filter['sort_by'] . ' ' . $filter['sort_order'] .
                " LIMIT " . $filter['start'] . ',' . $filter['page_size'];
				
						

        $filter['keywords'] = stripslashes($filter['keywords']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
	
	//var_dump($sql);exit;

    $user_list = $GLOBALS['db']->getAll($sql);
	
	

    $count = count($user_list);
    
    for ($i=0; $i<$count; $i++)
    {    	
    	$user_list[$i]['add_time'] = date('Y-m-d H:i:s', $user_list[$i]['add_time']);
       
    }

    $arr = array('user_list' => $user_list, 'filter' => $filter,
        'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}



?>