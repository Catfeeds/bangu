<?php
/**
 * 专家订单
 *
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since 2015年3月19日16:21:11
 * @author 徐鹏
 *
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Order extends UB2_Controller {
	public function __construct() {
		parent::__construct ();

		$this->load_model ( 'admin/b2/order_model', 'order' );
	}

	/**
	 * 我的订单
	 *
	 * @param number $page
	 */
	public function index($page = 1) {
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/b2/order/index/';
		$config['pagesize'] = 15;
		$config['page_now'] = $this->uri->segment ( 5, 0 );
		$post_arr = array();
		$dest_id = '';
		$page = $page == 0 ? 1 : $page;

		if ($this->uri->segment ( 5 ) != '') {

			// 产品名称
			if ($this->session->userdata ( 'order_linename' ) != '') {
				$post_arr['mb_od.productname like'] = '%' . $this->session->userdata ( 'order_linename' ) . '%';
			}
			// 目的地
			if ($this->session->userdata ( 'order_destid' ) != '') {
				$post_arr['FIND_IN_SET(' . $this->session->userdata ( 'order_destid' ) . ',l.overcity)>'] = 0;
			}
			// 订单编号
			if ($this->session->userdata ( 'order_ordersn' ) != '') {
				$post_arr['mb_od.ordersn'] = $this->session->userdata ( 'order_ordersn' );
			}
			// 出团日期
			if ($this->session->userdata ( 'usedate' ) != '') {
				$usedata_arr = explode ( ' - ', $this->session->userdata ( 'usedate' ) );
				$start_date_arr = explode ( '-', $usedata_arr[0] );
				$start_date = $start_date_arr[0] . '-' . $start_date_arr[2] . '-' . $start_date_arr[1];
				$end_date_arr = explode ( '-', $usedata_arr[1] );
				$end_date = $end_date_arr[0] . '-' . $end_date_arr[2] . '-' . $end_date_arr[1];
				$post_arr['mb_od.usedate >='] = $start_date;
				$post_arr['mb_od.usedate <='] = $end_date;
			}
			// 订单状态
			if ($this->session->userdata ( 'order_status' ) != '') {
				$post_arr['mb_od.status'] = $this->session->userdata ( 'order_status' );
			}

			// 支付状态
			if ($this->session->userdata ( 'pay_status' ) != '') {
				$post_arr['mb_od.ispay'] = $this->session->userdata ( 'pay_status' );
			}
		} else {

			unset ( $post_arr['mb_od.productname like'] );
			$this->session->unset_userdata ( 'order_linename' );
			unset ( $post_arr['FIND_IN_SET(' . $this->session->userdata ( 'order_destid' ) . ',l.overcity)>'] );
			$this->session->unset_userdata ( 'order_destid' );
			unset ( $post_arr['ordersn'] );
			$this->session->unset_userdata ( 'order_ordersn' );
			unset ( $post_arr['mb_od.usedate >='] );
			unset ( $post_arr['mb_od.usedate <='] );
			$this->session->unset_userdata ( 'usedate' );
			unset ( $post_arr['mb_od.status'] );
			$this->session->unset_userdata ( 'order_status' );
			unset ( $post_arr['mb_od.ispay'] );
			$this->session->unset_userdata ( 'pay_status' );
		}
		// 如果是搜索表单提交过来, 接受表单数据, 覆盖$post_arr中的数据,再搜索
		//if ($this->is_post_mode()) {
		// 产品名称
		if ($this->input->post ( 'linename' ) != '') {
			$post_arr['mb_od.productname like'] = '%' . $this->input->post ( 'linename' ) . '%';
			$this->session->set_userdata ( array(
					'order_linename' => $this->input->post ( 'linename' )
			) );
		}
		// 目的地
		if ($this->input->post ( 'destination' ) != '') {
			$post_arr['FIND_IN_SET(' . $this->input->post ( 'destination' ) . ',l.overcity)>'] = 0;
			$this->session->set_userdata ( array(
					'order_destid' => $this->input->post ( 'destination' )
			) );
		}

		// 订单编号
		if (trim($this->input->post ( 'ordersn' )) != '') {
			$post_arr['mb_od.ordersn'] = trim($this->input->post ( 'ordersn' ));
			$this->session->set_userdata ( array(
					'order_ordersn' => trim($this->input->post ( 'ordersn' ))
			) );
		}
		// 出团日期
		if ($this->input->post ( 'usedate' ) != '' && $this->input->post ( 'usedate' ) != '出团时间') {
			$usedata_arr = explode ( ' - ', $this->input->post ( 'usedate' ) );

			$start_date_arr = explode ( '-', $usedata_arr[0] );
			$start_date = $start_date_arr[0] . '-' . $start_date_arr[2] . '-' . $start_date_arr[1];
			$end_date_arr = explode ( '-', $usedata_arr[1] );
			$end_date = $end_date_arr[0] . '-' . $end_date_arr[2] . '-' . $end_date_arr[1];
			$post_arr['mb_od.usedate >='] = $start_date;
			$post_arr['mb_od.usedate <='] = $end_date;

			$this->session->set_userdata ( array(
					'usedate' => $this->input->post ( 'usedate' )
			) );
		}
		// 订单状态
		if ($this->input->get_post ( 'status' ) != '') {
			$post_arr['mb_od.status'] = $this->input->get_post ( 'status' );
			$this->session->set_userdata ( array(
					'order_status' => $this->input->get_post ( 'status' )
			) );
		}

		// 支付状态
		if ($this->input->get_post ( 'pay_status' ) != '') {
			$post_arr['mb_od.ispay'] = $this->input->get_post ( 'pay_status' );
			$this->session->set_userdata ( array(
					'pay_status' => $this->input->get_post ( 'pay_status' )
			) );
		}
		if($this->input->get( 'pay_status' ) != '' && $this->input->get( 'status' ) != '' ){
			$cal_pay_status = $this->input->get( 'pay_status' );
			$cal_order_status = $this->input->get( 'status' );
			$update_sql = "update cal_expert_order_status set isread=1 where expert_id=$this->expert_id and order_ispay=$cal_pay_status and order_status=$cal_order_status";
			$this->db->query($update_sql);
		}
		$destinations = $this->order->get_destinations ();
		$post_arr['mb_od.expert_id'] = $this->expert_id;
		$config['pagecount'] = $this->order->get_expert_orders ( $post_arr, 0, $config['pagesize']);
		$order_list = $this->order->get_expert_orders ( $post_arr, $page, $config['pagesize'] );
		//print_r($this->db->last_query());exit();
		$this->page->initialize ( $config );
		$data = array(
				'order_list' => $order_list,
				'order_linename' => $this->session->userdata ( 'order_linename' ),
				'order_ordersn' => $this->session->userdata ( 'order_ordersn' ),
				'order_status' => $this->session->userdata ( 'order_status' ),
				'pay_status' => $this->session->userdata ( 'pay_status' ),
				'usedate' => $this->session->userdata ( 'usedate' ),
				'dest' => $destinations,
				'destnation_check' => $this->session->userdata ( 'order_destid' )
		);
		$this->load_view ( 'admin/b2/order', $data );
	}


	/**
	 * [ajax_order_list 获取订单列表数据]
	 * @return [type] [description]
	 */
	/*function ajax_order_list(){


		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $exchange_info
            	);
		echo json_encode($data);
	}*/



	/**
	 * [order_detail_info 订单详情页面]
	 *
	 * @return [type] [description]
	 */
	function order_detail_info() {
		$post_arr = array();
		$order_id = $this->input->get ( 'id' );
		$post_arr['mo.id'] = $order_id;
		$order_detail_info = $this->order->get_order_detail ( $post_arr );
		//echo $this->db->last_query();
		$order_people = $this->order->get_order_people ( $post_arr );
		$order_insurance = $this->order->get_order_insurance ($order_id);
		$order_invoice = $this->order->get_order_invoice (array("mo.order_id"=>$order_id));

		//国内证件类型
		$certificate_type_domestic = $this->order->get_certificate_type (array('pid'=>99));
		//国外证件类型
		$certificate_type_abroad = $this->order->get_certificate_type (array('pid'=>100));
		$order_detail_data =$this->order->sel_data('u_order_detail',array('order_id'=>$order_id));//订单详情
		$data = array(
				'order_detail_info' => $order_detail_info[0],
				'order_id' => $order_id,
				'order_people' => $order_people,
				'order_insurance'=>$order_insurance,
				'certificate_type_domestic' => $certificate_type_domestic,
				'certificate_type_abroad' => $certificate_type_abroad,
				'order_detail_data'=>$order_detail_data,
				'order_invoice' => $order_invoice

		);
		$this->load_view ( 'admin/b2/order_detail_info', $data );
	}

	//获取保险的详细信息
	function get_insurance_detail(){
		$insurance_id = $this->input->post('insurance_id');
		$insurance_info = $this->order->get_insurance_detail($insurance_id);
		echo json_encode($insurance_info[0]);
	}

	/**
	 *
	 * @method 获取线路的行程
	 * @author 贾开荣
	 * @since 2015-06-02
	 */
	public function get_line_jieshao() {
		$id = intval ( $_POST['id'] );
		$this->load_model ( 'admin/b2/line_jieshao_model', 'line_model' );
		$data = $this->line_model->all ( array(
				'lineid' => $id
		), "day  asc" );
		echo json_encode ( $data );
	}

	/**
	 * 增加/修改参团人的数据
	 * 汪晓烽
	 */
	function edit_add_people() {
		$this->load->helper ( 'regexp' );
		$data = $this->security->xss_clean ( $_POST );
		$people_id = $data['people_id'];
		$order_id = $data['order_id'];
		$people_num = $data['people_num'];
		$people_count = $this->order->get_added_people ( array(
				'mom.order_id' => $order_id
		) );
		$insert_data = array(
				'name' => $data['people_name'],
				'certificate_type' => $data['certificate_type'],
				'certificate_no' => $data['certificate_no'],
				'endtime' => $data['endtime'],
				'telephone' => $data['telephone'],
				'sex' => $data['sex'],
				'birthday' => $data['birthday']
		);
		/*if (! regexp ( 'cid', $data['certificate_no'] )) {
			echo json_encode ( array(
					'status' => - 11,
					'msg' => '证件号码格式不对'
			) );
			exit ();
		}*/
		if (! regexp ( 'mobile', $data['telephone'] )) {
			echo json_encode ( array(
					'status' => - 11,
					'msg' => '手机号码格式不对'
			) );
			exit ();
		}
		if (empty ( $data['people_id'] )) {
			if ($people_count[0]['add_people_count'] + 1 <= $people_num) {
				$insert_data['addtime'] = date ( 'Y-m-d H:i:s' );
				$status = $this->db->insert ( 'u_member_traver', $insert_data );
				if (empty ( $status )) {
					echo json_encode ( array(
							'status' => - 11,
							'msg' => '添加失败'
					) );
					exit ();
				} else {
					$insert_data_m = array(
							'order_id' => $data['order_id'],
							'traver_id' => $this->db->insert_id ()
					);
					$this->db->insert ( 'u_member_order_man', $insert_data_m );
					echo json_encode ( array(
							'status' => 1,
							'msg' => '添加成功'
					) );
					exit ();
				}
			} else {
				echo json_encode ( array(
						'status' => - 10,
						'msg' => '添加的人数超过出行人数上限了'
				) );
				exit ();
			}
		} else {
			$insert_data['modtime'] = date ( 'Y-m-d H:i:s' );
			$this->db->where ( 'id', $data['people_id'] );
			$this->db->update ( 'u_member_traver', $insert_data );
			echo json_encode ( array(
					'status' => 1,
					'msg' => '修改成功'
			) );
			exit ();
		}
	}

	/**
	 * 获取一条参团人数据
	 */
	function get_one_people() {
		$post_arr = array();
		$people_id = $this->input->post ( 'id' );
		$post_arr['mt.id'] = $people_id;
		$order_people = $this->order->get_order_people ( $post_arr );
		echo json_encode ( $order_people[0] );
	}

	/**
	 * 汪晓烽
	 * [export_excel 导出出团人为Excel]
	 */
	function export_excel() {
		$this->load->library ( 'PHPExcel' );
		$this->load->library ( 'PHPExcel/IOFactory' );
		$post_arr = array();
		$order_id = $this->input->post ( 'id' );
		$post_arr['mo.id'] = $order_id;
		$order_people = $this->order->get_order_people ( $post_arr );
		$style_array = array('font' => array('bold' => true),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$one_style_array = array_pop($style_array);
		$objPHPExcel = new PHPExcel ();
		$objPHPExcel->getProperties ()->setTitle ( "export" )->setDescription ( "none" );
		$objPHPExcel->setActiveSheetIndex ( 0 );

		$objActSheet = $objPHPExcel->getActiveSheet ();
		$objActSheet->getColumnDimension ( 'A' )->setWidth ( 5 );
		$objActSheet->getColumnDimension ( 'B' )->setWidth ( 15 );
		$objActSheet->getColumnDimension ( 'C' )->setWidth ( 15 );
		$objActSheet->getColumnDimension ( 'D' )->setWidth ( 20 );
		$objActSheet->getColumnDimension ( 'E' )->setWidth ( 20 );
		$objActSheet->getColumnDimension ( 'F' )->setWidth ( 20 );
		$objActSheet->getColumnDimension ( 'G' )->setWidth ( 5 );
		$objActSheet->getColumnDimension ( 'H' )->setWidth ( 20 );

		$objActSheet->setCellValue ( "A1", '序号' );
		$objActSheet->getStyle ( 'A1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'B1', '姓名' );
		$objActSheet->getStyle ( 'B1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'C1', '证件类型' );
		$objActSheet->getStyle ( 'C1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'D1', '证件号码' );
		$objActSheet->getStyle ( 'D1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'E1', '有效期' );
		$objActSheet->getStyle ( 'E1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'F1', '手机号码' );
		$objActSheet->getStyle ( 'F1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'G1', '性别' );
		$objActSheet->getStyle ( 'G1' )->applyFromArray ($style_array);
		$objActSheet->setCellValue ( 'H1', '出生年月' );
		$objActSheet->getStyle ( 'H1' )->applyFromArray ($style_array);

		if (! empty ( $order_people )) {
			$i = 0;
			foreach ( $order_people as $key => $value ) {
				$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), $value['id'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'A' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'B' . ($i + 2), $value['m_name'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'B' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'C' . ($i + 2), $value['certificate_type'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'C' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'D' . ($i + 2), $value['certificate_no'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'D' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'E' . ($i + 2), date ( 'Y-m-d', strtotime ( $value['endtime'] ) ), PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'E' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'F' . ($i + 2), $value['telephone'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'F' . ($i + 2) )->applyFromArray ($one_style_array);
				if ($value['sex'] == 1) {
					$sex = '男';
				} elseif ($value['sex'] == - 1) {
					$sex = '保密';
				} else {
					$sex = '女';
				}
				$objActSheet->setCellValueExplicit ( 'G' . ($i + 2), $sex, PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'G' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'H' . ($i + 2), date ( 'Y-m-d', strtotime ( $value['birthday'] ) ), PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'H' . ($i + 2) )->applyFromArray ($one_style_array);
				$i ++;
			}
		}

		$objWriter = IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
		list( $ms, $s ) = explode ( ' ', microtime () );
		$ms = sprintf ( "%03d", $ms * 1000 );
		$g_session = date ( 'YmdHis' ) . "_" . $ms . "_" . rand ( 1000, 9999 );
		$file = "file/b2/upload/" . $g_session . ".xlsx";
		$objWriter->save ( $file );
		echo json_encode ( $file );
	}

	/**
	 * [import_excel 导出Excel格式的联系人]
	 *
	 * @return [type] [description]
	 */
	function import_excel() {
		$this->load->library ( 'PHPExcel' );
		$this->load->library ( 'PHPExcel/IOFactory' );
		$this->load->helper ( 'url' );
		$this->load->helper ( array('form', 'url'));
		$order_id = $this->input->post ( 'excel_order_id' );
		$people_num = $this->input->post ( 'people_num' );
		$config['upload_path'] = './file/b2/upload/';
		$config['allowed_types'] = 'xls|xlsx';
		$config['max_size'] = '40000';
		list( $ms, $s ) = explode ( ' ', microtime () );
		$ms = sprintf ( "%03d", $ms * 1000 );
		$g_session = date ( 'YmdHis' ) . "_" . $ms . "_" . rand ( 1000, 9999 );
		$file_name = $g_session . '.xlsx';
		$config['file_name'] = $file_name;
		$this->load->library ( 'upload', $config );
		$this->upload->initialize ( $config );
		$upload_status = $this->upload->do_upload ( 'people_excel' );
		if (!$upload_status) {
			echo "<script>alert('请先选择对应的Excel文件在点击导入!');location.href='" . $_SERVER["HTTP_REFERER"] . "'</script>";
			exit();
		}else{
		$file_info = array( 'upload_data' => $this->upload->data () );
		$file_path = './file/b2/upload/' . $file_info['upload_data']['file_name'];


		$objReader = IOFactory::createReader ( 'Excel2007' );
		$PHPExcel = $objReader->load ( $file_path );
		$sheet = $PHPExcel->getSheet ( 0 ); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow (); // 取得总行数
		$highestColumm = $sheet->getHighestColumn (); // 取得总列数
		$people_count = $this->order->get_added_people ( array(
				'mom.order_id' => $order_id
		) );
		if (($people_count[0]['add_people_count'] + $highestRow - 1) <= $people_num) {
			/**
			 * 循环读取每个单元格的数据
			 */
			for($row = 2; $row <= $highestRow; $row ++) { // 行数是以第1行开始,但是只取从第二行开始的数据
				$insert_data = array(
						'name' => $sheet->getCell ( 'A' . $row )->getValue (),
						'certificate_type' => $sheet->getCell ( 'B' . $row )->getValue (),
						'certificate_no' => $sheet->getCell ( 'C' . $row )->getValue (),
						'endtime' => $sheet->getCell ( 'D' . $row )->getValue (),
						'telephone' => $sheet->getCell ( 'E' . $row )->getValue (),
						'birthday' => $sheet->getCell ( 'G' . $row )->getValue (),
						'addtime' => date ( 'Y-m-d H:i:s' )
				);
				if ($sheet->getCell ( 'F' . $row )->getValue () == '男') {
					$insert_data['sex'] = 1;
				} elseif ($sheet->getCell ( 'F' . $row )->getValue () == '保密') {
					$insert_data['sex'] = - 1;
				} else {
					$insert_data['sex'] = 0;
				}
				$this->db->insert ( 'u_member_traver', $insert_data );
				$insert_data_m = array(
						'order_id' => $order_id,
						'traver_id' => $this->db->insert_id ()
				);
				$this->db->insert ( 'u_member_order_man', $insert_data_m );
			}
			echo "<script>location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
		} else {
			echo "<script>alert('添加的人数超过出行人数上限了');location.href='" . $_SERVER["HTTP_REFERER"] . "'</script>";
		}
	    }
	}

	/**
	 * 汪晓烽
	 */
	function change_order_price() {
		$order_id = $this->input->post ( 'order_id', true );
		$change_amount = $this->input->post ( 'change_amount', true );
		$old_amount = $this->input->post ( 'old_amount', true );
		$insur_amount = $this->input->post ( 'insur_amount', true );
		$reason = $this->input->post ( 'reason', true );
		$reason = trim ( $reason );
		if ($change_amount < 0) {
			echo json_encode ( array(
					'status' => - 1,
					'msg' => '订单金额不能为小于0'
			) );
			exit ();
		}
		if (empty ( $reason )) {
			echo json_encode ( array(
					'status' => - 3,
					'msg' => '修改理由必填'
			) );
			exit ();
		}
		//$update_sql = "update u_member_order set total_price=$change_amount where id=$order_id";
		$insert_data = array(
			'order_id'=>$order_id,
			'expert_id'=>$this->expert_id,
			'before_price'=>$old_amount+$insur_amount,
			'after_price'=>$change_amount+$insur_amount,
			'addtime'=>date('y-m-d H:i:s'),
			'modtime'=>date('y-m-d H:i:s'),
			'status'=>0,
			'expert_reason'=>$reason
			);
		if ($this->db->insert ('u_order_price_apply', $insert_data)) {
			$data = array(
					'order_id' => $order_id,
					'op_type' => 1,
					'userid' => $this->expert_id,
					'content' => '管家' . $this->session->userdata ( 'real_name' ) . '修改了订单价格,由' . $old_amount . '元修改为' . $change_amount . '元,修改原因:' . $reason,
					'addtime' => date ( 'Y-m-d H:i:s' )
			);
			$this->db->insert ( 'u_member_order_log', $data );
			echo json_encode ( array(
					'status' => 1,
					'msg' => '修改成功'
			) );
			exit ();
		} else {
			echo json_encode ( array(
					'status' => - 2,
					'msg' => '修改失败'
			) );
			exit ();
		}
	}

	//订单转团--遍历订单线路的套餐价格
	function get_line_suitprice(){
		$id=$this->input->post('id',true);
		if($id>0){
			//订单信息
			$expert_id=$this->expert_id;
			$where=" mb_od.expert_id={$expert_id} and mb_od.id={$id}";
			$order=$this->order->get_line_order_data($where);

                                      //订单套餐
			$suit=$this->order->get_line_order_suit($id,$order['suitid']);

			//当前的订单套餐日期
			$date=$this->order->get_order_date($id);
			$arrayName = array(
				'status' =>1 ,
				'order' =>$order ,
				'suit' =>$suit ,
				'date'=> $date
				);
			 echo json_encode($arrayName);
		}else{
 			echo json_encode(array('status'=>-1,'msg'=>'获取数据失败!'));
		}

	}
	//订单转团--订单线路的套餐日期价格
	function get_price_date(){
		$id=$this->input->post('id',true);
		$orderid=$this->input->post("orderid",true);
		if($id>0 && $orderid>0 ){
		         $date_price=" ";
		         $order=$this->order->sel_data("u_member_order",array('id'=>$orderid));

		         if(!empty($order['usedate'])){
			 $usedate=$order['usedate'];
			 $where="lsp.suitid  =  {$id} and  CURDATE()< lsp.day ";
			 $date_price=$this->order->get_table_data( $where);
			// echo $this->db->last_query();
		         }
		           echo json_encode(array('status'=>1,'date'=> $date_price));
		}else{
		          echo json_encode(array('status'=>-1,'msg'=>'获取数据失败!'));
		}
	}
	//获取总的价格
	 function get_total_price() {
	               $id=$this->input->post('id',true);
	               $orderid=$this->input->post('orderid',true);
	               if($id>0 && $orderid>0){
 		             $where="lsp.dayid  =  {$id}  and mb_od.id=".$orderid;
			$suitPrice=$this->order->sel_data("u_line_suit_price" ,array("dayid "=>$id));  //套餐日期价格
                                      $orderData=$this->order->sel_data("u_member_order" ,array("id "=>$orderid));  //订单价格
                                      $orderSuit=$this->order->sel_data("u_line_suit" ,array("id "=>$orderData['suitid']));  //订单套餐

                                      $suitPrice0=$this->order->sel_data("u_line_suit_price" ,array("lineid "=>$orderData['productautoid'],'suitid'=>$orderData['suitid'],'day'=>$orderData['usedate']));  //修改前套餐日期价格
                                 //     $old_price=$this->getCountMoney($orderSuit['unit'],$suitPrice0,$orderData); //修改前的总价格
                                      $total_price=$this->getCountMoney($orderSuit['unit'],$suitPrice,$orderData);  //修改后的总价格
                                 //     $diff_price= $total_price-$old_price;
			// $date_price=$this->order->get_table_data( $where);
			 echo json_encode(array('status'=>1,'date'=> $suitPrice,'total_price'=> $total_price));
	               }else{
		        echo json_encode(array('status'=>-1,'msg'=>'获取数据失败!'));
	               }
	}
	//获取价格
             protected function getCountMoney($unit,$suitPrice ,$order) {
		 $childprice=$order['childnum'] *$suitPrice ['childprice'] ;
		 $adultprice=$order['dingnum']*$suitPrice ['adultprice'] ;
		 $oldprice=$order['oldnum']*$suitPrice['oldprice'] ;
		 $childnobedprice= $order['childnobednum']*$suitPrice['childnobedprice'];
		 if($unit>1){
                                 $money =$order['suitnum']*$suitPrice ['adultprice'];
		 }else{
		       $money = $childprice+  $adultprice+  $oldprice+ $childnobedprice;
		 }

		return intval($money);
	}

	//订单日期转化
	function return_order_date(){

		//var_dump($_POST);
                          $dayid=$this->input->post('suit_date',true); //套餐日期价格ID
                          $suitid=$this->input->post('line_suit',true);  //套餐ID
                          $orderid=$this->input->post('order_id',true); //订单ID
                          $expert_id=$this->expert_id;
                       //   var_dump($suitid);
                          if(empty($suitid)){
                                     echo json_encode(array('status'=>-1,'msg'=>'请选择套餐'));
                                     exit;
                          }
                          if(empty($dayid)){
                                     echo json_encode(array('status'=>-1,'msg'=>'请选择套餐日期'));
                                     exit;
                          }
                          //是否有退款中的单
                          $refund=$this->order->sel_data("u_refund" ,array("order_id"=>$orderid,'status'=>0));  //套餐日期价格
                          if(!empty($refund)){
                                     echo json_encode(array('status'=>-1,'msg'=>'需等平台退款完后才可以转团'));
                                     exit;
                          }

 		     $orderData=$this->order->sel_data("u_member_order" ,array("id "=>$orderid));  //订单价格

	               $suitPrice=$this->order->sel_data("u_line_suit_price" ,array("dayid "=>$dayid));  //修改后套餐日期价格

                          $orderSuit=$this->order->sel_data("u_line_suit" ,array("id "=>$orderData['suitid']));  //订单套餐
                          $suitPrice0=$this->order->sel_data("u_line_suit_price" ,array("lineid "=>$orderData['productautoid'],'suitid'=>$orderData['suitid'],'day'=>$orderData['usedate']));  //修改前套餐日期价格
                          $total_price=$this->getCountMoney($orderSuit['unit'],$suitPrice,$orderData);  //没有优惠后的价格
                          $old_price=$orderData['order_price'];

                          //提前几天报名
                          $line=$this->order->sel_data('u_line',array('id'=>$orderData['productautoid']));
                          $date=date("Y-m-d",time());
                          if(!empty($line['linebefore'])){
                          	  $datetime=date("Y-m-d",strtotime("+{$line['linebefore']} day",strtotime("{$date}")));
	                          if($datetime>$suitPrice['day']){
				echo json_encode(array('status'=>-1,'msg'=>'需提前'.$line['linebefore'].'天转团'));
	                                  exit;
	                          }
                          }

                          //原来订单的人数
		 if($orderSuit['unit']>1){
		            $member=$orderData['suitnum'];
		 }else{
		 	$member= $orderData['dingnum']+$orderData['childnum']+$orderData['childnobednum']+$orderData['oldnum'];
		 }

		 //现在订单人数
		 if($suitPrice['number']<$member){  //套餐人数不够
		 	echo json_encode(array('status'=>-1,'msg'=>'当前出团日期对应的余位不足，请选择其它出团日期'));
		 	exit;
 		}

		//订单转换订单套餐日期
		$re=$this->order->return_order_siutDate($total_price,$old_price,$suitid,$dayid,$orderid, $expert_id,$suitPrice);
		if($re==1){
		          $content='由于各种原因,管家已帮您转团,待供应商确认,出发时间:'.$orderData['usedate'];
                                   $this->load->model('admin/b1/order_status_model','order_model');
		           $this->order_model->order_log($orderData['id'], $content,$expert_id,$orderData['status']);
   		           echo json_encode(array('status'=>1,'msg'=>'转团已提交成功，待供应商审核确认！'));
		}elseif($re==2){
                                      echo json_encode(array('status'=>-1,'msg'=>'当前出团日期对应的余位不足，请选择其它出团日期'));
		}else{
		           echo json_encode(array('status'=>-1,'msg'=>'操作失败!'));
		}
	}

	//拒绝订单转团
	function dis_order_date(){
		   $id=$this->input->post('id',true); //套餐日期价格ID
		   $re=$this->load->update_tabledata('u_member_order_diff',array('status'=>2), array('id'=>$id));
		   if($re){
                                  echo json_encode(array('status'=>1,'msg'=>'操作成功'));
		   }else{
		         echo json_encode(array('status'=>-1,'msg'=>'操作失败!'));
		   }
	}

}