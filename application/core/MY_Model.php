<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 数据库CRUD操作扩展(models)
 * Model.php
 * ============================================================
 * 简化数据库CRUD基本功能操作
 * ============================================================
 * v1.0.1
 * @author hejun(2511906352@qq.com)
 */
class MY_Model extends CI_Model
{
	protected $table;//当前操作的data table
	/**
	 *	构造函数
	 *  $table:数据表
	 */
	function __construct($table = '',$database = 'default')
	{
		parent::__construct();
		date_default_timezone_set('Asia/Shanghai');
		$this->table = $table;
	}
	
	public function escapeJsonString($value) {
		$escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
		$replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
		$result = str_replace($escapers, $replacements, $value);
		return $result;
	}
	
	/**
	 * @param unknown $jsonData 构造的JSON数据
	 * @param unknown $rows 原始记录
	 * @param unknown $pid  父ID
	 * @param unknown $level 递归到第几层
	 * @param unknown $idx  当前层级的行数
	 * @return string
	 */
	protected function getJsonTree(& $jsonData,$rows,$pid,$level,$idx){
		if($pid==0){
			$level=0;
		}else{
			$jsonData=$jsonData.",\"childs\":[";
			$level = $level+1;
		}
		foreach ($rows as $key=>$row){
			if($pid==$row["pid"])
			{
				$cpid = $row["id"];
				if($idx!=0){
					$jsonData=$jsonData.",";
				}
				$jsonData=$jsonData."{";
				$jsonData=$jsonData."\"id\":".$row["id"];
				$jsonData=$jsonData.",\"name\":\"".$row["name"]."\"";
				$jsonData=$jsonData.",\"pid\":".$row["pid"];
				unset($rows[$key]);
				$this->getJsonTree($jsonData,$rows,$cpid,$idx,0);
				$hasChild = true;
				$idx++;
			}
		}
		if($pid!=0){
			$jsonData=$jsonData."]";
			$jsonData=$jsonData."}";
		}
		return $jsonData;
	}
	/**
	 * @abstract 环境判断:sphinx
	 * 若是本地环境，即加载SphinxClient客户端类
	 * */
	protected function environment_sphinx() 
	{
		//$_SERVER["SERVER_NAME"]、gethostbyname($_SERVER["SERVER_NAME"])
		if(!in_array($_SERVER["SERVER_NAME"],array('192.168.10.202','t.w.1b1u.com','www.testbangu.com','120.25.217.197','51ubang.com','www.1b1u.com','test.1b1u.com')))
		{
			$this->load->library('SphinxClient');
		}
	}
	/**
	 * 获取总记录数里面不要带 LIMIT 1,1
	 * select * from a 
	 * 
	 * $sql = "select * from table a";
	 * getCount($sql)
	 * $sql+=" order by a.id desc  LIMIT 1,1";
	 * query($sql);
	 */
	function getCount($sql,$param){
		$query = $this->db->query("SELECT COUNT(*) AS num FROM (".$sql.") va", $param);
		$result = $query->result();
		$totalRecords = $result[0]->num;
		// 		echo $this->db->last_query();
		return $totalRecords;
	}
	
	/**
	 * JSON分页查询
	 * @param unknown $sql
	 * @param unknown $param
	 */
	function queryPageJson($sql,$param,$page,$type=0,$result=''){
// 		$query = $this->db->query("SELECT COUNT(*) AS num FROM (".$sql.") va", $param);
// 		echo "==============================================";
// 		$result = $query->result()[0];
// 		$totalRecords = $result->num;
		$totalRecords = $this->getCount($sql,$param);
// 		echo $totalRecords;
		$pageSize = $page->pageSize;
		$totalPages = ceil($totalRecords / $pageSize);// + ($totalRecords % $pageSize > 0 ? 1 : 0);
// 		echo "totalPages==".$totalPages."pageSize==".$pageSize."totalRecords==".$totalRecords."pageSize==".$pageSize . " %%==".$totalRecords % $pageSize;
		$pageNum = $page->pageNum;
		
		if ($pageNum > $totalPages){
			$pageNum = $totalPages;
		}
		if($pageNum==0){
			$pageNum=1;
		}
		$records = '{"totalRecords":"'.$totalRecords.'",';
		$records.= '"totalPages":"'.$totalPages.'",';
		$records.= '"pageNum":"'.$pageNum.'",';
		$records.= '"pageSize":"'.$pageSize.'",';
		if($type==1){
			$result =$result ;
		}else{

			$sql.=' LIMIT ?,?';
			if(null==$param){
				$param = array();
			}
			$param['start'] = ($pageNum-1) * $pageSize;
			$param['size'] = $pageSize;
			
			$query = $this->db->query($sql, $param);
			$result = $query->result();

		}
	
		$records.='"rows":[';
		$len = count($result);
		$f_len = 0;
		$f_idx = 0;//字段计数器
		$c_idx = 0;//行数计数器
		foreach($result as $row){
			$f_len = count($row);
			if($c_idx>0){
				$records.=',';
			}
			$records.='{';
			$f_idx = 0;
			foreach($row as $key=>$value){
				if($f_idx>0){
					$records.=',';
				}
				if(!empty($value)){   //过滤换行
					$html_string= array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
					$value = str_replace($html_string,"",$value);	
				}
				$records.='"'.$key.'":'.'"'.$value.'"';
				$f_idx++;
			}
			$records.='}';
			$c_idx++;
		}
		$records .= ']}';
		return $records;
	}
	
	/**
	 *	添加数据
	 *  $dataArr:(array)插入的数据
	 *  return:当前插入的数据id
	 */
	function insert($dataArr)
	{
		$this->db->insert($this->table, $dataArr);
		return $this->db->insert_id();
	}
	/**
	 *	修改数据
	 *  $dataArr:(array)更新的数据
	 *  $whereArr:(array)更新的条件
	 *  return:更新的数据条数
	 */
	function update($dataArr, $whereArr)
	{
		$this->db->where($whereArr);
		return $this->db->update($this->table, $dataArr);
	}
	
	/**
	 *	删除数据
	 *  $whereArr:(array)删除的条件
	 *  return:删除的数据条数
	 */
	function delete($whereArr)
	{
		$this->db->where($whereArr);
		$this->db->delete($this->table); 
		return $this->db->affected_rows();
	}
	
	/**
	 *	查询并返回一条数据
	 *  $whereArr:(array)查询的条件
	 *  $type:返回结果类型，默认为obj格式，arr为数组格式
	 *  return:查询结果
	 */
	function row($whereArr, $type='arr', $orderby = "",$fieldsArr="")
	{
		if(!empty($fieldsArr)){
			if (is_array($fieldsArr))
			{
				foreach($fieldsArr as $key => $value)
				{
					$this->db->select($value, FALSE);
				}
			}else{				
				$this->db->select($fieldsArr);
			}
		}
		$this->db->where($whereArr);
		if(!empty($orderby)){
			$orderby = str_replace("@"," ",$orderby);
			$this->db->order_by($orderby);
		}
		$query = $this->db->get($this->table);
		if($type=='obj')return $query->row();
		elseif($type=='arr')return $query->row_array();
	}
	
	 /**
	 *	查询并返回多条数据
	 *  $whereArr:(array)查询的条件
	 *  $type:返回结果类型，默认为obj格式，arr为数组格式
	 *  $num:单页显示的条数
	 *  $page:当前页数
	 *  $orderby:排序条件
	 *  return:查询结果
	 */
	function result($whereArr, $page = 1, $num = 10, $orderby = "", $type='arr',$joinArr='',$fieldsArr="")
	{
		if(!empty($fieldsArr)){
			if (is_array($fieldsArr))
			{
				foreach($fieldsArr as $key => $value)
				{
					$this->db->select($value, FALSE);
				}
			}else{
				$this->db->select($fieldsArr);
			}
		}
		if($page==0) $page=1;
		$offset=($page-1)*$num;
		$this->db->where($whereArr);
		if(!empty($orderby)){
			$orderby = str_replace("@"," ",$orderby);
			$this->db->order_by($orderby);
		}
		if(!empty($joinArr)){
			$this->db->join($joinArr[0], $joinArr[1],$joinArr[2]);
		}
		$query = $this->db->get($this->table,$num,$offset);
		if($type=='obj')return $query->result();
		elseif($type=='arr')return $query->result_array();
	}
	
	/**
	 *	查询并返回所有数据
	 *  $whereArr:(array)查询的条件
	 *  $type:返回结果类型，默认为obj格式，arr为数组格式
	 *  $orderby:排序条件
	 *  return:查询结果
	 */
	function all($whereArr=array(), $orderby = "", $type='arr',$fieldsArr="")
	{
		if(!empty($fieldsArr)){
			if (is_array($fieldsArr))
			{
				foreach($fieldsArr as $key => $value)
				{
					$this->db->select($value, FALSE);
				}
			}else{
				$this->db->select($fieldsArr);
			}
		}
		$this->db->where($whereArr);
		if(!empty($orderby)){
			$orderby = str_replace("@"," ",$orderby);
			$this->db->order_by($orderby);
		}
		$query = $this->db->get($this->table);
		if($type=='obj')return $query->result();
		elseif($type=='arr')return $query->result_array();
	}
	
	/**
	 *	查询数据条数
	 *  $whereArr:(array)查询的条件
	 *  return:查询结果数据条数
	 */
	function num_rows($whereArr,$joinArr='')
	{		
		$this->db->where($whereArr);
		if(!empty($joinArr)){
			$this->db->join($joinArr[0], $joinArr[1],$joinArr[2]);
		}
		$query = $this->db->get($this->table);
		return $query->num_rows();
	}
	
	/**
	 * @method 获取limit字符串
	 * @author jiakairong
	 * @since  2015-12-17
	 */
	public function getLimitStr()
	{
		$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
		$page = empty($page) ? 1 : $page;
		$pageSize = isset($_REQUEST['pageSize']) ? intval($_REQUEST['pageSize']) : 10;
		$pageSize = empty($pageSize) ? 10 : $pageSize;
		return ' limit '.($page-1)*$pageSize.','.$pageSize;
	}
	/**
	 * @method 获取数据和总条数
	 * @param unknown $sql 查询的sql语句，没有带条件部分
	 * @param array $whereArr 查询的条件，数组形式
	 * @param string $orderBy 排序  例：   id desc
	 * @param string $sqlWhere 特殊查询条件 如：find_in_set
	 */
	public function getCommonData($sql ,array $whereArr = array() ,$orderBy='' ,$groupBy = '' ,$sqlWhere='' ,$num=false)
	{
		$whereStr = '';
		if (!empty($whereArr))
		{
			foreach($whereArr as $key=>$val)
			{
				if (is_array($val)) {
					$w = ' (';
					foreach($val as $i) {
						$w .= ' '.$key.'='.$i.' or';
					}
					$whereStr .= rtrim($w ,'or'). ') and';
				} else {
					$lastStr = substr($val ,-1);
					if ($lastStr == ')') {
						$whereStr .= ' '.$key.'"'.substr($val,0,-1).'") and';
					} else {
						$whereStr .= ' '.$key.'"'.$val.'" and';
					}
					
				}
			}
			$whereStr = empty($whereStr) ? '' : ' where '.rtrim($whereStr ,'and');
		}
		if (!empty($sqlWhere))
		{
			if (empty($whereStr)) {
				$whereStr = ' where '.$sqlWhere;
			} else {
				$whereStr = $whereStr.' and '.$sqlWhere;
			}
		}
		$orderByStr = '';
		if (!empty($orderBy))
		{
			$orderByStr = ' order by '.$orderBy.' ';
		}
		$sql = $sql.$whereStr.' '.$groupBy.' ';
		
		if ($num == 'all') {
			//返回所有数据
			$data = $this ->db ->query($sql.$orderByStr) ->result_array();
		} else {
			$data['count'] = $this ->getCount($sql, array());
			$data['data'] = $this ->db ->query($sql.$orderByStr.$this ->getLimitStr()) ->result_array();
		}
		
		return $data;
	}
	/**
	 * @method 公用查询方法，返回查询的记录
	 * @param unknown $sql 查询的sql语句，没有带条件部分
	 * @param array $whereArr 查询的条件，数组形式
	 * @param string $orderBy 排序  例：   id desc
	 */
	public function queryCommon($sql ,array $whereArr ,$limitStr = '' ,$orderBy='' ,$groupBy = '')
	{
		$arr = $this ->analyticWhere($whereArr);
		$sql = $sql.$arr['whereStr'].' '.$groupBy.' '.$orderBy.' '.$limitStr;
		return $this ->db ->query($sql ,$arr['paramArr']) ->result_array();
	}
	/**
	 * @method 公用查询方法，返回一条查询的记录，亦可用于记录总数查询
	 * @param unknown $sql 查询的sql语句，没有带条件部分
	 * @param array $whereArr 查询的条件，数组形式
	 */
	public function queryCommonRow($sql ,array $whereArr ,$groupBy = '')
	{
		$arr = $this ->analyticWhere($whereArr);
		$sql = $sql.$arr['whereStr'].' '.$groupBy;
		return $this ->db ->query($sql ,$arr['paramArr']) ->row_array();
	}
	
	/**
	 * @method 解析where条件
	 * @param array $whereArr 查询的条件，数组形式
	 * 		  $whereArr = array(
	 * 				'field' =>'val',
	 * 				'field1' =>'val2'
	 * 				'like' =>array('field' =>'val%' ,'field1' =>'%val1%'), //like查询
	 * 				'in' =>array('field' =>array(1,2,3,4) ,'field' =>array(3,5,6)), // in查询
	 *
	 * 			);
	 */
	public function analyticWhere(array $whereArr)
	{
		$whereStr = '';
		$paramArr = array();
		if (!empty($whereArr))
		{
			foreach($whereArr as $key =>$val)
			{
				if (empty($val) && $val !== 0) {
					continue;
				}
				if ($key == 'in')
				{
					foreach($val as $k =>$item) {
						if (is_array($item)) {
							$whereStr .= ' '.$k.' in ? and';
							$paramArr[] = $item;
						}
					}
				}
				elseif ($key == 'like')
				{
					foreach($val as $k =>$item) {
						if (is_string($item)) {
							$whereStr .= ' '.$k.' like ? and';
							$paramArr[] = $item;
						}
					}
				}
				else
				{
					$whereStr .= ' '.$key.'= ? and';
					$paramArr[] = $val;
				}
			}
		}
		if (!empty($whereStr))
		{
			$whereStr = ' where '.rtrim($whereStr ,'and').' ';
		}
		return array(
				'whereStr' =>$whereStr,
				'paramArr' =>$paramArr
		);
	}
	/**
	 * sql过滤
	 * 参数: $data 数组或者变量
	 * 返回: 处理特殊字符后的原数组或者原变量
	 */
	private function ssl($str)
	{
		$farr = array(
				"/\\s+/",
				"/<(\\/?)(script|i?frame|style|html|body|title|link|meta|object|\\?|\\%)([^>]*?)>/isU",
				"/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",
		);
		$str = preg_replace($farr,"",$str);
		return addslashes($str);
	}
	function sql_check($array)
	{
	    if (is_array($array))
	    {
	        foreach($array AS $k => $v)
	        {
	            $array[$k] = $this->sql_check($v);
	        }
	    }
	    else
	    {
	        $array = $this->ssl($array);
	    }
	    return $array;
	}
	
/**
	 * @method 获取where条件的字符串
	 * @author jkr
	 * @param array $whereArr
	 * array(
	 * 		'field1 =' =>'value1',
	 * 		'field2 like ' =>'%value2%',
	 * 		'in' =>array(
	 * 			'field3' =>'2,3,4',
	 * 			'field6' =>'55,645'
	 * 		),
	 * 		'or' =>array(
	 * 			'field4 =' =>'value4',
	 * 			'field5 >=' =>'value5'
	 * 		),
	 * 		'or_like' =>array(
	 * 			'field4' =>'value4',
	 * 			'field5' =>'value5'
	 * 		),
	 * 		'find_in_set' =>array(
	 * 			'field6' =>array(1,2,3,4),
	 * 			'field7' =>array(34,56,67)
	 * 		),
	 * );
	 * @param string $specialSql 特殊的sql语句，如field is not null
	 */
	public function getWhereStr(array $whereArr ,$specialSql='')
	{
		$whereArr = $this ->sql_check($whereArr);
		$whereStr = ' ';
		if (!empty($whereArr))
		{
			$whereStr .= 'where ';
			foreach($whereArr as $k =>$v)
			{
				switch($k)
				{
					case 'find_in_set':
						foreach($v as $key =>$val)
						{
							$whereStr .= ' (';
							foreach($val as $i)
							{
								$whereStr .= " FIND_IN_SET( $i, $key) or";
							}
							$whereStr = rtrim($whereStr ,'or').') and';
						}
						break;
					case 'or': //or条件
						$whereStr .= ' (';
						foreach($v as $key =>$i)
						{
							$whereStr .= " $key $i or";
						}
						$whereStr = rtrim($whereStr ,'or').') and';
						break;
					case 'in': //in查询
						foreach($v as $key=>$val)
						{
							$whereStr .= " $key in ($val) and";
						}
						break;
					case 'or_like'://like的或者查询
						$whereStr .= ' (';
						foreach($v as $key=>$val)
						{
							$whereStr .= " $key like '%$val%' or";
						}
						$whereStr = rtrim($whereStr ,'or').') and';
						break;
					default:
						$whereStr .= " $k '$v' and";
						break;
				}
			}
		}
		return empty($specialSql) ? rtrim($whereStr ,'and') : $whereStr.' '.$specialSql.' ';
		//return rtrim($whereStr ,'and');
	}
}

include_once 'UB2_Model.php';
include_once 'APP_Model.php';
