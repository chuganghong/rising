<?php
class Common_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
  
  
  //产品服务中心等链接
	public function get_link()
	{
		 $sql = "SELECT * FROM sd_link ";
		 $sql .= "ORDER BY sort_order DESC,cat_id";
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}
	
	//关于我们等一级栏目
	public function get_ftopic()
	{
		$this->get_topics();
		$parent_id = 0;   //一级栏目的parent_id = 0;
		$sql = "SELECT * FROM sd_case_cat ";
		$sql .= "WHERE parent_id = $parent_id ";
		$sql .= "ORDER BY sort_order DESC,cat_id";
		$query = $this->db->query($sql);
		$data = $query->result_array();		
		return $data;
	}
	
	//关于我们的下级栏目
	public function get_stopic($parent_id)
	{
		
	}
	
	//获得栏目
	public function get_topic($parent_id)
	{
		$sql = "SELECT * FROM sd_case_cat ";
		$sql .= "WHERE parent_id = $parent_id ";
		$sql .= "ORDER BY sort_order DESC,cat_id";
		$query = $this->db->query($sql);
		$data = $query->result_array();			
		return $data;
	}
	
	//获得前端所需的栏目数据
	public function get_topics()
	{
		$data = array();
		$parent_id = 0;
		$ftopic = $this->get_topic($parent_id);		
		foreach($ftopic as $v)
		{			
			$arr = array();
			$parent_id2 = $v['cat_id'];
			$stopic = $this->get_topic($parent_id2);
			$arr[] = $v;
			$arr[] = $stopic;
			$res[] = $arr;			
		}		
		return $res;
	}
	
	//获得侧边栏目的数据
	public function get_pagenav()
	{
		$parent_id = $this->uri->segment(4, 0);			
		$sql1 = "SELECT * FROM sd_case_cat ";
		$sql1 .= "WHERE cat_id = $parent_id ";
		$sql1 .= "LIMIT 1";
		$query1 = $this->db->query($sql1);
		$topic1 = $query1->result_array();
		
		$sql2 = "SELECT * FROM sd_case_cat ";
		$sql2 .= "WHERE parent_id = $parent_id ";
		$sql2 .= "ORDER BY sort_order DESC,cat_id asc";
		$query2 = $this->db->query($sql2);
		$topic2 = $query2->result_array();			
	
		$data = array_merge($topic1,$topic2);
		return $data;		
	}
	
	//新闻会客室
	public function get_news($cat_id)
	{
		$limit = 2;
		$sql = "SELECT * FROM sd_news_link ";
		$sql .= "WHERE parent_id = $cat_id ";
		$sql .= "ORDER BY sort_order DESC,";
		$sql .= "cat_id DESC ";
		$sql .= "LIMIT $limit ";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();			
		return $data;		
	}
	
	//订阅
	public function book()
	{
		/*先弃用
		$username = $data['username'];
		$email = $data['email'];
		$phone = $data['phone'];
		$job = $data['job'];
		$company = $data['company'];
		
		$sql = "INSERT INTO sd_user ";
		*/
		
		//$this->load->helper('url');
  
		//$slug = url_title($this->input->post('title'), 'dash', TRUE);
  
		$data = array(
			'user_name' => $this->input->post('username'),
			'company' => $this->input->post('company'),
			'job' => $this->input->post('job'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'add_time'=>time(),
		);
		//var_dump($data);exit;
		//return $data;exit;
		$res = $this->db->insert('sd_users', $data);
		//var_dump($res);exit;
		return $res;		
	}
}