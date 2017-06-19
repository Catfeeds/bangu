<style type="text/css">
	.table thead th{ text-align: center;}
	.table tbody td{text-align: center;}
	.form-control{ width: 200px; margin-right: 15px;}
	.col-xs-2{ margin-right: 70px;}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active header_name">定制单管理</li>
		</ul>
	</div>
	<!-- Page Body -->
	<div class="page-body">
		<ul class="nav nav-tabs">
			<li class="active" status="1"><a>抢单中 </a></li>
			<li class="tab-red" status="3"><a>已完成</a></li>
			<li class="tab-blue" status="-2"><a>已取消</a></li>
			<li class="tab-blue" status="-3"><a>已过期</a></li>
		</ul>

		<div class="tab-content">
			
		
			<form action="<?php echo site_url('admin/a/expert/customized_list');?>" id='search_condition' method="post">
				<div class="col-xs-2">
					<div>
						<input type="text" class="form-control" placeholder="定制人姓名" name="linkname">
					</div>
				</div>
				<input type="hidden" name="page_new" />
				<input type="hidden" name="status" value="1" />
				<input type="submit" value="搜索" class="btn btn-darkorange active" />
			</form>
			<br />
			<div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
				<table class="table table-striped table-hover table-bordered dataTable no-footer"  aria-describedby="editabledatatable_info">
					<thead class="bordered-darkorange">
						<tr>
							<th>定制人</th>
							<th>联系手机</th>
							<th>出游时间</th>
							<th>出发城市</th>
							<th>目的地</th>
							<th>人均预算</th>
							<th>游玩天数</th>
							<th>出游人数</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody class='pagination_data'>
					<?php foreach($list as $val): ?>
						<tr>
							<td class="td_center"><?php echo $val ['linkname']?></td>
							<td><?php echo $val['linkphone']?></td>
							<td><?php echo $val['startdate']?></td>
							<td class="td_center"><?php echo $val ['startplace']?></td>
							<td class="td_center"><?php echo $val ['endplace'] ?></td>
							<td class="td_center"><?php echo $val ['budget'] ?></td>
							<td class="td_center"><?php echo $val['days']?></td>
							<td class="td_center"><?php echo $val ['people']?></td>
							<td><a href='javascript:void(0);' onclick="detailed(<?php echo $val['id']?>)" class="btn btn-info btn-xs edit">查看详情</a></td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
				<div class="pagination"><?php echo $page_string?></div>
			</div>
		</div>
	</div>
</div>
<!-- 定制单详情 -->
<div class="eject_body">
	<div class="eject_colse ">X</div>
	<div class="eject_title">定制单详情</div>
	<div class="eject_content">
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">定制&nbsp;&nbsp;人：</div>
				<div class="content_info cus_linkname"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">手机号：</div>
				<div class="content_info cus_linkphone"></div>
			</div>
		</div>
		<div class="eject_content_list cus_bid" style="display:none;">
			<div class="eject_list_row">
				<div class="eject_list_name ">中标管家：</div>
				<div class="content_info cus_expert"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">中标商家：</div>
				<div class="content_info cus_supplier"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">出游时间：</div>
				<div class="content_info cus_startdate"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">人均预算：</div>
				<div class="content_info cus_budget"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">游玩天数：</div>
				<div class="content_info cus_days"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">出游人数：</div>
				<div class="content_info cus_people"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">已抢数量：</div>
				<div class="content_info cus_grab"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">回复方案数：</div>
				<div class="content_info cus_reply"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">出发城市：</div>
				<div class="content_info cus_startplace"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">到达城市：</div>
				<div class="content_info cus_endplace"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">出游方式：</div>
				<div class="content_info cus_trip_way"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">酒店星级：</div>
				<div class="content_info cus_hotelstar"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">用餐要求：</div>
				<div class="content_info cus_catering"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">购物自费项目：</div>
				<div class="content_info cus_isshopping"></div>
			</div>
		</div>
		
		
		<div class="eject_content_text">
			<div class="eject_text_name">需求服务：</div>
			<div class="eject_text_info"><textarea style="border:none" rows="5" cols="50" class="cus_service_range" disabled></textarea></div>
		</div>
	</div>						
</div>	
<div class="modal-backdrop fade in bc_close" style="display:none"></div>
<script>
//分页数据获取
$('.ajax_page').click(function() {
	if ($(this).hasClass('active')) {
		return false;
	}
	var page_new = $(this).find('a').attr('page_new');
	get_ajax_data(page_new);
})
//条件搜索
$('#search_condition').submit(function() {
	get_ajax_data(1);
	return false;
})

//点击导航状态
$('.nav-tabs').find('li').click(function() {
	$(this).addClass('active').siblings().removeClass('active');
	$('input[name="status"]').val($(this).attr('status'));
	get_ajax_data(1);
})
//分页数据展示
function get_ajax_data(page_new) {
	$('input[name="page_new"]').val(page_new);
	var status = $('input[name="status"]').val();
	$.post("/admin/a/expert/customized_page", $('#search_condition').serialize(), function(data) {
		var data = eval("(" + data + ")");
		$('.pagination_data').html('');
		// 遍历数据
		$.each(data.list, function(key, val) {
			var str = "<tr>";
			str += "<td class='td_center'>" + val.linkname + "</td>";
			str += "<td>" + val.linkphone + "</td>";
			str += "<td>" + val.startdate + "</td>";
			str += "<td class='td_center'>" + val.startplace + "</td>";
			str += "<td class='td_center'>" + val.endplace + "</td>";
			str += "<td class='td_center'>" + val.budget + "</td>";
			str += "<td class='td_center'>" + val.days + "</td>";
			str += "<td class='td_center'>" + val.people + "</td>";
			if (status == 3) {
				str += "<td><a href='javascript:void(0);' onclick='detailed("+val.id+" ,1)' class='btn btn-info btn-xs edit'>查看详情</a></td>";
			} else {
				str += "<td><a href='javascript:void(0);' onclick='detailed("+val.id+")' class='btn btn-info btn-xs edit'>查看详情</a></td>";
			}
			
			str += "</tr>";
			$(".pagination_data").append(str);
		});
		$('.pagination').html(data.page_string);
		$('.ajax_page').click(function() {
			if ($(this).hasClass('active')) {
				return false;
			}
			var page_new = $(this).find('a').attr('page_new');
			get_ajax_data(page_new);
		})
	});
}
//查看定制单详细
function detailed(id ,is) {
	var status = $("input[name='status']").val();
	$.post("/admin/a/expert/get_one_customized_json",{'id':id,'status':status},function(data) {
		if (data.length < 1) {
			alert('请确认您选择的数据是否正确');
			return false;
		}
		var data = eval('('+data+')');
		$('.cus_linkname').html(data.linkname);
		$('.cus_linkphone').html(data.linkphone);
		$('.cus_startdate').html(data.startdate);
		$('.cus_budget').html(data.budget);
		$('.cus_startplace').html(data.startplace);
		$('.cus_endplace').html(data.endplace);
		$('.cus_days').html(data.days);
		$('.cus_people').html(data.people);
		$('.cus_trip_way').html(data.trip_way);
		$('.cus_hotelstar').html(data.hotelstar);
		$('.cus_catering').html(data.catering);
		$('.cus_isshopping').html(data.isshopping);
		$('.cus_service_range').val(data.service_range);
		$('.cus_grab').html(data.grab);
		$('.cus_reply').html(data.reply);
		if (is == 1) {
			$(".cus_bid").show();
			$('.cus_expert').html(data.realname);
			$('.cus_supplier').html(data.company_name);
		} else {
			$(".cus_bid").hide();
		}
		$('.eject_body').show();
		$('.modal-backdrop').show();
	});
}
$('.eject_colse').click(function(){
	$('.eject_body').hide();
	$('.modal-backdrop').hide();
})
</script>



