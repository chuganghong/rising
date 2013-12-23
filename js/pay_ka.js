$(document).ready(function() {
 $("#pay_ka").validate({
        rules: {
   username: {
    required: true,
    minlength: 4
   },
   confirm_username: {
    required: true,
    minlength: 4,
    equalTo: "#username"
   },
   kahao: {
    required: true,
    minlength: 6
   },
   kahao_pwd: {
    required: true,
    minlength: 6
   }
  },
        messages: {
   username: {
    required: "请输入充值账号",
    minlength: "充值账号不能小于4个字符"
   },
   confirm_username: {
    required: "请输入确认充值账号",
    minlength: "充值账号不能小于4个字符",
    equalTo: "两次充值账号不一致！"
   },
   kahao: {
    required: "请输入您的充值卡卡号",
    minlength: "充值卡卡号不能小于6个字符"
   },
   kahao_pwd: {
    required: "请输入您的充值卡卡号密码",
	minlength: "充值卡卡号密码为能小于6个字符"
   }
   
  }
    });

 $("#pay_phone").validate({
        rules: {
   username: {
    required: true,
    minlength: 4
   },
   confirm_username: {
    required: true,
    minlength: 4,
    equalTo: "#username"
   },
   woyaochong: {
    required: true
   },
   phone: {
    required: true,
	number: true,
    minlength: 11
   }
  },
        messages: {
   username: {
    required: "请输入充值账号",
    minlength: "充值账号不能小于4个字符"
   },
   confirm_username: {
    required: "请输入确认充值账号",
    minlength: "充值账号不能小于4个字符",
    equalTo: "两次充值账号不一致！"
   },
   woyaochong: {
    required: "请输入"
   },
   phone: {
    required: "请输入您的手机号码",
	number: "请输入有效的手机号码",
	minlength: "手机号码不能小于11个字符"
   }
   
  }
    });



 $("#pay_gouka").validate({
        rules: {
   amount: {
    required: true,
	number: true
   },
   username: {
    required: true,
    minlength: 4
   },
   confirm_username: {
    required: true,
    minlength: 4,
    equalTo: "#username"
   }
  },
        messages: {
   amount: {
    required: "请输入充值金额",
	number: "请输入有效的金额"
   },
   username: {
    required: "请输入充值账号",
    minlength: "充值账号不能小于4个字符"
   },
   confirm_username: {
    required: "请输入确认充值账号",
    minlength: "充值账号不能小于4个字符",
    equalTo: "两次充值账号不一致！"
   }
    

  }
    });
	

 $("#pay_online").validate({
        rules: {
   username: {
    required: true,
    minlength: 4,
	remote: "paypay.php?act=cuid"
   },
   confirm_username: {
    required: true,
    minlength: 4,
    equalTo: "#username"
   },
   paymoney: {
	required: true,
    digits: true
   },
   captcha: {
    required: true,
    remote: "paypay.php?act=check_password"
   }
  },
        messages: {
   username: {
    required: "请输入充值账号",
    minlength: "充值账号不能小于4个字符",
	remote: "没有此用户"
   },
   confirm_username: {
    required: "请输入确认充值账号",
    minlength: "充值账号不能小于4个字符",
    equalTo: "两次充值账号不一致！"
   },
   paymoney: {
	required: "请输入充值金额",
    digits: "请输入整数"
   },
   captcha: {
    required: "请输入验证码",
	remote: "验证码不正确"
   }
   
  }
    });
	
 $("#reg").validate({
        rules: {
   username: {
    required: true,
    minlength: 4,
	remote: "member.php?act=cuid"
   },
   password: {
    required: true,
    minlength: 6
   },
   old_password: {
    required: true,
    minlength: 6
   },
   new_password: {
    required: true,
    minlength: 6
   },
   confirm_password: {
    required: true,
    minlength: 6,
    equalTo: "#password"
   },
   realname: {
    required: true,
	minlength: 2
   },
   idcards: {
    required: true,
	number: true,
	remote: "member.php?act=idcard"
   },
   email: {
    required: true,
    email: true
   },
    new_email: {
    required: true,
    email: true
   },
   phone: {
    required: true,
	number: true,
    minlength: 11
   },
   agree: "required"
  },
        messages: {
   username: {
    required: "请输入通行证账号",
    minlength: "通行证账号不能小于6个字符",
	remote: "用户名已经使用"
   },
   password: {
    required: "输入您的通行证密码",
    minlength: "通行证密码不能小于6个字符"
   },
   old_password: {
    required: "输入您的通行证密码",
    minlength: "通行证密码不能小于6个字符"
   },
   new_password: {
    required: "输入您的通行证密码",
    minlength: "通行证密码不能小于6个字符"
   },
   confirm_password: {
    required: "请输入确认密码",
    minlength: "确认密码不能小于6个字符",
    equalTo: "两次密码不一致！"
   },
   
   realname: {
    required: "输入您的真实姓名",
	minlength: "真实姓名不能小于2个字符"
   },
   idcards: {
    required: "输入您的身份证号码",
	number: "请输入有效身份证号码",
	remote: "身份证错误"
   },
   email: {
    required: "输入您的邮箱地址",
    email: "请输入正确的邮箱地址"
   },
   
   phone: {
    required: "请输入您的手机号码",
	number: "请输入有效的手机号码",
	minlength: "手机号码不能小于11个字符"
   },
   agree: "请接受服务条款"
  }
    });

 $("#reg").validate({
        rules: {
   username: {
    required: true,
    minlength: 4
   },
   password: {
    required: true,
    minlength: 6
   },
   confirm_password: {
    required: true,
    minlength: 6,
    equalTo: "#password"
   },
   realname: {
    required: true,
	minlength: 4
   },
   idcards: {
    required: true,
	number: true
   },
   email: {
    required: true,
    email: true
   },
   phone: {
    required: true,
	number: true,
    minlength: 11
   },
   agree: "required"
  },
        messages: {
   username: {
    required: "请输入充值账号",
    minlength: "充值账号不能小于6个字符"
   },
   password: {
    required: "输入您的通行证密码",
    minlength: "通行证密码不能小于6个字符"
   },
   confirm_password: {
    required: "请输入确认密码",
    minlength: "通行证密码不能小于6个字符",
    equalTo: "两次密码不一致！"
   },
   
   realname: {
    required: "输入您的真实姓名",
	minlength: "真实姓名不能小于4个字符"
   },
   idcards: {
    required: "输入您的身份证号码",
	number: "请输入有效身份证号码"
   },
   email: {
    required: "输入您的邮箱地址",
    email: "请输入正确的邮箱地址"
   },
   phone: {
    required: "请输入您的手机号码",
	number: "请输入有效的手机号码",
	minlength: "手机号码不能小于11个字符"
   },
   agree: "请接受服务条款"
  }
    });
	
//修改密码
	$("#editpwd").validate({
        rules: {
   username: {
    required: true,
    minlength: 4
   },
   password: {
    required: true,
    minlength: 6
   },
   new_password: {
    required: true,
    minlength: 6
   },
   
   confirm_new_password: {
    required: true,
    minlength: 6,
    equalTo: "#new_password"
   },
   idcards: {
    required: true,
	number: true
   }
  
  },
      messages: {
   username: {
    required: "请输入充值账号",
    minlength: "充值账号不能小于6个字符"
   },
   password: {
    required: "输入您的当前密码",
    minlength: "通行证密码不能小于6个字符"
   },
   new_password: {
    required: "请输入您的新密码",
    minlength: "通行证密码不能小于6个字符"
   },
   confirm_new_password: {
    required: "请输入确认密码",
    minlength: "通行证密码不能小于6个字符",
    equalTo: "两次密码不一致！"
   },
   idcards: {
    required: "输入您的身份证号码",
	number: "请输入有效身份证号码"
   }
  }
    });
	
//修改邮箱
	$("#editemail").validate({
        rules: {
   username: {
    required: true,
    minlength: 4
   },
   password: {
    required: true,
    minlength: 6
   },
   idcards: {
    required: true,
	number: true,
	remote: "member.php?act=idcard"
   },
   new_email: {
    required: true,
    email: true
   }
  
  },
      messages: {
   username: {
    required: "请输入充值账号",
    minlength: "充值账号不能小于6个字符"
   },
   password: {
    required: "输入您的当前密码",
    minlength: "通行证密码不能小于6个字符"
   },
   idcards: {
    required: "输入您的身份证号码",
	number: "请输入有效身份证号码",
	remote: "身份证错误"
   },
   new_email: {
    required: "请输入您的新邮箱",
    email: "请输入正确的邮箱"
   }
  
  }
    });
	//修改邮箱
	$("#forgetpwd").validate({
        rules: {
   username: {
    required: true,
    minlength: 4
   },
   email: {
    required: true,
    email: true
   }
  
  },
      messages: {
   username: {
    required: "请输通行证帐号",
    minlength: "账号不小于6个字符"
   },
   email: {
    required: "请输入您的邮箱",
    email: "请输入正确的邮箱"
   }
  
  }
    });
	
	
	
});
//messages处，如果某个控件没有message，将调用默认的信息