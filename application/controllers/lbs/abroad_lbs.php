<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

include_once ('geohash.class.php');
class Abroad_lbs extends MY_Controller {
	protected $index_len = 5;
	protected $geohash;
	public function __construct() {
		parent::__construct ();
		$this->load->driver( 'cache', array('adapter' => 'redis' ) );
		$this->geohash = new Geohash();
	}
	/**
	 * 插入管家位置 - 如果存在则更新
	 */
	public function put() {
// 		$foo = 'foobarbaz!';
// 		
// 		$this->cache->save('foo', $foo, 300);
// 		echo "foo:[".$this->cache->get('foo')."]";
// 		$lat = 39.98123848;
// 		$lon = 116.30683690;
// 		$len = 12; // hash 长度
// 		$geohash = $this->geohash->encode_geohash ( $lat, $lon, $len ); // wx4gkj,长度:6
		
// 		echo ("<BR/>lat:$lat ,lon:$lon , len:$len,   geohash:" . $geohash);
// 		// /////获取周围八个
// 		$expands = $this->geohash->getGeoHashExpand ( $geohash );
// 		print_r ( "<BR/>expands周围9个中心点:" );
// 		print_r ( $expands );

// 		22.567663, 114.167985
		$this->cache->select(0);
		$this->upinfo("闲湖植物园", 22.567663, 114.167985);
		$this->upinfo("东湖公园", 22.557483, 114.147389);
		$this->upinfo("小梅沙", 22.600912, 114.320410);
		$this->upinfo("东部华侨城", 22.607250, 114.304057);
		$this->upinfo("广深宾馆", 22.544026, 114.126809);
	}
	
	public function map(){
		$this->load->view('test' );
	}
	
	public function get(){
		$lat = $this->input->post ( 'lat' ,true );
		$lon = $this->input->post ( 'lon' ,true );
// 		$lat = 22.544163;
// 		$lon = 114.127440;
// 		echo "lat:".$lat."    lon:".$lon."</br>";
		$re = $this->serach($lat,$lon);
// 		var_dump($re);
		$list = '[';
		
		if(null!=$re){
			for($i=0;$i<count($re);$i++){
				if($i>0){
					$list.= ',';
				}
				$lat = $this->cache->hGet ( $re[$i], 'la' );
				$lon = $this->cache->hGet ( $re[$i], 'lo' );
				
				$list.= '{';
				$list.= '"name":"'.$re[$i].'"';
				$list.= ',"lat":"'.$lat.'"';
				$list.= ',"lon":"'.$lon.'"';
				$list.= '}';
				
			}
		}
		$list.= ']';
		
// 		$data['lat'] = $lat;
// 		$data['lon'] = $lon;
// 		$data['list'] = $list;
		echo $list;
// 		$this->load->view('test',$data );
	}
	
	public function create(){
		$b_time = microtime(true);
		$n = 0;
		while(1) {
			//user_id 1~1000000
			$id = rand(1, 1000000);
			//latitude 30.59773~30.726786
			$rand_latitude = rand(30597730, 30726786);
			$latitude = $rand_latitude / 1000000;
			//longitude 103.983192 ~104.16069
			$rand_longitude = rand(103983192, 104160690);
			$longitude = $rand_longitude / 1000000;
// 			$lbs = new lbs();
			$this->upinfo($id, $latitude, $longitude);
			$n++;
			$this->mylog($n);
			$e_time = microtime(true);
			if(($e_time - $b_time) >= 60) {
				exit;
			}
		}
	}
	
	function mylog($content) {
		file_put_contents('upinfo.log', $content . "\r\n", FILE_APPEND);
	}
	
	public function search(){
		$b_time = microtime(true);
		$n = 0;
		while(1) {
			//latitude 30.59773~30.726786
			$rand_latitude = rand(30597730, 30726786);
			$latitude = $rand_latitude / 1000000;
			//longitude 103.983192 ~104.16069
			$rand_longitude = rand(103983192, 104160690);
			$longitude = $rand_longitude / 1000000;
			$re = $this->serach($latitude,$longitude);
			$n++;
			$this->slog($n);
			$e_time = microtime(true);
			if(($e_time-$b_time) >= 60) {
				exit;
			}
		}
		
		
	}
	function slog($content) {
		file_put_contents('search.log', $content . "\r\n", FILE_APPEND);
	}
	
	/**
	 * 更新用户信息
	 * @param mixed $latitude 纬度
	 * @param mixed $longitude 经度
	 */
	public function upinfo($id, $latitude, $longitude) {
		// 原数据处理
		// 获取原Geohash
		$o_hashdata = $this->cache->hGet ( $id, 'geo' );
		if (! empty ( $o_hashdata )) {
			$o_index_key = substr ( $o_hashdata, 0, $this->index_len );// 原索引
			$this->cache->sRem( $o_index_key, $id );// 删除
		}
		// 新数据处理
		$this->cache->hSet ( $id, 'la', $latitude );// 纬度
		$this->cache->hSet ( $id, 'lo', $longitude );// 经度
		// Geohash
		$hashdata = $this->geohash->encode_geohash( $latitude, $longitude,$this->index_len );
// 		echo $hashdata.'</br>';
		$this->cache->hSet ( $id, 'geo', $hashdata );
		// 索引
		$index_key = substr ( $hashdata, 0, $this->index_len );
		// 存入
		$this->cache->sAdd( $index_key, $id );
		return true;
	}
	
	/**
	 * 获取周边
	 * @param mixed $latitude 纬度
	 * @param mixed $longitude 经度
	 */
	public function serach($latitude,$longitude) {
		//Geohash
		$hashdata = $this->geohash->encode_geohash($latitude,$longitude,$this->index_len);
// 		echo $hashdata;
		//索引
		$index_key = substr($hashdata, 0, $this->index_len);
		//取得
		$user_id_array = $this->cache->sMembers($index_key);
		return $user_id_array;
	}
}
