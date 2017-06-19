<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_kind_dest_model extends MY_Model
{
	private $table_name = 'cfg_index_kind_dest';
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	/**
	 * @method 获取分类目的地
	 * @author 贾开荣
	 * @since  2015-06-11
	 * @param array $whereArr 查询条件
	 */
	public function getKindDestData(array $whereArr=array())
	{
		$sql = 'select ikd.*,ik.name as ikname,d.kindname,s.cityname from cfg_index_kind_dest as ikd left join cfg_index_kind as ik on ik.id = ikd.index_kind_id left join u_dest_base as d on d.id = ikd.dest_id left join u_startplace as s on s.id=ikd.startplaceid';
		return $this ->getCommonData($sql ,$whereArr ,'ikd.id desc');
	}
	/**
	 * @method 获取详细
	 * @author jiakairong
	 * @param unknown $id
	 */
	public function getKindDestDetail($id)
	{
		$sql = 'select i.*,s.pid as province,(select p.pid from u_startplace as p where p.id=s.pid) as country,d.level,d.pid as dest_province,(select c.pid from u_dest_base as c where c.id =d.pid) as dest_country from cfg_index_kind_dest as i left join u_startplace as s on s.id=i.startplaceid left join u_dest_base as d on d.id=i.dest_id where i.id ='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 通过出发城市获取首页分类目的地
	 * @author jiakairong
	 * @param unknown $startplaceid
	 */
	public function getStartKindDest($startplaceid)
	{
		$sql = 'select kd.*,k.name as kind_name from cfg_index_kind_dest as kd left join cfg_index_kind as k on k.id=kd.index_kind_id where kd.is_show =1 and k.is_show =1 and kd.startplaceid ='.$startplaceid;
		return $this ->db ->query($sql) ->result_array();
	}
	
	
	/**
	 * @method 获取所有的分类目的地，用于分类目的地线路的下拉选择
	 * @param unknown $whereArr
	 * @author jiakairong
	 * @since  2015-11-24
	 */
	public function getKindDestAll($whereArr)
	{
		$this ->db ->select('ikd.*,s.cityname');
		$this ->db ->from($this->table_name.' as ikd');
		$this ->db ->join('u_startplace as s','s.id = ikd.startplaceid' ,'left');
		$this ->db ->where($whereArr);
		return $this ->db ->get() ->result_array();
	}
}