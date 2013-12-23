<?php
class Brand_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	//合作品牌数据，从table sd_flash_works中取得
	public function get_content()
	{
		$cat_id = 14;   //合作品牌cat_id是14
		$limit = 10;     //选取10条
		$sql = "SELECT * FROM sd_flash_works ";
		$sql .= "WHERE 	cat_id = $cat_id ";
		$sql .= "ORDER BY flash_id ASC ";  //最新添加的显示在最前面，队列
		$sql .= "LIMIT $limit";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		//var_dump($data);exit;
		return $data;
	}  
}