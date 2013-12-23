var ColorSelecter = new Object();

ColorSelecter.Show = function(sender)
{
  if(ColorSelecter.box)
  {
    if (ColorSelecter.box.style.display = "none")
      ColorSelecter.box.style.display = "";
  }
  else
  {
    ColorSelecter.box = document.createElement("Div");
    ColorSelecter.box.id = "ColorSelectertBox";
    
	var ColorHex=new Array('00','33','66','99','CC','FF')
	var SpColorHex=new Array('FF0000','00FF00','0000FF','FFFF00','00FFFF','FF00FF')
	var colorTable=""
	for (i=0;i<2;i++)
	 {
	  for (j=0;j<6;j++)
	   {
		colorTable=colorTable+'<tr height="15">'
	
		if (i==0){
		colorTable=colorTable+'<td width="15" bgcolor="#'+ColorHex[j]+ColorHex[j]+ColorHex[j]+'">'} 
		else{
		colorTable=colorTable+'<td width="15" bgcolor="#'+SpColorHex[j]+'">'} 
		for (k=0;k<3;k++)
		 {
		   for (l=0;l<6;l++)
		   {
			colorTable=colorTable+'<td width="15" bgcolor="#'+ColorHex[k+i*3]+ColorHex[l]+ColorHex[j]+'">'
		   }
		 }
	  }
	}
	colorTable="<table width='337' border='1' cellpadding='0' cellspacing='0' bordercolor='#BDBBBC' style='border:2px #C5D9FE solid'>"
			   +colorTable+'</table>';           


    ColorSelecter.box.innerHTML = colorTable;
    document.body.appendChild(ColorSelecter.box);
    var myTable = ColorSelecter.box.childNodes[0];
    for (var i = 0; i<myTable.rows.length; i++)
    {
      for (var j = 0; j < myTable.rows[i].cells.length; j++)
      {
        myTable.rows[i].cells[j].style.border = "#BDBBBC 1px solid";
        myTable.rows[i].cells[j].onmousemove = function()
        {
          this.style.border = "#fff 1px solid";
        }
        myTable.rows[i].cells[j].onmouseout = function()
        {
          this.style.border = "#BDBBBC 1px solid";
        }
        myTable.rows[i].cells[j].onmousedown = function()
        {
          document.getElementById("font_color").style.backgroundColor = this.bgColor;
          document.getElementById("goods_name_color").value = this.bgColor;
          document.getElementsByName("goods_name").item(0).style.color = this.bgColor;
          ColorSelecter.box.style.display = "none";
        }
      }
    }
  }

  var pos = getPosition(sender);
  
  ColorSelecter.box.style.top  = pos.top + 18 + "px";
  ColorSelecter.box.style.left = pos.left + "px";

  document.onmousedown = function()
  {
    ColorSelecter.box.style.display = "none";
  }

}
function getPosition(o)
{
    var t = o.offsetTop;
    var l = o.offsetLeft;
    while(o = o.offsetParent)
    {
        t += o.offsetTop;
        l += o.offsetLeft;
    }
    var pos = {top:t,left:l};
    return pos;
}
