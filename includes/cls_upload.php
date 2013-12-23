<?php
class cls_upload
{
    var $error_msg   = '';
    var $data_dir    = DATA_DIR; //文件保存路径
	var $ext;
	var $fileFormat  = array('ZIP','RAR');  /* 允许上传的文件类型 */
	var $maxsize = '20971520'; // 20M
	
	function __construct($upload_allowext = array(), $upload_maxsize = '')
    {
		if ($upload_allowext) 
		{
			$this->fileFormat = $upload_allowext;
		}else{
			$this->fileFormat = $fileFormat;
		}
		if ($upload_maxsize)
		{
			$this->maxsize = $upload_maxsize;
		}else{
			$this->maxsize = $maxsize;
		}
    }
	
	/**
     * 文件上传的处理函数
     *
     * @access      public
     * @param       array       upload       包含上传的文件文件信息的数组
     * @param       array       dir          文件要上传在dir下的目录名。如果为空文件放在则在$this->data_dir下以当月命名的目录下
     * @param       array       file_name    上传文件名称，为空则随机生成
     * @return      mix         如果成功则返回文件名，否则返回false
     */
	function upload_file($upload, $dir = '', $file_name = '')
    {
        /* 没有指定目录默认为根目录images */
        if (empty($dir))
        {
            /* 创建当月目录 */
            $dir = date('Ym');
            $dir = ROOT_PATH . $this->data_dir . '/' . $dir . '/';
        }
        else
        {
            /* 创建目录 */
            $dir = ROOT_PATH . $dir . '/' . date('Ym') . '/';
            if ($file_name)
            {
                $file_name = $dir . $file_name; // 将文件定位到正确地址
            }
        }

        /* 如果目标目录不存在，则创建它 */
        if (!file_exists($dir))
        {
            if (!$this->make_dir($dir))
            {
                /* 创建目录失败 */
                $this->error_msg = sprintf('目录 % 不存在或不可写', $dir);

                return false;
            }
        }

		$this->ext = $this->get_filetype($upload['name']);
		
        if (empty($file_name))
        {
            $file_name = $this->unique_name($dir); //生成指定目录不重名的文件名
            $file_name = $dir . $file_name . $this->ext; //返回文件后缀名
        }

        if (!$this->check_file_type($upload['type']))
        {
            $this->error_msg = '不是允许的文件格式';
            return false;
        }
		
		if(!$this->checkExt($this->fileFormat)){
			$this->error_msg = '不是允许的文件格式';
			return false;
		}

		if ($this->maxsize != 0 )
        {
            if ($this->$upload['size'] > $this->maxsize)
            {
                $this->error_msg = '文件大小超过' . $this->maxsize;
                return false;
            }
        }
		
        if ($this->move_file($upload, $file_name))
        {
            return str_replace(ROOT_PATH, '', $file_name);
        }
        else
        {
            $this->error_msg = sprintf('文件 %s 上传失败', $upload['name']);

            return false;
        }
    }
	/* 错误信息
	*/
	function error_msg()
    {
        return $this->error_msg;
    }
	
	/**
     * 检查文件类型
     * @param   string  $file_type   文件类型
     * @return  bool
     */
	function check_file_type($file_type)
    {
        return $file_type == 'application/zip' ||
               $file_type == 'application/octet-stream';
    }
	
	//上传格式限制
	function checkExt($fileFormat){
		/* 如果有格式限制 */
		if (!empty($fileFormat))
		{  
			$ext = ltrim($this->ext,'.');
			reset($fileFormat);
			while(list($var, $key) = each($fileFormat))
			{
				if (strtolower($key) == strtolower($ext))			
					return true;
			}
			reset($this->fileFormat);
		}else{
			return false;
		}
	}
	/**
     *  返回文件后缀名，如‘.php’
     *
     * @access  public
     * @param
     *
     * @return  string      文件后缀名
     */
    function get_filetype($path)
    {
        $pos = strrpos($path, '.');
        if ($pos !== false)
        {
            return substr($path, $pos);
        }
        else
        {
            return '';
        }
    }
	//取上传文件的扩展名
	function get_ext($upload)
	{
		return $ext = strtolower(substr($upload['name'],strrpos($upload['name'],".")+1));	
	}
	/**
     * 生成随机的数字串
     *
     * @author: weber liu
     * @return string
     */
    function random_filename()
    {
        $str = '';
        for($i = 0; $i < 9; $i++)
        {
            $str .= mt_rand(0, 9);
        }

        return (time() - date('Z')) . $str;
    }
	/**
     *  生成指定目录不重名的文件名
     *
     * @access  public
     * @param   string      $dir        要检查是否有同名文件的目录
     *
     * @return  string      文件名
     */
    function unique_name($dir)
    {
        $filename = '';
        while (empty($filename))
        {
            $filename = cls_upload::random_filename();
            if (file_exists($dir . $filename . $this->ext))
            {
                $filename = '';
            }
        }

        return $filename;
    }
	
	function move_file($upload, $target)
    {
        if (isset($upload['error']) && $upload['error'] > 0)
        {
            return false;
        }

        if (!$this->move_upload_file($upload['tmp_name'], $target))
        {
            return false;
        }

        return true;
    }
	
	function move_upload_file($file_name, $target_name = '')
	{
		if (function_exists("move_uploaded_file"))
		{
			if (move_uploaded_file($file_name, $target_name))
			{
				@chmod($target_name,0755);
				return true;
			}
			else if (copy($file_name, $target_name))
			{
				@chmod($target_name,0755);
				return true;
			}
		}
		elseif (copy($file_name, $target_name))
		{
			@chmod($target_name,0755);
			return true;
		}
		return false;
	}
	/**
	 * 检查目标文件夹是否存在，如果不存在则自动创建该目录
	 *
	 * @access      public
	 * @param       string      folder     目录路径。不能使用相对于网站根目录的URL
	 *
	 * @return      bool
	 */
	function make_dir($folder)
	{
		$reval = false;
	
		if (!file_exists($folder))
		{
			/* 如果目录不存在则尝试创建该目录 */
			@umask(0);
	
			/* 将目录路径拆分成数组 */
			preg_match_all('/([^\/]*)\/?/i', $folder, $atmp);
	
			/* 如果第一个字符为/则当作物理路径处理 */
			$base = ($atmp[0][0] == '/') ? '/' : '';
	
			/* 遍历包含路径信息的数组 */
			foreach ($atmp[1] AS $val)
			{
				if ('' != $val)
				{
					$base .= $val;
	
					if ('..' == $val || '.' == $val)
					{
						/* 如果目录为.或者..则直接补/继续下一个循环 */
						$base .= '/';
	
						continue;
					}
				}
				else
				{
					continue;
				}
	
				$base .= '/';
	
				if (!file_exists($base))
				{
					/* 尝试创建目录，如果创建失败则继续循环 */
					if (@mkdir(rtrim($base, '/'), 0777))
					{
						@chmod($base, 0777);
						$reval = true;
					}
				}
			}
		}
		else
		{
			/* 路径已经存在。返回该路径是不是一个目录 */
			$reval = is_dir($folder);
		}
	
		clearstatcache();
	
		return $reval;
	}
}
?>