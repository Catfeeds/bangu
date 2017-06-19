<?php
if ( ! function_exists('getip'))
{
	function encrypt($string, $key)
	{
		$key    =   md5($key);
		$x      =   0;
		$len    =   strlen($string);
		$l      =   strlen($key);
		$char = '';
		$str ='';
		for ($i = 0; $i < $len; $i++)
		{
			if ($x == $l)
			{
				$x = 0;
			}
			$char .= $key{$x};
			$x++;
		}
		for ($i = 0; $i < $len; $i++)
		{
			$str .= chr(ord($string{$i}) + (ord($char{$i})) % 256);
		}
		return base64_encode($str);
	}
	
	function decrypt($string, $key)
	{
		$key = md5($key);
		$x = 0;
		$string = base64_decode($string);
		$len = strlen($string);
		$l = strlen($key);
		$char = '';
		$str = '';
		for ($i = 0; $i < $len; $i++)
		{
			if ($x == $l)
			{
				$x = 0;
			}
			$char .= substr($key, $x, 1);
			$x++;
		}
		for ($i = 0; $i < $len; $i++)
		{
			if (ord(substr($string, $i, 1)) < ord(substr($char, $i, 1)))
			{
				$str .= chr((ord(substr($string, $i, 1)) + 256) - ord(substr($char, $i, 1)));
			}
			else
			{
				$str .= chr(ord(substr($string, $i, 1)) - ord(substr($char, $i, 1)));
			}
		}
		return $str;
	}
}