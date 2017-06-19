<div class="detail-box expert-line" style="display:none;">
	<div class="db-body" style="width:900px;">
		<div class="db-title">
			<h4>管家售卖线路</h4>
			<div class="db-close close-line">x</div>
		</div>
		<div class="db-search">
			<form method="post" action="#" id="el-search">
				<ul>
					<li class="search-list">
						<span class="search-title">线路名称：</span>
						<span ><input class="search-input" type="text" name="linename" /></span>
					</li>
					<li class="search-list">
						<input type="hidden" name="expert_id">
						<input type="submit" value="搜索" class="search-button" />
					</li>
				</ul>
			</form>
		</div>
		<div class="db-content" id="expertLine"></div>
	</div>
</div>
<script>
var columnsExpert = [ {field : 'linename',title : '线路名称',width : '280',align : 'center',length:20},
				{field : false,title : '佣金比例',width : '70',align : 'center',formatter:function(item){
						return (item.agent_rate*100).toFixed(1)+'%';
					}
				},
				{field : false,title : '满意度',width : '60',align : 'center',formatter:function(item){
						return (item.satisfyscore*100).toFixed(0)+'%';
					}
				},
				{field : 'lineprice',title : '售价',width : '60',align : 'center'},
				{field : 'comment',title : '评论',align : 'center', width : '60'},
				{field : 'sales',title : '销量',align : 'center', width : '60'},
				{field : false,title : '级别',align : 'center', width : '70',formatter:function(item){	
						if (item.grade == 2) {
							return "初级专家";
						} else if (item.grade == 3) {
							return "中级专家";
						} else if (item.grade == 4) {
							return "高级专家";
						} else {
							return "管家";
						}
					}
				},
				{field : false,title : '线路状态',align : 'center', width : '70',formatter:function(item){	
						if (item.status == -1) {
							return '删除';
						} else if (item.status == 0) {
							return '保存';
						} else if (item.status == 1) {
							return '审核中';
						} else if (item.status == 2) {
							return '正常';
						} else if (item.status == 3) {
							return '下架';
						} else if (item.status == 4) {
							return '系统退回';
						}
					}
				},
				{field : 'company_name',title : '供应商名称',align : 'center', width : '200',length:15}];



function expertLine(obj) {
	var eid = $(obj).attr('data-val');
	var name = $(obj).attr('data-name');
	$("#el-search").find("input[name=expert_id]").val(eid);
	$("#expertLine").pageTable({
		columns:columnsExpert,
		url:'/admin/a/experts/expert_list/getExpertLineData',
		pageNumNow:1,
		searchForm:'#el-search',
		tableClass:'table-data'
	});
	$(".expert-line").find(".db-title").find("h4").html("管家："+name);
	$(".expert-line,.mask-box").show();
}
$(".close-line").click(function(){
	$(".expert-line,.mask-box").hide();
})
</script>