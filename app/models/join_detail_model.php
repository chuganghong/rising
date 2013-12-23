<?php
class Join_detail_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	
	//详细页的内容从table sd_case_join中取得
	public function get_content($case_id)
	{	
		$sql = "SELECT * FROM sd_case_join ";
		$sql .= "WHERE Case_id = $case_id ";
		$sql .= "LIMIT 1";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();		
		return $data[0];
	}
}