// JavaScript Document
function AjaxCall(url, params, callback, type, dataType)
{
	$.ajax({
		type:type,
		url:url,
		beforeSend:function(XMLHttpRequest){
			showLoader();
		},
		
		data: params,
		dataType:dataType.toLowerCase(),
		error: function(XMLHttpRequest, textStatus, errorThrown){
			alert("错误：" + errorThrown);
		},
		success: function(data,textStatus){
			callback(data);
		},
		complete: function(XMLHttpRequest, textStatus){
			hideLoader();
		}		
	});
}
/* *
 * 显示载入信息
 */
function showLoader()
{
  document.getElementsByTagName('body').item(0).style.cursor = "wait";

  if (top.frames['header-frame'])
  {
    top.frames['header-frame'].document.getElementById("load-div").style.display = "block";
  }
  else
  {
    var obj = document.getElementById('loader');
	var process_request = '正在处理您的请求...';
    if ( ! obj && process_request)
    {
      obj = document.createElement("DIV");
      obj.id = "loader";
      obj.innerHTML = process_request;

      document.body.appendChild(obj);
    }
  }
}

/* *
 * 隐藏载入信息
 */
function hideLoader()
{
  document.getElementsByTagName('body').item(0).style.cursor = "auto";
  if (top.frames['header-frame'])
  {
    setTimeout(function(){top.frames['header-frame'].document.getElementById("load-div").style.display = "none"}, 10);
  }
  else
  {
    try
    {
      var obj = document.getElementById("loader");
      obj.style.display = 'none';
      document.body.removeChild(obj);
    }
    catch (ex)
    {}
  }
}
