<!--Page Related Scripts-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript">
jQuery(document).ready(function(){
	/*未结算 */
	var page=null;
	// 查询
	jQuery("#btnSearch").click(function(){
		page.load({"status":"2"});
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/app_line/indexData",form : '#listForm',// 绑定一个查询表单的ID
		columns : [

			{field : 'linecode',title : '',width : '15',align : 'left',position : 'relative',
				formatter : function(value,	rowData, rowIndex){
					if(rowData.refuse>0){
	
                        return '<div class="title_info" lineid="'+rowData.linecode+'" expert="'+rowData.expert_id+'" style="position:absolute;width:40px;height:30px;line-height:30px;top:-6px;cursor:pointer;z-index:9999;"><img class="title_img" src="/assets/img/u223.png" style="width:20px;height:20px;margin-top:-4px;position:relative;"></div>' ;

					}else{
						return '';
					}
			}},
			{field : 'linecodeid',title : '线路编号',width : '60',align : 'center'},
			{field : '',title : '线路标题',width : '150',align : 'center',
				formatter : function(value,	rowData, rowIndex){
						return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.linecode+',1)" data="'+rowData.linecode+'" >'+rowData.linename+'</a>';
					}
			},
			{ field : 'ordernum',title:'订单数量',width : '80',align : 'center'},
			{field : 'ordermoney',title : '订单金额',width : '80',align : 'center',
				formatter : function(value,	rowData, rowIndex){
					if(rowData.ordermoney==''){
						    return 0;
						}else{
							return rowData.ordermoney;
						}
				}
			},
			{field : 'agent_rate',title : '佣金',align : 'center',sortable : true,width : '80',
				formatter : function(value,	rowData, rowIndex){
					return rowData.agent_rate_int;
				}
			},
			{field : '',title : '管家满意度',align : 'center', width : '80',
				formatter : function(value,	rowData, rowIndex){
					return rowData.satisfaction_rate*100+'%';
				}
			},
			{field : 'realname',title : '专家名称',align : 'center', width : '100'},
			{field : 'grade',title : '管家级别',align : 'center', width : '100'},
			{field : '',title : '操作',align : 'center',width : '100',
				formatter : function(value,	rowData, rowIndex){
					//return '<a href="#" data="'+rowData.id+'" name="tbtd" >通过</a> <a href="##" data="'+rowData.id+'" name="commit0" onclick="show_receive_dialog(this)" >拒绝</a> ';
					return '<a href="#" data="'+rowData.id+'" expert_id="'+rowData.expert_id+'" lineid="'+rowData.linecode+'" data-val="'+rowData.lagrade+'" name="tbtd" onclick="show_expert(this)" >申请</a>';

				}
			}
		]
	});

	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content0').addClass('active');
		jQuery(this).parent().addClass('active');
		page.load({"status":"2"});
	});
	/*jQuery('.title_info').hover(function(){
		$(this).find(".info_txt").show();
	},function(){
		$(".info_txt").hide();
	}); */
	/*通过*/
/*	jQuery('#list').on("click", 'a[name="tbtd"]',function(){
		var data=jQuery(this).attr('data');
		 var status=2;
		 if (!confirm("确认要通过？")) {
	            window.event.returnValue = false;
	        }else{

				$.post("<?php //echo base_url()?>admin/b1/app_line/ajax_status", { data:data,status:status} , function(result) {
						if(result){
							alert('通过成功！');
							page.load({"status":"2"});

							}else{
							  alert('通过失败！');
						}

				});
	        }
	}); */
});
</script>


