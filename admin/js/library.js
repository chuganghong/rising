// JavaScript Document
function $V(str){document.write(str);}

function showDateil(src,n){
	var url = src.src;
	if(url.indexOf("menu_plus.gif")!=-1){
		document.getElementById("item_"+n).style.display = "block";
		src.src = url.replace("plus.gif","minus.gif");
	}else{
		document.getElementById("item_"+n).style.display = "none";
		src.src = url.replace("minus.gif","plus.gif");
	}
}
/*是否为数字*/
function isInt(val)
{
	if (val == "")
	{
	  return false;
	}
	var reg = /\D+/;
	return !reg.test(val);	
}
/*
	获取随机字符
	len		长度 
	upper	是否允许大写字母 
	lower	是否允许小写字母 
	num		是否允许数字
*/
function getRnd(len,upper,lower,num){
	var a=new Array(); 
	var b=new Array(""); 
	var c=new Array(""); 
	var e=""; 

	a[0]= ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
	a[1]= ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"];
	a[2]= ["0","1","2","3","4","5","6","7","8","9"]; 

	if(upper){c=b.concat(a[0]);}
	if(lower){c=b.concat(a[1]);}
	if(num){c=b.concat(a[1]);}

	for (var i=0;i<len;i++){ 
		e+=c[Math.round(Math.random()*(c.length-1))] 
	}
	return e; 
}

function Hello(){
	var hour = new Date().getHours();
	if (hour < 4) {
		hello = "夜深了，";
	}else if (hour < 7) {
		hello = "早安，";
	}else if (hour < 9) {
		hello = "早上好，"; 
	}else if (hour < 12) {
		hello = "上午好，";
	}else if (hour < 14) {
		hello = "中午好，";
	}else if (hour < 17) {
		hello = "下午好，";
	}else if (hour < 19) {
		hello = "您好，";
	}else if (hour < 22) {
		hello = "晚上好，";
	}else {
		hello = "夜深了，";
	}
	$V(hello);
}

function GetDate(){
	var rnd = getRnd(10,true,true,false);
	$V("<span id='"+rnd+"' class='text-key'>Loading...</span>");
	
	setInterval(function(){
		var holiday="";
		
		var calendar = new Date();
		var day = calendar.getDay();
		var month = calendar.getMonth();
		var date = calendar.getDate();
		var year = calendar.getFullYear();
		month++;
		
		//母亲节
		var _date=new Date("May 0 "+year);
		if(_date.getDay()==0){
			var _n=14
		}else{
			var _n=14-_date.getDay();
		}
		
		if ((month == 1) && (date == 1)) holiday ="元旦";
		if ((month == 2) && (date == 14)) holiday ="情人节";
		if ((month == 3) && (date == 15)) holiday ="消费者权益日";
		if ((month == 3) && (date == 8)) holiday ="妇女节";
		if ((month == 4) && (date == 1)) holiday ="愚人节";
		if ((month == 3) && (date == 12)) holiday ="植树节 孙中山逝世纪念日";
		if ((month == 5) && (date == 1)) holiday ="国际劳动节";
		if ((month == 5) && (date==_n) && day==0) holiday ="母亲节";
		if ((month == 5) && (date == 4)) holiday ="青年节";
		if ((month == 6) && (date == 1)) holiday ="国际儿童节";
		if ((month == 7) && (date == 1)) holiday ="香港回归纪念日";
		if ((month == 9) && (date == 10)) holiday ="中国教师节";
		if ((month == 9) && (date == 18)) holiday ="九·一八事变纪念日";
		if ((month == 9) && (date == 28)) holiday ="孔子诞辰";
		if ((month == 10) && (date == 6)) holiday ="老人节";
		if ((month == 12) && (date == 20)) holiday ="澳门回归纪念";
		if ((month == 12) && (date == 24)) holiday ="平安夜"; 
		if ((month == 12) && (date == 25)) holiday ="圣诞节";
		
		$("#"+rnd).html(new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay())+" "+holiday);
	},1000);
}

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

/* 检查新消息的时间间隔 毫秒 */
var NEW_MSG_INTERVAL = 180000;

/* *
 * 开始检查新消息；
 */
function startCheckMsg()
{
  checkMsg()
  window.setInterval("checkMsg()", NEW_MSG_INTERVAL);
}

/*
 * 检查消息
 */
function checkMsg()
{ 
  var lastCheckMsg = new Date(document.getCookie('LastCheckMsg'));
  var today = new Date();

  if (lastCheckMsg == null || today-lastCheckMsg >= NEW_MSG_INTERVAL)
  {
    document.setCookie('LastCheckMsg', today.toGMTString());
    try
    {
     AjaxCall('main.php?act=check_msg','', checkMsgResponse, 'GET', 'JSON');
    }
    catch (e) { }
  }
}

/* *
 * 处理检查消息的反馈信息
 */
function checkMsgResponse(result)
{
  //出错屏蔽
  if (result.error != 0 || (result.new_swap == 0 && result.new_tryout == 0 && result.new_qa == 0 && result.new_zine == 0 && result.new_info == 0 && result.new_news == 0))
  {
    //return;
  }
  try
  {
	var winstr = "<div id=\"popMsgClose\"><span onclick=\"Message.close()\" onmouseover=\"style.color='#FF9900';\" onmouseout=\"style.color='red';\">X</span></div><div id=\"popMsgContent\"><img src=\"images/popLogo.gif\" style=\" border-style:none\" align=\"left\" height=\"120\" /><p align=\"center\" style=\"word-break:break-all\">您有 <strong>"+result.member_num+"</strong> 条会员信息 <a href=\"member.php?act=list\"><span>点击查看</span></a></p></div>";
	
    $('#popMsg').html(winstr);
    Message.show();
  }
  catch (e) { }
}

/*
 * 气泡式提示信息
 */
var Message = Object();

Message.bottom  = 0;
Message.count   = 0;
Message.elem    = "popMsg";
Message.mvTimer = null;

Message.show = function()
{
  try
  {
    Message.controlSound('msgBeep');
    document.getElementById(Message.elem).style.visibility = "visible"
    document.getElementById(Message.elem).style.display = "block"

    Message.bottom  = 0 - parseInt(document.getElementById(Message.elem).offsetHeight);
    Message.mvTimer = window.setInterval("Message.move()", 10);

    document.getElementById(Message.elem).style.bottom = Message.bottom + "px";
  }
  catch (e)
  {
    alert(e);
  }
}

Message.move = function()
{
  try
  {
    if (Message.bottom == 0)
    {
      window.clearInterval(Message.mvTimer)
      Message.mvTimer = window.setInterval("Message.close()", 20000)
    }

    Message.bottom ++ ;
    document.getElementById(Message.elem).style.bottom = Message.bottom + "px";
  }
  catch (e)
  {
    alert(e);
  }
}

Message.close = function()
{
  document.getElementById(Message.elem).style.visibility = 'hidden';
  document.getElementById(Message.elem).style.display = 'none';
  if (Message.mvTimer) window.clearInterval(Message.mvTimer)
}

Message.controlSound = function(_sndObj)
{
  sndObj = document.getElementById(_sndObj);

  try
  {
    sndObj.Play();
  }
  catch (e) { }
}
