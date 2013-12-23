// JavaScript Document
function showroll(a)
{
	var html = '';
	$.ajax({
		type:"POST",	   
		url :a+"getRoll.php",
		data:"",
		dataType:"JSON",
		success: function(data,textStatus){
			data = eval(data);
			
			$.each(data, function(index,txt){
			html+='<marquee  scrollamount="3">'+txt['talk']+'</marquee>';
			$("#main1_mid").html(html);
		});
		}
	});
	setTimeout("showroll()",15000);
}

