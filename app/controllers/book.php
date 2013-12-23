<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Book extends CI_Controller {
	
		public function action()
		{			
			$res = $this->Common_model->book();
			if($res)
			{

				$msg = '提交成功，返回首页。';

			}
			else
			{
				$msg = '提交失败，返回首页。';
			}
			Header('Content-Type:text/html;charset=utf-8');
				
			$js = "<script>alert('" . $msg . "');";
			
			$js .= "window.open('http://localhost/rising','_self');</script>";
			//$url = 'http://localhost/rising';
			echo $js;			
			exit;
		}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */