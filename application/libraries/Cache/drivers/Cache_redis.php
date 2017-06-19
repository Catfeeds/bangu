<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 3.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Redis Caching Class
 *
 * @package	   CodeIgniter
 * @subpackage Libraries
 * @category   Core
 * @author	   Anton Lindqvist <anton@qvister.se>
 * @link
 */
class CI_Cache_redis extends CI_Driver
{
	/**
	 * Default config
	 *
	 * @static
	 * @var	array
	 */
	protected static $_default_config = array(
		'socket_type' => 'tcp',
// 		'host' => '127.0.0.1',
		'host' => '192.168.10.202',
		'password' => '',
		'port' => 6379,
		'timeout' => 0
	);
	
	/**
	 * Redis connection
	 *
	 * @var	Redis
	 */
	protected $_redis;
	/**
	 * An internal cache for storing keys of serialized values.
	 *
	 * @var	array
	 */
	protected $_serialized = array();
	// ------------------------------------------------------------------------
	/**
	 * Class constructor
	 *
	 * Setup Redis
	 *
	 * Loads Redis config file if present. Will halt execution
	 * if a Redis connection can't be established.
	 *
	 * @return	void
	 * @see		Redis::connect()
	 */
	public function __construct()
	{
		$config = array();
		$CI =& get_instance();
		if ($CI->config->load('redis', TRUE, TRUE))
		{
			$config = $CI->config->item('redis');
		}
		$config = array_merge(self::$_default_config, $config);
		$this->_redis = new Redis();
		
		try
		{
			if ($config['socket_type'] === 'unix')
			{
				$success = $this->_redis->connect($config['socket']);
			}
			else // tcp socket
			{
				$success = $this->_redis->connect($config['host'], $config['port'], $config['timeout']);
			}
			if ( ! $success)
			{
				log_message('error', 'Cache: Redis connection failed. Check your configuration.');
			}
			if (isset($config['password']) && ! $this->_redis->auth($config['password']))
			{
				log_message('error', 'Cache: Redis authentication failed.');
			}
		}
		catch (RedisException $e)
		{
			log_message('error', 'Cache: Redis connection refused ('.$e->getMessage().')');
		}
		// Initialize the index of serialized values.
		$serialized = $this->_redis->sMembers('_ci_redis_serialized');
		empty($serialized) OR $this->_serialized = array_flip($serialized);
	}
	// ------------------------------------------------------------------------
	
	public function select($db){
		$this->_redis->select($db);
	}
	public function del($key) {
		return $this->_redis->del($key);
	}
	public function expire($key ,$seconds) {
		return $this->_redis->expire($key ,$seconds);
	}
	public function publish ($channel ,$msg) {
		return $this->_redis->publish($channel ,$msg);
	}
	public function subscribe($channelArr ,$callback) {
		return $this->_redis->subscribe($channelArr ,$callback);
	}
	public function zadd($key ,$score ,$member) {
		return $this->_redis->zadd($key ,$score ,$member);
	}
	public function zrevrangebyscore($key ,$max ,$min ,$withscores=false ,array $limitArr = array()) {
		if ($withscores != false && !empty($limitArr))
		{
			return $this->_redis->zrevrangebyscore($key ,$max ,$min ,array('withscores'=>true ,'limit' =>$limitArr));
		}
		elseif ($withscores != false)
		{
			return $this->_redis->zrevrangebyscore($key ,$max ,$min ,array('withscores'=>true));
		}
		elseif (!empty($limitArr))
		{
			return $this->_redis->zrevrangebyscore($key ,$max ,$min ,array('limit' =>$limitArr));
		}
		
	}
	
	public function scard($key)
	{
		return $this->_redis->scard($key);
	}
	public function zscore($key ,$member)
	{
		return $this->_redis->zscore($key ,$member);
	}
	
	public function incrby($key ,$increment)
	{
		return $this->_redis->incrby($key ,$increment);
	}
	public function setex($key ,$seconds  ,$value)
	{
		return $this->_redis->setex($key ,$seconds ,$value);
	}
	public function set($key ,$value) {
		return $this->_redis->set($key ,$value);
	}
	/**
	 * Get cache
	 *
	 * @param	string	Cache ID
	 * @return	mixed
	 */
	public function get($key)
	{
		$value = $this->_redis->get($key);
		if ($value !== FALSE && isset($this->_serialized[$key]))
		{
			return unserialize($value);
		}
		return $value;
	}
	/**
	 * Hash Get cache
	 * @param	hashCode
	 * @return	$hashdata
	 */
	public function hGet($key, $field)
	{
		$hashdata = $this->_redis->hGet ( $key, $field );
		return $hashdata;
	}
	public function hSet($key, $field, $value){
		$this->_redis->hSet ( $key, $field, $value );
	}
	public function hdel($key ,$field){
		$this ->_redis->hdel($key ,$field);
	}
	public function sAdd($key,$member){
		$this->_redis->sAdd( $key, $member );
	}
	public function sRem($index_key, $id){
		$this->_redis->sRem( $index_key, $id );
	}
	public function sMembers($key){
		$array = $this->_redis->sMembers($key);
		return $array;
	}
	
	/**
	 * 
	 * @param string $key
	 * @param array $arr
	 * @return unknown
	 */
	public function lpush($key ,$value){
		return $this->_redis->lpush($key ,$value);
	}
	
	
	// ------------------------------------------------------------------------
	/**
	 * Save cache
	 *
	 * @param	string	$id	Cache ID
	 * @param	mixed	$data	Data to save
	 * @param	int	$ttl	Time to live in seconds
	 * @param	bool	$raw	Whether to store the raw value (unused)
	 * @return	bool	TRUE on success, FALSE on failure
	 */
	public function save($id, $data, $ttl = 60, $raw = FALSE)
	{
		if (is_array($data) OR is_object($data))
		{
			if ( ! $this->_redis->sIsMember('_ci_redis_serialized', $id) && ! $this->_redis->sAdd('_ci_redis_serialized', $id))
			{
				return FALSE;
			}
			isset($this->_serialized[$id]) OR $this->_serialized[$id] = TRUE;
			$data = serialize($data);
		}
		elseif (isset($this->_serialized[$id]))
		{
			$this->_serialized[$id] = NULL;
			$this->_redis->sRemove('_ci_redis_serialized', $id);
		}
		return $this->_redis->set($id, $data, $ttl);
	}
	// ------------------------------------------------------------------------
	/**
	 * Delete from cache
	 *
	 * @param	string	Cache key
	 * @return	bool
	 */
	public function delete($key)
	{
		if ($this->_redis->delete($key) !== 1)
		{
			return FALSE;
		}
		if (isset($this->_serialized[$key]))
		{
			$this->_serialized[$key] = NULL;
			$this->_redis->sRemove('_ci_redis_serialized', $key);
		}
		return TRUE;
	}
	// ------------------------------------------------------------------------
	/**
	 * Increment a raw value
	 *
	 * @param	string	$id	Cache ID
	 * @param	int	$offset	Step/value to add
	 * @return	mixed	New value on success or FALSE on failure
	 */
	public function increment($id, $offset = 1)
	{
		return $this->_redis->incr($id, $offset);
	}
	// ------------------------------------------------------------------------
	/**
	 * Decrement a raw value
	 *
	 * @param	string	$id	Cache ID
	 * @param	int	$offset	Step/value to reduce by
	 * @return	mixed	New value on success or FALSE on failure
	 */
	public function decrement($id, $offset = 1)
	{
		return $this->_redis->decr($id, $offset);
	}
	// ------------------------------------------------------------------------
	/**
	 * Clean cache
	 *
	 * @return	bool
	 * @see		Redis::flushDB()
	 */
	public function clean()
	{
		return $this->_redis->flushDB();
	}
	// ------------------------------------------------------------------------
	/**
	 * Get cache driver info
	 *
	 * @param	string	Not supported in Redis.
	 *			Only included in order to offer a
	 *			consistent cache API.
	 * @return	array
	 * @see		Redis::info()
	 */
	public function cache_info($type = NULL)
	{
		return $this->_redis->info();
	}
	// ------------------------------------------------------------------------
	/**
	 * Get cache metadata
	 *
	 * @param	string	Cache key
	 * @return	array
	 */
	public function get_metadata($key)
	{
		$value = $this->get($key);
		if ($value !== FALSE)
		{
			return array(
				'expire' => time() + $this->_redis->ttl($key),
				'data' => $value
			);
		}
		return FALSE;
	}
	// ------------------------------------------------------------------------
	/**
	 * Check if Redis driver is supported
	 *
	 * @return	bool
	 */
	public function is_supported()
	{
		return extension_loaded('redis');
	}
	// ------------------------------------------------------------------------
	/**
	 * Class destructor
	 *
	 * Closes the connection to Redis if present.
	 *
	 * @return	void
	 */
	public function __destruct()
	{
		if ($this->_redis)
		{
			$this->_redis->close();
		}
	}
}