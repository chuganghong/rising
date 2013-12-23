<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Trends2 extends CI_Controller {
	public function view($page = 'trends2')
    {      
		if ( ! file_exists('app/views/trends/'.$page.'.php'))
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
		
		$url_detail = 'http://127.0.0.1/rising/index.php/trends_detail/view/detail/5/13/';
		$data['url_detail'] = $url_detail;   //文章详细页的URL
		
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

		$this->load->model('Trends_model');	
		
		$sum = $this->Trends_model->get_total();   //总记录数
		
		$config['total_rows'] = $sum;		
		
		//分页
		$this->load->library('pagination');
		
		$config['next_link'] = '下一页';   //自定义“下一页”链接
		$config['prev_link'] = '上一页';   //自定义“上一页”链接
		
		$config['first_link'] = FALSE;   //自定义起始链接
		$config['last_link'] = FALSE;    //自定义结束链接		
		$config['uri_segment'] = 6;
		$config['num_links'] = 4;		
		$per_page = 5;   //每页的数据条数		
		$cur_page = $this->uri->segment(6, 0);	   //获取当前页面的页码--CI中的当前页码，非通常可见的当前页码			
		$cur_page2 = $this->uri->segment(7, 0);	   //获取当前页面的页码---用户输入的密码
		
		/**
		 *页码输入框中值的来自两种情况：（1）用户输入，从JS的URL传值而来（2）用户点击具体的页码链接，根据数据总量数除以
		 *每页数据量数计算得来。
		 *第二种情况下,$cur_page2的值为0，或者说，$cur_page2的值为0时，是第二种情况
		 */
		if($cur_page2 == 0)
		{
			$cur_page2 = $cur_page/$per_page + 1;    //根据具体情况而来
		}
		$data['cur_page2'] = intval($cur_page2);
		
		$url = 'http://127.0.0.1/rising/index.php/trends2/view/trends2/5/13/';		

		$config['base_url'] = $url;//'http://127.0.0.1/rising/index.php/trends/view/trends/5/12/';

		$config['per_page'] = $per_page;
		
		$length = $config['per_page'];		

		$this->pagination->initialize($config); 		
		$data['page'] = $this->pagination->create_links();//分页		
		
		$content = $this->Trends_model->get_content($cur_page,$length);	
		$data['content'] = $content;   //这页的主要数据
		
		
		/**
		 *http://127.0.0.1/rising/index.php/about/view/intro/1/6 URL中的第5个是侧边栏目的cat_id,第4个是一级栏目的cat_id
		 */
		$cur2 = $this->uri->segment(5, 0);	
		//var_dump($cur2);exit;
		
		$this->load->model('Trends2_model');		
		$cat_desc = $this->Trends2_model->get_desc($cur2);
		
		
		$data['cat_desc'] = $cat_desc[0]['cat_desc'];   //栏目简介
		
		$cat_id = 13;   //日先动态的栏目ID是13
		$data['which'] = $cat_id;
		
		//新闻会客室		
		$news = $this->Common_model->get_news($cat_id);
		$data['news'] = $news;
		
		$this->load->view('templates/header',$data);
		$this->load->view('templates/pagenav',$data);    //nav		
		$this->load->view('trends/'.$page);
		$this->load->view('templates/footer');
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */