<?php
/**
 *
 * @copyright 深圳海外国际旅行社有限公司
 * @author 何俊
 *
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Line_detail extends UC_NL_Controller {
	public function __construct() {
		parent::__construct ();
		date_default_timezone_set ( 'Asia/Shanghai' );
		$this->load_model ( 'line_detail_model', 'line_model' );
		$this->load->helper ( 'kefu' );
	}
	public function del(){
		$this ->del_cache(1274);
	}
	
	// leon remove param  ,$type=0
	public function index($line_id=0 ,$type='') {
		
// 		$this->load->helper ( 'url' );
// 		$c_whereArr['member_id'] = $this->session->userdata('c_userid');
// 		$c_whereArr['line_id'] = $line_id;
// 		$collection_arr = $this->line_model->get_line_collection($c_whereArr);
// 		$new_day = date ( 'Y-m-d H:i:s', time () );
// 		$where = array(
// 				'l.id' => $line_id
// 		);
		$line_id = intval($line_id);
		$mid = $this->session->userdata('c_userid');
		
		//若会员登录，则查询是否收藏了此线路
		$whereArr = array(
				'member_id =' =>$mid,
				'line_id =' =>$line_id
		);
		$collection_arr = $this->line_model->get_line_collection($whereArr);

		//线路相册图片
		$whereArr = array(
				'l.id =' =>$line_id
		);
		$album_data = $this->line_model->get_album_data ( $whereArr );

		$where = array(
			'l.id' => $line_id
		);
		// 线路详情
		$line_data = $this->line_model->get_line_detail ( $where );
		$line_data = $this->replace_str($line_data,array("\r\n","\n","\r"),"<br />");
		if (empty($line_data) )
		{
			redirect('line/line_list');
		}
		//print_r($line_data);
		// 线路属性
		$where = $line_id;
		$line_property_arr = $this->line_model->get_line_property ( $where );
		$line_property = array();
		foreach ($line_property_arr as $key=>$val){
			$line_property[$val['pid']][$key] = $val;
		}
		// 中间专家
		$cwhere = array(
				'la.line_id' => $line_id,
				'la.status' => 2
		);
		$new_page = $this->input->get ( 'page', true );
		$new_page = empty ( $new_page ) ? 1 : $new_page;
		$center_expert = $this->line_model->get_expert_data ( $cwhere, $new_page, 6 );
		// 专家心得
		$cwhere = array(
				'la.line_id' => $line_id,
				'e.id' => 1
		);
		$expert_mind = $this->line_model->get_expert_mind ( $cwhere );

		$localtion_city = $this->line_model->get_city_localtion();
		// 获取右侧专家(在线，直属管家，成交量)
		$rwhere = array(
				'la.line_id' => $line_id,
				'la.status' => 2,
				'e.status' =>2,
				'e.is_kf !=' => 'Y',
				'e.supplier_id' =>$line_data['supplier_id']
		);
		//直属管家
		$du_expert = $this->line_model->get_expert_data ( $rwhere, 1, 4,$localtion_city);

		$rwhere = array(
				'la.line_id' => $line_id,
				'la.status' => 2,
				'e.status' =>2,
				'e.is_kf !=' => 'Y',
				'e.supplier_id !=' =>$line_data['supplier_id']
		);
		//右侧管家排序
		$dun_expert = $this->line_model->get_expert_data ( $rwhere, 1, 4,$localtion_city);
		//$right_expert = array();
		$r_expert = array_merge($du_expert,$dun_expert);
		//排序规则  第一级：在线的直属管家，第二级：在线的非直属管家，第三级：不在线的直属管家，第四级：不在线的非直属管家
		foreach($r_expert as $key =>$val)
		{
			if ($val['online'] == 2 && $val['supplier_id'] == $line_data['supplier_id'])
			{
				$r_expert[$key]['sort'] = 1;
			}
			elseif ($val['online'] == 2 && $val['supplier_id'] != $line_data['supplier_id'])
			{
				$r_expert[$key]['sort'] = 2;
			}
			elseif ($val['online'] != 2 && $val['supplier_id'] == $line_data['supplier_id'])
			{
				$r_expert[$key]['sort'] = 3;
			}
			else
			{
				$r_expert[$key]['sort'] = 4;
			}
		}
		$lenExpert = count($r_expert) -1;
		$i = 0;
		for($i ;$i <$lenExpert ;$i++)
		{
			$j = 0;
			for ($j ;$j < $lenExpert-$i ;$j ++)
			{
				if($r_expert[$j]['sort'] > $r_expert[$j+1]['sort'])
				{
					$arr = $r_expert[$j];
					$r_expert[$j] = $r_expert[$j+1];
					$r_expert[$j+1] = $arr;
				}
			}
		}

		//var_dump($r_expert);exit;

		//var_dump($right_expert);exit;
		//print_r($this->db->last_query());exit();
		// 获取线路行程
		$xwhere = array(
				'lineid' => $line_id
		);
		$jieshao = $this->line_model->get_line_jieshao ( $xwhere );
		//print_r($jieshao);exit();
		$jieshao = $this->replace_str($jieshao,array("\n\r","\n","\r"),"<br />");
		// 获取线路点评
		$cowhere = array(
				'c.line_id' => $line_id,
				'c.isshow' => 1
		);
		$comment_count = $this->line_model->get_comment_count ( $cowhere, 1, 10 );
		$comment_total = 0;
		$comment_count_array = array(1=>0,2=>0,3=>0,4=>0,5=>0);
		foreach ($comment_count as $key=>$val){
			$comment_total += $val['total'];
			if($val['avgscore1']>=1&&$val['avgscore1']<2){
				$comment_count_array[1] +=  $val['total'];
			}elseif($val['avgscore1']<3){
				$comment_count_array[2] +=  $val['total'];
			}elseif ($val['avgscore1']<4){
				$comment_count_array[3] +=  $val['total'];
			}elseif ($val['avgscore1']<5){
				$comment_count_array[4] +=  $val['total'];
			}elseif ($val['avgscore1']==5){
				$comment_count_array[5] +=  $val['total'];
			}

		}
		// 在线咨询
		$zwhere = array(
				'productid ' => $line_id
		);
		$on_line = $this->line_model->get_on_line ( $zwhere );

		// 获取线路套餐
		$suit_data = $this->line_model->get_suit_data ( array(
				'lineid' => $line_id,
				'is_open' =>1
		) );
		// 获取套餐日历 默认为 第一个套餐 当月
		if (! empty ( $suit_data )) {
			$swhere['suitid'] = $suit_data[0]['id'];
		}else{
			$swhere['suitid'] = 0;
		}
		$first_day = date ( 'Y-m-01', time () ); // 当月第一天
		$last_day = date ( 'Y-m-t', time () ); // 当月最后一天

		$swhere['day >='] = $first_day;
		$swhere['day <='] = $last_day;
		$price_data = $this->line_model->get_suit_price ( $swhere );
		//print_r($suit_data);
		// 根据线路ID，查费用包含和不包含，预定须知,签证
		$where = array(
				'id' => $line_id
		);
// 		$line_info = $this->line_model->line_info ( $where );
// 		$line_info = $this->replace_str($line_info,array("\n\r","\n","\r"),"<br />");
		//获取目的地
		$destName = '';
		$destArr = array(); //线路的第二级目的地
		if (!empty($line_data['overcity']))
		{
			$this ->load_model('dest/dest_base_model' ,'dest_base_model');
			$where = array(
					'in' =>array('id' =>trim($line_data['overcity'] ,','))
			);
			$destData = $this ->dest_base_model ->getDestData($where);
			
			if(!empty($destData))
			{
				foreach($destData as $v)
				{
					if ($v['level'] == 2)
					{
						$destArr[] = $v['id'];
					}
					$destName .= $v['kindname'].',';
				}
			}
			if ($type != 'gn' && $type != 'cj' && $type != 'zb' && $type != 'zt')
			//if (empty($type))
			{
				if(in_array(1 ,explode(',',$line_data['overcity'])))
				{
					$type = 'cj';
				}
				else
				{
					$type = 'gn';
				}
			}
		}
		$line_data['destName'] = rtrim($destName ,',');


		// 获取热卖线路(相同的第二级目的地)
		$startcityId = $this->session->userdata('city_location_id'); //出发城市id
		$hot_line = $this->line_model->get_hot_line ( $destArr ,$startcityId );
		//var_dump($this->db->last_query());exit();
		if ($hot_line) {
			foreach ( $hot_line as $key => $val ) {
				foreach ( $val as $k => $v ) {
					if ($k == 'linepic') {
						$line_pic = explode ( ',', $v );
						$hot_line[$key]['linepic'] = $line_pic[0];
					}
				}
			}
		}
		
		//获取促销价，促销价为今日之后的最小成人价格
		$minPice = $this->line_model ->getMinPrice($line_id);
		
		$data = array(
				'line_data' => $line_data,
				'album_data' => $album_data,
				'line_property' => $line_property,
				'center_expert' => $center_expert,
				'expert_mind' => $expert_mind,
				'right_expert' => $r_expert,
				'jieshao' => $jieshao,
				'comment_count' => $comment_count,
				'comment_total' => $comment_total,
				'hot_line' => $hot_line,
				'on_line' => $on_line,
				'suit_data' => $suit_data,
// 				'line_info' => $line_info,
				'price_data' => $price_data,
				'productid' => $line_id,
				'collection_count' => $collection_arr[0]['collection_count'],
				'c_userid' => $this->session->userdata('c_userid'),
				'line_id' => $line_id,
				'comment_count_array' =>$comment_count_array,
				'type'=>$type,
				'minPrice' =>empty($minPice['adultprice']) ? $line_data['lineprice'] : $minPice['adultprice'] //没有获取到，则设置为线路价格
		);
		//$this->output->cache(60*24);
		$this->load->view ( 'line/line_detail_view', $data );
	}


	//浏览次数每一次就加一
	function add_shownum(){
		$line_id = $this->input->post('l_id');
		//每次浏览次数都加一
		$status = $this->line_model->update_shownum($line_id);
		echo json_encode($status);
	}


	/*
	 * 获取当月的套餐的价格日历 42天
	 */
	public function get_price_data() {
		$where = array();
		$first_day = date ( 'Y-m-01', time () ); // 当月第一天
		$last_day = date ( 'Y-m-t', time () ); // 当月最后一天

		$first_time = strtotime ( $first_day );
		$last_time = strtotime ( $last_day );
		$first_week = date ( "w", $first_time ); // 当月第一天星期几
		$last_week = date ( "w", $last_time ); // 当月最后一天星期几
		switch ($first_week) {
			case 1 :
				$ftime = $first_time - 3600 * 24;
				$ltime = $ftime + 3600 * 24 * 41;
				$where['day >='] = date ( 'Y-m-d', $ftime );
				$where['day <='] = date ( 'Y-m-d', $ltime );
				break;
			case 2 :
				$ftime = $first_time - 3600 * 24 * 2;
				$ltime = $ftime + 3600 * 24 * 41;
				$where['day >='] = date ( 'Y-m-d', $ftime );
				$where['day <='] = date ( 'Y-m-d', $ltime );
				break;
			case 3 :
				$ftime = $first_time - 3600 * 24 * 3;
				$ltime = $ftime + 3600 * 24 * 41;
				$where['day >='] = date ( 'Y-m-d', $ftime );
				$where['day <='] = date ( 'Y-m-d', $ltime );
				break;
			case 4 :
				$ftime = $first_time - 3600 * 24 * 4;
				$ltime = $ftime + 3600 * 24 * 41;
				$where['day >='] = date ( 'Y-m-d', $ftime );
				$where['day <='] = date ( 'Y-m-d', $ltime );
				break;
			case 5 :
				$ftime = $first_time - 3600 * 24 * 5;
				$ltime = $ftime + 3600 * 24 * 41;
				$where['day >='] = date ( 'Y-m-d', $ftime );
				$where['day <='] = date ( 'Y-m-d', $ltime );
				break;
			case 6 :
				$ftime = $first_time - 3600 * 24 * 6;
				$ltime = $ftime + 3600 * 24 * 41;
				$where['day >='] = date ( 'Y-m-d', $ftime );
				$where['day <='] = date ( 'Y-m-d', $ltime );
				break;
			case 7 :
				$ftime = $first_time;
				$ltime = $ftime + 3600 * 24 * 41;
				$where['day >='] = date ( 'Y-m-d', $ftime );
				$where['day <='] = date ( 'Y-m-d', $ltime );
				break;
		}
		$suit_id = 14; // 套餐id
		$where['suitid'] = $suit_id;
		$price_data = $this->line_model->get_suit_price ( $where );
		echo json_encode ( $price_data );
	}

	/**
	 * 汪晓烽
	 * 2015-05-19 11:26:36
	 * 游客在线咨询
	 */
	function online_consultation() {
		$data = $this->security->xss_clean ( $_POST );
		$verifycode = strtolower ( $data['verify_code'] );
		$data['consultation_content'] = trim($data['consultation_content']);
		$insert_data = array(
				'typeid' => $data['consultation_radio'],
				'content' => $data['consultation_content'],
				'productid' => $data['consultation_productid'],
				'email' => $data['consultation_email'],
				'reply_id'=>0
		);
		$user_id = $this->session->userdata ( 'c_userid' );
		if (! empty ( $user_id )) {
			$insert_data['memberid'] = $this->session->userdata ( 'c_userid' );
		}else{
			echo json_encode ( array(
					'status' => - 2,
					'msg' => '请先登录'
			) );
			exit ();
		}
		if ($verifycode != strtolower ( $this->session->userdata ( 'captcha' ) )) {
			echo json_encode ( array(
					'status' => - 1,
					'msg' => '验证码错误'
			) );
			exit ();
		} elseif(empty($data['consultation_content'])){
			echo json_encode ( array(
					'status' => - 1,
					'msg' => '评论内容不能为空'
			) );
			exit ();
		}elseif(empty($data['consultation_email'])){
			echo json_encode ( array(
					'status' => - 1,
					'msg' => '邮箱不能为空'
			) );
			exit ();
		}else {
			$this->line_model->inert_online_consultation ( $insert_data );
			echo json_encode ( array(
					'status' => 1,
					'msg' => '咨询已提交'
			) );
			exit ();
		}
	}

// 	function ajax_right_expert()
// 	{
// 		echo json_encode(array());
// 	}
	//线路详情,热门咨询专家,点击换一批的时候分页数据
	function ajax_right_expert(){
		$line_id = $this->input->post('line_id',true);
		$line_data = $this->line_model->get_line_detail ( array('l.id' => $line_id) );
		$now_page = $this->input->post('now_page',true);
		$localtion_city = $this->line_model->get_city_localtion();
		$rwhere = array(
				'la.line_id' => $line_id,
				'la.status' => 2,
				'e.status' =>2,
				'e.is_kf !=' => 'Y',
				'e.supplier_id' =>$line_data['supplier_id']
		);
		//直属管家
		$du_expert = $this->line_model->get_expert_data ( $rwhere, 1, 4,$localtion_city);

		$rwhere = array(
				'la.line_id' => $line_id,
				'la.status' => 2,
				'e.status' =>2,
				'e.is_kf !=' => 'Y',
				'e.supplier_id !=' =>$line_data['supplier_id']
		);

		//右侧管家排序
		$dun_expert = $this->line_model->get_expert_data ( $rwhere, 1, 4,$localtion_city);
		//var_dump($dun_expert);exit;
		//$right_expert = array();
		$r_expert = array_merge($du_expert,$dun_expert);
		if (!empty($r_expert))
		{
			//排序规则  第一级：在线的直属管家，第二级：在线的非直属管家，第三级：不在线的直属管家，第四级：不在线的非直属管家
			foreach($r_expert as $key =>$val)
			{
				if ($val['online'] == 2 && $val['supplier_id'] == $line_data['supplier_id'])
				{
					$r_expert[$key]['sort'] = 1;
				}
				elseif ($val['online'] == 2 && $val['supplier_id'] != $line_data['supplier_id'])
				{
					$r_expert[$key]['sort'] = 2;
				}
				elseif ($val['online'] != 2 && $val['supplier_id'] == $line_data['supplier_id'])
				{
					$r_expert[$key]['sort'] = 3;
				}
				else
				{
					$r_expert[$key]['sort'] = 4;
				}
			}
			$lenExpert = count($r_expert) -1;
			$i = 0;
			for($i ;$i <$lenExpert ;$i++)
			{
				$j = 0;
				for ($j ;$j < $lenExpert-$i ;$j ++)
				{
					if($r_expert[$j]['sort'] > $r_expert[$j+1]['sort'])
					{
						$arr = $r_expert[$j];
						$r_expert[$j] = $r_expert[$j+1];
						$r_expert[$j+1] = $arr;
					}
				}
			}
		}
		echo json_encode($r_expert);
	}



	/**
	 *游客点评列表
	 * 全部 满意 不满意 一般
	 */
	public function customer_comments() {
		$line_id = $this->input->post ( 'id' );
		$level = $this->input->post ( 'flag' );
		$page_size = $this->input->post ( 'pageSize' );
		$page_num = $this->input->post ( 'pageIndex' );
		$cowhere['c.line_id'] = $line_id;
		$cowhere['c.isshow'] = 1;
		if ($level == 1 || $level == 2 || $level == 3 || $level == 4 || $level == 5 ) {
			$cowhere['c.avgscore1 <'] = $level+1;
			$cowhere['c.avgscore1 >='] = $level;
		} else if ($level == 6) { // 有照片
			$cowhere['c.haspic'] = 1;
		}
		$page_num = empty ( $page_num ) ? 10 : $page_num;
		$page_size = empty ( $page_size ) ? 2 : $page_size;
		$comment = $this->line_model->get_comment_data ( $cowhere, $page_num, $page_size );
		foreach ($comment as $key=>$val){
			foreach ($val as $k=>$v){
				if($k=="pictures"&&$v){
					$pics = explode(",", $v);
					$val[$k] = $pics;
				}
			}
			$comment[$key] = $val;
		}
		$comment = $this->replace_str($comment,array("\n\r","\n","\r"),"<br />");
		$total = count ( $this->line_model->get_comment_data ( $cowhere, 0, $page_size ) );
		echo json_encode ( array(
				'total' => $total,
				'result' => $comment
		) );
	}

	/**
	 * 获取游客游记分享列表
	 */
	public function customer_share() {
		$line_id = $this->input->post ( 'id' );
		$page_size = $this->input->post ( 'pageSize' );
		$page_num = $this->input->post ( 'pageIndex' );
		$cowhere = $line_id;
		$page_num = empty ( $page_num ) ? 10 : $page_num;
		$page_size = empty ( $page_size ) ? 2 : $page_size;
		$share = $this->line_model->get_share_data ( $cowhere, $page_num, $page_size );
		foreach ($share as $key=>$val){
			foreach ($val as $k=>$v){
				if($k=="pic"&&$v){
					$pics = explode(";", $v);
					$val[$k] = $pics;
				}
			}
			$share[$key] = $val;
		}
		$share = $this->replace_str($share,array("\n\r","\n","\r"),"<br />");
		$total = count ( $this->line_model->get_share_data ( $cowhere, 0, $page_size ) );
		echo json_encode ( array(
				'total' => $total,
				'result' => $share
		) );
	}

	/**
	 * 取消/添加收藏
	 */
	function add_cancle_collect(){
		$userid = $this ->session ->userdata('c_userid');
		if ($userid < 1) {
			echo json_encode(array('status'=>400,'msg'=>'取消收藏'));exit();
		}
		$c_member_id = $this->input->post('c_member_id');
		$collect_count = $this->input->post('collect_count');
		$line_id = $this->input->post('line_id');
		$whereArr = array();
		if($collect_count==0){ //如果没有收藏过就添加收藏
		   $insert_data['member_id'] = $c_member_id;
		   $insert_data['line_id'] = $line_id;
		   $insert_id = $this->line_model->insert_line_collection($insert_data);
		   if($insert_id){
		   	echo json_encode(array('status'=>200,'msg'=>'收藏成功'));exit();
		   }else{
		   	echo json_encode(array('status'=>-200,'msg'=>'收藏失败'));exit();
		   }
		}else{   //如果已经收藏过了,就取消收藏
			$whereArr['member_id'] = $c_member_id;
			$whereArr['line_id'] = $line_id;
			$result = $this->line_model->delete_line_collection($whereArr);
			if($result){
				echo json_encode(array('status'=>200,'msg'=>'取消收藏'));exit();
			}else{
				echo json_encode(array('status'=>-200,'msg'=>'取消收藏失败'));exit();
			}
		}
	}

	function upfile(){
		$this->load->helper ( 'url' );
		$config['upload_path'] = './file/c/img/';
		if(!file_exists("./file/c/img/")){
			mkdir("./file/c/img/",0777,true);//原图路径
		}
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '40000';
		$file_name = 'c_'.date('Y_m_d', time()).'_'.sprintf('%02d', rand(0,99));
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('file'))
		{
			echo json_encode(array('status' => -1,'msg' =>$this->upload->display_errors()));
			exit;
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url =  '/file/c/img/' .$file_info ['upload_data'] ['file_name'];
			echo json_encode(array('status' =>1, 'url' =>$url ));
			exit;
		}
	}

	/**
	 * 替换字符串
	 * 翁金碧
	 * $arr 需要替换的字符串/数组
	 * $orign 需要替换的字符串/数组
	 * $dest 目标字符串/数组
	 *
	 */
	function replace_str($arr="",$orign="",$dest=""){
// 		$in = array('features','introduce','feeinclude','feenotinclude','book_notice','visa_content','content');
		if(is_array($arr)){
			if($arr){
				foreach ($arr as $key=>$val){
					if(is_array($val)){
						if($val){
							foreach ($val as $k=>$v){
								if($v = str_replace($orign, $dest, $v)){
									$val[$k] = $v;
								}
							}
							$arr[$key] = $val;
						}
					}else{
						$arr[$key] =  str_replace($orign, $dest, $val);
					}
				}
			}
		}else{
			$arr = str_replace($orign, $dest, $arr);
		}
		return $arr;
	}

	//获取客人在线留言的列表数据
	function ajax_online_msg(){
		$typeid="";
		$line_id = $this->input->post ( 'id' );
		$typeid = $this->input->post ( 'typeid' );
		$page_size = $this->input->post ( 'pageSize' );
		$page_num = $this->input->post ( 'pageIndex' );
		$page_num = empty ( $page_num ) ? 10 : $page_num;
		$page_size = empty ( $page_size ) ? 2 : $page_size;
		$online_msg = $this->line_model->get_online_msg ( $line_id,$typeid, $page_num, $page_size );
		$online_msg = $this->replace_str($online_msg,array("\n\r","\n","\r"),"<br />");
		$total = count ( $this->line_model->get_online_msg ($line_id, $typeid, 0, $page_size ) );
		echo json_encode ( array(
				'total' => $total,
				'result' => $online_msg
		) );
	}
}