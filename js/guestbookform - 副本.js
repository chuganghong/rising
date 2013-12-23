$(document).ready(function() {
 $("#form1").validate({
        rules: {
   username: {
    required: true,
    minlength: 4
   },
   email: {
    required: true,
    email: true
   },
   password: {
    required: true,
    minlength: 5
   },
   confirm_password: {
    required: true,
    minlength: 5,
    equalTo: "#password"
   },
   phone: {
    required: true,
	number: true,
    minlength: 11
   },
   url: {
    required: true,
	url: true
   },
   content: {
    required: true,
	minlength: 10
   }
  },
        messages: {
   username: {
    required: "请输入姓名",
    minlength: "姓名不能小于4个字符"
   },
   email: {
    required: "请输入Email地址",
    email: "请输入正确的email地址"
   },
   password: {
    required: "请输入密码",
    minlength: jQuery.format("密码不能小于{0}个字符")
   },
   confirm_password: {
    required: "请输入确认密码",
    minlength: "确认密码不能小于5个字符",
    equalTo: "两次输入密码不一致不一致"
   },
   phone: {
    required: "请输入手机号",
	number: "请输入有效的手机号",
    minlength: "确认密码不能小于11个字符"
   },
   url: {
    required: "请输入网址",
	url: "请输入正确的网址<font color=red>http://</font>"
   },
   content: {
    required: "请输入留言内容",
	minlength: "留言内容不能小于10个字符"
   }
   
  }
    });
});
//messages处，如果某个控件没有message，将调用默认的信息