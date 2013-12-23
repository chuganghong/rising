<?PHP
if (!defined('IN_LK'))
{
    die('Hacking attempt');
}
/**这里决定栏目的上下排序*/

/* 广告管理 */
$modules['ads_manage']['01_list_flash'] = 'flashplay.php?act=list';

/*链接管理*/
$modules['link_manage']['link_list'] = 'link.php?act=list';


/*栏目管理*/
$modules['Case_manage']['01_Case_category'] = 'Case_cat.php?act=list';
//$modules['Case_manage']['02_Case_list'] = 'Case.php?=act=list';

/*关于我们*/
$dcat_id = 8;    //设置关于我们默认首页的cat_id=8;
$ccat_id = 7;    //设置关于日先足迹--其他的cat_id=8;

$modules['about_manage']['default'] = 'about.php?act=c_txt_list&cat_id=' . $dcat_id;
$modules['about_manage']['intro'] = 'about.php?act=intro';
$modules['about_manage']['course'] = 'about.php?act=course_main';  //日先足迹主体文字部分

$modules['about_manage']['c_pic'] = 'about.php?act=c_pic';  //'日先足迹-图片';
$modules['about_manage']['c_txt'] = 'about.php?act=c_txt_list&cat_id=' . $ccat_id;  //'日先足迹-其他';



$modules['about_manage']['honor'] = 'about.php?act=honor';
$modules['about_manage']['idea'] = 'about.php?act=idea';

/*日先作品*/
$modules['works_manage']['brand_list'] = 'works.php?act=brand_list';   //合作品牌
$modules['works_manage']['works_list'] = 'album.php?act=list';   //经典作品

/*加入我们*/
$modules['join_manage']['idea_list'] = 'join.php?act=list';   //人才理念
$modules['join_manage']['job_list'] = 'join.php?act=list';   // 招聘职位



/*动态与观点*/
$modules['trends_manage']['trends'] = 'trends.php?act=list';   //店铺视角
$modules['trends_manage']['trends2'] = 'trends2.php?act=list';   //日先动态

//新闻会客室

$cid1 = 6;   //日先简介
$cid2 = 1; //关于我们
$cid3 = 18; //人才理念
$cid4 = 19; //招聘职位
$cid5 = 4; //加入我们
$cid6 = 12;//店铺视角
$cid7 = 9;//日先理念
$cid8 = 13;//日先动态
$modules['news_manage']['intro_news_list'] = 'news_link.php?act=list&cat_id=' . $cid1;   //日先简介
$modules['news_manage']['about_news_list'] = 'news_link.php?act=list&cat_id=' . $cid2;   //关于我们
$modules['news_manage']['pidea_news_list'] = 'news_link.php?act=list&cat_id=' . $cid3;   //人才理念
$modules['news_manage']['job_news_list'] = 'news_link.php?act=list&cat_id=' . $cid4;   //招聘职位
$modules['news_manage']['join_news_list'] = 'news_link.php?act=list&cat_id=' . $cid5;   //加入我们
$modules['news_manage']['view_news_list'] = 'news_link.php?act=list&cat_id=' . $cid6;   //店铺视角
$modules['news_manage']['idea_news_list'] = 'news_link.php?act=list&cat_id=' . $cid7;   //日先理念
$modules['news_manage']['trends2_news_list'] = 'news_link.php?act=list&cat_id=' . $cid8;   //日先动态

//订阅管理
$modules['book_manage']['user_list'] = 'book.php?act=list';   //会员列表
$modules['book_manage']['email'] = 'book.php?act=email';   //发送邮件的邮箱设置
$modules['book_manage']['etitle'] = 'book.php?act=etitle';   //邮件标题



/* 权限管理 */
$modules['priv_manage']['01_admin_list'] = 'admin_user.php?act=list';
$modules['priv_manage']['02_admin_logs'] = 'admin_logs.php?act=list';
$modules['priv_manage']['03_admin_role'] = 'role.php?act=list';




/* 数据库管理 */
$modules['db_manage']['01_db_backup'] = 'database.php?act=backup';
$modules['db_manage']['02_db_restore'] = 'database.php?act=restore';
$modules['db_manage']['03_db_optimize'] = 'database.php?act=optimize';
$modules['db_manage']['04_sql_query'] = 'sqlquery.php?act=main';
?>