<?PHP
define('VERSION', '1.0');

class LK
{
    var $db_name = '';
    var $prefix  = 'lk_';
	
	/**
     * 构造函数
     *
     * @access  public
     * @param   string      $db_name    数据库名
	 * @param   string      $prefix     表名前缀
     *
     * @return  void
     */
    function LK($db_name, $prefix)
    {
        $this->db_name = $db_name;
        $this->prefix  = $prefix;
    }
	
	/**
     * 将指定的表名加上前缀后返回
     *
     * @access  public
     * @param   string      $str        表名
     *
     * @return  string
     */
    function table($str)
    {
        return '`' . $this->db_name . '`.`' . $this->prefix . $str . '`';
    }
	
	/**
     * 取得当前的域名
     *
     * @access  public
     *
     * @return  string      当前的域名
     */
    function get_domain()
    {
        /* 协议 */
        $protocol = $this->http();

        /* 域名或IP地址 */
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
        {
            $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
        }
        elseif (isset($_SERVER['HTTP_HOST']))
        {
            $host = $_SERVER['HTTP_HOST'];
        }
        else
        {
            /* 端口 */
            if (isset($_SERVER['SERVER_PORT']))
            {
                $port = ':' . $_SERVER['SERVER_PORT'];

                if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol))
                {
                    $port = '';
                }
            }
            else
            {
                $port = '';
            }

            if (isset($_SERVER['SERVER_NAME']))
            {
                $host = $_SERVER['SERVER_NAME'] . $port;
            }
            elseif (isset($_SERVER['SERVER_ADDR']))
            {
                $host = $_SERVER['SERVER_ADDR'] . $port;
            }
        }

        return $protocol . $host;
    }
	/**
     * 获得当前环境的 HTTP 协议方式
     *
     * @access  public
     *
     * @return  void
     */
    function http()
    {
        return (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';
    }
	
	 /**
     * 获得LK 当前环境的 URL 地址
     *
     * @access  public
     *
     * @return  void
     */
    function url()
    {
        $curr = strpos(PHP_SELF,'admin/') !== false ?
                preg_replace('/(.*)(admin)(\/?)(.)*/i', '\1', dirname(PHP_SELF)) :
                dirname(PHP_SELF);

        $root = str_replace('\\', '/', $curr);

        if (substr($root, -1) != '/')
        {
            $root .= '/';
        }

        return $this->get_domain() . $root;
    }
}
?>