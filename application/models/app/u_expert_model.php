<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class U_expert_model extends MY_Model
{
	
	private $table_name = 'u_expert';
	
	public function __construct() {
		parent::__construct ( $this->table_name );
	}
	
	public function getExpertData($whereArr ,$page=1 ,$num=10 ,$orderBy) {
	
	}
	
	
	/**
	 * @method 获取专家数据
	 * @author jiakairong
	 * @param unknown $where
	 * @param number $page
	 * @param number $num
	 * @param unknown $like
	 * @param string $order_by
	 */
	public function get_expert_list($whereArr ,$page = 1, $num = 10 ,$order_by = 'order by e.id asc' )
	{
		$limitStr = '';
		$whereStr = '';
		if (!empty($whereArr) && is_array ( $whereArr ))
		{
			foreach($whereArr as $key =>$val)
			{
				if ($val !== 0 && empty($val))
				{
					continue;
				}
				switch($key)
				{
					case 'e.city':
						$whereStr .= " e.city in ({$val}) and";
						break;
					case 'l.overcity':
					case 'e.visit_service':
						$whereStr .= '(';
						foreach($val as $v) {
							$whereStr .= " find_in_set ({$v} , {$key}) > 0 or";
						}
						$whereStr =rtrim($whereStr ,'or'). ') and';
						break;
					case 'keyWord':
						$whereStr .= ' (';
						foreach($val as $index =>$item) {
							if ($index == 'city') {
								$whereStr .= " e.city in ({$item}) or";
							} elseif ($index == 'nickname') {
								$whereStr .= " e.nickname like '%{$item}%' or";
							} elseif ($index == 'expert_dest') {
								foreach($item as $i) {
									$whereStr .= " find_in_set ({$i} , e.expert_dest) > 0 or";
								}
							}
						}
						$whereStr =rtrim($whereStr ,'or'). ') and';
						break;
					case 'e.nickname':
						$whereStr .= " e.nickname like '%{$val}%' and";
						break;
					default:
						$whereStr .= " {$key}='{$val}' and";
						break;
				}
			}
			$whereStr = rtrim($whereStr ,'and');
		}
	
		$num = empty ( $num ) ? 10 : $num;
		$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
		$limitStr = " limit {$offset} ,{$num} ";
	
	
		$sql = "select e.id as eid,e.small_photo,e.type,e.online,e.nickname,l.linename,e.realname,e.travel_title,e.satisfaction_rate,e.talk,e.order_count,e.total_score,e.comment_count,e.grade,e.sex, e.people_count,e.service_time,e.visit_service,e.expert_theme,e.expert_dest,a.name as cityname,e.order_amount,count(distinct e.id) ";
		$sql =$sql." from u_expert as e  left join  u_line_apply as la  on la.expert_id = e.id left join u_line as l on la.line_id = l.id left join u_area as a on a.id= e.city where $whereStr and e.is_kf != 'Y' group by e.id $order_by ";
		$data['count'] = $this ->getCount($sql ,array());
		$sql = $sql.$limitStr;
		$data['expertData'] = $this ->db ->query($sql) ->result_array();
		return $data;
	}
	
	/**
	 * @method 用户设计方案
	 * @author jiakairong
	 * @since  2015-11-02
	 */
	public function get_customer_lines($where ,$page = 1, $num = 5 ) {
		$this->db->select ( "c.id,e.id as e_id,e.nickname,m.litpic,c.question,c.linkname,c.addtime" );
		$this->db->from ( "u_customize as c" );
		$this ->db ->where($where);
		$this->db->join ( 'u_member as m', 'c.member_id=m.mid', 'left' );
		$this->db->join ( 'u_customize_answer as ca', 'ca.customize_id=c.id', 'left' );
		$this->db->join ( 'u_expert as e', 'e.id=ca.expert_id', 'left' );
		$this->db->order_by ( "c.addtime", "desc" );
		$num = empty ( $num ) ? 5 : $num;
		$offset = (empty ( $page ) ? 0 : ($page - 1)) * $num;
		$this->db->limit ( $num, $offset );
	
		return $this->db->get ()->result_array();
	}
	/**
	 * @method 获取管家详细
	 * @author jiakairong
	 * @since  2016-03-09
	 * @param unknown $expertId
	 */
	public function getExpertDetail($expertId)
	{
		$sql = 'select e.*,a.name as country_name,b.name as province_name,c.name as city_name,d.name as region_name from u_expert as e left join u_area as a on a.id = e.country left join u_area b on b.id=e.province left join u_area as c on c.id = e.city left join u_area as d on d.id = e.region where e.id ='.$expertId;
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取管家从业简历
	 * @author jiakairong
	 * @since  2016-03-09
	 * @param unknown $expertId
	 */
	public function getExpertResume($expertId)
	{
		$sql = 'select * from u_expert_resume where expert_id='.$expertId.' and status = 1 order by id asc';
		return $this ->db ->query($sql) ->result_array();
	}
	/**
	 * @method 获取管家证书
	 * @author jiakairong
	 * @since  2016-03-09
	 * @param unknown $expertId
	 */
	public function getExpertCertificate($expertId)
	{
		$sql = 'select * from u_expert_certificate where expert_id='.$expertId.' and status = 1 order by id asc';
		return $this ->db ->query($sql) ->result_array();
	}
	
	

	/**
	 * @method 管家登录获取通过的管家数据
	 * @author jiakairong
	 * @since  2015-01-08
	 * @param unknown $login_name
	 */
	public function getExpertLogin($login_name)
	{
		$sql = 'select id,login_name,mobile,realname,nickname,email,small_photo,logindatetime,password,status,city from u_expert where (login_name = "'.$login_name.'" or mobile = "'.$login_name.'" or email = "'.$login_name.'") and status = 2';
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
		$sql = 'select id,status,city from u_expert where login_name = "'.$login_name.'" or mobile="'.$login_name.'" or email="'.$login_name.'" order by id desc';
		return $this ->db ->query($sql) ->result_array();
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
         * @method getMobileRegistered
         * @desc    获取某个手机号状态不为-1的数据
         * @author  weiyong
         * @param   $mobile
         * @time    2017-1-12 11:04:03
         */
//        public function getMobileRegistered($mobile){
//            $sql = 'select id,status from u_expert where (mobile="'.$mobile.'" or login_name="'.$mobile.'") and status !=-1';
//            return $this->db->query($sql)->result_array();
//        }
        
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
		$sql = 'select id,status from u_expert where email = "'.$email.'" and status !=3 and id !='.$id;
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
	
	
	
	
	
	
	
	
	
}