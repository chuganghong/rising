function send_url(url,reobj)
{
	var http_request = false;
	if(window.XMLHttpRequest){//非IE创建XMLHttpRequest
		http_request = new XMLHttpRequest();
		if(http_request.overrideMimeType){//设置MIME类别
			http_request.overrideMimeType =("text/xml");
			}
	}
	else if(window.ActiveXObject){//IE情况
		var msxml = ['Microsoft.XMLHTTP', 'MSXML.XMLHTTP', 'Msxml2.XMLHTTP.7.0', 'Msxml2.XMLHTTP.6.0', 'Msxml2.XMLHTTP.5.0', 'Msxml2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP'];
		for(var i=0;i<msxml.length;i++)
		{
			try{
				http_request = new ActiveXObject(msxml[i]);
				}
			catch(e){}
		}
		}
	
	if(!http_request){//创建xmlhttprequest不成功
		window.alert("创建XMLHttp对象失败！");
          	return false;
		}
	http_request.onreadystatechange=function(){
		processrequest(http_request,reobj);
	}
	//确定发送请求方式，URL，及是否同步执行下段代码
	http_request.open("GET",url,true);
	http_request.send(null);
}

function processrequest(http_request,reobj)
{
	if(http_request.readyState==4){//判断对象状态
		if(http_request.status==200){//信息已成功返回，开始处理信息
			//document.getElementById(reobj).innerHTML="通信成功，数据正在处理中...";
				if (http_request.responseText.length > 0)
				{
					switch(http_request.responseText)
					{
						
						
						case "11":
						case "12":
							document.getElementById("idp").className="rr";
							document.getElementById("ide").innerHTML="<font color=red>通行证帐号不符合要求</font>";
							break;
						case "13":
							document.getElementById("idp").className="rr";
							document.getElementById("ide").innerHTML="<font color=red>该帐号已被使用</font>";
							break;	
						case "15":
							document.getElementById("idp").className="rr";
							document.getElementById("ide").innerHTML="<font color=red>数据传输错误</font>";
							break;	
						case "14":
							document.getElementById("idp").className="rr3";
							document.getElementById("ide").innerHTML="";
							break;
						default:
							document.getElementById("idp").className="rr";
							document.getElementById("ide").innerHTML="<font color=red>数据传输错误</font>";
							break;						
													
					}
				}
				else
				{
							document.getElementById("idp").className="rr";
							document.getElementById("ide").innerHTML="<font color=red>数据传输错误</font>";
				}
			}else{
				document.getElementById("idp").className="rr";
				document.getElementById("ide").innerHTML="通信失败!请刷新重试";
				}
		}
	}

function getlen( str)  //获取字符串(包括中文在内)长度
{
	var totallength=0;
	for (var i=0;i<str.length;i++)
	{
		var intCode=str.charCodeAt(i);
		if (intCode>=0&&intCode<=128) 
		{
			totallength=totallength+1;//非中文单个字符长度加1
		}
		else 
		{
			totallength=totallength+2;//中文字符长度则加2
		}
	}
	return totallength;
}

function onlyNum()  //控制输入的只能为数字
{
	if(!(event.keyCode==46)&&!(event.keyCode==8)&&!(event.keyCode==37)&&!(event.keyCode==39))
		if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105)))
    			event.returnValue=false;
}

function checkcardstring( s ) //判断身份证号码组成是否为数字母X或x构成
{
	var regu = "^[0-9xX]+$"; 
	var re = new RegExp(regu); 
	if (re.test(s)) 
	{ 
		return false; 
	}
	else
	{ 
		return true; 
	} 
} 

function checkemailstring( s )  //验证邮件地址是否合法
{
	var regu = "^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$";
	var re = new RegExp(regu);
	if (re.test(s)) 
	{ 
		return false; 
	}
	else
	{ 
		return true; 
	} 
}

function checkid()
{
	var f=document.form;
	var id=f.id.value;
	var regu = "^[A-Za-z0-9]+[_]{0,1}[A-Za-z0-9]+$";
	var re = new RegExp(regu);
    	if(id=="")
    	{
		document.getElementById("idp").className="rr";
		document.getElementById("ide").innerHTML="通行证帐号不能为空";	
         	return false;
    	}
    	else if(id.length < 4 || id.length > 18)
    	{
		document.getElementById("idp").className="rr";
		document.getElementById("ide").innerHTML="通行证帐号长度应为4-18个字符";	
         	return false; 		
    	}
    	else if(!re.test(id))
    	{
		document.getElementById("idp").className="rr";
		document.getElementById("ide").innerHTML="通行证帐号应由4-18位字母、数字组成，中间最多可包含一个下划线";	
         	return false; 
    	}
    	else
    	{
    		document.getElementById("ide").innerHTML="正在验证数据...";
    		send_url('member.php?act=cuid&uid='+id,"ide");
   	}
}

function checkpsw( n )
{
	var f = document.form;
	var regu = "^[A-Za-z0-9]+$";
	var re = new RegExp(regu);
	switch( n )
	{
		case 1:
			var psw = f.passwd.value;
			if ( psw == "" )
			{
				document.getElementById("pswp").className="rr";
				document.getElementById("pswe").innerHTML="密码不能为空";	
		         	return false; 
			}
			else if (getlen(psw) < 5 || getlen(psw) > 14)
			{
				document.getElementById("pswp").className="rr";
				document.getElementById("pswe").innerHTML="密码长度5～14位，字母区分大小写";	
		         	return false; 
			}
			else if (!re.test(psw))
			{
				document.getElementById("pswp").className="rr";
				document.getElementById("pswe").innerHTML="密码长度5～14位，字母区分大小写";	
		         	return false; 				
			}
			break;
		case 2:
			var repsw = f.repasswd.value;
			if ( repsw == "" )
			{
				document.getElementById("pswp").className="rr";
				document.getElementById("pswe").innerHTML="重复密码不能为空";	
		        return false; 
			}
			else if(getlen(repsw) < 5 || getlen(repsw) > 14)
			{
				document.getElementById("pswp").className="rr";
				document.getElementById("pswe").innerHTML="重复密码长度5～14位，字母区分大小写";	
		         	return false; 
			}
			else if( repsw != document.form.passwd.value )
			{
				document.getElementById("pswp").className="rr";
				document.getElementById("pswe").innerHTML="重复密码与密码不一致，请重新输入";	
		         	return false; 
			}
			else if (!re.test(repsw))
			{
				document.getElementById("pswp").className="rr";
				document.getElementById("pswe").innerHTML="密码长度5～14位，字母区分大小写";	
		         	return false; 				
			}
			else
			{
				document.getElementById("pswp").className="rr3";
				document.getElementById("pswe").innerHTML="";	
		         	return false; 
			}
			break;
		default:
			break;
	}
}

function checkcard()
{
	var f=document.form;
	var card=f.idcard.value;
	if (card=="")
	{
		document.getElementById("idcardp").className="rr";
		document.getElementById("idcarde").innerHTML="身份证号码不能为空";	
         	return false; 
	}
	else if((getlen(card)!=15 && getlen(card)!=18) || checkcardstring(card))
	{
		document.getElementById("idcardp").className="rr";
		document.getElementById("idcarde").innerHTML="身份证号码格式不对";	
         	return false; 		
	}
	else
	{
		document.getElementById("idcardp").className="rr3";
		document.getElementById("idcarde").innerHTML="";	
         	return true; 
	}	
}

function checkuname()
{
	var f=document.form;
	var uname=f.uname.value;	
	if (uname=="")
	{
		document.getElementById("unamep").className="rr";
		document.getElementById("unamee").innerHTML="姓名是<font color=red>防沉迷</font>的重要依据。请正确填写";	
         	return false; 
	}
	else
	{
		document.getElementById("unamep").className="rr3";
		document.getElementById("unamee").innerHTML="";
		return true;
	}	
}


function checkemail()
{
	var f=document.form;
	var emailstring=f.email.value;
	if ( emailstring == "" )
	{
		document.getElementById("emailp").className="rr";
		document.getElementById("emaile").innerHTML="E-mail不能为空";
		return false; 
	}
	else if(checkemailstring(emailstring))
	{
		document.getElementById("emailp").className="rr";
		document.getElementById("emaile").innerHTML="E-mail格式不对";
		return false; 
	}
	else
	{
		document.getElementById("emailp").className="rr3";
		document.getElementById("emaile").innerHTML="";
		return true;
	}	
}

function showxt()
{
	var f=document.form;
	var choseckd=f.choice.checked;
	if (choseckd)
	{
		document.getElementById("xtinfo").style.display="block";
	}
	else
	{
		document.getElementById("xtinfo").style.display="none";
	}
}

function showtips(n)
{
	switch(n)
	{
		case 1:
			document.getElementById("ide").innerHTML="";
			document.getElementById("idp").className="rr2";
			document.getElementById("ide").innerHTML="账号请以字母开头，长度3~24位。可以包含数字、字母(不分大小写)或下划线";	
			break;
		case 2:
			document.getElementById("pswp").className="rr2";
			document.getElementById("pswe").innerHTML="密码长度5～14位，字母区分大小写";
			break;
		case 3:
			document.getElementById("idcardp").className="rr2";
			document.getElementById("idcarde").innerHTML="身份证号码是<font color=red>取回账号</font>的最后保障，请认真填写，<font color=red>今后将不予修改。</font>";
			break;		
		case 4:
			document.getElementById("emailp").className="rr2";
			document.getElementById("emaile").innerHTML="电子邮箱是<font color=red>角色删除及找回密码</font>的重要途径。请正确填写";
			break;
		case 7:
			document.getElementById("unamep").className="rr2";
			document.getElementById("unamee").innerHTML="非实名注册的帐号权利不受保护！";		
			break;
		case 5:
			document.getElementById("birthe").innerHTML="出生日期格式：xxxx-xx-xx";
			break;
		case 6:
			document.getElementById("phonee").innerHTML="电话号码格式：020-88888888或13700000000";
			break;
	}
}

function checkform()
{
	var f=document.form;
	var xieyivalue=f.xieyi.checked;
	var passcode = f.captcha.value;
	if (passcode != "")
	{
		if ( xieyivalue )
		{
			//document.form.submit();
			return true;
		}
		else
		{
			alert("请确认您已阅读并同意《广州蓝空数码科技有限公司通行证用户协议》");
			return false;
		}
	}
	else
	{
		alert("请输入验证码");
		return false;
	}

}
function check_all()
{


if(checkid()==false || checkuname()==false || (checkpsw(2)==false && checkpsw(1)==false) || checkcard()==false || checkemail()==false || checkform()==false)
{
	return false;
}else
{
	return true;		
}


}
