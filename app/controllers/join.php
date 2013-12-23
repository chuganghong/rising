<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Join extends CI_Controller {
	public function view($page = 'join')
    {      
		if ( ! file_exists('app/views/join/'.$page.'.php'))
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
		//var_dump($pagenav);exit;
		//var_dump($topic);exit;
		
		$cur = 3;    //在取出的top topic数组中，join栏目的key为0
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
		
		$data['cur2'] = $cur2;   //侧边栏目的选中状态
		
		$data['cur3'] = $cur3;   //区分是否有banner背景

		//内部培训
		$this->load->model('Pidea_model');
		$content1 = $this->Pidea_model->get_content();
		//var_dump($content1);
		
		//内部提升机制
		$content2 = $this->Pidea_model->get_content2();
		//var_dump($content2);
		
		//招聘职位
		$this->load->model('Job_model');
		$content3 = $this->Job_model->get_content();
		//var_dump($content3);exit;
		
		$url_detail1 = 'http://localhost/rising/index.php/join_detail/view/detail/4/18/';  //人才理念
		$url_detail2 = 'http://localhost/rising/index.php/join_detail/view/detail/4/19/';  //招聘职位

		$data['url_detail1'] = $url_detail1;   //人才理念文章详细页的URL
		$data['url_detail2'] = $url_detail2;   //招聘职位文章详细页的URL

		
		$data['content1'] = $content1;
		$data['content2'] = $content2;
		$data['content3'] = $content3;
		
		//新闻会客室
		$cat_id = 4; //加入我们
		$news = $this->Common_model->get_news($cat_id);
		$data['news'] = $news;
		
		$this->load->view('templates/header',$data);
		$this->load->view('templates/advertise',$data);    //ad
		$this->load->view('templates/pagenav',$data);    //nav
		$this->load->view('join/'.$page);
		$this->load->view('templates/footer');
	}	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */