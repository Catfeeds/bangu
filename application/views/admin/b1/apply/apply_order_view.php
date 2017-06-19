
<link href="/assets/ht/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />

<style type="text/css">
.tab_content { padding-top:0;}
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
.pagination{  float: right;}
.pay_input{padding:3px;margin-top:10px; margin-left:3px;}
.search_input { width:100px;}
lable{ display: inline-block;}
.all_account{color:#FF6537;font-size: 14px;font-weight: bold;}
</style>
<link href="/assets/css/style.css" rel="stylesheet" />
</head>
<body>

<!--=================右侧内容区================= -->
     <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">付款申请</a>
        </div>
        
        <div class="page_content bg_gray search_box">      
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav"> 
                        <li data-val="0"><a href="#" class="active"  id="tab0">付款申请记录</a></li> 
                    </ul>
                </div>
                <div class="tab_content">
            <!--       <form class="search_form" method="post" id="search-condition" action=""> -->
                  <form class="form-horizontal bv-form" method="post" id="searchForm0" novalidate="novalidate">
                      <div class="search_form_box clear">
							 
                 	    <div class="search_group">
                    	    <label>团号编号：</label>
                        	<input type="text" name="linesn" class="search_input">
                        </div>
                        <div class="search_group search-time">
	                         <label>出团日期：</label>
	                         <input type="text" name="starttime" style="width: 70px;" class="search_input" id="starttime" placeholder="开始时间"/>
	                         <input type="text" name="endtime" style="width: 70px;" class="search_input" id="endtime" placeholder="结束时间"/>
	                    </div>
                        <div class="search_group">
	                          <label>旅行社：</label>
	                          <input type="text" id="sch_union_name" name="sch_union_name" class="search_input" style="width:180px;">
	                    </div>
                        <div class="search_group">
	                          <label>线路编号：</label>
	                          <input type="text"  name="linecode" class="search_input">
	                   </div>
                              
      		           <div class="search_group">
	                          <label>订单编号：</label>
	                          <input type="text" name="ordersn" class="search_input">
	                   </div>
                        <div class="search_group">
	                          <label>线路名称：</label>
	                          <input type="text" name="linename" style="width: 147px;" class="search_input">
	                    </div>
	                    <div class="search_group show_select ul_kind " >
                                <label>审核状态</label>
                                <select name="apply_status">
                                    <option value="-1">请选择</option>
                                    <option value="0" selected="selected">未结算</option>
                                    <option value="1">申请中</option>
                                    <option value="2">已结算</option>
                                </select>
                        </div>
                        <div class="search_group">
                      	     <input type="hidden" name="status" value="0">
                     	     <input type="button" name="submit" class="search_button" value="搜索" id="searchBtn0" />
                        </div>
                      </div>
                    </form>
                    <form class="form-horizontal bv-form" method="post" id="batchForm" >
                    <div id="list"></div>
    	    	<div style="margin-top:10px;">
    			     <div><lable style="width: 100px;text-align: right;font-weight:bold;">申请总金额：</lable><span class="all_account">0</span></div>
    		   </div>
    		   <div  class="pay_div clear" >
                	<div class="fl" style="width:100%;">
    					<lable style="width:100px;text-align: right">收款单位：</lable>
    					<div style="width: 300px;display: inline-block;"><?php if(!empty($company_name)){ echo $company_name;} ?></div>
    					<lable style="width:100px;text-align: right;">付款方式：</lable>
    					<select name="pay_way" id="pay_way"  class="pay_input" style="margin-left:5px;width:60px;padding:0;">
    						<!-- <option value="-1">请选择</option> -->
    						<!-- <option value="0">现金</option> -->
    						<option value="1">转账</option>
    					</select>
    				</div>
    				<div class="fl" style="width:100%;">
    					<lable style="width: 100px;text-align: right;" class="pay_span">银行名称+支行：</lable>
    					<input type="text" name="p_bankname" class="w_300" value="<?php if(!empty($bank)){ echo $bank['bankname'].$bank['brand'];} ?>" style="padding:3px;margin-top:5px;margin-left: 3px;">
    					<lable style="width: 100px;text-align: right;" class="pay_span">开户公司：</lable>
    					<input type="text" name="p_bankcompany" value="<?php if(!empty($bank)){ echo $bank['openman'];} ?>" class="pay_input w_300" style="">
    					
    				</div>
    				<div class="fl" style="width:100%;">
                    			<lable style="width: 100px;text-align: right;" class="pay_span">银行卡号：</lable>
    					<input type="text" name=" p_bankcard" value="<?php if(!empty($bank)){ echo $bank['bank'];} ?>"class="pay_input w_300" size="25">
                 			   </div>
    				<div class="fl" style="width:100%;">
    					<lable style="width: 100px;text-align: right;" class="pay_span"> 申请备注：</lable>
    					<input type="text" name="p_remark" class="pay_input" style="width:710px;" size="100">
    					
    				</div>
    				<div style="margin:20px 300px;float:left;"><input type="button" value="提交申请" class="btn btn-info btn-xs" id="batchData"  ></div>		
    		    </div>
	            </form>
                </div>
            </div> 
        </div>
    </div>

<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<!-- <script type="text/javascript" src="/assets/ht/js/base.js"></script> -->
<script type="text/javascript" src="/assets/ht/js/jquery.datetimepicker.js"></script>
<!--分页-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<!-- 旅行社搜索 -->
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>
<script type="text/javascript">
/*$("#pay_way").change(function(){ 
	var val=$(this).find("option:selected").val();
	$(".pay_div").hide();
	if(val==0){
		$(".pay_div").hide();
	}else if(val==1){
		$(".pay_div").show();
	}
});*/
//--------------------------------------数据列表-----------------------------------------------
jQuery(document).ready(function(){
	var page=null;
	// 查询
	jQuery("#searchBtn0").click(function(){
		
		page.load({"status":"0"});
		//layer.msg('加载中', {icon: 16});
		$('.all_account').html(0);   //结算总金额
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/apply/apply_order/indexData",form : '#searchForm0',// 绑定一个查询表单的ID
		columns : [
			
			{ title : '<input type="checkbox" id="checkAll" style="opacity: 1;top:0px;position: static;"/>',
				width : '25',
				align : 'center',
				formatter : function(value,rowData, rowIndex) {
					/* if(rowData.billy_id>0){
						return '<div class="title_info"style="position:absolute;width:30px;height:20px;line-height:30px;top:-6px;cursor:pointer;z-index:9999;"><img class="title_img" src="/assets/img/u224.png" style="width:16px;height:16px;margin-top:-4px;position:relative;"></div>' ;
					}else{ */
	
					if(rowData.sk_money>0 || rowData.sk_money<0 ){
						var string='<input  onclick="check_order_id('+rowIndex+','+rowData.supplier_cost+','+rowData.platform_fee+')" name="order['+rowIndex+']" type="checkbox" style="left:1px;opacity: 1;position: static;" value="'+rowData.order_id+'" />';
						string=string+'<input  type="hidden"  name="unionID['+rowIndex+']" value="'+rowData.union_id+'"/>';
						string=string+'<input  type="hidden"  name="p_id['+rowIndex+']" value="'+rowData.a_money+'"/>';
						string=string+'<input  type="hidden"  name="su_id['+rowIndex+']" value="'+rowData.supplier_cost+'"/>';
						string=string+'<input  type="hidden"  name="pla['+rowIndex+']" value="'+rowData.platform_fee+'"/>';
						string=string+'<input  type="hidden"  name="a_m['+rowIndex+']" value="'+rowData.sk_money+'"/>';
						apply_moneyStr=parseFloat(rowData.apply_money)-parseFloat(rowData.applyMo);
						string=string+'<input  type="hidden"  name="ap_m['+rowIndex+']" value="'+apply_moneyStr.toFixed(2)+'"/>';	

						return string;	
					}else{
						return '';
					}	
				
					//}
				}
			},
		    {field : 'id',title : '',width : '25',align : 'center',
	                 formatter : function(value,rowData, rowIndex){  
	                 	  if(rowData.is_apply>0){
	                 		    return '<span style="font-size:17px;cursor: pointer;position:absolute;left:0;top:0;line-height:24px;text-align:center;display: inline-block;width: 100%;top: -3px;" onclick="show_payable(this,1);" data-id="'+rowData.order_id+'">+</span>';
	                 	  }else{
	                 		  	return ''; 	
	                 	  }       	  		                   	  
	                 },
	        },
		{field : '',title : '申请金额',width : '90',align : 'center',
			formatter : function(value,rowData, rowIndex) { 
				if(rowData.billy_id>0){
					return '';
				}else{
					//if(rowData.balance_status==1 || rowData.balance_status==2){
					//if(rowData.balance_status==2){
					//	return '';
					//}else{
						if(rowData.sk_money>0 || rowData.sk_money<0){ //已交款-已结算的金额

							if(parseFloat(rowData.j_money)>=parseFloat(rowData.supplier_cost)){  //1.已收金额>=结算金额
								//申请金额-正在申请的
								rowData.apply_money=parseFloat(rowData.apply_money)-parseFloat(rowData.applyMo)-parseFloat(rowData.platform_fee);
								rowData.apply_money=rowData.apply_money.toFixed(2);  //保留后两位小数
								return '<input type="text" name="apply_money['+rowIndex+']" onBlur="check_apply_money('+rowIndex+','+rowData.apply_money+')"  style="padding: 0px 4px;width: 100%;" value="'+rowData.apply_money+'" />';

							}else if(parseFloat(rowData.j_money)<parseFloat(rowData.supplier_cost)){ //2.已收金额<结算金额

								if(parseFloat(rowData.j_money)>=parseFloat(rowData.balance_money)){ //已收金额>=已结算
									rowData.apply_money=parseFloat(rowData.j_money)-parseFloat(rowData.balance_money)-parseFloat(rowData.applyMo);//已收金额和已结算之差
									rowData.apply_money=rowData.apply_money.toFixed(2);  //保留后两位小数	
									return '<input type="text" name="apply_money['+rowIndex+']" onBlur="check_apply_money('+rowIndex+','+rowData.apply_money+')"  style="padding: 0px 4px;width: 100%;" value="'+rowData.apply_money+'" />';
								}else if(parseFloat(rowData.j_money)<parseFloat(rowData.balance_money)){ //已收金额<已结算
									return '<input type="text" name="apply_money['+rowIndex+']" onBlur="check_apply_money('+rowIndex+','+0+')"  style="padding: 0px 4px;width: 100%;" value="'+0+'" />';
								}
								
							}

						}else{
								return '';
						}
					//}
				}
			}
		},

		{field : 'j_money',title : '已交全款',width : '65',align : 'center',
			formatter : function(value,rowData, rowIndex){
				if(rowData.all_money==''){
					return '否';	
				}else{
					if(parseFloat(rowData.all_money)>=parseFloat(rowData.total_price)){
						return '是';	
					}else{
						return '否';
					}
				}
				//return rowData.total_price;
			}
		},
		{field : 'linesn',title : '团号',align : 'left', width : '100'},
		{field : 'ordersn',title : '订单号',width : '120',align : 'center',
			formatter : function(value,	rowData, rowIndex){	
				return '<a href="/admin/b1/order/order_detail?id='+rowData.order_id+'" target="_blank" >'+rowData.ordersn+'</a>';
			}
		},
		{field : '',title : '产品名称',width : '260',align : 'left',
			formatter : function(value,	rowData, rowIndex){
				if(rowData.line_kind==1){
					return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lid+',1)" data="'+rowData.lid+'">'+rowData.linename+'</a>';
				}else{
					return rowData.linename;
				}	
				
			}
		},
		{field : 'usedate',title : '出团日期',align : 'center', width : '100'},
		
		{field : 'supplier_cost',title : '结算金额',align : 'right',sortable : true,width : '90',
			formatter : function(value,rowData, rowIndex){ 
				/*if(parseFloat(rowData.j_money)<parseFloat(rowData.supplier_cost)){
					return 	 rowData.j_money;
				}else{*/
					return 	 rowData.supplier_cost;
				//}
			}
		},
		{field : 'a_balance',title : '结算申请中',align : 'right',sortable : true,width : '90'},
		{field : 'balance_money',title : '已结算',align : 'right',sortable : true,width : '90',formatter : function(value,rowData, rowIndex){
			var red= rowData.account_money_list;
			if(red==''){
				red=0;
			}
			red=parseFloat(red).toFixed(2);
			return '<div title="'+red+'%">'+value+'</div>';
		}},
		{field : 'platform_fee',title : '操作费',align : 'right', width : '70'},
		{field : 'un_balance',title : '未结算',align : 'right',sortable : true,width : '90'},
		{field : 'realname',title : '销售',align : 'center',sortable : true,width : '80'},
		{field : 'depart_name',title : '营业部',align : 'center',sortable : true,width : '100'},
		{field : 'union_name',title : '旅行社',align : 'center',sortable : true,width : '100'},			
		{field : '',title : '状态',align : 'center', width : '55',
			formatter : function(value,rowData, rowIndex){
				if(rowData.balance_status==0){
					return '未结算';
				}else if(rowData.balance_status==1){
					return '申请中';	
				}else if(rowData.balance_status==2){
					return '已结算';	
				}	
			}
		}

		]
	});
	
	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home0').addClass('active');
		jQuery(this).parent().addClass('active');
		page.load({"status":"0"});
		$('.all_account').html(0);   
	}); 

});
	 
//--------------------------------------数据列表-----------------------------------------------
//申请付款
function submit_apply(){
	$.post("/admin/b1/apply/apply_order/add_apply_money",$('#apply_from').serialize(),function(data){
           data = eval('('+data+')');
           if(data.status==1){
            	alert(data.msg);
                $('.opp_colse,.bc_close').click();
                jQuery('#tab1').click();
           }else{
       	        alert(data.msg);	
           }    
    })
	return false;
}
$('.opp_colse,.bc_close').click(function(){
	$('.eject_body').hide();
	$('.modal-backdrop').hide();	
	$('.batch_settlement_body').hide();
})

$(document).on('mouseover', '.title_info', function(){	
	var html='';
	html=html+'<div class="info_txt" id="info_txt" style="width:340px;text-align:left;border:1px solid #aaa;background:#fff;z-index:999;position:absolute;left:40px;top:0;display:none;">';
	html=html+'<p style="color: red;">销售人员因客户需求,订单的出游人数或成本价有变化,请尽快去订单管理确认"订单修改"</p></div>';     
	$('.title_info').append(html);
	$(this).find(".info_txt").show();
});
$(document).on('mouseout', '.title_info', function(){
	$(".info_txt").hide();
});

 $(function() {
          $("#checkAll").click(function() {  //全选
             	var all_money=parseFloat(0);
             	var union_id=0;
             	for (var j=0; j <=9; j++) {
             		var unionid=$('input[name="unionID['+j+']"]').val();
	           		if(unionid!=undefined){
	           			union_id=unionid;
	           			break;
	           		}
             	}
             	//alert(union_id);
	           	for (var i =0; i <=9; i++) {
	           		var union_data=$('input[name="unionID['+i+']"]').val();
	           		if(union_data!=undefined){
				    if(union_id==union_data){  //需选择同一个旅行社
		           		$('input[name="order['+i+']"]').attr("checked",this.checked); 
		           		if(this.checked==true){
		           			var money=$('input[name="apply_money['+i+']"]').val();
		           			if(money!=undefined && money!=''){
		           				var b_money=$('input[name="p_id['+i+']"]').val();//结算价
		           				var  pla=$('input[name="pla['+i+']"]').val(); //平台佣金
		           		    	var ap_m=$('input[name="ap_m['+i+']"]').val();  //未结算(未减平台佣金)	
		           				b_money=parseFloat(ap_m)-parseFloat(pla);
		           				if(parseFloat(money)>parseFloat(b_money)){  //申请金额>结算金额-平台管理费
		           					money=b_money;
		           					$('input[name="apply_money['+i+']"]').val(b_money.toFixed(2));
		           				}else{
           					        var a_m=$('input[name="a_m['+i+']"]').val();    //已交款的金额
                                 	if(parseFloat(a_m)>parseFloat(b_money)){   //判断是否已交全款>=结算价
                                        if(parseFloat(ap_m)==parseFloat(money)){  
                                                        
                                                money=parseFloat(money)-parseFloat(pla);  
                                                money=money.toFixed(2); 
                                                $('input[name="apply_money['+i+']"]').val(money); 
                                        }
                                     }
		           				}
			           			all_money=parseFloat(all_money)+parseFloat(money);
		           			}else{
			           			
		           				$('input[name="order['+i+']"]').attr("checked",false); 
			           		}
		           		}
			          }else{
			          		$('input[type="checkbox"]').attr("checked",false); 
			          		alert('请选择同一个旅行社');
			          		all_money=0;
			          		return false;
			          	}
	           		}	
	           	};  
	          	all_money=all_money.toFixed(2);
	   			$('.all_account').html(all_money);   
         });
      
 });

       	function check_order_id(i,supplier_cost,platform_fee){  //单选
       		var union_id=0;
       		for (var j=0; j <=9; j++) {
       			var re=$('input[name="order['+j+']"]').attr("checked"); 
             		if(re=='checked'){ 
             			if(i!=j){
	             			var unionid=$('input[name="unionID['+j+']"]').val();
	             			union_id=unionid;
		           			break;	
             			}            			
             		}
        		  }
	           var unionID=$('input[name="unionID['+i+']"]').val(); 
	           if(union_id!=0){
					if(union_id!=unionID){
	             		$('input[name="order['+i+']"]').attr("checked",false); 
	             		layer.msg('请选择同一个旅行社', {icon: 2});
	             		return false;
		            }
	           }

	       	var value=$('input[name="apply_money['+i+']"]').val(); 
			if(isNaN(value)){
				layer.msg('填写格式出错', {icon: 2});
				$('input[name="apply_money['+i+']"]').val('');
				return false
			}else if(value==''){
				var b=$('input[name="order['+i+']"]').attr("checked");
           	 	if(b=="checked"){
					layer.msg('勾选的申请的金额不能为空', {icon: 2});
					$('input[name="apply_money['+i+']"]').val('');
					$('input[name="order['+i+']"]').attr("checked",false); 
					return false
				}
			}
			var all_money=0;
			for (var a =0; a<=9; a++) {
	           	var check=$('input[name="order['+a+']"]').attr("checked"); 
	           	if(check=='checked'){
		                 var money=$('input[name="apply_money['+a+']"]').val();
                         if(money!=undefined && money!=''){
                               var b_money=$('input[name="p_id['+a+']"]').val();  //结算价
                            var  ap_m=$('input[name="ap_m['+a+']"]').val();  //未结算(未减平台佣金)
                            var  pla=$('input[name="pla['+a+']"]').val(); //平台佣金
                               b_money=parseFloat(ap_m)-parseFloat(pla);
                               if(parseFloat(money)>parseFloat(b_money)){  //申请金额>结算金额-平台管理费
                                     money=b_money;
                                     $('input[name="apply_money['+i+']"]').val(b_money.toFixed(2));
                               }else{
                               		var a_m=$('input[name="a_m['+a+']"]').val();    //已交款的金额
                                 if(parseFloat(a_m)>parseFloat(b_money)){   //判断是否已交全款>=结算价
                                      	
                                   if(parseFloat(ap_m)==parseFloat(money)){  
                                              money=parseFloat(money)-parseFloat(pla); 
                                              money=money.toFixed(2); 
                                              $('input[name="apply_money['+a+']"]').val(money); 
                                        }
                                     }     
                               }
                               all_money=parseFloat(all_money)+parseFloat(money);
                         }
	           	}
	          };  

             	all_money=all_money.toFixed(2);
             	$('.all_account').html(all_money);
            };
          	function check_apply_money(a,a_money){ //申请金额变化

          		var c_money=$('input[name="apply_money['+a+']"]').val();
          		if(c_money=='0' || c_money=='0.00'){
          			return false;
          		}
          		if(c_money==''){
              		var b=$('input[name="order['+a+']"]').attr("checked");
              		if(b=="checked"){
              			//alert('申请金额不能为空');
              			layer.msg('申请金额不能为空', {icon: 2});
                        $('input[name="apply_money['+a+']"]').focus();
                        return false;
                  	}
          		}
          		 if(isNaN(c_money)){
                     	layer.msg('填写格式不对', {icon: 2});
                        $('input[name="apply_money['+a+']"]').val('');
                        $('input[name="apply_money['+a+']"]').focus();
                        return false;
                 }

          		if(c_money>a_money){
          		 	layer.msg('申请的金额不能大于已交款的金额', {icon: 2});
          			$('input[name="apply_money['+a+']"]').val(a_money);
          			$('input[name="money_list['+a+']"]').val(100); 
          			return false;
          		}
          		/*if(c_money<0){
			alert('申请的金额不能大于0');
          			$('input[name="apply_money['+a+']"]').val(0);
          			$('input[name="money_list['+a+']"]').val(0); 
          			return false;
          		}*/
          		//alert(c_money);
          /*		if(parseFloat(a_money)>=parseFloat(b_money)){
          			b_money=a_money;
          			
          		}else{
          			b_money=$('input[name="p_id['+a+']"]').val();	
          		}
          		*/
          		//b_money=$('input[name="p_id['+a+']"]').val();	
          		var indata=parseFloat(c_money)/parseFloat(a_money)*100;
          		indata=indata.toFixed(2);
          		$('input[name="money_list['+a+']"]').val(indata); //改变比例

             	var all_money=parseFloat(0);

	           	for (var i =0; i <=9; i++) {  //重新遍历,计算中金额
	           	var check=$('input[name="order['+i+']"]').attr("checked"); 
	           		if(check=='checked'){
	           			var money=$('input[name="apply_money['+i+']"]').val();
						if(isNaN(money)){
							layer.msg('填写格式出错', {icon: 2});
						  	$('input[name="apply_money['+i+']"]').val('');
						  	return false
						}

	           			if(money!=undefined){
		           			  all_money=parseFloat(all_money)+parseFloat(money);
	           			}
	           		}
	           	};  
	          	all_money=all_money.toFixed(2);
	   	$('.all_account').html(all_money); 
             }
             //申请金额比例
	function check_money_list(a,a_money){
		//alert(a_money);
		var list=$('input[name="money_list['+a+']"]').val(); 
		if(list==''){
			alert('申请金额比例不能为零');
			$('input[name="money_list['+a+']"]').focus();
                                return false;
		}
		 if(isNaN(list)){
                alert('填写格式不对');
                $('input[name="money_list['+a+']"]').val('');
                $('input[name="money_list['+a+']"]').focus();
                return false;
          }else{
               if(list >100){
    				alert('不能大于100%');
    				$('input[name="money_list['+a+']"]').val('');
                  	$('input[name="money_list['+a+']"]').focus();
    				return false;
                }else if(list <0 ){
    				alert('不能低于0');
    				$('input[name="money_list['+a+']"]').val('');
                    $('input[name="money_list['+a+']"]').focus();
    				return false;
                }
		}
        a_money =$('input[name="apply_money['+a+']"]').val(); 
		var data=parseFloat(a_money)*parseFloat(list)*parseFloat(0.01);
		data=data.toFixed(2);
		$('input[name="apply_money['+a+']"]').val(data);
		var all_money=parseFloat(0);

       	for (var i =0; i <=9; i++) {  //重新遍历,计算中金额
       		var check=$('input[name="order['+i+']"]').attr("checked"); 
       		if(check=='checked'){

       			var money=$('input[name="apply_money['+i+']"]').val();

       			if(money!=undefined){
			all_money=parseFloat(all_money)+parseFloat(money);
       			}

       		}
       	};  
	    all_money=all_money.toFixed(2);
	   	$('.all_account').html(all_money); 
	}


 //批量申请
jQuery('#batchData').click(function(){


    jQuery.ajax({ type : "POST",async:false,data :$('#batchForm').serialize(),url : "<?php echo base_url()?>admin/b1/apply/apply_order/p_payable_apply", 
        beforeSend:function() {//ajax请求开始时的操作
             layer.load(1);//加载层
        },
        complete:function(){//ajax请求结束时操作              
             layer.closeAll('loading'); //关闭层
        },
        success : function(result) { 
      	  data = eval('('+result+')');
	       	   if(data.status==1){   
	 	       	   layer.msg(data.msg, {icon: 1});  
		 	       $('input[name="p_remark"]').val('');
		           $('.opp_colse,.bc_close').click();
		           jQuery('#tab0').click();  
	         }else{
	               alert(data.msg);
	         } 
        }
    });
    
	/*$.post("/admin/b1/apply/apply_order/p_payable_apply",$('#batchForm').serialize(),function(data){
       	data = eval('('+data+')');
         if(data.status==1){
        	   alert(data.msg);
        	   $('input[name="p_remark"]').val('');
               $('.opp_colse,.bc_close').click();
               jQuery('#tab0').click();   
         }else{
       		   alert(data.msg);
         }
	})*/
});

//保存批量申请的结算单
function submit_p_apply(){
	$.post("/admin/b1/apply/apply_order/p_payable_apply",$('#p_apply_from').serialize(),function(data){
           data = eval('('+data+')');
           if(data.status==1){
           	   $('input[name="p_remark"]').val('');
               alert(data.msg);
	           $('.opp_colse,.bc_close').click();
	           jQuery('#tab0').click();   
           }else{
               alert(data.msg);
           }
	})
}
//旅行社查询搜索
 $.post('/admin/b1/apply/apply_order/get_depart_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		if(val.union_name==null){
			val.union_name='';
		}
		array.push({
		    text : val.union_name,
		    value : val.id,
		    jb : val.union_name,
		    qp : val.union_name
		});
	})
	var comboBox = new jQuery.comboBox({
		 id : "#sch_union_name",
		 name : "b_unionid",// 隐藏的value ID字段
		 query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
		 blurAfter : function(item, index) {// 选择后的事件
			if(jQuery('#b_unionid').val()==''){
				jQuery('#b_unionid').val('');
				//jQuery('#sch_union_name').val('');
			}
		 },
		 data : array
	});
 
})
$('#starttime').datetimepicker({
      lang:'ch', //显示语言
      timepicker:false, //是否显示小时
      format:'Y-m-d', //选中显示的日期格式
      formatDate:'Y-m-d',
      validateOnBlur:false,
});
$('#endtime').datetimepicker({
      lang:'ch', //显示语言
      timepicker:false, //是否显示小时
      format:'Y-m-d', //选中显示的日期格式
      formatDate:'Y-m-d',
      validateOnBlur:false,
});

//展开申请记录
function show_payable(obj,type){
	if(type==1){
 		var orderid = $(obj).attr("data-id");
    		$.post("<?php echo base_url()?>admin/b1/apply/apply_order/get_order_payable_list", { orderid:orderid} , function(result) {
                 	 var result =eval("("+result+")"); 
                  	 if(result.status==1){ 
	                          var html = '<tr class="order_table"><td colspan="17" style="padding:0;"><div style="padding:5px 5px 5px 30px;"><table class="table table-bordered" style="width:1000px">';
	                           html+='<thead class="th-border"><tr>';
	                           html+='<th>审核状态</th>';
	                           html+='<th>申请金额</th>';
	                           html+='<th>订单号</th>';
	                           html+='<th>销售&部门</th>';
	                           html+='<th>出团日期</th>';
	                           html+='<th>结算总价</th>';
	                           html+='<th>已结算</th>';
	                           html+='<th>操作费</th>';
	                           html+='<th>未结算</th>';
	                           html+='<th>团号</th>';
	                           html+='<th>操作</th>';
// 	                           html+='<th>佣金</th>'; 
	                           html+='</tr></thead><tbody>';
	                      if(result.data!=''){
  
		                        $.each(result.data, function(key,val) {   
		                       	var apply=""; 
		                                if(val.status==0){
		                                     apply="申请中";
		                                }else if(val.status==1){
		                                    apply="申请中";
		                                }else if(val.status==2){
		                                    apply="已通过";
		                                }else if(val.status==3){
		                                    apply="已拒绝";
		                                }else if(val.status==4){
		                                    apply="已付款";
		                                }else if(val.status==5){
		                                    apply="已拒绝";
		                                }    
		   
		                                html+='<tr>';
		                                html+='<td>'+apply+'</td>';
		                                html+='<td>'+val.amount_apply+'</td>';
		                                html+='<td>'+val.ordersn+'</td>';
		                                html+='<td>'+val.realname+'&'+val.depart_name+'</td>';
		                                html+='<td>'+val.usedate+'</td>';
		                                html+='<td>'+val.supplier_cost+'</td>';
		                                html+='<td>'+val.balance_money+'</td>';
		                                html+='<td>'+val.platform_fee+'</td>';
		                                html+='<td>'+val.un_balance+'</td>';
		                                html+='<td>'+val.item_code+'</td>'; 
		                                html+="<td><a href='javascript:void(0);' class='a_print' data-id='"+val.id+"'>打印预付</a></td>"; 
// 		                                html+='<td>'+val.platform_fee+'</td>';     
		                                html+='</tr>';
		                        });
			}else{
				 html+='<tr>';
				 html+='<td colspan="10" style="letter-spacing:10px"><span style="font-weight: bold;color: red;">暂无申请记录数据</span></td>';
				 html+='</tr>';
			}

			html+='</tbody></table></div></td></tr>';
	        $(obj).parent().parent().parent().after(html);
	        $(obj).html("-").attr("onclick","show_payable(this,2);");
		}else{

		}
           });  

      }else{
            $(obj).html("+").attr("onclick","show_payable(this,1);");
            $(obj).parent().parent().parent().next().remove();
      }
}

/*打印预付*/
$("body").on("click",".a_print",function(){
		
		var id=$(this).attr("data-id");
		var win1 = window.open("<?php echo base_url('admin/b1/apply/apply_order_log/pay_print');?>"+"?id="+id,'print','height=1090,width=765,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
		win1.focus();
	});
	
</script>

