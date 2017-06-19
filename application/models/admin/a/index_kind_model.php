<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_kind_model extends MY_Model
{
	private $table_name = 'cfg_index_kind';
	public function __construct()
	{
		parent::__construct ( $this->table_name );
	}

	/**
	 * @method 获取首页分类
	 * @author 贾开荣
	 * @since  2015-06-11
	 * @param array $whereArr 查询条件
	 */
	public function getIndexKindData(array $whereArr=array())
	{
		$sql = 'select k.*,d.kindname from cfg_index_kind as k left join u_dest_base as d on d.id=k.dest_id';
		return $this ->getCommonData($sql ,$whereArr ,'k.id desc');
	}
}