<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Update_dest extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
	}
	
	public function expert()
	{
		ini_set('default_socket_timeout', -1);
		set_time_limit(0);
		
		//获取原目的地表的二级目的地
		$sql = 'select id,kindname from u_dest_base where level = 2';
		$dest = $this ->db ->query($sql) ->result_array();
		$destArr = array();
		foreach($dest as $v)
		{
			$destArr[$v['kindname']] = $v['id'];
		}
		
		//新目的地的名称
		$newDest = array(
				'印度尼西亚',
				'港澳台',
				'东南亚',
				'日韩',
				'海岛',
				'地中海',
				'欧洲',
				'中东非',
				'美洲',
				'澳新',
				'北欧',
				'俄罗斯',
				'邮轮',
				'南北极',
				'西亚',
				'满洲里',
				'海拉尔',
				'海南',
				'广西',
				'阿坝州',
				'福建',
				'广东',
				'云南',
				'贵州',
				'川渝',
				'湖南',
				'江西',
				'湖北',
				'华东',
				'西北',
				'华北',
				'东北',
				'内蒙古',
				'边境游'
		);
		
		//获取新目的地ID
		$newArr = array();
		foreach($newDest as $v)
		{
			$sql = 'select id from u_dest_base where kindname="'.$v.'" and isopen=1';
			$data = $this ->db ->query($sql) ->row_array();
			$newArr[$v] = $data['id'];
		}
		
		$idArr = array();
		foreach($destArr as $k =>$v)
		{
			if ($k == '南亚中亚' || $k=='西南') {
				continue;
			}
			switch ($k)
			{
				case '东欧地中海':
					$idArr[$v] = $newArr['地中海'];
					break;
				case '中东非洲':
					$idArr[$v] = $newArr['中东非'];
					break;
				case '澳新南太':
					$idArr[$v] = $newArr['澳新'];
					break;
				case '北欧俄罗斯':
					$idArr[$v] = array($newArr['俄罗斯'],$newArr['北欧']);
					break;
				case '邮轮度假村':
					$idArr[$v] = $newArr['邮轮'];
					break;
				case '海南广西':
					$idArr[$v] = array($newArr['广西'],$newArr['海南']);
					break;
				case '福建广东':
					$idArr[$v] = array($newArr['广东'],$newArr['福建']);
					break;
				case '云贵川渝':
					$idArr[$v] = array($newArr['云南'],$newArr['贵州'],$newArr['川渝']);
					break;
				case '江西湖北':
					$idArr[$v] = array($newArr['江西'],$newArr['湖北']);
					break;
				case '内蒙':
					$idArr[$v] = $newArr['内蒙古'];
					break;
				default:
					$idArr[$v] = $newArr[$k];
					break;
			}
		}
		
		$i = 0;
		$a = '';
		for($i ;$i<1000 ;$i++)
		{
			//更改3月1号之前的
			$j = $i*1000;
			
// 			$sql = 'select id,expert_dest from u_expert where addtime < "2017-03-01" order by addtime asc limit '.$j.',1000';
// 			$data = $this ->db ->query($sql) ->result_array();
			$data = array();
			if (!empty($data))
			{
				foreach($data  as $v)
				{
					//latitude
					if (!empty($v['expert_dest']))
					{
						if (strpos($v['expert_dest'] ,'undefined') !== false)
						{
							//数据中存在undefined,则过滤掉undefined
							$str = str_replace('undefined', '', $v['expert_dest']);
							$arr = explode(',', $str);
							$dest = '';
							foreach($arr as $val)
							{
								if (!empty($val))
								{
									$dest .= $val.',';
								}
							}
							$dest = trim($dest ,',');
							$v['expert_dest'] = $dest;
						}
						
						if (!empty($v['expert_dest']))
						{
							$edArr = explode(',', $v['expert_dest']);
							$str = '';
							foreach($edArr as $item)
							{
								if (array_key_exists($item, $idArr)) 
								{
									if (is_array($idArr[$item]))
									{
										$str .= implode(',', $idArr[$item]).',';
									}
									else 
									{
										$str .= $idArr[$item].',';
									}
								}
							}
							
							if (!empty($str))
							{
								$sql = 'update u_expert set expert_dest="'.rtrim($str,',').'",latitude="'.$v['expert_dest'].'" where id='.$v['id'];
								$this ->db ->query($sql);
							}
							else 
							{
								//没有获取到原目的地，则更新为空，原目的地暂时保存在latitude字段中
								$sql = 'update u_expert set expert_dest="",latitude="'.$v['expert_dest'].'" where id='.$v['id'];
								$this ->db ->query($sql);
								$a .= $v['id'].',';
							}
						}
						else 
						{
							//字段有值，但都是undefined填充，则更新为空
							$sql = 'update u_expert set expert_dest="" where id ='.$v['id'];
							$this ->db ->query($sql);
						}
					}
					else 
					{
						//没有目的地
					}
				}
			}
			else 
			{
				echo '执行完成';
				break;
			}
			
			//break;
		}
		if (!empty($a))
		{
			echo 'expert_dest字段有值，但没有获取到原目的地。有如下值：'.$a;
		}
		echo '执行结束';
	}
	
}