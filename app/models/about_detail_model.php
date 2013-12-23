<?php
class About_detail_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}	
	
	//详细页的内容从table sd_case_about中取得
	public function get_content($case_id)
	{	
		$sql = "SELECT * FROM sd_case_about ";
		$sql .= "WHERE Case_id = $case_id ";
		$sql .= "LIMIT 1";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();	
		//var_dump($data);exit;
		return $data[0];
	}
}