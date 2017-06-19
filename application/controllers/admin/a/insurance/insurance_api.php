<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Insurance_api extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->database();
		$this->load->model ( 'admin/a/insure_model','insure_model');

	}
	public function index()
	{
		//订单保险数据
		$date=date("Y-m-d",strtotime("+1 day"));
		//保险类型
		//$insurance=$this->insure_model->select_data('u_travel_insurance','insurance_code != " " ');
		$insurance=$this->insure_model->get_order_result(array('starttime'=>$date));
		if(!empty($insurance)){
			    foreach ($insurance as $key => $value) {

				$insurance_code=$value['insurance_code'];
				// var_dump($insurance_code);
				$insura_where=array('starttime'=>$date,'insurance_code'=>$insurance_code,'order_id'=>$value['order_id']);
				$order_insure=$this->insure_model->get_insurance_member($insura_where);
	                                    
				$insuraData[$key]['code']=$insurance_code;
				$insuraData[$key]['insura']=$order_insure;
	                                   
				if(!empty($order_insure)){
			
					$code=$insurance_code;  	//保险方案编号
					$insura=$order_insure;	//保险人数
					$xml_array=$this->get_insurance_api($code,$insura); //投保接口
					$ob= simplexml_load_string($xml_array);
					$json  = json_encode($ob);
					$configData = json_decode($json, true);

					foreach ($configData as $key => $value) {
						if($value['RESULTCODE']=='0000'){ //交易成功
							foreach ($order_insure as $n => $y) {
								$orderid=$y['order_id'];
								$travelid=$y['travelid'];	
								$where=array(
									'order_id'=>$orderid,
									'insurance_id'=>$travelid	
								);
								$object=array('is_buy'=>1);
								$this->insure_model->update_rowdata('u_order_insurance',$object,$where);
							}
							echo $value['ERRINFO'];		
						}else{
							echo $value['ERRINFO'];
								
						}	
					}
		                          }else{
		                          	echo '没有投保人';
		                          }
			}
		}else{
			echo '没有投保人';
		}	

	}
	//保险接口
	public function get_insurance_api($code,$insura){
                                   //      var_dump($insura);
	       		$this->get_xmldata($code,$insura); 
	                          $xmldata=file_get_contents('insurance.xml');
                            
			$url = 'https://61.138.246.87:6002/LifeServiceUat';  //接收xml数据的文件
			$header[] = "Content-Type: text/xml; charset=GBK"; //定义content-type为xml,注意是数组
	 		$header[]="GW_CH_TX: 1021";
			$header[]="GW_CH_CODE: SZHWGL";
		 	$header[]="GW_CH_USER: SZHWGL";
			$header[]="GW_CH_PWD:SZHWGL "; 
			$ch = curl_init ($url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xmldata);
			
			$response = curl_exec($ch);
			if(curl_errno($ch)){
				print curl_error($ch);
			}
			curl_close($ch);
			return  $response;
			//echo   $response;
	}

	//被保险人信息
	public function get_xmldata($code,$insura){
		$peple='';
		$count=count($insura);
		$momey=$insura[0]['insurance_price']*$count*$insura[0]['lineday'];
		$momey= sprintf("%.2f", $momey); 

                            foreach ($insura as $k => $v) {           
                                       if($v['sex']==0){   //性别:女
                                             $sex=1062;		
                                       }elseif($v['sex']==1){
                                             $sex=1061;
                                       }else{
                                      	      $sex=1060;
                                       }
                                       //证件类型
                                       if($v['certificate']=='身份证'){
                                              $idtype=1201;
                                       }elseif ($v['certificate']=='户口薄') {
                                              $idtype=1202;
                                       }elseif ($v['certificate']=='军官证') {
                                              $idtype=1206;
                                       }elseif ($v['certificate']=='护照') {
                                       	if(!empty($v['enname'])){
                                       	      $idtype=1204;		
                                       	}else{
                                       	       $idtype=1203;	
                                       	}	
                                       }elseif ($v['certificate']=='通行证') {
                                       	 $idtype=12011;	
                                       }
                                      
                                      if(empty($v['name'])){
                                       	$v['name']=$v['enname'];
                                      }
      
                                     $v['lineday']=$v['lineday']-1;

                                     $date= date('Y-m-d',strtotime("{$v['usedate']} +{$v['lineday']}day"));
                         
                                  	$str="\t<BBRS>\r\t";
		          	$str.="\t<BBR>\r\t";
		         	$str.="\t<BBRNAME>".$v['name']."</BBRNAME>\r\t";
			$str.="\t<BBRSEX>".$sex."</BBRSEX>\r\t";
			$str.="\t<BBRBIRTH>".$v['birthday']."</BBRBIRTH>\r\t";
			$str.="\t<BBRIDTYPE>".$idtype."</BBRIDTYPE>\r\t";
			$str.="\t<BBRIDNO>".$v['certificate_no']."</BBRIDNO>\r\t";
			$str.="\t<BBRADDR>".$v['sign_place']."</BBRADDR>\r\t";
			$str.="\t<BBRPOSTCODE></BBRPOSTCODE>\r\t";
			$str.="\t<BBRTEL></BBRTEL>\r\t";
			$str.="\t<BBRMOBILE>".$v['telephone']."</BBRMOBILE>\r\t";
			$str.="\t<BBREMAIL></BBREMAIL>\r\t";
			$str.="\t<BBRWORKCODE></BBRWORKCODE>\r\t";
			$str.="\t<BBRCATEGORY></BBRCATEGORY>\r\t";
			$str.="\t<BBRPROVINCE>110000</BBRPROVINCE>\r\t";
			$str.="\t<BBRCITY>110100</BBRCITY>\r\t";
			$str.="\t<BBRCOUNTY>110000</BBRCOUNTY>\r\t";
			$str.="\t<BENIFITMARK>N</BENIFITMARK>\r\t";
			$str.="\t<SYRS>\r\t";
			$str.="\t<SYR>\r\t";


			$str.="\t</SYR>\r\t";
			$str.="\t</SYRS>\r\t";
			$str.="\t</BBR>\r\t";
			$str.="\t</BBRS>\r\t";
                                      $usedate= $v['usedate'];

			$peple=$peple.$str;
			  
                            }
                         //   var_dump($usedate);
                           // <EFFDATE>'.$v['usedate'].'</EFFDATE>
		//	<TERMDATE> '.$date.'</TERMDATE>
                      //   var_dump( $momey);
		  $str='<?xml version="1.0" encoding="GBK"?>
			<INSUREQ>
			<HEAD>
			<TRANSRNO>1021</TRANSRNO>
			<PARTNERCODE>SZHWGL</PARTNERCODE>
			<PARTNERSUBCODE>SZHWGL</PARTNERSUBCODE>
			</HEAD>
			<MAIN>	
			<PRODUCTCODE>'.$code.'</PRODUCTCODE>
			<SERIALNUMBER>lj'.date('YmdHis').'</SERIALNUMBER>
			<TRANSRDATE>'.date('Y-m-d H:i:s').'</TRANSRDATE>
			<PRODUCTUNIT>1</PRODUCTUNIT>
			<EFFDATE>'.$usedate.' 00:00:00</EFFDATE>
			<TERMDATE>'.$date.' 24:00:00</TERMDATE>
			<CATALOGPREMIUM>'.$momey.'</CATALOGPREMIUM>
			<BBRUNIT>'.$count.'</BBRUNIT>
			<APPCONTENT>路线/航班号</APPCONTENT>
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
			</TBR>'.$peple.'
			</HEALPOLICYINFO>
			</INSUREQ>';
			$_fp = @fopen('insurance.xml','w');
			$str = mb_convert_encoding( $str, "GBK", "utf-8");
  			flock($_fp,LOCK_EX);
  	 		fwrite($_fp, $str ,strlen($str)); 
			flock($_fp,LOCK_UN);
			fclose($_fp);
	}




}	

