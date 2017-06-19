<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016-01-05
 * @author		jiakairong
 * @method 		地区管理
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_dest extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('admin/a/line_dest_model','line_dest_model');
		$this->load_model('dest/dest_base_model','dest_base_model');
	}

	function index()
	{
		//echo 123;
		$this->load_view ( 'admin/a/basics/line_dest');
	}
	
	//线路目的地
	function get_line_dest(){
		$whereArr = array();
		$linecode=trim($this ->input ->post('linecode' ,true));
		$linename=trim($this ->input ->post('linename' ,true));
		$startdate=trim($this ->input ->post('startdate' ,true));
		$enddate=trim($this ->input ->post('enddate' ,true));
		
		if(!empty($linecode)){
			$whereArr['l.linecode=']=$linecode;
		}
		if (!empty($linename)){
			$whereArr['l.linename like'] = '%'.$linename.'%';
		}
		if(!empty($startdate)){
			$whereArr['l.addtime >='] = $startdate;
		}
		if(!empty($enddate)){
			$whereArr['l.addtime <='] =  $enddate;
		}
		
		$whereArr['l.line_kind=']=1;
		$dataArr['data'] = $this ->line_dest_model ->getlineDestData($whereArr);
		$dataArr['count'] = $this ->line_dest_model ->getDestNum($whereArr);
		
		//线路目的地
		if(!empty($dataArr['data'])){
			foreach ($dataArr['data'] as $k=>$v){
				$linedest='';
				if(!empty($v['overcity2'])){
					$destArr=explode(",",$v['overcity2']);
					foreach ($destArr as $key=>$val){
						if(!empty($val)){
							$dest=$this->dest_base_model->row(array('id'=>$val));
							if(!empty($dest['kindname'])){
								if(empty($linedest)){
									$linedest=$dest['kindname'];
								}else{
									$linedest=$linedest.','.$dest['kindname'];
								}
								
							}
						}
					}
				}	
				$dataArr['data'][$k]['linedest']=$linedest;
			}
		}
		
		echo json_encode($dataArr);
	}
	//获取线路目的地
	function get_destData(){
		$data=array();
		$line_id=$this->input->get('line_id',true);
		if(!empty($line_id)){

			$whereArr['l.id=']=$line_id;
			$line= $this ->line_dest_model ->getlineDestData($whereArr);
			//目的地
			if($line[0]['overcity2']){
				$destArr=explode(",",$line[0]['overcity2']);
				foreach ($destArr as $k=>$v){
					if(!empty($v)){
						$dataArr=$this->dest_base_model->row(array('id'=>$v));
						if(!empty($dataArr)){
							$data['dest'][]=$dataArr;
						}else{
							$data['dest'][]=array('id'=>$v,'kindname'=>'');
						}
						
					}
				}
			}
		
			//出发地
			$data['startcity']=$this->line_dest_model->select_startplace(array('ls.line_id'=>$line_id));
			
			$data['line']=$line[0];
		}else{
			echo '<script>alert("获取数据失败");</script>';
		}
		
		$this->load_view ( 'admin/a/basics/get_linedest_data',$data);
	}
	//替换目的地
	function update_line_dest(){
		$line_id=$this->input->post('line_id',true);
		$overcity=$this->input->post('overcity',true);
		if(!empty($line_id)){
			if(!empty($overcity)){
				$re=$this->line_dest_model->update_lineDest($line_id,$overcity);
				if($re){
					echo json_encode(array('status'=>1,'msg'=>'修改成功'));
				}else{
					echo json_encode(array('status'=>-1,'msg'=>'修改失败'));
				}
			}else{
				echo json_encode(array('status'=>-1,'msg'=>'请选择目的地'));
			}
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'获取数据失败'));
		}
	}
}
