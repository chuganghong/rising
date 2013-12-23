<?php
/**
 * $p = new page();		    //建立新对像
 * $p->file="ttt.php";		//设置文件名，默认为当前页
 * $p->pvar="pagecount";	//设置页面传递的参数，默认为p
 * $p->setvar($_GET);	    //设置要传递的参数,要注意的是此函数必须要在 set 前使用，否则变量传不过去
 * $p->set(20,2000,1);		//设置相关参数，共三个，分别为'页面大小'、'总记录数'、'当前页(如果为空则自动读取GET变量)'
 * $p->output(0);			//输出,为0时直接输出,否则返回一个字符串
 * echo $p->limit();		//输出Limit子句。在sql语句中用法为 "SELECT * FROM TABLE LIMIT {$p->limit()}";
 *
 */

class page {
	var $info;
	var $output;
	var $file;
	var $pvar = "page";
	var $psize;
	var $curr;
	var $varstr;
    var $tpage;
    var $totalrows;
    var $ImagePath;
    function set($pagesize=20,$total,$current=false) {
		global $HTTP_SERVER_VARS,$HTTP_GET_VARS,$_LANG;
		$forpagesize=7;
		$this->tpage = ceil($total/$pagesize);
		if (!$current) {$current = $HTTP_GET_VARS[$this->pvar];}
		if ($current>$this->tpage) {$current = $this->tpage;}
		if ($current<1) {$current = 1;}

		$this->curr  = $current;
		$this->psize = $pagesize;
		$this->totalrows = $total;
		
		if (!$this->file) {$this->file = $HTTP_SERVER_VARS['PHP_SELF'];}
		if ($this->tpage > 1) {
            if ($current>1) {
				//$this->output.='<a href='.$this->file.'?'.$this->pvar.'=1'.($this->varstr).' title="第一页">第一页</a>';
				$this->output.='<a href='.$this->file.'?'.$this->pvar.'='.($current-1).($this->varstr).' title="上一页">上一页</a>';
			}
			/*
            if ($current==1) {
				$this->output.= '<span class="disabled">第一页</span>';
				$this->output.= '<span class="disabled">上一页</span>';
			}
			*/
		$start=$current-(ceil($forpagesize/2)-1);
		if($start<1) $start=1;
		$end=$start+($forpagesize-1);
		if($end>$this->tpage) $end=$this->tpage;
		if(($end-$start)<($forpagesize-1)) $start=$start-(($forpagesize-1)-($end-$start));
		if($start<1) $start=1;

		$line = ceil($forpagesize/2);

			if ($current - $line >= 1){
				$start = $start+1;
				$this->output.='<a href="'.$this->file.'?'.$this->pvar.'=1'.$this->varstr.'">1</a>';
				$this->output.='<span>...</span>';
			}
			if ($current + $line <= $this->tpage){
				$end = $end-1;
			}
            for ($i=$start; $i<=$end; $i++) {
                if ($current==$i) {
                    $this->output.='<span class="current">'.$i.'</span>';    //输出当前页数
                } else {
                    $this->output.='<a href="'.$this->file.'?'.$this->pvar.'='.$i.$this->varstr.'" class="pagenav">'.$i.'</a>&nbsp;';    //输出页数
                }
            }
			if ($current + $line <= $this->tpage){
				$this->output.='<span>...</span>';
				$this->output.='<a href="'.$this->file.'?'.$this->pvar.'='.$this->tpage.$this->varstr.'">'.$this->tpage.'</a>';
			}

            if ($current<$this->tpage) {
				$this->output.='<a href='.$this->file.'?'.$this->pvar.'='.($current+1).($this->varstr).' title="下一页">下一页</a>';
				//$this->output.='<a href='.$this->file.'?'.$this->pvar.'='.$this->tpage.($this->varstr).' title="最末页">最末页</a>';
			}
			/*
            if ($current==$this->tpage) {
				$this->output.= '<span class="disabled">下一页</span>';
				$this->output.= '<span class="disabled">最末页</span>';
			}
			*/
		}
	}

	function setvar($data) {
		foreach ($data as $k=>$v) {
			if($k != $this->pvar)
			$this->varstr.='&amp;'.$k.'='.urlencode($v);
		}
	}
	function setImgPath($path){
		$this->ImagePath = $path;
	}
	function output($return = false) {
/*		
		if($this->totalrows){
			$this->output.="<div class='text'><span>共<b class=\"blue\">$this->totalrows</b>条记录，共<b class=\"blue\">$this->tpage</b>页，每页显示<b class=\"blue\">$this->psize</b>条</span></div>";
		}else{
			$this->output.="<div class='text'><span>当前条件下没有数据 <a href=\"javascript:history.back(-1);\" class=\"blue\">[返回]</a></span></div>";
		}
*/		
		return $this->output;
	}

    function limit() {
		return (sprintf("%d,%d",($this->curr-1)*$this->psize,$this->psize));
	}

} //End Class
?>