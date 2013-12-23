// 添加到收藏夹
function addFavorite()
{
	var isFirefox=(navigator.userAgent.indexOf("Firefox")>0);
	if (isFirefox)  // firefox
	{
    window.sidebar.addPanel("广州蓝空数码科技有限公司", "http://www.19lk.com","");
	}
	else if (document.all) 
	{
		window.external.addFavorite("http://www.19lk.com", "广州蓝空数码科技有限公司");
	}
}