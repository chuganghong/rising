$(function(){
			
			//index prev
			$(".advertise ul li").hover(function(){
					clearInterval(turnImg);
					var n=$(this).index();
					$(".advertise ul li").eq(n).addClass("cur").siblings().removeClass("cur");
					if(!$('.bigpic').is(":animated")){
							$(".bigpic").eq(n).animate({
							opacity:1,
							zIndex:2
							},1000).siblings(".bigpic").animate({
								opacity:0,
								zIndex:1
								},1000)
						}
				},function(){
					turnImg = setInterval("scrollImg('.advertise ul li[class=cur]','.advertise ul li','.bigpic')",4000)
				});
				
				
				
				//
				
				//index prev
			$(".zuopins span").hover(function(){
					clearInterval(turnZp);
					var n=$(this).index();
					$(".zuopins span").eq(n).addClass("cur").siblings().removeClass("cur");
					if(!$('.zuopin').is(":animated")){
							$(".zuopin").eq(n).animate({
							opacity:1,
							zIndex:2
							},1000).siblings(".zuopin").animate({
								opacity:0,
								zIndex:1
								},1000)
						}
				},function(){
					turnZp = setInterval("scrollImg('.zuopins span[class=cur]','.zuopins span','.bigpic')",4000)
				});
				
				
	})

var timer = 4000;	
var turnImg = setInterval("scrollImg('.advertise ul li[class=cur]','.advertise ul li','.bigpic')",timer);
var turnZp = setInterval("scrollImg('.zuopins span[class=cur]','.zuopins span','.zuopin')",timer)




function scrollImg(indexs,liElem,boxElem){
		var indexElem=$(indexs).index();
		indexElem = indexElem +1;
		//console.log(indexElem);
		if(indexElem>=$(liElem).length){
				indexElem=0;
				$(liElem).eq(indexElem).addClass("cur").siblings().removeClass("cur");
				$(boxElem).eq(indexElem).animate({
						opacity:1,
						zIndex:2
					},1000).siblings(boxElem).animate({
						opacity:0,
						zIndex:1
						},1000)
			}else{
				$(liElem).eq(indexElem).addClass("cur").siblings().removeClass("cur");
				$(boxElem).eq(indexElem).animate({
						opacity:1,
						zIndex:2
					},1000).siblings(boxElem).animate({
						opacity:0,
						zIndex:1
						},1000)
				
				}
		
		
	}

//
//(function() {
//    var     $backToTopEle = $('.backToTop').click(function() {
//            $("html, body").animate({ scrollTop: 0 }, 120);
//    }), $backToTopFun = function() {
//        var st = $(document).scrollTop(), winh = $(window).height();
//        (st > 0)? $backToTopEle.show(): $backToTopEle.hide();    
//        //IE6下的定位
//        if (!window.XMLHttpRequest) {
//            $backToTopEle.css("top", st + winh - 166);    
//        }
//    };
//    $(window).bind("scroll", $backToTopFun);
//    $(function() { $backToTopFun(); });
//})();






//menu
$(function(){
		$(".nav span").hover(function(){
				$(this).addClass("cur");
				$(this).find(".subnav").show();
			},function(){
				$(this).removeClass("cur");
				$(this).find(".subnav").hide();
				});
		$(".blc_wraps").css({width:$(".bottom_l_con").length*543})
		$(".next").click(function(){
				var pos= $(".blc_wraps").position();
				console.log(pos.left)
				console.log($(".bottom_l_con").length-1)
				if(pos.left > -($(".bottom_l_con").length-1)*543 && !$(".blc_wraps").is(":animated")){
					$(".blc_wraps").animate({
							left:'-=543'
						})}else{
							return false
						}
				
			})
		$(".prev").click(function(){
				var pos= $(".blc_wraps").position();
				console.log(pos.left)
				console.log($(".bottom_l_con").length-1)
				if(pos.left < 0 && !$(".blc_wraps").is(":animated")){
					$(".blc_wraps").animate({
							left:'+=543'
						})}else{
							return false
						}
				
			})
			
			
			
			
		//
			
		$(".imgnext").click(function(){
				var pos= $(".prints").position();
				console.log(pos.left)
				console.log($(".printsub").length-1)
				if(pos.left > -($(".printsub").length-1)*303 && !$(".prints").is(":animated")){
					$(".prints").animate({
							left:'-=303'
						})}else{
							return false
						}
				
			})
		$(".imgprev").click(function(){
				var pos= $(".prints").position();
				console.log(pos.left)
				console.log($(".printsub").length-1)
				if(pos.left < 0 && !$(".prints").is(":animated")){
					$(".prints").animate({
							left:'+=303'
						})}else{
							return false
						}
				
			})	
			
			
			$(".brand span").click(function(){
					$(this).next().show();
				});
			$(".brand").mouseleave(function(){
					$(".showdetail").hide();
				})
		
		
		
		
		///dtitle
		
		$(".dtitle span").click(function(){
				var n=$(this).index();
				$(this).addClass("cur").siblings().removeClass("cur");
				$(".dtxtcon").eq(n).show().siblings(".dtxtcon").hide();
			})
		
		
		//img5
		$(".img5").hover(function(){
					clearInterval(turnZp);
			},function(){
					turnZp = setInterval("scrollImg('.zuopins span[class=cur]','.zuopins span','.bigpic')",4000);
			})
		$(".img5l").click(function(){
			if(!$(".img5l").is(":animated") && !$(".img5r").is(":animated")){
					$(this).animate({width:0},1000).next().animate({width:691},1000);;
					$(this).parent(".img5").siblings(".img5").find(".img5r").css({width:0})
					$(this).parent(".img5").siblings(".img5").find(".img5l").css({width:0})
				}else{return false}
			});
		$(".img5r").click(function(){
			if(!$(".img5l").is(":animated") && !$(".img5r").is(":animated")){
				$(this).animate({width:0},1000).prev().animate({width:138},1000)
				$(this).parent(".img5").siblings().find(".img5l").animate({width:138},2000)
			}else{return false}
				
			})
	})

//店铺视角的分页--跳转到某一页

$(document).ready(function()
{
	$("#goto").click(function()
	{
		var len = 5;   //每页的数据数量
		var cur_page = $("#gpage").val();
		var reg = /^([1-9]*)$/;
		if(!reg.test(cur_page))
		{
			var msg = "请输入合法的数字！";
			alert(msg);
			return false;
		}
		var page = (cur_page-1)*len;
		var cat_id = $("#which").val();
		if(cat_id == 12)   //店铺视角的栏目ID
		{
			var url = "http://localhost/rising/index.php/trends/view/trends/5/" + cat_id + "/";  //跳转页面网址
		}
		else if(cat_id == 13)   //日先动态的栏目ID
		{
			var url = "http://localhost/rising/index.php/trends2/view/trends2/5/" + cat_id + "/";  //跳转页面网址
		}
		window.open(url +  page + "/" + cur_page,"_self");	//在原窗口打开新页面，此方法值得记录.window.open(url,"_self")
	})
})



