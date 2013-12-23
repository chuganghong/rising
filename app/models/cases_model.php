<?php
class Cases_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	//经典案例数据，从table 
	public function get_content()
	{
		$cat_ids = $this->get_cat_id();	
		$num = count($cat_ids);
		$data = array();
		$data[] = $num;
		foreach($cat_ids as $v)
		{
			$cat_id = $v['cat_id'];
			$data[] = $this->get_pics($cat_id);
		}	
		
		return $data;
	}
	
	//获取经典案例图集cat_id数据
	public function get_cat_id()
	{
		$sql = "SELECT cat_id ";
		$sql .= "FROM sd_brand_album";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}
	
	//获取经典案例一个图集下的所有图片数据
	public function get_pics($cat_id)
	{
		$sql = "SELECT * FROM sd_brand ";
		$sql .= "WHERE cat_id = $cat_id";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();		
		return $data;
	}
	
  
}