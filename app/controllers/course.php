<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Course extends CI_Controller {
	public function view($page = 'course')
    {      
		if ( ! file_exists('app/views/about/'.$page.'.php'))
		{			
			// 页面不存在
			show_404();
		}
		$data['pre'] = $this->config->base_url();	
		
		$link = $this->Common_model->get_link();
		$topic = $this->Common_model->get_topics();
		//var_dump($topic);exit;
		$pagenav = $this->Common_model->get_pagenav();  //test		
		
		
		$data['link'] = $link;
		$data['topic'] = $topic;
		$data['pagenav'] = $pagenav;   //侧边栏目
		//var_dump($topic);exit;
		
		$cur = 0;    //在取出的top topic数组中，home栏目的key为0
		$data['cur'] = $cur;   //栏目的选中状态
		
		/**
		 *http://127.0.0.1/rising/index.php/about/view/intro/1/6 URL中的第5个是侧边栏目的cat_id,第4个是一级栏目的cat_id
		 */
		$cur2 = $this->uri->segment(5, 0);	
		
		$this->load->model('Intro_model');		
		$cat_desc = $this->Intro_model->get_desc($cur2);		
		
		$data['cat_desc'] = $cat_desc[0]['cat_desc'];   //栏目简介
		
		
		$cur3 = $cur2;
		if($cur2 == 0)    //当对应的部分不存在时$this->uri->segment(5, 0)返回值是0
		{
			$cur2 = $pagenav[2]['cat_id'];//Common_model.php中的get_pagenav()方法返回结果的第三个元素侧边栏目的第一个
		}
		//var_dump($cur2);exit;
		$data['cur2'] = $cur2;   //侧边栏目的选中状态
		
		$data['cur3'] = $cur3;   //区分是否有banner背景	
		
		
		//content
		$case_id = 2;   //在sd_case_about table中“日先简介“的ID是1
		$intro_content = $this->Intro_model->get_content($case_id);
		//var_dump($intro_content);exit;
		$data['intro_content'] = $intro_content[0]['content'];
		
		//picture
		$this->load->model('Course_model');		
		$pic = $this->Course_model->get_pic();
		$data['pic'] = $pic['img_src'];
		
		//other
		$other = $this->Course_model->get_other();
		//var_dump($other);exit;
		$data['other'] = $other;
		
  
		$this->load->view('templates/header',$data);
		$this->load->view('templates/advertise',$data);    //ad
		$this->load->view('templates/pagenav',$data);    //ad
		$this->load->view('about/'.$page);
		$this->load->view('templates/footer');
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */