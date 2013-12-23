<?php
/**
 *目录类
 *@modify:增加了showLink()方法，选取链接式的栏目
 *@modify:修改showCategory()方法，只选取非链接式的栏目
 *@date:2013/12/06 10:01
 */

if (!defined('IN_LK'))
{
    die('Hacking attempt');
}

class category
{
	protected $category;   //下拉菜单返回的值
	protected $cat;        //列表返回的值
	protected $i = 0;
	protected $medialoca='';
	
	public function __construct($table)
	{
		$this->category = '';
		$this->cat      = '';
		$this->table    = $table;
		$this->other    = array();
	}
	/**
	 * 无限级菜单
	 * @public
	 * @param   integer            分类编号(0为一级目录)
	 * @param   integer            当前下拉菜单选择的栏目ID
	 */	
	function toSelect($child = 0,$selid = 0 ,$level = 0 )
	{
		$sql    = "select * from " .$this->table. " where parent_id = $child ";
		$result = $GLOBALS['db']->query($sql);

		while ($row = $GLOBALS['db']->fetch_array($result))
		{
			if($row['cat_id'] == $selid)
			{
				$this->category .= '<option selected value='.$row['cat_id'];
			}else{
				$this->category .= '<option value='.$row['cat_id'];
			}
			
			if ($level > 0)
			{
				$this->category .= ">" . str_repeat( "&nbsp;&nbsp;&nbsp;&nbsp;", $level ) . " " . $row['cat_name'] . "(".$row['cat_name_en'].")</option>\n";
			}
			else
			{
				$this->category .= ">" . $row['cat_name'] . "(".$row['cat_name_en'].")</option>\n";
			}
			$this->toSelect($row['cat_id'], $selid, $level + 1, $tables);
		}
		return $this->category;
	}
	
	function showCategory($child = 0,$level=0,$other=array())
	{
		$this->other=$other;		
		$sql    = "select * from " .$this->table;
		$sql .= " where parent_id = $child ";
		$sql .="order by sort_order DESC, cat_id";		
		$result = $GLOBALS['db']->query($sql);
		while ($row = $GLOBALS['db']->fetch_array($result))
		{
			$this->cat[$this->i]['cat_id']       .= $row['cat_id'];
			$this->cat[$this->i]['cat_name']     .= $row['cat_name'];
			$this->cat[$this->i]['cat_name_tw']  .= $row['cat_name_tw'];
			$this->cat[$this->i]['cat_name_en']  .= $row['cat_name_en'];
			$this->cat[$this->i]['parent_id']    .= $row['parent_id'];
			$this->cat[$this->i]['sort_order']   .= $row['sort_order'];
			$this->cat[$this->i]['show_in_nav']  .= $row['show_in_nav'];
			$this->cat[$this->i]['keywords']     .= $row['keywords'];
			$this->cat[$this->i]['cat_desc']     .= $row['cat_desc'];
			$this->cat[$this->i]['level']        .= $level;
			foreach($this->other as $val)
			{
				$this->cat[$this->i][$val]     .= $row[$val];
			}
			$this->i++;
			$this->showCategory($row['cat_id'], $level + 1,$this->other);
		}
		return $this->cat;
	}
	
	//选取所有的link
	function showLink()
	{
		$tid = 1;   //link的tid是1
		$sql    = "select * from " .$this->table. " where tid = $tid order by sort_order DESC, cat_id";		
		$result = $GLOBALS['db']->query($sql);
		while($row = mysql_fetch_assoc($result))
		{
			$this->cat[] = $row;
		}
		return $this->cat;
	}
	/* 递归分类 */
	function recursive($cat_id)
	{
		$sql    = "select * from " .$this->table. " where parent_id = '$cat_id' ";
		$result = $GLOBALS['db']->query($sql);

		while ($row = $GLOBALS['db']->fetch_array($result))
		{
			
			if($this->i==0)
			{
				$this->medialoca .= '';
				$this->medialoca .= $cat_id.",";
			}else
			{
				$this->medialoca .= ',';
			}
			
			$this->medialoca .= $row['cat_id'];
			//$this->medialoca_id=$row['cat_id'];
			$this->i++;
				
			$this->recursive($row['cat_id']);
		}
		if($this->medialoca=='')
		{
			$this->medialoca="$cat_id";
		}
		return $this->medialoca;
	}

}
?>