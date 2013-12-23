<?php
//店铺视角
class Trends_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	
	//店铺视角的内容从table sd_case_trends中取得，要有分页
	public function get_content($page,$length)
	{
		$cat_id = 12;   //店铺视角的cat_id为12
		//$length = 5;    //每页显示数据条数为5条
		$start = $page;//$page - 1;
		//$start2 = $start * $length;
		$start2 = $start;
		$sql = "SELECT * FROM sd_case_trends ";
		$sql .= "WHERE cat_id=$cat_id ";
		$sql .= "LIMIT $start2,$length";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		//var_dump($data);exit;//test
		return $data;
	}
	
	//店铺视角的文章的数据总数
	public function get_total()
	{
		$cat_id = 12;//店铺视角的栏目ID为12
		$sql = "SELECT COUNT(case_id) AS num FROM sd_case_trends ";
		$sql .= "WHERE cat_id = $cat_id ";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		//var_dump($data[0]);exit;//test
		return $data[0]['num'];
	}
  
}