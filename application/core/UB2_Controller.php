<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月23日14:03:55
 * @author		徐鹏
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UB2_Controller extends MY_Controller {

	/**
	 *  专家id
	 * @var integer
	 */
	protected $expert_id;

	public $defaultArr = array(
	               	"totalRecords"=>0,
	               	"totalPages" =>0,
	                "pageNum" =>1,
	                "pageSize" =>0,
	               	"rows" => array()
            		);
	public function __construct() {

		parent::__construct();
		$this->load->helper('string');
		$this->load->library('session');
        $this ->load_model('common/u_expert_model' ,'common_u_expert_model');
		$this->expert_id = $this->session->userdata('expert_id');
		if (!isset($this->expert_id) || empty($this->expert_id))
        {
			redirect('admin/b2/login/index');
		}
        else
        {
			$expert_status = $this->common_u_expert_model->getExpertById($this->expert_id); //is_commit,status,expert_type, is_dm,depart_list,union_id,union_status
             if($expert_status['status']==-1 && $expert_status['union_status'] != 1)
             {
				//不符合登录状态，销毁session
				$array_items = array('expert_id' => '', 'login_name' => '','real_name'=>'','email' =>'','user_pic'=>'');
				$this->session->unset_userdata($array_items);
				redirect('admin/b2/login/index');
		     }
                        
		    if($expert_status['expert_type']==1 && $expert_status['is_dm']==1 && $expert_status['union_status']==1)
	         {
	                                 //身份是b端经理
					$array_items = array(
						'parent_depart_id'	=> current(explode(',',rtrim($expert_status['depart_list'],','))),
						'depart_id'		=>	end(explode(',',rtrim($expert_status ['depart_list'],','))),
						'union_id'		=> $expert_status ['union_id'],
						//'is_manage'		=>1,
						'e_status'		=> $expert_status ['status'],
						'is_commit'		=> $expert_status ['is_commit']
						);
					$this->session->set_userdata($array_items);
				}elseif($expert_status['expert_type']==0 || $expert_status['union_status']==-1)
	            {
	                                //身份是c端管家
					$array_items = array(
						'parent_depart_id'	=> '',
						'depart_id'		=>	'',
						'union_id'		=> '',
						//'is_manage'		=>-1,
						'e_status'		=> $expert_status ['status'],
						'is_commit'		=> $expert_status ['is_commit']
						);
					$this->session->set_userdata($array_items);
				}else
	            {
	                                //身份是b端普通管家
					$array_items = array(
						'parent_depart_id'	=> current(explode(',',rtrim($expert_status ['depart_list'],','))),
						'depart_id'		=>	end(explode(',',rtrim($expert_status ['depart_list'],','))),
						'union_id'		=> $expert_status ['union_id'],
						//'is_manage'		=>0,
						'e_status'		=> $expert_status ['status'],
						'is_commit'		=> $expert_status ['is_commit']
						);
					$this->session->set_userdata($array_items);
				}
		
		   } // if end
	   }

        /*
         * 管家全部详细信息
         */
        public function expertInfo()
        {
            $this ->load_model('common/u_expert_model' ,'expert_model');
            $expert = $this->expert_model->getExpertById($this->expert_id);
            return $expert;
        }

        public function load_view($page_view, $param = NULL) {
		$statis_msg = $this->get_unread_msg();
		$web_config = $this->get_web_config();
		$data = array(
				'email' => $this->session->userdata('email'),
				'login_name' => $this->session->userdata('login_name'),
				'user_pic'     => $this->session->userdata('user_pic'),
				'statis_msg' => $statis_msg,
				'web_config' => $web_config
					  );
		//print_r($statis_msg);exit();
		$this->load->view('admin/b2/header', $data);
		$this->load->view($page_view, $param);
		$this->load->view('admin/b2/footer.html');
	}

	public function view($page_view, $param = NULL) {
		$statis_msg = $this->get_unread_msg();
		$web_config = $this->get_web_config();
		$data = array(
				'email' => $this->session->userdata('email'),
				'login_name' => $this->session->userdata('login_name'),
				'user_pic'     => $this->session->userdata('user_pic'),
				'statis_msg' => $statis_msg,
				'web_config' => $web_config
		);
		$this->load->view('admin/expert/common/header', $data);
		$this->load->view($page_view, $param);
		$this->load->view('admin/expert/common/footer.html');
// 		$this->load->view('admin/b2/footer.html');
	}

	public function load_self_view($page_view, $param = NULL) {
		$this->load->view($page_view, $param);
	}

	public function get_unread_msg(){

		$depart_id = $this ->session ->userdata('depart_id');
		$expert_id = $this ->session ->userdata('expert_id');

		$sys_msg_unread = $this->db->query ( "SELECT
				COUNT(*) AS sys_msg_count
				FROM
				(`u_notice` AS n)
				WHERE FIND_IN_SET('1', n.notice_type) > 0 AND `n`.`id` NOT IN (SELECT nr.notice_id FROM u_notice_read AS nr WHERE FIND_IN_SET('1', n.notice_type) > 0 AND nr.userid = $this->expert_id)")->result_array ();
		// $sys_msg_unread = $this->db->get()->result_array();
		$this->db->select('count(*) AS buniess_msg_count');
		$this->db->from('u_message AS m');
		$this->db->where(array('m.msg_type'=>1,'m.read'=>0,'m.receipt_id'=>$this->expert_id));
		$buniess_msg_unread = $this->db->get()->result_array();

		$count_res['sys'] = $sys_msg_unread[0]['sys_msg_count'];
		$count_res['buniess'] = $buniess_msg_unread[0]['buniess_msg_count'];
		$count_res['sum_msg'] = $sys_msg_unread[0]['sys_msg_count']+$buniess_msg_unread[0]['buniess_msg_count'];
		
		if ($depart_id > 0)
		{
			//营业部管家，获取t33站内消息
			$this ->load_model('msg/msg_send_model' ,'send_model');
			//未读消息数量
			$whereArr = array(
					'ms.status =' =>0,
					'sp.user_id =' =>$expert_id,
					'in' =>array('sp.user_type' =>'1,2')
			);
			$count_res['sum_msgess'] = $this ->send_model ->getUnreadMsgCount($whereArr);

			//获取最新的5条未读消息
			$count_res['msg_arr'] = $this ->send_model ->getNewMsgData($whereArr);
		}
	
		return $count_res;
	}

	public function get_web_config(){
		$sql = "select * from cfg_web";
		$web_config = $this->db->query($sql)->result_array();
		return $web_config[0];
	}
	/*管家拍照生成二维码*/
	function get_qrcodes($id){
		$this->load->library('ciqrcode');
		$params['data'] = base_url().'admin/b2/register/upExpertMuseum?id='.$id;
		$params['level'] = 'H';
		$params['size'] = 12;
		$params['savename'] = FCPATH.'file/qrcodes/guanjiaid_'.$id.'.png';
		$this->ciqrcode->generate($params);
		//echo '<img src="'.base_url().'file/qrcodes/guanjiaid.png" />';
		$logo = FCPATH.'file/qrcodes/logo.png';//准备好的logo图片
		//echo FCPATH;
		$QR = base_url().'file/qrcodes/guanjiaid_'.$id.'.png';//已经生成的原始二维码图
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
		imagepng($QR, FCPATH.'file/qrcodes/'.$id.'_qr.png');
		//	echo '<img src="'.base_url().'file/qrcodes/guanjiaid_qr.png">';
		//echo "file/qrcodes/".$id."_qr.png";
		return  FCPATH.'file/qrcodes/'.$id.'_qr.png';
	}

	/**
	 * @name：公共函数:线路详情（线路的全部相关信息=基本信息+目的地列表+标签+套餐+行程安排+轮播图+交通+酒店+主题）
	 * @author: 温文斌
	 * @param: id=线路id；
	 * @return:
	 *
	 */
	protected function F_line_detail_more($lineId)
	{
		$sql="
		SELECT
		a.*,(select GROUP_CONCAT(kindname) from u_dest_base where FIND_IN_SET(id,a.overcity2) >0 )as overcity_name,
		(select group_concat(us.cityname) from u_line_startplace as ls left join u_startplace as us on ls.startplace_id=us.id where ls.line_id=a.id) as startplace,
		t.name as theme_name
		FROM
		u_line as a
		left join u_line_startplace as ls on a.id=ls.line_id
		LEFT JOIN u_startplace as u  on ls.startplace_id=u.id
		left join u_theme as t on t.id=a.themeid
		WHERE
		a.id={$lineId}
		";
		$data['data']=$this->db->query($sql)->row_array(); //线路基本信息+目的地城市+出发城市
		//满意度4舍5入 ，echo round(0.455,2);
		$data['data']['satisfyscore']=(round($data['data']['satisfyscore'],2)*100).'%';

		$this->load->model ( 'app/u_line_apply_model', 'line_apply' );
		$this->load->model ( 'app/user_shop_model' );
		$this->load->model ( 'app/u_line_attr_model', 'lineattr_model' );
		$this->load->model ( 'app/u_destinations_model', 'destinations_model' );
		//目的地
		$data ['overcity_arr'] = array ();
					if (!empty($data ['data'] ['overcity2']))
					$data ['overcity_arr'] = $this->destinations_model->getDestinations ( explode ( ",", $data ['data'] ['overcity2'] ) );
		//标签
			$data ['line_attr_arr'] = array ();
			if (!empty($data ['data'] ['linetype']))
			{
			$data ['line_attr_arr'] = $this->lineattr_model->getLineattr ( explode ( ",", $data ['data'] ['linetype'] ) );
			}
		// 供应商信息
		$supplierData = $this->user_shop_model->get_user_shop_select ( 'u_supplier', array ('id' => $data ['data'] ['supplier_id']) );
		// 线路品牌、套餐
		$data ['data'] ['brand'] = $supplierData [0] ['brand'];
		$data ['suits'] = $this->user_shop_model->getLineSuit ( $lineId );
		$data['line_aff']=$this->user_shop_model->select_rowData('u_line_affiliated',array('line_id'=>$lineId));
		//线路轮播图
		$pics=$this->db->query("select a.filepath from u_line as l left join u_line_pic as p on l.id=p.line_id left join u_line_album as a on a.id=p.line_album_id where l.id='{$lineId}'")->result_array();
		$data ['data'] ['pics']=$pics;
		// 行程安排
			$data ['rout'] = $this->user_shop_model->getLineRout ( $lineId );
			foreach ( $data ['rout'] as $key => $val )
			{
				foreach ( $val as $k => $v )
				{
					if ($k == "pic")
					{
						if ($v)
						{
							$val [$k] = explode ( ";", $v );
							foreach ( $val [$k] as $k )
							{
							if (! empty ( $k )) {
							$val ['pics'] [] =  $k;
							}
							}
							$val ['pic'] = '1';
						}
					}
				}
				$data ['rout'] [$key] = $val;
			}
			//线路评论
			$data ['comment_list'] = $this->db->query ( "SELECT m.litpic, m.nickname, c.level, c.content,c.reply1,c.reply2,c.pictures, c.addtime, c.isanonymous, m.mobile FROM u_comment AS c	LEFT JOIN  u_member as m ON c.memberid=m.mid	WHERE c.line_id ='{$lineId}' order by c.addtime desc LIMIT 5" )->result_array ();
			foreach ($data ['comment_list'] as $n=>$m)
			{
				$pic_arr=explode(",", $m['pictures']);

			    $m['pictures']=$pic_arr;
				$data ['comment_list'][$n]=$m;
	     	}
			//线路体验分享
			$data['share_list']=$this->db->query("select tn.id,tn.title,tn.content,tn.cover_pic,tn.modtime,tn.line_id,um.nickname as nickname from travel_note as tn left join u_member as um on tn.userid=um.mid where tn.usertype='0' and tn.is_show='1' and tn.status='1' and tn.line_id='{$lineId}' order by tn.modtime desc limit 5")->result_array();
			// 线路图片
			//$data ['imgurl'] = $this->user_shop_model->select_imgdata ( $lineId );
			// 交通方式
			$data ['transport'] = $this->user_shop_model->description_data ( 'DICT_TRANSPORT' );
			// 星际酒店概述
			$data ['hotel'] = $this->user_shop_model->description_data ( 'DICT_HOTEL_STAR' );

			$data ['supplier'] = $supplierData;


			// 是否是主题游
			$data ['themeid'] = '';
			if (! empty ( $data ['data'] ['themeid'] )) {
			$data ['themeid'] = $this->user_shop_model->get_user_shop_select ( 'u_theme', array (
					'id' => $data ['data'] ['themeid']
			) );
		}
			// 管家培训
						$data ['train'] = $this->user_shop_model->get_user_shop_select ( 'u_expert_train', array (
						'line_id' => $lineId,
						'status' => 1
		) );
			// 礼品管理
			$data ['gift'] = $this->user_shop_model->get_gift_data ( $lineId );
			return $data;
	}

	/**
	 * @name：私有函数：输出数据,$len是长度
	 * @author: wwb
	 * @param:
	 * @return:
	 *
	 */
	public function __data($reDataArr,$common=array()) {
		$len="1";
		if(empty($reDataArr))
		{
			$code="4001";
			$msg="data empty";
			$data=array();
		}
		else
		{
			if(is_array($reDataArr))
				$len=count($reDataArr);
	
			$reDataArr = strip_slashes ( $reDataArr );
			$data=$reDataArr;
			$code="2000";
			$msg="success";
		}
	
		$output= json_encode ( array (
				"code" => $code,
				"msg" => $msg,
				"data" => $data,
				"total" => $len,
				'common'=>$common
		), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
	
		echo $output;
		exit ();
	}
	/**
	 * 请求错误信息接口
	 * @param string $msg
	 * @param string $code
	 */
	public function __errormsg($msg = "", $code = "-3") {
		$this->result_code = $code;
		if ($msg == "") {
			$this->result_msg = "data error";
		} else {
			$this->result_msg = $msg;
		}
		
		$this->resultJSON = json_encode ( array(
				"code" => $this->result_code,
				"msg" => $this->result_msg,
		) );
		echo $this->resultJSON;
		exit ();
	}


}