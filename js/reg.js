function send_url(url,reobj)
{
	var http_request = false;
	if(window.XMLHttpRequest){//��IE����XMLHttpRequest
		http_request = new XMLHttpRequest();
		if(http_request.overrideMimeType){//����MIME���
			http_request.overrideMimeType =("text/xml");
			}
	}
	else if(window.ActiveXObject){//IE���
		var msxml = ['Microsoft.XMLHTTP', 'MSXML.XMLHTTP', 'Msxml2.XMLHTTP.7.0', 'Msxml2.XMLHTTP.6.0', 'Msxml2.XMLHTTP.5.0', 'Msxml2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP'];
		for(var i=0;i<msxml.length;i++)
		{
			try{
				http_request = new ActiveXObject(msxml[i]);
				}
			catch(e){}
		}
		}
	
	if(!http_request){//����xmlhttprequest���ɹ�
		window.alert("����XMLHttp����ʧ�ܣ�");
          	return false;
		}
	http_request.onreadystatechange=function(){
		processrequest(http_request,reobj);
	}
	//ȷ����������ʽ��URL�����Ƿ�ͬ��ִ���¶δ���
	http_request.open("GET",url,true);
	http_request.send(null);
}

function processrequest(http_request,reobj)
{
	if(http_request.readyState==4){//�ж϶���״̬
		if(http_request.status==200){//��Ϣ�ѳɹ����أ���ʼ������Ϣ
			//document.getElementById(reobj).innerHTML="ͨ�ųɹ����������ڴ�����...";
				if (http_request.responseText.length > 0)
				{
					switch(http_request.responseText)
					{
						
						
						case "11":
						case "12":
							document.getElementById("idp").className="rr";
							document.getElementById("ide").innerHTML="<font color=red>ͨ��֤�ʺŲ�����Ҫ��</font>";
							break;
						case "13":
							document.getElementById("idp").className="rr";
							document.getElementById("ide").innerHTML="<font color=red>���ʺ��ѱ�ʹ��</font>";
							break;	
						case "15":
							document.getElementById("idp").className="rr";
							document.getElementById("ide").innerHTML="<font color=red>���ݴ������</font>";
							break;	
						case "14":
							document.getElementById("idp").className="rr3";
							document.getElementById("ide").innerHTML="";
							break;
						default:
							document.getElementById("idp").className="rr";
							document.getElementById("ide").innerHTML="<font color=red>���ݴ������</font>";
							break;						
													
					}
				}
				else
				{
							document.getElementById("idp").className="rr";
							document.getElementById("ide").innerHTML="<font color=red>���ݴ������</font>";
				}
			}else{
				document.getElementById("idp").className="rr";
				document.getElementById("ide").innerHTML="ͨ��ʧ��!��ˢ������";
				}
		}
	}

function getlen( str)  //��ȡ�ַ���(������������)����
{
	var totallength=0;
	for (var i=0;i<str.length;i++)
	{
		var intCode=str.charCodeAt(i);
		if (intCode>=0&&intCode<=128) 
		{
			totallength=totallength+1;//�����ĵ����ַ����ȼ�1
		}
		else 
		{
			totallength=totallength+2;//�����ַ��������2
		}
	}
	return totallength;
}

function onlyNum()  //���������ֻ��Ϊ����
{
	if(!(event.keyCode==46)&&!(event.keyCode==8)&&!(event.keyCode==37)&&!(event.keyCode==39))
		if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105)))
    			event.returnValue=false;
}

function checkcardstring( s ) //�ж����֤��������Ƿ�Ϊ����ĸX��x����
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

function checkemailstring( s )  //��֤�ʼ���ַ�Ƿ�Ϸ�
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
		document.getElementById("ide").innerHTML="ͨ��֤�ʺŲ���Ϊ��";	
         	return false;
    	}
    	else if(id.length < 4 || id.length > 18)
    	{
		document.getElementById("idp").className="rr";
		document.getElementById("ide").innerHTML="ͨ��֤�ʺų���ӦΪ4-18���ַ�";	
         	return false; 		
    	}
    	else if(!re.test(id))
    	{
		document.getElementById("idp").className="rr";
		document.getElementById("ide").innerHTML="ͨ��֤�ʺ�Ӧ��4-18λ��ĸ��������ɣ��м����ɰ���һ���»���";	
         	return false; 
    	}
    	else
    	{
    		document.getElementById("ide").innerHTML="������֤����...";
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
				document.getElementById("pswe").innerHTML="���벻��Ϊ��";	
		         	return false; 
			}
			else if (getlen(psw) < 5 || getlen(psw) > 14)
			{
				document.getElementById("pswp").className="rr";
				document.getElementById("pswe").innerHTML="���볤��5��14λ����ĸ���ִ�Сд";	
		         	return false; 
			}
			else if (!re.test(psw))
			{
				document.getElementById("pswp").className="rr";
				document.getElementById("pswe").innerHTML="���볤��5��14λ����ĸ���ִ�Сд";	
		         	return false; 				
			}
			break;
		case 2:
			var repsw = f.repasswd.value;
			if ( repsw == "" )
			{
				document.getElementById("pswp").className="rr";
				document.getElementById("pswe").innerHTML="�ظ����벻��Ϊ��";	
		        return false; 
			}
			else if(getlen(repsw) < 5 || getlen(repsw) > 14)
			{
				document.getElementById("pswp").className="rr";
				document.getElementById("pswe").innerHTML="�ظ����볤��5��14λ����ĸ���ִ�Сд";	
		         	return false; 
			}
			else if( repsw != document.form.passwd.value )
			{
				document.getElementById("pswp").className="rr";
				document.getElementById("pswe").innerHTML="�ظ����������벻һ�£�����������";	
		         	return false; 
			}
			else if (!re.test(repsw))
			{
				document.getElementById("pswp").className="rr";
				document.getElementById("pswe").innerHTML="���볤��5��14λ����ĸ���ִ�Сд";	
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
		document.getElementById("idcarde").innerHTML="���֤���벻��Ϊ��";	
         	return false; 
	}
	else if((getlen(card)!=15 && getlen(card)!=18) || checkcardstring(card))
	{
		document.getElementById("idcardp").className="rr";
		document.getElementById("idcarde").innerHTML="���֤�����ʽ����";	
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
		document.getElementById("unamee").innerHTML="������<font color=red>������</font>����Ҫ���ݡ�����ȷ��д";	
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
		document.getElementById("emaile").innerHTML="E-mail����Ϊ��";
		return false; 
	}
	else if(checkemailstring(emailstring))
	{
		document.getElementById("emailp").className="rr";
		document.getElementById("emaile").innerHTML="E-mail��ʽ����";
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
			document.getElementById("ide").innerHTML="�˺�������ĸ��ͷ������3~24λ�����԰������֡���ĸ(���ִ�Сд)���»���";	
			break;
		case 2:
			document.getElementById("pswp").className="rr2";
			document.getElementById("pswe").innerHTML="���볤��5��14λ����ĸ���ִ�Сд";
			break;
		case 3:
			document.getElementById("idcardp").className="rr2";
			document.getElementById("idcarde").innerHTML="���֤������<font color=red>ȡ���˺�</font>������ϣ���������д��<font color=red>��󽫲����޸ġ�</font>";
			break;		
		case 4:
			document.getElementById("emailp").className="rr2";
			document.getElementById("emaile").innerHTML="����������<font color=red>��ɫɾ�����һ�����</font>����Ҫ;��������ȷ��д";
			break;
		case 7:
			document.getElementById("unamep").className="rr2";
			document.getElementById("unamee").innerHTML="��ʵ��ע����ʺ�Ȩ�����ܱ�����";		
			break;
		case 5:
			document.getElementById("birthe").innerHTML="�������ڸ�ʽ��xxxx-xx-xx";
			break;
		case 6:
			document.getElementById("phonee").innerHTML="�绰�����ʽ��020-88888888��13700000000";
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
			alert("��ȷ�������Ķ���ͬ�⡶������������Ƽ����޹�˾ͨ��֤�û�Э�顷");
			return false;
		}
	}
	else
	{
		alert("��������֤��");
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
