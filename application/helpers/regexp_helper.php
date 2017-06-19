<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * PHP正则表达式辅助函数（regexp_helper）
 * @path：helpers/regexp_helper.php
 * ===================================================================
 * @功能：验证字符串是否符合正则规则
 * if(regexp("id",$user_id))
 * ===================================================================
 * @类别：辅助函数
 * @作者： 何俊（junhey@qq.com）v1.0.0
 *
 * 使用前先加载
 * $this->load->helper ( 'regexp' );
 * 直接按以下验证
 * regexp ( 'md5password', $password);
 *  返回true表示验证通过
 *
 */
 if ( ! function_exists('regexp'))
{
	function regexp($role,$str)
	{
		switch ($role)
		{
			case "id"://ID 字母、数字、下划线组成 6-2
			  return preg_match("/^(\w){6,20}$/",$str);
			case "password"://密码
			  return preg_match("/^(\S){6,20}$/",$str);
			case "md5password"://md5密码
			  return preg_match("/^(\S){32}$/",$str);
			case "zhcn"://中文
			  return preg_match("/^[\x80-\xff]{6,30}$/",$str);
			case "tel"://国内座机电话号
			  return preg_match("/\d{3}-\d{8}|\d{4}-\d{7,8}/",$str);
			case "mobile"://国内手机号码
			  return preg_match("/1[34578]{1}\d{9}$/",$str);
			case "qq"://QQ号
			  return preg_match("/^[1-9][0-9]{4,}$/",$str);
			case "numberInteger"://整形数字
			  return preg_match("/^[-+]?[1-9]\d*\.?[0]*$/",$str);
			case "numberFloat"://浮点型数字
			  return preg_match("/^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$/",$str);
			case "email":// email
			  return preg_match("/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/",$str);
			case "cid"://18位身份证号
			  return isCreditNo($str);
			case "zipcode"://国内邮编
			  return preg_match("/^[1-9]\d{5}(?!\d)$/",$str);
			case "url"://网址
			  return preg_match("/^(ht|f)tp(s?)\:\/\/[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;%\$#_]*)?$/",$str);
			case "htmlHexCode"://html颜色代码，如：#fff0
			  return preg_match("//^#([a-fA-F0-9]){3}(([a-fA-F0-9]){3})?$/",$str);
			case "dottedQuadIP"://ip地址
			  return preg_match("/^(\d|[01]?\d\d|2[0-4]\d|25[0-5])\.(\d|[01]?\d\d|2[0-4] \d|25[0-5])\.(\d|[01]?\d\d|2[0-4]\d|25[0-5])\.(\d|[01]?\d\d|2[0-4] \d|25[0-5])$/",$str);
			case "macAddress"://主机mac地址
			  return preg_match("/^([0-9a-fA-F]{2}:){5}[0-9a-fA-F]{2}$/",$str);
			case 'name'://姓名，中文或英文
			  return preg_match("/^([\x{4e00}-\x{9fa5}]+)$|^([a-z]+)$/u",$str);
			case 'date': //年月日  如：1992-08-08
				return preg_match("/^((19[2-9][0-9])|(20[0-9][0-9]))-((0[1-9])|(1[0-2]))-((0[1-9])|([12][0-9])|(3[01]))$/",$str);
			case 'zhcnup':
				return preg_match(" /^[\x{4e00}-\x{9fa5}]+$/u",$str);
		}
		return false;
	}

	function isCreditNo($id_num){
	    $province_code = array(
	        '11','12','13','14','15','21','22',
	        '23','31','32','33','34','35','36',
	        '37','41','42','43','44','45','46',
	        '50','51','52','53','54','61','62',
	        '63','64','65','71','81','82','91'
	    );
	if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $id_num)) return false;
	if (!in_array(substr($id_num, 0, 2), $province_code)) return false;
	$id_num = preg_replace('/[xX]$/i', 'a', $id_num);
	$id_num_length = strlen($id_num);
	    if ($id_num_length == 18){
	        $id_birthday = substr($id_num, 6, 4) . '-' . substr($id_num, 10, 2) . '-' . substr($id_num, 12, 2);
	    }else{
	        $id_birthday = '19' . substr($id_num, 6, 2) . '-' . substr($id_num, 8, 2) . '-' . substr($id_num, 10, 2);
	    }
    	if (date('Y-m-d', strtotime($id_birthday)) != $id_birthday) return false;
   	 if ($id_num_length == 18){
       		 $vSum = 0;
       		 for ($i = 17 ; $i >= 0 ; $i--){
         		   $vSubStr = substr($id_num, 17 - $i, 1);
          		  $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
     		   }
       		 if($vSum % 11 != 1) return false;
  	  }
   	 return true;
	}
}

/* End of file regexp_helper.php */
