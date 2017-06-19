<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_model extends MY_Model {
	public $table = 'u_line';
	
	function __construct() {
		parent::__construct ( 'u_line' );
	}
	
	/**
	 * @method 获取线路数据，用于线路虚拟值修改
	 * @author jkr
	 */
	public function getLineVrData($whereArr,$orderBy='l.id desc')
	{
		$sql = 'select l.id,l.linecode,l.linename,s.company_name as supplier_name,la.collect_num_vr,la.sati_vr,la.order_num_vr,group_concat(sp.cityname) as cityname from u_line as l left join u_line_affiliated as la on la.line_id=l.id left join u_supplier as s on s.id=l.supplier_id left join u_line_startplace as ls on ls.line_id = l.id left join u_startplace as sp on sp.id=ls.startplace_id';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy ,'group by l.id');
	}
	
	/**
	 * @method 修改收藏虚拟值
	 * @param unknown $lineid 线路ID
	 * @param unknown $num 收藏虚拟值
	 */
	public function update_vr($lineid ,$dataArr)
	{
		$this->db->trans_start();
	
		//查询附属记录是否存在
		$sql = 'select * from u_line_affiliated where line_id='.$lineid;
		$affiliated = $this ->db ->query($sql) ->row_array();
		if (empty($affiliated))
		{
			//没有记录附属信息，则写入
			$dataArr['line_id'] = $lineid;
			$this ->db ->insert('u_line_affiliated' ,$dataArr);
		}
		else
		{
			$this ->db ->where('id' ,$affiliated['id']) ->update('u_line_affiliated' ,$dataArr);
		}
	
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	/**
	 * @method 查询表的数据
	 * @author xml
	 */
	public function select_rowData($table,$where){
		$this->db->select('*');
		$this->db->where($where);
		return  $this->db->get($table)->row_array();
	}
      /**
	 * @method 插入表
	 * @author xml
	 */
	public function insert_data($table,$data){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	/**
	 * @method 单项预定获取数据
	 * @author jkr
	 */
	public function getLineReserve(array $whereArr ,$orderBy="lsp.dayid desc" ,$specialSql)
	{
		//目前单项只有一个目的地，和一个出发地

		//$sql = 'select group_concat(d.kindname) as kindname,lsp.lineid,l.linename,l.linecode,lsp.dayid,lsp.day,lsp.number,lsp.childnobedprice,lsp.childprice,lsp.oldprice,lsp.adultprice,sp.cityname from u_line_suit_price as lsp left join u_line as l on l.id=lsp.lineid left join u_line_startplace as ls on ls.line_id=l.id left join u_startplace as sp on sp.id=ls.startplace_id left join u_line_dest as ld on ld.line_id = l.id left join b_single_affiliated as sa on sa.line_id=l.id left join u_dest_base as d on d.id=ld.dest_id ';

		$sql = 'select 
						lsp.lineid,l.linename,l.linecode,lsp.dayid,lsp.day,lsp.number,lsp.childnobedprice,lsp.childprice,
						lsp.oldprice,lsp.adultprice,sp.cityname,
						(select group_concat(f.file) from b_single_file as f where f.line_id=lsp.lineid) as file_path,
						(select group_concat(f.file_name) from b_single_file as f where f.line_id=lsp.lineid) as file_name
				from 
						u_line_suit_price as lsp 
						left join u_line as l on l.id=lsp.lineid 
						left join u_line_startplace as ls on ls.line_id=l.id 
						left join u_startplace as sp on sp.id=ls.startplace_id 
						left join b_single_affiliated as sa on sa.line_id=l.id 
				';

		return $this ->getCommonData($sql ,$whereArr ,$orderBy ,'group by lsp.dayid' ,$specialSql);
	}

	//定制线预订
	public function getGroupLine(array $whereArr ,$orderBy="lsp.dayid desc" ,$union_id,$sqlWhere,$cityid)
	{

		$sql = 'select lsp.lineid,l.linename,lsp.description,l.linecode,lsp.dayid,lsp.day,lsp.number,lsp.childnobedprice,lsp.childprice,lsp.oldprice,lsp.adultprice,l.linebefore,lsp.before_day as p_day,lsp.hour as p_hour,lsp.minute as p_minute,';
		$sql.=' laf.deposit, laf.before_day,laf.hour,laf.minute,laf.code, ';
		$sql.=' SUM(mo.dingnum) AS total_dingnum,SUM(mo.oldnum) AS total_oldnum,SUM(mo.childnum) AS total_childnum,SUM(mo.childnobednum) AS total_childnobednum ';
		$sql .=' from   u_line_suit_price as  lsp ';
		$sql .=' left join u_line as  l on l.id = lsp.lineid ';
		$sql .='  left join  u_line_affiliated as laf on laf.line_id= l.id  ';
		$sql .=' left join b_union_approve_line as lapl on lapl.line_id=l.id and lapl.union_id= '.$union_id ;
		$sql .='  left join  u_line_package as lpc on lpc.line_id=l.id  ';
		$sql .='  left join u_member_order mo ON lsp.suitid=mo.suitid AND mo.usedate=lsp.day ';
		if(!empty($cityid)){  //出发城市搜索 
		    $sqlWhere=$sqlWhere.'and (select count(id) from u_line_startplace as lst where lst.line_id =l.id and lst.startplace_id='.$cityid.')>0 ';
		}
		$result=$this ->getCommonData($sql ,$whereArr ,$orderBy ,'group by lsp.dayid' ,$sqlWhere);
        //echo $this->db->last_query();
		if(!empty($result['data'])){
		 	foreach ($result['data'] as $key => $value) {

				$mysql ='select GROUP_CONCAT(sp.cityname) AS cityname from u_line as l ';
		 		$mysql .=' left join  u_line_startplace as  ls on ls.line_id = l.id';
				$mysql .=' left join u_startplace as sp on sp.id = ls.startplace_id';
				$mysql .=' where l.id='.$value['lineid'];
				$mysql .=' group by l.id ';
				$data=$this ->db ->query($mysql) ->row_array();
				if(!empty($data['cityname'])){
					$result['data'][$key]['cityname'] =$data['cityname'];
				}else{
					$result['data'][$key]['cityname'] ='';
				}
		 	}
		 }
		 return  $result;
	}

	/**
	 * @method 获取线路出发城市
	 * @author jkr
	 * @param unknown $lineid
	 */
	public function getLineStartplace($lineid)
	{
		$sql = 'select ls.startplace_id from u_line as l left join u_line_startplace as ls on ls.line_id = l.id where l.id ='.$lineid;
		return $this ->db ->query($sql) ->result_array();
	}

	/**
	 * @method 获取线路套餐,用于下订单
	 * @author jkr
	 */
	public function getLineSuit($dayid ,$lineid)
	{
		$sql = 'select sp.*,ls.suitname,ls.unit from u_line_suit_price as sp left join u_line_suit as ls on ls.id= sp.suitid  where sp.dayid ='.$dayid.' and sp.lineid ='.$lineid.' and sp.is_open =1';
		return $this ->db ->query($sql) ->row_array();
	}

	/**
	 * @method 获取线路套餐,用于下订单
	 * @author jkr
	 */
	public function getLineSuitDay($suitid,$usedate)
	{
		$sql = 'SELECT * FROM u_line_suit_price WHERE suitid='.$suitid.' AND  day =\''.$usedate.'\' and is_open=1';
		$res = $this ->db ->query($sql) ->row_array();
		return $res;
	}

	/**
	 * @method 获取线路信息，现用于c端下订单
	 * @param unknown $where
	 */
	public function getLineOrder(array $whereArr)
	{
		$whereStr = '';
		foreach($whereArr as $key=>$val)
		{
			$whereStr .= ' '.$key.'="'.$val.'" and';
		}
		$sql = 'select l.*,la.deposit,la.before_day from u_line as l left join u_line_affiliated as la on la.line_id = l.id where '.rtrim($whereStr,'and');
		return $this ->db ->query($sql) ->result_array();
	}

	/**
	 * @method 用于平台的线路审核管理
	 * @author jiakairong
	 * @since  2016-03-15
	 * @param array $whereArr
	 */
	public function getALineData(array $whereArr = array() ,$specialSql = '' ,$num=false ,$orderBy='l.modtime desc')
	{
		//GROUP_CONCAT group by count(distinct l.id)
		$sql = 'select l.displayorder, ula.collect_num_vr,l.linecode,l.confirm_time,l.linename,
                        l.modtime,l.addtime,s.linkman,s.company_name,l.id as line_id,l.status,l.agent_rate_int, group_concat(distinct ud.kindname) as dest_name,
                        l.overcity,l.online_time,a.realname as username,group_concat(distinct sp.cityname) as cityname,b.employee_name,b.puid 
                        from u_line as l left join u_supplier as s on l.supplier_id = s.id 
						left join (select pul.line_id,pul.employee_name,pul.id as puid from b_union_approve_line as pul group by pul.line_id) as b  on l.id = b.line_id
                        left join u_admin as a on l.admin_id = a.id 
                        left join u_line_startplace as ls on ls.line_id = l.id 
                        left join u_startplace as sp on sp.id=ls.startplace_id 
                        left join u_line_dest as uld on l.id = uld.line_id
                        left join u_dest_base as ud on uld.dest_id = ud.id AND ud.level = 3
                        left join u_line_affiliated as ula on ula.line_id = l.id ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy ,'group by l.id',$specialSql ,$num);
		
	}


	/**
	 * @method 线路排序
	 * @author jiakairong
	 * @since  2015-11-12
	 */
	public function lineSortData($whereArr ,$page=1 ,$num =10 ,$orderBy = 'id desc') {
		$whereStr = '';
		$startplace_where='';
		$join_dest = '';
		foreach($whereArr as $k=>$v)
		{
			switch($k){
				case 'ls.startplace_id':
					$startplace_where .= ' ls.startplace_id in ('.$v.') ';
					break;
				case 'overcity':
					$join_dest .= ' INNER JOIN `u_line_dest` ld ON l.id=ld.line_id  AND dest_id IN (';
					foreach($v as $i){
						$join_dest .= ' '.$i.' or';
					}
					$join_dest =rtrim($join_dest ,'or'). ') ';
					break;
				case 'l.themeid':
					$whereStr .= ' l.themeid >0 and';
					break;
				default:
					$whereStr .= " $k = '$v' and";
					break;
			}
		}
		$whereStr = rtrim($whereStr ,'and');
		$limitStr = ' LIMIT '.(($page-1)*$num).','.$num;

		$sql = 'SELECT l.id,l.linename,l.lineprice,l.mainpic,l.overcity FROM u_line as l INNER JOIN u_line_startplace AS ls ON ls.line_id = l.id AND '.$startplace_where.$join_dest.' WHERE '.$whereStr.' ORDER BY '.$orderBy.$limitStr;
		return $this ->db ->query($sql) ->result_array($sql);
	}

	/**
	 * 获取满足条件的线路
	 * @author 贾开荣
	 * @param array $where  条件
	 * @param intval $page		当前页
	 * @param intval $num	每页数量
	 * @param string $order_by	排序
	 * @return array
	 */
	public function getLineData($whereArr,$page = 1, $num = 10 ,$orderBy = 'l.displayorder asc') {
		$whereStr = '';
		$join = '';
		foreach($whereArr as $key =>$val)
		{
			if (empty($val) && $val !== 0)
			{
				continue;
			}
			if ($key == 'overcity') //线路属性 or 线路目的地，多选
			{
				$join.= ' INNER JOIN `u_line_dest` ld ON l.id=ld.line_id AND dest_id IN(';
				$idx=0;
				foreach($val as $i)
				{
					$join .= ($idx>0?',':'').$i;
					$idx++;
				}
				$join.= ') ';

			}else if ($key == 'linetype' ){ //线路属性 or 线路目的地，多选

				$join.= ' INNER JOIN u_line_type lt ON l.id=lt.line_id AND attr_id IN(';
				$idx=0;
				foreach($val as $i)
				{
					$join .= ($idx>0?',':'').$i;
					$idx++;
				}
				$join.= ') ';
			}
			elseif ($key == 'themeid')
			{
				$themeids = implode(',', $val);
				$whereStr .= ' l.themeid in ('.$themeids.') and';
			}
			elseif ($key == 'theme')
			{
				$whereStr .= ' l.themeid > 0 and';
			}
			elseif ($key == 'keyword') //关键词
			{
				$whereStr .= ' (l.linename like "%'.$val.'%" or l.linetitle like "%'.$val.'%") and';
			}
			elseif ($key == 'l.startcity' || $key == 'la.expert_id')
			{
				//$whereStr .= ' ls.startplace_id in ('.$val.') and';
			}
			elseif ($key == 'status' || $key == 'producttype')
			{
				$whereStr .= " l.$key='$val' and";
			}
		}
		$whereStr = rtrim($whereStr ,'and');
		$limitStr = 'LIMIT '.(($page-1) * $num).','.$num;

// 		$sql = 'select l.id as lineid,l.linename,l.mainpic,l.overcity,l.peoplecount,l.all_score,l.comment_count,l.linetitle,l.lineprice,l.satisfyscore,l.features,l.comment_score,l.bookcount AS sales,l.transport,l.lineday,l.hotel_start from u_line as l where ';

// 		$join .= " INNER JOIN u_line_startplace AS ls ON ls.line_id = l.id AND ls.startplace_id IN (".$whereArr["l.startcity"].") ";
// 		if ($whereArr['la.expert_id'] > 0){
// 			$join .= ' INNER JOIN u_line_apply AS la ON la.line_id = l.id AND la.status=2 AND la.expert_id = '.$whereArr['la.expert_id'].' ';
// 		}
		//获取总数
		$count_sql="SELECT COUNT(l.id) AS num FROM u_line AS l ".$join." WHERE $whereStr ";
// 		echo $count_sql;
		$query = $this->db->query($count_sql, $param);
		$result = $query->result();
		$data['count'] = $result[0]->num;
		//$sql = "select l.id as lineid,l.linename,l.mainpic,l.overcity,l.peoplecount,l.all_score,l.comment_count,l.linetitle,l.lineprice,l.satisfyscore,l.features,l.comment_score,l.bookcount AS sales,l.transport,l.lineday,l.hotel_start,count(distinct l.id) from u_line as l left join u_line_apply as la on la.line_id = l.id left join u_line_startplace as ls on ls.line_id = l.id where $whereStr group by l.id ";
		//$data['count'] = $this ->getCount($sql ,array());
		//获取列表

		$sub_sql = "SELECT l.id  FROM u_line AS l " .$join." WHERE ".$whereStr;
		//当没有JOIN的时候 不需要分组
		if(!empty($join)){
			$sub_sql.=" GROUP BY l.id ";
		}
		$sub_sql.=" ORDER BY ".$orderBy.' '.$limitStr;

// 		echo $sub_sql;

		$lineIds = $this ->db ->query($sub_sql) ->result_array();

		$sql = "SELECT l.id AS lineid,l.linename,l.mainpic,l.overcity,l.peoplecount,l.all_score,l.comment_count,l.linetitle,l.lineprice,l.satisfyscore,l.features,l.comment_score,l.bookcount AS sales,l.transport,l.lineday,l.hotel_start";
		$sql.=" FROM u_line AS l  WHERE l.status = 2 ";
// 			$sql.="  INNER JOIN ( SELECT l.id  FROM u_line AS l  " .$join;//.$join;
// 			$sql.=" WHERE $whereStr"; //
// 			$sql.=" GROUP BY l.id ORDER BY ".$orderBy.' '.$limitStr." )va ON l.id=va.id ";
		$sql.="  ";
		if(!empty($lineIds)){
			$idx=0;
			foreach($lineIds as $key =>$val){
				if($idx>0){
					$sql.=" OR ";
				}
				$sql.=" l.id=".$val["id"];
				$idx++;
			}
		}else{
			//为空的时候
			$sql = $sql.' l.id=-1 ';
		}
// 		$sql = $sql.' LIMIT 10 ';
// 		echo $sql;
		$data['list'] = $this ->db ->query($sql) ->result_array();
		return  $data;

	}
	/**
	 * @abstract: 新版线路搜索【使用sphinx全文搜索】
	 * @param:  $whereArr=array(
				'status'=>'2',  //线路状态
				'producttype'=>'0',  //线路类型
				'linename'=>'',  //线路名称（模糊搜索内容）
				'overcity'=>array('10328','10342'),  //目的地
				'linetype'=>array('158','193'),  //线路标签
				'expert_ids'=>array('1'),   //管家
				'startplace_ids'=>array('391'),   //出发城市
				'min_price'=>'2.1', //最低价格
				'max_price'=>'1000.2', //最高价格
				'themeid'=>$themeid,  //主题id  情况一:$themeid值是一整形值，表示>$themeid；情况二:$themeid是数组，表示=$themeid数组里的值
				'lineday'=>array('min'=>$min,'max'=>$max)   //天数,范围值：$min是最小天数，$max是最大天数
		);
	 *
	 * @param: $page=当前页
	 * @param: $num=每页显示记录数
	 * @param: $orderBy=排序,如  $orderBy = 'addtime desc';  或者 $orderBy="addtime desc,status asc,producttype asc";
	 * */
	public function line_list_sphinx($whereArr,$page = 1, $num = 10 ,$orderBy = 'displayorder asc')
	{
		//var_dump($whereArr);
		$this->environment_sphinx();
		$s = new SphinxClient;
		$this->load->model ( 'common/cfg_web_model','cfg_web_model');
		$data=$this->cfg_web_model->row(array('id'=>'1'));
		$s->setServer($data['serverIp'], 9312);
		//设置
		$s->setMatchMode(SPH_MATCH_ALL);
		$s->setMaxQueryTime(30);
		//where条件
		if(isset($whereArr['status']))
		{
			$where_status[]=$whereArr['status'];
			$s->SetFilter("status",$where_status);  //对应 sql_attr_uint 配置 ，条件是字符串
		}
		if(isset($whereArr['line_kind']))
		{
			$where_line_kind[]=$whereArr['line_kind'];
			$s->SetFilter("line_kind",$where_line_kind);  //对应 sql_attr_uint 配置 ，条件是整形；line_kind为1是长短线路，为2是单项
		}
		if(isset($whereArr['producttype']))
		{
			$where_producttype[]=$whereArr['producttype'];
			$s->SetFilter("producttype",$where_producttype);  //对应 sql_attr_uint 配置，条件是字符串
		}
		if(isset($whereArr['themeid']))
		{
			if(is_array($whereArr['themeid']))
			{
				$s->SetFilter("themeid",$whereArr['themeid']); //对应 sql_attr_uint 配置，条件是字符串
			}
			else
			{
				$s->SetFilterRange("themeid",$whereArr['themeid'],10000);
			}

		}
		if(isset($whereArr['lineday']['min'])&&isset($whereArr['lineday']['max']))
		{
			$s->SetFilterRange("lineday",$whereArr['lineday']['min'],$whereArr['lineday']['max']); //对应 sql_attr_uint 配置，条件是字符串
		}
		if(isset($whereArr['overcity']))
		{
			if(!empty($whereArr['overcity']))
			$s->SetFilter("overcity",$whereArr['overcity']);  //类似find_in_set  对应 sql_attr_multi 配置   ,条件是数组
		}
		if(isset($whereArr['linetype']))
		{
			if(!empty($whereArr['linetype']))
				$s->SetFilter("linetype",$whereArr['linetype']);  //类似find_in_set  对应 sql_attr_multi 配置   ,条件是数组
		}
		if(isset($whereArr['expert_ids']))
		{
			if(!empty($whereArr['expert_ids']))
				$s->SetFilter("expert_ids",$whereArr['expert_ids']);  //类似find_in_set  对应 sql_attr_multi 配置   ,条件是数组
		}
		if(isset($whereArr['startplace_ids']))
		{
			if(!empty($whereArr['startplace_ids']))
				$s->SetFilter("startplace_ids",$whereArr['startplace_ids']);  //类似find_in_set  对应 sql_attr_multi 配置   ,条件是数组
		}
		if(isset($whereArr['min_price'])&&isset($whereArr['max_price']))
		{
				$s->SetFilterFloatRange("lineprice",$whereArr['min_price'],$whereArr['max_price']);  //最低价、最高价
		}
		$content="";
		if(isset($whereArr['linename']))
		{
			if(!empty($whereArr['linename']))
				$content=$whereArr['linename'];   // 模糊搜索
			else
				$content="";
		}

		//分页
		$from=($page-1) * $num;
		$s->SetLimits($from,$num,50000); //0-9条   5000是设置控制搜索过程中 searchd 在内存中所保持的匹配项数目
		$s->SetSortMode(SPH_SORT_EXTENDED,$orderBy);
		$res = $s->query($content,'*');//$content="古迹遗址";
		$ids=array();
		if(!empty($res['matches']))
			$ids = array_keys($res['matches']);
		$str=join(",",$ids);
		$orderBy_arr="(l.id,".$str.")";

		//总记录数，用于分页
		$s->SetLimits(0,20000,50000);
		$total_result = $s->query($content,'*');//$content="古迹遗址";
		$total_ids=array();
		if(!empty($total_result['matches']))
			$total_ids = array_keys($total_result['matches']);
		$total_rows=count($total_ids);
		//var_dump($total_rows);

		if(!empty($ids)) //若全文检索结果为空
		{
		$data['list']=$this->db->query("select l.id AS lineid,l.linename,l.mainpic,l.overcity,l.peoplecount,l.all_score,l.comment_count,l.linetitle,l.lineprice,l.satisfyscore,l.features,l.comment_score,l.bookcount AS sales,l.transport,l.lineday,l.hotel_start,la.sati_vr from u_line as l left join u_line_affiliated as la on la.line_id= l.id where l.id in ({$str}) order by FIELD {$orderBy_arr}")->result_array();
		$data['count']=$total_rows;
		}
		else
		{
			$data['list']=array();
			$data['count']="0";
		}
		//var_dump($data);
		return $data;
	}
	/**
	 * 搜索线路接口
	 */
	public function get_line_list($where,$order_by,$from,$page_size){
		$sql = "SELECT l.id,l.linename,l.linetitle,l.mainpic,l.lineprice,ceil(l.satisfyscore* 100) as satisfyscore,l.comment_count as comments,l.peoplecount as bookcount,(SELECT	COUNT(*) FROM u_member_order AS mo WHERE l.id = mo.productautoid AND mo. STATUS > 4 ) AS volume FROM u_line AS l WHERE l. STATUS = 2 {$where}{$order_by} LIMIT {$from},{$page_size}";
		$query = $this->db->query ( $sql );
		$data['line_list']= $query->result_array ();
		return $data['line_list'];
	}
		/**
	 * 查询总记录数
	 */
	public function get_line_list_total_rows($where,$order_by){
		$sql = "select count(*) as cont FROM (SELECT l.id,l.linename,l.linetitle,l.mainpic,l.lineprice,l.satisfyscore,(SELECT COUNT(*) FROM u_comment AS c WHERE c.line_id = l.id ) AS comments,(SELECT	SUM(mo.dingnum + mo.childnum+mo.childnobednum+mo.oldnum) FROM u_member_order AS mo WHERE	l.id = mo.productautoid AND mo. STATUS > 4) AS people,(SELECT	COUNT(*) FROM u_member_order AS mo WHERE l.id = mo.productautoid AND mo. STATUS > 4 ) AS volume FROM u_line AS l WHERE l. STATUS = 2  {$where}{$order_by} ) temp";
		$query = $this->db->query ( $sql );
		$result = $query->result_array ();
		return $result;
	}

/*
*
*        do     add order
*
*        by     zhy
*
*        at     2015年12月30日 15:30:04
*
*/
	public function add_order_expert($ll_id,$ee_id){
		$sql = "select e.realname AS expert_name,e.expert_type,l.supplier_id,s.company_name AS supplier_name,l.linename AS productname,l.mainpic AS litpic from u_line AS l left join u_line_apply AS la on la.line_id=l.id left join u_expert AS e on e.id=la.expert_id left join u_supplier AS s on s.id=l.supplier_id where e.id={$ee_id} and l.id={$ll_id}";
		$query = $this->db->query ( $sql );
		$info = $query->result_array ();
		return ($info);
	}
/*
*
*        do     add order 		rate
*
*        by     zhy
*
*        at     2015年12月30日 15:32:00
*
*/
	public function add_order_agent_rate($ll_id){
		$sql = "select agent_rate from u_line where id = {$ll_id}";
		$query = $this->db->query ( $sql );
		$agent_rate = $query->result_array ();
		return ($agent_rate);
	}
/*
*
*        do     add order 				othen
*
*        by     zhy
*
*        at     2015年12月30日 15:32:51
*
*/
	public function add_order_info($ll_id,$ee_id){
		$sql = "select e.realname AS expert_name,l.supplier_id,s.company_name AS supplier_name,l.linename AS productname,l.mainpic AS litpic from u_line AS l left join u_line_apply AS la on la.line_id=l.id left join u_expert AS e on e.id=la.expert_id left join u_supplier AS s on s.id=l.supplier_id where e.id={$ee_id} and l.id={$ll_id}";
		$query = $this->db->query ( $sql );
		$info = $query->result_array ();
		return ($info);
	}
	
	/*
	 * @method 添加线路价格 开放平台接口 api
	 * @param lineArr 
	 * @author xml 
	 * 
	 */


}