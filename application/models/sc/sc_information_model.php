<?php
/*
*
*        do     one     sql     one     model
*
*        by     zhy
*
*        at     2016年2月18日 15:13:16
*
*/
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sc_information_model extends MY_Model {


    function __construct() {
        parent::__construct();
    }
/*
*
*        do     show_information_tip
*
*        by     zhy
*
*        at     2016年2月22日 15:22:59
*
*/
    function show_information_tip(){

        $sql = " SELECT id,`name` as attrname FROM `sc_index_category` ORDER BY showorder       limit 8  ";
    	return $this ->db ->query($sql) ->result_array();
    }

/*
*
*        do     quality		line
*
*        by     zhy
*
*        at     2016年2月22日 15:22:59
*
*/
    function show_information_content($loca,$offset="",$page=""){

		if(empty($loca)){	$loca='';}

        $sql = "    SELECT c.id,c.title ,c.pic ,c.content_paper,c.addtime,   c.shownum ,c.praisetnum ,sc.sc_index_category_id    FROM `sc_index_category_consult` sc     LEFT JOIN `u_consult` AS c ON sc.consult_id=c.id    {$loca}	ORDER BY showorder";
        if(!empty($page)&&$page!="0")
        	$sql.=" LIMIt {$offset},{$page}";

        return $this ->db ->query($sql) ->result_array();
    }

    /**
     * 旅游曝光台列表
     * */
    function show_travel_article($where=array(),$offset="",$page=""){
    	$sql = "select * from sc_index_travel_article where is_show=1 order by showorder";
    	if(!empty($page)&&$page!="0")
    		$sql.=" LIMIt {$offset},{$page}";

    	return $this ->db ->query($sql) ->result_array();
    }
    /**
     * 旅游曝光台详情
     * */
    function travel_article_detail($id){
    	$sql = "select ta.*,td.content,a.realname from sc_index_travel_article as ta left join sc_travel_article_detail as td on ta.id=td.sc_index_travel_article_id left join u_admin as a on ta.admin_id=a.id where ta.is_show=1 and ta.id={$id}";
    	$sql = $this ->db ->escape_str($sql);
    	return $this ->db ->query($sql) ->row_array();
    }



	function show_hot_tok($loca){
	    if(    empty($loca  )){    $where='' ;   }else{     $where="  FIND_IN_SET({$loca},l.overcity)>0 AND  ";   }
	$sql="	SELECT 	l.id,l.linename,l.linetitle,l.lineprice,l.marketprice,l.saveprice,l.collectnum,l.comment_count,l.mainpic,l.overcity	 FROM u_line AS l
	WHERE  {$where} l.status=2
	ORDER BY l.peoplecount limit 3";
	return $this ->db ->query($sql) ->result_array();
	}

	function get_destname($dest_id)
	{
		$sql="select id,kindname from u_dest_base where id={$dest_id}";
		return $this ->db ->query($sql) ->row_array();
	}

	function show_guess_line(){
		$sql="SELECT
	l.id,l.mainpic ,l.linename ,l.linetitle ,
	l.lineprice ,l.marketprice ,l.saveprice ,l.overcity
	FROM `sc_index_recommend_line` AS sl
	LEFT JOIN u_line AS l ON sl.line_id=l.id
	WHERE sl.status=1
	ORDER BY showorder limit 6 ";
		return $this ->db ->query($sql) ->result_array();
	}

	function show_im_list($loca){
	    $sql="	SELECT id,title ,pic ,content ,shownum ,praisetnum ,article_attr_id,user_name,`addtime`,dest_id as dest FROM `u_consult` where id ={$loca}";
	    return $this ->db ->query($sql) ->row_array();
	}
	function consult_zan($where=array(),$data=array())
	{
		$sql="update u_consult set praisetnum=".$data['praisetnum']." where id=".$where['id'];
		return $this ->db ->query($sql);
	}
	function consult_read($where=array(),$data=array())
	{
		$sql="update u_consult set shownum=".$data['shownum']." where id=".$where['id'];
		return $this ->db ->query($sql);
	}


}