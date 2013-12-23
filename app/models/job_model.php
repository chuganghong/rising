<?php
//招聘职位
class Job_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	//栏目说明
	public function get_desc($cat_id)
	{
		$sql = "SELECT * FROM sd_case_cat ";
		$sql .= "WHERE cat_id=$cat_id ";
		$sql .= "LIMIT 1";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		
		return $data;
	}
	
	//招聘职位的内容从table sd_case_join中取得
	public function get_content()
	{
		$cat_id = 19;   //招聘职位 19
		$data1 = array();
		
		$cat_name = $this->get_cat_name($cat_id);
		$data1[] = $cat_name;		
		
		$sql = "SELECT * FROM sd_case_join ";
		$sql .= "WHERE cat_id = $cat_id ";
		$sql .= "ORDER BY sort_order DESC ";
		$sql .= ",Case_id DESC ";		
		
		$query = $this->db->query($sql);
		$data2 = $query->result_array();
		
		$data = array_merge($data1,$data2);
		//var_dump($data);exit;//test
		return $data;
	}
	
	
	
	/**
	 *获取栏目名
	 */
	public function get_cat_name($cat_id)
	{
		$sql = "SELECT cat_name FROM sd_case_cat ";
		$sql .= "WHERE cat_id = $cat_id ";
		$sql .= "LIMIT 1";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		
		$cat_name = $data[0]['cat_name'];		
		return $cat_name;		
	}
}