<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>tltle</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        *{ margin: 0; padding: 0 ; font-family:"Microsoft YaHei"; font-size: 12px;}
        body{ background: #fff; }
        i{ font-style: normal; }
        .RongBox{ width:100%; background: #fff;}
        .flex10{ width: 100%; position: relative;height: 40px; line-height: 40px; border-bottom: 1px solid #f1f1f1; border-right: 1px solid #f1f1f1; box-sizing:border-box }
        .flex5{ width: 50%; position: relative;height: 40px; line-height: 40px; float: left; border-right: 1px solid #f1f1f1; box-sizing:border-box}
        .ListTitle{ width:90px; text-align: right; height: 40px; line-height: 40px; padding-right: 10px; border-right: 1px solid #f1f1f1;}
        .ListTitle i{ color: #f30; }
        .ListSub{ position: absolute; top: 5px; bottom: 5px; right: 0; left: 110px;line-height: 30px; }
        .ListSub label{ margin-right: 10px; }
        .ListInput{ float: left; }
        .ListInput input{ height: 24px; line-height: 24px; border: 1px solid #ccc; width:180px; }
        .ListTip{ display: inline-block; height: 30px; line-height: 30px; float: left; margin-left: 10px; }
        .borNone { border-right: none }
        .imagexPot{width: 200px;position: relative;z-index: 10;display: none;top: 34px;left: -46px;}
        .sizeConsInput{ margin-right: 10px; float: left; }
        .sizeConsInput input{ height: 24px; line-height: 24px; display: inline-block; width: 80px; }
        .FangFile{ height: 30px; line-height: 30px; position: relative; cursor: pointer;float: left; }
        .FangFile input{ position: absolute; top: 0; left: 0; right: 0 ; bottom:0; opacity: 0 }
        .FangFile .textFile{ height: 28px; line-height: 28px; padding: 0 10px; border: 1px solid #ccc; float: left; border-radius: 3px; cursor: pointer; }
        .btnBoix{  text-align: center; padding: 50px; }
        .Ybuoon, .Nbuoon { display: inline-block; margin: 0 20px; }
        .Ybuoon input{ height: 28px; line-height: 28px; width: 100px; background: #3176b1; color: #fff; border: none; border: 1px solid #ccc; border-radius: 3px; }
        .Nbuoon input{ height: 28px; line-height: 28px; width: 100px; background: #fff; border: none; border: 1px solid #ccc; border-radius: 3px;}
        .selectedContent{padding:4px;cursor: pointer;}
    </style>
</head>
<body>
    <div class="RongBox">
    	<form action="" id="up-dest">
        <div class="RongCon">
          <div class="flex10">
                <div class="ListTitle">产品类型</div>
                <div class="ListSub">
                    <div class="ListInput">
                    	    <?php if(!empty($line['line_classify'])){?>
                                   <?php  if($line['line_classify']=="1"){ ?>
                                           境外游
                                   <?php  }else if($line['line_classify']=="2"){ ?>
                                           国内游
                                   <?php }else if($line['line_classify']=="3"){  ?>
                                           周边游
                                   <?php  }else{?>
                                           国内游
                                   <?php } ?>
      
                                   <?php  }else{ 
                                          $line_overcity=explode(',', $line['overcity']);
                                          if(in_array("2", $line_overcity)){
                                                 echo " 境外游";
                                          }else{
                                                echo "国内游";
                                          }	
                           } ?>
                    </div>
                </div>
            </div>
            <div class="flex10">
                <div class="ListTitle">产品编号</div>
                <div class="ListSub">
                    <div class="ListInput">
                    	<?php  if(!empty($line['linecode'])){ echo $line['linecode'];} ?>
                    </div>
                </div>
            </div>
            <div class="flex10">
                <div class="ListTitle">产品名称</div>
                <div class="ListSub">
                    <?php  if(!empty($line['linename'])){ echo $line['linename'];} ?>
                </div>
            </div>
            <div class="flex10">          
                  <div class="ListTitle">供应商</div>
                  <div class="ListSub">
                         <?php  if(!empty($line['realname'])){ echo $line['realname'];} ?>/<?php  if(!empty($line['mobile'])){ echo $line['mobile'];} ?>
                  </div> 
            </div>
            <div class="flex10">          
                  <div class="ListTitle">状态</div>
                  <div class="ListSub">
                       <?php if(isset($line['status'])){
                       	   if($line['status']==0){
                       	   	    echo '未提交';
                       	   }else if($line['status']==1){
                       	   	    echo '审核中';
                       	   }else if($line['status']==2){
								echo '已上线';	
                       	   }else if($line['status']==3){
                       	   		echo '审核拒绝';
                       	   }else if($line['status']==4){
                       	   		echo '已停售';
                       	   } else if($line['status']=='-1'){
                       	   		echo '已删除';
                       	   }else{
                       	   	    echo $line['status'];
                         }
                       	   
                       } ?>
                  </div> 
            </div>
            <div class="flex10">    
                  <div class="ListTitle">出发地</div>
                  <div class="ListSub">
                        <?php if(!empty($startcity)){
                        	 foreach ($startcity as $k=>$v){
									echo $v['cityname']."&nbsp;&nbsp;";
                        	 }
                        } ?>
                  </div>
            </div>

            <div class="flex10" style="height:auto;">
                <div class="ListTitle">目的地</div>
                <div class="ListSub">
                    <div class="ListInput">
                    
                       	    <?php if(!empty($line['line_classify'])){?>
                                   <?php  if($line['line_classify']=="1"){ ?>
                                          <input type="text" id="overcity" name="overcity" onfocus="showCJDestTree(this);">
                                   <?php  }else if($line['line_classify']=="2"){ ?>
                                          <input type="text" id="overcity" name="overcity" onfocus="showGNDestTree(this);">
                                   <?php }else if($line['line_classify']=="3"){  ?>
                                          <input type="text" id="overcity" name="overcity" onfocus="showGNDestTree(this);">
                                   <?php  }else{?>
                                           <input type="text" id="overcity" name="overcity" onfocus="showGNDestTree(this);">
                                   <?php } ?>
      
                                   <?php  }else{ 
                                          $line_overcity=explode(',', $line['overcity']);
                                          if(in_array("2", $line_overcity)){
                                               echo '<input type="text" id="overcity" name="overcity" onfocus="showCJDestTree(this);">' ;
                                          }else{
                                                echo ' <input type="text" id="overcity" name="overcity" onfocus="showGNDestTree(this);">';
                                          }	
                           } ?>
                           
                        
                          <input type="hidden" id="overcitystr" name="overcitystr" value="<?php echo $line['overcity2']; ?>" />  
                    </div>
                  
                     <div id="ds-list" style="width:540px;float:left;margin:0px 0px 4px 8px;position:relative;"> 
	                     <?php if(!empty($dest)){
	                         foreach ($dest as $k=>$v){
	                     ?>
	                     	<span class="selectedContent" value="<?php echo $v['id']; ?>">
	                            	<?php echo $v['kindname']; ?><input name="overcity[]" value="<?php echo $v['id']; ?>" type="hidden">
	                            	<span class="delPlugin" onclick="delPlugin(this ,'overcitystr' ,'ds-list');">×</span>
	                            </span>	
	                     <?php }}?>                 									
       
                     </div>
                </div>
            </div>
        </div>
        <div class="btnBoix">
        	<input type="hidden" name="line_id" value="<?php echo $line['line_id']; ?>">
            <div class="Ybuoon"><input type="button" onclick="update_linedest()" value="确定"></div>
            <div class="Nbuoon" onclick="t33_close_iframe_noreload();"><input type="button" value="取消"></div>
        </div>
        </form>
    </div>

<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script src="<?php echo base_url() ;?>assets/js/admin/pinyin.js"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>
<?php $this->load->view("admin/common/tree_view"); //加载树形目的地   ?>
<script>

//编辑目的地
function callbackTree(data_id,v){
 	$('#overcity').val('');
	//选目的地
	var valObj=$("#overcitystr");
	var ids = valObj.val();
	var idArr = ids.split(",");
	var s = true;
	/* $.each(idArr ,function(key ,val) {
		if (data_id == val) {
			alert("此选项你已选择");
			s = false;
		}
	}) */
	if (s == false) {
		return false;
	} 

	ids += data_id+',';
	valObj.val(ids); 
	
	var valId="overcitystr";
	var buttonId="ds-list";
	var html = '<span class="selectedContent" value="'+data_id+'">'+v+'<input type="hidden" name="overcity[]" value="'+data_id+'"><span onclick="delPlugin(this ,\''+valId+'\' ,\''+buttonId+'\');" class="delPlugin">×</span></span>';
	$('#ds-list').append(html);
	$('#ds-list').css('display','block');
		
}

function delPlugin(obj ,valId ,buttonId) {
	var valObj = $("#"+valId);
	var buttonObj = $("#"+buttonId);
	var id = $(obj).parent("span").attr("value");
	var ids = valObj.val();
	valObj.val(ids.replace(id+',',''));
	$(obj).parent("span").remove();
	if (buttonObj.children("span").length == 0) {
		buttonObj.html('');
		buttonObj.hide();
	}
}

//提交修改数据
function update_linedest(){

	jQuery.ajax({ type : "POST",async:false,data : jQuery('#up-dest').serialize(),url : "<?php echo base_url()?>admin/a/basics/line_dest/update_line_dest", 
		success : function(response) {
			var obj = eval('(' + response + ')');
			if(obj.status==1){
				 layer.msg(obj.msg, {icon: 1});
				 $('.search_button').click();
			}else{
				 layer.msg(obj.msg, {icon: 2});
			}
		}
	 });
}


</script>
</body>
</html>
