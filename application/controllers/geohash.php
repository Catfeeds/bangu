<?php
 /**
 *   @abstract   API接口: 经纬度哈希值 
 *   @author 温文斌
 *   @version 2016年4月25日
 *   @version 2.0
 *      
 *      geohash长度	Lat位数	Lng位数	Lat误差	Lng误差	km误差
 *				1	2	3	±23	±23	±2500
 *				2	5	5	± 2.8	±5.6			±630
 *				3	7	8	± 0.70	± 0.7			±78
 *				4	10	10	± 0.087	± 0.18			±20
 *				5	12	13	± 0.022	± 0.022			±2.4
 *				6	15	15	± 0.0027	± 0.0055	±0.61
 *				7	17	18	±0.00068	±0.00068	±0.076
 *				8	20	20	±0.000086	±0.000172	±0.01911
 *				9	22	23	±0.000021	±0.000021	±0.00478
 *				10	25	25	±0.00000268	±0.00000536	±0.0005971
 *				11	27	28	±0.00000067	±0.00000067	±0.0001492
 *				12	30	30	±0.00000008	±0.00000017	±0.0000186
 */

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

//define ('JSON_PRETTY_PRINT', 128);
//define ('JSON_UNESCAPED_UNICODE', 256);

class Geohash extends MY_Controller {
	public function __construct() {
		parent::__construct ();
		date_default_timezone_set ( 'Asia/Shanghai' );
		header ( "content-type:text/html;charset=utf-8" );
		$this->db = $this->load->database ( "default", TRUE );
		$this->load->helper ( "string" );
		header ( 'Content-type: application/json;charset=utf-8' );
		echo header ( 'Access-Control-Allow-Origin: *' );
		
	
		
	}
	/**
	 * API： "经纬度" => "geohash码"
	 * @param 距离 $len
	 * @param 维度 $lat
	 * @param 经度 $lon
	 * 
	 * @return geohash
	 */
	public function cfg_geohash()
	{
		$lat=$this->input->post("lat",true);
		$lng=$this->input->post("lng",true);
		$length=$this->input->post("length",true);
		//$lng="114.070908";
		//$lat="22.546162";
		//$length="4";
		if(!$lat||!$lng) $this->__errormsg('param missing');
		if(!$length) $length="12";
		$geohash=$this->encode_geohash($lat,$lng,$length);
		$geohash_arr=$this->getGeoHashExpand($geohash);
		
		$this->__outmsg($geohash);
	}
	/**
	 * API： "经纬度" => 9个扇形"geohash码"区域
	 * @param 距离 $len
	 * @param 维度 $lat
	 * @param 经度 $lon
	 * 
	 * @return 9个geohash
	 */
	public function cfg_nine_geohash()
	{
		$lat=$this->input->post("lat",true);
		$lng=$this->input->post("lng",true);
		$length=$this->input->post("length",true);
		//$lng="114.070908";
		//$lat="22.546162";
		//$length="4";
		if(!$lat||!$lng) $this->__errormsg('param missing');
		if(!$length) $length="12";
		$geohash=$this->encode_geohash($lat,$lng,$length);
		$geohash_arr=$this->getGeoHashExpand($geohash);

		$this->__outmsg($geohash_arr);
	}
	/**
	 * API： "geohash" => 9个扇形"geohash码"区域
	 * @param  $geohash 
	 *
	 * @return 9个geohash
	 */
	public function cfg_nine_geohash_two()
	{
		$geohash=$this->input->post("geohash",true);
		if(!$geohash) $this->__errormsg('param missing');
		$geohash_arr=$this->getGeoHashExpand($geohash);

		$this->__outmsg($geohash_arr);
	}
	/**
	 * API： "geohash码" => "经纬度"
	 * @param 距离 $geohash
	 *
	 * @return 经纬度
	 */
	public function cfg_GPRS()
	{
		$geohash=$this->input->post("geohash",true);
		//$geohash="ws12";
		if(!$geohash) $this->__errormsg('param missing');
		$location=$this->decode_geohash($geohash);
		$output['lat']=$location[0];
		$output['lng']=$location[1];
		
		$this->load->model('common/u_expert_location_model','expert_location');
		$result=$this->expert_location->all(array());
		$this->__outmsg($result);
	}
 
	/**
	 * 专家实时插入位置
	 */
	public function post_expert_location(){
		//载入模型
		$this->load->model('common/u_expert_location_model','expert_location');
		//接收数据
		$eid=$this->input->post('eid');
		$lat=$this->input->post('lat');
		$lng=$this->input->post('lng');
		$length='12';
		
		if(!$eid||!$lat||!$lng) {$this->__outmsg('param missing', '-3', array());exit();}
		//处理数据
		$geohash=$this->encode_geohash($lat,$lng,$length);
		$dataArr=array(
				'eid'=>$eid,
				'lat'=>$lat,
				'lng'=>$lng,
				'geohash'=>$geohash,
				'updatetime'=>date('Y-m-d H:i:s')
		);
		$g=$this->expert_location->row(array('eid'=>$eid));
		if($g){
			$status=$this->expert_location->update($dataArr,array('eid'=>$eid));
		}else{
			//插入数据
			$status=$this->expert_location->insert($dataArr);
			
		}
		//返回插入接口
		if($status){
			
				$this->__successmsg('插入位置成功');
			
		}else{
			
				$this->__errormsg('插入位置失败');
			
		}
	}
	
 
	

	/**
	 * 获取九个点的矩形编码(包括自己)
	 * 
	 * @param geohash
	 * @return
	 */
	protected function getGeoHashExpand($geohash) {
		$this->setMap();
		 
		//System.out.println("=========中心	" + geohash);
	
		$geohashTop = $this->calculateAdjacent($geohash, "top");
		//	echo  "<BR>geohashTop : $geohashTop";

			$geohashBottom = $this->calculateAdjacent($geohash, "bottom");
		//	echo  "<BR>geohashBottom : $geohashBottom";
	
			$geohashRight = $this->calculateAdjacent($geohash, "right");
		//	echo  "<BR>geohashRight : $geohashRight";
	
			$geohashLeft = $this->calculateAdjacent($geohash, "left");
		//	echo  "<BR>geohashLeft : $geohashLeft";
	
			$geohashTopLeft = $this->calculateAdjacent($geohashLeft, "top");
		//	echo  "<BR>geohashTopLeft : $geohashTopLeft";
	
			$geohashTopRight = $this->calculateAdjacent($geohashRight, "top");
		//	echo  "<BR>geohashTopRight : $geohashTopRight";
	
			$geohashBottomRight = $this->calculateAdjacent($geohashRight, "bottom");
		//	echo  "<BR>geohashBottomRight : $geohashBottomRight";
	
			$geohashBottomLeft = $this->calculateAdjacent($geohashLeft, "bottom");
		//	echo  "<BR>geohashBottomLeft : $geohashBottomLeft";
			
			
			$expand = array( $geohash, $geohashTop, $geohashBottom, $geohashRight, $geohashLeft, $geohashTopLeft,
			$geohashTopRight, $geohashBottomRight, $geohashBottomLeft );
			return $expand; 
	}
	
	 
	
	/**
	 * 编码: 经纬度  =>  geohash码
	 * 
	 * @param $latitude 经度
	 * @param $longitude 纬度
	 * @param $deep  长度
	 * 
	 * @return string geohash码
	 */
	protected function encode_geohash($latitude, $longitude, $deep)
	{
		$BASE32 = '0123456789bcdefghjkmnpqrstuvwxyz';
		$bits = array(16,8,4,2,1);
		$lat = array(-90.0, 90.0);
		$lon = array(-180.0, 180.0);
		 
		$bit = $ch = $i = 0;
		$is_even = 1;
		$i = 0;
		$mid;
		$geohash = '';
		while($i < $deep)
		{
			if ($is_even)
			{
				$mid = ($lon[0] + $lon[1]) / 2;
				if($longitude > $mid)
				{
					$ch |= $bits[$bit];
					$lon[0] = $mid;
				}else{
					$lon[1] = $mid;
				}
			} else{
				$mid = ($lat[0] + $lat[1]) / 2;
				if($latitude > $mid)
				{
					$ch |= $bits[$bit];
					$lat[0] = $mid;
				}else{
					$lat[1] = $mid;
				}
			}
			 
			$is_even = !$is_even;
			if ($bit < 4)
				$bit++;
			else {
				$i++;
				$geohash .= $BASE32[$ch];
				$bit = 0;
				$ch = 0;
			}
		}
		return $geohash;
	}
	/**
	 * 解码: geohash码 => 经纬度
	 * 
	 * @param geohash码
	 * 
	 * @return 经纬度
	 */
	protected function decode_geohash($geohash)	{
		$geohash = strtolower($geohash);
		$BASE32 = '0123456789bcdefghjkmnpqrstuvwxyz';
		$bits = array(16,8,4,2,1);
		$lat = array(-90.0, 90.0);
		$lon = array(-180.0, 180.0);
		$hashlen = strlen($geohash);
		$is_even = 1;
		 
		for($i = 0; $i < $hashlen; $i++ )
		{
			$of = strpos($BASE32,$geohash[$i]);
			for ($j=0; $j<5; $j++) {
				$mask = $bits[$j];
				if ($is_even) {
					$lon[!($of&$mask)] = ($lon[0] + $lon[1])/2;
				} else {
					$lat[!($of&$mask)] = ($lat[0] + $lat[1])/2;
				}
				$is_even = !$is_even;
			}
		}
		$point = array( 0 => ($lat[0] + $lat[1]) / 2, 1 => ($lon[0] + $lon[1]) / 2);
		return $point;
	}
	
	
	/*********************** 获取九个的矩形编码 ****************************************/
	
	public static  $digits = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
			'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
	public static   $lookup =array( );
	public static   $BORDERS = array( );
	public static   $NEIGHBORS = array( );
	
	/**
	 * 
	 * 初始化图形
	 *
	 */
	private function  setMap() {
		for ($i=0;$i<count( self::$digits);$i++){
			self::$lookup[self::$digits[$i]]=$i;
		}
		self::$NEIGHBORS["right:even"]= "bc01fg45238967deuvhjyznpkmstqrwx";
		self::$NEIGHBORS["left:even"]= "238967debc01fg45kmstqrwxuvhjyznp" ;
		self::$NEIGHBORS["top:even"]= "p0r21436x8zb9dcf5h7kjnmqesgutwvy" ;
		self::$NEIGHBORS["bottom:even"]= "14365h7k9dcfesgujnmqp0r2twvyx8zb" ;
	
		self::$NEIGHBORS["right:odd"]= "p0r21436x8zb9dcf5h7kjnmqesgutwvy" ;
		self::$NEIGHBORS["left:odd"]= "14365h7k9dcfesgujnmqp0r2twvyx8zb" ;
		self::$NEIGHBORS["top:odd"]= "bc01fg45238967deuvhjyznpkmstqrwx" ;
		self::$NEIGHBORS["bottom:odd"]= "238967debc01fg45kmstqrwxuvhjyznp" ;
	
		self::$BORDERS["right:even"]= "bcfguvyz" ;
		self::$BORDERS["left:even"]= "0145hjnp" ;
		self::$BORDERS["top:even"]= "prxz" ;
		self::$BORDERS["bottom:even"]= "028b" ;
	
		self::$BORDERS["right:odd"]= "prxz" ;
		self::$BORDERS["left:odd"]= "028b" ;
		self::$BORDERS["top:odd"]= "bcfguvyz" ;
		self::$BORDERS["bottom:odd"]= "0145hjnp" ;
	
	}
	
	
	/**
	 * 分别计算每个点的矩形编码
	 *
	 * @param srcHash
	 * @param dir
	 * @return
	 */
	
	private function calculateAdjacent($srcHash, $dir) {
		$srcHash=strtolower($srcHash);
		$lastChr =substr($srcHash,-1);
		$a = strlen($srcHash) % 2;
	
		$type ="even";
		if($a > 0){
			$type = "odd" ;
		}
		//	echo "<BR>srcHash:".$srcHash ;
		$base =substr($srcHash,0,strlen($srcHash)-1);
		//	echo  "<BR> base $base  ,lastChr $lastChr dir $dir  type $type" ;
		//	print_r(self::$BORDERS);
	
	
		$key=$dir.":".$type ;
		$val=self::$BORDERS[$key];
		//	echo "<BR> key $key,val $val,  lastChr $lastChr " ;
		$pos =strpos($val, $lastChr ) ;
		//	echo  "<BR> pos[ $pos] " ;
		//	exit();
		if (!empty($pos)) {
			$base = $this->calculateAdjacent($base, $dir);
		}
		//	echo  "<BR> base2: $base " ;
		$base = $base.self::$digits[strpos(self::$NEIGHBORS[$dir.":". $type],$lastChr)];
	
		//	echo  "<BR> base3: $base " ;
		//exit();
		return $base;
	}
	/**
	 * @name：私有函数：输出数据,$len是长度
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function __outmsg($reDataArr, $len = 1) {
		
		if(empty($reDataArr))
		{
			$code="4001";
			$msg="data empty";
			$data=array();
		}
		else 
		{
			if(is_array($reDataArr))
			{
				$len=count($reDataArr);
				$data['rows']=$reDataArr;
			}
			else
			{
				$data=$reDataArr;
			}
				
			$code="2000";
			$msg="success";
		}

		$output= json_encode ( array (
				"msg" => $msg,
				"code" => $code,
				"data" => $data,
				"total" => $len
		), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
		echo $output;
		exit ();
	}
	
	/**
	 * @name：私有函数：错误输出，已-3为标志
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function __errormsg($msg = "", $code = "-3") {
		
		if ($msg == "") 
		{
			$msg = "error";
		} 
		$this->resultJSON = json_encode ( array (
				"msg" => $msg,
				"code" => $code,
				"data" => array()
		) );
		echo $this->resultJSON;
		exit ();
	}
	
}