<?PHP
class captcha
{
	private $width = 130;   //宽度
	private $height = 80;   //高度
	private $font = 'courbd.ttf';
	private $session_word = 'captcha_word';	
	
	/* 构造函数 */
	function captcha($width = 145, $height = 20, $font = 'courbd.ttf')
	{
		$this->width    = $width;
        $this->height   = $height;
		$this->font     = ROOT_PATH . 'includes/' . $font;
		
		/* 检查是否支持 GD */
        if (PHP_VERSION >= '4.3')
        {

            return (function_exists('imagecreatetruecolor') || function_exists('imagecreate'));
        }
        else
        {

            return (((imagetypes() & IMG_GIF) > 0) || ((imagetypes() & IMG_JPG)) > 0 );
        }
	}
	
	/* 构造函数 */
	function __construct($width = 145, $height = 20, $font = 'courbd.ttf')
    {
        $this->captcha($width, $height, $font);
    }
	
	/* 生成图片并输出到浏览器 */
	public function generate_image($word = false, $type = 'png')
    {
		if (!$word)
        {
            $word = $this->generate_word();
        }

		/* 验证码长度 */
        $letters = strlen($word);
		
		/* 字符间距 */
		$spacePerChar = $this->width / $letters;
		
		/* 记录验证码到session */
        $this->record_word($word);
		
		$img_org     = ((function_exists('imagecreatetruecolor')) && PHP_VERSION >= '4.3') ?
                          imagecreatetruecolor($this->width, $this->height) : imagecreate($this->width, $this->height);
		$background  = imagecolorallocate($img_org, 255, 255, 255); //背景颜色
		//$borderColor = imagecolorallocate($img_org, 0, 0, 0); //边框颜色
		
		imagefilledrectangle($img_org, 0, 0, $this->width, $this->height, $background);
		//imagerectangle($img_org, 0, 0, $this->width - 1, $this->height - 1, $borderColor);
		
		for($i = 0; $i < $letters; $i++)
		{
			$colors[] = imagecolorallocate($img_org, rand(0, 100), rand(0, 100), rand(0, 100));	
		}
		
		/* 随机生成雪花 */
		for ($i = 1; $i <= 200; $i++) 
		{
			imagestring($img_org,1,mt_rand(1,$this->width),mt_rand(1,$this->height),"*",imagecolorallocate($img_org,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255))); 
		}
		
		/* 把字符串写入图片 设置GBFONTPATH为当前目录,不然linux环境下会报错 */
		putenv('GDFONTPATH=' . realpath('.'));
		for($i = 0; $i < $letters; $i++){
				$color = $colors[$i % count($colors)];
				imagettftext(
						$img_org,
						16 + rand(0, 2),
						-20 + rand(0, 40),
//						($i + 0.3) * $spacePerChar,
//						$this->height - 20 + rand(0, 10),
						($i + 0.3) * $spacePerChar,
						$this->height - 3,
						$color,
						$this->font,
						$word{$i}
				);
		}

//		$clr = imagecolorallocate($img_org, 45, 120, 25);	
//		$x = ($this->width - (imagefontwidth(5) * $letters)) / 2;
//		$y = ($this->height - imagefontheight(5)) / 2;
//		imagestring($img_org, 5, $x, $y, $word, $clr);
		
		/* 绘制随机实线 */ 
/*		for($i = 0; $i < 100; $i++){
			$x1 = rand(5, $this->width  - 5);
			$y1 = rand(5, $this->height - 5);
			$x2 = $x1 - 4 + rand(0, 8);
			$y2 = $y1 - 4 + rand(0, 8);
			imageline($img_org, $x1, $y1, $x2, $y2, $colors[rand(0, count($colors) - 1)]);
		}*/
		
		/* 修正linux以及低版本的GD库问题 */
		if(function_exists(imageantialias)){
			imageantialias($img_org, true);
		}
 
		switch ($type){
			case 'png':
					header('Content-type:image/png');                                
					imagepng($img_org);        
			case 'jpeg':
					header('Content-type:image/jpeg'); 
					imageinterlace($img_org, 1);
					imagejpeg($img_org, '' , 75);
			case 'gif':
					header('Content-type:image/gif');                                
					imagegif($img_org);        
			default:
					header('Content-type:image/png');                                
					imagepng($img_org);                                                                                                                
		}
		imagedestroy($img_org);
		return true;
	}
	
	/* 生成随机的验证码 */
    function generate_word($length = 4)
    {
        $chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';

        for ($i = 0, $count = strlen($chars); $i < $count; $i++)
        {
            $arr[$i] = $chars[$i];
        }

        mt_srand((double) microtime() * 1000000);
        shuffle($arr);

        return substr(implode('', $arr), 5, $length);
    }
	
	/* 将验证码保存到session */
	function record_word($word)
    {
        $_SESSION[$this->session_word] = base64_encode($this->encrypts_word($word));
    }
	
	/* 检查给出的验证码是否和session中的一致 */
    function check_word($word)
    {
        $recorded = isset($_SESSION[$this->session_word]) ? base64_decode($_SESSION[$this->session_word]) : '';
        $given    = $this->encrypts_word(strtoupper($word));

        return (preg_match("/$given/", $recorded));
    }
	
	/* 对需要记录的串进行加密 */
	function encrypts_word($word)
    {
        return substr(md5($word), 1, 10);
    }
}

?>