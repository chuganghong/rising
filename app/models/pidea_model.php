<?php
class Pidea_model extends CI_Model
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
	
	//内部培训的内容从table sd_case_join中取得
	public function get_content()
	{
		$cat_id = 20;   //内部培训   内部提升机制21
		$data1 = array();
		
		$cat_name = $this->get_cat_name($cat_id);
		$data1[] = $cat_name;
		
		$num = $this->get_total($cat_id);   //数据条数
		$num = $num - 1;   //减去上面的一篇。
		$data2 = array($num);
		
		$sql = "SELECT * FROM sd_case_join ";
		$sql .= "WHERE cat_id = $cat_id ";
		$sql .= "ORDER BY sort_order DESC ";
		$sql .= ",Case_id DESC ";		
		
		$query = $this->db->query($sql);
		$data3 = $query->result_array();
		
		$data = array_merge($data1,$data2,$data3);
		//var_dump($data);exit;//test
		return $data;
	}
	
	//内部提升机制，从table sd_case_join中取得
	public function get_content2()
	{
		$cat_id = 21; //内部提升机制21
		
		$data1 = array();		
		$cat_name = $this->get_cat_name($cat_id);
		$data1[] = $cat_name;		
		
		$limit = 5;   //只需要5条数据
		$sql = "SELECT * FROM sd_case_join ";
		$sql .= "WHERE cat_id = $cat_id ";
		$sql .= "ORDER BY sort_order DESC ";
		$sql .= ",Case_id DESC ";
		$sql .= "LIMIT $limit";		
		
		$query = $this->db->query($sql);
		$data2 = $query->result_array();
		
		$data = array_merge($data1,$data2);
		
		//$data = array_merge($data1,$data2,$data3);
		//var_dump($data);exit;//test
		return $data;
	}
	
	//人才理念的文章的数据总数
	public function get_total($cat_id)
	{		
		$sql = "SELECT COUNT(Case_id) AS num FROM sd_case_join ";
		$sql .= "WHERE cat_id = $cat_id ";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		//var_dump($data[0]);exit;//test
		return $data[0]['num'];
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