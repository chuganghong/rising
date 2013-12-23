<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cases extends CI_Controller {
	public function view($page = 'cases')
    {      
		if ( ! file_exists('app/views/works/'.$page.'.php'))
		{			
			// 页面不存在
			show_404();
		}
		$data['pre'] = $this->config->base_url();
		
		$link = $this->Common_model->get_link();
		$topic = $this->Common_model->get_topics();
		$pagenav = $this->Common_model->get_pagenav();  //test		
		$data['link'] = $link;
		$data['topic'] = $topic;
		$data['pagenav'] = $pagenav;   //侧边栏目
		//var_dump($pagenav);//exit;
		
		$cur = 1;    //在取出的top topic数组中，join栏目的key为0
		$data['cur'] = $cur;   //栏目的选中状态
		
		/**
		 *http://127.0.0.1/rising/index.php/about/view/intro/1/6 URL中的第5个是侧边栏目的cat_id,第4个是一级栏目的cat_id
		 */
		$cur2 = $this->uri->segment(5, 0);	
		//var_dump($cur2);//test
		
		if($cur2 == 0)    //当对应的部分不存在时$this->uri->segment(5, 0)返回值是0
		{
			$cur2 = $pagenav[2]['cat_id'];//Common_model.php中的get_pagenav()方法返回结果的第三个元素侧边栏目的第一个
		}
		//var_dump($cur2);exit;
		$data['cur2'] = $cur2;   //侧边栏目的选中状态
		
		$cur3 = 0;   //显示广告
		$data['cur3'] = $cur3;   //区分是否有banner背景	
		
		//经典案例数据
		$this->load->model('Cases_model');	
		$cases = $this->Cases_model->get_content();		
		$data['cases'] = $cases;
  
		$this->load->view('templates/header',$data);
		$this->load->view('templates/advertise',$data);    //ad
		$this->load->view('templates/pagenav',$data);    //nav
		$this->load->view('works/'.$page);
		$this->load->view('templates/footer');
	}	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */