<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Dest_base_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct ( 'u_dest_base' );
	}
	
	/**
	 * 获取目的地
	 * @author jkr
	 */
	public function getDestData($whereArr)
	{
		$sql = $sql = 'select * from u_dest_base'.$this ->getWhereStr($whereArr);
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取自己以及其上级
	 * @param unknown $id
	 */
	public function getDestPdata($id)
	{
		$sql = 'select d.kindname,(select p.kindname from u_dest_base as p where p.id=d.pid) as pname from u_dest_base as d where d.id='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取周边游数据
	 * @author jkr
	 */
	public function getTripDestBase($whereArr)
	{
		$sql = 'select d.kindname as name,d.simplename,d.enname,3 as pId,d.id,d.list from cfg_round_trip as cfg left join u_dest_base as d on cfg.neighbor_id=d.id '.$this ->getWhereStr($whereArr);
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取所有目的地
	 * @author jkr
	 * @param array $whereArr 搜索条件(搜索形式参考MY_Model中的getWhereStr方法)
	 */
	public function getDestBaseAll($whereArr=array())
	{
		$sql = 'select kindname as name,level,simplename,enname,list,pid as pId,id,"false" as open from u_dest_base'.$this ->getWhereStr($whereArr);
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取所有目的地
	 * @author jkr
	 * @param array $whereArr 搜索条件
	 */
	public function getDestBaseAllData($whereArr)
	{
		$sql = 'select id,kindname as name,simplename,enname,list,pid,ishot,level from u_dest_base'.$this ->getWhereStr($whereArr);
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 通过目的地名称，获取目的地的上级和自己
	 * @author jkr
	 * @param array $whereArr 搜索条件(不包括目的地名称)
	 * @param string $name 目的地名称
	 */
	public function getNameSearchDest($whereArr ,$name)
	{
		$sql = 'select * from u_dest_base where kindname like "%'.$name.'%"';
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
			$sql = 'select kindname as name,simplename,enname,list,pid as pId,id,"true" as open from u_dest_base '.$whereStr;
			return $this ->db ->query($sql) ->result_array();
		}
	}
	
	/**
	 * @method 获取目的地的下级
	 * @author jkr
	 * @param intval $destid 目的地ID
	 */
	public function getLowerData($destid)
	{
		//先判断是否是顶级
		$sql = 'select * from u_dest_base where id ='.$destid;
		$destData = $this ->db ->query($sql) ->row_array();
		if (!empty($destData))
		{
			if ($destData['level'] == 1)
			{
				$sql = 'select * from u_dest_base where list like "'.$destid.',%" ';
				return $this ->db ->query($sql) ->result_array();
			}
			else 
			{
				$sql = 'select * from u_dest_base where list like "%,'.$destid.',%" ';
				return $this ->db ->query($sql) ->result_array();
			}
		}
		else
		{
			return array();
		}
	}
	
	/**
	 * @method 获取目的地数据，用于平台目的地管理
	 * @param array $whereArr 搜索条件
	 */
	public function getDestBaseData($whereArr ,$orderBy='id asc')
	{
		$sql = 'select d.*,p.kindname as parent_name from u_dest_base as d left join u_dest_base as p on p.id=d.pid ';
		$sql .= $this ->getWhereStr($whereArr).' order by '.$orderBy.$this->getLimitStr();
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取目的地总数
	 * @param array $whereArr 搜索条件
	 */
	public function getDestNum($whereArr)
	{
		$sql = 'select count(*) as count from u_dest_base as d left join u_dest_base as p on p.id=d.pid ';
		$sql .= $this ->getWhereStr($whereArr);
		$countArr = $this ->db ->query($sql) ->row_array();
		return $countArr['count'];
	}
	
	/**
	 * @method 获取周边游目的地
	 * @author xml
	 * @param array $whereArr 搜索条件
	 */
	public function getZLDestBaseAll($whereArr=array())
	{
		$sql = "select kindname as name,simplename,enname,pid as pId,id,'dest' as type from u_dest_base".$whereArr;
		$data= $this ->db ->query($sql) ->result_array();
		return $data;
	}
	//$sql = 'select id,kindname as name,enname,simplename,level,ishot,pid from u_dest_base where id in ('.$destids.') and level=3';
	//return $this ->db ->query($sql) ->result_array();
	
	/**
	 * @method 添加目的地
	 * @param array $dataArr 目的地数据
	 */
	public function add($dataArr)
	{
		$this->db->trans_start();
		
		$this ->db ->insert('u_dest_base' ,$dataArr);
		$id = $this ->db ->insert_id();
		
		//更新目的地的list字段
		$updateArr = array(
				'list' =>trim($dataArr['list'],',').','.$id .','
		);
		$this ->db ->where('id' ,$id) ->update('u_dest_base' ,$updateArr);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}