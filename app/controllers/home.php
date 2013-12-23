<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
		//$this->load->library('model');
	}
	 
	public function view($page = 'index')
    {      
		
		if ( ! file_exists('app/views/home/'.$page.'.php'))
		{			
			// 页面不存在
			show_404();
		}
		$data['pre'] = $this->config->base_url();
		
		
		
		
		$link = $this->Common_model->get_link();
		$topic = $this->Common_model->get_topics();
		
		$banner = $this->home_model->get_banner();
		$flags = $this->home_model->get_flags();
		//var_dump($flags);
		
		$data['link'] = $link;
		$data['topic'] = $topic;
		$data['banner'] = $banner;  //广告
		$data['flags'] = $flags;  //广告
		
		$cur = 0;    //在取出的top topic数组中，home栏目的key为0
		$data['cur'] = $cur;   //栏目的选中状态
		
		//首页 日先动态
		$itrends = $this->home_model->get_trends();
		$data['itrends'] = $itrends;   //首页 日先动态
		$url_detail_2 = 'http://localhost/rising/index.php/trends_detail/view/detail/5/13/';
		$data['url_detail_2'] = $url_detail_2;   //文章详细页的URL
		
		
		
		//首页 店铺视角
		$url_detail_1 = 'http://localhost/rising/index.php/trends_detail/view/detail/5/12/';
		$data['url_detail_1'] = $url_detail_1;   //文章详细页的URL
		$iview = $this->home_model->get_view();
		$data['iview'] = $iview;   
		
		
  
		$this->load->view('templates/header',$data);
		$this->load->view('home/'.$page);
		$this->load->view('templates/footer');
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */