<?php
//日先简介
class Intro_model extends CI_Model
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
		//$sql .= "ORDER BY sort_order DESC";
		//$sql .= ",cat_id ASC";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		//var_dump($data);exit;//test
		return $data;
	}
	
	//日先简介的内容从table sd_case_about中取得
	public function get_content($case_id)
	{
		$sql = "SELECT * FROM sd_case_about ";
		$sql .= "WHERE case_id=$case_id ";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		//var_dump($data);exit;//test
		return $data;
	}
  
}