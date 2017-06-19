<style type="text/css">
	.form-control{ width: 200px; margin-right: 15px;}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active header_name">定制单管理</li>
		</ul>
	</div>
	<div class="page-body">
		<ul class="nav nav-tabs" id="changeNavTab">
			<li class="active" data-val="1"><a>抢单中 </a></li>
			<li class="tab-red" data-val="3"><a>已完成</a></li>
			<li class="tab-blue" data-val="-2"><a>已取消</a></li>
			<li class="tab-blue" data-val="-3"><a>已过期</a></li>
		</ul>
		<div class="tab-content">
			<form action="<?php echo site_url('admin/a/expert/customize/getCustomizeJson');?>" id='search_condition' method="post">
				<div class="" style="display:inline-block;">
					<input type="text" class="search_input" placeholder="定制人姓名" name="linkname">
				</div>
				<div class="" style="display:inline-block;">
					<input type="text" class="search_input" placeholder="手机号" name="linkphone">
				</div>
				<input type="hidden" name="status" value="1" />
				<input type="submit" value="搜索" class="btn btn-darkorange active" />
			</form>
			<div id="dataTable"></div>
		</div>
	</div>
</div>
<div id="customizeDetail"></div>
<div class="modal-backdrop fade in bc_close" style="display:none"></div>
<script src="<?php echo base_url("assets/js/jquery.detailbox.js") ;?>"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script>
var columns = [ {field : 'linkname',title : '定制人',width : '150',align : 'center'},
				{field : 'linkphone',title : '联系手机',width : '200',align : 'center'},
				{field : 'startdate',title : '出游时间',width : '140',align : 'center'},
				{field : 'cityname',title : '出发城市',align : 'center', width : '160'},
				{field : 'kindname',title : '目的地',align : 'center', width : '130'},
				{field : 'budget',title : '人均预算',align : 'center', width : '120'},
				{field : 'days',title : '游玩天数',align : 'center', width : '130'},
				{field : 'total_people',title : '出游人数',align : 'center', width : '120'},
				{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
					return "<a href='javascript:void(0);' onclick='detail("+item.id+")' class='btn btn-info btn-xs edit'>查看详情</a>";;
				}
			}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/experts/customize/getCustomizeJson',
	searchForm:'#search_condition'
});

$("#changeNavTab li").click(function() {
	$("#search_condition").find("input[type=text]").val('');
	$("input[name='status']").val($(this).attr("data-val"));
	$(this).addClass("active").siblings("li").removeClass("active");
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/experts/customize/getCustomizeJson',
		searchForm:'#search_condition',
		pageNumNow:1
	});
})
//查看定制单详细
function detail(id) {
	$.ajax({
		type:"POST",
		url:"/admin/a/experts/customize/getCustomizeDetail",
		dataType:"json",
		data:{id:id},
		success:function(data) {
			see_detail(data);
		}
	});
}
function see_detail(data) {
	var customize = {
				"定制人":{content:data.linkname},
				"手机号":{content:data.linkphone},
				"定制时间":{content:data.addtime},
				"成人":{content:data.people},
				"老人":{content:data.oldman},
				"儿童不占床":{content:data.childnobednum},
				"儿童占床":{content:data.childnum},
				"出游时长":{content:data.days},
				"用房数":{content:data.roomnum},
				"出发城市":{content:data.cityname},
				"目的地":{content:data.kindname},
				"出游方式":{content:data.trip_way},
				"多项服务":{content:data.another_choose},
				"出行日期":{content:data.startdate,type:"text"},
				"人均预算":{content:data.budget,type:"text"},
				"酒店要求":{content:data.hotelstar,type:"text"},
				"用房要求":{content:data.room_require,type:"text"},
				"用餐要求":{content:data.catering,type:"text"},
				"购物自费":{content:data.isshopping,type:"text"},
				"详细需求":{content:data.service_range,width:"100%"},
			};
	$("#customizeDetail").detailbox({
			data:customize,
			titleName:"定制详情"
		});
}

$('.eject_colse').click(function(){
	$('.eject_body').hide();
	$('.modal-backdrop').hide();
})
</script>