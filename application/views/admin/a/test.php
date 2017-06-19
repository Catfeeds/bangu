<?php
/**
 * **
 * 深圳海外国际旅行社
 * 艾瑞可
 * 2015-3-18
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
include_once './application/controllers/msg/t33_msg.php';
class Test extends UB1_Controller {
	function __construct() {
		parent::__construct ();

		$this->load->database ();
		$this->load->helper ( 'form' );
		$this->load->helper ( array(
			'form', 
			'url' 
		) );
		$this->load->helper ( 'url' );
		$this->load->model ( 'admin/b1/user_shop_model' );
		header ( "content-type:text/html;charset=utf-8" );
				
	}
	function index(){
		$this->load->view ( 'admin/b1/test' );
	}
	//转移目的地数据
/* 	function update_line_dest(){
		$lstr=array();
		$this->db->trans_start();
	
		//这个月份的数据已更新 
		$starttime="2017-03-09";
		$endtime="2017-03-14";
		$L_query = $this->db->query('select id,overcity2,overcity,linecode from u_line where  addtime>"'.$starttime.'" and addtime<="'.$endtime.'" ');
		$line = $L_query->result_array();
		
		foreach ($line as $k=>$v){
			$overcityArr=explode(',', $v['overcity2']);
			$dest='';
			$pdest='';
			$linestr='';
				
			$pdestArr='';
			foreach ($overcityArr as $key=>$val){
				//目的地的映射表
				$destArr= $this ->user_shop_model ->select_data('u_dest_ys',array('d_baseid'=>$val));
				$Tydest=count($destArr); 
				if($Tydest!=0){  //一对一匹配数据
					if(empty($dest)){
						$dest=$destArr[0]['d_id'];
					}else{
						$dest=$dest.','.$destArr[0]['d_id'];
					}
	
					//目的地的父级
					$destA= $this ->user_shop_model ->select_rowData('u_dest_base',array('id'=>$destArr[0]['d_id'],'isopen'=>1));
					if(!empty($destA['list'])){
						if(empty($pdest)){
							$pdest=$destA['list'].','.$destArr[0]['d_id'];
						}else{
							$pdest=$pdest.','.$destA['list'].','.$destArr[0]['d_id'];
						}
					}
					if(!empty($pdest)){
						$pdestArr=explode(",",$pdest);
						$pdestArr=array_unique($pdestArr);
						$pdestArrData=implode(',', $pdestArr);
					}
				}
			}
				
			//线路目的地表
			if(!empty($pdestArr)){
				$this ->user_shop_model ->del_data('u_line_dest',array('line_id'=>$v['id']));
				foreach ($pdestArr as $a=>$b){
					if(!empty($b)){
						$pdestdata=array(
								'line_id'=>$v['id'],
								'dest_id'=>$b,
						);
						$this ->user_shop_model ->insert_data('u_line_dest',$pdestdata);
					}
						
				}
			}
				
			//修改线路表的目的地
			if(!empty($dest)){
				$this ->user_shop_model ->update_rowdata('u_line',array('overcity2'=>$dest),array('id'=>$v['id']));
			}
			if(!empty($pdestArrData)){
				$this ->user_shop_model ->update_rowdata('u_line',array('overcity'=>$pdestArrData),array('id'=>$v['id']));
				unset($pdestArrData);
			}
		}
	
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			echo false;
		}else{
			echo true;
		}
	
	} */
	
/* 	function L_line_dest(){

		//这个月份的数据已更新 
		$starttime="2017-03-09";
		$endtime="2017-03-14";
		$L_query = $this->db->query('select id,overcity2,overcity,linecode from u_line where  addtime>"'.$starttime.'" and addtime<="'.$endtime.'" ');
		$line = $L_query->result_array();
		echo '线路不匹配目的地,添加时间'.$starttime.'至'.$endtime."<br><br>";
		foreach ($line as $k=>$v){
			$overcityArr=explode(',', $v['overcity2']);
			$dest='';
			$pdest='';
			$linestr='';
		
			$pdestArr='';
			foreach ($overcityArr as $key=>$val){
				if(!empty($val)){
					//目的地的映射表
					$destArr= $this ->user_shop_model ->select_data('u_dest_ys',array('d_baseid'=>$val));
					$Tydest=count($destArr);	
							
					if($Tydest=='0'){ //不匹配的数据	 
						
						$dt=$this ->user_shop_model ->select_rowData('u_dest_base',array('id'=>$val));
						if(empty($dt['kindname'])){
							$dt['kindname']='';
						}
						
						if(empty($linestr)){
							$linestr='产品编号:('.$v['linecode'].')的产品,对应的';
						}
						
						$linestr=$linestr.'目的地编号:'.$val.'('.$dt['kindname'].')'.' , ';
					} 
				}
			}
			$linestr=$linestr.'<br>';
			echo  $linestr;
			unset($linestr);
		}	
	} */
	
	//产品匹配目的地
	function up_line_dest(){
		$this->db->trans_start();
		//这个月份的数据已更新 
		$startdate=$this->input->post('startdate',true);
		$startdate=trim($startdate);
		$endtdate=$this->input->post('endtdate',true);
		$endtdate=trim($endtdate);
		if(empty($startdate)){
			echo '日期不能为空';
		}
		$L_query = $this->db->query('select l.id,l.overcity2,l.overcity,l.linecode from u_line  as l LEFT JOIN u_line_affiliated as la on l.id=la.line_id  where l.line_kind=1 and l.addtime>"'.$startdate.'" and l.addtime<="'.$endtdate.'" ');
		$line = $L_query->result_array();
         
		foreach ($line as $k=>$v){
			
			$dest='';
			$pdest='';
			$linestr='';
			$pdestArr='';
			$overcityArr=explode(',', $v['overcity2']);
			foreach ($overcityArr as $key=>$val){	
				if(!empty($val)){
				
					$destBase= $this ->user_shop_model ->select_rowData('u_dest_base',array('id'=>$val));
					if(!empty($destBase)){
						 //新的目的地匹配
						$newdest=$this ->user_shop_model ->select_data('u_dest_base',array('kindname'=>$destBase['kindname']));
				
						if(!empty($newdest[0]['id'])){  //一对一匹配
							
							if(empty($dest)){
								$dest=$newdest[0]['id'];
							}else{
								$dest=$dest.','.$newdest[0]['id'];
							}
                            
							//目的地的父级
							if(!empty($newdest[0]['list'])){
								if(empty($pdest)){
									$pdest=$newdest[0]['list'].$newdest[0]['id'];
								}else{
									$pdest=$pdest.','.$newdest[0]['list'].$newdest[0]['id'];
								}
							}
						   		
							
						}else{
							
							if(empty($dest)){
								$dest=$destBase['id'];
							}else{
								$dest=$dest.','.$destBase['id'];
							}
						}
					}else{ 
					
						//查看新的目的地是否存在
						$cdest=$this ->user_shop_model ->select_rowData('u_dest_base',array('id'=>$val));

						if(!empty($cdest['list'])){
							if(empty($pdest)){
								$pdest=$cdest['list'].$val;
							}else{
								$pdest=$pdest.','.$cdest['list'].$val;
							}
						}
						
						if(empty($dest)){
							$dest=$val;
						}else{
							$dest=$dest.','.$val;
						}
					}
					
					//相同的目的地合拼
					if(!empty($pdest)){
						$pdestArr=explode(",",$pdest);
						$pdestArr=array_unique($pdestArr);
						$pdestArrData=implode(',', $pdestArr);
					}	
					
				}
				
			}
	
			//线路目的地表
 			if(!empty($pdestArr)){
				$this ->user_shop_model ->del_data('u_line_dest',array('line_id'=>$v['id']));
				foreach ($pdestArr as $a=>$b){
					if(!empty($b)){
						$pdestdata=array(
								'line_id'=>$v['id'],
								'dest_id'=>$b,
						);
						$this ->user_shop_model ->insert_data('u_line_dest',$pdestdata);
					}
				}
			}
						
			//修改线路表的目的地
			if(!empty($dest)){
				$this ->user_shop_model ->update_rowdata('u_line',array('overcity2'=>$dest),array('id'=>$v['id']));
				
				//是否有u_line_affiliated
				$affil=$this ->user_shop_model ->select_data('u_line_affiliated',array('line_id'=>$v['id']));
				if(!empty($affil)){
					$this ->user_shop_model ->update_rowdata('u_line_affiliated',array('modify_time'=>1),array('line_id'=>$v['id']));
				}else{
					$this ->user_shop_model ->insert_data('u_line_affiliated',array('line_id'=>$v['id'],'modify_time'=>1));
				}
				
			}
			if(!empty($pdestArrData)){
				$this ->user_shop_model ->update_rowdata('u_line',array('overcity'=>$pdestArrData),array('id'=>$v['id']));
				unset($pdestArrData);
			} 
			
		}
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			echo false;
		}else{
		    echo true;
		}
		
	}
	
	//查看没有匹配到的数据
	function sel_line_dest(){
		$this->db->trans_start();
		$lineArr='';
		//这个月份的数据已更新
		$startdate=$this->input->post('startdate',true);
		$startdate=trim($startdate);
		$endtdate=$this->input->post('endtdate',true);
		$endtdate=trim($endtdate);
	
		$L_query = $this->db->query('select l.id,l.overcity2,l.overcity,l.linecode from u_line  as l LEFT JOIN u_line_affiliated as la on l.id=la.line_id  where  l.line_kind=1 and l.addtime>"'.$startdate.'" and l.addtime<="'.$endtdate.'" ');
		$line = $L_query->result_array();
		echo '线路不匹配目的地,添加时间'.$startdate.'至'.$endtdate."<br>";
		foreach ($line as $k=>$v){
			$dest='';
			$pdest='';
			$pdestArr='';
			$overcityArr=explode(',', $v['overcity2']);
			foreach ($overcityArr as $key=>$val){
				if(!empty($val)){
					$destBase= $this ->user_shop_model ->select_rowData('u_dest_base',array('id'=>$val));
					if(!empty($destBase)){
						//新的目的地匹配
						$newdest=$this ->user_shop_model ->select_data('u_dest_base',array('kindname'=>$destBase['kindname']));
	
						if(empty($newdest[0]['id'])){  //一对一匹配
				
							$lineArr[]=array('dest_id'=>$val,'kindname'=>$destBase['kindname']);
						}
					}else{  //目的地ID不存在
	
						//查看新的目的地是否存在
						$cdest=$this ->user_shop_model ->select_rowData('u_dest_base',array('id'=>$val));
						if(empty($cdest)){
	
							$lineArr[]=array('dest_id'=>$val,'kindname'=>'');
						}
					}
				}
			}
		}
		if(!empty($lineArr)){
			//$lineArr = array_unique($lineArr);
			$lineArr=$this->array_unique_fb($lineArr);
		}
	
		echo "<pre>";print_r($lineArr);echo "<pre>"; 

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			echo false;
		}else{
			
		}
	}
	//二位数组去重
	function array_unique_fb($array2D)
	{
		foreach ($array2D as $v)
		{
			$v = join(",",$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
			$temp[] = $v;
		}
		$temp = array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
		foreach ($temp as $k => $v)
		{
			$temp[$k] = explode(",",$v); //再将拆开的数组重新组装
		}
		return $temp;
	}
/* 	function sel_line_dest(){
		$this->db->trans_start();
		//这个月份的数据已更新
		$startdate=$this->input->post('startdate',true);
		$startdate=trim($startdate);
		$endtdate=$this->input->post('endtdate',true);
		$endtdate=trim($endtdate);

		$L_query = $this->db->query('select l.id,l.overcity2,l.overcity,l.linecode from u_line  as l LEFT JOIN u_line_affiliated as la on l.id=la.line_id  where  l.line_kind=1 and l.addtime>"'.$startdate.'" and l.addtime<="'.$endtdate.'" ');
		$line = $L_query->result_array();
		echo '线路不匹配目的地,添加时间'.$startdate.'至'.$endtdate."<br>";
		$t_count=0;
		foreach ($line as $k=>$v){
			$dest='';
			$pdest='';
			$linestr='';
			$pdestArr='';
			$overcityArr=explode(',', $v['overcity2']);
			foreach ($overcityArr as $key=>$val){
				if(!empty($val)){
					$destBase= $this ->user_shop_model ->select_rowData('u_dest_base',array('id'=>$val));
					if(!empty($destBase)){
						//新的目的地匹配
						$newdest=$this ->user_shop_model ->select_data('u_dest_base',array('kindname'=>$destBase['kindname']));
		
						if(empty($newdest[0]['id'])){  //一对一匹配
											
							if(empty($linestr)){
								$linestr='产品编号:('.$v['linecode'].')的产品,对应的';
							}	
							$linestr=$linestr.'目的地编号:'.$val.'('.$destBase['kindname'].')'.' , ';
						}
					}else{  //目的地ID不存在
						
						//查看新的目的地是否存在
						$cdest=$this ->user_shop_model ->select_rowData('u_dest_base',array('id'=>$val));
		               	if(empty($cdest)){

		               		if(empty($linestr)){
		               			$linestr='产品编号:('.$v['linecode'].')的产品,对应的';
		               		}
		               		$linestr=$linestr.'目的地编号:'.$val.'()'.' , ';
		               	} 	
					}			
				}			
			}
			if(!empty($linestr)){
				$t_count=$t_count+1;
				$linestr=$linestr.'<br>';
			}
			echo  $linestr;
		}
		echo '影响线路总行数'.$t_count;
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			echo false;
		}else{
			//echo true;
		}
	} */
		
/* 	function dest_line_num(){
		$query = $this->db->query('select * from u_dest_line_num ');
		$dest = $query->result_array();
		foreach ($dest as $k=>$v){
			$linestr='';
			if(!empty($v['dest_id'])){
				$destBase= $this ->user_shop_model ->select_rowData('u_dest_base',array('id'=>$v['dest_id']));
				if(!empty($destBase)){
					$newdest=$this ->user_shop_model ->select_data('u_dest_base',array('kindname'=>$destBase['kindname']));
					if(!empty($newdest[0]['id'])){  //一对一匹配
						$this ->user_shop_model ->update_rowdata('u_dest_line_num',array('dest_id'=>$newdest[0]['id']),array('dest_id'=>$v['dest_id']));
					}else{
						if(empty($linestr)){
								$linestr='编号:('.$v['dest_id'].'),对应的';
						}
						$linestr=$linestr.'目的地编号:'.$v['dest_id'].'('.$destBase['kindname'].')'.' , ';
					}
				}else{
					$hot_dest= $this ->user_shop_model ->select_rowData('u_dest_base',array('id'=>$v['dest_id']));
					if(empty($hot_dest)){
						if(empty($linestr)){
							$linestr='编号:('.$v['dest_id'].'),对应的';
						}
						$linestr=$linestr.'目的地编号:'.$v['dest_id'].'()';
					}
				}
			}
			if(!empty($linestr)){
				$linestr=$linestr.'<br>';
			}
			echo  $linestr;
		}
	} */
	
	//替换视频的目的地
	function replace_live_video(){
		$this->db->trans_start();
		$str="";
		$sql="";
		$sql=$sql."SELECT a.video AS video_url,a.name AS video_name, FROM_UNIXTIME(a.addtime, '%Y-%m-%d %h:%i') AS addtime,";
		$sql=$sql."	CASE WHEN a.type = 1 THEN 'type' ELSE '短视频' END AS 'type',b.kindName,a.dest_id,a.id as video_id ";
		$sql=$sql."FROM bangu_live.live_video a LEFT JOIN bangu.u_destinations b ON a.dest_id = b.id WHERE b.kindname is NOT NUll ";
		$rows = $this->db->query($sql)->result_array();

        if(!empty($rows)){
			foreach ($rows as $k=>$v){
				if(!empty($v["kindname"])){
					$newdest=$this ->user_shop_model ->select_data("u_dest_base",array("kindname"=>$rows["kindname"]));
					if(!empty($newdest[0]["id"])){
						$this ->user_shop_model ->update_rowdata("bangu_live.live_video",array("dest_id"=>$newdest[0]["id"]),array("id"=>$v["video_id"]));
					}else{
						$str="video_id=".$v["video_id"]."匹配不上目的地".$v["video_id"]."<br>";
					}
				}
			}
		}
		echo $str;
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			echo false;
		}else{
			echo true;
		}
	}
	
}