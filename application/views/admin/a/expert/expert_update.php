<style type="text/css">
.page-content{ min-width: auto !important; }
</style>
<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>管家资料修改</li>
	</ul>
	<div class="page-body">
		<ul class="nav-tabs">
			<li class="active" data-val="0">审核中</li>
<!-- 			<li class="tab-red" data-val="1">已通过</li> -->
<!-- 			<li class="tab-blue" data-val="2">已拒绝</li> -->
		</ul>
		<div class="tab-content">
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">管家姓名：</span>
						<span ><input class="search-input" type="text" name="name" placeholder="管家姓名" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">手机号：</span>
						<span ><input class="search-input" type="text" name="mobile" placeholder="手机号" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">邮箱号：</span>
						<span ><input class="search-input" type="text" name="email" placeholder="邮箱号" /></span>
					</li>
					<li class="search-list">
						<input type="hidden" value="0" name="status">
						<input type="submit" value="搜索" class="search-button" />
					</li>
				</ul>
			</form>
			<div id="dataTable"></div>
		</div>
	</div>
</div>

<div class="detail-box">
	<div class="db-body">
		<div class="db-title">
			<h4 class="detail-title">数据详情展示</h4>
			<div class="db-close detail-close">x</div>
		</div>
		<div class="db-content">
			<ul>
				<li class="db-category">
					<h4>基本信息</h4>
					<ul id="basic-info">
						<li class="db-data-row">
							<div class="db-row-title">姓名：</div>
							<div class="db-row-content">jiakairong</div>
						</li>
					</ul>
				</li>
			</ul>
			<ul>
				<li class="db-category">
					<h4 class="resume-title">从业经历</h4>
					<table class="table-data">
						<thead>
							<tr>
								<th>起止时间</th>
								<th>所在企业</th>
								<th>职务</th>
								<th>工作描述</th>
							</tr>
						</thead>
						<tbody id="expert-resume"></tbody>
					</table>
				</li>
			</ul>
			<ul>
				<li class="db-category">
					<h4 class="certificate-title">荣誉证书</h4>
					<table class="table-data">
						<thead>
							<tr>
								<th>证书名称</th>
								<th>扫描件</th>
							</tr>
						</thead>
						<tbody id="expert-certificate"></tbody>
					</table>
				</li>
			</ul>
			<div  class="db-description">
				<div class="db-desc-title">修改原因：</div>
				<div class="db-desc-content update-reason">jioawejgaiowjefaowie</div>
			</div>
			<div  class="db-description refuse-reason">
				<div class="db-desc-title">拒绝理由：</div>
				<div class="db-desc-content"><textarea name="reason"></textarea></div>
			</div>
			<div class="db-buttons">
				<div class="detail-close">关闭</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>
<script type="text/javascript">
// 新申请
var columns1 = [ {field : null,title : '管家姓名',width : '150',align : 'center',formatter:function(item){
				return '<span class="green-msg" onclick="expertDetail('+item.id+' ,0)">'+item.realname+'</span>';
			}
		},
		{field : 'mobile',title : '手机号',width : '140',align : 'center'},
		{field : 'email',title : '邮箱号',width : '140',align : 'center'},
		{field : 'idcard',title : '身份证',width : '140',align : 'center'},
		{field : 'addtime',title : '资料修改时间',align : 'center', width : '180'},
		{field : 'reason' ,title:'修改理由',width:200 ,align:'center' ,length:20},
		{field : null,title : '操作',align : 'center', width : '120',formatter: function(item){
			var button = '<a href="javascript:void(0);" onclick="expertDetail('+item.id+' ,1)" class="tab-button but-blue"> 通过</a>&nbsp;';
			button += '<a href="javascript:void(0);" onclick="expertDetail('+item.id+' ,2)" class="tab-button but-red"> 拒绝</a>';
			return button;
		}
	}];
//合作中
var columns2 = [ {field : null,title : '管家姓名',width : '150',align : 'center',formatter:function(item){
				return '<span class="green-msg" onclick="expertDetail('+item.id+' ,0)">'+item.realname+'</span>';
			}
		},
		{field : 'mobile',title : '手机号',width : '140',align : 'center'},
		{field : 'email',title : '邮箱号',width : '140',align : 'center'},
		{field : 'idcard',title : '身份证',width : '140',align : 'center'},
		{field : 'addtime',title : '资料修改时间',align : 'center', width : '180'},
		{field : 'reason' ,title:'修改理由',width:140 ,align:'center' ,length:20}];
//已拒绝
var columns3 = [ {field : null,title : '管家姓名',width : '150',align : 'center',formatter:function(item){
				return '<span class="green-msg" onclick="expertDetail('+item.id+' ,0)">'+item.realname+'</span>';			
			}
		},
		{field : 'mobile',title : '手机号',width : '140',align : 'center'},
		{field : 'email',title : '邮箱号',width : '140',align : 'center'},
		{field : 'idcard',title : '身份证',width : '140',align : 'center'},
		{field : 'addtime',title : '资料修改时间',align : 'center', width : '180'},
		{field : 'reason' ,title:'拒绝理由',width:140 ,align:'center' ,length:20}];

var formObj = $('#search-condition');
changeStatusData(0);
function changeStatusData(status) {
	if (status == 0) {
		var columns = columns1;
	} else if (status == 1) {
		var columns = columns2;
	} else if (status == 2) {
		var columns = columns3;
	}
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/experts/expert_update/getBridgeExpertData',
		pageNumNow:1,
		searchForm:'#search-condition',
		tableClass:'table-data'
	});
}
//导航栏切换
$('.nav-tabs li').click(function(){
	formObj.find("input[type='text']").val('');
	if (!$(this).hasClass('active')) {
		$(this).addClass('active').siblings().removeClass('active');
		var status = $(this).attr('data-val')
		formObj.find('input[name=status]').val(status);
		changeStatusData(status);
	}
})

function expertDetail(mapid ,type) {
	$.ajax({
		url:'/admin/a/experts/expert_update/getExpertDetail',
		type:'post',
		dataType:'json',
		data:{mapid:mapid},
		success:function(data){
			if ($.isEmptyObject(data)) {
				alert('请确认选择的数据');
				return false;
			}
			var expert = data.expert;
			var bridge = data.bridge;
			$('.detail-title').html('管家详情：'+expert.realname);
			//管家基本信息
			var basicInfo = [
						{'title':'手机号','content':bridge.mobile,'isModify':expert.mobile == bridge.mobile ? 0 : 1,'type':'text'},
						{'title':'邮箱号','content':bridge.email,'isModify':expert.email == bridge.email ? 0 : 1,'type':'text'},
						{'title':'性别','content':bridge.sex==1 ?'男':'女','isModify':expert.sex == bridge.sex ? 0 : 1,'type':'text'},
						{'title':'昵称','content':bridge.nickname,'isModify':expert.nickname == bridge.nickname ? 0 : 1,'type':'text'},
						{'title':'身份证','content':bridge.idcard,'isModify':expert.idcard == bridge.idcard ? 0 : 1,'type':'text'},
						{'title':'微信号','content':bridge.weixin,'isModify':expert.weixin == bridge.weixin ? 0 : 1,'type':'text'},
						{'title':'身份证扫描件正面','content':bridge.idcardpic,'isModify':expert.idcardpic == bridge.idcardpic ? 0 : 1,'type':'img'},
						{'title':'管家头像','content':bridge.small_photo,'isModify':expert.small_photo == bridge.small_photo ? 0 : 1,'type':'img'},
						{'title':'身份证扫描件反面','content':bridge.idcardconpic,'isModify':expert.idcardconpic == bridge.idcardconpic ? 0 : 1,'type':'img'},
						{'title':'管家背景','content':bridge.big_photo,'isModify':expert.big_photo == bridge.big_photo ? 0 : 1,'type':'img'},
						{'title':'擅长线路','content':bridge.destName,'isModify':expert.expert_dest == bridge.expert_dest ? 0 : 1,'type':'text'},
						{'title':'毕业院校','content':bridge.school,'isModify':expert.school == bridge.school ? 0 : 1,'type':'text'},
						{'title':'旅游从业','content':bridge.profession,'isModify':expert.profession == bridge.profession ? 0 : 1,'type':'text'},
						{'title':'工作年限','content':bridge.working,'isModify':expert.working == bridge.working ? 0 : 1,'type':'text'},
						{'title':'所在地','content':bridge.address,'isModify':expert.address == bridge.address ? 0 : 1,'type':'text'},
						{'title':'上门服务地区','content':bridge.servinceName,'isModify':expert.visit_service == bridge.visit_service ? 0 : 1,'type':'text'},
						{'title':'个人描述','content':bridge.talk,'isModify':expert.talk == bridge.talk ? 0 : 1,'type':'text'}
					];
			var html = '';
			$.each(basicInfo ,function(k ,v){
				html += '<li class="db-data-row">';
				if (v.isModify == 1) {
					html += '<div class="db-row-title" style="color:red;">'+v.title+'：</div>';
				} else {
					html += '<div class="db-row-title">'+v.title+'：</div>';
				}
				if (v.type == 'text') {
					html += '<div class="db-row-content">'+v.content+'</div>';
				} else {
					html += '<div class="db-row-content"><img style="width:80px;" class="img-w" src="'+v.content+'" data-zoom="'+v.content+'" /></div>';
				}
				html += '</li>';
			})
			$('#basic-info').html(html);
			var html = '';
			var s = true;
			$.each(bridge.resume ,function(k ,v) {
				html += '<tr><td>'+v.starttime+'到'+v.endtime+'</td><td>'+v.company_name+'</td><td>'+v.job+'</td><td>'+v.description+'</td></tr>';
				if (typeof expert.resume[k] != 'undefined') {
					var val = expert.resume[k];
					if (v.starttime != val.starttime || v.endtime != val.endtime || v.company_name != val.company_name || v.job != val.job || v.description != val.description) {
						s = false;
					}
				} else {
					s = false;
				}
			})
			$('#expert-resume').html(html);
			if (s == false) {
				$('.resume-title').css('color','red');
			} else {
				$('.resume-title').css('color','#444');
			}
			var html = '';
			var s = true;
			$.each(bridge.certificate ,function(k ,v) {
				var src = typeof v.certificatepic == 'string' ? '<img style="width:40px;" src="'+v.certificatepic+'">' : '';
				html += '<tr><td>'+v.certificate+'</td><td>'+src+'</td></tr>';
				if (typeof expert.certificate[k] != 'undefined') {
					var val = expert.certificate[k];
					if (v.certificatepic != val.certificatepic || v.certificate != val.certificate) {
						s = false;
					}
				} else {
					s = false;
				}
			})
			$('#expert-certificate').html(html);
			if (s == false) {
				$('.certificate-title').css('color','red');
			} else {
				$('.certificate-title').css('color','#444');
			}
			if (type ==0) {
				$('.db-buttons').find('div').eq(0).nextAll().remove();
				$('.refuse-reason').hide();
			} else if (type == 1) {
				$('.db-buttons').find('div').eq(0).nextAll().remove();
				$('.db-buttons').append('<div data-map="'+bridge.mapid+'" onclick="bridge_through(this);">通过</div>');
				$('.refuse-reason').hide();
			} else if (type == 2) {
				$('.db-buttons').find('div').eq(0).nextAll().remove();
				$('.db-buttons').append('<div data-map="'+bridge.mapid+'" onclick="bridge_refuse(this);">拒绝</div>');
				$('.refuse-reason').show();
			}
			$('.update-reason').html(bridge.reason);
			$('.detail-box,.mask-box').show();
			$('.img-w').imgPreview();
		}
	});
}
$.fn.extend({
	disableButton:function(options){
		//var 
		alert(this.attr('data-map'));
	}
});
//关闭管家详情
$('.detail-close').click(function() {
	$('.detail-box,.mask-box').hide();
})
//拒绝申请
function bridge_refuse(obj) {
//	$(obj).disableButton();
//	return false;
	$.ajax({
		url:'/admin/a/experts/expert_update/refuse',
		type:'post',
		data:{mapid:$(obj).attr('data-map'),reason:$(obj).parent('div').prev('.refuse-reason').find('textarea').val()},
		dataType:'json',
		success:function(data) {
			if (data.code == '2000') {
				$("#dataTable").pageTable({
					columns:columns1,
					url:'/admin/a/experts/expert_update/getBridgeExpertData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
				$('.detail-box,.mask-box').hide();
			} else {
				alert(data.msg);
			}
		}
	});
}
//通过申请
function bridge_through(obj) {
	$.ajax({
		url:'/admin/a/experts/expert_update/through',
		type:'post',
		data:{mapid:$(obj).attr('data-map')},
		dataType:'json',
		success:function(data) {
			if (data.code == '2000') {
				$("#dataTable").pageTable({
					columns:columns1,
					url:'/admin/a/experts/expert_update/getBridgeExpertData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
				$('.detail-box,.mask-box').hide();
			} else {
				alert(data.msg);
			}
		}
	});
}          
</script>