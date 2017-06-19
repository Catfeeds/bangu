<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @功能：获取文件缓存
 * ===================================================================
 * @类别：辅助函数
 * @作者： 何俊（junhey@qq.com）v1.0.0
 * 
 * 调用方法
 * 
 * 
		$cache_key = 'abc';  //cache key 。任意字符即可
		$expireTime = 3;   //过期时间。 0 为永不过期
		if ( false == ($content = cache_get($cache_key, $expireTime) ) ) {		
			// code here
			$content = array('a'=>date("Y-m-d H:i:s"));		
			cache_set($cache_key, $content);
		}
		print_r( cache_get('abc') ) ;exit();
 * 
 * 
 * /
 
/**
 * 获取文件缓存
 *
 * @param cache_key $cache_key
 * @param 过期时间(s) $expireTime
 * @return 缓存内容
 */
function cache_get($cache_key, $expireTime = 0)
{
	if (empty($cache_key)) {
		return false;
	}
	$cache_key = md5($cache_key);
 
	$CI = & get_instance();
	$cache_path = $CI->config->config['cache_path'];
 
	$filepath =  $cache_path . substr($cache_key, 0, 2). "/" .$cache_key;
	if (!file_exists($filepath)) {
		return false;
	}
 
	if ( !empty($expireTime)
	 && filemtime($filepath) < time() - $expireTime
	) {
		unlink($filepath);
		return false;
	}
 
	return unserialize(file_get_contents($filepath));	
}
 
/**
 * 设置缓存
 *
 * @param cache key $cache_key
 * @param 缓存内容(strint/array) $content
 * @return true/false
 */
function cache_set($cache_key, $content='')
{
	if (empty($cache_key) || empty($content)) {
		return false;
	}
	$cache_key = md5($cache_key);
 
	$CI = & get_instance();
	$cache_path = $CI->config->config['cache_path'];
 	
	$path = $cache_path . substr($cache_key, 0, 2) ;
	if (!is_dir($path)) {
		mkdir($path);
		@chmod($path, 0777);
	}
	$filepath = $path. "/" .$cache_key;
	if( @file_put_contents($filepath, serialize($content) ) ) {
		return false;
	}
	return true;
}
 
/**
 * 删除缓存
 *
 * @param cache key $cache_key
 * @return true/false
 */
function cache_del($cache_key)
{
	if (empty($cache_key)) {
		return false;
	}	
	$cache_key = md5($cache_key);
 
	$CI = & get_instance();
	$cache_path = $CI->config->config['cache_path'];
 
	$filepath =  $cache_path . substr($cache_key, 0, 2). "/" .$cache_key;
	if (!file_exists($filepath)) {
		return false;
	}
	unlink($filepath);
	return true;
}