<?PHP
if (!defined('IN_LK'))
{
    die('Hacking attempt');
}
/* 权限管理的一级分组 */
$_LANG['priv']      = '权限管理';
$_LANG['db']        = '数据库管理';
$_LANG['Case']        = '栏目管理';
$_LANG['ads']       = '广告管理';

//广告管理部分的权限
$_LANG['flash_manage']     = 'FLASH广告管理';

/*资信管理*/
$_LANG['Case_cat_manage']  = '案例栏目添加/编辑';
$_LANG['Case_cat_drop']    = '案例栏目删除';
$_LANG['Case_manage']      = '案例添加/编辑';
$_LANG['Case_drop']        = '案例删除';

//权限管理部分的权限
$_LANG['admin_manage']     = '管理员添加/编辑';
$_LANG['admin_pass']       = '修改密码';
$_LANG['admin_drop']       = '删除管理员';
$_LANG['logs_manage']      = '管理日志列表';
$_LANG['logs_drop']        = '删除管理日志';
$_LANG['role_manage']      = '角色管理';

//数据库管理部分的权限
$_LANG['db_backup']        = '数据备份';
$_LANG['db_restore']       = '数据恢复';
$_LANG['db_optimize']      = '数据表优化';
$_LANG['sql_query']        = 'SQL查询';
?>