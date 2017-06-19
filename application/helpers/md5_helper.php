<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 自定义 md5 加密算法
 * @author      junhey
 * @link        http://www.junhey.com/
 * 
 * @access   public
 * @param    string   需加密的字符串
 * @return   string   加密后的字符串
 */
function str_md5($str)
{
	return md5(base64_encode(SITE_ENCRYPTION_KEY_BEGIN) . md5($str) . base64_encode(SITE_ENCRYPTION_KEY_END));
}

/* End of file my_md5_helper.php */
/* Location: ./application/helpers/my_md5_helper.php */