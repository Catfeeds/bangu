<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>tltle</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
    <style type="text/css">
        *{ margin: 0; padding: 0 ; font-family:"Microsoft YaHei"; font-size: 12px;}
        body{ background: #fff; }
        i{ font-style: normal; }
        .RongBox{ width: 800px; background: #fff;}
        .flex10{ width: 100%; position: relative;height: 40px; line-height: 40px; border-bottom: 1px solid #f1f1f1; border-right: 1px solid #f1f1f1; box-sizing:border-box }
        .flex5{ width: 50%; position: relative;height: 40px; line-height: 40px; float: left; border-right: 1px solid #f1f1f1; box-sizing:border-box}
        .ListTitle{ width:90px; text-align: right; height: 40px; line-height: 40px; padding-right: 10px; border-right: 1px solid #f1f1f1;}
        .ListTitle i{ color: #f30; }
        .ListSub{ position: absolute; top: 5px; bottom: 5px; right: 0; left: 110px;line-height: 30px; }
        .ListSub label{ margin-right: 10px; }
        .ListInput{ float: left; }
        .ListInput input{ height: 24px; line-height: 24px; border: 1px solid #ccc; width:200px; }
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
    	h4{  border-bottom: 1px solid #f1f1f1;padding: 10px 0px 10px 21px;}
    	.table-data td{text-align:center;}
    	.table-data input{height:24px;}
    	.expert-resume{border: none;}
    	.r-time{width:75px;}
    	.expert-resume span{font-weight:500;margin-left:20px;border:1px solid #ccc;padding:2px 7px;border-radius:3px;cursor: pointer;}
    </style>
</head>
<body>
    <div class="RongBox">
    	<form action="" id="edit-expert">
        <div class="RongCon">
        	<h4>基本资料</h4>
            <div class="flex10">
                <div class="flex5">
                    <div class="ListTitle">性别</div>
                    <div class="ListSub">
	                    <label><input type="radio" name="sex" value="0" <?php if($expert['sex']==0){echo "checked='checked'";}?>>女</label>
                        <label><input type="radio" name="sex" value="1" <?php if($expert['sex']==1){echo "checked='checked'";}?>>男</label>
                        <label><input type="radio" name="sex" value="-1" <?php if($expert['sex']==-1){echo "checked='checked'";}?>>保密</label>
	                </div>
                </div>
                <div class="flex5 borNone">
                    <div class="ListTitle">身份证</div>
                    <div class="ListSub">
                        <div class="ListInput"><input type="text" name="idcard" value="<?php echo $expert['idcard']?>" maxlength="18"></div>
                        <div class="ListTip"></div>
                    </div>
                </div>
            </div>
            <div class="flex10">
                <div class="flex5">
                    <div class="ListTitle">毕业院校</div>
                    <div class="ListSub">
                        <div class="ListInput"><input type="text" name="school" value="<?php echo $expert['school']?>"></div>
                        <div class="ListTip"></div>
                    </div>
                </div>
                <div class="flex5 borNone">
                    <div class="ListTitle">工作年限</div>
                    <div class="ListSub">
                        <div class="ListInput"><input type="text" name="working" value="<?php echo $expert['working']?>"></div>
                        <div class="ListTip"></div>
                    </div>
                </div>
            </div>
            
             <div class="flex10">
                <div class="ListTitle">个人描述</div>
                <div class="ListSub" style="width:78%;">
                    <div class="ListInput" style="width:100%;">
                    	<input type="text" style="width:96% !important" name="talk" value="<?php echo $expert['talk']?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="RongCon">
        	<h4 class="expert-resume">从业经历<span id="add-row">增加</span></h4>
        	<table class="table-data" style="margin:0px 4px;;width:99%;">
        		<thead>
        			<tr>
	        			<th>起止时间</th>
	        			<th>所在企业</th>
	        			<th>职务</th>
	        			<th>工作描述</th>
	        			<th>操作</th>
        			</tr>
        		</thead>
        		<tbody class="resume-row">
        			<?php foreach($resume as $v):?>
        			<tr>
	        			<td>
	        				<input type="text" class="r-time" readonly="readonly" name="starttime[]" value="<?php echo $v['starttime']?>">到
	        				<input type="text" class="r-time" readonly="readonly" name="endtime[]" value="<?php echo $v['endtime']?>">
	        			</td>
	        			<td><input type="text" name="company_name[]" value="<?php echo $v['company_name']?>"></td>
	        			<td><input type="text" name="job[]" value="<?php echo $v['job']?>"></td>
	        			<td><input type="text" name="description[]" value="<?php echo $v['description']?>"></td>
	        			<td><a href="javascript:void(0);" onclick="del(this)" class="tab-button but-red">删除</a></td>
        			</tr>
        			<?php endforeach;?>
        		</tbody>
        	</table>
        </div>
        <div class="btnBoix">
        	<input type="hidden" name="id" value="<?php echo $expert['id'] ?>">
            <div class="Ybuoon"><input type="submit" value="确定"></div>
            <div class="Nbuoon" onclick="t33_close_iframe_noreload();"><input type="button" value="取消"></div>
        </div>
        </form>
    </div>
    
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script>
$('input[name=working]').verifNum();
$('input[name=idcard]').verifNum();

$('#add-row').click(function(){
	var html = '<tr>'+
					'<td>'+
						'<input type="text" class="r-time" readonly="readonly" name="starttime[]">到'+
						'<input type="text" class="r-time" readonly="readonly" name="endtime[]">'+
					'</td>'+
					'<td><input type="text" name="company_name[]"></td>'+
					'<td><input type="text" name="job[]"></td>'+
					'<td><input type="text" name="description[]"></td>'+
					'<td><a href="javascript:void(0);" onclick="del(this)" class="tab-button but-red">删除</a></td>'+
				'</tr>';
	$('.resume-row').append(html);
	$('.r-time').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
		validateOnBlur:false,
	});
})
function del(obj) {
	$(obj).parents('tr').remove();
}

$('.r-time').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});


//更新数据 
$('#edit-expert').submit(function(){
	$.ajax({
		url:'/admin/a/experts/expert_list/edit_expert',
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(result) {
			if (result.code == 2000) {
				layer.confirm(result.msg, {btn:['确认']},function(){
					t33_close_iframe_noreload();
				});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})
</script>
</body>
</html>