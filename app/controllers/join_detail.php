<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Join_Detail extends CI_Controller {
	public function view($page = 'detail')
    {      
		if ( ! file_exists('app/views/templates/'.$page.'.php'))
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
		
		$cur = 4;    //在取出的top topic数组中，trends栏目的key为0
		$data['cur'] = $cur;   //栏目的选中状态
		
		/**
		 *http://127.0.0.1/rising/index.php/about/view/intro/1/6 URL中的第5个是侧边栏目的cat_id,第4个是一级栏目的cat_id
		 */
		$cur2 = $this->uri->segment(5, 0);	
		$cur3 = $cur2;		
		if($cur2 == 0)    //当对应的部分不存在时$this->uri->segment(5, 0)返回值是0
		{
			$cur2 = $pagenav[2]['cat_id'];//Common_model.php中的get_pagenav()方法返回结果的第三个元素侧边栏目的第一个
		}
		//var_dump($cur2);exit;
		$data['cur2'] = $cur2;   //侧边栏目的选中状态
		
		$data['cur3'] = $cur3;   //区分是否有banner背景	

		$this->load->model('Join_detail_model');		
		
		/**
		 *详细页的URL形如http://127.0.0.1/rising/index.php/trends_detail/view/detail/5/12/1
		 *1为case_id
		 */
		
		$case_id = $cur2 = $this->uri->segment(6, 0);	
		
		$content = $this->Join_detail_model->get_content($case_id);   //文章数据	
		
		$data['content'] = $content;   //这页的主要数据		
		
		$this->load->view('templates/header',$data);
		$this->load->view('templates/pagenav',$data);    //nav
		$this->load->view('templates/'.$page);
		$this->load->view('templates/footer');
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */