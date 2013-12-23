<?php
define('IN_LK', true);
@session_start();
require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/cls_category.php');

check_admin();

$exc = new exchange($lk->table("sys_config"), $db, 'id', 'config_name');

if (!$_REQUEST['act'])
{
	admin_priv('sys_config');
	$smarty->assign('ur_here', "系统设置");
	$sql = "SELECT * FROM ".$lk->table('sys_config');
	$sys_config = $db->getAll($sql);
	$smarty->assign('sys_config',  $sys_config);
	$smarty->assign('form_act',    'insert');
	$smarty->display('sys_config_info.html');
}
elseif ($_REQUEST['act'] == 'insert')
{
    admin_priv('sys_config');
	$arr = array();
    $sql = 'SELECT id, value FROM ' . $lk->table('sys_config');
    $res = $db->query($sql);
    while($row = $db->fetch_array($res))
    {
        $arr[$row['id']] = $row['value'];
    }
	
    foreach ($_POST['value'] AS $key => $val)
    {
        if($arr[$key] != $val)
        {
            $sql = "UPDATE ".$lk->table('sys_config')." SET value = '" . trim($val) . "' WHERE id = '" . $key . "'";
            $db->query($sql);
        }
    }
	admin_log('', 'edit', 'sys_config');
	$link[0]['text'] = '返回系统设置';
	$link[0]['href'] = 'sys_config.php';
	sys_msg("系统设置成功", 0, $link);
}
/*------------------------------------------------------ */
//-- 发送测试邮件
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'send_test_email')
{
    /* 检查权限 */
    check_authz_json('shop_config');

    /* 取得参数 */
    $email          = trim($_POST['email']);

    /* 更新配置 */
    $_CFG['mail_service'] = intval($_POST['mail_service']);
    $_CFG['smtp_host']    = trim($_POST['smtp_host']);
    $_CFG['smtp_port']    = trim($_POST['smtp_port']);
    $_CFG['smtp_user']    = json_str_iconv(trim($_POST['smtp_user']));
    $_CFG['smtp_pass']    = trim($_POST['smtp_pass']);
    $_CFG['smtp_mail']    = trim($_POST['reply_email']);

    if (send_mail('', $email, '测试邮件', '您好！这是一封检测邮件服务器设置的测试邮件。收到此邮件，意味着您的邮件服务器设置正确！您可以进行其它邮件发送的操作了！', 0))
    {
        make_json_result('', '恭喜！测试邮件已成功发送到 ' . $email);
    }
    else
    {
        make_json_error('访问被拒绝.');
    }
}
?>