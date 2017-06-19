<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Insurance_api extends MY_Controller {
	public $insura_api_url;
	public function __construct() {
		parent::__construct ();
		$this->load->database ();
		$this->load->model ( 'admin/a/insure_model', 'insure_model' );
		// $this->insura_api_url="https://61.138.246.87:6002/LifeServiceUat"; //测试保险接口url
		$this->insura_api_url = "https://ptn.cic.cn:8101/LifePartnerService"; // 正式地址
	}
	public function index() {
		
		// 订单保险数据
		// $date='2017-01-28';
		$date = date ( "Y-m-d", strtotime ( "+1 day" ) );
		$suitdata = $this->insure_model->get_insurance_suit ( $date );
		if (! empty ( $suitdata )) {
			
			$text = '没有投保人';
			foreach ( $suitdata as $key => $value ) {
				$insura_where = array (
						'usedate' => $date,
						'suitid' => $value ['suitid'],
						'insurance_id' => $value ['insurance_id'] 
				); // 同一个出团日期 同一个保险方案
				$order_insure = $this->insure_model->get_insurance_people ( $insura_where );
				
				$insuraData ['suitid'] = $value ['suitid']; // 套餐id
				$insuraData ['people'] = $value ['people']; // 这个套餐的人数
				$insuraData ['insurance_price'] = $value ['insurance_price']; // 单个保险的价格
				$insuraData ['settlement_price'] = $value ['settlement_price']; // 套餐保险的总的售卖价格
				$insuraData ['insurance_code'] = $value ['insurance_code']; // 投保人
				if (! empty ( $order_insure )) {
					$text = '投保失败';
					if ($value ['people'] == count ( $order_insure )) {
						$insureDataArr = array ();
						$x = 1;
						$mub = 0;
						while ( $x > 0 ) {
							// 流水账号
							$mub = $x;
							$water_account = 'L' . $value ['line_id'] . 'D' . date ( 'Ymd' ) . 'S' . $value ['suitid'] . 'B' . $value ['insurance_id'] . 'P' . $order_insure [0] ['suit_price_id'] . '_' . $x;
							$waterArr = $this->insure_model->select_rowData ( 'u_order_insurance', array (
									'water_account' => $water_account 
							) );
							// var_dump( $waterArr);
							if (! empty ( $waterArr )) {
								
								$s_where = array (
										'usedate' => $date,
										'suitid' => $value ['suitid'],
										'insurance_id' => $value ['insurance_id'],
										'water_account' => $water_account 
								); // 同一个流水号的订单.防止重复提交订单
								$fdata = $this->insure_model->get_insurance_people ( $s_where );
								if (! empty ( $fdata [0] )) {
									$insureDataArr [$x] ['insura'] = $fdata;
									$insureDataArr [$x] ['water_account'] = $water_account;
								}
								
								$x ++;
							} else {
								
								$x = - 1;
							}
						}
						
						$su_where = array (
								'usedate' => $date,
								'suitid' => $value ['suitid'],
								'insurance_id' => $value ['insurance_id'],
								'water_account' => '' 
						); // 后来添加的保险
						/*
						 * if($x==-1){ $x=count($insureDataArr)+1; }else{ $x=count($insureDataArr)+1; }
						 */
						
						$Idata = $this->insure_model->get_insurance_people ( $su_where );
						if (! empty ( $Idata )) {
							$insureDataArr [$mub] ['insura'] = $Idata;
							$insureDataArr [$mub] ['water_account'] = $water_account;
						}
						
						// print_r($insureDataArr );echo '<br>';
						
						foreach ( $insureDataArr as $kt => $vt ) {
							$order_insure = $vt ['insura'];
							if (! empty ( $order_insure )) {
								// print_r($order_insure);echo '<br>';
								$water_account = $vt ['water_account'];
								$insurance_price = $value ['people'] * $value ['insurance_price'];
								$xml_array = $this->get_insurance_api ( $insuraData, $order_insure, $water_account ); // 投保接口
								$ob = simplexml_load_string ( $xml_array, null, LIBXML_NOCDATA );
								$json = json_encode ( $ob );
								$configData = json_decode ( $json, true );
								// var_dump($configData);
								foreach ( $configData as $a => $b ) {
									// echo $b['RESULTCODE'];
									if (! empty ( $b ['RESULTCODE'] )) { // 返回保险接口的状态代码
										
										if ($b ['RESULTCODE'] == "0000" || $b ['RESULTCODE'] == "1111") { // 交易成功或是重复投保
											
											$polno = $configData ['MAIN'] ['POLNO']; // 保单号
											if (! empty ( $configData ['MAIN'] ['RECEIPT_URL'] )) {
												$url = $configData ['MAIN'] ['RECEIPT_URL']; // 保险证书
											} else {
												$url = '';
											}
											$people_num = count ( $order_insure );
											$settlement_price = $people_num * $order_insure [0] ['settlement_price'];
											$insurance_price = $people_num * $value ['insurance_price'];
											$object = array (
													'line_id' => $value ['line_id'],
													'insurance_id' => $value ['insurance_id'],
													'order_use_date' => $order_insure [0] ['usedate'],
													'people_num' => count ( $order_insure ),
													'insurance_code' => $polno,
													'insurance_sn' => $url,
													'insurance_price' => $insurance_price,
													// 'settlement_price'=>$value['settlement_price'],
													'settlement_price' => $settlement_price,
													'status' => 1,
													'water_account' => $water_account,
													'suit_id' => $value ['suitid'],
													'suit_day_id' => $order_insure [0] ['suit_price_id'] 
											);
											// 改变订单状态
											if (! empty ( $order_insure )) {
												foreach ( $order_insure as $keys => $vals ) {
													$data = array (
															'is_buy' => 1 
													);
													$this->insure_model->update_rowdata ( 'u_order_insurance', $data, array (
															'id' => $vals ['oid'] 
													) );
												}
											}
											
											$water_account = $this->insure_model->select_rowData ( 'u_insurance_order', array (
													'insurance_code' => $polno 
											) );
											if (empty ( $water_account )) { // 投保表
												$this->insure_model->insert_data ( 'u_insurance_order', $object );
											}
											// echo $this->db->last_query();
											$text = $b ['ERRINFO'];
										} else {
											$text = $b ['ERRINFO'];
										}
									} else {
										// echo '交易失败';
									}
								}
							}
						}
					} else {
						echo '投保人数不对';
					}
				} else {
					echo '没有投保人';
				}
			}
			echo $text;
			// print_r($insuraData[1]['order_insure']);
		} else {
			echo '没有投保人';
		}
	}
	// 保险接口
	public function get_insurance_api($insuraData, $order_insure, $water_account) {
		$this->get_xmldata ( $insuraData, $order_insure, $water_account );
		$xmldata = file_get_contents ( 'insurance.xml' );
		
		// $url = 'https://61.138.246.87:6002/LifeServiceUat'; //接收xml数据的文件
		$url = $this->insura_api_url;
		$header [] = "Content-Type: text/xml; charset=GBK"; // 定义content-type为xml,注意是数组
		$header [] = "GW_CH_TX: 1021";
		$header [] = "GW_CH_CODE: SZHWGL";
		$header [] = "GW_CH_USER: SZHWGL";
		$header [] = "GW_CH_PWD:SZHWGL ";
		$ch = curl_init ( $url );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $xmldata );
		// header ( "content-type:text/xml;charset=GBK" );
		$response = curl_exec ( $ch );
		if (curl_errno ( $ch )) {
			print curl_error ( $ch );
		}
		curl_close ( $ch );
		// 改变订单状态
		if (! empty ( $order_insure )) {
			foreach ( $order_insure as $keys => $vals ) {
				$data = array (
						'water_account' => $water_account 
				);
				$this->insure_model->update_rowdata ( 'u_order_insurance', $data, array (
						'id' => $vals ['oid'] 
				) );
			}
		}
		return $response;
		// echo $response;
		// exit;
	}
	
	// 被保险人信息
	public function get_xmldata($insuraData, $order_insure, $water_account) {
		$peple = '';
		/*
		 * if($insuraData['insurance_code']=='A0111'){ //意外险 if($insuraData['insurance_price']=='6' || $insuraData['insurance_price']=='6.00'){ $count=1; }else if($insuraData['insurance_price']=='12' || $insuraData['insurance_price']=='12.00'){ $count=2; }else if($insuraData['insurance_price']=='18' || $insuraData['insurance_price']=='18.00'){ $count=3; }else if($insuraData['insurance_price']=='24' || $insuraData['insurance_price']=='24.00'){ $count=4; }else{ $count=5; } $momey=$insuraData['insurance_price']*count($order_insure); $momey= sprintf("%.2f", $momey); }else{
		 */
		// 其他保险
		$count = count ( $order_insure ); // 同订单,同一个方案
		                             // $momey=$insura[0]['insurance_price']*$count*$insura[0]['lineday'];
		$momey = $insuraData ['insurance_price'] * $count;
		$momey = sprintf ( "%.2f", $momey );
		// }
		
		$usedate = '';
		$date = '';
		$routname = "路线/航班号";
		foreach ( $order_insure as $k => $v ) {
			if ($v ['sex'] == 0) { // 性别:女
				$sex = 1062;
			} elseif ($v ['sex'] == 1) {
				$sex = 1061;
			} else {
				$sex = 1060;
			}
			$routname = $v ['productname'];
			// 证件类型
			if ($v ['certificate'] == '身份证') {
				$idtype = 1201;
			} elseif ($v ['certificate'] == '户口薄') {
				$idtype = 1202;
			} elseif ($v ['certificate'] == '军官证') {
				$idtype = 1206;
			} elseif ($v ['certificate'] == '护照') {
				if (! empty ( $v ['enname'] )) {
					$idtype = 1204;
				} else {
					$idtype = 1203;
				}
			} elseif ($v ['certificate'] == '通行证') {
				$idtype = 12011;
			}
			
			if (empty ( $v ['name'] )) {
				$v ['name'] = $v ['enname'];
			}
			
			$v ['lineday'] = $v ['lineday'] - 1;
			
			// if(!empty($v['usedate']) && !empty($v['lineday'])){
			
			// }
			
			$str = "\t<BBRS>\r\t";
			$str .= "\t<BBR>\r\t";
			$str .= "\t<BBRNAME>" . $v ['name'] . "</BBRNAME>\r\t";
			$str .= "\t<BBRSEX>" . $sex . "</BBRSEX>\r\t";
			$str .= "\t<BBRBIRTH>" . $v ['birthday'] . "</BBRBIRTH>\r\t";
			$str .= "\t<BBRIDTYPE>" . $idtype . "</BBRIDTYPE>\r\t";
			$str .= "\t<BBRIDNO>" . $v ['certificate_no'] . "</BBRIDNO>\r\t";
			// $str.="\t<BBRADDR>".$v['sign_place']."</BBRADDR>\r\t";
			$str .= "\t<BBRADDR></BBRADDR>\r\t";
			$str .= "\t<BBRPOSTCODE></BBRPOSTCODE>\r\t";
			$str .= "\t<BBRTEL></BBRTEL>\r\t";
			$str .= "\t<BBRMOBILE>" . $v ['telephone'] . "</BBRMOBILE>\r\t";
			$str .= "\t<BBREMAIL></BBREMAIL>\r\t";
			$str .= "\t<BBRWORKCODE></BBRWORKCODE>\r\t";
			$str .= "\t<BBRCATEGORY></BBRCATEGORY>\r\t";
			$str .= "\t<BBRPROVINCE></BBRPROVINCE>\r\t";
			$str .= "\t<BBRCITY></BBRCITY>\r\t";
			$str .= "\t<BBRCOUNTY></BBRCOUNTY>\r\t";
			$str .= "\t<BENIFITMARK>N</BENIFITMARK>\r\t";
			$str .= "\t<SYRS>\r\t";
			$str .= "\t<SYR>\r\t";
			
			$str .= "\t</SYR>\r\t";
			$str .= "\t</SYRS>\r\t";
			$str .= "\t</BBR>\r\t";
			$str .= "\t</BBRS>\r\t";
			
			if (! empty ( $v ['usedate'] )) {
				$usedate = $v ['usedate'];
				$date = date ( 'Y-m-d', strtotime ( "{$v['usedate']} +{$v['lineday']}day" ) );
			}
			
			$peple = $peple . $str;
		}
		// 流水账号:线路id+出团日期+套餐id+报价id
		$water_account = $water_account;
		$str = '<?xml version="1.0" encoding="GBK"?>
			<INSUREQ>
			<HEAD>
			<TRANSRNO>1021</TRANSRNO>
			<PARTNERCODE>SZHWGL</PARTNERCODE>
			<PARTNERSUBCODE>SZHWGL</PARTNERSUBCODE>
			</HEAD>
			<MAIN>	
			<PRODUCTCODE>' . $insuraData ['insurance_code'] . '</PRODUCTCODE>
			<SERIALNUMBER>' . $water_account . '</SERIALNUMBER>
			<TRANSRDATE>' . date ( 'Y-m-d H:i:s' ) . '</TRANSRDATE>
			<PRODUCTUNIT>1</PRODUCTUNIT>
			<EFFDATE>' . $usedate . ' 00:00:00</EFFDATE>
			<TERMDATE>' . $date . ' 24:00:00</TERMDATE>
			<CATALOGPREMIUM>' . $momey . '</CATALOGPREMIUM>
			<BBRUNIT>' . $count . '</BBRUNIT>
			<APPCONTENT>' . $routname . '</APPCONTENT>
			</MAIN>
			<HEALPOLICYINFO>
			<TBR>
			<TBRNAME>张三</TBRNAME>
			<TBRSEX>1061</TBRSEX>
			<TBRIDTYPE>1201</TBRIDTYPE>
			<TBRIDNO>130406198801160641</TBRIDNO>
			<TBRBIRTH>1980-01-01</TBRBIRTH>
			<TBRADDR>石家庄市</TBRADDR>
			<TBRPOSTCODE>050000</TBRPOSTCODE>
			<TBRTEL>03178713265</TBRTEL>
			<TBRMOBILE>13001121112</TBRMOBILE>
			<TBREMAIL>qw@126.com</TBREMAIL>
			<TBRBBRRELATION>213001</TBRBBRRELATION>
			<ENAME>jaky</ENAME>
			<CORPORATION/>
			<SOCIALNO/>
			<FAX/>
			<ORGPROPERTY/>
			<TRADCODE/>
			<LINKMAN/>
			<LINKMANIDTYPE/>
			<LINKMANIDNO/>
			<LINKMANTEL/>
			<LINKMANMOBILE/>                  
			<LINKMANPOSTCODE/>
			<LINKMANADDRESS1/>
			<LINKMANADDRESS2/>
			<LINKMANADDRESS3/>
			<LINKMANADDR/>
			</TBR>' . $peple . '
			</HEALPOLICYINFO>
			</INSUREQ>';
		$_fp = @fopen ( 'insurance.xml', 'w' );
		$str = mb_convert_encoding ( $str, "GBK", "utf-8" );
		flock ( $_fp, LOCK_EX );
		fwrite ( $_fp, $str, strlen ( $str ) );
		flock ( $_fp, LOCK_UN );
		fclose ( $_fp );
	}
	
	/**
	 * *对账接口
	 */
	public function account() {
		// $xmldata=' 42SZ001 | 42SZ00101 | 20150119 | 1021 | 012015830122016020183000058 | | 100.55 | ';
		$xmldata = $this->get_order_insurance (); // 对账数据
		                                       // var_dump($xmldata);exit;
		if (! empty ( $xmldata )) {
			// $url = 'https://61.138.246.87:6002/LifeServiceUat'; //接收xml数据的文件
			$url = $this->insura_api_url;
			$header [] = "Content-Type: text/xml; charset=GBK"; // 定义content-type为xml,注意是数组
			$header [] = "GW_CH_TX: 1024";
			$header [] = "GW_CH_CODE: SZHWGL";
			$header [] = "GW_CH_USER: SZHWGL";
			$header [] = "GW_CH_PWD:SZHWGL ";
			$ch = curl_init ( $url );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt ( $ch, CURLOPT_URL, $url );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $xmldata );
			header ( "content-type:text/xml;charset=GBK" );
			$response = curl_exec ( $ch );
			if (curl_errno ( $ch )) {
				print curl_error ( $ch );
			}
			curl_close ( $ch );
			echo $response;
		} else {
			echo '没有要对账的数据';
		}
	}
	
	// 对账接口数据
	public function get_order_insurance() {
		$xmldata = '';
		// 订单保险数据
		// $date='2016-06-18';
		$date = date ( "Y-m-d" ); // 当前时间对账
		                     // 订单信息
		$insurance = $this->insure_model->get_complete_order ( array (
				'starttime' => $date 
		) );
		// echo $this->db->last_query();exit;
		if (! empty ( $insurance )) {
			foreach ( $insurance as $key => $value ) {
				if ($value ['status'] == - 1) {
					$datetime = date ( "Ymd" ); // 日期
					$insurance_code = $value ['insurance_code']; // 保单号
					$insurance_sn = $value ['insurance_sn']; // 保险单
					$amount = $value ['insurance_price']; // 费用
					$insurance_code_cancel = $value ['batch_number']; // 批单号
					$xmldata = $xmldata . '  SZHWGL | SZHWGL | ' . $datetime . ' | 1021 | ' . $insurance_code . ' | | ' . $amount . ' |  '; // 对账数据
					$xmldata = $xmldata . '\n\r';
					$xmldata = $xmldata . '  SZHWGL | SZHWGL | ' . $datetime . ' | 1022 | ' . $insurance_code . ' | ' . $insurance_code_cancel . ' | -' . $amount . ' |  ';
					$xmldata = $xmldata . '\n\r';
				} else {
					$datetime = date ( "Ymd" ); // 日期
					$insurance_code = $value ['insurance_code']; // 保单号
					$insurance_sn = $value ['insurance_sn']; // 保险单
					$amount = $value ['insurance_price']; // 费用
					$xmldata = $xmldata . '  SZHWGL | SZHWGL | ' . $datetime . ' | 1021 | ' . $insurance_code . ' | | ' . $amount . ' |  ';
					$xmldata = $xmldata . '\n\r';
				}
			}
		}
		
		return $xmldata;
	}
	
	// 批改接口-----------注销-------------
	public function edit_insurance() {
		// 保单号
		$insurance_code = $this->input->post ( 'insurance_code', true );
		$insurance_code = trim ( $insurance_code );
		// $insurance_code='012016830122016020183111520';
		$data = $this->insure_model->get_insurance_baodan ( $insurance_code );
		
		if (! empty ( $data )) {
			$xmldata = $this->get_diplay_data ( $data );
			$url = $this->insura_api_url;
			$header [] = "Content-Type: text/xml; charset=GBK"; // 定义content-type为xml,注意是数组
			$header [] = "GW_CH_TX: 1022";
			$header [] = "GW_CH_CODE: SZHWGL";
			$header [] = "GW_CH_USER: SZHWGL";
			$header [] = "GW_CH_PWD:SZHWGL ";
			$ch = curl_init ( $url );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt ( $ch, CURLOPT_URL, $url );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $xmldata );
			// header ( "content-type:text/xml;charset=GBK" );
			$response = curl_exec ( $ch );
			if (curl_errno ( $ch )) {
				print curl_error ( $ch );
			}
			curl_close ( $ch );
			
			$ob = simplexml_load_string ( $response, null, LIBXML_NOCDATA );
			$json = json_encode ( $ob );
			$configData = json_decode ( $json, true );
			$text = '';
			foreach ( $configData as $a => $b ) {
				
				if (! empty ( $b ['RESULTCODE'] )) { // 返回保险接口的状态代码
					
					if ($b ['RESULTCODE'] == '0000') { // 交易成功
						
						$polno = $configData ['MAIN'] ['CONFIRMNO']; // 保单号
						if (! empty ( $polno )) {
							$where = array (
									'insurance_code' => $insurance_code 
							);
							$object = array (
									'status' => - 1,
									'batch_number' => $polno 
							);
							$this->insure_model->update_rowdata ( 'u_insurance_order', $object, $where );
							// echo $this->db->last_query();
						}
						
						$text = $b ['ERRINFO'];
					} else {
						$text = $b ['ERRINFO'];
					}
				} else {
					// echo '交易失败';
				}
			}
			echo json_encode ( array (
					'status' => 1,
					'msg' => $text 
			) );
		} else {
			echo json_encode ( array (
					'status' => - 1,
					'msg' => '没有该保单号要注销的' 
			) );
		}
	}
	// 批改接口注销数据
	public function get_diplay_data($data) {
		$html = '<?xml version="1.0" encoding="GBK"?>
			<INSUREQ>
			<HEAD>
			<TRANSRNO>1022</TRANSRNO>
			<PARTNERCODE>SZHWGL</PARTNERCODE>
			<PARTNERSUBCODE>SZHWGL</PARTNERSUBCODE>
			</HEAD>
			<MAIN>	
			<PRODUCTCODE>' . $data ["code"] . '</PRODUCTCODE>
			<SERIALNUMBER>CJ' . date ( 'YmdHis' ) . '</SERIALNUMBER>
			<TRANSRDATE>' . date ( 'Y-m-d H:i:s' ) . '</TRANSRDATE>
			<POLNO>' . $data ["insurance_code"] . '</POLNO>
			<CORRECTCODE>320011</CORRECTCODE>
			<TOTLPREMCHANGE>-' . $data ["insurance_price"] . '</TOTLPREMCHANGE>
			<SQRNAME>admin</SQRNAME>
			<SQRIDTYPE>1201</SQRIDTYPE>
			<SQRIDNO>474747658909876543</SQRIDNO>
			<APPLYDATE>' . date ( 'Y-m-d H:i:s' ) . '</APPLYDATE>
			<APPLYREASON>注销</APPLYREASON>		
			</MAIN>
			<HEALCORRECTINFO>
			</HEALCORRECTINFO>
			</INSUREQ>';
		return $html;
	}
	// 批改接口-----------换人-------------
	function insurance_change() {
		// 订单信息
		$insurance = $this->insure_model->get_insurance_member ( array () );
		echo $this->db->last_query ();
		exit ();
		$xmldata = $this->insurance_change_data ();
		echo $xmldata;
	}
	
	// 批改接口换人数据
	function insurance_change_data() {
		$html = ' <?xml version="1.0" encoding="GBK"?>
			<INSUREQ>
				<HEAD>
					<TRANSRNO>1022</TRANSRNO>
					<PARTNERCODE>SZHWGL</PARTNERCODE>
					<PARTNERSUBCODE>SZHWGL</PARTNERSUBCODE>
				</HEAD>
				<MAIN>	
					<PRODUCTCODE>100001</PRODUCTCODE>
					<SERIALNUMBER>CJ140000000000100431</SERIALNUMBER>
					<TRANSRDATE>2015-01-23 10:00:00</TRANSRDATE>
					<POLNO>012015830122016020183000058</POLNO>
					<CORRECTCODE>320032</CORRECTCODE>
					<INCREASENUM>1</INCREASENUM>
					<REDUCENUM>1</REDUCENUM>
					<TOTLPREMCHANGE>0.00</TOTLPREMCHANGE>
					<SQRNAME>83D0096</SQRNAME>
					<SQRIDTYPE>1201</SQRIDTYPE>
					<SQRIDNO>474747658909876543</SQRIDNO>
					<APPLYDATE>2015-01-23</APPLYDATE>
					<APPLYREASON>换人</APPLYREASON>		
				</MAIN>
				<HEALCORRECTINFO>
					<BBRS>
						<BBR>
							<BBRNAME>测试</BBRNAME>
							<BBRSEX></BBRSEX>
							<BBRBIRTH></BBRBIRTH>
							<BBRIDTYPE>12010</BBRIDTYPE>
							<BBRIDNO>122221113</BBRIDNO>
							<BBRTEL></BBRTEL>
							<BBRWORKCODE></BBRWORKCODE>
							<BBRCORRECTTYPE>030002</BBRCORRECTTYPE>
							<FILLAREFUND></FILLAREFUND>
						</BBR>
						<BBR>
							<BBRNAME>测试3</BBRNAME>
							<BBRSEX></BBRSEX>
							<BBRBIRTH></BBRBIRTH>
							<BBRIDTYPE>12010</BBRIDTYPE>
							<BBRIDNO>122221113</BBRIDNO>
							<BBRTEL></BBRTEL>
							<BBRWORKCODE></BBRWORKCODE>
							<BBRCORRECTTYPE>030001</BBRCORRECTTYPE>
							<FILLAREFUND></FILLAREFUND>
						</BBR>
					</BBRS>
				</HEALCORRECTINFO>
			</INSUREQ>';
		return $html;
	}
}	

