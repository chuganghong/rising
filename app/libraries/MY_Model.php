<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_Model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
  
  
  //产品服务中心等链接
	public function get_link()
	{
		 $query = $this->db->get('link');
		 return $query->result_array();
	}
	
	//关于我们等栏目
	public function get_topic()
	{
	}
}