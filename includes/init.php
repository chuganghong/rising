<?php
if (!defined('IN_LK'))
{
	die('Hacking attempt');
}

/*自定义错误处理机制
1). 0 = 关闭所有错误
1). E_ALL 表示输出所有信息
2). E_ALL & ~ E_NOTICE 表示输出所有的错误，除了提示。
3). E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR 表示输出所有的ERROR信息。
4). E_WARNING | E_ERROR 表示输出所有的警告与错误信息。
*/
error_reporting(E_ALL & ~ E_NOTICE);

if (__FILE__ == '')
{
    die('Fatal error code: 0');
}
if (isset($_SERVER['PHP_SELF']))
{
    define('PHP_SELF', $_SERVER['PHP_SELF']);
}
else
{
    define('PHP_SELF', $_SERVER['SCRIPT_NAME']);
}
/* 取得网站根目录名称 如: gs_portals */
$root = explode('/',trim(PHP_SELF,'/'));
define('ROOT', $root[0] . '/');

/* 取得当前所在的物理根目录 */
define('ROOT_PATH', str_replace('includes/init.php', '', str_replace('\\', '/', __FILE__)));
define('SCHEME', $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://');
define('SITE_URL', SCHEME.$_SERVER['HTTP_HOST'] . '/' . ROOT);
define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
define('SITE_NAME',"日先");
define('DATA_DIR',  'data'); //上传的数据路径

/* 区分win和linux路径 */
if (DIRECTORY_SEPARATOR == '\\')
{
    @ini_set('include_path',      '.;' . ROOT_PATH);
}
else
{
    @ini_set('include_path',      '.:' . ROOT_PATH);
}

require(ROOT_PATH . 'includes/config.php');

/* 设定默认时区 */
if (PHP_VERSION >= '5.1' && !empty($timezone))
{
    date_default_timezone_set($timezone);
}

$php_self = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
if ('/' == substr($php_self, -1))
{
    $php_self .= 'index.php';
}
define('PHP_SELF', $php_self);

require(ROOT_PATH . 'includes/lib_main.php');
require(ROOT_PATH . 'admin/includes/lib_main.php');
require(ROOT_PATH . 'includes/cls_lk.php');
require(ROOT_PATH . 'includes/cls_mysql.php');
require(ROOT_PATH . 'admin/includes/cls_exchange.php');

/* 对用户传入的变量进行转义操作。*/
if (!get_magic_quotes_gpc())
{
    if (!empty($_GET))
    {
        $_GET  = addslashes_deep($_GET);
    }
    if (!empty($_POST))
    {
        $_POST = addslashes_deep($_POST);
    }

    $_COOKIE   = addslashes_deep($_COOKIE);
    $_REQUEST  = addslashes_deep($_REQUEST);
}

/* 可以直接使用名称作为变量 */
//foreach($_GET as $k=>$v){
//	$$k=$v;
//}
//foreach($_POST as $k=>$v){
//	$$k=$v;
//}

/* 创建 lk 对象 */
$lk = new lk($db_name, $prefix);
/* 实例化MYSQL类 */
$db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
$db_host = $db_user = $db_pass = $db_name = NULL;

/* 载入系统参数 */
$_CFG = load_config();
$cache_lifetime = 3600;

/* 初始化“页面标题”和“当前位置” */
$page_title = SITE_NAME . ' - ' . 'Powered by lk';
$ur_here    = '<a href="./">首页</a>';

/* 设置Smarty模版目录 */
require(ROOT_PATH . "includes/smarty/Smarty.class.php");

$smarty = new Smarty;
$smarty->template_dir    = ROOT_PATH . 'themes/';
$smarty->compile_dir     = ROOT_PATH . 'themes/templates_c/';
$smarty->config_dir      = ROOT_PATH . 'themes/configs/';
$smarty->cache_dir       = ROOT_PATH . 'themes/cache/';
$smarty->cache           = false;

/* 站点描述及关键字 */
$smarty->assign('site_key',  $_CFG['description']);
$smarty->assign('site_dec',  $_CFG['keywords']);

header('Cache-control: private');
header('Content-type: text/html; charset='.GS_CHARSET);

/* 判断用户是否登录 */
//is_session();

/* 统计访问量 */
//visit_stats();
/*导行*/
$action = explode('.php',strtolower($_SERVER['PHP_SELF']));
$action = explode('/',trim($action[0],'/'));
$smarty->assign('action',     $action[0]);

?>