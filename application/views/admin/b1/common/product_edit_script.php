<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	/*未结算 */
	var pag=null;
  
	// 查询
	jQuery("#searchBtn").click(function(){
		initTab1()
		pag.load({"status":"0"});
	});
	var data1 = '<?php echo $pageData1; ?>';
	function initTab1(){
	pag=new jQuery.paging({renderTo:'#gift_list',record:jQuery.parseJSON(data1),url : "<?php echo base_url()?>admin/b1/product/giftData",form : '#listForm',// 绑定一个查询表单的ID
		columns : [{
					title : '',
					width : '30',
					align : 'center',		
					formatter : function(value,rowData, rowIndex) {
					     var orderIds= $('input[name="lineGiftListID"]').val();
						 var orderArr=new Array();
						 var html='';
						 if(orderIds !=''){
							   orderArr=orderIds.split(",");
						       if($.inArray(rowData.id,orderArr) ==-1){
						    	   html=' '; 
							   }else{
							    	 html='checked="checked" '; 
							   }             
					           return '<input name="luck_gift_id[]" type="checkbox" style="left:5px;opacity: 1;" '+html+' value="'+rowData.id+'" />';
						 }else{
							   return '<input name="luck_gift_id[]" type="checkbox" style="left:5px;opacity: 1;" '+html+' value="'+rowData.id+'" />';
						 } 
						//return '<input name="luck_gift_id[]" type="checkbox"  style="left:5px;opacity: 1;" value="'+rowData.id+'" />';
					}
		
			     },
				{field : 'gift_name',title : '礼品名称',width : '150',align : 'center'},
				{field : '',title : '图片',width : '150',align : 'center',
					formatter : function(value,	rowData, rowIndex){
						/* var vid=$('input[name="lineGiftListID"]').val();
						alert(vid); */
						return '<span><img style="max-width:40px;"  src="'+rowData.logo+'" /></span>';
					}
				},
				{ field : 'worth',title:'价值',width : '80',align : 'center'},	
				{field : '',title : '剩余数量',width : '80',align : 'center',
					formatter : function(value,	rowData, rowIndex){
						return '<span id="account'+rowData.id+'">'+rowData.account+'</span>';
					}
				},
				{field : 'starttime',title : '开始日期',align : 'center',sortable : true,width : '150'},
				{field : 'endtime',title : '结束日期',align : 'center',sortable : true,width : '150'},
				{field : '',title : '状态',align : 'center', width : '150',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.status==0){
							return '上架';
						}else if(rowData.status==1){
							return '下架';				
						}
					}
				},
				{field : '',title : '数量',align : 'center',sortable : true,width : '100',
					formatter : function(value,	rowData, rowIndex){
						var val=$('input[name="lineGiftListMun['+rowData.id+']"]').val()
						if(typeof(val)=='undefined'){
							val='';
						}
                        return '<input type="text" name="gift_num['+rowData.id+']" value="'+val+'" style="width: 60px;height: 28px;" />';
					}
			     }
			]
	});
	}
		
});
/****************************抽奖礼品********************************/
/*线路的抽奖礼品*/
$('#starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:true, //是否显示小时
	format:'Y-m-d H:i', //选中显示的日期格式
	formatDate:'Y-m-d H:i',
});
$('#endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:true, //是否显示小时
	format:'Y-m-d H:i', //选中显示的日期格式
	formatDate:'Y-m-d H:i',
}); 

$('#addgift').click(function(){
	$('.gift_biaoti').html('添加礼品');
	$('#giftFrom').find('input[name="gift_id"]').val('');
    $('#giftFrom').find('input[name="gift_name"]').val('');
    $('#giftFrom').find('input[name="startdatetime"]').val('');
    $('#giftFrom').find('input[name="enddatetime"]').val('');
    $('#giftFrom').find('input[name="account"]').val('');
    $('#giftFrom').find('input[name="worth"]').val('');
    $('#giftFrom').find('input[name="logo"]').val('');
    $('#giftFrom').find("img").attr("src",'');
    $('#giftFrom').find('textarea[name="description"]').val('');
    
	$('.lp_div').show();  
 })
 
//礼品的新增
$('#gift_button').click(function(){
   var gift_name= $('#giftFrom').find('input[name="gift_name"]').val();
   var starttime= $('#giftFrom').find('input[name="startdatetime"]').val();
   var endtime= $('#giftFrom').find('input[name="enddatetime"]').val();
   var account= $('#giftFrom').find('input[name="account"]').val();
   var add_account= $('#giftFrom').find('input[name="add_account"]').val();
   var worth= $('#giftFrom').find('input[name="worth"]').val();
   var  logo=$('#giftFrom').find('input[name="logo"]').val();
   var description=$('#giftFrom').find('textarea[name="description"]').val(); 
   if(gift_name==''){
	   alert('礼品名称不能为空!');
	   return false;
   }
   if(starttime=='' && endtime==''){
	   alert('有效日期不能为空!');
	   return false;
   }
   if(account==''){
	   alert('礼品的数量不能为空!');
	   return false;
   }
   if(worth==''){
	   alert('礼品的价值不能为空!');
	   return false;
   }
  var str='';
  var title='';
  title=title+'<tr role="row"><th style="width: 100px;text-align:center" >礼品名称</th>';
  title=title+'<th style="width: 80px;text-align:center" >有效期</th>';
  title=title+'<th style="width: 60px;text-align:center" >  图片 </th>';
  title=title+'<th style="width: 40px;text-align:center" > 数量 </th>';
  title=title+'<th style="width: 80px;text-align:center" > 价值</th>';
  title=title+'<th style="width: 60px;text-align:center" > 状态</th>';
  title=title+'<th style="width: 150px;text-align:center" > 操作 </th></tr>';   
		
   jQuery.ajax({ type : "POST",data : jQuery('#giftFrom').serialize(),url : "<?php echo base_url()?>admin/b1/product/addGift", 
		success : function(data) {
			 var data=eval("("+data+")");
			 if(data.status==1){  //添加礼品
				 alert(data.msg);	
 				 str=str+'<tr class="gift_tr'+data.id+'" id="delgift"> <td style="text-align:center" class="sorting_1"><input type="hidden" name="giftID[]" value="'+data.id+'"/>'+data.result.gift_name+'</td>'; 
				 str= str+'<td style="text-align:center" class="center">'+data.result.starttime+'至'+data.result.endtime+'</td>';  
				 str= str+'<td style="text-align:center"><img style="width:65px; height:65px;" src="'+data.result.logo+'"></td>'; 
				 str= str+'<td style="text-align:center"><input type="hidden" name="gift_num[]" value="'+add_account+'"/>'+add_account+'</td>'; 
				 str= str+'<td style="text-align:center">'+data.result.worth+'</td>'; 
				 str= str+'<td style="text-align:center">上架</td>'; 
				 str= str+'<td style="text-align:center" class="caozuo "><span class="look_gift" onclick="look_gift(this)"  data="'+data.id+'">查看</span> ';
				 str= str+'<span class="del_gift" data="'+data.id+'" onclick="del_gift(this);" >删除</span> </td></tr>'; 
				 var lineGiftListID=$('input[name="lineGiftListID"]').val();
				 var lineGiftnum=$('input[name="lineGiftnum"]').val();
				 if(lineGiftListID==''){
					 var vid= data.id;
    			  }else{
    				  var vid= lineGiftListID+','+data.id;
        	      }
				 var lineGiftnum=$('input[name="lineGiftListID"]').val(vid);
       	         $('#linelist_div').append('<input type="hidden" name="lineGiftListMun['+data.id+']" value="'+add_account+'"> ');
       	     	 $('.gift_text').find('#delgift').remove();
	       	 	 var hasClass=$('input[name="hasClass"]').val();
				 if(hasClass==''){
					 $('.gift_title').append(title);
					 $('input[name="hasClass"]').val(1);
				 }
				 $('#save_line_gift').show();
			     $('.gift_text').append(str);  
			 }else if(data.status==2){  //修改礼品 
				 /*alert(data.msg);
				   var gift_name= $('#giftFrom').find('input[name="gift_name"]').val();
				   var starttime= $('#giftFrom').find('input[name="startdatetime"]').val();
				   var endtime= $('#giftFrom').find('input[name="enddatetime"]').val();
				   var account= $('#giftFrom').find('input[name="account"]').val();
				   var worth= $('#giftFrom').find('input[name="worth"]').val();
				   var  logo=$('#giftFrom').find('input[name="logo"]').val();
				   var description=$('#giftFrom').find('textarea[name="description"]').val(); 
				   $('.gift_tr'+data.id).find('td').eq(0).html(gift_name);
				   $('.gift_tr'+data.id).find('td').eq(1).html(starttime+'至'+endtime);
				   $('.gift_tr'+data.id).find('td').eq(2).find('img').attr('src',logo);	
				   $('.gift_tr'+data.id).find('td').eq(3).html(account);
				   $('.gift_tr'+data.id).find('td').eq(4).html(worth);	 */		 
		     }else{
				 alert(data.msg);
			 }
			 
		}
	});

	$('.bootbox-close-button').click();
})
$('.bootbox-close-button').click(function(){
	$('.bootbox').hide();
	$('.lp_div').hide();
	$('.lookgfit_div').hide();
});
//编辑礼品
//$('.edit_gift').click(function(){
function edit_gift(obj){
	$('.gift_biaoti').html('编辑礼品');
	var id=$(obj).attr('data');
	var gift_id=$('#giftFrom').find('#gift_id').val(id);
	if(id>0){
		   jQuery.ajax({ type : "POST",data :"id="+id,url : "<?php echo base_url()?>admin/b1/product/editGift", 
				success : function(data) {
					 var data=eval("("+data+")");
					 if(data.status==1){	
						    $('#giftFrom').find('input[name="gift_name"]').val(data.gift.gift_name);
						    $('#giftFrom').find('input[name="startdatetime"]').val(data.gift.starttime);
						    $('#giftFrom').find('input[name="enddatetime"]').val(data.gift.endtime);
						    $('#giftFrom').find('input[name="account"]').val(data.gift.account);
						    $('#giftFrom').find('input[name="worth"]').val(data.gift.worth);
						    $('#giftFrom').find('input[name="logo"]').val(data.gift.logo);
						    $('#giftFrom').find("img").attr("src",data.gift.logo);
						    $('#giftFrom').find('textarea[name="description"]').val(data.gift.description); 
					 }else{
						 alert(data.msg);
					 }
				}
			});
		   $('.lp_div').show();
	}else{
	   alert('暂不能修改,请重新刷新页面;');	
	}
	
}

//查看礼品
function look_gift(obj){
	var id=$(obj).attr('data');
	if(id>0){
		   jQuery.ajax({ type : "POST",data :"id="+id,url : "<?php echo base_url()?>admin/b1/product/editGift", 
				success : function(data) {
					 var data=eval("("+data+")");
					 if(data.status==1){
						   $('#lookgiftFrom').find('.gift_div_1 span').html(data.gift.gift_name);
						   $('#lookgiftFrom').find('.gift_div_2 span').html(data.gift.starttime+'至'+data.gift.endtime);
						   $('#lookgiftFrom').find('.gift_div_3 span').html(data.gift.account+'张');	
						   $('#lookgiftFrom').find('.gift_div_4 span').html(data.gift.worth+'元');
						   $('#lookgiftFrom').find('.gift_div_5 ').html('<img style="width:170px;height:150px;" src="'+data.gift.logo+'">');
						   $('#lookgiftFrom').find('.gift_div_6 span').html(data.gift.description);	    
					 }else{
						 alert(data.msg);
					 }
				}
			});
		   $('.lookgfit_div').show();
	}else{
	   alert('暂不能查看,请重新刷新页面;');	
	}
	
}
//礼品的下架
function up_gift(obj){
	var str='';
	var id=$(obj).attr('data');
	var status=$(obj).attr('status');
	if(status==1){
		str="下架该产品？";
	}else{
		str="上架该产品？";
   }
	if(id>0){
		 if (!confirm(str)) {
	            window.event.returnValue = false;
	        }else{
	        	 jQuery.ajax({ type : "POST",data :"id="+id+'&status='+status,url : "<?php echo base_url()?>admin/b1/product/upGift", 
	        		 success : function(data) {
	        			 var data=eval("("+data+")");
	        			 alert(data.msg);
	        			 if(status==1){
	        				 $(obj).attr('status',0);
		        			 $('.gift_tr'+id).find('td').eq(5).html('下架');
		        			 $('.gift_tr'+id).find('.up_gift').html('上架');
		        		 }else if(status==0){
		        			 $(obj).attr('status',1);
		        			 $('.gift_tr'+id).find('td').eq(5).html('上架');
		        			 $('.gift_tr'+id).find('.up_gift').html('下架');
			        	}
						
		        	 }
	        	 })
		    }
	}else{
		alert('操作失败!');
	}
}
//删除礼品
function del_gift(obj){
	var id=$(obj).attr('data');
	if(id>0){
		 if (!confirm('删除该礼品')) {
	         window.event.returnValue = false;
	     }else{
        	 jQuery.ajax({ type : "POST",data :"id="+id,url : "<?php echo base_url()?>admin/b1/product/delLineGift", 
        		 success : function(data) {
        			 var data=eval("("+data+")");
        			  alert(data.msg);
        			  if(data.status==1){
	        			  
        				  $('.gift_tr'+id).remove();
	        		  }
	        	 }
        	 })
		}
	}else{
		//alert('操作失败!');
		 $('.gift_tr'+id).remove();
		 $(obj).parent().parent().parent().remove();
	}
}

//选择礼品
$('#selgift').click(function(){

    // 查询
    jQuery("#searchBtn").click();
	$(".bgsd,.tbtsd").show();	
	$('.messages_color').show();
});
//关闭礼品
$(".closetd,.close_gift").click(function(e) {
    $(".bgsd,.tbtsd").hide();
    $('.messages_color').hide();
});
//保存新增的礼品
function checkgift(){
	  var title='';
	  title=title+'<tr role="row" class="gift_row"><th style="width: 100px;text-align:center" >礼品名称</th>';
	  title=title+'<th style="width: 80px;text-align:center" >有效期</th>';
	  title=title+'<th style="width: 60px;text-align:center" >  图片 </th>';
	  title=title+'<th style="width: 40px;text-align:center" > 数量 </th>';
	  title=title+'<th style="width: 80px;text-align:center" > 价值</th>';
	  title=title+'<th style="width: 60px;text-align:center" > 状态</th>';
	  title=title+'<th style="width: 150px;text-align:center" > 操作 </th></tr>';
	  var flag=true;
	  var flag1=true; 
	  var flag2=false;  
	 $('input[name="luck_gift_id[]"]').each(function(){ 
		 var type  = jQuery(this).attr('checked');
		 if(type=='checked'){
		     flag2=true;  
			var id=jQuery(this).val(); 
			var value=$('input[name="gift_num['+id+']"]').val();
			var account=$('#account'+id).html();
			if(parseInt(value)>parseInt(account)){
				flag1=false;
			}
			
			if(value==''){
				flag=false;
			 }
		  }
	 })
	 if(flag2==false){
		 alert('请选择礼品');
		 return false;
	 }
	 if(flag1==false){
		 alert('剩余的礼品数量不够');
		 return false;
	 }
	 if(flag==false){
		 alert('请填写选中礼品的数量');
		 return false;
	 }  

	 jQuery.ajax({ type : "POST",data : jQuery('#supplier_gift').serialize(),url : "<?php echo base_url()?>admin/b1/product/save_gift", 
		success : function(data) {		
			var data = eval("("+data+")");
			var str='';
			if (data.status == 1) {
	
				 $.each(data.gift,function(n,value) {
					        // 
                        	 str=str+'<tr class="gift_tr'+value.glid+'" id="delgift"> <td style="text-align:center" class="sorting_1"><input type="hidden" name="giftID[]" value="'+value.id+'"/>'+value.gift_name+'</td>'; 
            				 str= str+'<td style="text-align:center" class="center">'+value.starttime+'至'+value.endtime+'</td>';  
            				 str= str+'<td style="text-align:center"><img style="width:65px; height:65px;" src="'+value.logo+'"></td>'; 
            				 str= str+'<td style="text-align:center"><input type="hidden" name="gift_num[]" value="'+data.gift_num[value.id]+'"/>'+data.gift_num[value.id]+'张</td>'; 
            				 str= str+'<td style="text-align:center">'+value.worth+'</td>'; 
            				 str= str+'<td style="text-align:center">上架</td>'; 
            				 str= str+'<td style="text-align:center" class="caozuo "><span class="look_gift" onclick="look_gift(this)"  data="'+value.id+'">查看</span>  ';
            				 str= str+'<span class="del_gift" data="'+value.glid+'" onclick="del_gift(this);" >删除</span> </td></tr>';
            				 var lineGiftListID=$('input[name="lineGiftListID"]').val();
            				 var lineGiftnum=$('input[name="lineGiftnum"]').val();
            				 if(lineGiftListID==''){
            					 var vid= value.id;
                			  }else{
                				  var vid= lineGiftListID+','+value.id;
                    	      }
            				 var lineGiftnum=$('input[name="lineGiftListID"]').val(vid);
                   	      $('#linelist_div').append('<input type="hidden" name="lineGiftListMun['+value.id+']" value="'+data.gift_num[value.id]+'"> ');

			     });
				 $('.gift_text').find('#delgift').remove();
				 //gift_row
				 var hasClass=$('input[name="hasClass"]').val();
				 if(hasClass==''){
					 $('.gift_title').append(title);
					 $('input[name="hasClass"]').val(1);
				 }
	/* 			 if(data.gid==0){    	
					 $('.gift_title').append(title);
					 
			     } */
			     $('.gift_text').append(str);
			     $('#save_line_gift').show();	
                 //关闭弹框
			     $(".bgsd,.tbtsd").hide();
			     $('.messages_color').hide();
			} else {
				alert(data.msg);
			}  
		}
	});
	 return false;
}
</script>