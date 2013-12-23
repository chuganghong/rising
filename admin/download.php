<?PHP
define('IN_LK', true);
require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/global.func.php');

$parameters = base64_decode(str_replace(" ","+",$_GET['parameters'])); //防止有些中文GET过来+变成空格
parse_str($parameters);
$fileurl   = trim($f);
$filename  = trim($t);

if(empty($fileurl) || empty($filename)) $error = '参数错误';

$fileurl = file_exists($fileurl) ? stripslashes($fileurl) : ROOT_PATH.$fileurl;//此处可能为物理路径

$filename = basename($fileurl);

if(preg_match("/^([\s\S]*?)([\x81-\xfe][\x40-\xfe])([\s\S]*?)/", $filename))//处理中文文件
{
	$filename = str_replace(array("%5C", "%2F", "%3A"), array("\\", "/", ":"), urlencode($filename));
	$filename = urldecode($filename);
}
if($error)
{
	echo '<script>alert("'.$error.'");window.history.back(-1);</script>';
}else{
	file_down($fileurl, $filename);
}
?>