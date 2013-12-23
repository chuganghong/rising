<?PHP
if (!defined('IN_LK'))
{
    die('Hacking attempt');
}

//广告管理权限
$purview['01_list_flash']       = 'flash_manage';

/*案例管理*/
$purview['01_Case_category']    = array('Case_cat_manage', 'Case_cat_drop');
$purview['02_Case_list']        = array('Case_manage', 'Case_drop');

//权限管理权限
$purview['01_admin_list']       = array('admin_manage', 'admin_drop');
$purview['02_admin_logs']       = array('logs_manage', 'logs_drop');
$purview['03_admin_role']       = 'role_manage';

//数据库管理权限
$purview['01_db_backup']        = 'db_backup';
$purview['02_db_restore']       = 'db_restore';
$purview['03_db_optimize']      = 'db_optimize';
$purview['04_sql_query']        = 'sql_query';
?>