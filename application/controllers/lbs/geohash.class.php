<?php
/**
* Encode and decode geohashes
*/
class Geohash {
	/**
	 * 获取附近的点
	 * @param 距离 $len
	 * @param 维度 $lat
	 * @param 经度 $lon
	 */
	public function lbs($len,$lat,$lon){
		// 根据用户的 位置编码。 暂时 五位深度。
		// 根据编码计算周围的八个 编码 getGeoHashExpand
		// 用这九个 哈希编码 去管家位置表查   like 'geohash1%'  union like 'geohash2%'. 查出来的大约是 10公里范围的。这是第一次快速筛选。
		// 将筛选出来的这些管家位置，逐个和用户位置计算距离。
		$geohash =$this->encode_geohash($lat,$lon,$len) ;//wx4gkj,长度:6
		
		///////获取周围八个
		$expands = $this->getGeoHashExpand($geohash) ;
		return $expands;
			
	}
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	/*********************** 获取九个的矩形编码 ****************************************/
	
	public static  $digits = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
			'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
	public static   $lookup =array( );
	public static   $BORDERS = array( );
	public static   $NEIGHBORS = array( );
	
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
	 * 获取九个点的矩形编码(包括自己)
	 *
	 * @param geohash
	 * @return
	 */
	public function getGeoHashExpand($geohash) {
		$this->setMap();
		//System.out.println("=========中心	" + geohash);
		$geohashTop = $this->calculateAdjacent($geohash, "top");
		//	echo  "<BR>geohashTop : $geohashTop";
		//exit;
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
			
			
		$expand = array( $geohash, $geohashTop, $geohashBottom, $geohashRight, $geohashLeft, $geohashTopLeft,$geohashTopRight, $geohashBottomRight, $geohashBottomLeft );
		return $expand;
	}
	
	
	
	/**
	 * 编码
	 * @param unknown $latitude
	 * @param unknown $longitude
	 * @param unknown $deep
	 * @return string
	 */
	function encode_geohash($latitude, $longitude, $deep)
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
	 * 解码
	 * @param unknown $geohash
	 * @return multitype:number
	 */
	function decode_geohash($geohash)	{
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
}
?>