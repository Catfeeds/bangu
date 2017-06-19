<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * @验证码生成工具
 * @path：controllers/tools/captcha.php
 * ===================================================================
 * 加载验证码图像的同时将会生成两个session键，判断键值即可完成验证
 * 底层函数配置路径：application/helpers/captcha_helper.php
 * --调用-------------------------------------------------------------
 * //在视图页面中加载验证码
 * <img style="-webkit-user-select: none" src="<?php echo base_url(); ?>tools" onclick="this.src='<?php echo base_url();?>tools?'+Math.random()">
 * --验证-------------------------------------------------------------
 * //获取验证码图像中的文字内容并在控制器中和输入的值进行匹配
 * $this->session->userdata('captcha');
 * //获取验证码生成的时间戳，同时也是图像文件的文件名
 * $this->session->userdata('captime');
 * ===================================================================
 * @类别：通用工具
 * @作者：何俊 （junhey@qq.com）v1.0 Final
 */
//ob_clean();
class Captcha extends CI_Controller {
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ();
		// 载入验证码辅助函数
		$this->load->helper ( 'captcha' );
		$this->load->library ( 'session' );
	}
	/**
	 * route默认指向页面
	 */
	public function index() {
		$this->ver1 ();
	}
	
	/**
	 * 验证码：版本1
	 */
	public function ver1($data = '') {
		Header ( "Content-type: image/gif" );
		// 验证码配置参数
		/*
		 * 参数初始化
		 */
		$defaults = array (
				'border' => 1,
				'num' => 4,
				'w' => 60,
				'h' => 30,
				'fontsize' => 50 
		);
		
		foreach ( $defaults as $key => $val ) {
			if (! is_array ( $data )) {
				if (! isset ( $$key ) or $$key == '') {
					$$key = $val;
				}
			} else {
				$$key = (! isset ( $data [$key] )) ? $val : $data [$key];
			}
		}
		
		$alpha = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; // 验证码内容1:字母
		$number = "1234567890"; // 验证码内容2:数字
		$randcode = ""; // 验证码字符串初始化
		srand ( ( double ) microtime () * 1000000 ); // 初始化随机数种子
		$im = ImageCreate ( $w, $h ); // 创建验证图片
		
		/*
		 * 绘制基本框架
		 */
		$bgcolor = ImageColorAllocate ( $im, 255, 255, 255 ); // 设置背景颜色
		ImageFill ( $im, 0, 0, $bgcolor ); // 填充背景色
		if ($border) {
			$black = ImageColorAllocate ( $im, 176, 196, 242 ); // 设置边框颜色
			ImageRectangle ( $im, 0, 0, $w - 1, $h - 1, $black ); // 绘制边框
		}
		/*
		 * 逐位产生随机字符
		 */
		for($i = 0; $i < $num; $i ++) {
			$alpha_or_number = mt_rand ( 0, 1 ); // 字母还是数字
			//$str = $alpha_or_number ? $alpha : $number;
			$str = $alpha_or_number ? $number : $number;
			$which = mt_rand ( 0, strlen ( $str ) - 1 ); // 取哪个字符
			$code = substr ( $str, $which, 1 ); // 取字符
			$j = ! $i ? 4 : $j + 15; // 绘字符位置
			$color3 = ImageColorAllocate ( $im, mt_rand ( 0, 100 ), mt_rand ( 0, 100 ), mt_rand ( 0, 100 ) ); // 字符随即颜色
			ImageChar ( $im, $fontsize, $j, 3, $code, $color3 ); // 绘字符
			$randcode .= $code; // 逐位加入验证码字符串
		}
		/*
		 * 添加干扰
		 */
		for($i = 0; $i < $num * 15; $i ++) // 绘背景干扰点
{
			$color2 = ImageColorAllocate ( $im, mt_rand ( 0, 255 ), mt_rand ( 0, 255 ), mt_rand ( 0, 255 ) ); // 干扰点颜色
			ImageSetPixel ( $im, mt_rand ( 0, $w ), mt_rand ( 0, $h ), $color2 ); // 干扰点
		}
		// 把验证码字符串写入session
		$arr = array (
				'captcha' => $randcode 
		);
		$this->session->set_userdata ( $arr ); // $_SESSION[$this->name]=$randcode;
		/* 绘图结束 */
		Imagegif ( $im );
		ImageDestroy ( $im );
	}
	/**
	 * 验证码：版本2
	 */
	public function ver2($data=''){
		//session_start();
		//生成验证码图片
		header("Content-type: image/png");
		//要显示的字符，可自己进行增删
		$str = "1,2,3,4,5,6,7,8,9,0";
		$list = explode(",", $str);
		$cmax = count($list) - 1;
		$verifyCode = '';
		for ( $i=0; $i < 4; $i++ ){
			$randnum = mt_rand(0, $cmax);
			//取出字符，组合成验证码字符
			$verifyCode .= $list[$randnum];
		}
		//避免程序读取session字符串破解，生成的验证码用MD5加密一下再放入session，提交的验证码md5以后和seesion存储的md5进行对比
		//直接md5还不行，别人反向md5后提交还是可以的，再加个特定混淆码再md5强度才比较高,总长度在14位以上
		//网上有反向md5的 Rainbow Table，64GB的量几分钟内就可以搞定14位以内大小写字母、数字、特殊字符的任意排列组合的MD5反向
		//但这种方法不能避免直接分析图片上的文字进行破解，生成gif动画比较难分析出来
		//加入前缀、后缀字符，prestr endstr 为自定义字符，将最终字符放入SESSION中
		//$_SESSION['captcha'] =  md5("prestr".$verifyCode."endstr");
		
		// 把验证码字符串写入session
		$arr = array (
				'captcha' => $verifyCode
		);
		
		$this->session->set_userdata ( $arr ); // $_SESSION[$this->name]=$randcode;
		//生成图片
		$im = imagecreate(500,250);
		//$im = imagecreate(60,30);
		
		//此条及以下三条为设置的颜色
		$black = imagecolorallocate($im, 0,0,0);
		$white = imagecolorallocate($im, 255,255,255);
		$gray = imagecolorallocate($im, 200,200,200);
		$red = imagecolorallocate($im, 255, 0, 0);
		//给图片填充颜色
		imagefill($im,0,0,$white);
		//将验证码写入到图片中
		imagestring($im, 5, 10, 8, $verifyCode, $black);
		//加入干扰象素
		for($i=0;$i<50;$i++)
		{
			$randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
			imagesetpixel($im, rand()%70 , rand()%30 , $randcolor);
		}
		imagepng($im);
		imagedestroy($im);
	}
	
	/**
	 * 检测验证码
	 * 若验证码输入正确则返回1，失败则为0
	 */
	public function checkCap() {
		// $cap=strtoupper("18f5");
		$cap = strtoupper ( $this->input->post ( "ucap" ) ); // 字符串转换成大写
		echo $cap == $this->session->userdata ( 'captcha' ) ? 1 : 0;
	}
}
/* End of file Captcha.php */
/* Location: ./application/controllers/tools/captcha.php */