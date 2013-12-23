<?php
/**
 * 获得服务器上的 GD 版本
 *
 * @access      public
 * @return      int         可能的值为0，1，2
 */
function gd_version()
{
    include(ROOT_PATH . 'includes/cls_image.php');

    return cls_image::gd_version();
}
/* 验证管理员身份 */
function check_admin()
{
	if(!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id']))
	header("Location: index.php?act=login\n");
}
/**
 * 系统提示信息
 *
 * @access      public
 * @param       string      msg_detail      消息内容
 * @param       int         msg_type        消息类型， 0消息，1错误，2询问
 * @param       array       links           可选的链接
 * @param       boolen      $auto_redirect  是否需要自动跳转
 * @return      void
 */
function sys_msg($msg_detail, $msg_type = 0, $links = array(), $auto_redirect = true)
{
    if (count($links) == 0)
    {
        $links[0]['text'] = '返回上一页';
        $links[0]['href'] = 'javascript:history.go(-1)';
    }
	
	$arr = explode('/',trim(PHP_SELF,'/'));
	$file = end($arr);
	if($file == 'index.php') $flag = true;
    $GLOBALS['smarty']->assign('ur_here',     SITE_NAME);//导航
    $GLOBALS['smarty']->assign('msg_detail',  $msg_detail);
    $GLOBALS['smarty']->assign('msg_type',    $msg_type);
    $GLOBALS['smarty']->assign('links',       $links);
    $GLOBALS['smarty']->assign('default_url', $links[0]['href']);
    $GLOBALS['smarty']->assign('auto_redirect', $auto_redirect);
	$GLOBALS['smarty']->assign('ur_here',      "系统信息");
	$GLOBALS['smarty']->assign('flag',        $flag);
    $GLOBALS['smarty']->display('message.html');

    exit;
}

/**
 * 判断管理员对某一个操作是否有权限。
 *
 * 根据当前对应的action_code，然后再和用户session里面的action_list做匹配，以此来决定是否可以继续执行。
 * @param        $priv_str    操作对应的priv_str
 * @param        $msg_output  是否提示信息
 * @return true/false
 */
function admin_priv($priv_str, $msg_output = true)
{
    if ($_SESSION['action_list'] == 'all')
    {
        return true;
    }

    if (strpos(',' . $_SESSION['action_list'] . ',', ',' . $priv_str . ',') === false)
    {
        $link[] = array('text' => '返回上一页', 'href' => 'javascript:history.back(-1)');
        if ( $msg_output)
        {
            sys_msg('对不起,您没有执行此操作的权限!', 0, $link);
        }
        return false;
    }
    else
    {
        return true;
    }
}

/**
 * 记录管理员的操作内容
 *
 * @access  public
 * @param   string      $sn         数据的唯一值
 * @param   string      $action     操作的类型
 * @param   string      $content    操作的内容
 * @return  void
 */
function admin_log($sn = '', $action, $content)
{
    $log_info = $GLOBALS['_LANG']['log_action'][$action] . $GLOBALS['_LANG']['log_action'][$content] .': '. addslashes($sn);

    $sql = 'INSERT INTO ' . $GLOBALS['lk']->table('admin_log') . ' (log_time, user_id, log_info, ip_address) ' .
            " VALUES ('" . time() . "', $_SESSION[admin_id], '" . stripslashes($log_info) . "', '" . real_ip() . "')";
    $GLOBALS['db']->query($sql);
}

/* 删除数组 */
function unsetArray(&$arr)
{
	foreach($arr as $k=>$v)
	{
		if(is_array($v)){
			unsetArray($v);
		}else{
			unset($arr[$k]);
		}
	}
}

/**
 * URL过滤
 * @param   string  $url  参数字符串，一个urld地址,对url地址进行校正
 * @return  返回校正过的url;
 */
function sanitize_url($url , $check = 'http://')
{
    if (strpos( $url, $check ) === false)
    {
        $url = $check . $url;
    }
    return $url;
}

/**
 * 创建编辑器
 * @return  返回编辑器实例;
 */
function createCkedit($name = '', $value = ''){
	include_once 'ckeditor/ckeditor.php';
	include_once 'ckfinder/ckfinder.php';

	$initialValue = $value;
	$CKEditor = new CKEditor();
	$CKEditor->basePath = "ckeditor/";
	$CKEditor->returnOutput = true;
	$CKEditor->config['height'] = 250;
	$CKEditor->config['width'] = 550;
	$CKEditor->config['skin'] = 'v2';
//	$CKEditor->config['toolbar'] = array(
//					array( 'Source','-','Save','NewPage','Preview','-','Templates'),
//					array( 'Cut','Copy','Paste','PasteText','PasteFromWord'),                       
//					array( 'Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat' ),                      array( 'Bold','Italic','Underline','Strike','-','Subscript','Superscript'), 
//					array('NumberedList','BulletedList','-','Outdent','Indent','Blockquote'), 
//					array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'), 
//					array('Link','Unlink','Anchor'), 
//					array('Image','Flash','Table','HorizontalRule','SpecialChar'),
//					array('TextColor','BGColor'),
//   array('Styles','Format','Font','FontSize'), 
//			);

	$ckfinder = new CKFinder();
	$ckfinder->BasePath ='ckfinder/';
	$ckfinder->SetupCKEditorObject($CKEditor);				
	
	$code = $CKEditor->editor($name, $initialValue);
	return $code;
}
/**
 * 分页的信息加入条件的数组
 *
 * @access  public
 * @return  array
 */
function page_and_size($filter)
{
    if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
    {
        $filter['page_size'] = intval($_REQUEST['page_size']);
    }
    elseif (isset($_COOKIE['PAGE']['page_size']) && intval($_COOKIE['PAGE']['page_size']) > 0)
    {
        $filter['page_size'] = intval($_COOKIE['PAGE']['page_size']);
    }
    else
    {
        $filter['page_size'] = 15;
    }

    /* 每页显示 */
    $filter['page'] = (empty($_REQUEST['page']) || intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

    /* page 总数 */
    $filter['page_count'] = (!empty($filter['record_count']) && $filter['record_count'] > 0) ? ceil($filter['record_count'] / $filter['page_size']) : 1;

    /* 边界处理 */
    if ($filter['page'] > $filter['page_count'])
    {
        $filter['page'] = $filter['page_count'];
    }

    $filter['start'] = ($filter['page'] - 1) * $filter['page_size'];

    return $filter;
}

/**
 * 保存过滤条件
 * @param   array   $filter     过滤条件
 * @param   string  $sql        查询语句
 * @param   string  $param_str  参数字符串，由list函数的参数组成
 */
function set_filter($filter, $sql, $param_str = '')
{
    $filterfile = basename(PHP_SELF, '.php');
    if ($param_str)
    {
        $filterfile .= $param_str;
    }
    setcookie('PAGE[lastfilterfile]', sprintf('%X', crc32($filterfile)), time() + 600);
    setcookie('PAGE[lastfilter]',     urlencode(serialize($filter)), time() + 600);
    setcookie('PAGE[lastfiltersql]',  urlencode($sql), time() + 600);
}

/**
 * 取得上次的过滤条件
 * @param   string  $param_str  参数字符串，由list函数的参数组成
 * @return  如果有，返回array('filter' => $filter, 'sql' => $sql)；否则返回false
 */
function get_filter($param_str = '')
{
    $filterfile = basename(PHP_SELF, '.php');
    if ($param_str)
    {
        $filterfile .= $param_str;
    }
    if (isset($_GET['uselastfilter']) && isset($_COOKIE['PAGE']['lastfilterfile'])
        && $_COOKIE['PAGE']['lastfilterfile'] == sprintf('%X', crc32($filterfile)))
    {
        return array(
            'filter' => unserialize(urldecode($_COOKIE['PAGE']['lastfilter'])),
            'sql'    => urldecode($_COOKIE['PAGE']['lastfiltersql'])
        );
    }
    else
    {
        return false;
    }
}

/**
 * 创建一个JSON格式的数据
 *
 * @access  public
 * @param   string      $content
 * @param   integer     $error
 * @param   string      $message
 * @param   array       $append
 * @return  void
 */
function make_json_response($content='', $error="0", $message='', $append=array())
{
    include_once(ROOT_PATH . 'includes/cls_json.php');

    $json = new JSON;

    $res = array('error' => $error, 'message' => $message, 'content' => $content);

    if (!empty($append))
    {
        foreach ($append AS $key => $val)
        {
            $res[$key] = $val;
        }
    }

    $val = $json->encode($res);

    exit($val);
}

/**
 *
 *
 * @access  public
 * @param
 * @return  void
 */
function make_json_result($content, $message='', $append=array())
{
    make_json_response($content, 0, $message, $append);
}

/**
 * 创建一个JSON格式的错误信息
 *
 * @access  public
 * @param   string  $msg
 * @return  void
 */
function make_json_error($msg)
{
    make_json_response('', 1, $msg);
}
/**
 * 检查管理员权限
 *
 * @access  public
 * @param   string  $authz
 * @return  boolean
 */
function check_authz($authz)
{
    return (preg_match('/,*'.$authz.',*/', $_SESSION['action_list']) || $_SESSION['action_list'] == 'all');
}

/**
 * 检查管理员权限，返回JSON格式数剧
 *
 * @access  public
 * @param   string  $authz
 * @return  void
 */
function check_authz_json($authz)
{
    if (!check_authz($authz))
    {
        make_json_error('对不起,您没有执行此操作的权限!');
    }
}
/**
 * 重新格式化图片 
 * $typ   图片类型
 * $id    图片所属的交易信息ID
 * $source_img  资源图片路径
*/
function reformat_image_name($type, $id, $source_img)
{
    $rand_name = (time() - date('Z')) . sprintf("%03d", mt_rand(1,999));
    $img_ext = substr($source_img, strrpos($source_img, '.'));
	$dir = 'userfiles/product_img/' . $_SESSION['admin_name'];
	
    switch($type)
    {
        case 'gallery':
			if (!$GLOBALS['image']->make_dir(ROOT_PATH . $dir . '/gallery'))
			{
				return false;
			}
            $img_name = $id . '_P_' . $rand_name;
			
			if (move_image_file(ROOT_PATH . $source_img, ROOT_PATH . $dir . '/gallery/' . $img_name . $img_ext))
			{
				return $dir.'/gallery/'.$img_name.$img_ext;
			}
            break;
        case 'gallery_thumb':
			if (!$GLOBALS['image']->make_dir(ROOT_PATH . $dir . '/gallery_thumb'))
			{
				return false;
			}
            $img_name = $id . '_thumb_P_' . $rand_name;
			
			if (move_image_file(ROOT_PATH . $source_img, ROOT_PATH . $dir . '/gallery_thumb/' . $img_name . $img_ext))
			{
				return $dir.'/gallery_thumb/'.$img_name.$img_ext;
			}
            break;
			
		case 'swap':
			$dir = 'userfiles/product_img/' . $_SESSION['username'];
			if (!$GLOBALS['image']->make_dir(ROOT_PATH . $dir . '/swap'))
			{
				return false;
			}
            $img_name = $id . '_P_' . $rand_name;
			
			if (move_image_file(ROOT_PATH . $source_img, ROOT_PATH . $dir . '/swap/' . $img_name . $img_ext))
			{
				return $dir.'/swap/'.$img_name.$img_ext;
			}
            break;
    }
    return false;
}

/**
 * 移动文件
 *
 * @access  public
 */
function move_image_file($source, $dest)
{
    if (@copy($source, $dest))
    {
        @unlink($source);
        return true;
    }
    return false;
}
/* 计算文件大小 */
function bytes($size)
{
    $unim = array("B","KB","MB","GB","TB","PB");
    $c = 0;
    while ($size>=1024) {
        $c++;
        $size = $size/1024;
    }
    return number_format($size,($c ? 2 : 0),".",",")." ".$unim[$c];
}
/* 生成颜色和字型的表单内容 */
function style($style = '')
{
	if($style)
	{
		list($color, $b) = explode(' ', $style);
	}
	$styleform = "<option value=\"\">颜色</option>\n";
	for($i=1; $i<=15; $i++)
	{
		$styleform .= "<option value=\"c".$i."\" ".($color == 'c'.$i ? "selected=\"selected\"" : "")." class=\"bg".$i."\"></option>\n";
	}
	$styleform = "<select name=\"style_color\" id=\"style_color\" onchange=\"document.all.style_id.value=document.all.style_color.value;if(document.all.style_strong.checked)document.all.style_id.value += ' '+document.all.style_strong.value;\">\n".$styleform."</select>\n";
	$styleform .= " <label><input type=\"checkbox\" name=\"style_strong\" class=\"radio\" id=\"style_strong\" value=\"b\" ".($b == 'b' ? "checked=\"checked\"" : "")." onclick=\"document.all.style_id.value=document.all.style_color.value;if(document.all.style_strong.checked)document.all.style_id.value += ' '+document.all.style_strong.value;\"> 加粗";
	$styleform .= "</label><input type=\"hidden\" name=\"style\" id=\"style_id\" value=\"".$style."\">";
	return $styleform;
}

function checkAction($action_name)
{
 $action_path='../App/Lib/Action/'.$action_name.'Action.class.php';
 if(file_exists($action_path))
 {
 	return 'Yes';
 }else
 {
 	return 'NO';
 }
}
?>