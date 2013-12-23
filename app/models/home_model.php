<?php
class Home_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	//首页banner
	public function get_banner()
	{
		$img_type = 1;   //首页banner的img_type是1
		$limit = 1;     //选取1条
		$sql = "SELECT * FROM sd_flash_play ";
		$sql .= "WHERE 	img_type = $img_type ";
		$sql .= "ORDER BY img_sort DESC,flash_id DESC ";  //默认按后来增加的排在前面，其次按序号降序排列
		$sql .= "LIMIT $limit";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		//var_dump($data[0]);exit;
		return $data[0];
	}
	
	//首页flags
	public function get_flags()
	{
		$img_type = 0;   //首页flag的img_type是0
		$limit = 5;     //选取5条
		$cat_id = 0;    //首页幻灯片的cat_id=0
		$sql = "SELECT * FROM sd_flash_play ";
		$sql .= "WHERE img_type = $img_type ";
		$sql .= "AND cat_id = $cat_id ";
		$sql .= "ORDER BY img_sort DESC,flash_id DESC ";  //默认按后来增加的排在前面，其次按序号降序排列
		$sql .= "LIMIT $limit";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		//var_dump($data);exit;
		return $data;
	}
	
	//首页 日先动态 从table sd_case_trends中取得
	public function get_trends()
	{
		$limit = 40;
		$cat_id = 13;//日先动态;
		$sql = "SELECT * FROM sd_case_trends ";
		$sql .= "WHERE cat_id = $cat_id ";
		$sql .= "ORDER BY sort_order DESC,";
		$sql .= "case_id DESC ";
		$sql .= "LIMIT $limit ";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		
		//$num = count($data);
		//var_dump($num);exit;
		//var_dump($data);exit;
		$data = $this->del_data($data);
		$num = count($data);
		$data2 = array($num,$data);
		return $data2;
	}
	
	//处理get_trends的数据，使其满足前端需要
	public function del_data($data)
	{
		$num = 4;
		foreach($data as $k=>$v)
		{
			if( ($k+1)%$num == 0)
			{
				$data2[] = $data1;
				$data1 = array();
			}
			$data1[] = $v;			
		}
		$data2[] = $data1;
		//var_dump($data2);exit;
		return $data2;
	}
	
	//首页 店铺视角
	public function get_view()
	{
		$limit = 1;
		$cat_id = 12;   //店铺视角
		$sql = "SELECT * FROM sd_case_trends ";
		$sql .= "WHERE cat_id = $cat_id ";
		$sql .= "ORDER BY sort_order DESC,";
		$sql .= "case_id DESC ";
		$sql .= "LIMIT $limit ";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		//var_dump($data);exit;
		return $data[0];
	}
  
}