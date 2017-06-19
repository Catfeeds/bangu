<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_line_attr_model extends MY_Model {
	private $table_name = 'u_line_attr';
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * @method 获取目的地数据，用于平台目的地管理
	 * @since  2016-01-19
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getLineAttrData(array $whereArr)
	{
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			if ($key == 'pid')
			{
				$whereStr .= ' (a.id = '.$val.' or a.pid = '.$val.') and';
			}
			else
			{
				$whereStr .= ' '.$key.'"'.$val.'" and';
			}
		}
		$whereStr = empty($whereStr) ? '' : ' where '.rtrim($whereStr ,'and');
		$sql = 'select a.*,la.attrname as parent from u_line_attr as a left join u_line_attr as la on a.pid = la.id '.$whereStr;
		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by a.id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
	/**
	 * 贾开荣
	 * 查询线路属性
	 * @param unknown $whereArr   查询条件     	
	 * @param number $page        当前页	
	 * @param number $num         每页条数
	 * @param unknown $like       模糊搜索条件
	 */
	public function get_line_attr_list($whereArr, $page = 1, $num = 10, $like = array()) {
		$datafield = "*";
		$this->db->select ( $datafield );
		$this->db->from ( $this->table_name );
		
		$this->db->where ( $whereArr );
		$this->db->order_by ( "id", "desc" );
		$num = empty ( $num ) ? 10 : $num;
		$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
		$this->db->limit ( $num, $offset );
		if (! empty ( $like ) && is_array ( $like )) {
			foreach ( $like as $key => $val ) {
				$this->db->or_like ( $key, $val );
			}
		}
		$query = $this->db->get ();
		// echo $this ->db ->last_query();exit;
		
		return $query->result_array ();
	}
	/**
	 * 查询总条数
	 * @param unknown $whereArr
	 * @param unknown $like
	 */
	public function num_rows_total($whereArr, $like = array()) {
		$datafield = "id";
		$this->db->select ( $datafield );
		$this->db->from ( $this->table_name );
		
		$this->db->where ( $whereArr );
		if (! empty ( $like ) && is_array ( $like )) {
			foreach ( $like as $key => $val ) {
				$this->db->or_like ( $key, $val );
			}
		}
		$query = $this->db->get ();
		return $query->num_rows ();
	}
	public function getLineattrTreeDate(){
		$query = $this->db->query('SELECT id,attrname AS name,pid FROM u_line_attr ORDER BY pid');
		$rows = $query->result_array();
		$treeStr = "[";
		$this->getJsonTree($treeStr,$rows,0,1,0);
		$treeStr=$treeStr."]";
		return $treeStr;
	}
	
	/**
	 * 获取目的地
	 * @param string $ids 数组IDS
	 * @return string
	 */
	public function getLineattr($ids = null){
	
		if(null!=$ids){
			$sql = 'SELECT id,attrname AS name,pid FROM u_line_attr WHERE id!=0 ';
			$sql.=" AND id IN (";
			$i=0;
			foreach($ids as $v){
				if(!empty($v)){
					if($i>0){
						$sql.=',';
					}
					$sql.=$v;
					$i++;
				}
	
			}
			$sql.=" ) ORDER BY displayorder ";
			$query = $this->db->query($sql,$ids);
			$rows = $query->result_array();
		}
		return $rows;
	}
}