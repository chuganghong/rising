// JavaScript Document
function up_click(news_id)
{
	document.getCookie = function(sName)
	{
	  // cookies are separated by semicolons
	  var aCookie = document.cookie.split("; ");
	  for (var i=0; i < aCookie.length; i++)
	  {
		// a name/value pair (a crumb) is separated by an equal sign
		var aCrumb = aCookie[i].split("=");
		if (sName == aCrumb[0])
		  return decodeURIComponent(aCrumb[1]);
	  }
	
	  // a cookie with the requested name does not exist
	  return null;
	}
	
	document.setCookie = function(sName, sValue, sExpires)
	{
	  var sCookie = sName + "=" + encodeURIComponent(sValue);
	  if (sExpires != null)
	  {
		sCookie += "; expires=" + sExpires;
	  }
	
	  document.cookie = sCookie;
	}

	document.removeCookie = function(sName,sValue)
	{
	  document.cookie = sName + "=; expires=Fri, 31 Dec 1999 23:59:59 GMT;";
	}
	
	var NEW_MSG_INTERVAL =60000;
	var lastCheckMsg = new Date(document.getCookie(news_id+"click"));
	var today = new Date();
		if (lastCheckMsg == null || today-lastCheckMsg >= NEW_MSG_INTERVAL)
		{
			document.setCookie(news_id+"click", today.toGMTString());
			$.post("news.php", {act: "up_click", id: news_id}, function(data) {
						window.location="News.php?act=show&id="+news_id;
					});
		}else{
				window.location="News.php?act=show&id="+news_id;
			}
}