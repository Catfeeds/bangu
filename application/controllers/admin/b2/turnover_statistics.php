<?php
/**
 * 专家答题
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年7月28日15:05:11
 * @author		汪晓烽
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Turnover_statistics extends UB2_Controller {

	public function __construct() {
		parent::__construct();

		$this->load_model('admin/b2/turnover_statistics_model', 'turnover');
	}

	function index() {
		$this->load_view('admin/b2/turnover_statistics_view');
	}

	function ajax_get_turnover(){
		$whereArr = array();
/*		$linecode = trim($this ->input ->post('line_code' ,true)); //产品编号
		$linename = trim($this ->input ->post('linename' ,true)); //产品名称
		$company_name = trim($this ->input ->post('supplier' ,true)); //供应商名称
		$supplier_id = intval($this ->input ->post('supplier_id'));
		$kindname = trim($this ->input ->post('kindname' ,true));
		$overcity = intval($this ->input ->post('destid'));
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));


		if (!empty($linecode)){
			$whereArr['l.linecode ='] = $linecode;
		}

		if (!empty($linename)){
			$whereArr['l.linename like'] = '%'.$linename.'%';
		}
		//供应商
		if (!empty($supplier_id)){
			$whereArr['l.supplier_id ='] = $supplier_id;
		}elseif (!empty($company_name)){
			$whereArr['s.company_name like'] = '%'.$company_name.'%';
		}
		//目的地
		if (!empty($overcity)){
			$specialSql = ' find_in_set('.$overcity.' ,l.overcity)';
			$whereArr['overcity'] = $specialSql;
		}elseif (!empty($kindname)){
			$this ->load_model('destinations_model' ,'dest_model');
			$destData = $this ->dest_model ->all(array('kindname like' =>'%'.$kindname.'%'));
			if (empty($destData)) {
				echo json_encode($this ->defaultArr);exit;
			}else{
				$specialSql = ' (';
				foreach($destData as $v){
					$specialSql .= ' find_in_set('.$v['id'].' ,l.overcity) or';
				}
				$specialSql = rtrim($specialSql ,'or').') ';
			}
			$whereArr['overcity'] = $specialSql;
		}

		if (!empty($starttime)){
			$whereArr['l.online_time >='] = $starttime;
		}

		if (!empty($endtime)){
			$whereArr['l.online_time <='] = $endtime.' 23:59:59';
		}*/


		$number = $this->input->post('pageSize', true);
       	$page = $this->input->post('pageNum', true);
        	$number = empty($number) ? 10 : $number;
        	$page = empty($page) ? 1 : $page;

	$turnover_list = $this->turnover->get_all_turnover($whereArr,$page,$number,$this->session->userdata('depart_id'),$this->expert_id);
		$pagecount = $this->turnover->get_all_turnover($whereArr,0,$number,$this->session->userdata('depart_id'),$this->expert_id);
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
	               	"rows" => $turnover_list
            		);
		echo json_encode($data);
	}
}