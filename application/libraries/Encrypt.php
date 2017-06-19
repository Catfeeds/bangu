<?php
/**
 * 
 * -----------------------------------------------------------------------
 *  加密解密算法
 * -----------------------------------------------------------------------
 * 
 * @author 温文斌
 * @time 2015年11月09日 10:25:46
 * @url 
 * @email 
 *
 */
class Encrypt {
    
    var $encrypt_key="bangu";
    /*
    *加密
    */
    function getEncryptString($str) {
        $td = mcrypt_module_open(MCRYPT_3DES, '',MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        $ks = mcrypt_enc_get_key_size($td);
        $key = substr(md5($this->encrypt_key), 0, $ks);
        mcrypt_generic_init($td, $key, $iv);
        $encrypted = mcrypt_generic($td, $str);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return  base64_encode($encrypted);
    }
    
    /**
     * 解密
     */
    function decryptToken($encrypted){
        $encrypted = base64_decode($encrypted);
        $td = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        $ks = mcrypt_enc_get_key_size($td);
        $key = substr(md5($this->encrypt_key), 0, $ks);
        mcrypt_generic_init($td, $key, $iv);
        $dencrypted = mdecrypt_generic($td, $encrypted);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return trim($dencrypted);
    }
 /**
     * 发送curl请求
     * 方式:post
     */
    public function post_curl($uri=null,$data=array())
    {
        
        $ch = curl_init ();
        // print_r($ch);
        curl_setopt ( $ch, CURLOPT_URL, $uri );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
         
        return $result;
    }
	

}
