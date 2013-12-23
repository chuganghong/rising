// JavaScript Document
$(document).ready(function() {
	$(document).bind("contextmenu",function(e){
        return false;
    });
	$(document).bind("selectstart",function(e){
        return false;
    });
	$(document).bind("paste",function(e){
        e.preventDefault(); 
    });
	$(document).bind("copy",function(e){
        e.preventDefault();
    });
});