<?php
/**
 * 专家包团线路
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年7月16日18:00:01
 * @author		汪晓烽
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Line_package extends UB2_Controller{
	public function __construct() {
		parent::__construct();
		$this->load_model('admin/b2/line_package_model', 'line_package');
	}

	public function index(){
		$supplier = $this->line_package->get_supplier();
	//	$overcity = $this->line_package->get_destinations();
		$data = array(
			'suppliers'=>$supplier,
			//'destinations' => $overcity
			);
		$this->load_view('admin/b2/line_package_view', $data);
	}
	public function package_list(){
		$post_arr = array();
		$number = $this->input->post('pageSize', true);
       	$page = $this->input->post('pageNum', true);
        $number = empty($number) ? 15 : $number;
        $page = empty($page) ? 1 : $page;
        $kindname = trim($this ->input ->post('kindname' ,true));
        $destid = intval($this ->input ->post('destid'));
		$line_code=trim($this ->input ->post('line_code' ,true));
        $whereArr = array(
        		'l.producttype =' =>1,
        		'la.expert_id =' =>$this->expert_id,
        		'la.line_id >' =>0
        );
//         $post_arr['l.producttype']=1;
//         $post_arr['la.expert_id']=$this->expert_id;
		if($this->input->post('supplier_id')!='')
		{
       		$whereArr['l.supplier_id ='] = $this->input->post('supplier_id');
       	}
       	if($this->input->post('line_name')!='')
       	{
       		$whereArr['l.linename LIKE'] = '%'.$this->input->post('line_name').'%';
       	}
       	if(!empty($line_code)){
       		$whereArr['l.linecode ='] = $line_code;
       	}
       	
       	//目的地搜索
       	if($destid >0)
       	{
       		//$post_arr['FIND_IN_SET('.$destid.',l.overcity)>'] = 0;
       		$whereArr['find_in_set']['l.overcity'] = array($destid);
       	}
       	elseif (!empty($kindname))
       	{
       		$this ->load_model('dest/dest_base_model' ,'dest_base_model');
       		$where = array(
       				'kindname like' =>'%'.$kindname.'%'
       		);
       		$destData = $this ->dest_base_model ->getDestBaseAllData($where);
       		if (empty($destData))
       		{
       			$data=array(
       					"totalRecords" => 0,
       					"totalPages" =>  1,
       					"pageNum" => $page,
       					"pageSize" => $number,
       					"rows" => array()
       			);
       			echo json_encode($data);exit;
       		}
       		else 
       		{
       			$idsArr = array();
       			foreach($destData  as $v)
       			{
       				$idsArr[] = $v['id'];
       			}
       			$whereArr['find_in_set']['l.overcity'] = $idsArr;
       		}
       	}
       
		$package_list = $this->line_package->get_package_list($whereArr,$page, $number);
		
		$pagecount = $this->line_package->get_package_list($whereArr,0,$number);

		if (($total = $pagecount - $pagecount % $number) / $number == 0) {
        	$total = 1;
        } else {
            $total = ($pagecount - $pagecount % $number) / $number;
	        if ($pagecount % $number > 0) {
	            $total +=1;
	        }
        }
		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $package_list
            	);
		echo json_encode($data);
	}

}