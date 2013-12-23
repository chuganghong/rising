<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Semail extends CI_Controller {
	public function send()
    {		
		$this->load->model('Semail_model');			
		
		$email_config = $this->Semail_model->get_email_config();
		//var_dump($email_config);exit;
		
		$receiver = $this->Semail_model->to_email();
		//var_dump($receiver);exit;
		
		$content = $this->Semail_model->get_email();
		
		$this->email($email_config,$receiver,$content);			
	}	
	
	
	//测试邮件发送
	public function email($email_config,$receiver,$content)
	{		
		$from = $email_config[0]['smtp_user'];
		
		//配置
		$config['protocol'] = $email_config[0]['protocol'];	
		$config['smtp_host'] =  $email_config[0]['smtp_host'];
		$config['smtp_user'] =  strstr($from,'@',true);
		//var_dump($config['smtp_user']);exit;
		$config['smtp_pass'] =  $email_config[0]['smtp_pass'];
		$config['smtp_port'] = $email_config[0]['smtp_port'];
		
		$title = $email_config[0]['title'];   //email title
		
		
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;		
		$config['mailtype'] = 'html';
		
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		
		//var_dump($config);exit;
		
		$list = array();		
		
		//receiver
		foreach($receiver as $v)
		{
			//
			$list[] = $v['email'];
		}
		
		//email content
		$message = <<<EOT
<html>
<body>
<style type="text/css">
	.shoplists {
		border-bottom: 1px solid #BBBBBB;
		height: 135px;
		overflow: hidden;
		width: 70%;
		font-size:12px;
	}
	.shoplists img {
		border: 1px solid #BBBBBB;
		float: left;
		margin: 16px 15px 0 0;
	}
	.shoplist_txt {
		margin-top: 16px;
	}
	.shoplist_txt p {
		overflow: hidden;
		color:#555;
	}
	.shoplist_txt p a {
		text-decoration:none;
		color: #333333;
		float: left;
		font-size: 14px;
		font-weight: bold;
		margin-bottom: 0px;
	}
	.shoplist_txt p i {
		float: right;
		font-style: normal;
		margin-bottom: 0px;
	}
</style>
<div class="shoplist">
EOT;
		
		//var_dump($content);exit;
		foreach($content as $v)
		{
			//
			$message .= $this->content($v);
		}
			
		$message .= '</div></body></html>';

		
		$res = $this->load->library('email');

		$this->email->initialize($config);

		//$this->email->from($email_config[0]['smtp_user'], $email_config[0]['smtp_user']);
		$this->email->from($from, $from);
		//$list = array('chuganghong@qq.com','chuganghong@163.com');  //test
		//$list = 'chuganghong@qq.com';
		//$this->email->to($list);
		if(empty($list))
		{
			$list[] = 'chuganghong@163.com';
		}		
		
		$this->email->bcc($list);
		$this->email->subject($title);
		
		$this->email->message($message);		
		
		if ( ! $this->email->send())
		{
			$msg = '发送失败！';	
		}
		else
		{
			$msg = '发送成功！';
			
		}
		echo $msg;
		
		//echo $this->email->print_debugger();
		exit;
	}
	
	
	//email content
	public function content($data)
	{
		/*
		//var_dump($data);exit;
		$pre = 'http://localhost/rising/';
		
		$html = "<div style='border-bottom: 1px solid #BBBBBB;height: 135px;overflow: hidden;width: 100%;'><p><img src=\"" . $pre . $data['g_pic'] . "\" />";
		$html .= "<p>" . $data['title'] . "</p>";
		$html .= "<p>" . $data['content_en'] . "</p>";
		*/
		
		$date = date('Y-m-d',$data['addtime']);
		$detail_url = "http://localhost/rising/index.php/trends_detail/view/detail/5/{$data['cat_id']}/{$data['Case_id']}";
		
		$num = 300;   //摘要字数
		$desc = mb_substr($data['content_en'],0,$num);
		
		
		$html = <<<EOT
<div class="shoplists">
                                    	<img src="http://localhost/rising/{$data['g_pic']}"/>
                                        <div class="shoplist_txt">
                                        	<p><a href="{$detail_url}" target="_blank">{$data['title']}</a><i>{$date}</i></p>
                                            <p>{$desc}&nbsp;&nbsp;&nbsp;</p>                                        
                                        </div>	
									</div>
EOT;
		
		return $html;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */