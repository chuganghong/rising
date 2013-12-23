<?php
/*载入系统配置信息*/
function load_config()
{
	$sql = 'SELECT config_name, value FROM '.$GLOBALS['lk']->table('sys_config');
	$res = $GLOBALS['db']->getAll($sql);

	foreach ($res AS $row)
	{
		$arr[$row['config_name']] = $row['value'];
	}
	
	return $arr;
}
/* 检查是否含有敏感词语 */
function check_badkey($content)
{
	if(preg_match("/".$GLOBALS['_CFG']['badkey']."/i",$content))
	{
		sys_msg("对不起，含有含有敏感字符，不允许发表", 1);
	}
}
/**
 * 清除缓存文件
 *
 * @access  public
 * @param   mix     $ext    模版文件名， 不包含后缀
 * @return  void
 */
function clear_cache_files()
{
    return clear_tpl_files('admin');
}
/* 清除模板缓存 */
function clear_all_files()
{
   return clear_tpl_files('admin') + clear_tpl_files('themes');
}
/**
 *  清除模板缓存
 *
 * @access  public
 * @param  strimg       $path      admin:后台缓存 themes:前台缓存
 *
 * @return int        返回清除的文件个数
 */
function clear_tpl_files($path = 'admin')
{
    if ($path == 'admin')
    {
        $dir[] = ROOT_PATH . $path . '/templates/templates_c/';
		$dir[] = ROOT_PATH . $path . '/cache/';
    }
    else
    {
        $dir[] = ROOT_PATH . $path . '/templates_c/';
		$dir[] = ROOT_PATH . $path . '/cache/';
    }
	foreach($dir as $k=>$v)
	{
		if (is_dir($v)) 
		{
			if ($folder = @opendir($v))
			{
				while ($file = readdir($folder))
				{
					if ($file == '.' || $file == '..')
					{
						continue;
					}
					if (is_file($v . $file))
					{
						if (@unlink($v . $file))
						{
							$count++;
						}
					}
				}
				closedir($folder);
			}
		}
	}
    return $count;
}
/* 会员权限 */
function user_priv($priv_str, $msg_output = true)
{
	if(!$_SESSION['username'])
	{
		if ($msg_output)
        {
			$root = explode('/',trim(PHP_SELF,'/'));
			echo '<script>alert("对不起,您还没有登录,请登录!")</script>';
			if(count($root)>1)
				echo '<script language="javascript">window.location.href="../member.php?act=login";</script>';
			else
				echo '<script language="javascript">window.location.href="member.php?act=login";</script>';
        }
        return false;	
	}else{
		if ((strpos(',' . $_SESSION['priv_list'] . ',', ',' . $priv_str . ',') === false) || (time() > $_SESSION['endtime']))
		{
			if ($msg_output)
			{
				echo '<script>alert("对不起,您没有相应的权限或者您的权限已过期,请联系客服!")</script>';
				echo '<script language="javascript">window.location.href="'.$_SERVER['HTTP_REFERER'].'";</script>';
			}
			return false;
		}
		else
		{
			return true;
		}
	}
}




/**
 * 创建像这样的查询: "IN('a','b')";
 *
 * @access   public
 * @param    mix      $item_list      列表数组或字符串
 * @param    string   $field_name     字段名称
 *
 * @return   void
 */
function db_create_in($item_list, $field_name = '')
{
    if (empty($item_list))
    {
        return $field_name . " IN ('') ";
    }
    else
    {
        if (!is_array($item_list))
        {
            $item_list = explode(',', $item_list);
        }
        $item_list = array_unique($item_list);
        $item_list_tmp = '';
        foreach ($item_list AS $item)
        {
            if ($item !== '')
            {
                $item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
            }
        }
        if (empty($item_list_tmp))
        {
            return $field_name . " IN ('') ";
        }
        else
        {
            return $field_name . ' IN (' . $item_list_tmp . ') ';
        }
    }
}

/**
 * 递归方式的对变量中的特殊字符进行转义
 *
 * @access  public
 * @param   mix     $value
 *
 * @return  mix
 */
function addslashes_deep($value)
{
    if (empty($value))
    {
        return $value;
    }
    else
    {
        return is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
    }
}

/* 去除转义字符 */
function stripslashes_array($value)
{
	if (empty($value))
    {
        return $value;
    }
    else
    {
	   return  is_array($value) ? array_map('stripslashes_array', $value) : stripslashes($value);
	}
}

function mkdirs($pathname, $mode = 0777) {
	is_dir(dirname($pathname)) || mkdirs(dirname($pathname), $mode);
	return is_dir($pathname) || @mkdir($pathname, $mode);
}


/**
 * 对 MYSQL LIKE 的内容进行转义
 *
 * @access      public
 * @param       string      string  内容
 * @return      string
 */
function mysql_like_quote($str)
{
    return strtr($str, array("\\\\" => "\\\\\\\\", '_' => '\_', '%' => '\%', "\'" => "\\\\\'"));
}

/**
 * 文件或目录权限检查函数
 *
 * @access          public
 * @param           string  $file_path   文件路径
 * @param           bool    $rename_prv  是否在检查修改权限时检查执行rename()函数的权限
 *
 * @return          int     返回值的取值范围为{0 <= x <= 15}，每个值表示的含义可由四位二进制数组合推出。
 *                          返回值在二进制计数法中，四位由高到低分别代表
 *                          可执行rename()函数权限、可对文件追加内容权限、可写入文件权限、可读取文件权限。
 */
function file_mode_info($file_path)
{
    /* 如果不存在，则不可读、不可写、不可改 */
    if (!file_exists($file_path))
    {
        return false;
    }

    $mark = 0;

    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
    {
        /* 测试文件 */
        $test_file = $file_path . '/cf_test.txt';

        /* 如果是目录 */
        if (is_dir($file_path))
        {
            /* 检查目录是否可读 */
            $dir = @opendir($file_path);
            if ($dir === false)
            {
                return $mark; //如果目录打开失败，直接返回目录不可修改、不可写、不可读
            }
            if (@readdir($dir) !== false)
            {
                $mark ^= 1; //目录可读 001，目录不可读 000
            }
            @closedir($dir);

            /* 检查目录是否可写 */
            $fp = @fopen($test_file, 'wb');
            if ($fp === false)
            {
                return $mark; //如果目录中的文件创建失败，返回不可写。
            }
            if (@fwrite($fp, 'directory access testing.') !== false)
            {
                $mark ^= 2; //目录可写可读011，目录可写不可读 010
            }
            @fclose($fp);

            @unlink($test_file);

            /* 检查目录是否可修改 */
            $fp = @fopen($test_file, 'ab+');
            if ($fp === false)
            {
                return $mark;
            }
            if (@fwrite($fp, "modify test.\r\n") !== false)
            {
                $mark ^= 4;
            }
            @fclose($fp);

            /* 检查目录下是否有执行rename()函数的权限 */
            if (@rename($test_file, $test_file) !== false)
            {
                $mark ^= 8;
            }
            @unlink($test_file);
        }
        /* 如果是文件 */
        elseif (is_file($file_path))
        {
            /* 以读方式打开 */
            $fp = @fopen($file_path, 'rb');
            if ($fp)
            {
                $mark ^= 1; //可读 001
            }
            @fclose($fp);

            /* 试着修改文件 */
            $fp = @fopen($file_path, 'ab+');
            if ($fp && @fwrite($fp, '') !== false)
            {
                $mark ^= 6; //可修改可写可读 111，不可修改可写可读011...
            }
            @fclose($fp);

            /* 检查目录下是否有执行rename()函数的权限 */
            if (@rename($test_file, $test_file) !== false)
            {
                $mark ^= 8;
            }
        }
    }
    else
    {
        if (@is_readable($file_path))
        {
            $mark ^= 1;
        }

        if (@is_writable($file_path))
        {
            $mark ^= 14;
        }
    }

    return $mark;
}
/**
 * 邮件发送
 *
 * @param: $name[string]        接收人姓名
 * @param: $email[string]       接收人邮件地址
 * @param: $subject[string]     邮件标题
 * @param: $content[string]     邮件内容
 * @param: $type[int]           0 普通邮件， 1 HTML邮件
 * @param: $notification[bool]  true 要求回执， false 不用回执
 *
 * @return boolean
 */
function send_mail($name, $email, $subject, $content, $type = 0, $notification=false)
{
	$charset   = GS_CHARSET;
	/**
     * 使用mail函数发送邮件
     */
    if ($GLOBALS['_CFG']['mail_service'] == 0 && function_exists('mail'))
    {
        /* 邮件的头部信息 */
        $content_type = ($type == 0) ? 'Content-Type: text/plain; charset=' . $charset : 'Content-Type: text/html; charset=' . $charset;
        $headers = array();
        $headers[] = 'From: "' . '=?' . $charset . '?B?' . base64_encode('蓝空') . '?='.'" <' . $GLOBALS['_CFG']['smtp_mail'] . '>';
        $headers[] = $content_type . '; format=flowed';
        if ($notification)
        {
            $headers[] = 'Disposition-Notification-To: '.'=?'.$charset . '?B?'.base64_encode('蓝空').'?='.'" <'.$GLOBALS['_CFG']['smtp_mail'].'>';
        }
        $res = @mail($email, '=?' . $charset . '?B?' . base64_encode($subject) . '?=', $content, implode("\r\n", $headers));

        if (!$res)
        {
            make_json_error('邮件发送失败,请检查您的邮件服务器设置');
            return false;
        }
        else
        {
            return true;
        }
    }
	/**
     * 使用smtp服务发送邮件
     */
    else
    {
		/* 邮件的头部信息 */
        $content_type = ($type == 0) ?
            'Content-Type: text/plain; charset=' . $charset : 'Content-Type: text/html; charset=' . $charset;
        $content   =  base64_encode($content);

        $headers = array();
        $headers[] = 'Date: ' . gmdate('D, j M Y H:i:s') . ' +0000';
        $headers[] = 'To: "' . '=?' . $charset . '?B?' . base64_encode($name) . '?=' . '" <' . $email. '>';
        $headers[] = 'From: "' . '=?' . $charset . '?B?' . base64_encode('蓝空') . '?='.'" <' . $GLOBALS['_CFG']['smtp_mail'] . '>';
        $headers[] = 'Subject: ' . '=?' . $charset . '?B?' . base64_encode($subject) . '?=';
        $headers[] = $content_type . '; format=flowed';
        $headers[] = 'Content-Transfer-Encoding: base64';
        $headers[] = 'Content-Disposition: inline';
        if ($notification)
        {
            $headers[] = 'Disposition-Notification-To: ' . '=?' . $charset . '?B?' . base64_encode('蓝空') . '?='.'" <' . $GLOBALS['_CFG']['smtp_mail'] . '>';
        }
		
        /* 获得邮件服务器的参数设置 */
        $params['host'] = $GLOBALS['_CFG']['smtp_host'];
        $params['port'] = $GLOBALS['_CFG']['smtp_port'];
        $params['user'] = $GLOBALS['_CFG']['smtp_user'];
        $params['pass'] = $GLOBALS['_CFG']['smtp_pass'];

        if (empty($params['host']) || empty($params['port']))
        {
            // 如果没有设置主机和端口直接返回 false
            make_json_error('邮件服务器设置信息不完整');
            return false;
        }
        else
        {
            // 发送邮件
            if (!function_exists('fsockopen'))
            {
                //如果fsockopen被禁用，直接返回
                make_json_error('fsockopen函数被禁用');
                return false;
            }

            include_once(ROOT_PATH . 'includes/cls_smtp.php');
            static $smtp;

            $send_params['recipients'] = $email;
            $send_params['headers']    = $headers;
            $send_params['from']       = $GLOBALS['_CFG']['smtp_mail'];
            $send_params['body']       = $content;

            if (!isset($smtp))
            {
                $smtp = new smtp($params);
            }

            if ($smtp->connect() && $smtp->send($send_params))
            {
                return true;
            }
            else
            {
                $err_msg = $smtp->error_msg();
                if (empty($err_msg))
                {
                    make_json_error('Unknown Error');
                }
                else
                {
					if (strpos($err_msg, 'Failed to connect to server') !== false)
					{
						make_json_error(sprintf('无法连接到邮件服务器 %s', $params['host'] . ':' . $params['port']));
					}
					else if (strpos($err_msg, 'AUTH command failed') !== false)
					{
						make_json_error('邮件服务器验证帐号或密码不正确');
					}
					elseif (strpos($err_msg, 'bad sequence of commands') !== false)
					{
					   make_json_error('服务器拒绝发送该邮件');
					}
					else
					{
					   make_json_error($err_msg);
					}
                }
                return false;
            }
        }
    }
}
/**
 * 将JSON传递的参数转码
 *
 * @param string $str
 * @return string
 */
function json_str_iconv($str)
{
    if (GS_CHARSET != 'utf-8')
    {
        if (is_string($str))
        {
            return iconv('utf-8', GS_CHARSET, $str);
        }
        elseif (is_array($str))
        {
            foreach ($str as $key => $value)
            {
                $str[$key] = json_str_iconv($value);
            }
            return $str;
        }
        elseif (is_object($str))
        {
            foreach ($str as $key => $value)
            {
                $str->$key = json_str_iconv($value);
            }
            return $str;
        }
        else
        {
            return $str;
        }
    }
    return $str;
}


 /**
 * 获取文件后缀名,并判断是否合法
 *
 * @param string $file_name
 * @param array $allow_type
 * @return blob
 */
function get_file_suffix($file_name, $allow_type = array())
{
    $file_suffix = strtolower(array_pop(explode('.', $file_name)));
    if (empty($allow_type))
    {
        return $file_suffix;
    }
    else
    {
        if (in_array($file_suffix, $allow_type))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
/**
 * 将上传文件转移到指定位置
 *
 * @param string $file_name
 * @param string $target_name
 * @return blog
 */
function move_upload_file($file_name, $target_name = '')
{
    if (function_exists("move_uploaded_file"))
    {
        if (move_uploaded_file($file_name, $target_name))
        {
            @chmod($target_name,0755);
            return true;
        }
        else if (copy($file_name, $target_name))
        {
            @chmod($target_name,0755);
            return true;
        }
    }
    elseif (copy($file_name, $target_name))
    {
        @chmod($target_name,0755);
        return true;
    }
    return false;
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
function sys_msgs($msg_detail, $msg_type = 0, $links = array(), $auto_redirect = true)
{
    if (count($links) == 0)
    {
        $links[0]['text'] = '返回上一页';
        $links[0]['href'] = 'javascript:history.go(-1)';
    }

    $GLOBALS['smarty']->assign('ur_here',     SITE_NAME);//导航
    $GLOBALS['smarty']->assign('msg_detail',  $msg_detail);
    $GLOBALS['smarty']->assign('msg_type',    $msg_type);
    $GLOBALS['smarty']->assign('links',       $links);
    $GLOBALS['smarty']->assign('default_url', $links[0]['href']);
    $GLOBALS['smarty']->assign('auto_redirect', $auto_redirect);
	$GLOBALS['smarty']->assign('ur_here',      "系统信息");

    $GLOBALS['smarty']->display('message.html');

    exit;
}
function sys_msgs_en($msg_detail, $msg_type = 0, $links = array(), $auto_redirect = true)
{
    if (count($links) == 0)
    {
        $links[0]['text'] = 'Go back to the previous page';
        $links[0]['href'] = 'javascript:history.go(-1)';
    }

    $GLOBALS['smarty']->assign('ur_here',     SITE_NAME);//导航
    $GLOBALS['smarty']->assign('msg_detail',  $msg_detail);
    $GLOBALS['smarty']->assign('msg_type',    $msg_type);
    $GLOBALS['smarty']->assign('links',       $links);
    $GLOBALS['smarty']->assign('default_url', $links[0]['href']);
    $GLOBALS['smarty']->assign('auto_redirect', $auto_redirect);
	$GLOBALS['smarty']->assign('ur_here',      "System information");

    $GLOBALS['smarty']->display('en/message.html');

    exit;
}
/* 头部菜单 判断是否为当前页 */
function nav_list($action = '')
{
	global $navigator_list;
	global $smarty;
	$noindex = false;
	
	if(!empty($action))
	{
		foreach($navigator_list as $k=>$v)
		{
			if(is_array($v['name']))
			{
				if(in_array($action, $v['name']))
				{
					$navigator_list[$k]['tab'] = '1';	
					$noindex = true;
				}
			}else{
				if(strtolower($v['name']) == $action)
				{
					$navigator_list[$k]['tab']='1';	
					$noindex = true;
				}
			}
		}
	}
	if ($noindex == false) {
        $navigator_list['config']['index'] = 1;
    }
	$smarty->assign('navigator_list',  $navigator_list);
}
function channels_nav_list($action, $cat_id = 0)
{
	global $channels_nav_list;
	global $smarty;
	$noindex = false;
	
	if(!empty($action))
	{
		foreach($channels_nav_list as $k=>$v)
		{
			if(is_array($v['name']))
			{
				if(in_array($action, $v['name']))
				{
					$channels_nav_list[$k]['tab'] = '1';
					$noindex = true;
				}
			}else{
				if(strtolower($v['name']) == $action)
				{
					$channels_nav_list[$k]['tab']='1';	
					$noindex = true;
				}
			}
			
			if ($cat_id && $v['name'] != 'soft' && $v['name'] != 'media' && $v['name'] != 'sms' && $v['name'] != 'research_cat' && $v['name'] != 'website') 
				$channels_nav_list[$k]['url'] .= '?cat_id='.$cat_id;
			
			$act = explode('.php',strtolower($_SERVER['PHP_SELF']));
			$act = explode('/',trim($act[0],'/'));
			if ($v['name'] == 'swap') $channels_nav_list[$k]['url'] = $act[0].'.php';
//			switch ($cat_id)
//			{
//				case 1:
//					if ($v['name'] == 'swap')
//						$channels_nav_list[$k]['url'] = 'metal.php';
//					break;
//				case 2:
//					if ($v['name'] == 'swap')
//						$channels_nav_list[$k]['url'] = 'steel.php';
//					break;
//				case 4:
//					if ($v['name'] == 'swap')
//						$channels_nav_list[$k]['url'] = 'plastic.php';
//					break;
//				case 5:
//					if ($v['name'] == 'swap')
//						$channels_nav_list[$k]['url'] = 'build.php';
//					break;
//			}
		}
	}
	if ($noindex == false) {
        $channels_nav_list['config']['index'] = 1;
    }
	$smarty->assign('channels_nav_list',  $channels_nav_list);
}
/**
 * 创建编辑器
 * @return  返回编辑器实例;
 */
function createEditor($name = 'contents', $value = '')
{
	include_once('HtmlEditor/htmlEditor.class.php');
	$editor = new HtmlEditor($name);
	$editor->Value = $value;
	$editor->BasePath = '.';
	$editor->Height   = 300;
	$editor->Width    = 500;
	$editor->AutoSave = false;
	$code = $editor->Create();
	return $code;
}

/*多选*/
function duoxuan($key)
{
	$aihao=$_REQUEST[$key];
	
	$count=count($aihao);
	$str="";
	for ($i=0;$i<$count;$i++)
	{
		
		if ($i==0)
		{
			$fuhao="";
		}else
		{
			$fuhao=",";
		}
		$str.=$fuhao;
		$str.=$aihao[$i];
	}
	return $str;
}

/**
 * 获得用户的真实IP地址
 *
 * @access  public
 * @return  string
 */
function real_ip()
{
    static $realip = NULL;

    if ($realip !== NULL)
    {
        return $realip;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr AS $ip)
            {
                $ip = trim($ip);

                if ($ip != 'unknown')
                {
                    $realip = $ip;

                    break;
                }
            }
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if (isset($_SERVER['REMOTE_ADDR']))
            {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $realip = '0.0.0.0';
            }
        }
    }
    else
    {
        if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_CLIENT_IP'))
        {
            $realip = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $realip = getenv('REMOTE_ADDR');
        }
    }

    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

    return $realip;
}
/**
 * 获取模版文件下拉列表
 * $pre  模版文件前缀名
 * $sel  当前选中的选项
 */
function select_template($pre = '', $sel = '')
{
	$select = '';
	/* 取得语言项 */
	if (file_exists(ROOT_PATH . 'ini/lang_template.php'))
	{
		include_once(ROOT_PATH . 'ini/lang_template.php');
	}
	$templatedir = ROOT_PATH . 'themes/';
	$files = array_map('basename', glob($templatedir.$pre.'*.html'));
	foreach($files as $file)
	{
		$key = substr($file, 0, -5);
		$templates[$key] = '['.$file.'] - ' . $_LANG['template_libs'][$key];
	}
	ksort($templates);
	foreach($templates as $key=>$val)
	{
		if($key == $sel)
			$select .= '<option value="'.$key.'" selected="selected">'.$val.'</option>';
		else
			$select .= '<option value="'.$key.'" >'.$val.'</option>';
	}
	return $select;
}

function getRoll($path='')
{
	if($path=='path')
	{
		$path='../';
	}else
	{
		$path='';
	}
	/*跑马灯*/
	$queryminute  = "SELECT * FROM " . $GLOBALS['lk']->table('uptothe_minute')." where 1  order by addtime desc limit 0,1";
	$rs=$GLOBALS['db']->get_one($queryminute);
	if($rs['attr']=='1')
	{
		$talk="".$rs['truename']." 恭喜您注册成功！";
	}else
	{
		if($rs['stype']=='1')
		{
			$name='<font color="#FF3300">供应</font>';
		}elseif($rs['stype']=='2')
		{
			$name='<font color="#00CC33">求购</font>';
		}else
		{
			$name='<font color="#3399FF">其他</font>';
		}
		if($rs['cat_id']=='1')
			{
				$type="metal/metal.php?act=show&swap=".$rs['swap_id']."";
			}elseif($rs['cat_id']=='2')
			{
				$type="steel/steel.php?act=show&swap=".$rs['swap_id']."";
			}elseif($rs['cat_id']=='4')
			{
				$type="build/build.php?act=show&swap=".$rs['swap_id']."";
			}else
			{
				$type="plastic/plastic.php?act=show&swap=".$rs['swap_id']."";
			}
		$talk='['.$name.']&nbsp;<font color="#014DA3">'.$rs['title'].'</font>&nbsp; 
		<a href="'.$path.$type.'" target="_blank"><font color="#FF3300">点击这里</font></a>';
	}
	$data[]=array('talk'=>$talk);
	//return $data;
	echo json_encode($data);
}
/**
 * 统计访问信息
 *
 * @access  public
 * @return  void
 */
function visit_stats()
{
    if (isset($GLOBALS['_CFG']['visit_stats']) && $GLOBALS['_CFG']['visit_stats'] == 'off')
    {
        return;
    }
    $time = time();
    /* 检查客户端是否存在访问统计的cookie */
    $visit_times = (!empty($_COOKIE['lk']['visit_times'])) ? intval($_COOKIE['lk']['visit_times']) + 1 : 1;
    setcookie('lk[visit_times]', $visit_times, $time + 86400 * 365, '/');
	
    $browser  = get_user_browser();
    $os       = get_os();
    $ip       = real_ip();
	require("cls_ip_area.php");
	$ip_area = new ip_area();
	$area    = $ip_area->get($ip);

    /* 语言 */
    if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE']))
    {
        $pos  = strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], ';');
        $lang = addslashes(($pos !== false) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, $pos) : $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    }
    else
    {
        $lang = '';
    }

    /* 来源 */
    if (!empty($_SERVER['HTTP_REFERER']) && strlen($_SERVER['HTTP_REFERER']) > 9)
    {
        $pos = strpos($_SERVER['HTTP_REFERER'], '/', 9);
        if ($pos !== false)
        {
            $domain = substr($_SERVER['HTTP_REFERER'], 0, $pos);
            $path   = substr($_SERVER['HTTP_REFERER'], $pos);

            /* 来源关键字 */
            if (!empty($domain) && !empty($path))
            {
                save_searchengine_keyword($domain, $path);
            }
        }
        else
        {
            $domain = $path = '';
        }
    }
    else
    {
        $domain = $path = '';
    }
	
	/* 如下文件不记录到统计表中 */
	$allow_suffix = array('getRoll', 'js', 'SH', 'member', 'member_alipay_integral', 'member_intro', 'member_issuance', 'member_model', 'member_news', 'member_password_up', 'picture', 'postpic_upload', 'scan_por', 'search', 'shop_main', 'show_shop', 'ad', 'ajaxTypeArea', 'ask', 'c', 'company_up', 'download', 'individual_up', 'main_imgs', 'main_msg','news','episteme');
	
	$tmp = explode('.',end(explode('/',trim(PHP_SELF,'/'))));
	if(in_array($tmp[0], $allow_suffix))
	{
		return;	
	}
    $sql = 'INSERT INTO ' . $GLOBALS['lk']->table('stats') . ' ( ' .
                'ip_address, visit_times, browser, system, language, area, ' .
                'referer_domain, referer_path, access_url, access_time' .
            ') VALUES (' .
                "'$ip', '$visit_times', '$browser', '$os', '$lang', '$area', ".
                "'" . addslashes($domain) ."', '" . addslashes($path) ."', '" . addslashes(PHP_SELF) ."', '" . $time . "')";
    $GLOBALS['db']->query($sql);
}
/**
 * 获得浏览器名称和版本
 *
 * @access  public
 * @return  string
 */
function get_user_browser()
{
    if (empty($_SERVER['HTTP_USER_AGENT']))
    {
        return '';
    }

    $agent       = $_SERVER['HTTP_USER_AGENT'];
    $browser     = '';
    $browser_ver = '';

    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs))
    {
        $browser     = 'Internet Explorer';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'FireFox';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/Maxthon/i', $agent, $regs))
    {
        $browser     = '(Internet Explorer ' .$browser_ver. ') Maxthon';
        $browser_ver = '';
    }
    elseif (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'Opera';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs))
    {
        $browser     = 'OmniWeb';
        $browser_ver = $regs[2];
    }
    elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'Netscape';
        $browser_ver = $regs[2];
    }
    elseif (preg_match('/safari\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'Safari';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs))
    {
        $browser     = '(Internet Explorer ' .$browser_ver. ') NetCaptor';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'Lynx';
        $browser_ver = $regs[1];
    }

    if (!empty($browser))
    {
       return addslashes($browser . ' ' . $browser_ver);
    }
    else
    {
        return 'Unknow browser';
    }
}
/**
 * 获得客户端的操作系统
 *
 * @access  private
 * @return  void
 */
function get_os()
{
    if (empty($_SERVER['HTTP_USER_AGENT']))
    {
        return 'Unknown';
    }

    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $os    = '';

    if (strpos($agent, 'win') !== false)
    {
        if (strpos($agent, 'nt 5.1') !== false)
        {
            $os = 'Windows XP';
        }
        elseif (strpos($agent, 'nt 5.2') !== false)
        {
            $os = 'Windows 2003';
        }
        elseif (strpos($agent, 'nt 5.0') !== false)
        {
            $os = 'Windows 2000';
        }
        elseif (strpos($agent, 'nt 6.0') !== false)
        {
            $os = 'Windows Vista';
        }
        elseif (strpos($agent, 'nt') !== false)
        {
            $os = 'Windows NT';
        }
        elseif (strpos($agent, 'win 9x') !== false && strpos($agent, '4.90') !== false)
        {
            $os = 'Windows ME';
        }
        elseif (strpos($agent, '98') !== false)
        {
            $os = 'Windows 98';
        }
        elseif (strpos($agent, '95') !== false)
        {
            $os = 'Windows 95';
        }
        elseif (strpos($agent, '32') !== false)
        {
            $os = 'Windows 32';
        }
        elseif (strpos($agent, 'ce') !== false)
        {
            $os = 'Windows CE';
        }
    }
    elseif (strpos($agent, 'linux') !== false)
    {
        $os = 'Linux';
    }
    elseif (strpos($agent, 'unix') !== false)
    {
        $os = 'Unix';
    }
    elseif (strpos($agent, 'sun') !== false && strpos($agent, 'os') !== false)
    {
        $os = 'SunOS';
    }
    elseif (strpos($agent, 'ibm') !== false && strpos($agent, 'os') !== false)
    {
        $os = 'IBM OS/2';
    }
    elseif (strpos($agent, 'mac') !== false && strpos($agent, 'pc') !== false)
    {
        $os = 'Macintosh';
    }
    elseif (strpos($agent, 'powerpc') !== false)
    {
        $os = 'PowerPC';
    }
    elseif (strpos($agent, 'aix') !== false)
    {
        $os = 'AIX';
    }
    elseif (strpos($agent, 'hpux') !== false)
    {
        $os = 'HPUX';
    }
    elseif (strpos($agent, 'netbsd') !== false)
    {
        $os = 'NetBSD';
    }
    elseif (strpos($agent, 'bsd') !== false)
    {
        $os = 'BSD';
    }
    elseif (strpos($agent, 'osf1') !== false)
    {
        $os = 'OSF1';
    }
    elseif (strpos($agent, 'irix') !== false)
    {
        $os = 'IRIX';
    }
    elseif (strpos($agent, 'freebsd') !== false)
    {
        $os = 'FreeBSD';
    }
    elseif (strpos($agent, 'teleport') !== false)
    {
        $os = 'teleport';
    }
    elseif (strpos($agent, 'flashget') !== false)
    {
        $os = 'flashget';
    }
    elseif (strpos($agent, 'webzip') !== false)
    {
        $os = 'webzip';
    }
    elseif (strpos($agent, 'offline') !== false)
    {
        $os = 'offline';
    }
    else
    {
        $os = 'Unknown';
    }

    return $os;
}
/**
 * 保存搜索引擎关键字
 *
 * @access  public
 * @return  void
 */
function save_searchengine_keyword($domain, $path)
{
    if (strpos($domain, 'google.com.tw') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'GOOGLE TAIWAN';
        $keywords = urldecode($regs[1]); // google taiwan
    }
	if (strpos($domain, 'google.com.hk') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'GOOGLE HONGKONG';
        $keywords = urldecode($regs[1]); // google hongkong
    }
    if (strpos($domain, 'google.cn') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'GOOGLE CHINA';
        $keywords = urldecode($regs[1]); // google china
    }
    if (strpos($domain, 'google.com') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'GOOGLE';
        $keywords = urldecode($regs[1]); // google
    }
    elseif (strpos($domain, 'baidu.') !== false && preg_match('/wd=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'BAIDU';
        $keywords = urldecode($regs[1]); // baidu
    }
    elseif (strpos($domain, 'baidu.') !== false && preg_match('/word=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'BAIDU';
        $keywords = urldecode($regs[1]); // baidu
    }
    elseif (strpos($domain, '114.vnet.cn') !== false && preg_match('/kw=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'CT114';
        $keywords = urldecode($regs[1]); // ct114
    }
    elseif (strpos($domain, 'iask.com') !== false && preg_match('/k=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'IASK';
        $keywords = urldecode($regs[1]); // iask
    }
    elseif (strpos($domain, 'soso.com') !== false && preg_match('/w=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'SOSO';
        $keywords = urldecode($regs[1]); // soso
    }
    elseif (strpos($domain, 'sogou.com') !== false && preg_match('/query=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'SOGOU';
        $keywords = urldecode($regs[1]); // sogou
    }
    elseif (strpos($domain, 'so.163.com') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'NETEASE';
        $keywords = urldecode($regs[1]); // netease
    }
    elseif (strpos($domain, 'yodao.com') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'YODAO';
        $keywords = urldecode($regs[1]); // yodao
    }
    elseif (strpos($domain, 'zhongsou.com') !== false && preg_match('/word=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'ZHONGSOU';
        $keywords = urldecode($regs[1]); // zhongsou
    }
    elseif (strpos($domain, 'search.tom.com') !== false && preg_match('/w=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'TOM';
        $keywords = urldecode($regs[1]); // tom
    }
    elseif (strpos($domain, 'live.com') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'MSLIVE';
        $keywords = urldecode($regs[1]); // MSLIVE
    }
    elseif (strpos($domain, 'tw.search.yahoo.com') !== false && preg_match('/p=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'YAHOO TAIWAN';
        $keywords = urldecode($regs[1]); // yahoo taiwan
    }
	elseif (strpos($domain, 'hk.search.yahoo.com') !== false && preg_match('/p=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'YAHOO HONGKONG';
        $keywords = urldecode($regs[1]); // yahoo hongkong
    }
    elseif (strpos($domain, 'cn.yahoo.') !== false && preg_match('/p=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'YAHOO CHINA';
        $keywords = urldecode($regs[1]); // yahoo china
    }
    elseif (strpos($domain, 'yahoo.') !== false && preg_match('/p=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'YAHOO';
        $keywords = urldecode($regs[1]); // yahoo
    }
    elseif (strpos($domain, 'msn.com.tw') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'MSN TAIWAN';
        $keywords = urldecode($regs[1]); // msn taiwan
    }
	elseif (strpos($domain, 'msn.com.hk') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'MSN HONGKONG';
        $keywords = urldecode($regs[1]); // msn hongkong
    }
    elseif (strpos($domain, 'msn.com.cn') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'MSN CHINA';
        $keywords = urldecode($regs[1]); // msn china
    }
    elseif (strpos($domain, 'msn.com') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'MSN';
        $keywords = urldecode($regs[1]); // msn
    }

    if (!empty($keywords))
    {
        $gb_search = array('YAHOO CHINA', 'TOM', 'ZHONGSOU', 'NETEASE', 'SOGOU', 'SOSO', 'IASK', 'CT114', 'BAIDU');
        if (GS_CHARSET == 'utf-8' && in_array($searchengine, $gb_search))
        {
            $keywords = iconv('GBK', 'UTF8', $keywords);
        }
        if (GS_CHARSET == 'gbk' && !in_array($searchengine, $gb_search))
        {
            $keywords = iconv('UTF8', 'GBK', $keywords);
        }

        $GLOBALS['db']->autoReplace($GLOBALS['lk']->table('keywords'), array('date' => date('Y-m-d'), 'searchengine' => $searchengine, 'keyword' => addslashes($keywords), 'count' => 1), array('count' => 1));
    }
}
/**
 * 获得指定国家的所有省份
 *
 * @access      public
 * @param       int     country    国家的编号
 * @return      array
 */
function get_regions($type = 0, $parent = 0)
{
    $sql = 'SELECT region_id, region_name FROM ' . $GLOBALS['lk']->table('region') .
            " WHERE region_type = '$type' AND parent_id = '$parent'";

    return $GLOBALS['db']->getAll($sql);
}

/**
 * 截取字符串
 *
 * @access  public
 * @return  string
 */
function cut_str($sourcestr,$cutlength){
	$returnstr = '';
	$i = $n = 0;
	$str_length = strlen($sourcestr);
	while (($n<$cutlength) and ($i<=$str_length))
	{
		$temp_str = substr($sourcestr,$i,1);
		$ascnum = Ord($temp_str);
		if ($ascnum>=224){
			$returnstr = $returnstr . substr($sourcestr,$i,3);
			$i = $i+3; 
			$n++;
		}elseif ($ascnum>=192){
			$returnstr = $returnstr . substr($sourcestr,$i,2);
			$i = $i+2; 
			$n++;
		}elseif ($ascnum>=65 && $ascnum<=90){
			$returnstr = $returnstr . substr($sourcestr,$i,1);
			$i = $i+1;
			$n++;
		}else{
			$returnstr = $returnstr . substr($sourcestr,$i,1);
			$i = $i+1; 
			$n = $n+0.5;
		}
	}
	if ($str_length>$cutlength){
		$returnstr = $returnstr . "...";
	}
	return $returnstr; 
}

/*IS SESSION*/
function is_session()
{	
		$times=time();
		if($_SESSION['username'])
		{
			$ip=substr($_SERVER['REMOTE_ADDR'],0,50);
			$lasttime=time()+3600;
			$sqls = "SELECT * FROM " . $GLOBALS['lk']->table('is_session')." where username='".$_SESSION['username']."' ";
			$result = $GLOBALS['db']->query($sqls);
			while($rs= $GLOBALS['db']->fetch_array($result))
			{
				if($_SESSION['username']==$rs['username'])
				{
					$sql = "UPDATE   ".$GLOBALS['lk']->table('is_session'). "  
					SET lasttime='".$lasttime."'  WHERE username='".$rs['username']."'";
					$results = $GLOBALS['db']->query($sql);
				}
				
				if($_SESSION['username']==$rs['username'] && $ip<>$rs['ip'])
				{
					unset($_SESSION['username']);
					$lik[]=array('href'=>"index.php",'text'=>'返回首页');
					sys_msgs('帐号在别处登陆', 1,$lik);
				}
			}
		}
			$sqls = "SELECT * FROM " . $GLOBALS['lk']->table('is_session')." ";
			$result = $GLOBALS['db']->query($sqls);
			while($rs= $GLOBALS['db']->fetch_array($result))
			{
				if($rs['lasttime']<$times)
				{
					$sql = "DELETE FROM  ".$GLOBALS['lk']->table('is_session')."   WHERE session_id='".$rs['session_id']."'";
					$resulta = $GLOBALS['db']->query($sql);
				}
			}
}
function alertgo($msg,$url)
{
	if ($msg!="")
	{
		echo '<script language="javascript">alert("'.$msg.'");</script>';
	}
	echo '<script language="javascript">window.location="'.$url.'";</script>';
	exit();
}
/**
 *取得所有分类ID
*/
function cat_list($cat_id, $lower = '')
{		
	$query = "select cat_id, parent_id from ".$GLOBALS['lk']->table('medialoca')." where parent_id='".$cat_id."'";
	$result= $GLOBALS['db']->query($query);
	//如果存在下级目录
	if($num_rows = $GLOBALS['db']->num_rows($result))
	{
		$row = $GLOBALS['db']->fetch_assoc($result); 
		foreach ($row AS $key=>$val)
		{
			$lower .= ','.$val['cat_id'];
			cat_list($val['cat_id'],$lower);
		}
	}
	return $cat_id . ',' . trim($lower,',');
}



// 计算身份证校验码，根据国家标准GB 11643-1999  
function idcard_verify_number($idcard_base)
{
	if(strlen($idcard_base)!=17)
	{
		return false;
	}
	//加权因子
	$factor=array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
	//校验码对应值
	$verify_number_list=array('1','0','X','9','8','7','6','5','4','3','2');
	$checksum=0;
	for($i=0;$i<strlen($idcard_base);$i++)
	{
		$checksum+=substr($idcard_base,$i,1)*$factor[$i];
	}
	$mod=$checksum%11;
	$verify_number=$verify_number_list[$mod];
	return $verify_number;
}
//// 将15位身份证升级到18位  


function idcard_15to18($idcard)
{
	if(strlen($idcard)!=15)
	{
		return false;
	}else
	{
		//如果身份证顺序码是 996 997 998 999,这些是为百岁以上老人的特殊编码
		if(array_search(substr($idcard,12,3),array('996','997','999'))!==false)
		{
			$idcard=substr($idcard,0,6).'18'.substr($idcard,6,9);
		}else
		{
			$idcard=substr($idcard,0,6).'19'.substr($idcard,6,9);
		}
	}
	$idcard=$idcard.idcard_verify_number($idcard);
	return $idcard;
}

// 18位身份证校验码有效性检查  

function idcard_checksum18($idcard)
{
	if(strlen($idcard)!=18)
	{
		return false;
	}
	$idcard_base=substr($idcard,0,17);
	if(idcard_verify_number($idcard_base)!=strtoupper(substr($idcard,17,1)))
	{
		return false;
	}else
	{
		return true;
	}
}
/*限制非法登陆*/
function checkload()
{
	if(!$_SESSION['m_username'])
	{
	   header("location:login.php");
	   exit();
	}
}
//验证EMAIL
function checkEmail($inAddress)   
	{   
	
	return (ereg("^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+",$inAddress));   
	}
//验证手机和电话（加区号）
function checkTel($str){
	if(ereg("^([0-9]{2}-?)?0[0-9]{2}-[0-9]{8}$",$str))return 1;//3位区号
	if(ereg("^([0-9]{2}-?)?0[0-9]{10}$",$str))return 2;
	
	if(ereg("^([0-9]{2}-?)?0[0-9]{3}-[0-9]{7}$",$str))return 3;//4位区号
	if(ereg("^0?13[0-9]{9}$",$str))return 4;//手机
	return 0;
}
function unescape($str){ 
$ret = ''; 
$len = strlen($str); 
for ($i = 0; $i < $len; $i++){ 
if ($str[$i] == '%' && $str[$i+1] == 'u'){ 
$val = hexdec(substr($str, $i+2, 4)); 
if ($val < 0x7f) $ret .= chr($val); 
else if($val < 0x800) $ret .= chr(0xc0|($val>>6)).chr(0x80|($val&0x3f)); 
else $ret .= chr(0xe0|($val>>12)).chr(0x80|(($val>>6)&0x3f)).chr(0x80|($val&0x3f)); 
$i += 5; 
} 
else if ($str[$i] == '%'){ 
$ret .= urldecode(substr($str, $i, 3)); 
$i += 2; 
} 
else $ret .= $str[$i]; 
} 
return $ret; 
} 



function escape($str){
preg_match_all("/[\x80-\xff].|[\x01-\x7f]+/",$str,$newstr);
$ar = $newstr[0];
foreach($ar as $k=>$v){
   if(ord($ar[$k])>=127){
    $tmpString=bin2hex(iconv("GBK","ucs-2//IGNORE",$v));
    if (!eregi("WIN",PHP_OS)){
     $tmpString = substr($tmpString,2,2).substr($tmpString,0,2);
    }
    $reString.="%u".$tmpString;
   }else{
    $reString.= rawurlencode($v);
   }
}
return $reString;
}



?>