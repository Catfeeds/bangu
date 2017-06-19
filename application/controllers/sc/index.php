<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
*
*        do     scindex             深圳之窗show page
*
*        by     zhy
*
*        at     2016年1月19日 14:25:15
*
*/
class Index extends MY_Controller {

		public function __construct() {
		parent::__construct ();
		$this ->load_model('common/u_area_model' ,'area_model');

	}

	/*
	*
	*        do     index             深圳之窗
	*
	*        by     zhy
	*
	*        at     2016年1月22日 18:19:06
	*
	*/


	public function index()
	{
	    $this->load->model('sc/sc_fix_desc_model','fix_desc_model');
		$cityId='235';
	    $startcityId='235';
	    $reDataArr['desc']=                                     $this->fix_desc_model->show_desc($loca='1');
	    $reDataArr['desc_zhong'] =                        		$this->fix_desc_model->show_desc($loca='2');
	    $reDataArr['nav'] =                                     $this->fix_desc_model->show_nav();
	    $reDataArr['gn5'] =                                     $this->fix_desc_model->show_left($loca='2');
	    $reDataArr['jw5'] =                                     $this->fix_desc_model->show_left($loca='1');
	    $reDataArr['zb5'] =                                     $this->fix_desc_model->show_left($loca='2');
	    $reDataArr['zt5'] =                                     $this->fix_desc_model->show_theme();
	    $reDataArr['guanj5'] =                                	$this->fix_desc_model->show_grade();
	    $reDataArr['wz'] =                                      $this->fix_desc_model->show_article($loca='2');
	    $reDataArr['swz1'] =                                    $this->fix_desc_model->show_article($loca='1');
	    $reDataArr['gn9'] =                                     $this->fix_desc_model->show_centre($loca='2');
	    $reDataArr['jw9'] =                                     $this->fix_desc_model->show_centre($loca='1');
	    $reDataArr['zb9'] =                                     $this->fix_desc_model->show_centre($loca='2');
	    $reDataArr['zt9'] =                                     $this->fix_desc_model->show_centre_zt($loca='3');

	//一管家
        $reDataArr['expertData1'] =                     		$this->fix_desc_model->show_expert($loca='1');
	//六管家
        $reDataArr['expertData2'] =                    			$this->fix_desc_model->show_expert($loca='2');

		$topDest2['cj'] =                                       $this->fix_desc_model->show_product($tip='1',$limit='2');
		$topDest2['gn'] =                                       $this->fix_desc_model->show_product($tip='2',$limit='2');
		$topDest2['zb'] =                                       $this->fix_desc_model->show_product_1($loca='2');
		$topDest2['zt'] =                                       $this->fix_desc_model->show_product_2($loca='2');
		$reDataArr['orderByLine2'] = $topDest2;
		$topDest['cj'] =                                        $this->fix_desc_model->show_product($tip='1',$limit='2,4');
		$topDest['gn'] =                                        $this->fix_desc_model->show_product($tip='2',$limit='2,4');
		$topDest['zb'] =                                        $this->fix_desc_model->show_product_1($loca='2,4');
		$topDest['zt'] =                                        $this->fix_desc_model->show_product_1($loca='2,4');
		$reDataArr['orderByLine'] = $topDest;
//文章5
		$reDataArr['jw_consult'] =                    			$this->fix_desc_model->jw_consult($loca='2',$tip='1',$limit='1,5');
		$reDataArr['gn_consult'] =                    			$this->fix_desc_model->jw_consult($loca='2',$tip='2',$limit='1,5');
		$reDataArr['zt_consult'] =                     			$this->fix_desc_model->zt_consult($loca='2',$limit='1,5');
		$reDataArr['zb_consult'] =                    			$this->fix_desc_model->zt_consult($loca='2',$limit='1,5');
//文章1
		$reDataArr['jw_consult1'] =                   			$this->fix_desc_model->jw_consult($loca='1',$tip='1',$limit='1');
		$reDataArr['gn_consult1'] =                   			$this->fix_desc_model->jw_consult($loca='1',$tip='2',$limit='1');
		$reDataArr['zt_consult1'] =                   			$this->fix_desc_model->zt_consult($loca='1',$limit='1');
		$reDataArr['zb_consult1'] =                   			$this->fix_desc_model->zt_consult($loca='1',$limit='1');


		$reDataArr['jw_consult1content'] =       				$this->Profile_word($reDataArr['jw_consult1']['content']);
		$reDataArr['gn_consult1content'] =       				$this->Profile_word($reDataArr['gn_consult1']['content']);
		$reDataArr['zt_consult1content'] =        				$this->Profile_word($reDataArr['zt_consult1']['content']);
		$reDataArr['zb_consult1content'] =        				$this->Profile_word($reDataArr['zb_consult1']['content']);
//问题
        $reDataArr['p_cj'] =                                	$this->fix_desc_model->show_problem($loca='1');
        $reDataArr['p_gn'] =                               		$this->fix_desc_model->show_problem($loca='2');
        $reDataArr['p_zb'] =                               		$this->fix_desc_model->show_problem($loca='3');
        $reDataArr['p_zt'] =                                	$this->fix_desc_model->show_problem($loca='4');

		$reDataArr['url']= $this->sc_index_url();

	   //实际上线开启
	   // /$this->output->cache(5);
		$this->load->view('sc/index_view.php',$reDataArr);
	}

	//深窗首页  版本2
	function index2(){

	    $this->load->model('sc/sc_fix_desc_model','fix_desc_model');
		$this->load->model('sc/sc_db_model','db_model');
		//出发城市
		$startcityId='235';
		$startcityname="深圳市";
		$reDataArr['startcityId']=$startcityId;
		$reDataArr['startcityname']=$startcityname;
		$reDataArr['server_visit']=$this->getRegionData($startcityId);
		$reDataArr['gn5'] = $this->db_model->show_gnjw($loca='2');
		$reDataArr['jw5'] = $this->db_model->show_gnjw($loca='1');
		$reDataArr['zb5'] = $this->db_model->show_zb($startcityId);
		$reDataArr['zt5'] = $this->db_model->show_zt();
		$reDataArr['lunbo'] = $this->db_model->show_lunbo();

		//1234 咨询
		$reDataArr['consult_top'] = $this->db_model->show_index_category_consult_two();
		$reDataArr['consult_jw'] = 		$this->db_model->show_public($loca='1');
		//$reDataArr['consult_zt'] = $this->db->query ( "SELECT a.id,a.title,aa.attrname FROM sc_consult as c LEFT JOIN u_consult as a on c.consult_id=a.id left join sc_index_article_attr as aa on aa.id=a.article_attr_id where c.is_show=1 and c.index_kind_id=3 ORDER BY c.showorder desc limit 5")->result_array ();
		$reDataArr['consult_gn'] =	$this->db_model->show_public($loca='2');
		$reDataArr['consult_zb'] =	$this->db_model->show_public($loca='3'); //周边游
		//管家推荐路线
		$reDataArr['recommend_line'] =	$this->db_model->show_recommend_line();
		$reDataArr['application'] = 	$this->db_model->show_index_application();
		//一管家
		$reDataArr['expertData1'] =                     		$this->fix_desc_model->show_expert($loca='1');
		//六管家
		$reDataArr['expertData2'] =                     		$this->fix_desc_model->show_expert($loca='6');
		//模块配置 模块id
		$reDataArr['index_kind'] = 	$this->db_model->show_index_kind();
		//模块线路
		$reDataArr['index_kind_line'] =	$this->db_model->show_index_kind_line();
		//模块种类
		 $reDataArr['index_category'] = 		$this->db_model->show_index_category();
		//模块文章
		$reDataArr['index_category_consult'] = 		$this->db_model->show_index_category_consult();
		//二维码
		$reDataArr['index_public_qrcode'] = 	$this->db_model->show_index_public_qrcode();
		//帮游出品
		$reDataArr['index_bangu_article'] =	$this->db_model->show_index_bangu_article();
		//旅游曝光台
		$reDataArr['index_travel_articl'] =		$this->db_model->show_ndex_travel_article();
		//广告
		$reDataArr['fix_desc'] = $this->db_model->show_fix_desc();
		//友情链接
		$reDataArr['friend_link'] = $this->db_model->friend_link($limit="9");

		//var_dump($reDataArr['server_visit']);
		//链接
		$reDataArr['url']= $this->sc_index_url();

		$this->load->view('sc/index2_view.php',$reDataArr);
	}
	public function index3()
	{
		$this->load->view('sc/index3_view.php');
	}

	/*
	***深窗资讯列表
	*/
	public function information_list()
	{
		$this->load->model('sc/sc_fix_desc_model','fix_desc_model');
		$this->load->model('sc/sc_db_model','db_model');
		$this->load->model('sc/sc_information_model','im_model');
		//出发城市
		$startcityId='235';
		$startcityname="深圳市";
		$reDataArr['startcityId']=$startcityId;
		$reDataArr['startcityname']=$startcityname;
		$reDataArr['server_visit']=$this->getRegionData($startcityId);
		$reDataArr['gn5'] = $this->db_model->show_gnjw($loca='2');
		$reDataArr['jw5'] = $this->db_model->show_gnjw($loca='1');
		$reDataArr['zb5'] = $this->db_model->show_zb($startcityId);
		$reDataArr['zt5'] = $this->db_model->show_zt();
		//六管家
		$reDataArr['lunbo'] = $this->db_model->show_lunbo();

		$reDataArr['nav'] =                                     $this->fix_desc_model->show_nav();
		$reDataArr['expertData'] =                     		$this->fix_desc_model->show_expert($loca='6');
		$reDataArr['friend_link'] = $this->db_model->friend_link($limit="9");

		$reDataArr['fix_desc'] = $this->db_model->show_fix_desc();

		$reDataArr['index_public_qrcode'] = 	$this->db_model->show_index_public_qrcode();
		$reDataArr['tip']  =  $this->im_model->show_information_tip();

		//分页
		$page=$this->input->post("page",true);
		$cate=$this->input->post("cate",true);
		$isajax=$this->input->post("isajax",true);

		if(!$page)
			$page="1";

		$this->load->library('page_ajax');

		if (!empty($reDataArr['tip']))
			{
				foreach($reDataArr['tip'] as $key =>$val)
				{
					$k = $key + 1;
					if ($val['id'] > 0)
					{
						//分页
						$config[$k]['base_url'] = base_url().'sc/index/information_list/';
						$config[$k]['pagesize'] = "5";
						$config[$k]['page_now'] = $page;
						if($page=="1")
						{
							$offset="0";
						}
						else
						{
							$offset=($page - 1) * $config[$k]['pagesize'];
						}

						$reDataArr['im_content'][$k] = $this->im_model->show_information_content($loca='where sc.sc_index_category_id='.$val['id'],$offset,$config[$k]['pagesize']);

						$reDataArr['im_content_total'][$k]= $this->im_model->show_information_content($loca='where sc.sc_index_category_id='.$val['id']);

						$config[$k]['pagecount'] = count($reDataArr['im_content_total'][$k]);
						$this->page_ajax->initialize($config[$k]);
						$reDataArr['link_page'][$k]=$this->page_ajax->create_page();//分页
					} else {
						$reDataArr['im_content'][$k] = array();
					}
				}

			}
			$a = 1;
			$b = 8;
			for($a ; $a <= $b; $a++)
			{
				if (!array_key_exists('im_content'.$a, $reDataArr))
				{
					$reDataArr['im_content'.$a] = array();
				}
			}

		$reDataArr['url']= $this->sc_index_url();
		$reDataArr['hot_tok']  =  $this->im_model->show_hot_tok($loca='');

	    $reDataArr['guess_line']  =  $this->im_model->show_guess_line();
        if($isajax)
        {
        	$ret=array("code"=>"0","result"=>"",'msg'=>'success','page'=>$page);
        	if(isset($reDataArr['im_content'][$cate]))
        		$ret['result']=$reDataArr['im_content'][$cate];
        	echo json_encode($ret);
        }
        else
        {
		$this->load->view('sc/sc_information_list_view.php',$reDataArr);
        }
	}
	/*
	***深窗资讯详情
	*/
	public function information_detail()
	{
	    $this->load->model('sc/sc_information_model','im_model');
	    $this->load->model('sc/sc_fix_desc_model','fix_desc_model');
	    $this->load->model('sc/sc_db_model','db_model');
	    $num = $this->input->get ("id");
	    if(empty($num)){  show_404('404',500,'page not found'); }
	    $reDataArr['con']  =  $this->im_model->show_im_list($num);

	    $reDataArr['nav'] =                                     $this->fix_desc_model->show_nav();
	    $startcityId='235';
	    $reDataArr['gn5'] = $this->db_model->show_gnjw($loca='2');
	    $reDataArr['jw5'] = $this->db_model->show_gnjw($loca='1');
	    $reDataArr['zb5'] = $this->db_model->show_zb($startcityId);
	    $reDataArr['zt5'] = $this->db_model->show_zt();
	    $reDataArr['url']= $this->sc_index_url();
	    $reDataArr['fix_desc'] = $this->db_model->show_fix_desc();
	    $reDataArr['index_public_qrcode'] = 	$this->db_model->show_index_public_qrcode();
	    $reDataArr['friend_link'] = $this->db_model->friend_link($limit="9");


	    $reDataArr['guess_line']  =  $this->im_model->show_guess_line();
	    if(   empty(  $reDataArr['con']['dest'] )){    $loc=  '10342';   }else{   $arr=explode(",",$reDataArr['con']['dest']);$loc=$arr[0];  }

	    $reDataArr['three_line']  =  $this->im_model->show_hot_tok($loc);
	    $dest=$this->im_model->get_destname($loc);
	    $reDataArr['dest_name']=$dest['kindname'];
// 	    echo '<pre>';print_r(   $reDataArr );
		$this->load->view('sc/sc_information_detail_view.php',$reDataArr);
	}
	/**
	 * 点赞+1
	 * 温文斌
	 * */
	public function to_zan()
	{
		$this->load->model('sc/sc_information_model','im_model');
		$ret=array('code'=>'0','msg'=>'success');
		$id=$this->input->post("id",true);
		if(!$id)
		{
			$ret['code']="-1";
			$ret['msg']="required parameter missing";
			echo json_encode($ret);
			exit();
		}
		$consult =  $this->im_model->show_im_list($id);
		$num=$consult['praisetnum']+1;

		$data['praisetnum']=$num;
		$where['id']=$id;
		$re=$this->im_model->consult_zan($where,$data);
		if(!$re)
			$ret['code']="-1";
		echo json_encode($ret);
	}
	/**
	 * 浏览+1
	 * 温文斌
	 * */
	public function to_read()
	{
		$this->load->model('sc/sc_information_model','im_model');
		$ret=array('code'=>'0','msg'=>'success');
		$id=$this->input->post("id",true);
		if(!$id)
		{
			$ret['code']="-1";
			$ret['msg']="required parameter missing";
			echo json_encode($ret);
			exit();
		}
		$consult =  $this->im_model->show_im_list($id);
		$num=$consult['shownum']+1;

		$data['shownum']=$num;
		$where['id']=$id;
		$re=$this->im_model->consult_read($where,$data);
		if(!$re)
			$ret['code']="-1";
		echo json_encode($ret);
	}
	/***
	***深窗  曝光台  列表
	**/
	public function exposure_list(){
		$this->load->model('sc/sc_fix_desc_model','fix_desc_model');
		$this->load->model('sc/sc_db_model','db_model');
		$this->load->model('sc/sc_information_model','im_model');
		//出发城市
		$startcityId='235';
		$startcityname="深圳市";
		$reDataArr['startcityId']=$startcityId;
		$reDataArr['startcityname']=$startcityname;
		$reDataArr['server_visit']=$this->getRegionData($startcityId);
		$reDataArr['gn5'] = $this->db_model->show_gnjw($loca='2');
		$reDataArr['jw5'] = $this->db_model->show_gnjw($loca='1');
		$reDataArr['zb5'] = $this->db_model->show_zb($startcityId);
		$reDataArr['zt5'] = $this->db_model->show_zt();
		//六管家
		$reDataArr['lunbo'] = $this->db_model->show_lunbo();
		$reDataArr['nav'] =                                     $this->fix_desc_model->show_nav();
		$reDataArr['expertData'] =                     		$this->fix_desc_model->show_expert($loca='6');
		$reDataArr['friend_link'] = $this->db_model->friend_link($limit="9");

		$reDataArr['fix_desc'] = $this->db_model->show_fix_desc();

		$reDataArr['index_public_qrcode'] = 	$this->db_model->show_index_public_qrcode();
		//$reDataArr['tip']  =  $this->im_model->show_information_tip();
		$reDataArr['tip']  =  array('0'=>array('id'=>'1','attrname'=>'旅游曝光台'));

		//分页
		$page=$this->input->post("page",true);
		$cate=$this->input->post("cate",true);
		$isajax=$this->input->post("isajax",true);

		if(!$page)
			$page="1";

		$this->load->library('page_ajax');

		if (!empty($reDataArr['tip']))
		{
			foreach($reDataArr['tip'] as $key =>$val)
			{
				$k = $key + 1;
				if ($val['id'] > 0)
				{
					//分页
					$config[$k]['base_url'] = base_url().'sc/index/exposure_list/';
					$config[$k]['pagesize'] = "5";
					$config[$k]['page_now'] = $page;
					if($page=="1")
					{
						$offset="0";
					}
					else
					{
						$offset=($page - 1) * $config[$k]['pagesize'];
					}

					$reDataArr['im_content'][$k] = $this->im_model->show_travel_article(array(),$offset,$config[$k]['pagesize']);

					$reDataArr['im_content_total'][$k]= $this->im_model->show_travel_article(array());

					$config[$k]['pagecount'] = count($reDataArr['im_content_total'][$k]);
					$this->page_ajax->initialize($config[$k]);
					$reDataArr['link_page'][$k]=$this->page_ajax->create_page();//分页
				} else {
					$reDataArr['im_content'][$k] = array();
				}
			}

		}
		$a = 1;
		$b = 8;
		for($a ; $a <= $b; $a++)
		{
		if (!array_key_exists('im_content'.$a, $reDataArr))
		{
		$reDataArr['im_content'.$a] = array();
		}
		}

		$reDataArr['url']= $this->sc_index_url();
		$reDataArr['hot_tok']  =  $this->im_model->show_hot_tok($loca='');

		$reDataArr['guess_line']  =  $this->im_model->show_guess_line();
		if($isajax)
		{
		$ret=array("code"=>"0","result"=>"",'msg'=>'success','page'=>$page);
		if(isset($reDataArr['im_content'][$cate]))
		$ret['result']=$reDataArr['im_content'][$cate];
		echo json_encode($ret);
		}
        else
		{
			$this->load->view('sc/sc_exposure_list_view.php',$reDataArr);
		}


	}
	/***
	***深窗  曝光台  详情
	**/
	public function exposure_detail(){
		$this->load->model('sc/sc_information_model','im_model');
		$this->load->model('sc/sc_fix_desc_model','fix_desc_model');
		$this->load->model('sc/sc_db_model','db_model');
		$num = $this->input->get ("id");
		if(empty($num) || $this->check_inject($num)){  show_404('404',500,'page not found'); }
		$reDataArr['con']  =  $this->im_model->travel_article_detail($num);
		$reDataArr['nav'] =                                     $this->fix_desc_model->show_nav();
		$startcityId='235';
		$reDataArr['gn5'] = $this->db_model->show_gnjw($loca='2');
		$reDataArr['jw5'] = $this->db_model->show_gnjw($loca='1');
		$reDataArr['zb5'] = $this->db_model->show_zb($startcityId);
		$reDataArr['zt5'] = $this->db_model->show_zt();
		$reDataArr['url']= $this->sc_index_url();
		$reDataArr['fix_desc'] = $this->db_model->show_fix_desc();
		$reDataArr['index_public_qrcode'] = 	$this->db_model->show_index_public_qrcode();
		$reDataArr['friend_link'] = $this->db_model->friend_link($limit="9");


		$reDataArr['guess_line']  =  $this->im_model->show_guess_line();
		if(   empty(  $reDataArr['con']['dest'] )){    $loc=  '10342';   }else{   $arr=explode(",",$reDataArr['con']['dest']);$loc=$arr[0];  }

		$reDataArr['three_line']  =  $this->im_model->show_hot_tok($loc);
		$dest=$this->im_model->get_destname($loc);
		$reDataArr['dest_name']=$dest['kindname'];
		// 	    echo '<pre>';print_r(   $reDataArr );

		$this->load->view('sc/sc_exposure_detail_view.php',$reDataArr);

	}
/*
*
*        do     ajax	expert
*
*        by     zhy
*
*        at     2016年1月20日 16:40:43
*
*/
public function expert_data_after($eid=""){
	//$eid= $this->input->post ( 'kks', true );
	$callback=$_REQUEST['callback'];

	// is_numeric($eid)? ($eid):	echo json_encode(array('code'=>4001 ,'msg' =>'null'));
	$reDataArr = $this->db->query ( "  SELECT `e`.`id` as eid, `e`.`nickname`, `e`.`talk`, (select GROUP_CONCAT(kindname) from u_dest_base where FIND_IN_SET(id,substring_index(e.expert_dest,',',4)) >0 )as end ,(select GROUP_CONCAT(name) from u_area where FIND_IN_SET(id,substring_index(e.visit_service,',',4)	) >0 )as door ,`a`.`name` as cityname, `ie`.`smallpic`, `ie`.`pic`, CASE WHEN e.grade=1 THEN '管家' WHEN	e.grade=2 THEN '初级管家'   WHEN e.grade=3 THEN '中级管家'  WHEN	e.grade=4 THEN '高级管家'  END grade FROM (`cfg_index_expert` as ie) LEFT JOIN `u_expert` as e ON `ie`.`expert_id` = `e`.`id`  LEFT JOIN `u_area` as a ON `a`.`id` = `ie`.`startplaceid`  WHERE `ie`.`is_show` = 1 AND `ie`.`location` = 1 AND `e`.`status` = 2 AND `ie`.`startplaceid` = '235' and e.id={$eid} ")->row_array ();

	if(!empty($reDataArr))
	{
		echo $callback."(".json_encode(array('code'=>2000 ,'msg' =>'ok!','data'=>$reDataArr)).")";
	}
	else
	{
		echo $callback."(".json_encode(array('code'=>4001 ,'msg' =>'is null')).")";
	}
}
/*
*
*        do     Profile	 	简介
*
*        by     zhy
*
*        at     2016年1月22日 15:16:52
*
*/
public function Profile_word($word){
		$nn=strip_tags($word);
		$bb=str_replace("&nbsp", "", $nn);
		$vv =mb_substr($bb,0,14,'utf-8') . '...';
		return $vv;

}

/*
*
*        do     activity	 	活动
*
*        by     zhy
*
*        at     2016年1月22日 18:06:23
*
*/


public function scactivity(){
    $this->load->model('sc/sc_fix_desc_model','fix_desc_model');
	 $this->load->model('sc/sc_scactivity_model','scactivity_model');
	 $this->load->model('sc/sc_db_model','db_model');

		//导航
			$reDataArr['nav'] =                                     		$this->fix_desc_model->show_nav();
		//精品路线
			 $reDataArr['quality_line'] = 									$this->scactivity_model->quality_line();
		//超值路线
			$reDataArr['recommend_line'] = 									$this->scactivity_model->recommend_line();
		//一管家
			$reDataArr['expertData1'] =                     				$this->fix_desc_model->show_expert($loca='1');
		//友情链接
			$reDataArr['friend_link'] = $this->db_model->friend_link($limit="9");

		//六管家
			$reDataArr['expertData2'] =                     				$this->fix_desc_model->show_expert($loca='1,6');


			$reDataArr['in'] =                                       		$this->fix_desc_model->show_product($tip='2',$limit='4');
			$reDataArr['ou'] =                                       		$this->fix_desc_model->show_product($tip='1',$limit='4');
			$reDataArr['zb'] =                                       		$this->fix_desc_model->show_product($loca='3',$limit='4');
		//国内
			$reDataArr['ou_dest'] = 										$this->scactivity_model->out_inseid_line($loca='1');
			$end = $this->scactivity_model->sole_num($loca='1');
			if (!empty($end))
			{
				foreach($end as $key =>$val)
				{
					$k = $key + 1;
					if ($val['id'] > 0)
					{
						$reDataArr['ou_dest_list'.$k] = $this->scactivity_model->out_inseid_pro($val['id']);
					} else {
						$reDataArr['ou_dest_list'.$k] = array();
					}
				}

			}
			$a = 1;
			$b = 5;
			for($a ; $a <= $b; $a++)
			{
				if (!array_key_exists('ou_dest_list'.$a, $reDataArr))
				{
					$reDataArr['ou_dest_list'.$a] = array();
				}
			}

			//国外
			$reDataArr['in_dest'] = 										$this->scactivity_model->out_inseid_line($loca='2');
			$endnum = $this->scactivity_model->sole_num($loca='2');

			if (!empty($endnum))
			{
			    foreach($endnum as $key =>$val)
			    {
			        $k = $key + 1;
			        if ($val['id'] > 0)
			        {
			            $reDataArr['in_dest_list'.$k] = $this->scactivity_model->out_inseid_pro($val['id']);
			        } else {
			            $reDataArr['in_dest_list'.$k] = array();
			        }
			    }

			}
			$a = 1;
			$b = 5;
			for($a ; $a <= $b; $a++)
			{
			    if (!array_key_exists('in_dest_list'.$a, $reDataArr))
			    {
			        $reDataArr['in_dest_list'.$a] = array();
			    }
			}

			//周边
			$reDataArr['zb_dest'] = 										$this->scactivity_model->out_inseid_line($loca='3');
			$endnums = $this->scactivity_model->sole_num($loca='3');

			if (!empty($endnums))
			{
			    foreach($endnums as $key =>$val)
			    {
			        $k = $key + 1;
			        if ($val['id'] > 0)
			        {
			            $reDataArr['zb_dest_list'.$k] = $this->scactivity_model->out_inseid_pro($val['id']);
			        } else {
			            $reDataArr['zb_dest_list'.$k] = array();
			        }
			    }

			}
			$a = 1;
			$b = 5;
			for($a ; $a <= $b; $a++)
			{
			    if (!array_key_exists('zb_dest_list'.$a, $reDataArr))
			    {
			        $reDataArr['zb_dest_list'.$a] = array();
			    }
			}
			$reDataArr['pics_3'] =								$this->scactivity_model->show_pic_3();

			if (!empty($reDataArr['pics_3']))
			{
			    foreach($reDataArr['pics_3'] as $key =>$val)
			    {
			            $re = $this->scactivity_model->show_pic_3_2($val['dest_id']);
			            foreach (     $re  as  $k=>$v   ){
			                if($v['pid'] ==1){
			                    $reDataArr['pics_3'][$key]['pid'] = '1';
			                }elseif( $v['pid'] ==2){
			                    $reDataArr['pics_3'][$key]['pid'] ='2';
			                }else{
			                    $reDataArr['pics_3'][$key]['pid'] = $this->scactivity_model->show_pic_3_2($v['pid']);
			                }
			            }
			    }

			}


			$reDataArr['url']= $this->sc_index_url();
	 $this->load->view('sc/activity_view.php',$reDataArr);
 }
 /**
  * 深窗首页栏
  */
 public function travel() {
 	$this->load->model('sc/sc_fix_desc_model','fix_desc_model');
	$this->load->model('sc/sc_db_model','db_model');
 	$reDataArr = array();
	$reDataArr['wz'] = $this->db_model->show_travel_sc_consult();
	$reDataArr['swz1'] = $this->db_model->show_travel_sc_consult_2();
	$reDataArr['expertData1'] = $this->fix_desc_model->show_expert($loca='1');
	//8管家
	$reDataArr['expertData2'] =  $this->fix_desc_model->show_expert($loca='1,8');
	$topDest['cj'] = $this->db_model->show_travel_line($loca='1');
	$topDest['gn'] = $this->db_model->show_travel_line($loca='2');
	$topDest['zb'] = $this->db_model->show_travel_line_zb();
	$topDest['zt'] = $this->db_model->show_travel_line_zt();
	$reDataArr['orderByLine'] = $topDest;
	$reDataArr['url']= $this->sc_index_url();
	//var_dump($reDataArr['expertData1']);exit();
    	$this->load->view ( 'sc/travel.php',  $reDataArr);
 }

 /**
  * 描述：深窗首页右边侧栏：页面
  * 功能: 资讯
  */
 public function sidebar() {
 	$this->load->model('sc/sc_db_model','db_model');
 	$consult=$this->db_model->sidebar_consult($limit="8");
 	$data['consult']=json_encode($consult);
 	$data['url']=$this->sc_index_url();
 	$this->load->view ( 'sc/sidebar',$data);
 }
 /**
  * 描述：深窗首页右边侧栏:接口
  * 功能: 资讯
  */
 public function sidebar_api() {
 	$callback=$_REQUEST['callback'];
 	$this->load->model('sc/sc_db_model','db_model');
 	$consult=$this->db_model->sidebar_consult($limit="7");
 	echo $callback."(".json_encode($consult).")";
 }


 /*
*
*        do     url
*
*        by     zhy
*
*        at     2016年1月26日 17:40:42
*
*/

 public function sc_index_url(){
	 $reDataArr['url']=array(
		   'cj'=>'http://www.1b1u.com/cj/_ds-',
		   'gn'=>'http://www.1b1u.com/gn/_ds-',
		   'zt'=>'http://www.1b1u.com/zt/_ts-',
		   'zb'=>'http://www.1b1u.com/zb/_ds-',
		   'guanj1'=>'http://www.1b1u.com/guanj/_c-235_g-',
		   'guanj2'=>'http://www.1b1u.com/guanj/_c-235_g-',
		   'guanj3'=>'http://www.1b1u.com/guanj/_c-235_g-',
		   'guanj4'=>'http://www.1b1u.com/guanj/_c-235_g-',
		   'guanwei'=>'_p-1_o-1.html',
		   'guanj'=>' http://www.1b1u.com/guanj/',  //管家列表
		   'line'=>'http://www.1b1u.com/cj', //线路列表
		   'consult'=>'http://www.1b1u.com/lyzx', //咨询列表
		   'articl_detail'=>'http://www.1b1u.com/sc/index/exposure_detail?id=',//旅游曝光台详情
		   'wz'=>'http://www.1b1u.com/lyzx/tours_',
		   'wei'=>'.html',
		   'l_cj'=>'http://www.1b1u.com/cj/',
		   'l_gn'=>'http://www.1b1u.com/gn/',
		   'l_zt'=>'http://www.1b1u.com/zt/',
		   'l_zb'=>'http://www.1b1u.com/zb/',
		   'l_dzy'=>'http://www.1b1u.com/dzy/',
		   'index'=>'http://www.1b1u.com',
		   'guanjia'=>'http://www.1b1u.com/srdz/e-',
	 	   'sc_consult_detail'=>'http://www.1b1u.com/sc/index/information_detail'
		   );

		   return $reDataArr['url'];

 }
/**
 * ==================================================================================
 **/
   /**
    * 从 controller/common/area.php 复制部分方法出来
    * 温文斌
    * */
	/**
	 * @method 根据出发城市获取周边游
	 * @author jiakairong
	 * @since  2015-11-14-6
	 * @param intval $startplaceid 出发城市ID
	 */
	protected function getRoundTripData($startplaceid)
	{
		$this ->load_model('common/cfg_round_trip_model' ,'trip_model');
		$this ->load_model('common/u_dest_cfg_model' ,'dest_model');

		if(empty($startplaceid))
		{
			$startplaceid = $this ->session ->userdata('city_location_id');
			$cityName = $this ->session ->userdata('city_location');
		}
		else
		{
			$this ->load_model('common/u_startplace_model' ,'startplace_model');
			$startData = $this ->startplace_model ->row(array('id' =>$startplaceid));
			$cityName = $startData['cityname'];
		}
		//获取周边目的地
		$tripData = $this ->trip_model ->all(array('startplaceid' =>$startplaceid ,'isopen' =>1));
		$tripArr = array();
		if (!empty($tripData))
		{
			$destId = '';
			foreach($tripData as $v)
			{
				$destId .= $v['neighbor_id'].',';
			}
			$destId = rtrim($destId ,',');
			//获取目的地
			$tripArr = $this ->dest_model ->getDestInData($destId);
		}
		return array(
				'name' =>'周边游',
				'two' =>array(
						array(
								'name' =>$cityName,
								'three' =>$tripArr
						),
				),
		);
	}
	/**
	 * @method 通过城市ID获取其下面的行政区(现用于：获取管家服务地区)
	 * @since  2015-11-17
	 */
	public function getRegionData($cityid="")
	{
		//$cityid = intval($this ->input ->post('cityid'));
		$regionData = $this ->area_model ->all(array('isopen'=>1,'pid'=>$cityid));
		return $regionData;
	}
	/**
	 * @method 通过城市ID获取其下面的行政区(现用于：获取管家服务地区) --------   深圳页面 ，ajax跨域
	 * @since  2015-11-17
	 */
	public function getRegionData_sc($cityid="")
	{
		//$cityid = intval($this ->input ->post('cityid'));
		$regionData = $this ->area_model ->all(array('isopen'=>1,'pid'=>$cityid));
		echo $_REQUEST['callbackparam']."(".json_encode($regionData).")";
	}
	/**
	 * @method 获取地区，用于地区选择插件 ---------------------  深窗页面，ajax跨域
	 * @author jiakairong
	 * @since  2015-11-16
	 */
	public function getAreaData_sc()
	{
		$this ->load_model('common/u_area_model' ,'area_model');
		$areaData = $this ->area_model ->getAreaAllData();
		$areaArr = array();
		$three_area = array();
		foreach($areaData as $key=>$val)
		{
			if (empty($val['name']))
			{
				continue;
			}
			switch($val['level']) {
				case 1: //顶级
					if ($val['id'] == 1) //境外
					{
						$areaArr['abroad'] = $val;
					}
					elseif ($val['id'] == 2) //国内
					{
						$areaArr['domestic'] = $val;
					}
					break;
				case 2:
					if ($val['pid'] == 1)
					{
						$areaArr['abroad']['two'][$val['id']] = $val;
					}
					elseif ($val['pid'] == 2)
					{
						$areaArr['domestic']['two'][$val['id']] = $val;
					}
					break;
				case 3:
					$three_area[] = $val;
					break;
			}
		}
		foreach($three_area as $val)
		{
			foreach($areaArr as $index =>$item)
			{
				if (!isset($item['two']))
				{
					unset($areaArr[$index]); //没有第二级，则删除掉
				}
				else
				{
					foreach($item['two'] as $k =>$v)
					{
						if ($val['pid'] == $v['id'])
						{
							$areaArr[$index]['two'][$k]['three'][] = $val;
						}
					}
				}
			}
		}
		//过滤第三级为空的情况
		foreach($areaArr as $key=>$val)
		{
			foreach($val['two'] as $k=>$v)
			{
				if (empty($v['three']))
				{
					unset($areaArr[$key]['two'][$k]);
				}
			}
		}
		echo $_REQUEST['callbackparam']."(".json_encode($areaArr).")";
	}
	/**
	 * @method 获取出发城市，用于出发城市选择插件---------- 深窗页面，ajax跨域
	 * @author jiakairong
	 * @since  2015-11-17
	 */
	public function getStartplaceAllData_sc()
	{
		$this ->load_model('common/u_startplace_model' ,'start_model');
		$startData = $this ->start_model ->getStartAllData(1);
		$startArr = array();
		$threeStartArr = array();
		$callbackparam = $this->input->get_post('callbackparam',true);
		foreach($startData as $key=>$val)
		{
			if (empty($val['name']))
			{
				continue;
			}
			switch($val['level']) {
				case 1: //顶级
					if ($val['id'] == 1) //国外
					{
						$startArr['abroad'] = $val;
					}
					elseif ($val['id'] == 2) //国内
					{
						$startArr['domestic'] = $val;
					}
					break;
				case 2:
					if ($val['pid'] == 1)
					{
						$startArr['abroad']['two'][$val['id']] = $val;
					}
					elseif ($val['pid'] == 2)
					{
						$startArr['domestic']['two'][$val['id']] = $val;
					}
					break;
				case 3:
					$threeStartArr[] = $val;
					break;
			}
		}
		foreach($threeStartArr as $val)
		{
			foreach($startArr as $index =>$item)
			{
				if (!isset($item['two']))
				{
					unset($startArr[$index]); //没有第二级，则删除掉
				}
				else
				{
					foreach($item['two'] as $k =>$v)
					{
						if ($val['pid'] == $v['id'])
						{
							$startArr[$index]['two'][$k]['three'][] = $val;
						}
					}
				}
			}
		}
		//过滤第三级为空的情况
		foreach($startArr as $key=>$val)
		{
			foreach($val['two'] as $k=>$v)
			{
				if (empty($v['three']))
				{
					unset($startArr[$key]['two'][$k]);
				}
			}
		}
		echo  $callbackparam."(".json_encode($startArr).")";
	}
	/**
	 * @method 获取目的地，用于目的地选择插件--------------------  深圳页面，ajax跨域
	 * @author jiakairong
	 * @since  2015-11-16
	 * @param intval $startplaceid  出发城市id，用于获取周边游
	 */
	public function getDestAllData_sc($startplaceid=0)
	{
		$callbackparam = $this->input->get_post('callbackparam',true);
		$this ->load_model('common/u_dest_cfg_model' ,'dest_model');
		$destData = $this ->dest_model ->getDistination(3);
		$destArr = array();
		$threeDestArr = array();
		foreach($destData as $key=>$val)
		{
			if (empty($val['name']))
			{
				continue;
			}
			switch($val['level']) {
				case 1: //顶级
					if ($val['id'] == 1) //出境游
					{
						$destArr['abroad'] = $val;
					}
					elseif ($val['id'] == 2) //国内游
					{
						$destArr['domestic'] = $val;
					}
					break;
				case 2:
					if ($val['pid'] == 1)
					{
						$destArr['abroad']['two'][$val['id']] = $val;
					}
					elseif ($val['pid'] == 2)
					{
						$destArr['domestic']['two'][$val['id']] = $val;
					}
					break;
				case 3:
					$threeDestArr[] = $val;
					break;
			}
		}
		foreach($threeDestArr as $val)
		{
			foreach($destArr as $index =>$item)
			{
				if (!isset($item['two']))
				{
					unset($destArr[$index]); //没有第二级，则删除掉
				}
				else
				{
					foreach($item['two'] as $k =>$v)
					{
						if ($val['pid'] == $v['id'])
						{
							$destArr[$index]['two'][$k]['three'][] = $val;
						}
					}
				}
			}
		}
		//过滤第三级为空的情况
		foreach($destArr as $key=>$val)
		{
			foreach($val['two'] as $k=>$v)
			{
				if (empty($v['three']))
				{
					unset($destArr[$key]['two'][$k]);
				}
			}
		}
		$destArr['trip'] = $this ->getRoundTripData($startplaceid);

		echo $callbackparam."(".json_encode($destArr).")";
	}
	/**
	 * ===  结束 ====
	 * */
	
	
	/**
	 * 女神宣传页 
	 * */
	public function nvshen()
	{
		$this->load->model('sc/sc_fix_desc_model','fix_desc_model');
		$data['nav'] = $this->fix_desc_model->show_nav();
		$this->load->view('sc/nvshen' ,$data);
	}
	
	
	


}
