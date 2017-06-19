<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Expert_model extends MY_Model {
	
	function __construct() {
		parent::__construct ( 'u_expert' );
	}
	
	/**
	 * 获取所有绑定手机设备的管家
	 * @return array 查询结果
	 */
	public function getExpertEquipment()
	{
		$sql ='select equipment_id,id,mobile from u_expert where status=2 and equipment_id != "" GROUP BY equipment_id';
		return $this->db->query($sql)->result_array();
	}
	
	/**
	 * 根据经纬度，获取一个点附近的管家
	 * @param array $whereArr 查询条件
	 * @param string $longitude 经度
	 * @param string $latitude 纬度
	 * @param number $dis 查询距离，单位公里,默认10km
	 * @return array 查询结果
	 */
	public function getNearbyExpert($whereArr,$longitude ,$latitude,$dis=10000)
	{
		$sql = 'SELECT id,realname,nickname,small_photo as photo,
		st_distance_sphere(point(longitude, latitude), point('.$longitude.','.$latitude.')) as distance
		FROM u_expert '.$this->getWhereStr($whereArr).' HAVING distance<'.$dis.' ORDER BY distance'.$this->getLimitStr();
		
		return $this ->db ->query($sql) ->result_array();
	}
	
	/**
	 * @method 获取营业部下的管家
	 * @param unknown $departIds
	 */
	public function getDepartExpert($departIds)
	{
		$sql = 'select e.id,e.realname from u_expert as e left join b_depart as d on d.id=e.depart_id where (d.id in ('.$departIds.') or d.pid in('.$departIds.')) and e.union_status=1';
		return $this ->db ->query($sql) ->result_array();
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
		
		
		$sql = "select e.id as eid,e.small_photo,e.type,e.online,e.nickname,l.linename,e.realname,e.travel_title,(e.satisfaction_rate+ea.sati_intervene) as satisfaction_rate,e.talk,e.order_count,e.total_score,e.comment_count,e.grade,e.sex, e.people_count,e.service_time,e.visit_service,e.expert_theme,e.expert_dest,a.name as cityname,e.order_amount,count(distinct e.id) ";
		$sql =$sql." from u_expert as e  left join  u_line_apply as la  on la.expert_id = e.id left join u_line as l on la.line_id = l.id left join u_area as a on a.id= e.city left join u_expert_affiliated as ea on ea.expert_id = e.id where $whereStr and e.is_kf != 'Y' group by e.id $order_by ";
		
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
}