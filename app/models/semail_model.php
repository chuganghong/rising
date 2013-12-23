<?php
//发送邮件
class Semail_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}	
	
	//获取邮件发送配置
	public function get_email_config()
	{		
		$limit = 1;
		$sql = "SELECT * FROM sd_email_config ";		
		$sql .= "LIMIT $limit";		
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		//var_dump($data);//exit;//test
		return $data;
	}
	
	//获取收信人email
	public function to_email()
	{
		$limit = 200;
		$sql = "SELECT * FROM sd_users ";
		$sql .= "WHERE isbook = 1 ";   //isbook=1,订阅
		$sql .= "ORDER BY user_id ";
		$sql .= "LIMIT $limit";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		//var_dump($data);//exit;//test
		return $data;
	}
	
	//获取邮件内容
	public function get_email()
	{
		$limit = 10;   //邮件内容最多为10篇文章
		$sql = "SELECT * FROM sd_case_trends ";
		$sql .= "WHERE issend = 1 ";   //当issend为1时，将作为邮件内容
		$sql .= "ORDER BY sort_order DESC,";
		$sql .= "Case_id DESC ";
		$sql .= "LIMIT $limit";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		//var_dump($data);//exit;//test
		return $data;
		
	}
	
  
}