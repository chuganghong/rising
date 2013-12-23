<?php
//日先简介
class About_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}	
	
	
	//关于我们的内容从table sd_case_about中取得
	public function get_content($cat_id)
	{
		$limit = 4;
		$sql = "SELECT * FROM sd_case_about ";
		$sql .= "WHERE cat_id = $cat_id ";
		$sql .= "ORDER BY sort_order DESC,";
		$sql .= "case_id DESC ";
		$sql .= "LIMIT $limit";		
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		//var_dump($data);exit;//test
		return $data;
	}
  
}