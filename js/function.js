// JavaScript Document
function imgZoom(obj)
{
	/* 内容中心 */
	if(obj == 'imgZoom')
	{
		$('#'+obj+' img').each(function() { 
			var maxWidth = 700; // 图片最大宽度 
			var maxHeight = 525; // 图片最大高度 
			var ratio = 0; // 缩放比例 
			var width = $(this).width(); // 图片实际宽度 
			var height = $(this).height(); // 图片实际高度 
			// 检查图片是否超宽 
			if(width > maxWidth){ 
				ratio = maxWidth / width; // 计算缩放比例 
				$(this).css("width", maxWidth); // 设定实际显示宽度 
				//height = height * ratio; // 计算等比例缩放后的高度 
				//$(this).css("height", height * ratio); // 设定等比例缩放后的高度 
			} 
			// 检查图片是否超高 
			if(height > maxHeight){ 
				ratio = maxHeight / height; // 计算缩放比例 
				$(this).css("height", maxHeight); // 设定实际显示高度 
				//width = width * ratio; // 计算等比例缩放后的高度 
				//$(this).css("width", width * ratio); // 设定等比例缩放后的高度 
			} 
		});
	/* 友情链接 */
	}else{
		$('#'+obj+' img').each(function() { 
			var maxWidth = 98; // 图片最大宽度 
			var maxHeight = 28; // 图片最大高度 
			var ratio = 0; // 缩放比例 
			var width = $(this).width(); // 图片实际宽度 
			var height = $(this).height(); // 图片实际高度 
			// 检查图片是否超宽 
			if(width > maxWidth){ 
				ratio = maxWidth / width; // 计算缩放比例 
				$(this).css("width", maxWidth); // 设定实际显示宽度 
				//height = height * ratio; // 计算等比例缩放后的高度 
				//$(this).css("height", height * ratio); // 设定等比例缩放后的高度 
			} 
			// 检查图片是否超高 
			if(height > maxHeight){ 
				ratio = maxHeight / height; // 计算缩放比例 
				$(this).css("height", maxHeight); // 设定实际显示高度 
				//width = width * ratio; // 计算等比例缩放后的高度 
				//$(this).css("width", width * ratio); // 设定等比例缩放后的高度 
			} 
		});
	}
}

// JavaScript Document
function $V(str){document.write(str);}

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
function GetDate(){
	var rnd = getRnd(10,true,true,false);
	$V("<span id='"+rnd+"' class='text-key'>Loading...</span>");
	
	setInterval(function(){
		
		var calendar = new Date();
		var year = calendar.getFullYear();
		var month = calendar.getMonth();
		var day = calendar.getDate();
		var hours = calendar.getHours();
		var minutes = calendar.getMinutes();
		var seconds = calendar.getSeconds();
		month++;
		
		$("#"+rnd).html(year+'年'+month+'月'+day+'日 '+hours+':'+minutes+':'+seconds+' 星期'+'日一二三四五六'.charAt(new Date().getDay()));
	},1000);
}
/* 幻灯片播放 幻灯片的容器ID必须为:KinSlideshow */
function KinSlideshow()
{
	var moveStyle
	var rand =parseInt(Math.random()*4)
//	switch(rand){
//		case 0:	moveStyle="left" ;break;
//		case 1:	moveStyle="right" ;break;
//		case 2:	moveStyle="down" ;break;
//		case 3:	moveStyle="up" ;break;
//	}	
	$("#KinSlideshow").KinSlideshow({
			moveStyle:"left",
			intervalTime:3,
			mouseEvent:"mouseover",
			isHasTitleFont:false,
			titleFont:{TitleFont_size:14},
			titleBar:{titleBar_height:30},
			btn:{btn_bgColor:"#FFFFFF",btn_bgHoverColor:"#1072aa",btn_fontColor:"#000000",
				 btn_fontHoverColor:"#FFFFFF",btn_borderColor:"#cccccc",
				 btn_borderHoverColor:"#1188c0",btn_borderWidth:1}
	});
}
/* TAB切换 */
function onhover(op){
	for(var i=1;i<=3;i++){
		if(op==i){
			$("#trade"+i).addClass("li_hover2");
			$("#list"+i).css("display","block");
		}else{
			$("#trade"+i).removeClass("li_hover2");
			$("#list"+i).css("display","none");
		}
	}
}