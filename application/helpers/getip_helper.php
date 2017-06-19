<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * PHP正则表达式辅助函数（getip_helper）
 * @path：helpers/getip_helper.php
 * ===================================================================
 * @功能：获取ip具体城市
 * ===================================================================
 * @类别：辅助函数
 * @作者： 何俊（junhey@qq.com）v1.0.0
 *
 *
 */
 if ( ! function_exists('getip'))
{
	function JSGetIP()
	{
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} else {
				if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) ) {
					$ip = $_SERVER['REMOTE_ADDR'];
				} else {
					if (getenv('HTTP_X_FORWARDED_FOR')) {
						$ip = getenv('HTTP_X_FORWARDED_FOR');
					} else {
						if (getenv('HTTP_CLIENT_IP')) {
							$ip = getenv('HTTP_CLIENT_IP');
						} else {
							if (getenv('REMOTE_ADDR')) {
								$ip = getenv('REMOTE_ADDR');
							} else {
								$ip = 'Unknown';
							}
						}
					}
				}
			}
		}
		return $ip;
	}
	function getip($ip)
	{
		$ip="222.23.43.23";
		$url = ('http://www.ip138.com/ips138.asp?ip=' . $ip) . '&action=2';
		echo $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		//设置URL，可以放入curl_init参数中
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.202 Safari/535.1');
		//设置UA
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。 如果不加，即使没有echo,也会自动输出
		$content = curl_exec($ch);
		//执行
		curl_close($ch);
		//关闭
		//echo $content;
		//<li>本站主数据：湖南省常德市 电信</li>
		preg_match('/本站主数据：(?<mess>(.*))市(.*)<\\/li><li>/', $content, $arr);
		print_r($arrs);
		if(sizeof($arr)){
			return "深圳";
		}else{
			//查询注意事项
			if (strripos($arr['mess'], '省') > 0) {
				$city = substr($arr['mess'], strripos($arr['mess'], '省') + 2, 100);
			} else {
				$city = $arr['mess'];
			}
			return $city;
		}

	}
}

/* End of file getip_helper.php */
