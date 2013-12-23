<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Book extends CI_Controller {
	
		public function action()
		{
			/*
			$username = $_POST['username'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$job = $_POST['job'];
			$company = $_POST['company'];
			*/
			$res = $this->Common_model->book();
			if($res)
			{

				$msg = '提交成功';

			}
			else
			{
				$msg = '提交失败';
			}
				
			$js = "<script>alert('" . $msg . "');";
			//$js .= "</script>";
			$js .= "histroy.go(-2);</script>";
			
			echo $js;
			echo 2;exit;
		}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */