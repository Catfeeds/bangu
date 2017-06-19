<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年11月20日16:10:50
 * @author		xml
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Grade extends UA_Controller {
	const pagesize = 10; //分页的页数

	public function __construct() {
		//error_reporting(0);
		parent::__construct ();
		
		$this->load_model ( 'admin/a/grade_model', 'grade_model' );
		
	}
    //管家列表
	public function expert_grade_list() {
		//主题游
		$data['pageData']=$this->grade_model->get_expert_data(array(),$this->getPage ());
		$this->load_view( 'admin/a/ui/grade/expert_grade_list',$data);
	}
	public function expertGradeData(){
		$expert_type=$this->input->post('expert_type',true);
		$param = $this->getParam(array('title','mobile'));
		$data = $this->grade_model->get_expert_data( $param , $this->getPage (),$expert_type);
	  	 //echo $this->db->last_query();
		echo  $data ;
	}
	//评分修改
	public  function edit_grade_list(){
		$id= intval($this->input->get('id',true));
		//管家级别
		$this ->load_model('expert_grade_model');
		$gradeData = $this ->expert_grade_model ->all(array() ,'grade asc');
		$data['expertGrade'] = array('0' =>'不限');
		foreach($gradeData as $val)
		{
			$data['expertGrade'][$val['grade']] = $val['title'];
		}
       		 $data['expertGradelist']=$gradeData;

		if($id>0){
			//管家信息
			$data['expert']=$this->grade_model->get_expert_row($id);
			$overcity=$data['expert']['expert_dest'];
			if(empty($overcity)){
				$overcity='';
			}
			//管家满意度的增值
			$data['affil']=$this->grade_model->get_grade_data('u_expert_affiliated',array('expert_id'=>$id));
			if(empty($data['affil']['sati_intervene'])){
				$data['affil']['sati_intervene']=0;
			}
			//管家售卖列表
			$data['pageData']=$this->grade_model->get_line_apply(array('expert_id'=>$id),$this->getPage (),$overcity);
		//	echo $this->db->last_query();
			$this->load_view ( 'admin/a/ui/grade/edit_grade_list',$data);
		}else{
			echo '<script>alert("不存在该管家!");window.history.go(-1);</script>';
		}
	}
	//管家售卖列表分页
	function line_apply(){
		$id= intval($this->input->post('status',true));
		$linecode=$this->input->post('linecode',true);
		$linename=$this->input->post('linename',true);
		$overcity=$this->input->post('overcity',true);
		if(empty($overcity)){
			$overcity='';
		}
		$param = $this->getParam(array('expert_id','linecode','linename'));
		//$pam=array('expert_id'=>$id);
		$data =$this->grade_model->get_line_apply($param,$this->getPage (),$overcity);
		//echo $this->db->last_query();
		echo  $data ;
	}

	//获取管家指标数据
	function get_expert_target(){
		$expert_id=intval($this->input->post('id',true));
		if($expert_id>0){
			$expert=$this->grade_model->get_expert_row($expert_id);
			$affil=$this->grade_model->get_grade_data('u_expert_affiliated',array('expert_id'=>$expert_id));
			if(!empty($expert)){
				//var_dump($expert[0]);
				$expert['satisfaction_rate']=$expert['satisfaction_rate']*100;
				
				if(!empty($affil['sati_intervene'])){
					$expert['sati_intervene']=$affil['sati_intervene']*100;
					$expert['all_intervene']=$affil['sati_intervene']*100+$expert['satisfaction_rate'];
				}else{
					$expert['sati_intervene']=0;
					$expert['all_intervene']=$expert['satisfaction_rate'];
				}
				echo  json_encode(array('status'=>1,'expert'=>$expert));
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'获取数据失败'));
			}
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'获取数据失败'));
		}
	}
	//保存管家指标数据
	function save_expert_target(){
		$id=intval($this->input->post('expert_id',true));
	//	$updataArr['satisfaction_rate']=$this->input->post('satisfaction_rate',true);
	//	$updataArr['satisfaction_rate']=$updataArr['satisfaction_rate']/100;
	    $dArr['sati_intervene'] =$this->input->post('sati_intervene',true);
	    $dArr['sati_intervene']=$dArr['sati_intervene']/100;
		$updataArr['people_count']=$this->input->post('people_count',true);
		$updataArr['order_amount']=$this->input->post('order_amount',true);
		$updataArr['total_score']=$this->input->post('total_score',true);
		
		if($id>0){
			$expert=$this->grade_model->get_expert_row($id);
			if(!empty($expert)){
				$all_intervene=$expert['satisfaction_rate']+ $dArr['sati_intervene'];
				if($all_intervene>1 || $all_intervene<0){
					echo  json_encode(array('status'=>-1,'msg'=>'年满意度的百分比大于100或小于0,操作失败'));exit;
				}
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));exit;
			}
			$re=$this->grade_model->update_expert_target($updataArr, $dArr['sati_intervene'],$id);
			if($re){
				echo  json_encode(array('status'=>1,'msg'=>'操作成功'));
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
			}
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
		}
	}
	//保存管家调整级别
	function save_expert_grade(){
		$expert_id=intval($this->input->post('up_expert_id',true));
		$grate=intval($this->input->post('expert_gradeDate',true));
		//管家级别
		$this ->load_model('expert_grade_model');
		$gradeData = $this ->expert_grade_model ->all(array() ,'grade asc');
		$data['expertGrade'] = array('0' =>'不限');
		foreach($gradeData as $val)
		{
			$expertGrade[$val['grade']] = $val['title'];
		}
		if(array_key_exists($grate ,$expertGrade)) {
			$expert_grade= $expertGrade[$grate];
		}else{
			$expert_grade='管家';
		}

		if($expert_id>0){
			$re=$this->grade_model->update(array('grade'=>$grate),array('id'=>$expert_id));
			if($re){
				echo  json_encode(array('status'=>1,'msg'=>'修改成功','expert_grade'=>$expert_grade));
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'修改失败'));
			}
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'修改失败'));
		}
	}
	//保存批量修改管家申请线路
	function save_expertData_line(){
		$grade=$this->input->post('grade',true);
		$expert_bookcount=$this->input->post('expert_bookcount',true);
		$expert_grade=$this->input->post('expert_grade',true);
		$expertid=$this->input->post('expertid');
		if($grade=='' && $expert_bookcount==''){
			echo  json_encode(array('status'=>-1,'msg'=>'请选择要修改的内容'));
			exit();
		}
		if(!empty($expert_grade)){
			$lineApply='';
			$lineid='';
			foreach ($expert_grade as $k=>$v){
				if(!empty($v)){
					$expertArr=explode('-', $v);
					$lineApply[]=$expertArr[0];
					$lineid[]=$expertArr[1];
				}
			}
			//保存批量修改的数据  $expert_bookcount:管家的销量 $expert_grade：管家修改的级别
			$re=$this->grade_model->save_expertline($lineApply,$lineid,$expert_bookcount,$grade,$expertid);
			if(!empty($expertid)){
				$expertData=$this->grade_model->all(array('id'=>$expertid));
				if(!empty($expertData)){
					$expertArr=$expertData[0];
				}
			}else{
				$expertArr='';
			}
			
			if($re){
				echo  json_encode(array('status'=>1,'msg'=>'操作成功','expert'=>$expertArr));
				exit();
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
				exit();
			}
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'请选择要修改的线路'));
			exit(); 
		}
	}
	
	//获取管家申请的线路
	function get_expert_line(){
		$this->load_model ( 'admin/a/line_model', 'line_model' );
		$id=intval($this->input->post('id',true));
		$expert_id=$this->input->post('expert_id',true);
	
		if($id>0){
			$line[0]=$this->grade_model->get_grade_data('u_expert_line_count',array('expert_id'=>$expert_id,'line_id'=>$id));
			if(!empty($line[0])){
				echo  json_encode(array('status'=>1,'line'=>$line[0]));
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'获取数据失败'));
			}
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'获取数据失败'));
		}
		
	}
	//保存管家申请的
	function save_expert_line(){
		$this->load_model ( 'admin/a/line_model', 'line_model' );
		$line_id=$this->input->post('line_id',true);
		$updataArr['peoplecount']=$this->input->post('bookcount',true);
		$expertid=$this->input->post('up_expert_id',true);
		$admin_id = $this->admin_id;// 发布人id
		if($line_id>0){
			$re=$this->grade_model->update_expert_line($updataArr,$line_id,$expertid,$admin_id);
			
			if($re){
				if(!empty($expertid)){
					$expertData=$this->grade_model->all(array('id'=>$expertid));
					if(!empty($expertData)){
						$expertArr=$expertData[0];
					}
				}else{
					$expertArr='';
				}
				
				echo  json_encode(array('status'=>1,'msg'=>'操作成功','expert'=>$expertArr));
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
			}
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
		}
	}
	//保存评论
	function save_comment(){
		$insert_data = array();
		$line_id = $this->input->post('c_line_id');
		$expert_id = $this->input->post('c_expert_id');
		$pic_url = $this->input->post('img');
		if(!empty($pic_url)){
			$pic_url = implode(',', $pic_url);
		}
		$content = $this->input->post('content');
		$level = $this->input->post('level');
		$expert_comment = $this->input->post('expert_comment');
		$score0 = $this->input->post('score0');
		$score1 = $this->input->post('score1');
		$score2 = $this->input->post('score2');
		$score3 = $this->input->post('score3');
		$score4 = $this->input->post('score4');
		$score5 = $this->input->post('score5');
		
		$insert_data['expert_id'] = $expert_id;
		$insert_data['memberid'] = 0;
		$insert_data['line_id'] = $line_id;
		$insert_data['ADDTIME'] = date('Y-m-d H:i:s');
		$insert_data['content'] = $content;
		$insert_data['pictures'] = $pic_url;
		$insert_data['score1'] = $score0;
		$insert_data['score2'] = $score1;
		$insert_data['score3'] = $score2;
		$insert_data['score4'] = $score3;
		$insert_data['score5'] = $score4;
		$insert_data['score6'] = $score5;
		$insert_data['isanonymous'] = $this->input->post('isanonymous');
		$insert_data['avgscore1']=($score0+$score1+$score2+$score3)/4;
		$insert_data['avgscore2']=($score4+$score5)/2;
		//评论送积分
		$integral=0;
		if($insert_data['avgscore1']>0){
			$integral=100;
		}
		if(!empty($content)){
			$integral=$integral+500;
			$content_len=mb_strlen($content, 'UTF-8');
			if($content_len>30){
				$integral=$integral+500;
			}
		}
		if(!empty($pic_url)){
			$integral=$integral+500;
		}
		//$insert_data['LEVEL'] = $level;
		$insert_data['expert_content'] = $expert_comment;
		$insert_data['channel'] = 0;
		$insert_data['isshow'] = 1;
		if(empty($pic_url)){
			$insert_data['haspic'] = 0;
		}else{
			$insert_data['haspic'] = 1;
		}

		//获取线路的始发地
		$this->load_model ( 'admin/a/line_model', 'line_model' );
		$line= $this->line_model->all(array('id'=>$line_id));
		$insert_data['starcityid'] = $line[0]['startcity'];
		//查询评论
		$this->load_model ( 'admin/a/comment_model', 'comment_model' );
		$re=$this->comment_model->insert($insert_data);
		if($re){
			echo  json_encode(array('status'=>1,'msg'=>'评论成功'));
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'评论失败'));
		}
		
	}
}

