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
    </style>
</head>
<body>
    <div class="RongBox">
    	<form action="" id="edit-dest">
        <div class="RongCon">
            <div class="flex10">
                <div class="ListTitle"><i>*</i>上级</div>
                <div class="ListSub">
                    <div class="ListInput">
                    	<input type="text" id="parent" data-id="<?php echo $pid;?>" value="<?php echo $parent_name?>" name="parent" onfocus="showDestBaseTree(this)">
                    </div>
                    <div class="ListTip">如果不选则为顶级</div>
                </div>
            </div>
            <div class="flex10">
                <div class="ListTitle"><i>*</i>名称</div>
                <div class="ListSub">
                    <div class="ListInput"><input type="text" value="<?php echo $kindname?>" name="kindname"></div>
                    <div class="ListTip"></div>
                </div>
            </div>
            <div class="flex10">
                <div class="flex5">
                    <div class="ListTitle"><i>*</i>全拼</div>
                    <div class="ListSub">
                        <div class="ListInput"><input type="text" value="<?php echo $enname?>" name="enname"></div>
                        <div class="ListTip"></div>
                    </div>
                </div>
                <div class="flex5 borNone">
                    <div class="ListTitle"><i>*</i>简拼</div>
                    <div class="ListSub">
                        <div class="ListInput"><input type="text" value="<?php echo $simplename?>" name="simplename"></div>
                        <div class="ListTip"></div>
                    </div>
                </div>
            </div>
            <div class="flex10">
                <div class="flex5">
                    <div class="ListTitle"><i>*</i>是否启用</div>
                    <div class="ListSub">
                        <label><input type="radio" name="isopen" value="1" <?php if ($isopen==1){echo 'checked="checked"';}?>>启用</label>
                        <label><input type="radio" name="isopen" value="0" <?php if ($isopen==0){echo 'checked="checked"';}?>>停用</label>
                    </div>
                </div>
            </div>
             <div class="flex10">
                <div class="ListTitle"><i>*</i>排序值</div>
                <div class="ListSub">
                    <div class="sizeConsInput"><input type="text" value="<?php echo $displayorder?>" name="displayorder"></div>
                    <span class="kaosText">越大越靠前</span>
                </div>
            </div>
             <div class="flex10">
                <div class="ListTitle"><i>*</i>是否热门</div>
                <div class="ListSub">
                    <label><input type="radio" name="ishot" value="1" <?php if ($ishot==1){echo 'checked="checked"';}?>>是</label>
                    <label><input type="radio" name="ishot" value="0" <?php if ($ishot==0){echo 'checked="checked"';}?>>否</label>
                </div>
            </div>
            <div class="flex10">
                <div class="ListTitle"><i>*</i>类型</div>
                <div class="ListSub">
                    <label><input type="radio" name="type" value="1" <?php if ($type==1){echo 'checked="checked"';}?>>目的地</label>
                    <label><input type="radio" name="type" value="2" <?php if ($type==2){echo 'checked="checked"';}?>>景点</label>
                </div>
            </div>
        </div>
        <div class="btnBoix">
        	<input type="hidden" name="pid" value="<?php echo $pid?>">
        	<input type="hidden" name="id" value="<?php echo $id?>">
            <div class="Ybuoon"><input type="submit" value="确定"></div>
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
//生成拼音
$("input[name=kindname]").keyup(function(){
	var name = $(this).val();
	var enname = pinyin.getFullChars(name).toLowerCase();
	var simplename = pinyin.getCamelChars(name).toLowerCase();
	$("input[name='simplename']").val(simplename);
	$("input[name='enname']").val(enname);
})
//排序正整数
$('input[name=displayorder]').verifNum();
//添加数据 
$('#edit-dest').submit(function(){
	$(this).find('input[name=pid]').val($(this).find('input[name=parent]').attr('data-id'));
	$.ajax({
		url:'/admin/a/dest/dest_base/edit',
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(result) {
			if (result.code == 2000) {
				layer.confirm(result.msg, {btn:['确认']},function(){
					t33_close_iframe();
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