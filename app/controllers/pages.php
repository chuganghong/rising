<?php
class Pages extends CI_Controller
{
	public function view($page='home')
	{
		if(!file_exists('application/views/pages/' . $page . '.php'))
		{
			//page not exist
			show_404();
		}
		
		$data['title'] = ucfirst($page);
		$data['time']= time();
		$data['about'] = 'call_user_func()';
		
		$this->load->view('templates/header',$data);
		$this->load->view('pages/' . $page,$data);
		$this->load->view('templates/footer',$data);
	}
}