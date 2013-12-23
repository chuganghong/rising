<?php
define('IN_LK', true);
@session_start();
require(dirname(__FILE__) . '/includes/init.php');

/* act操作项的初始化 */
if (empty($_REQUEST['act']))
{
	$_REQUEST['act'] = 'login';
}
else
{
	$_REQUEST['act'] = trim($_REQUEST['act']);
}

/*------------------------------------------------------ */
//-- 退出登录
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'logout')
{
	unsetArray($_SESSION);
//	setcookie('autologin','',time()-3600);
	header("Location: ./index.php\n");
}

/*------------------------------------------------------ */
//-- 验证码显示
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'captcha')
{
	include(ROOT_PATH . 'includes/cls_captcha.php');

	$img = new captcha();
	@ob_end_clean(); //清除之前出现的多余输入
	$img->generate_image();

	exit;
}

/*------------------------------------------------------ */
//-- 用户登录
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'login')
{
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	
	//读取cookie
//	if(!empty($_COOKIE["saveuser"]))
//	{
//		if(empty($para['user']) || $para['user']==$_COOKIE["saveuser"])
//		{
//			$para['user'] = $_COOKIE["saveuser"];
//			$para['pass'] = $_COOKIE["savepass"];
//		}
//		$para['saveuser'] = 1;
//	}
	
//	if(!empty($_COOKIE["autologin"]))
//	{
//		$para['autologin'] = 1;
//	}
	
	$smarty->assign('random',     mt_rand());
	$smarty->assign('date',       date("Y"));
//	$smarty->assign('para',       $para);
	$smarty->display('login.html');
}

/*------------------------------------------------------ */
//-- 处理用户登录
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'signin')
{
	$username = isset($_POST['user']) ? trim($_POST['user']) : '';
	$password = isset($_POST['pass']) ? trim($_POST['pass']) : '';
//	
//	if($_POST['autologin']!='1'){
//		setcookie('autologin','',time()-3600);
//	}
	
	if (!empty($_SESSION['captcha_word']))
	{
		//判断是否自动登陆
//		if($_POST['user'] == $_COOKIE["saveuser"] && $_COOKIE["autologin"]!=md5('SYSAUTOLOGIN:'.$_COOKIE["saveuser"]))
//		{
			include_once(ROOT_PATH . 'includes/cls_captcha.php');
	
			/* 检查验证码是否正确 */
			$validator = new captcha();
			if (empty($_POST['captcha']) || !$validator->check_word($_POST['captcha']))
			{
				sys_msg('您输入的验证码不正确！', 1);
			}
		//}
	}

	/* 检查密码是否正确 */
	$sql = "SELECT au.*, r.* FROM " . $lk->table('admin_user') . " AS au 
			LEFT JOIN " . $lk->table('role') . " AS r 
			ON au.role_id = r.role_id 
			WHERE au.user_name = '" . $username. "' AND au.password = '" . md5($password) . "'";
	$row = $db->get_one($sql);

	if ($row)
	{
		unsetArray($_SESSION);
		
		// 登录成功
		$row['last_login'] = date('Y-m-d H:i:s',$row['last_login']);

		$_SESSION['admin_id']    = $row['user_id'];
		$_SESSION['admin_name']  = $row['user_name'];
		$_SESSION['admin_true']  = $row['true_name'];
		$_SESSION['action_list'] = $row['action_list'];
		$_SESSION['last_login']  = $row['last_login'];
		$_SESSION['role_id']     = $row['role_id'];

		// 更新最后登录时间和IP
		$db->query("UPDATE " . $lk->table('admin_user') .
				 " SET last_login='" . time() . "', last_ip='" . real_ip() . "'".
				 " WHERE user_id='$_SESSION[admin_id]'"); 

		//设置cookie
//		if($_POST['saveuser']=='1'){
//			setcookie('saveuser',$_POST['user'],time()+3600*24*365);
//			setcookie('savepass',$_POST['pass'],time()+3600*24*365);
//		}else{
//			setcookie('saveuser','',time()-3600);
//			setcookie('savepass','',time()-3600);
//		}
//		if($_POST['autologin']=='1'){
//			setcookie('autologin',md5('SYSAUTOLOGIN:'.$_POST['user']),time()+3600*24*365);
//		}else{
//			setcookie('autologin','',time()-3600);
//		}
		
		header("Location: ./main.php\n");
		exit;
	}
	else
	{
		sys_msg('用户名或密码错误！', 1);
	}
}
?>