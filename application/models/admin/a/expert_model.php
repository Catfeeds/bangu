<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Expert_model extends MY_Model {

	private $table_name = 'u_expert';
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	/**
	 * 获取满足条件的所有管家
	 * @param array $whereArr 查询条件
	 */
	public function getAllExpert($whereArr ,$orderBy='id desc')
	{
		$sql = 'select id,realname,nickname from u_expert'.$this->getWhereStr($whereArr).' order by '.$orderBy;
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * 解绑管家的供应商
	 * @param unknown $expert_id
	 * @param string $applyIds 管家申请线路通过状态下的ID组
	 */
	public function relieveSupplier($expert_id ,$applyIds)
	{
		$this->db->trans_start();
		$time = date('Y-m-d H:i:s' ,time());
		
		$dataArr = array(
				'supplier_id' =>0
		);
		$this ->db ->where('id',$expert_id) ->update('u_expert' ,$dataArr);
		
		//将管家申请的供应商线路，通过状态下的，改为4
		if (!empty($applyIds))
		{
			$time = date('Y-m-d H:i:s' ,time());
			$sql = 'update u_line_apply set status=4,modtime="'.$time.'" where id in ('.$applyIds.')';
			$this ->db ->query($sql);
		}
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * 给管家绑定供应商
	 * @param unknown $expert_id 管家ID
	 * @param unknown $supplier_id 供应商ID
	 * @param unknown $insertArr 需要写入管家申请线路表的线路ID
	 * @param unknown $updateArr 需要修改的管家申请表记录，状态改为2
	 */
	public function bindSupplier($expert_id ,$supplier_id ,$insertArr ,$updateArr)
	{
		$this->db->trans_start();
		$time = date('Y-m-d H:i:s' ,time());
		
		$dataArr = array(
				'supplier_id' =>$supplier_id
		);
		$this ->db ->where('id',$expert_id) ->update('u_expert' ,$dataArr);
		
		if (!empty($insertArr))
		{
			$sql = 'insert into u_line_apply(grade,addtime,modtime,line_id,expert_id,status) values';
			foreach($insertArr as $v)
			{
				$sql .= "(1,'$time','$time',{$v['id']},$expert_id ,2),";
			}
			$this ->db ->query(trim($sql ,','));
		}
		
		if (!empty($updateArr))
		{
			$idStr = '';
			foreach($updateArr as $v)
			{
				$idStr .= $v.',';
			}
			$sql = 'update u_line_apply set status=2,modtime="'.$time.'" where id in ('.rtrim($idStr,',').')';
			$this ->db ->query($sql);
		}
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * 修改管家资料
	 * @param unknown $id 管家ID
	 * @param unknown $expertArr 修改的基本信息
	 * @param unknown $resumeArr 从业经历
	 */
	public function edit_expert($id ,$expertArr ,$resumeArr)
	{
		$this->db->trans_start();
		$this ->db ->where('id',$id) ->update('u_expert' ,$expertArr);
		
		//删除原来的从业经历
		$this ->db ->where('expert_id' ,$id) ->delete('u_expert_resume');
		
		foreach($resumeArr as $v)
		{
			$this ->db ->insert('u_expert_resume' ,$v);
		}
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * @method 修改收藏虚拟值
	 * @param unknown $expertId 管家ID
	 * @param unknown $num 收藏虚拟值
	 */
	public function vrNum($expertId ,$num)
	{
		$this->db->trans_start();
		
		//查询附属记录是否存在
		$sql = 'select * from u_expert_affiliated where expert_id='.$expertId;
		$affiliated = $this ->db ->query($sql) ->row_array();
		if (empty($affiliated))
		{
			//没有记录附属信息，则写入
			$dataArr = array(
					'expert_id' =>$expertId,
					'collect_num_vr' =>$num
			);
			$this ->db ->insert('u_expert_affiliated' ,$dataArr);
		}
		else
		{
			$dataArr = array(
					'collect_num_vr' =>$num
			);
			$this ->db ->where('id' ,$affiliated['id']) ->update('u_expert_affiliated' ,$dataArr);
		}
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * @method 管家资料不全，平台发起资料修改
	 * @param unknown $expertId
	 * @param unknown $reason
	 */
	public function editInfo($expertId ,$reason)
	{
		$this->db->trans_start();
		
		//更改管家状态
		$dataArr = array(
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'status' =>5
		);
		$this ->db ->where('id' ,$expertId) ->update('u_expert' ,$dataArr);
		
		//记录原因到附属表
		$sql = 'select * from u_expert_affiliated where expert_id='.$expertId;
		$affiliated = $this ->db ->query($sql) ->row_array();
		if (empty($affiliated))
		{
			//没有记录附属信息，则写入
			$dataArr = array(
					'expert_id' =>$expertId,
					'reason' =>$reason
			);
			$this ->db ->insert('u_expert_affiliated' ,$dataArr);
		}
		else 
		{
			$dataArr = array(
					'reason' =>$reason
			);
			$this ->db ->where('id' ,$affiliated['id']) ->update('u_expert_affiliated' ,$dataArr);
		}
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	/**
	 * @method 获取管家数量
	 * @param unknown $status
	 */
	public function getExpertCount($status) 
	{
		$sql = 'select count(*) as count from u_expert where status = '.$status;
		$countArr = $this ->db ->query($sql) ->result_array();
		return $countArr[0]['count'];
	}
	/**
	 * @method 获取某个手机号的数据，除去已拒绝的
	 * @author jiakairong
	 * @param unknown $mobile
	 */
	public function getMobileUnique($mobile) {
		$sql = 'select id,status from u_expert where (mobile="'.$mobile.'" or login_name="'.$mobile.'") and status !=3';
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取某个手机号的数据，除去已拒绝的
	 * @author jiakairong
	 * @param unknown $mobile
	 */
	public function getEmailUnique($email) {
		$sql = 'select id,status from u_expert where email = "'.$email.'" and status !=3';
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取某个手机号的数据，除去已拒绝的和审核中的(用于管家审核)
	 * @author jiakairong
	 * @param unknown $mobile
	 */
	public function getMobileUniqueNo($mobile ,$id) {
		$sql = 'select id,status from u_expert where (mobile="'.$mobile.'" or login_name="'.$mobile.'") and status =2';
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取某个手机号的数据，除去已拒绝的和审核中的(用于管家审核)
	 * @author jiakairong
	 * @param unknown $mobile
	 */
	public function getEmailUniqueNo($email ,$id) {
		$sql = 'select id,status from u_expert where email = "'.$email.'" and status !=3 and status != 1 and id !='.$id;
		return $this ->db ->query($sql) ->result_array();
	}

	/**
	 * @method 获取专家数据
	 * @author jiakairong
	 * @param array $whereArr
	 */
	public function getExpertData (array $whereArr ,$orderBy = 'e.id' ,$type=false)
	{
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		$whereStr = empty($whereStr) ? '' : ' where '.rtrim($whereStr ,'and');
		$sql = 'select ua.realname as username,e.modtime,e.union_name,e.realname,e.city,e.idcard,e.nickname,e.is_commit,e.email,e.mobile,e.id,e.supplier_id,pd.name as pd_name,cid.name as cid_name,rd.name as rd_name,e.addtime,s.company_name,(select count(*) from u_line_apply as la left join u_line as l on l.id=la.line_id where la.expert_id = e.id and l.producttype=0 and la.status=2) as apply_num from u_expert as e left join u_area as pd on pd.id=e.province left join u_area as cid on cid.id=e.city left join u_area as rd on rd.id=e.region left join u_admin as ua on ua.id=e.admin_id left join u_supplier as s on s.id=e.supplier_id '.$whereStr;
		if ($type == false)
		{
			$data['count'] = $this ->getCount($sql, array());
			$data['data'] = $this ->db ->query($sql.' order by '.$orderBy.' desc '.$this ->getLimitStr()) ->result_array();
			return $data;
		}
		else 
		{
			return $this ->db ->query($sql.' order by '.$orderBy.' desc ') ->result_array();
		}
		
	}

	/**
	 * @method 获取专家数据(用于管家配置)
	 * @author 贾开荣
	 * @param array $whereArr
	 * @param number $page
	 * @param number $num
	 * @param array  $keywordArr 关键字搜索
	 */
	public function getExpertCfgData (array $whereArr ,$page = 1, $num = 10 ,$keywordArr = array()) {
		$this ->db ->select ( 'e.realname,e.id,e.nickname,e.small_photo,a.name as cityname' );
		$this ->db ->from ( $this->table_name .' as e');
		$this ->db ->join ('u_area as a' ,'a.id = e.city' ,'left');
		$this ->db ->where ( $whereArr );
	
		if (! empty ( $keywordArr ) && is_array ( $keywordArr )) {
			foreach ( $keywordArr as $key => $val ) {
				$this->db->or_like ( $key, $val );
			}
		}
		$this->db->order_by ( 'id', "desc" );
		if ($page > 0) {
			$num = empty ( $num ) ? 10 : $num;
			$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
			$this->db->limit ( $num, $offset );
		}
		return $this->db->get ()->result_array ();
	}

	/**
	 * @method 获取管家数据(关联目的地)
	 * @author zyf
	 * @param array $whereArr
	 * @param number $page
	 * @param number $num
	 * @param array  $keywordArr 关键字搜索
	 */
	public function getExpertsCfgData ($page = 1, $num = 10 ,$keywordArr = array()) {
		
		$where=" WHERE e.status=2";
		
		if (! empty ( $keywordArr ) && is_array ( $keywordArr )) {
			$where .= " and realname like '%".$keywordArr['realname']."%' or nickname like '%".$keywordArr['realname']."%' ";	
		}
		$order = " ORDER BY id DESC ";
		$sql="SELECT e.realname,e.id,e.nickname,e.small_photo,a.name as cityname FROM ".$this->table_name." as e left join u_area as a on a.id =e.city".$where.$order ;
		if ($page > 0) {
			$num = empty ( $num ) ? 10 : $num;
			$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
			$sql .= " limit  $offset,$num ";
		}
		return $this->db->query ($sql)->result_array ();
	}
	
	/**
	 * @method 获取管家详情
	 * @author jiakairong
	 */
	public function getExpertDetail($id)
	{
		$sql = 'select e.*,ca.name as ca_name,pa.name as pa_name,cia.name as cia_name,ra.name as ra_name from u_expert as e left join u_area as ca on ca.id = e.country left join u_area as pa on pa.id = e.province left join u_area as cia on cia.id = e.city left join u_area as ra on ra.id = e.region where e.id ='.$id;
		return $this ->db ->query($sql) ->result_array();
	}

	/**
	 * @method 获取专家售卖线路
	 * @param array $whereArr 查询条件
	 * @param number $page 当前页
	 * @param number $num  每页条数
	 */
	public function getExpertApplyLine(array $whereArr) {
		$whereStr = '';
		foreach($whereArr as $key =>$val)
		{
			$whereStr .= ' '.$key.'"'.$val.'" and';
		}
		$whereStr = empty($whereStr) ? '' : ' where '.rtrim($whereStr ,'and');

		$sql = 'select la.grade,l.linename,l.status,l.lineprice,l.linecode,l.agent_rate,l.satisfyscore,s.company_name,s.realname,(select count(c.id) from u_comment as c left join u_member_order as mo on mo.id = c.orderid where c.expert_id = la.expert_id and mo.productautoid = l.id) as comment,(select count(mor.id) from u_member_order as mor where mor.productautoid = l.id) as sales from u_line_apply as la left join u_line as l on la.line_id = l.id left join u_supplier as s on l.supplier_id = s.id '.$whereStr;

		$data['count'] = $this ->getCount($sql, array());
		$data['data'] = $this ->db ->query($sql.' order by la.id desc '.$this ->getLimitStr()) ->result_array();
		return $data;
	}
	/**
	 * @method 获取某个管家的合作商家
	 * @author jiakairong
	 * @param number $expert_id 管家ID
	 */
	public function get_expert_supplier($expert_id) {
		$sql = "select s.realname,s.id,s.company_name,la.expert_id from u_line_apply as la left join u_line as l on la.line_id = l.id left join u_supplier as s on s.id = l.supplier_id where la.expert_id = {$expert_id} and s.status = 2 and l.status = 2 group by s.id";
		$query = $this ->db ->query($sql);
		return $query ->result_array();
	}

	/**
	 * [get_complain_list 获取投诉列表]
	 *
	 * @param [type] $whereArr
	 *        	查询条件
	 * @param integer $page
	 *        	每一页的记录条数
	 * @param integer $num
	 * @return array $Result [description]
	 */
	public function get_complain_list($whereArr, $page = 1, $num = 10) {
		$this->db->select ( "c.user_name AS 'complainant',c.attachment ,c.addtime AS 'complainTime',c.reason AS 'content',
				      mo.productname AS 'product',mo.expert_name AS 'expert',c.status AS 'status',
				      mo.supplier_name AS 'supplier',c.mobile AS 'phone',c.id as cid,c.remark,c.complain_type" );
		$this->db->from ( 'u_complain AS c' );
		$this->db->join ( 'u_member_order AS mo', 'c.order_id=mo.id', 'INNER' );
 
		$this->db->where ( $whereArr );

		if ($page > 0) {
			$offset = ($page - 1) * $num;
			$this->db->limit ( $num, $offset );
		}
		$this->db->order_by('c.addtime desc');
		$query = $this->db->get ();
		$result = array ();
		$result = $query->result_array ();
		array_walk ( $result, array (
				$this,
				'_fetch_list'
		) );
		return $result;
	}
	protected function _fetch_list(&$value, $key) {
		switch ($value ['status']) {

			case '0' :
				$value ['status'] = '待处理';
				break;
			case '1' :
				$value ['status'] = '已处理';
				break;
			default :
				$value ['status'] = '';
				break;
		}
		if(isset($value['complain_type'])){
			switch ($value ['complain_type']) {

			case '1' :
				$value ['complain_type'] = '专家';
				break;
			case '2' :
				$value ['complain_type'] = '供应商';
				break;
			default :
				$value ['complain_type'] = '供应商,专家';
				break;
			}
		}
	}
	/**
	 * @method 获取管家提现数据
	 * @author jiakairong
	 * @param unknown $whereArr
	 * @param number $page
	 * @param number $num
	 * @param unknown $likeArr
	 */
	function get_exchange_data($whereArr ,$page = 1,$num = 10, $likeArr = array(),$order_by = 'ec.id') {
		$this ->db ->select('ec.*,e.realname,a.username');
		$this ->db ->from('u_exchange as ec');
		$this ->db ->join('u_admin as a' ,'a.id = ec.admin_id' ,'left');
		$this ->db ->join('u_expert as e','ec.userid = e.id');
		$this ->db ->where($whereArr);
		$this ->db ->order_by($order_by ,'desc');
		if (! empty ( $likeArr ) && is_array ( $likeArr )) {
			foreach ( $likeArr as $key => $val ) {
				$this->db->or_like ( $key, $val );
			}
		}
		if ($page > 0) {
			$num = empty ( $num ) ? 10 : $num;
			$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
			$this->db->limit ( $num, $offset );
		}
		return $this ->db ->get() ->result_array();
	}

	/**
	 * 获得提现管理的数据
	 */
	function get_new_apply_data($whereArr, $page = 1, $num = 10, $like = array()) {
		$this->db->select ( "ec.id,ec.ADDTIME AS apply_date,
				ec.serial_number AS serial_number,
				ec.bankname AS bankname,
				ec.amount_before AS amount_before,
				ec.amount AS apply_amount,ec.cardholder AS expert_name" );
		$whereArr ['ec.is_remit'] = 0;
		$this->db->from ( "u_exchange AS ec" );
		$this->db->where ( $whereArr );
		$this->db->order_by ( "addtime", "desc" );
		
		
		 
		
		
		
		if (! empty ( $like ) && is_array ( $like )) {
			foreach ( $like as $key => $val ) {
				$this->db->or_like ( $key, $val );
			}
		}
		if ($page > 0) {
			$offset = ($page - 1) * $num;
			$this->db->limit ( $num, $offset );
		}
		$result = $this->db->get ()->result_array ();
		return $result;
	}

	/**
	 * *获取已经审核通过/已经拒绝的数据
	 */
	function get_pass_or_refused_data($whereArr, $page = 1, $num = 10, $is_remit = 1, $like = array()) {
		$this->db->select ( "ec.id,ec.ADDTIME AS apply_date,
				ec.serial_number AS serial_number,
				ec.bankname AS bankname,
				ad.realname AS operator,
				ec.amount_before AS amount_before,
				ec.amount AS apply_amount,ec.cardholder AS expert_name,modtime" );
		$whereArr ['ec.is_remit'] = $is_remit;
		$this->db->from ( "u_exchange AS ec" );
		$this->db->join ( 'u_admin AS ad', 'ec.admin_id = ad.id', 'left' );
		$this->db->where ( $whereArr );
		$this->db->order_by ( "modtime", "desc" );
		if (! empty ( $like ) && is_array ( $like )) {
			foreach ( $like as $key => $val ) {
				$this->db->or_like ( $key, $val );
			}
		}
		if ($page > 0) {
			$offset = ($page - 1) * $num;
			$this->db->limit ( $num, $offset );
		}
		$result = $this->db->get ()->result_array ();
		// print_r(count($result));exit();
		return $result;
	}

	/**
	 * 获取搜索条件
	 */
	function get_search_condition($expert_name, $apply_date) {
		$where = array ();

		return $where;
	}

	/**
	 * @method 定制单数据获取
	 * @author jiakaiorng
	 * @param unknown $whereArr
	 * @param number $page
	 * @param number $num
	 * @param unknown $likeArr
	 */
	 
 
	 
	public function get_customized_data ($whereArr ,$page = 1, $num = 10 ,$likeArr = array()) {
		$datafield = "id,startdate,startplace,endplace,budget,days,people,service_range,other_service,linkname,linkphone";
		$this->db->select ( $datafield );
		$this->db->from ( "u_customize" );
		$this->db->where ( $whereArr );
		if (! empty ( $likeArr ) && is_array ( $likeArr )) {
			foreach ( $likeArr as $key => $val ) {
				$this->db->or_like ( $key, $val );
			}
		}
		$this->db->order_by ( "id", "desc" );
		if ($page > 0) {
			$num = empty ( $num ) ? 10 : $num;
			$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
			$this->db->limit ( $num, $offset );
		}
		$query = $this->db->get ();
		return $query->result_array ();
	}
	
	/**
	 * @method 获取定制单详细
	 * @author jiakairong
	 */
	public function get_one_customized($whereArr = array()) {
		 $reDataArr =$this->db->query ("SELECT `c`.`id`, `c`.`startdate`, `c`.`startplace`, (select GROUP_CONCAT(kindname) from u_dest_base where FIND_IN_SET(id, endplace)>0) as endplace, `c`.`budget`,`e`.`realname`,`s`.`company_name`,`c`.`days`,`c`.`people`, `c`.`service_range`, `c`.`linkname`, `c`.`linkphone`, `c`.`isshopping`,`c`.`hotelstar`, `c`.`hotelstar`,`c`.`catering`,c.trip_way, `c`.`grabcount` as grab, (SELECT COUNT(*) FROM u_customize_answer AS ca where ca.customize_id = c.id) AS reply FROM (`u_customize` AS c) LEFT JOIN `u_enquiry` as eq ON `eq`.`customize_id` = `c`.`id` and eq.expert_id = c.expert_id LEFT JOIN `u_expert` as e ON `e`.`id` = `c`.`expert_id` LEFT JOIN `u_enquiry_grab` as eg ON `eg`.`enquiry_id` = `eq`.`id` LEFT JOIN `u_supplier` as s ON `s`.`id` = `eg`.`supplier_id` where {$whereArr}")->result_array ();
		return $reDataArr;
	}
	/**
	 * @method 获取管家申请照相的数据
	 * @author xml
	 */
	public function get_expert_museum($param,$page){	
		$query_sql='';
		$query_sql.=' SELECT em.museum_id,em.qrcode,em.addtime,m.name,m.address,m.linkman,m.linkmobile,m.price,e.realname,e.mobile,e.idcard,e.email ';
		$query_sql.=' FROM u_expert_museum as em LEFT JOIN u_expert as e on e.id=em.expert_id ';
		$query_sql.=' LEFT JOIN u_museum as m on m.id=em.museum_id ';
		$query_sql.=' LEFT JOIN u_expert_qrcode as eq on em.id=eq.expert_museum_id ';
		if($param!=null){
			if(null!=array_key_exists('status', $param)){
				$query_sql.=' where eq.status = ? ';
				$param['status'] = $param['status'];
			}
			if(null!=array_key_exists('realname', $param)){
				$query_sql.=' AND e.realname  like ? ';
				$param['realname'] = '%'.$param['realname'].'%';
			}
		}
		$query_sql.=' ORDER BY em.addtime desc';
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
	
}