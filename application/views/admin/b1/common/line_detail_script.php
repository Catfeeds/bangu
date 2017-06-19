<script type="text/javascript">
//订单详情
$("body").on("click",".line_detail",function(){
	var line_id=$(this).attr("data");
	jQuery.ajax({ type : "POST",data :"line_id="+line_id,url : "<?php echo base_url()?>admin/b1/product/auth_line",
		success : function(data) {
			 var data=eval("("+data+")");
			 if(data.status==1){
			 	layer.open({
					title:'线路详情',
					type: 2,
					area: ['1200px', '80%'],
					fix: false, //不固定
					maxmin: true,
					content: "<?php echo base_url('admin/b1/product/show_line_detail');?>"+"?id="+line_id+"&type=1"
				});

			 }else{
			 	alert(data.msg);
			 }	
		}
	});

});
</script>