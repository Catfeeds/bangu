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

class Activity extends UA_Controller {
	const pagesize = 10; //分页的页数

	public function __construct() {
		//error_reporting(0);
		parent::__construct ();
		$this->load_model ( 'admin/a/activity_model', 'activity_model' );
	}

	/**
	 * 活动主表列表
	 * @author xml
	 */
	public function act_activity() {
		$param['adminid']=$this->session->userdata('a_user_id');
		$data['pageData']=$this->activity_model->get_act_activity($param,$this->getPage ());
		$this->load_view ( 'admin/a/ui/activity/act_activity',$data);	
	}
	public function actData(){
		$param['adminid']=$this->session->userdata('a_user_id');
		if(!empty($_POST['name'])){
			$param['name']=$_POST['name'];
		}
		$data = $this->activity_model->get_act_activity( $param , $this->getPage ());
		echo  $data ;
	}
	
	//添加活动主表
	public function  add_activity(){
		$insert['name']=$this->input->post('name');
		$insert['starttime']=$this->input->post('starttime');
		$insert['endtime']=$this->input->post('endtime');
		$description=$this->input->post('description');
		$qian=array(" ","　","\t","\n","\r");
		$hou=array("","","","","");
		$insert['description']=str_replace($qian,$hou,$description);
		$insert['showorder']=$this->input->post('showorder');
		$insert['adminid'] = $this->session->userdata('a_user_id');
		$insert['addtime']=date('Y-m-d H:i:s');
		$city['startcityid']=$this->input->post('startcityId');
		$act_id=$this->input->post('act_id');
		if($act_id>0){ //修改活动
			$res=$this->activity_model->update_activity($insert,$act_id);
			if($res){
				echo json_encode(array('status'=>1,'msg'=>'修改成功'));
			}else{
				echo json_encode(array('status'=>-1,'msg'=>'修改失败'));
			}	
		}else{
			//添加活动
			$re=$this->activity_model->save_activity($insert,$city);
			if($re){
				echo json_encode(array('status'=>1,'msg'=>'添加成功'));
			}else{
				echo json_encode(array('status'=>-1,'msg'=>'添加失败'));
			}
		}
	
	}
	//活动的详情页面
	function activity_detail(){
		$actid=$this->input->post('actid');
		$data=array();
		if($actid>0){
			//活动信息
			$data['activity']=$this->activity_model->activity_data($actid);
			//活动的城市
			$data['activity_city']=$this->activity_model->activity_city($actid);
			echo json_encode(array('satus'=>1,'msg'=>'获取数据成功','data'=>$data));
		}else{
			echo json_encode(array('satus'=>-1,'msg'=>'获取数据失败','data'=>$data));
		}
	}
	//删除活动城市  没有用到
/* 	function del_city_activity(){
		$actid=$this->input->post('actid');
		$cityid=$this->input->post('cityid');
		if($actid>0 && $cityid>0){
			
		}
	} */
	
	/**活动城市列表**/
	function edit_activity(){
		$id=$this->input->get('id');
		$data['tyle']=$this->input->get('tyle');
		if($id>0){
			$data['activity']=$this->activity_model->all(array('id'=>$id));
		//	var_dump($data['activity']);
			$param['adminid']=$this->session->userdata('a_user_id');
			//活动城市
			$data['pageData']=$this->activity_model->get_act_city($param,'',$this->getPage ());
			//活动的分类
			$data['pageData1']=$this->activity_model->get_act_tab($param,$this->getPage ());
			
			$this->load_view ( 'admin/a/ui/activity/edit_activity',$data);
		}
	}
	/**活动城市列表分页**/
	function act_cityData(){
		$param = $this->getParam(array('actid'));
		$param['adminid']=$this->session->userdata('a_user_id');
		$city['id']=$this->input->post('act_startcityid');
		$city['cityname']=$this->input->post('cityname');

		$data=$this->activity_model->get_act_city($param,$city,$this->getPage ());
		//echo $this->db->last_query();
		echo  $data ;
	}
	/**活动的分类分页**/
	function act_tabData(){
		$id=$this->input->get('id');
		$param = $this->getParam(array('actid','name'));
		$param['adminid']=$this->session->userdata('a_user_id');
		$data=$this->activity_model->get_act_tab($param,$this->getPage ());
		//echo $this->db->last_query();
		echo  $data ;
	}
	/**活动的线路**/
	function act_line(){
		//$actid=$this->input->get('actid');
		$param = $this->getParam(array('actid','name','act_line'));
		$data=$this->activity_model->get_act_line($param,$this->getPage ());
		//echo $this->db->last_query();
		echo  $data ;
	}
	//添加活动城市
	function add_ActCity(){
		$insert['act_id']=$this->input->post('act_id');
	 	$insert['startcityid']=$this->input->post('startcityId');	
	 	$insert['isopen']=$this->input->post('isopen');
	 	$insert['showorder']=$this->input->post('showorder');
	 	$pic=$this->input->post('pic');
	 	if(empty($pic)){
	 		echo json_encode(array('status'=>-1,'msg'=>'图片不能为空'));
	 		exit;
	 	}
	 	
	 	$insert['pic']=implode(';', $pic);
	 	
	 	$city_id=$this->input->post('city_id');
	 	if(empty($insert['startcityid'])){
	 		echo json_encode(array('status'=>-1,'msg'=>'该选择城市'));
	 		exit;
	 	}

	    
	 	if($city_id>0){ //编辑活动城市表
	 		//array('startcityid'=>$insert['startcityid'],'act_id'=>$insert['act_id'])
	 		$cityWhere='id !='.$city_id.' and startcityid='.$insert['startcityid'].' and act_id='.$insert['act_id'];
	 		
	 		$iscity=$this->activity_model->get_rowData('act_activity_city',$cityWhere);
	 		if(!empty($iscity)){
	 			echo json_encode(array('status'=>-1,'msg'=>'该城市已经存在'));
	 			exit;
	 		}
	 		$res=$this->activity_model->update_table($city_id,$insert,'act_activity_city');
	 		
	 		if($res){
	 			echo json_encode(array('status'=>1,'msg'=>'编辑成功'));
	 		}else{
	 			echo json_encode(array('status'=>-1,'msg'=>'编辑失败'));
	 		}
	 	}else{	   //添加活动城市表
	 		
	 		//判断该城市是否添加
	 		$recity=$this->activity_model->get_rowData('act_activity_city',array('startcityid'=>$insert['startcityid'],'act_id'=>$insert['act_id']));
	 		
	 		if(!empty($recity)){
	 			echo json_encode(array('status'=>-1,'msg'=>'该城市已经添加'));
	 			exit;
	 		}
	 		$re=$this->activity_model->save_Actdata('act_activity_city',$insert);
	 		if($re){
	 			echo json_encode(array('status'=>1,'msg'=>'添加成功'));
	 		}else{
	 			echo json_encode(array('status'=>-1,'msg'=>'添加失败'));
	 		}
	 	}
	}
	//活动城市的信息
	function ActCity_detail(){
		$cityid=$this->input->post('cityid');
	
		$city=array();
		if($cityid>0){
			$city=$this->activity_model->get_ActCity(array('acy.id'=>$cityid));
			echo json_encode(array('status'=>1,'msg'=>'获取数据成功','city'=>$city));
		}else{
			echo json_encode(array('status'=>11,'msg'=>'获取数据失败','city'=>$city));
		}
	}
	//获取添加的活动城市
	function get_actTabCity(){
		$actid=$this->input->post('actid');
		$city=array();
		if($actid>0){
			$city=$this->activity_model->get_ActCity(array('act_id'=>$actid));
			echo json_encode(array('status'=>1,'msg'=>'获取数据成功','city'=>$city));
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'获取数据失败','city'=>$city));
		}
	}
	//活动城市联动的活动分类
	function get_actTabName(){
		$startcityid=$this->input->post('startcityid');
		$tabname=array();
		if($startcityid>0){
			$tabname=$this->activity_model->get_ActName(array('aac_id'=>$startcityid));
			echo json_encode(array('status'=>1,'msg'=>'获取数据成功','tabname'=>$tabname));
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'获取数据失败','tabname'=>$tabname));
		}
	}
	//添加活动的分类
	function add_ActTab(){
	    $act_tab_id=$this->input->post('act_tab_id');
		$insert['aac_id']=$this->input->post('sel_startcity');
		$insert['name']=$this->input->post('name');
		$insert['showorder']=$this->input->post('showorder');
		$description=$this->input->post('description');
		
		$qian=array(" ","　","\t","\n","\r");
		$hou=array("","","","","");
		$insert['description']=str_replace($qian,$hou,$description);
		
		$insert['description']=trim($description);
		if(empty($insert['aac_id'])){
			echo json_encode(array('status'=>-1,'msg'=>'请选择活动城市'));
			exit();
		}
		if(empty($insert['name'])){
			echo json_encode(array('status'=>-1,'msg'=>'请填写活动分类名称'));
			exit();
		}
		if($act_tab_id>0){ //修改
			
			$res=$this->activity_model->update_table($act_tab_id,$insert,'act_tab');
	 		if($res){
	 			echo json_encode(array('status'=>1,'msg'=>'编辑成功'));
	 		}else{
	 			echo json_encode(array('status'=>-1,'msg'=>'编辑失败'));
	 		}
			
		}else{  //添加
			$re=$this->activity_model->save_Actdata('act_tab',$insert);
			if($re>0){	
				echo json_encode(array('status'=>1,'msg'=>'添加成功'));
			}else{
				echo json_encode(array('status'=>-1,'msg'=>'添加失败'));
			} 
		}
	}
	//活动分类的某条信息
	function ActTab_detail(){
		$tabid=$this->input->post('tabid');
		$actid=$this->input->post('actid');
		$tab=array();
		$city=array();
		if($tabid>0){
			//活动分类
			$tab=$this->activity_model->get_rowData('act_tab',array('id'=>$tabid));
		    //活动城市
			$city=$this->activity_model->get_ActCity(array('act_id'=>$actid));
			echo json_encode(array('status'=>1,'msg'=>'获取数据成功','tab'=>$tab,'city'=>$city));
		}else{
			echo json_encode(array('status'=>1,'msg'=>'获取数据成功','tab'=>$tab,'city'=>$city));
		}
	}
	//添加活动线路
	function add_ActLinetab(){ 
		$insert['tab_id']=$this->input->post('sel_act_tab');
		$insert['showorder']=$this->input->post('showorder');
		$insert['line_id']=$this->input->post('line_id');
		$insert['startcityid']=$this->input->post('sel_act_city');
		if(empty($insert['startcityid'])){
			echo json_encode(array('status'=>-1,'msg'=>'请选择活动城市'));
			exit();
		}
		if(empty($insert['tab_id'])){
			echo json_encode(array('status'=>-1,'msg'=>'请选择活动分类'));
			exit();
		}
		if(empty($insert['line_id'])){
			echo json_encode(array('status'=>-1,'msg'=>'请选择线路'));
			exit();
		}
		$linewhere='tab_id ='.$insert['tab_id'].' and line_id='.$insert['line_id'].' and startcityid='.$insert['startcityid'].' and status=1';
		$recity=$this->activity_model->get_rowData('act_tab_line',$linewhere);

		if(!empty($recity)){
			echo json_encode(array('status'=>-1,'msg'=>'该线路已经添加了'));
			exit();
		}
		$re=$this->activity_model->save_Actdata('act_tab_line',$insert);
		if($re>0){
			echo json_encode(array('status'=>1,'msg'=>'添加成功'));
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'添加失败'));
		}
	}
	//删除活动线路
	function del_lineTabid(){
		$tablineid=$this->input->post('tablineid');
		if($tablineid>0){
			$re=$this->activity_model->update_actline(array('status'=>0),$tablineid);
		
			if($re){
				echo json_encode(array('status'=>1,'msg'=>'删除成功'));
			}else{
				echo json_encode(array('status'=>-1,'msg'=>'删除失败'));
			}
			
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'删除失败'));
		}
	}
}