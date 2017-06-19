
<script type="text/javascript">
/*------------------------------------------------出发城市-------------------------------------------------------*/
var citysFlight=new Array();
<?php if(!empty($user_shop)){
	foreach ($user_shop as $k=>$v){
?>
     citysFlight[<?php echo $v['id'];?>]=new Array('<?php echo $v['id'];?>','<?php echo $v['cityname']; ?>','<?php echo $v['enname']; ?>','');
<?php } }?>
     
/*------------------------------------------------主题游------------------------------------------------------*/
 var themeFlight=new Array();
<?php if(!empty($theme)){
	foreach ($theme as $k=>$v){
?>
    themeFlight[<?php echo $v['id'];?>]=new Array('<?php echo $v['id'];?>','<?php echo $v['name']; ?>','','');
<?php } }?>
     
/*------------------------------------------------选择目的地-------------------------------------------------------*/

 var destination=new Array();
 <?php if(!empty($dest)){
 	foreach ($dest as $k=>$v):
 		foreach($v['two'] as $key=>$val):
 			foreach($val['three'] as $keyt=>$valt):
 ?>
  destination[<?php echo $valt['id'];?>]=new Array('<?php echo $valt['id'];?>','<?php echo $valt['kindname']; ?>','<?php if(!empty($val['twoname'])){ echo $val['twoname'];} ?>','<?php echo $valt['simplename']; ?>');
 <?php 
 	endforeach; 
 		endforeach;
 			endforeach;
 	 } 
  ?>
 /*------------------------------------------------线路属性----------------------------------------------------remove by yijinwen09-22- --*/	



</script>
