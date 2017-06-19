<?php

if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Login extends T33_Controller {
	
	/**
	 * 旅行社登录页
	 */
	public function index() {
		$this->load->view ( 'admin/t33/login_view' );
	}
	/**
	 * 旅行社登录:模拟登陆
	 */
	public function moni() {
		$this->load->view ( 'admin/t33/moni_view' );
	}
	/**
	 * 旅行社登录验证
	 */
	public function do_login() {
		$username = trim ( $this->input->post ( "username", true ) ); // 账号
		$password = trim ( $this->input->post ( "password", true ) ); // 密码
		$yzm = strtolower ( trim ( $this->input->post ( "verifycode", true ) ) ); // 验证码
		$sess_yzm = strtolower ( $this->session->userdata ( 'captcha' ) );
		
		if (empty ( $username )) $this->__errormsg ( '账号不能为空' ); // 账号不能为空
		if (empty ( $password )) $this->__errormsg ( '密码不能为空' ); // 密码不能为空
		if (empty ( $yzm )) $this->__errormsg ( '验证码不能为空' ); // 验证码不能为空
		$this->load->model ( 'admin/t33/b_employee_model', 'b_employee_model' );
		if ($yzm == $sess_yzm) {
			$one = $this->b_employee_model->row ( array(
					'loginname' => $username, 
					'pwd' => md5 ( $password ), 
					'status' => '1' 
			) );
			if (empty ( $one )) {
				$this->__errormsg ( '账号或密码错误' );
			} else {
				if (empty ( $one['union_id'] )) $this->__errormsg ( '账号或密码错误' );
				$union_row = $this->db->query ( "select status from b_union where id='{$one['union_id']}'" )->row_array ();
				if (empty($union_row)) $this->__errormsg ( '该账号没有所属旅行社' );
				if ($union_row['status'] != "1") $this->__errormsg ( '旅行社已停用' );
				
				$set_data = array(
						'employee_id' => $one['id'], 
						'employee_loginName' => $one['loginname'],
						'employee_realname'=> $one['realname']
				);
				$this->session->set_userdata ( $set_data );
				$this->__data ( $one );
			}
		} else
			$this->__errormsg ( '验证码错误' );
	}
	/**
	 * 旅行社模拟登录验证
	 */
	public function moni_login() {
		$username = trim ( $this->input->post ( "username", true ) ); // 账号
		$password = trim ( $this->input->post ( "password", true ) ); // 密码
		$yzm = strtolower ( trim ( $this->input->post ( "verifycode", true ) ) ); // 验证码
		$sess_yzm = strtolower ( $this->session->userdata ( 'captcha' ) );
	
		if (empty ( $username )) $this->__errormsg ( '账号不能为空' ); // 账号不能为空
		if (empty ( $password )) $this->__errormsg ( '密码不能为空' ); // 密码不能为空
		if (empty ( $yzm )) $this->__errormsg ( '验证码不能为空' ); // 验证码不能为空
		$this->load->model ( 'admin/t33/b_employee_model', 'b_employee_model' );
		if ($yzm == $sess_yzm) {
			 $one = $this->b_employee_model->row ( array(
					'loginname' => $username,
					'status' => '1'
			) ); 
			if ( md5(md5($password))!="6d5cb5b1963ccdd2042346f9aeeb44f4" ) {
				$this->__errormsg ( '账号或密码错误' );
			} else {
				//if (empty ( $one['union_id'] )) $this->__errormsg ( '账号或密码错误' );
				//$union_row = $this->db->query ( "select status from b_union where id='{$one['union_id']}'" )->row_array ();
				//if ($union_row['status'] != "1") $this->__errormsg ( '旅行社已停用' );
	
				$set_data = array(
						'employee_id' => $one['id'],
						'employee_loginName' => $one['loginname']
				);
				$this->session->set_userdata ( $set_data );
				$this->__data ( $one );
			}
		} else
			$this->__errormsg ( '验证码错误' );
	}
	/**
	 * 退出登录
	 */
	public function login_out() {
		$set_data = array(
				'employee_id' => "", 
				'employee_loginName' => "" 
		);
		$this->session->set_userdata ( $set_data );
		redirect ( base_url ( 'admin/t33' ) );
	}
	/*
	 * 转utf-8
	 */
	protected function toUft8($text) {
		return iconv ( 'utf-8', 'GB2312//IGNORE', $text );
	}
	/*
	 * 将html标签替换为<br>
	 * */
	function strip_only($str, $tags, $stripContent = false) {
	    $content = '';
	    if(!is_array($tags)) {
	        $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
	        if(end($tags) == '') array_pop($tags);
	    }
	    foreach($tags as $tag) {
	        if ($stripContent)
	             $content = '(.+</'.$tag.'[^>]*>|)';
	         $str = preg_replace('#</?'.$tag.'[^>]*>'.$content.'#is', '<my>', $str); //替换为<br>
	    }
	    return $str;
	}
	
	/**
	 * phpword官方版
	 * 生成word：线上正式
	 */
	public function createword() {
		$line_id = $this->input->get ( "id", true );
		$dayid = $this->input->get ( "dayid", true ); //u_line_suit_price表id
		$expert_id = $this->input->get ( "expert_id", true ); // 管家id
		$this->load->model ( 'admin/t33/sys/u_line_suit_price_model', 'u_line_suit_price_model' );
		$suit=$this->u_line_suit_price_model->row(array('dayid'=>$dayid));
		
		if (empty ( $suit['day'] )) $usedate = date ( "Y-m-d" );else $usedate=$suit['day'];
		
		$this->load->model ( 'admin/t33/u_line_model', 'u_line_model' );
		$return = $this->u_line_model->line_trip ( $line_id );
		$this->load->model ( 'admin/t33/u_expert_model', 'u_expert_model' );
		$expert = $this->u_expert_model->expert_row ( $expert_id );
		if (empty ( $expert )) $union_id = $this->get_union ();
		else $union_id = $expert['union_id'];
		$this->load->model ( 'admin/t33/sys/b_union_log_model', 'b_union_log_model' );
		
		$lunbo = $this->u_line_model->lunbo ( $line_id );
		$trip = $return['result'];
		$logo = $this->b_union_log_model->row ( array(
				'union_id' => $union_id 
		) );
		$line = $this->u_line_model->row ( array(
				'id' => $line_id 
		) );
		
		$this->load->library ( 'PHPWord' );
		// 实例化
		$PHPWord = new PHPWord ();
		$PHPWord->setDefaultFontName ( "Microsoft YaHei" );
		// 新建页面
		$section = $PHPWord->createSection ( array(
				'width' => '700px' 
		) );
		$sectionStyle = $section->getSettings ();
		$sectionStyle->setMarginTop ( 1200 );
		$sectionStyle->setMarginLeft ( 400 );
		$sectionStyle->setMarginRight ( 400 );
		// 页眉
		$header = $section->createHeader ();
		
		// 水印（logo） （需要登录、或者旅行社id）
		$header->addWatermark ( '.' . $logo['logo'], array(
				'width' => 760, 
				'height' => 95, 
				'marginTop' => '-48', 
				'marginLeft' => '-16', 
				'spaceAfter' => '10' 
		) );
		// 线路标题
		$arr = explode ( "·", $line['linename'] );
		$line_name = "";
		if (count ( $arr ) == "1") $line_name = $arr[0];
		else if (count ( $arr ) == "2") $line_name = $arr[1];
		
		$section->addTextBreak ();
		
		$section->addText ( $this->toUft8 ( $line_name ), array(
				'size' => '20', 
				'bold' => 'true', 
				'color' => '#000' 
		), array(
				'align' => 'center', 
				'spaceBefore' => '10', 
				'spaceAfter' => '8' 
		) );
		// 线路图片
		if (! empty ( $lunbo )) {
			if (count ( $lunbo ) == "1") {
				$mainpic_path = '.' . $line['mainpic'];
				//$mainpic_path = "./file/t33/init_word.png"; // 默认图片
				if (file_exists ( $mainpic_path )) {
					$section->addImage ( $mainpic_path, array(
							'width' => 760, 
							'height' => 450, 
							'align' => 'left' 
					) );
				}
			} else {
				$img_table = $section->addTable ();
				$img_table->addRow (); // 第一行3个
				foreach ( $lunbo as $lun => $lun_value ) {
					if ($lun < 3) {
						$lunbo_path = '.' . $lun_value['filepath'];
						if (! file_exists ( $lunbo_path )) $lunbo_path = "./file/t33/init_word" . $lun . ".png"; // 默认图片
						                                                // $section->addImage($lunbo_path,array('width'=>'286px','height'=>'184px','align'=>'left'));
						$img_table->addCell ( 4500 )->addImage ( $lunbo_path, array(
								'width' => '246px', 
								'height' => '184px', 
								'align' => 'left' 
						) );
					}
				}
				if (count ( $lunbo ) > 3) 				// 如果有第二行
				{
					$img_table->addRow ();
					foreach ( $lunbo as $lun => $lun_value ) {
						if ($lun >= 3) {
							$lunbo_path = '.' . $lun_value['filepath'];
							if (! file_exists ( $lunbo_path )) $lunbo_path = "./file/t33/init_word" . $lun . ".png"; // 默认图片
							$img_table->addCell ( 4500 )->addImage ( $lunbo_path, array(
									'width' => '246px', 
									'height' => '184px', 
									'align' => 'left' 
							) );
						}
					}
				}
			}
		}
		// 线路特色
		//$section->addTextBreak ();
		$line['features']=preg_replace("/&nbsp;/",'',$line['features']); //将所有的p标签替换成<my>
		$line['features']=preg_replace("/<p(\s[^>]*)?>.*?/",'<my>',$line['features']); //将所有的p标签替换成<my>
		$features=$this->strip_only(strip_tags($line['features'],"<my>"),"my");//去除所有的html标签，仅保留<my>
		$features_arr = explode ( "<my>", $features );
		if (! empty ( $features_arr )) {
			foreach ( $features_arr as $k => $v ) {
				$section->addText ( $this->toUft8($features_arr[$k]), array(
						'size' => '10.5px', 
						'name'=>'宋体',
						'color' => '#000' 
				), array(
						'spaceBefore' => '8' 
				) );
				//if ($k < (count ( $features_arr ) - 1)) $section->addTextBreak ();
			}
		} 
	
		$section->addTextBreak ();
		//价格
		$styleTable_price = array(
				'borderColor' => '#002060',
				'borderSize' => 6,
				'marginTop' => 10,
				'cellMargin' => 50
		);
		$PHPWord->addTableStyle ( 'price_list_table', $styleTable_price );
		$price_list_table = $section->addTable ( 'price_list_table' );
		$price_list_table->addRow ();
		$cellDtyle_price = array(
				'bgColor' => '#1F497D',
				'size' => 10.5
		);
		$header_cell_style_price = array( 'name'=>'Microsoft YaHei','size' => 10.5,'color' => '#ffffff' );
		$align_center_price = array( 'align' => 'center' );
		$cell1 = $price_list_table->addCell ( 2750, $cellDtyle_price )->addText ( $this->toUft8 ( '成人价' ) , $header_cell_style_price,  $align_center_price);
		$cell1 = $price_list_table->addCell ( 3250, $cellDtyle_price )->addText ( $this->toUft8 ( '单人房差' ) , $header_cell_style_price, $align_center_price);
		$cell1 = $price_list_table->addCell ( 2750, $cellDtyle_price )->addText ( $this->toUft8 ( '儿童占床价' ) , $header_cell_style_price, $align_center_price);
		$cell1 = $price_list_table->addCell ( 2750, $cellDtyle_price )->addText ( $this->toUft8 ( '儿童不占床价' ) , $header_cell_style_price, $align_center_price);
		$price_list_table->addRow ();
		$cell1 = $price_list_table->addCell ( 2750, array('size' => 9) )->addText ( $this->toUft8 ( $suit['adultprice'].'元' ) );
		$cell1 = $price_list_table->addCell ( 3250, array('size' => 9) )->addText ( $this->toUft8 ( $suit['oldprice'].'元' ) );
		$cell1 = $price_list_table->addCell ( 2750, array('size' => 9) )->addText ( $this->toUft8 ( $suit['childprice'].'元' ) );
		$cell1 = $price_list_table->addCell ( 2750, array('size' => 9) )->addText ( $this->toUft8 ( $suit['childnobedprice'].'元' ) );
		/* if(!empty($line['old_description'])||!empty($line['child_nobed_description'])||!empty($line['child_description']))
		{ */
		$price_list_table->addRow ();
		$cell1 = $price_list_table->addCell ( 2750, array('size' => 9) )->addText ( $this->toUft8 ( '' ) );
		$cell1 = $price_list_table->addCell ( 3250, array('size' => 9) )->addText ( $this->toUft8 ( '单独一人一间房，需要补足的费用' ) );
		$cell1 = $price_list_table->addCell ( 2750, array('size' => 9) )->addText ( $this->toUft8 ( $line['child_description'] ) );
		$cell1 = $price_list_table->addCell ( 2750, array('size' => 9) )->addText ( $this->toUft8 ( $line['child_nobed_description'] ) );
		//}
		$section->addTextBreak ();
		// 行程预览
		$trip_table = $section->addTable ();
		$trip_table->addRow ( 400 );
		$trip_table->addCell ( 5500 )->addText ( $this->toUft8 ( '行程预览' ), array(
				'size' => 11, 
				'bold' => true, 
				'color' => '#093c7c' 
		) );
		$trip_table->addCell ( 5500 )->addText ( $this->toUft8 ( '出团日期：' . $usedate ), array(
				'size' => 11, 
				'bold' => true, 
				'color' => '#093c7c' 
		), array(
				'align' => 'right' 
		) );
		
		$styleTable = array(
				'borderColor' => '#002060', 
				'borderSize' => 6, 
				'marginTop' => 10, 
				'cellMargin' => 50 
		);
		$PHPWord->addTableStyle ( 'trip_list_table', $styleTable );
		$trip_list_table = $section->addTable ( 'trip_list_table' );
		$trip_list_table->addRow ();
		$cellDtyle = array(
				'bgColor' => '#1F497D', 
				'size' => 10.5 
		);
		$header_cell_style = array( 'name'=>'Microsoft YaHei','size' => 10.5,'color' => '#ffffff' );
		$align_center = array( 'align' => 'center' );
		$cell1 = $trip_list_table->addCell ( 1000, $cellDtyle )->addText ( $this->toUft8 ( '天数' ) , $header_cell_style,  $align_center);
		$cell1 = $trip_list_table->addCell ( 4000, $cellDtyle )->addText ( $this->toUft8 ( '行程安排' ) , $header_cell_style, $align_center);
		$cell1 = $trip_list_table->addCell ( 1000, $cellDtyle )->addText ( $this->toUft8 ( '早餐' ) , $header_cell_style, $align_center);
		$cell1 = $trip_list_table->addCell ( 1000, $cellDtyle )->addText ( $this->toUft8 ( '中餐' ) , $header_cell_style, $align_center);
		$cell1 = $trip_list_table->addCell ( 1000, $cellDtyle )->addText ( $this->toUft8 ( '晚餐' ) , $header_cell_style, $align_center);
		$cell1 = $trip_list_table->addCell ( 3500, $cellDtyle )->addText ( $this->toUft8 ( '住宿酒店' ) , $header_cell_style, $align_center);
		if (! empty ( $trip )) {
			foreach ( $trip as $tr => $tr_value ) {
				$trip_list_table->addRow ();
				$cell1 = $trip_list_table->addCell ( 1000, array(
						'size' => 9 
				) )->addText ( $this->toUft8 ( '第' . $tr_value['day'] . '天' ) );
				
				$trip_title = preg_replace ( "/<(.*?)>/", ' ~ ', $tr_value['title'] );
				$trip_title = str_replace("undefined"," ", $trip_title);
				
				$cell1 = $trip_list_table->addCell ( 3000, array(
						'size' => 9 
				) )->addText ( $this->toUft8 ( $trip_title ) );
				$break = $tr_value['breakfirsthas'] == "1" ? $tr_value['breakfirst'] : "--";
				$cell1 = $trip_list_table->addCell ( 1500, array(
						'size' => 9 
				) )->addText ( $this->toUft8 ( $break ),array(),array('align'=>'center') );
				$lunch = $tr_value['lunchhas'] == "1" ? $tr_value['lunch'] : "--";
				$cell1 = $trip_list_table->addCell ( 1500, array(
						'size' => 9 
				) )->addText ( $this->toUft8 ( $lunch ),array(),array('align'=>'center') );
				$supper = $tr_value['supperhas'] == "1" ? $tr_value['supper'] : "--";
				$cell1 = $trip_list_table->addCell ( 1500, array(
						'size' => 9 
				) )->addText ( $this->toUft8 ( $supper ) ,array(),array('align'=>'center'));
				$cell1 = $trip_list_table->addCell ( 3000, array(
						'size' => 9 
				) )->addText ( $this->toUft8 ( $tr_value['hotel'] ) );
			}
		}
		
		// 详细行程
		$section->addTextBreak ();
		$section->addText ( $this->toUft8 ( '【行程介绍】' ), array(
				'size' => 11, 
				'bold' => 'true', 
				'color' => '#093c7c' 
		), array(
				'align' => 'left' 
		) );
		if (! empty ( $trip )) {
			foreach ( $trip as $tr2 => $tr_value2 ) {
				
			   $style_p_table = array(
						'borderBottomColor' => '#002460',
						'borderBottomSize' => 16,
						'marginTop' => 10,
						'cellMargin' => 30
				);
				$PHPWord->addTableStyle ( 'p_table', $style_p_table );
				$p_table = $section->addTable ( 'p_table' );
				$p_table->addRow ();
				
				$jieshao_title = preg_replace ( "/<(.*?)>/", ' ~ ', $tr_value2['title'] );
				$jieshao_title = str_replace("undefined"," ",$jieshao_title);
				
				$p_table->addCell(14000)->addText($this->toUft8( '第' . $tr_value2['day'] . '天：' . $jieshao_title),array(
						'size' => 10.5,
						'bold' => 'true',
						'color' => '#014289'
				)); 
				//行程内容
				$section->addText ( $this->toUft8 ( $tr_value2['jieshao'] ), array(
						'size' => 10.5, 
						'color' => '#000' 
				), array(
						'align' => 'left', 
						'indent' => 2000 
				) ); 
				
				// 图片
				$pic_arr = array();
				if (! empty ( $tr_value2['pic'] )) $pic_arr = explode ( ";", $tr_value2['pic'] );
				if (! empty ( $pic_arr )) {
					if (count ( $pic_arr ) > 1) array_pop ( $pic_arr );
					$img_table = $section->addTable ();
					$img_table->addRow (); // 第一行3个
					
					foreach ( $pic_arr as $pic => $pic_value ) {
						if ($pic < 3) {
							$pic_path = '.' . $pic_value;
							
							if (! file_exists ( $pic_path )) $pic_path = "./file/t33/init_word" . $pic . ".png"; // 默认图片
							                                              // $section->addImage($lunbo_path,array('width'=>'286px','height'=>'184px','align'=>'left'));
							$img_table->addCell ( 4500 )->addImage ( $pic_path, array(
									'width' => '246px', 
									'height' => '184px', 
									'align' => 'left' 
							) );
						}
					}
					if (count ( $pic ) > 3) 					// 如果有第二行
					{
						$img_table->addRow ();
						foreach ( $pic_arr as $pic => $pic_value ) {
							if ($pic >= 3) {
								$pic_path = '.' . $pic_value;
								if (! file_exists ( $pic_path )) $pic_path = "./file/t33/init_word" . $pic . ".png"; // 默认图片
								$img_table->addCell ( 4500 )->addImage ( $pic_path, array(
										'width' => '246px', 
										'height' => '184px', 
										'align' => 'left' 
								) );
							}
						}
					}
				}
				$section->addTextBreak ();
			}
		}
		
		// 接待标准
		$section->addTextBreak ();
		$section->addText ( $this->toUft8 ( '接待标准' ), array(
				'size' => 11, 
				'bold' => 'true', 
				'color' => '#093c7c' 
		), array(
				'align' => 'left' 
		) );
		if (! empty ( $line['feeinclude'] )) {
			$section->addText ( $this->toUft8 ( '【费用包含】' ), array(
					'size' => 11, 
					'bold' => 'true', 
					'color' => '#da0000' 
			), array(
					'align' => 'left', 
					'marginTop' => '25' 
			) );
			$section->addText ( $this->toUft8 ( $line['feeinclude'] ), array(
					'size' => 10.5, 
					'color' => '#000' 
			), array(
					'align' => 'left', 
					'marginTop' => '25' 
			) );
		}
		if (! empty ( $line['feenotinclude'] )) {
			$section->addText ( $this->toUft8 ( '【费用不包】' ), array(
					'size' => 11, 
					'bold' => 'true', 
					'color' => '#da0000' 
			), array(
					'align' => 'left', 
					'marginTop' => '25' 
			) );
			$section->addText ( $this->toUft8 ( $line['feenotinclude'] ), array(
					'size' => 10.5, 
					'color' => '#000' 
			), array(
					'align' => 'left', 
					'marginTop' => '25' 
			) );
		}
		
		$section->addTextBreak ();
		if (! empty ( $line['visa_content'] )) {
			$section->addText ( $this->toUft8 ( '签证说明' ), array(
					'size' => 11, 
					'bold' => 'true', 
					'color' => '#093c7c' 
			), array(
					'align' => 'left' 
			) );
			$section->addText ( $this->toUft8 ( $line['visa_content'] ), array(
					'size' => 10.5, 
					'color' => '#000' 
			), array(
					'align' => 'left', 
					'marginTop' => '25' 
			) );
			$section->addTextBreak ();
		}
		if (! empty ( $line['insurance'] )) {
			$section->addText ( $this->toUft8 ( '保险说明' ), array(
					'size' => 11, 
					'bold' => 'true', 
					'color' => '#093c7c' 
			), array(
					'align' => 'left' 
			) );
			$section->addText ( $this->toUft8 ( $line['insurance'] ), array(
					'size' => 10.5, 
					'color' => '#000' 
			), array(
					'align' => 'left', 
					'marginTop' => '25' 
			) );
			$section->addTextBreak ();
		}
		if (! empty ( $line['other_project'] )) {
			$section->addText ( $this->toUft8 ( '购物自费' ), array(
					'size' => 11, 
					'bold' => 'true', 
					'color' => '#093c7c' 
			), array(
					'align' => 'left' 
			) );
			$section->addText ( $this->toUft8 ( $line['other_project'] ), array(
					'size' => 10.5, 
					'color' => '#000' 
			), array(
					'align' => 'left', 
					'marginTop' => '25' 
			) );
			$section->addTextBreak ();
		}
		if (! empty ( $line['beizu'] )) {
			$section->addText ( $this->toUft8 ( '温馨提示' ), array(
					'size' => 11, 
					'bold' => 'true', 
					'color' => '#093c7c' 
			), array(
					'align' => 'left' 
			) );
			$section->addText ( $this->toUft8 ( $line['beizu'] ), array(
					'size' => 10.5, 
					'color' => '#000' 
			), array(
					'align' => 'left', 
					'marginTop' => '25' 
			) );
			$section->addTextBreak ();
		}
		if (! empty ( $line['safe_alert'] )) {
			$section->addText ( $this->toUft8 ( '安全提示' ), array(
					'size' => 11, 
					'bold' => 'true', 
					'color' => '#093c7c' 
			), array(
					'align' => 'left' 
			) );
			$section->addText ( $this->toUft8 ( $line['safe_alert'] ), array(
					'size' => 10.5, 
					'color' => '#000' 
			), array(
					'align' => 'left', 
					'marginTop' => '25' 
			) );
		}
		
		// 页脚
		$footer = $section->createFooter ();
		if (! empty ( $expert )) 		// 管家信息
		{
			$foot_table = $footer->addTable ();
			$foot_table->addRow ();
			$foot_table->addCell ( 4500 )->addText ( $this->toUft8 ( '联系人：' . $expert['realname'] ), array(
					'size' => '10', 
					'color' => '#000', 
					'bold' => true 
			) );
			$foot_table->addCell ( 4500 )->addText ( $this->toUft8 ( '手机：' . $expert['mobile'] ), array(
					'size' => '10', 
					'color' => '#000', 
					'bold' => true 
			) );
			// $foot_table->addCell(4500)->addText($this->toUft8('电话：0755-25132531'),array('size'=>'10','color'=>'#000','bold'=>true));
			$foot_table->addCell ( 4500 )->addText ( $this->toUft8 ( '邮箱：' . $expert['email'] ), array(
					'size' => '10', 
					'color' => '#000', 
					'bold' => true 
			) );
			$foot_table->addCell ( 4500 )->addText ( $this->toUft8 ( '营业部：' . $expert['depart_name'] ), array(
					'size' => '10', 
					'color' => '#000', 
					'bold' => true 
			) );
			
			$foot_table->addRow ();
			$foot_table->addCell ( 4500 )->addText ( '', array(
					'size' => '10', 
					'color' => '#000', 
					'bold' => true 
			) );
			$foot_table->addCell ( 4500 )->addText ( '', array(
					'size' => '10', 
					'color' => '#000', 
					'bold' => true 
			) );
			$foot_table->addCell ( 4500 )->addText ( '', array(
					'size' => '10', 
					'color' => '#000', 
					'bold' => true 
			) );
			$foot_table->addCell ( 4500 )->addText ( '', array(
					'size' => '10', 
					'color' => '#000', 
					'bold' => true 
			) );
		}
		$section->addTextBreak ();
		// $foot_table->addCell(4500)->addPreserveText($this->toUft8('第 {PAGE}页 共 {NUMPAGES}页.'), array('align'=>'center'));
		$footer->addPreserveText ( $this->toUft8 ( '第 {PAGE}页   共 {NUMPAGES}页.' ), array(), array(
				'align' => 'center', 
				'marginTop' => '10' 
		) );
		// Save File
		$objWriter = PHPWord_IOFactory::createWriter ( $PHPWord, 'Word2007' );
		//$objWriter->save('Watermark.docx');
		
		// download
		
		header ( "Content-Type:   application/msword" );
		header ( "Content-Disposition:   attachment;   filename=" . $this->toUft8($line_name) . ".doc" ); // 指定文件名称
		header ( "Pragma:   no-cache" );
		header ( "Expires:   0" );
		
		$objWriter->save ( 'php://output' ); 
	}
	/**
	 * phpword官方版
	 * 生成word:模板
	 */
	public function createword_tpl() {
		/*
		 * $line_id=$this->input->get("id",true); $this->load->model('admin/t33/u_line_model','u_line_model'); $return = $this ->u_line_model ->line_trip($line_id); $union_id=$this->get_union(); $this->load->model('admin/t33/sys/b_union_log_model','b_union_log_model'); $trip= $return['result']; $logo=$this->b_union_log_model->row(array('union_id'=>$union_id)); $line=$this->F_line_detail_more($line_id);
		 */
		$this->load->library ( 'PHPWord' );
		// 实例化
		$PHPWord = new PHPWord ();
		
		// $templateProcessor = new PhpOffice\PhpWord\TemplateProcessor('D:/xampp_junhey/htdocs/bangu/Sample_07_TemplateCloneRow.docx');
		
		$document = $PHPWord->loadTemplate ( 'Template.docx' );
		
		$document->setValue ( 'myReplacedValue', $this->toUft8 ( '一航' ) );
		$document->cloneRow ( 'myReplacedValue', 10 );
		
		$document->setValue ( 'Value1', 'Sun' );
		$document->setValue ( 'Value2', 'Mercury' );
		$document->setValue ( 'Value3', 'Venus' );
		$document->setValue ( 'Value4', 'Earth' );
		$document->setValue ( 'Value5', 'Mars' );
		$document->setValue ( 'Value6', 'Jupiter' );
		$document->setValue ( 'Value7', 'Saturn' );
		$document->setValue ( 'Value8', 'Uranus' );
		$document->setValue ( 'Value9', 'Neptun' );
		$document->setValue ( 'Value10', 'Pluto' );
		
		$document->setValue ( 'weekday', date ( 'l' ) );
		$document->setValue ( 'time', date ( 'H:i' ) );
		
		$document->save ( 'Solarsystem.docx' );
	}
	/*
	 * phpword： 社区版
	 * */
	public function word_tpl() {
		$this->load->library ( 'Word' );
		$templateProcessor = new PhpOffice\PhpWord\TemplateProcessor ( 'Temp.docx' );
		
		$templateProcessor->setValue ( 'yemei', '海外国际' );
		$templateProcessor->setValue ( 'linename', '深圳两日游' );
		$templateProcessor->setValue ( 'mainpic', "http://192.168.10.202/file/upload/20161025/147736547218996.jpg />" );
		$templateProcessor->setValue ( 'myReplacedValue', '段落' );
		$templateProcessor->cloneRow ( 'Value1', 3 );
		/*
		 * $templateProcessor->setValue('Value1', 'Sun'); $templateProcessor->setValue('Value2', 'Mercury'); $templateProcessor->setValue('Value3', 'Venus'); $templateProcessor->setValue('Value4', 'Earth'); $templateProcessor->setValue('Value5', 'Mars'); $templateProcessor->setValue('Value6', 'Jupiter'); $templateProcessor->setValue('Value7', 'Saturn'); $templateProcessor->setValue('Value8', 'Uranus'); $templateProcessor->setValue('Value9', 'Neptun'); $templateProcessor->setValue('Value10', 'Pluto'); $document->setValue('weekday', date('l')); $document->setValue('time', date('H:i'));
		 */
		
		// echo date('H:i:s'), ' Saving the result document...', EOL;
		$templateProcessor->saveAs ( 'tt.docx' );
		
		// echo getEndingNotes(array('Word2007' => 'docx'));
		/*
		 * if (!CLI) { include_once 'Sample_Footer.php'; }
		 */
	}
	/*
	 * 导出word: 将html导出成word
	 */
	public function create_word() {
		$line_id = $this->input->get ( "id", true );
		
		// $html=file_get_contents('http://www.1b1u.com/admin/t33/login/trip?id='.$line_id);
		$html = file_get_contents ( base_url ( 'admin/t33/login/trip?id=' ) . $line_id, 'rb' );
		
		$fileContent = $this->getWordDocument ( $html, "http://www.1b1u.com" );
		// 1、直接保存
		ob_end_clean (); // 关键
		header ( "Content-Type:   application/msword" );
		header ( "Content-Disposition:   attachment;   filename=L" . $line_id . ".doc" ); // 指定文件名称
		header ( "Pragma:   no-cache" );
		header ( "Expires:   0" );
		echo $fileContent;
		
		/*
		 * $time = date('Ymd',time()); $path ="./file/t33/word/".$time."/"; //上传路径 $return="/file/t33/word/".$time."/"; //返回的路径 if (!file_exists($path)) { $status = mkdir($path ,0777 ,true); if ($status == false) $this->__errormsg('生成失败'); } $filename=$path.'L'.$line_id.'.doc'; $return_filename=$return.'L'.$line_id.'.doc'; $fp = fopen($filename, 'w'); fwrite($fp, $fileContent); fclose($fp); $this->__data(BANGU_URL.$return_filename);
		 */
		
		// 1、直接保存
		/*
		 * $fp = fopen("test.doc", 'w'); fwrite($fp, $fileContent); fclose($fp);
		 */
		// 2、下载
		/*
		 * header("Content-Type: application/msword"); header("Content-Disposition: attachment; filename=doc.doc"); //指定文件名称 header("Pragma: no-cache"); header("Expires: 0"); echo $fileContent;
		 */
	}
	/**
	 * 线路行程
	 */
	public function trip() {
		$line_id = $this->input->get ( "id", true );
		$this->load->model ( 'admin/t33/u_line_model', 'u_line_model' );
		$return = $this->u_line_model->line_trip ( $line_id );
		
		$data['list'] = $return['result'];
		$union_id = "1";
		$this->load->model ( 'admin/t33/sys/b_union_log_model', 'b_union_log_model' );
		$data['logo'] = $this->b_union_log_model->row ( array(
				'union_id' => $union_id 
		) );
		$data['line'] = $this->F_line_detail_more ( $line_id );
		// var_dump($data);
		$this->load->view ( "admin/t33/line/trip", $data );
	}
	/*
	 * 付款审批：导出excel=>按payable_id导
	 * */
	function drive_excel_data()
	{
		$payable_id=$this->input->post('payable_id',true);
		$ordersn=$this->input->post('ordersn',true);
		$u_starttime=$this->input->post('u_starttime',true);
		$u_endtime=$this->input->post('u_endtime',true);
		$price_start=$this->input->post('price_start',true);//金额起始
		$price_end=$this->input->post('price_end',true); //金额结束
		$team_code=$this->input->post('team_code',true); //团号
		$productname=$this->input->post('productname',true); //产品名称
		$commit_name=$this->input->post('commit_name',true); //申请人
		
		$where['id']=$payable_id;
		if(!empty($ordersn)){$where['ordersn']=$ordersn;}  //供应商搜索订单编号
		if(!empty($u_starttime)){$where['u_starttime']=$u_starttime;}
		if(!empty($u_endtime)){$where['u_endtime']=$u_endtime;}
		
		if(!empty($price_start)){$where['price_start']=$price_start;}
		if(!empty($price_end)){$where['price_end']=$price_end;}
		if(!empty($team_code)){$where['team_code']=$team_code;}
		if(!empty($productname)){$where['productname']=$productname;}
		if(!empty($commit_name)){$where['commit_name']=$commit_name;}
		$this->load->model('admin/t33/approve/u_payable_apply_model','u_payable_apply_model'); //付款申请表
		$return=$this->u_payable_apply_model->pay_order($where,'0',20);
		
		$supplier=$this->supplier_bank($payable_id);

		$this->pay_excel($return['result'],$supplier);
	}
	/*
	 * 付款审批：导出excel=>按payable_id导
	* */
	function t33_drive_excel()
	{
		$list=$this->input->post('list',true);
		if(empty($list))  $this->__errormsg('请选择要导出的订单');
		
		$list_in=implode(",", $list);
		$list_in="(".$list_in.")";
		$where=array('list'=>$list_in);
		$this->load->model('admin/t33/approve/u_payable_apply_model','u_payable_apply_model'); //付款申请表
		$return=$this->u_payable_apply_model->payable_list_excel($where);
	
		$supplier=$this->supplier_bank($return['result'][0]['payable_id']);
	
		$this->pay_excel($return['result'],$supplier);
	}
	/*
	 * 付款查询：导出excel
	* */
	function btn_pay_list()
	{
	    $type=trim($this->input->post("type",true)); //类型 -1全部，1未提交，2已通过（代付款），3、5已退回，4已付款
		
		$supplier_id=trim($this->input->post("supplier_id",true)); //供应商id
		$item_company=trim($this->input->post("item_company",true));//收款单位
		$starttime=trim($this->input->post("starttime",true));
		$endtime=trim($this->input->post("endtime",true));
		$ordersn=trim($this->input->post("ordersn",true));
		$team_code=trim($this->input->post("team_code",true));
		$productname=trim($this->input->post("productname",true));
		$expert_name=trim($this->input->post("expert_name",true));
	
		$price_start=trim($this->input->post("price_start",true));
		$price_end=trim($this->input->post("price_end",true));
	
		//分页
		$page = $this->input->post ( 'page', true );
		$page_size = sys_constant::B_PAGE_SIZE;
		//$page_size="1";
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;

		//条件筛选
		$union_id=$this->get_union();
		$where=array('union_id'=>$union_id);

		
		if(!empty($supplier_id))
			$where['supplier_id']=$supplier_id;
		if(!empty($item_company))
			$where['item_company']=$item_company;
		if(!empty($starttime))
			$where['starttime']=$starttime;
		if(!empty($endtime))
			$where['endtime']=$endtime;
		if(!empty($price_start))
			$where['price_start']=$price_start;
		if(!empty($price_end))
			$where['price_end']=$price_end;
		if(!empty($ordersn))
			$where['ordersn']=$ordersn;
		if(!empty($team_code))
			$where['team_code']=$team_code;
		if(!empty($productname))
			$where['productname']=$productname;
		if(!empty($expert_name))
			$where['expert_name']=$expert_name;
		if($type!="-1")
			$where['status']=$type; //默认-1
		
		$this->load->model('admin/t33/approve/u_payable_apply_model','u_payable_apply_model'); //付款申请表
		
		$return=$this->u_payable_apply_model->payable_list_excel($where);
	
		$return['account']['sum_to_pay_money']=0;
		if(!empty($return['result']))
		{
			foreach ($return['result'] as $k=>$v)
			{
				$temp=empty($v['to_pay_money'])==true?0:$v['to_pay_money'];
				$return['account']['sum_to_pay_money']+=$temp;
			}
		}
		
		//供应商信息
		/* $supplier=array();
		if(!empty($return['result']))
		{
		$row=$this->u_payable_apply_model->row(array('id'=>$return['result'][0]['payable_id']));
		$this->load->model('admin/t33/u_supplier_model','u_supplier_model'); 
		$supplier=$this->u_supplier_model->row(array('id'=>$supplier_id));
		$supplier['bankname']=$row['bankname'];
		$supplier['bankcompany']=$row['bankcompany'];
		$supplier['bankcard']=$row['bankcard'];
		} */
		$supplier=$this->supplier_info($supplier_id);
		
		$this->pay_excel_order($return['result'],$supplier,$return['account']);
		
	}
	/*
	 * 供应商信息：付款申请时填写的供应商（多个）
	 * */
	protected function supplier_bank($payable_id)
	{
		$row=$this->u_payable_apply_model->row(array('id'=>$payable_id));
		$this->load->model('admin/t33/u_supplier_model','u_supplier_model'); //
		$supplier=$this->u_supplier_model->row(array('id'=>$row['supplier_id']));
		$supplier['bankname']=$row['bankname'];
		$supplier['bankcompany']=$row['bankcompany'];
		$supplier['bankcard']=$row['bankcard'];
		return $supplier;
	}	
	/*
	 * 供应商信息：设置的供应商账号（一个）
	* */
	protected function supplier_info($supplier_id)
	{
		$this->load->model('admin/t33/u_supplier_bank_model','u_supplier_bank_model');
		$supplier=$this->u_supplier_bank_model->supplier_info($supplier_id);
		if(empty($supplier))
		$supplier=array('bankname'=>'','openman'=>'','bank'=>'','brand'=>'','company_name'=>'','supplier_brand'=>'');
		return $supplier;
	}
	/*
	*  导出excel表,按订单id排序,按合并单元格
	*  $list:付款申请列表
	*  $supplier: 供应商信息
	*/
	protected function pay_excel($list,$supplier=array(),$account=array()){

		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
			
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
		$objPHPExcel->setActiveSheetIndex(0);
	
		$objActSheet = $objPHPExcel->getActiveSheet ();
		$objActSheet->setTitle('供应商月结'); //表名
		
		$objActSheet->mergeCells('A1:K1');  //第一行空格
		$objActSheet->setCellValue('A1', '');
		//1、表结构1（供应商品牌名）
		$start=2;
		if(!empty($supplier))
		{
			$objActSheet->mergeCells('A'.$start.':K'.$start);
			$objActSheet->setCellValue('A'.$start, $supplier['company_name']."·".$supplier['brand']);
			$objActSheet->getStyle('A'.$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objActSheet->getStyle('A'.$start)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
			$start=3;
		}
		//2、表结构2（订单列表）
		$munu=array(
				'0'=>'订单号',
				'1'=>'本次结算金额',
				'2'=>'状态',
				'3'=>'产品名称',
				'4'=>'出团日期',
				'5'=>'结算价',
				'6'=>'已结算',
				'7'=>'操作费',
				'8'=>'未结算',
				'9'=>'待付款',
				'10'=>'团号',
				'11'=>'营业部'
		);
		//第二场景
		if(empty($supplier))
		{
			$munu['12']="供应商名称";
			$munu['13']="户名";
			$munu['14']="银行账户";
			$munu['15']="银行名称";
		}
	
		$i = 'A';
		
		foreach ($munu as $key=>$val) {
			$col_title = $i . $start; //每次给这个值进行更改 即 第一次A1，第二次B1，第三次C1
	
			$objActSheet->getColumnDimension($i)->setWidth(16);
			$objActSheet->setCellValue($col_title,$munu[$key]);
			$objActSheet->getStyle($col_title)->applyFromArray(array( 'font' => array( ),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ) ) );
			//执行相应操作
			$i++;
		}
		$start=$start+1;
		if(!empty($list)){
			foreach ($list as $key => $value) {
				 
				$objActSheet->setCellValueExplicit('A'.($i+$start+$key),$value['ordersn'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('A'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
				$objActSheet->setCellValueExplicit('B'.($i+$start+$key),round($value['amount_apply'],2),PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('B'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
				$status_str="";if($value['status']=="1") $status_str="申请中";else if($value['status']=="2") $status_str="已审待付";else if($value['status']=="4") $status_str="已付款";else $status_str="已拒绝";
				$objActSheet->setCellValueExplicit('C'.($i+$start+$key), $status_str,PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('C'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
				$objActSheet->getColumnDimension('D')->setWidth(30);
				$objActSheet->setCellValueExplicit('D'.($i+$start+$key), $value['productname'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('D'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
	
				$objActSheet->setCellValueExplicit('E'.($i+$start+$key), $value['usedate'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('E'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
				$objActSheet->setCellValueExplicit('F'.($i+$start+$key), round($value['supplier_cost'],2),PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('F'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
				$objActSheet->setCellValueExplicit('G'.($i+$start+$key), round($value['balance_money'],2),PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('G'.($i+$start+$key))->applyFromArray(array(
	
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				$objActSheet->setCellValueExplicit('H'.($i+$start+$key),round( $value['all_platform_fee'],2),PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('H'.($i+$start+$key))->applyFromArray(array(
	
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				$total_apply=empty($value['total_apply'])==true?0:$value['total_apply'];  //未结算=nopay_money-申请结算中的金额
				$objActSheet->setCellValueExplicit('I'.($i+$start+$key), round(($value['nopay_money']-$total_apply),2),PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('I'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		
				$objActSheet->setCellValueExplicit('J'.($i+$start+$key), empty($value['to_pay_money'])==true?0:round($value['to_pay_money'],2),PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('J'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
				$objActSheet->getColumnDimension('K')->setWidth(18);
				$objActSheet->setCellValueExplicit('K'.($i+$start+$key),$value['item_code'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('K'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
				$objActSheet->getColumnDimension('L')->setWidth(18);
				$objActSheet->setCellValueExplicit('L'.($i+$start+$key),$value['depart_name'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('L'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
				//第二场景
			if(empty($supplier))
				{
					$objActSheet->setCellValueExplicit('M'.($i+$start+$key),$value['brand'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('M'.($i+$start+$key))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
					$objActSheet->setCellValueExplicit('N'.($i+$start+$key),$value['bankcompany'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('N'.($i+$start+$key))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
					$objActSheet->setCellValueExplicit('O'.($i+$start+$key),$value['bankcard'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('O'.($i+$start+$key))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
					$objActSheet->setCellValueExplicit('P'.($i+$start+$key),$value['bankname'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('P'.($i+$start+$key))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
				}
	
			}
			//总计
			if(!empty($account))
			{
				$last=$i+$start+count($list);
				$objActSheet->setCellValue('A'.$last, '总计');
				$objActSheet->setCellValue('B'.$last, $account['sum_amount_apply']);
				
				$objActSheet->mergeCells('C'.$last.':D'.$last);
				$objActSheet->setCellValue('C'.$last, '');
				$objActSheet->setCellValue('E'.$last, $account['sum_jiesuan_price']);
				$objActSheet->setCellValue('F'.$last, $account['sum_balance_money']);
				$objActSheet->setCellValue('G'.$last, $account['sum_platform_fee']);
				$objActSheet->setCellValue('H'.$last, $account['sum_nopay_money']);
				$objActSheet->setCellValue('I'.$last, $account['sum_to_pay_money']);
				$objActSheet->mergeCells('J'.$last.':L'.$last);
				$objActSheet->setCellValue('J'.$last, '');
				$objActSheet->getStyle('A'.$last.':L'.$last)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else 
				$last=$i+$start+count($list)-1;
			//供应商 银行账号
			$three_start=$last+2;
			
			$objActSheet->mergeCells('A'.$three_start.':B'.$three_start);
			$objActSheet->setCellValue('A'.$three_start, '户名：');
			$objActSheet->getStyle('A'.$three_start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objActSheet->mergeCells('C'.$three_start.':L'.$three_start);
			$objActSheet->setCellValue('C'.$three_start, $supplier['bankcompany']);
			
			$three_start+=1;
			$objActSheet->mergeCells('A'.$three_start.':B'.$three_start);
			$objActSheet->setCellValue('A'.$three_start, '银行账号：');
			$objActSheet->getStyle('A'.$three_start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
			$objActSheet->mergeCells('C'.$three_start.':L'.$three_start);
			$objActSheet->setCellValue('C'.$three_start, ' '.$supplier['bankcard']); //“长数字显示为科学计数”解决方案：加个空格使之为字符串
			$objActSheet->getStyle('C'.$three_start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objActSheet->getStyle('C'.$three_start)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			
			$three_start+=1;
			$objActSheet->mergeCells('A'.$three_start.':B'.$three_start);
			$objActSheet->setCellValue('A'.$three_start, '银行名称-支行：');
			$objActSheet->getStyle('A'.$three_start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objActSheet->mergeCells('C'.$three_start.':L'.$three_start);
			$objActSheet->setCellValue('C'.$three_start, $supplier['bankname']);
			
			//设置边框
			$styleArray = array(
					'borders' => array(
							'allborders' => array(
									//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
									'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
									//'color' => array('argb' => 'FFFF0000'),
							),
					),
			);
			$objActSheet->getStyle('A1:L'.$three_start)->applyFromArray($styleArray);
		}
		//exit();
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		list($ms, $s) = explode(' ',microtime());
		$ms = sprintf("%03d",$ms*1000);
		$g_session = date('YmdHis')."_".$ms."_".rand(1000, 9999);
		$file='file/b1/uploads/payable'.$g_session.".xlsx";
		//$file="file/b1/uploads/payable".$g_session.".xlsx";
		$objWriter->save($file);
		echo json_encode(array('status'=>1,'file'=>$file));
	}
	/*
	 *  导出excel表,按订单id排序,按合并单元格
	*  $list:付款申请列表
	*  $supplier: 供应商信息
	*/
	protected function pay_excel_order($list,$supplier=array(),$account=array()){
	
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
			
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
		$objPHPExcel->setActiveSheetIndex(0);
	
		$objActSheet = $objPHPExcel->getActiveSheet ();
		$objActSheet->setTitle('供应商月结'); //表名
	
		$objActSheet->mergeCells('A1:K1');  //第一行空格
		$objActSheet->setCellValue('A1', '');
		//1、表结构1（供应商品牌名）
		$start=2;
		if(!empty($supplier))
		{
			$objActSheet->mergeCells('A'.$start.':K'.$start);
			$objActSheet->setCellValue('A'.$start, $supplier['company_name']."·".$supplier['supplier_brand']);
			$objActSheet->getStyle('A'.$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objActSheet->getStyle('A'.$start)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
			$start=3;
		}
		//2、表结构2（订单列表）
		$munu=array(
				'0'=>'订单号',
				'1'=>'本次结算金额',
				'2'=>'状态',
				'3'=>'产品名称',
				'4'=>'出团日期',
				'5'=>'结算价',
				'6'=>'已结算',
				'7'=>'操作费',
				'8'=>'未结算',
				'9'=>'待付款',
				'10'=>'团号',
				'11'=>'营业部'
		);
		//第二场景
		if(empty($supplier))
		{
			$munu['12']="供应商名称";
			$munu['13']="户名";
			$munu['14']="银行账户";
			$munu['15']="银行名称";
		}
	
		$i = 'A';
	
		foreach ($munu as $key=>$val) {
			$col_title = $i . $start; //每次给这个值进行更改 即 第一次A1，第二次B1，第三次C1
	
			$objActSheet->getColumnDimension($i)->setWidth(16);
			$objActSheet->setCellValue($col_title,$munu[$key]);
			$objActSheet->getStyle($col_title)->applyFromArray(array( 'font' => array( ),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ) ) );
			//执行相应操作
			$i++;
		}
		$start=$start+1;
	
		if(!empty($list)){
			foreach ($list as $key => $value) {
				
				//@xml
				$value['amount_apply']=sprintf("%.2f",$value['amount_apply']);
				$value['to_pay_money']=sprintf("%.2f",$value['to_pay_money']);
				
				$objActSheet->setCellValueExplicit('A'.($i+$start+$key),$value['ordersn'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('A'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
				$objActSheet->setCellValueExplicit('B'.($i+$start+$key),$value['amount_apply'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('B'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
				$status_str="";if($value['status']=="1") $status_str="申请中";else if($value['status']=="2") $status_str="已审待付";else if($value['status']=="4") $status_str="已付款";else $status_str="已拒绝";
				$objActSheet->setCellValueExplicit('C'.($i+$start+$key), $status_str,PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('C'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
				$objActSheet->getColumnDimension('D')->setWidth(30);
				$objActSheet->setCellValueExplicit('D'.($i+$start+$key), $value['productname'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('D'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
	
				$objActSheet->setCellValueExplicit('E'.($i+$start+$key), $value['usedate'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('E'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
				$objActSheet->setCellValueExplicit('F'.($i+$start+$key), sprintf("%.2f",$value['supplier_cost']),PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('F'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
				$objActSheet->setCellValueExplicit('G'.($i+$start+$key), sprintf("%.2f",$value['balance_money']),PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('G'.($i+$start+$key))->applyFromArray(array(
	
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				$objActSheet->setCellValueExplicit('H'.($i+$start+$key),sprintf("%.2f",$value['all_platform_fee']),PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('H'.($i+$start+$key))->applyFromArray(array(
	
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				$total_apply=empty($value['total_apply'])==true?0:$value['total_apply'];  //未结算=nopay_money-申请结算中的金额
				$objActSheet->setCellValueExplicit('I'.($i+$start+$key),sprintf("%.2f",($value['nopay_money']-$total_apply)),PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('I'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		
				$objActSheet->setCellValueExplicit('J'.($i+$start+$key), empty($value['to_pay_money'])==true?0:$value['to_pay_money'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('J'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
				$objActSheet->getColumnDimension('K')->setWidth(18);
				$objActSheet->setCellValueExplicit('K'.($i+$start+$key),$value['item_code'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('K'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
				$objActSheet->getColumnDimension('L')->setWidth(18);
				$objActSheet->setCellValueExplicit('L'.($i+$start+$key),$value['depart_name'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('L'.($i+$start+$key))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
				/*
				 * 合并单元格
				 * $group=array('id'=>,'ordersn'=>'','num'=>'');
				 * 
				 */
				
				$id_in=array();
				$a=array(); // 关联数组：每个id对应的num
				if(!empty($account))
				{
					foreach ($account as $k=>$v)
					{
						array_push($id_in,$v['id']);
						$a[$v['id']]=$v['num'];
					}
				}
				//var_dump($id_in);var_dump($a);exit();
				if(in_array( $value['id'],$id_in)&&$a[$value['id']]>1)
				{
					//var_dump($key);var_dump($value['id']);var_dump($i+$start+$key);
					
					$objActSheet->mergeCells('A'.($i+$start+$key).':A'.($i+$start+$key+$a[$value['id']]-1));
					//$objActSheet->mergeCells('C'.($i+$start+$key).':C'.($i+$start+$key+$a[$value['id']]-1));
					$objActSheet->mergeCells('D'.($i+$start+$key).':D'.($i+$start+$key+$a[$value['id']]-1));
					$objActSheet->mergeCells('E'.($i+$start+$key).':E'.($i+$start+$key+$a[$value['id']]-1));
					$objActSheet->mergeCells('F'.($i+$start+$key).':F'.($i+$start+$key+$a[$value['id']]-1));
					$objActSheet->mergeCells('G'.($i+$start+$key).':G'.($i+$start+$key+$a[$value['id']]-1));
					$objActSheet->mergeCells('H'.($i+$start+$key).':H'.($i+$start+$key+$a[$value['id']]-1));
					$objActSheet->mergeCells('I'.($i+$start+$key).':I'.($i+$start+$key+$a[$value['id']]-1));
					$objActSheet->mergeCells('J'.($i+$start+$key).':J'.($i+$start+$key+$a[$value['id']]-1));
					$objActSheet->mergeCells('K'.($i+$start+$key).':K'.($i+$start+$key+$a[$value['id']]-1));
					$objActSheet->mergeCells('L'.($i+$start+$key).':L'.($i+$start+$key+$a[$value['id']]-1));
					
					$objActSheet->getStyle('A'.($i+$start+$key).':L'.($i+$start+$key))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				} 

				//第二场景
				if(empty($supplier))
				{
					$objActSheet->setCellValueExplicit('M'.($i+$start+$key),$value['brand'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('M'.($i+$start+$key))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
					$objActSheet->setCellValueExplicit('N'.($i+$start+$key),$value['bankcompany'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('N'.($i+$start+$key))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
					$objActSheet->setCellValueExplicit('O'.($i+$start+$key),$value['bankcard'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('O'.($i+$start+$key))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
					$objActSheet->setCellValueExplicit('P'.($i+$start+$key),$value['bankname'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('P'.($i+$start+$key))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	
				}
	
			}
			//exit();
			//总计
			if(!empty($account))
			{
				$sum_amount_apply=$sum_jiesuan_price=$sum_balance_money=$sum_platform_fee=$sum_nopay_money=$sum_to_pay_money=0;
				foreach ($account as $p=>$q)
				{
					$sum_amount_apply+=$q['amount_apply'];
					$sum_jiesuan_price+=$q['jiesuan_price'];
					$sum_balance_money+=$q['balance_money'];
					$sum_platform_fee+=$q['platform_fee'];
					$sum_nopay_money+=$q['nopay_money'];
					$sum_to_pay_money+=empty($q['to_pay_money'])==true?0:$q['to_pay_money'];
				}
				//@xml
				$sum_amount_apply=sprintf("%.2f",$sum_amount_apply);
				
				$last=$i+$start+count($list);
				$objActSheet->setCellValue('A'.$last, '总计');
				$objActSheet->setCellValue('B'.$last, $sum_amount_apply);
	
				$objActSheet->mergeCells('C'.$last.':E'.$last);
				$objActSheet->setCellValue('C'.$last, '');
				$objActSheet->setCellValue('F'.$last, $sum_jiesuan_price);
				$objActSheet->setCellValue('G'.$last, $sum_balance_money);
				$objActSheet->setCellValue('H'.$last, $sum_platform_fee);
				$objActSheet->setCellValue('I'.$last, $sum_nopay_money);
				$objActSheet->setCellValue('J'.$last, $sum_to_pay_money);
				$objActSheet->mergeCells('K'.$last.':L'.$last);
				$objActSheet->setCellValue('K'.$last, '');
				$objActSheet->getStyle('A'.$last.':L'.$last)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
				$last=$i+$start+count($list)-1;
			//供应商 银行账号
			$three_start=$last+2;
				
			$objActSheet->mergeCells('A'.$three_start.':B'.$three_start);
			$objActSheet->setCellValue('A'.$three_start, '户名：');
			$objActSheet->getStyle('A'.$three_start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objActSheet->mergeCells('C'.$three_start.':L'.$three_start);
			$objActSheet->setCellValue('C'.$three_start, $supplier['openman']);
				
			$three_start+=1;
			$objActSheet->mergeCells('A'.$three_start.':B'.$three_start);
			$objActSheet->setCellValue('A'.$three_start, '银行账号：');
			$objActSheet->getStyle('A'.$three_start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
			$objActSheet->mergeCells('C'.$three_start.':L'.$three_start);
			$objActSheet->setCellValue('C'.$three_start, ' '.$supplier['bank']); //“长数字显示为科学计数”解决方案：加个空格使之为字符串
			$objActSheet->getStyle('C'.$three_start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objActSheet->getStyle('C'.$three_start)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
			$three_start+=1;
			$objActSheet->mergeCells('A'.$three_start.':B'.$three_start);
			$objActSheet->setCellValue('A'.$three_start, '银行名称-支行：');
			$objActSheet->getStyle('A'.$three_start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objActSheet->mergeCells('C'.$three_start.':L'.$three_start);
			$objActSheet->setCellValue('C'.$three_start, $supplier['bankname'].$supplier['brand']);
				
			//设置边框
			$styleArray = array(
					'borders' => array(
							'allborders' => array(
									//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
									'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
									//'color' => array('argb' => 'FFFF0000'),
							),
					),
			);
			$objActSheet->getStyle('A1:L'.$three_start)->applyFromArray($styleArray);
		}

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		list($ms, $s) = explode(' ',microtime());
		$ms = sprintf("%03d",$ms*1000);
		$g_session = date('YmdHis')."_".$ms."_".rand(1000, 9999);
		$file='file/b1/uploads/payable'.$g_session.".xlsx";
		//$file="file/b1/uploads/payable".$g_session.".xlsx";
		$objWriter->save($file);
		echo json_encode(array('status'=>1,'file'=>$file));
	}
	/**
	 * 线路行程
	 */
	protected function getWordDocument($content, $absolutePath = "", $isEraseLink = true) {
		$this->load->library ( 'MhtFileMaker' );
		$mht = new MhtFileMaker ();
		if ($isEraseLink) $content = preg_replace ( '/<a\s*.*?\s*>(\s*.*?\s*)<\/a>/i', '$1', $content ); // 去掉链接
		$images = array();
		$files = array();
		$matches = array();
		// 这个算法要求src后的属性值必须使用引号括起来
		if (preg_match_all ( '/<img[.\n]*?src\s*?=\s*?[\"\'](.*?)[\"\'](.*?)\/>/i', $content, $matches )) {
			$arrPath = $matches[1];
			for($i = 0; $i < count ( $arrPath ); $i ++) {
				$path = $arrPath[$i];
				$imgPath = trim ( $path );
				if ($imgPath != "") {
					$files[] = $imgPath;
					if (substr ( $imgPath, 0, 7 ) == 'http://') {
						// 绝对链接，不加前缀
					} else {
						$imgPath = $absolutePath . $imgPath;
					}
					$images[] = $imgPath;
				}
			}
		}
		$mht->AddContents ( "tmp.html", $mht->GetMimeType ( "tmp.html" ), $content );
		
		for($i = 0; $i < count ( $images ); $i ++) {
			$image = $images[$i];
			if (@fopen ( $image, 'r' )) {
				$imgcontent = @file_get_contents ( $image );
				if ($content) $mht->AddContents ( $files[$i], $mht->GetMimeType ( $image ), $imgcontent );
			} else {
				echo "file:" . $image . " not exist!<br />";
			}
		}
		
		return $mht->GetFile ();
	}
}

/* End of file login.php */
