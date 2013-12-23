<?php
//日先足迹
class Course_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	/*使用了Intro_model class 中的方法，故此类中不需要这些方法
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
	
	//日先足迹的内容从table sd_case_about中取得
	public function get_content($case_id)
	{
		$sql = "SELECT * FROM sd_case_about ";
		$sql .= "WHERE case_id=$case_id ";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		//var_dump($data);exit;//test
		return $data;
	}
	*/
	
	//日先足迹图片
	public function get_pic()
	{
		$cat_id = 7;    //日先足迹的cat_id 是7
		$sql = "SELECT * FROM sd_flash_play ";
		$sql .= "WHERE cat_id = $cat_id ";
		$sql .= "LIMIT 1";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		//var_dump($data[0]);exit;//test
		return $data[0];
	}
	
	//日先足迹--其他
	public function get_other()
	{
		$limit = 10;    //最多显示10条
		$cat_id = 7;    //日先足迹的cat_id 是7
		$sql = "SELECT * FROM sd_case_about ";
		$sql .= "WHERE cat_id = $cat_id ";
		$sql .= "ORDER BY sort_order DESC,";
		$sql .= "case_id DESC ";
		$sql .= "LIMIT $limit";
		
		$query = $this->db->query($sql);
		$data2 = $query->result_array();	
		
		$num = count($data2);		
		
		$data = array($num,$data2);	
		
		return $data;		
		
	}
  
}