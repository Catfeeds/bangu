<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Member_model extends MY_Model {

	private $table_name = 'u_member';
	
	function __construct() {
		parent::__construct ( $this->table_name );
	}
	//获取会员数据
	function get_member_data($param,$page){
		$query_sql='';
		$query_sql.=' SELECT m.mid,m.loginname,m.nickname,m.truename,m.mobile,m.email,m.sex,m.jointime,m.register_channel,c.name as cityname,p.name as province_name';
		$query_sql.=' FROM	u_member as m left join u_area as p on p.id=m.province left join u_area as c on c.id=m.city where m.mid>0';
		if($param!=null){
			if(null!=array_key_exists('loginname', $param)){
				$query_sql.=' and m.loginname = ? ';
				$param['loginname'] = trim($param['loginname']);
			}
			if(null!=array_key_exists('mobile', $param)){
				$query_sql.=' and m.mobile = ? ';
				$param['mobile'] = trim($param['mobile']);
			}
			if(null!=array_key_exists('register_channel', $param)){
				$query_sql.=' and m.register_channel = ? ';
				$param['register_channel'] = trim($param['register_channel']);
			}
			if(null!=array_key_exists('member_name', $param)){
				$query_sql.=" and (m.nickname  like ?  or m.truename like '%{$param['member_name']}%')";
				$param['member_name'] = '%'.trim($param['member_name']).'%';
			}
			if(null!=array_key_exists('city', $param)){
				if (empty($param['city'])) {
					unset($param['city']);
				} else {
					$query_sql.=" and m.city = ? ";
					$param['city'] = $param['city'];
					unset($param['province']);
				}
			}
			if(null!=array_key_exists('province', $param) && !array_key_exists('city', $param)){
				if(empty($param['province'])) {
					unset($param['province']);
				} else {
					$query_sql.=" and m.province = ? ";
					$param['province'] = $param['province'];
				}
			}
		}
		$query_sql.=' ORDER BY	m.jointime DESC';
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
	//导出会员数据
	function derive_member_data($param){
		$query_sql='';
		$query_sql.=' SELECT mid,loginname,nickname,truename,mobile,email,sex,jointime ';
		$query_sql.=' FROM	u_member where mid>0 ';
		if($param!=null){
			if(null!=array_key_exists('loginname', $param)){
				$query_sql.=' and loginname ='.$param['loginname'];
				$param['loginname'] = $param['loginname'];
			}
			if(null!=array_key_exists('mobile', $param)){
				$query_sql.=' and mobile = '.$param['mobile'];
				$param['mobile'] = $param['mobile'];
			}
		
			if(null!=array_key_exists('member_name', $param)){
				$query_sql.=" and (nickname  like '%{$param['member_name']}%'  or truename like '%{$param['member_name']}%')";
				$param['member_name'] = '%'.$param['member_name'].'%';
			}
		}
		$query_sql.=' ORDER BY	jointime DESC';
		$data=$this ->db ->query($query_sql) ->result_array();
		return $data;
	}
	//会员渠道
	function u_register_channel($param,$page){
		$query_sql='';
		$query_sql.=' SELECT id,name,channel_code,qrcode ';
		$query_sql.=' FROM	u_register_channel where id>0 and status=1';
		if($param!=null){
			if(null!=array_key_exists('s_name', $param)){
				$query_sql.=' and name like ? ';
				$param['s_name'] = '%'.trim($param['s_name']).'%';
			}
			if(null!=array_key_exists('s_channel_code', $param)){
				$query_sql.=' and channel_code = ? ';
				$param['s_channel_code'] = trim($param['s_channel_code']);
			}
		
		}
		
	//	$query_sql.=' ORDER BY	jointime DESC';
		return $this->queryPageJson( $query_sql , $param ,$page);
		
	}
	//插入会员渠道的数据表
	function insert_channelData($channelArr){
		$this->db->trans_start();
		
		$this->db->insert('u_register_channel',$channelArr);
		$channelId=$this->db->insert_id();
		
		$this->get_qrcodes($channelId); //生成二微码
		
		$qrcode='/file/qrcodes/channelid_'.$channelId.'.png';
		$this->db->query(" update u_register_channel SET qrcode ='".$qrcode."' WHERE id=?  ",$channelId);
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return true;
		}
	} 
	//获取会员注册渠道
	function get_channel_data($id){
		$query=$this->db->query(" select * from  u_register_channel  WHERE id=?  ",$id);
		$data=$query->row_array();
		return $data;
	}
	//编辑会员注册渠道
	function edit_channelData($data,$id){
		$this->db->where('id', $id);
	    $this->get_qrcodes($id); //生成二微码
		$this->db->update('u_register_channel', $data);
		return $this->db->affected_rows();
	}
	//删除会员注册渠道
	function del_channel_data($id){
/* 		$this->db->where('id', $id);
		return $this->db->delete('u_register_channel');
		 */
		$this->db->where('id', $id);
		return $this->db->update('u_register_channel', array('status'=>0));
		
	}
	//漂流门票
	function get_wx_drifting($param,$page){
		$query_sql='';
		$query_sql.=' SELECT id,code,name,num,status from wx_activity ';
		$query_sql.='  where id>0 and status=1 ';
		if($param!=null){
			if(null!=array_key_exists('s_name', $param)){
				$query_sql.=' and name like ? ';
				$param['s_name'] = '%'.$param['s_name'].'%';
			}
			if(null!=array_key_exists('s_channel_code', $param)){
				$query_sql.=' and code = ? ';
				$param['s_channel_code'] = $param['s_channel_code'];
			}
		}
		
			$query_sql.=' ORDER BY	id asc';
		return $this->queryPageJson( $query_sql , $param ,$page);
	}
	
	//编辑某个漂流门票
	function edit_wx_activity($data,$id){
		$this->db->where('id', $id);
		$this->db->update('wx_activity', $data);
		return $this->db->affected_rows();
	}
	//添加漂流门票
	function insert_wx_activity($data){
		$this->db->insert('wx_activity',$data);
		$id=$this->db->insert_id();
		return $id;
	}
	
	//获取某一条数据的门票信息
	function get_wx_activity($id){
		$query=$this->db->query(" select * from  wx_activity  WHERE id=?  ",$id);
		$data=$query->row_array();
		return $data;
	}
	//删除门票信息
	function del_activity_data($id){
		$this->db->where('id', $id);
		$this->db->update('wx_activity', array('status'=>0));
		return $this->db->affected_rows();
	}
	/*生成二维码*/
	function get_qrcodes($id){
		$this->load->library('ciqrcode');
		$params['data'] ='http://m.1b1u.com/login/registerFrame?type='.$id;
		$params['level'] = 'H';
		$params['size'] = 12;
		$params['savename'] = FCPATH.'file/qrcodes/channelid_'.$id.'.png';
		$this->ciqrcode->generate($params);
		//echo '<img src="'.base_url().'file/qrcodes/guanjiaid.png" />';
		$logo = FCPATH.'file/qrcodes/logo.png';//准备好的logo图片
		//echo FCPATH;
		$QR = base_url().'file/qrcodes/channelid_'.$id.'.png';//已经生成的原始二维码图
		if ($logo !== FALSE) {
			
			$QR = imagecreatefromstring(file_get_contents($QR));
			$logo = imagecreatefromstring(file_get_contents($logo));
			$QR_width = imagesx($QR);//二维码图片宽度
			$QR_height = imagesy($QR);//二维码图片高度
			$logo_width = imagesx($logo);//logo图片宽度
			$logo_height = imagesy($logo);//logo图片高度
			$logo_qr_width = $QR_width/ 5;//
			$scale = $logo_width/$logo_qr_width;
			$logo_qr_height = $logo_height/$scale;//
			$from_width = ($QR_width - $logo_qr_width) /2;
			//重新组合图片并调整大小
			imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,$logo_qr_height, $logo_width, $logo_height);
		}
		imagepng($QR, FCPATH.'file/qrcodes/channelid_'.$id.'.png');
		//	echo '<img src="'.base_url().'file/qrcodes/guanjiaid_qr.png">';
		//echo "file/qrcodes/".$id."_qr.png";
	}
}