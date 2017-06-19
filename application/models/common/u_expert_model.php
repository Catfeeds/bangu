<?php
/**
 * 管家模型
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_expert_model extends MY_Model {

	private $table_name = 'u_expert';

	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	/**
	 * @method 管家登录获取通过的管家数据
	 * @author jiakairong
	 * @since  2015-01-08
	 * @param unknown $login_name
	 */
	public function getExpertLogin($login_name)
	{
         $sql = 'select  * from u_expert where (login_name = "'.$login_name.'" or mobile="'.$login_name.'") and (status = 2 or union_status=1 or status=5) order by id desc';
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 管家登录获取最后一条管家数据
	 * @author jiakairong
	 * @since  2015-01-08
	 * @param unknown $login_name
	 */
	public function getExpertLoginNo($login_name)
	{
		$sql = 'select * from u_expert where login_name = "'.$login_name.'" or mobile="'.$login_name.'" or email="'.$login_name.'" order by id desc';
		return $this ->db ->query($sql) ->result_array();
	}
        /**
	 * @method 根据管家id获得管家的信息
	 * @author wwb
	 * @since  2017-01-05
	 * @param unknown $login_name
	 */
	public function getExpertById($id)
	{
		$sql = 'select 
                                 e.*,d.name as depart_name,u.union_name
                        from 
                                 u_expert as e
                                 left join b_depart as d on d.id=e.depart_id
                                 left join b_union as u on u.id=e.union_id
                        where 
                                 e.id = "'.$id.'"';
		return $this ->db ->query($sql) ->row_array();
	}

	/**
	 * @method 获取某个手机号的数据，除去已拒绝的
	 * @author jiakairong
	 * @param unknown $mobile
	 */
	public function getMobileUnique($mobile) {
		$sql = 'select id,status from u_expert where (mobile="'.$mobile.'" or login_name="'.$mobile.'") and status !=3  and status != -1';
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
	 * @method 获取某个手机号的数据，除去已拒绝的和自己本身
	 * @author jiakairong
	 * @param unknown $mobile
	 */
	public function getMobileUniqueNo($mobile ,$id) {
		$sql = 'select id,status from u_expert where (mobile="'.$mobile.'" or login_name="'.$mobile.'") and status !=3 and id !='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取某个手机号的数据，除去已拒绝的和自己本身
	 * @author jiakairong
	 * @param unknown $mobile
	 */
	public function getEmailUniqueNo($email ,$id) {
		$sql = 'select id,status from u_expert where email = "'.$email.'" and status !=3 and status != -1 and id !='.$id;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 照相馆信息
	 * @author xml
	 */
	public function get_museum() {
	/* 	$reDataArr = $this->db->query ( 'SELECT museum_id FROM `u_expert_museum` where expert_id='.$id)->result_array ();
		$kk=$reDataArr['museum_id'];
		if(empty($kk)){
			$kk='1';
		} */
		$sql = 'select id,name,address,linkman,linkmobile,addtime,beizhu,price from u_museum ';
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 *@method 管家获取照相馆信息
	 *@author xml
	 */
	public function get_expert_museum($expert_id){
		$sql = 'SELECT	m.name,	em.id AS emid,m.id as mid,em.expert_id,m.address,em.qrcode FROM u_expert_museum AS em ';
		$sql.=' LEFT JOIN u_museum AS m ON em.museum_id = m.id where status=0 and em.expert_id='.$expert_id;
		return $this ->db ->query($sql) ->row_array();
	}
	public function up_expert_museum($expert_id){
		$this->db->where('expert_id', $expert_id);
		$this->db->update('u_expert_qrcode', array('status'=>1));
		return $this->db->affected_rows();
	}
	public function get_expert_data($expert_id){
		$sql = 'SELECT	* FROM u_expert  where id='.$expert_id;
		return $this ->db ->query($sql) ->row_array();
	}
	//管家二维码
	public function get_expert_qrcode($expert_id){
		$sql = 'SELECT	* FROM u_expert_qrcode  where status=1 and expert_id='.$expert_id;
		return $this ->db ->query($sql) ->row_array();
	}
	//管家申请拍照
	public function get_e_museum($expert_id){
		$sql = 'SELECT	m.name,m.linkman,m.linkmobile,em.id AS emid,m.id as mid,em.expert_id,m.address,mq.qrcode,mq.status FROM u_expert_museum AS em ';
		$sql.=' LEFT JOIN u_museum AS m ON em.museum_id = m.id  LEFT JOIN u_expert_qrcode as mq on mq.expert_museum_id=em.id';
		$sql.=' where em.expert_id='.$expert_id;
		return $this ->db ->query($sql) ->row_array();
	}


	//管家申请拍照
	public function get_depart_list($depart_id){
		$sql = 'SELECT	m.name,m.linkman,m.linkmobile,em.id AS emid,m.id as mid,em.expert_id,m.address,mq.qrcode,mq.status FROM u_expert_museum AS em ';
		$sql.=' LEFT JOIN u_museum AS m ON em.museum_id = m.id  LEFT JOIN u_expert_qrcode as mq on mq.expert_museum_id=em.id';
		$sql.=' where em.expert_id='.$expert_id;
		return $this ->db ->query($sql) ->row_array();
	}

}