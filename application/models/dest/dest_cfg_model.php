<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Dest_cfg_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct ( 'u_dest_cfg' );
	}
	
	/**
	 * @method 获取所有目的地配置数据
	 * @author jkr
	 * @param array $whereArr 搜索条件
	 */
	public function getDestCfgAll($whereArr=array())
	{
		$sql = 'select name,simplename,enname,list,pid as pId,id,dest_id from u_dest_cfg'.$this ->getWhereStr($whereArr);
		return $this ->db ->query($sql) ->result_array();
               // return $sql;
	}
	
	/**
	 * @method 通过目的地名称，获取目的地的上级和自己
	 * @author jkr
	 * @param array $whereArr 搜索条件(不包括目的地名称)
	 * @param string $name 目的地名称
	 */
	public function getNameSearchDest($whereArr ,$name)
	{
		$sql = 'select * from u_dest_cfg where name like "%'.$name.'%"';
		$searchData = $this ->db ->query($sql) ->result_array();
		if (empty($searchData))
		{
			return array();
		}
		else
		{
			$idArr = array();
			foreach($searchData as $v)
			{
				$listArr = explode(',', trim($v['list'] ,','));
				$idArr = array_merge($idArr ,$listArr);
				$idArr[] = $v['id'];
			}
				
			$idArr = array_unique($idArr);
			$idStr = '';
			foreach($idArr as $v)
			{
				if (empty($v))
					continue;
					$idStr .= $v.',';
			}
			$str = ' id in ('.rtrim($idStr ,',').') ';
				
			$str1 = $this->getWhereStr($whereArr);
			$whereStr = empty($str1) ? $str : $str1.' and '.$str;
			$sql = 'select name,simplename,enname,list,pid as pId,id,"true" as open from u_dest_cfg '.$whereStr;
			return $this ->db ->query($sql) ->result_array();
		}
	}
	
	/**
	 * @method 获取目的地配置数据的下级
	 * @author jkr
	 * @param intval $destid 目的地ID
	 */
	public function getLowerData($destid)
	{
		//先判断是否是顶级
		$sql = 'select * from u_dest_cfg where id ='.$destid;
		$destData = $this ->db ->query($sql) ->row_array();
		if (!empty($destData))
		{
			if ($destData['level'] == 1)
			{
				$sql = 'select * from u_dest_cfg where list like "'.$destid.',%" ';
				return $this ->db ->query($sql) ->result_array();
			}
			else
			{
				$sql = 'select * from u_dest_cfg where list like "%,'.$destid.',%" ';
				return $this ->db ->query($sql) ->result_array();
			}
		}
		else
		{
			return array();
		}
	}
	
	/**
	 * @method 获取目的地配置数据
	 * @param array $whereArr 搜索条件
	 */
	public function getDestCfgData($whereArr ,$orderBy='id asc')
	{
		$sql = 'select cfg.*,p.name as parent_name,d.kindname from u_dest_cfg as cfg left join u_dest_cfg as p on p.id=cfg.pid left join u_dest_base as d on d.id=cfg.dest_id';
		$sql .= $this ->getWhereStr($whereArr).' order by '.$orderBy.$this->getLimitStr();
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取目的地配置总数
	 * @param array $whereArr 搜索条件
	 */
	public function getDestNum($whereArr)
	{
		$sql = 'select count(*) as count from u_dest_cfg as cfg left join u_dest_cfg as p on p.id=cfg.pid left join u_dest_base as d on d.id=cfg.dest_id';
		$sql .= $this ->getWhereStr($whereArr);
		$countArr = $this ->db ->query($sql) ->row_array();
		return $countArr['count'];
	}
	
	/**
	 * @method 添加目的地配置
	 * @param array $dataArr 目的地数据
	 */
	public function add($dataArr ,$list)
	{
		$this->db->trans_start();
	
		$this ->db ->insert('u_dest_cfg' ,$dataArr);
		$id = $this ->db ->insert_id();
	
		//更新目的地的list字段
		$updateArr = array(
				'list' =>$dataArr['list'].$id .','
		);
		$this ->db ->where('id' ,$id) ->update('u_dest_cfg' ,$updateArr);
	
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}