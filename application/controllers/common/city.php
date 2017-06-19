<?php
/**
 * @method 站点城市
 * @since  2016-01-06
 * @author jiakairong
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class City extends MY_Controller
{
	public function __construct()
	{
		parent::__construct ();
	}
	//站点城市
	public function getStartCityJson()
	{
		$this ->load_model('startplace_model');
		$startData = $this ->startplace_model ->all(array('isopen' =>1,'level' =>3) ,'' ,'arr' ,'simplename,id,cityname as name,ishot');
		$startArr = array(
			'热门城市' => array(),
			'ABCDEFG' =>array(),
			'HIJKLMN' =>array(),
			'OPQRST' =>array(),
			'UVWXYZ' =>array()
		);
		foreach($startArr as $key =>$val)
		{
			if ($key == '热门城市') continue;
			$keyLen = strlen($key);
			$i = 0;
			for($i ;$i<$keyLen ;$i++) 
			{
				$startArr[$key][$key[$i]] = array();
			}
		}
		if (!empty($startData))
		{
			foreach($startData  as $val)
			{
				if (empty($val['name']) || empty($val['simplename'])) continue;
				if ($val['ishot'] == 1)
				{
					$startArr['热门城市'][] = $val;
				}
				$firstStr = strtoupper(substr($val['simplename'] ,0 ,1));
				switch($firstStr)
				{
					case 'A':
					case 'B':
					case 'C':
					case 'D':
					case 'E':
					case 'F':
					case 'G':
						$startArr['ABCDEFG'][$firstStr][] = $val;
						break;
					case 'H':
					case 'I':
					case 'J':
					case 'K':
					case 'L':
					case 'M':
					case 'N':
						$startArr['HIJKLMN'][$firstStr][] = $val;
						break;
					case 'O':
					case 'P':
					case 'Q':
					case 'R':
					case 'S':
					case 'T':
						$startArr['OPQRST'][$firstStr][] = $val;
						break;
					case 'U':
					case 'V':
					case 'W':
					case 'X':
					case 'Y':
					case 'Z':
						$startArr['UVWXYZ'][$firstStr][] = $val;
						break;
				}
			}
		}
		echo json_encode($startArr);
	}
}