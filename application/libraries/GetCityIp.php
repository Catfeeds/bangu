<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class CI_GetCityIp {
	
	function getIPLoc_sina($ip){
	
		$url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$ip;
	
		$ch = curl_init($url);
	
		//curl_setopt($ch,CURLOPT_ENCODING ,'utf8');
	
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
	
		$location = curl_exec($ch);
	
		$location = json_decode($location);
	
		curl_close($ch);

		if($location===FALSE || is_int($location)) {
			return false;
		} elseif (is_object($location)) {
			$ret = $location ->ret;
			if ($ret == 1) {
				$address = array(
					'country' =>$location ->country,
					'province' =>$location ->province,
					'city' =>$location ->city
				);
				return $address;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}