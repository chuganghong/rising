<?PHP
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

define('ROOT_PATH', str_replace('admin/includes/init.php', '', str_replace('\\', '/', __FILE__)));
define("SITE_NAME", "日先管理后台");
define('IMAGE_DIR', 'data/images'); //上传的图片路径
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

if (isset($_SERVER['PHP_SELF']))
{
    define('PHP_SELF', $_SERVER['PHP_SELF']);
}
else
{
    define('PHP_SELF', $_SERVER['SCRIPT_NAME']);
}

require(ROOT_PATH . 'includes/config.php');
require(ROOT_PATH . 'admin/includes/lib_main.php');
require(ROOT_PATH . 'admin/includes/cls_exchange.php');
require(ROOT_PATH . 'includes/lib_main.php');
require(ROOT_PATH . 'includes/cls_mysql.php');
require(ROOT_PATH . 'includes/cls_lk.php');

/* 设定默认时区 */
if (PHP_VERSION >= '5.1' && !empty($timezone))
{
    date_default_timezone_set($timezone);
}
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

/* 创建LK 对象 */
$lk = new LK($db_name, $prefix);

/* 初始化数据库类 */
$db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
$db_host = $db_user = $db_pass = $db_name = NULL;

/* 载入系统参数 */
$_CFG = load_config();

/* 设置Smarty模版目录 */
require(ROOT_PATH . "includes/smarty/Smarty.class.php");
define("TPL_PATH" , ROOT_PATH . "admin/templates/");


/* 载入日志配置文件 */
require(ROOT_PATH . 'admin/ini/log_action.php');
/* 载入左侧菜单语言 */
require(ROOT_PATH . 'admin/ini/menu_action.php');

/* 设置Smarty */
$smarty = new Smarty;
$smarty->template_dir    = TPL_PATH;
$smarty->compile_dir     = TPL_PATH."templates_c/";
$smarty->config_dir      = TPL_PATH."configs/";
$smarty->cache_dir       = TPL_PATH."cache/";
$smarty->left_delimiter  = "{"; 
$smarty->right_delimiter = "}";
$smarty->cache           = false;

$smarty->assign('myarray', join(',',explode('|',trim($GLOBALS['_CFG']['badkey'],'|'))));//敏感词数组

/* 管理员登录后可在任何页面使用 act=phpinfo 显示 phpinfo() 信息 */
if ($_REQUEST['act'] == 'phpinfo' && function_exists('phpinfo'))
{
    phpinfo();

    exit;
}
header('content-type: text/html; charset=' . GS_CHARSET);
header('Expires: Fri, 14 Mar 1980 20:53:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
?>