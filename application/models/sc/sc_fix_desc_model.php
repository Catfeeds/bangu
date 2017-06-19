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

class Sc_fix_desc_model extends MY_Model {


    function __construct() {
        parent::__construct();
    }
/*
*
*        do     advertising
*
*        by     zhy
*
*        at     2016年2月18日 15:16:20
*
*/
    function show_desc($loca){
        $sql = "  select pic,link from sc_fix_desc where location='{$loca}'  ORDER BY showorder limit 1        ";
    	return $this ->db ->query($sql) ->row_array();
    }
    
/*
*
*        do     nav
*
*        by     zhy
*
*        at     2016年2月18日 15:28:02
*
*/
    function show_nav(){
        $sql = " select name,link from sc_index_nav where is_show=1  ORDER BY showorder limit 6      ";
        return $this ->db ->query($sql) ->result_array();
    }
 /*
 *
 *        do    public      left
 *
 *        by     zhy
 *
 *        at     2016年2月18日 15:32:02
 *
 */
 function show_left($loca){
     $sql = " select name,dest_id from cfg_index_kind_dest where is_show=1  and index_kind_id = '{$loca}' limit 4     ";
     return $this ->db ->query($sql) ->result_array();
 }
 /*
  *
  *        do       theme
  *
  *        by     zhy
  *
  *        at     2016年2月18日 15:32:02
  *
  */
 function show_theme(){
     $sql = " select name,index_kind_id from cfg_index_kind_theme where is_show=1  and index_kind_id = 3 ORDER BY showorder limit 4    ";
     return $this ->db ->query($sql) ->result_array();
 }

 /*
  *
  *        do       grade
  *
  *        by     zhy
  *
  *        at     2016年2月18日 15:32:02
  *
  */
 function show_grade(){
     $sql = "select id,title from u_expert_grade limit 4    ";
     return $this ->db ->query($sql) ->result_array();
 }
 /*
  *
  *        do     article
  *
  *        by     zhy
  *
  *        at     2016年2月18日 15:32:02
  *
  */
 function show_article($loca){
     if($loca=='2'){
         $sql = "SELECT a.id,a.title FROM sc_consult as c LEFT JOIN u_consult as a on c.consult_id=a.id ORDER BY c.showorder  limit 2,8  ";
         return $this ->db ->query($sql) ->result_array();
     }elseif($loca=='1'){
         $sql = "SELECT a.id,a.title FROM sc_consult as c LEFT JOIN u_consult as a on c.consult_id=a.id ORDER BY c.showorder  limit 1 ";
         return $this ->db ->query($sql) ->row_array();
     } 
 }
/*
*
*        do     show_centre
*
*        by     zhy
*
*        at     2016年2月18日 15:54:35
*
*/
 function show_centre($loca){
     $sql = "select name,dest_id from cfg_index_kind_dest where is_show=1  and index_kind_id = {$loca}  ORDER BY showorder  limit 9  ";
     return $this ->db ->query($sql) ->result_array();
 }
 /*
 *
 *        do    zt
 *
 *        by     zhy
 *
 *        at        2016年2月18日 16:04:12
 *
 */
 function show_centre_zt($loca){
     $sql = " select name,dest_id from cfg_index_kind_dest where is_show=1 and index_kind_id = '3' ORDER BY showorder limit 9  ";
     return $this ->db ->query($sql) ->result_array();
 }
/*
*
*        do     expert
*
*        by     zhy
*
*        at     2016年2月18日 16:09:50
*
*/
function show_expert($loca){
 
        $sql = "SELECT `e`.`id` as eid, `e`.`nickname`, e.sex,`e`.`talk`, (select GROUP_CONCAT(kindname) from u_dest_base where FIND_IN_SET(id,substring_index(e.expert_dest,',',4)) >0 )as end , (select GROUP_CONCAT(name) from u_area where FIND_IN_SET(id,substring_index(e.visit_service,',',4)	) >0 )as door , `a`.`name` as cityname, `ie`.`smallpic`, `ie`.`pic`, CASE WHEN e.grade=1 THEN '管家'  WHEN	e.grade=2 THEN '初级管家'  WHEN e.grade=3 THEN '中级管家' WHEN	e.grade=4 THEN '高级管家' END grade	FROM (`cfg_index_expert` as ie)  LEFT JOIN `u_expert` as e ON `ie`.`expert_id` = `e`.`id` LEFT JOIN `u_area` as a ON `a`.`id` = `ie`.`startplaceid` WHERE `ie`.`is_show` = 1 AND `ie`.`location` = 1 AND `e`.`status` = 2 AND `ie`.`startplaceid` = '235' ORDER BY `ie`.`showorder` asc LIMIT {$loca}  ";
      return $this ->db ->query($sql) ->result_array();
     
}
/*
 *
 *        do    product
 *
 *        by     zhy
 *
 *        at        2016年2月18日 16:04:12
 *
 */
function show_product($tip,$limit){
    $sql = " SELECT 
  u.id AS lineid,
  linename,
  lineprice,
  mainpic,
  linetitle,
  RIGHT(overcity, 1) AS inou,
  overcity,
  marketprice 
FROM
sc_activity_dest_line AS dl
  LEFT JOIN   sc_activity_dest AS d 
    ON d.id = dl.sc_activity_dest_id 
  LEFT JOIN u_line AS u 
    ON dl.line_id = u.id 
WHERE 
d.index_kind_id = {$tip}
  AND u.status = 2 
  and d.status=1
  order by dl.showorder
LIMIT {$limit}
";
    return $this ->db ->query($sql) ->result_array();
}


/*
*
*        do     show_product_s
*
*        by     zhy
*
*        at
*
*/
function show_product_1($loca){
    $sql = " select u.id as lineid,linename,lineprice,mainpic,linetitle, right(overcity , 1) as inou   ,overcity,marketprice from sc_index_dest_line as s LEFT JOIN u_line as u  on s.line_id= u.id where    SUBSTRING(s.dest_id,1,6) in ( 10388,10434,10542,10436,10437,10438,10439,10440,10441,10442) and u.status = 2 	limit {$loca}";
    return $this ->db ->query($sql) ->result_array();
}
/*
 *
 *        do     show_product_s
 *
 *        by     zhy
 *
 *        at
 *
 */
function show_product_2($loca){
    $sql = " select u.id as lineid,linename,lineprice,mainpic,linetitle, right(overcity , 1) as inou   ,overcity,marketprice from 	sc_index_theme_line as t LEFT JOIN  u_line as u    on u.id = t.line_id where t.is_show=1  and u.status = 2 ORDER BY showorder  limit {$loca}";
    return $this ->db ->query($sql) ->result_array();
}
/*
*
*        do     jw_consult
*
*        by     zhy
*
*        at     2016年2月18日 16:29:32
*
*/
function jw_consult($loca,$tip,$limit){
    if ($loca=='2'){
        $sql = " SELECT u.title ,u.id,u.theme_id FROM sc_consult as c LEFT JOIN u_consult AS u ON c.consult_id=u.id  where c.is_show=1 and SUBSTRING(u.dest_id,7,1)={$tip} limit {$limit}";
        return $this ->db ->query($sql) ->result_array();
    }elseif($loca='1'){
        $sql = " SELECT u.title ,u.id,u.theme_id,u.content FROM sc_consult as c LEFT JOIN u_consult AS u ON c.consult_id=u.id  where c.is_show=1 and SUBSTRING(u.dest_id,7,1)={$tip} limit {$limit}";
        return $this ->db ->query($sql) ->row_array();
    }
}
/*
*
*        do
*
*        by     zhy
*
*        at     2016年2月18日 16:43:29
*
*/      
function zt_consult($loca,$limit){
 
    if ($loca=='2'){
        $sql = " SELECT u.title ,u.id,u.theme_id FROM sc_consult as c LEFT JOIN u_consult AS u ON c.consult_id=u.id  where c.is_show=1 and u.theme_id  is not null  limit {$limit}";
        return $this ->db ->query($sql) ->result_array();
    }elseif($loca=='1'){
        $sql = " SELECT u.title ,u.id,u.theme_id,u.content  FROM sc_consult as c LEFT JOIN u_consult AS u ON c.consult_id=u.id  where c.is_show=1 and u.theme_id  is not null  limit {$limit}";
        return $this ->db ->query($sql) ->row_array();
    }
}
/*
 *
 *        do
 *
 *        by     zhy
 *
 *        at     2016年2月18日 16:43:29
 *
 */
 function zb_consult($loca,$limit){
     if ($loca=='2'){
         $sql = " SELECT u.title ,u.id,u.theme_id FROM sc_consult as c LEFT JOIN u_consult AS u ON c.consult_id=u.id  where c.is_show=1 and SUBSTRING(u.dest_id,1,6)	in ( 10388,10434,10542,10436,10437,10438,10439,10440,10441,10442  )	 limit {$limit}";
         return $this ->db ->query($sql) ->result_array();
     }elseif($loca=='1'){
         $sql = " SELECT u.title ,u.id,u.theme_id,u.content FROM sc_consult as c LEFT JOIN u_consult AS u ON c.consult_id=u.id  where c.is_show=1 and SUBSTRING(u.dest_id,1,6)	in ( 10388,10434,10542,10436,10437,10438,10439,10440,10441,10442  )	 limit {$limit}";
         return $this ->db ->query($sql) ->row_array();
     }
 }
 /*
 *
 *        do        last
 *
 *        by     zhy
 *
 *        at       2016年2月18日 16:56:28
 *
 */
 function  show_problem($loca){
     
     $sql = "SELECT id,title FROM `sc_common_problem`  WHERE index_kind_id={$loca} and is_show=1 order by showorder  limit 6 ";
     return $this ->db ->query($sql) ->result_array();
     
 }

}