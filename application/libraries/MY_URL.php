<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
/**
 * 解决URL地址的中文问题
 * @version 1.0
 * @author 何俊
 */

class MY_URI extends CI_URI {
        function _filter_uri($str)
    {
        if ($str != '' AND $this->config->item('permitted_uri_chars') != '')
        {
            $str = urlencode($str);  // 注意这里
            if ( ! preg_match("|^[".preg_quote($this->config->item('permitted_uri_chars'))."]+$|i", $str))
            {
                exit('The URI you submitted has disallowed characters.');
            }
            $str = urldecode($str);  // 注意这里
        }
        return $str;
    }  
}
?>