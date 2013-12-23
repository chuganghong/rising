<?PHP
define('IN_LK', true);
require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/cls_upload.php');

if(isset($_REQUEST['PHPSESSID'])){ 
	session_id($_REQUEST['PHPSESSID']); // 调用 session_id function 放入 session id 
	session_start();
}

$upload_allowext = explode('|',strtoupper(str_replace('*.','',$_CFG['upload_allowext'])));
$upload_maxsize  = '20971520';

if($_REQUEST['dosubmit'])
{
	$upload = new cls_upload($upload_allowext, $upload_maxsize);
	$file_url = $upload->upload_file($_FILES['Filedata'], 'data/soft_file');

	if($file_url)
	{
		if ($_REQUEST['old_file'])
		{
			$soft_url = explode('|',$_REQUEST['old_file']);
			@unlink(ROOT_PATH . $soft_url[1]);
		}
		exit($_FILES['Filedata']['name'].'|'.$file_url);
	}
	else
	{
		exit($upload->error_msg());
	}	
}
?>