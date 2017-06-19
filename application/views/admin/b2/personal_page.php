<style type="text/css">
.box{ background: #fff; font-size: 14px;}
.sheetMain{ padding: 30px 0 0 30px;  width: 1000px;}
.sheetTitle{ float: left; margin-right: 10px; width: 90px; height: 40px; }
.sheetCon{ float: left; }
.input[type="text"]{
 width: 150px; padding-left: 10px;
}
.sheetLlst{ width: 100%; overflow: hidden; height: 40px;line-height: 40px;}
.sheetLlst2{ width: 100%; overflow: hidden;line-height: 40px;}
.input{ height: 24px; padding: 0; line-height: 24px }
.select{ height: 24px; line-height: 24px; padding: 0 12px ; }
.checkboxList li{ float: left; margin-right: 30px; }
.checkboxList li input{ position:relative; top: 3px; opacity: 1;  left: 0; right: 0; width: 16px; height: 16px;}
.checkboxBar{ padding: 0 5px; height: 30px; line-height: 30px; position: relative; top: 5px; border-radius: 1px; background: #f54; float: left;  margin-right:30px; color: #fff;}
.radioList li{ float: left; margin-right: 30px; }
.radioList li input{ position:relative; top: 3px; opacity: 1;  left: 0; right: 0; width: 16px; height: 16px;}
.interest{ overflow: hidden; display: inline-block; }
.interest li{ float: left; margin-right: 30px; }
.interestChox{ width: 800px; }
.interestChox li{ width: 120px;float: left; }
.interestChox li input{ position:relative; top: 3px; opacity: 1;  left: 0; right: 0; width: 16px; height: 16px;}
.xingge{ float: left; width: 800px; }
</style>
<div class="box">

<form action="#" method="post" id="personal_page" class="personal_page" >
<div class="sheetMain">
	<!-- <div class="sheetLlst">
		<div class="sheetTitle">毕业院校</div>
		<div class="sheetCon"><input type="text" name="school" class="input"></div>
	</div> -->

	<div class="sheetLlst">
		<div class="sheetTitle">你的家乡</div>
		<div class="sheetCon">
		<select class="select" name="provinces" id="provinces" onchange="change_city(this)">
			<option value="">选择省份</option>
			<?php foreach($provinces AS $k=>$v):?>
				<?php if($more_detail['province']==$v['id']):?>
					<option value="<?php echo $v['id']?>" selected="selected"><?php echo $v['name']?></option>
				<?php else:?>
					<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
				<?php endif;?>

			<?php endforeach;?>
		</select>
		<select class="select" name="city" id="city"></select>
		</div>
	</div>

	<div class="sheetLlst">
		<div class="sheetTitle">你的星座</div>
		<div class="sheetCon">
			<select class="select" name="xingzuo" id="xingzuo">
			<option value="">--请选择--</option>
			<?php foreach($constellation AS $k=>$v):?>
				<?php if($more_detail['constellation']==$v['dict_id']):?>
					<option selected="selected" value="<?php echo $v['dict_id']?>"><?php echo $v['description']?></option>
				<?php else:?>
					<option value="<?php echo $v['dict_id']?>"><?php echo $v['description']?></option>
				<?php endif;?>
			<?php endforeach;?>
			</select>
		</div>
	</div>


	<div class="sheetLlst2">
		<div class="sheetTitle">性格特点</div>
		<div class="sheetCon xingge">
		<div class="checkboxBar">多选</div>
			<ul class="checkboxList">
			<?php foreach($attr AS $k=>$v):?>
				<?php if(!empty($label_attr) && in_array($v['dict_id'], $label_attr)):?>
				<li><input type="checkbox" checked="checked" name="attr[]" value="<?php echo $v['dict_id']?>" data-field="attr_id" data-table="u_expert_attr" id="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
			<?php else:?>
				<li><input type="checkbox"  name="attr[]" value="<?php echo $v['dict_id']?>" data-field="attr_id" data-table="u_expert_attr" id="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
			<?php endif;?>
			<?php endforeach;?>
			</ul>
		</div>
	</div>

	<div class="sheetLlst">
		<div class="sheetTitle">出生年代</div>
		<div class="sheetCon">
			<ul class="radioList">
			<?php foreach($decade AS $k=>$v):?>
				<?php if($more_detail['decade']==$v['dict_id']):?>
					<li><input type="radio" checked name="decade" value="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
				<?php else:?>
					<li><input type="radio" name="decade" value="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
				<?php endif;?>
			<?php endforeach;?>
			</ul>
		</div>
	</div>

	<div class="sheetLlst">
		<div class="sheetTitle">我的血型</div>
		<div class="sheetCon">
			<ul class="radioList">
			<?php foreach($blood AS $k=>$v):?>
				<?php if($more_detail['blood']==$v['dict_id']):?>
					<li><input checked type="radio" name="blood" value="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
				<?php else:?>
					<li><input  type="radio" name="blood" value="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
				<?php endif;?>
			<?php endforeach;?>
			</ul>
		</div>
	</div>

	<div class="sheetLlst">
		<div class="sheetTitle">个人爱好</div>
		<div class="sheetCon">
			<ul class="interest">
				<li><input type="text" name="interest1" placeholder="兴趣1" class="input inputText" value="<?php if(isset($more_detail['hobby_arr'][0]) && $more_detail['hobby_arr'][0]!='') echo $more_detail['hobby_arr'][0]?>"/></li>
				<li><input type="text" name="interest2" placeholder="兴趣2(选填)" class="input inputText" value="<?php if(isset($more_detail['hobby_arr'][1]) && $more_detail['hobby_arr'][1]!='') echo $more_detail['hobby_arr'][1]?>"/></li>
				<li><input type="text" name="interest3" placeholder="兴趣3(选填)" class="input inputText" value="<?php if(isset($more_detail['hobby_arr'][2]) && $more_detail['hobby_arr'][2]!='') echo $more_detail['hobby_arr'][2]?>"/></li>
				<li><input type="text" name="interest4" placeholder="兴趣4(选填)" class="input inputText" value="<?php if(isset($more_detail['hobby_arr'][3]) && $more_detail['hobby_arr'][3]!='') echo $more_detail['hobby_arr'][3]?>"/></li>
			</ul>
		</div>
	</div>

	<div class="sheetLlst">
		<div class="sheetTitle">去过地方</div>
		<div class="sheetCon">
			<ul class="interest">
				<li><input type="text" name="placeed1" placeholder="填写地方名称" class="input inputText" value="<?php if(isset($more_detail['pass_way_arr'][0]) && $more_detail['pass_way_arr'][0]!='') echo $more_detail['pass_way_arr'][0]?>"></li>
				<li><input type="text" name="placeed2" placeholder="填写地方名称(选填)" class="input inputText" value="<?php if(isset($more_detail['pass_way_arr'][1]) && $more_detail['pass_way_arr'][1]!='') echo $more_detail['pass_way_arr'][1]?>"></li>
				<li><input type="text" name="placeed3" placeholder="填写地方名称(选填)" class="input inputText" value="<?php if(isset($more_detail['pass_way_arr'][2]) && $more_detail['pass_way_arr'][2]!='') echo $more_detail['pass_way_arr'][2]?>"></li>
				<li><input type="text" name="placeed4" placeholder="填写地方名称(选填)" class="input pass_way" value="<?php if(isset($more_detail['pass_way_arr'][3]) && $more_detail['pass_way_arr'][3]!='') echo $more_detail['pass_way_arr'][3]?>"></li>
			</ul>
		</div>
	</div>

	<div class="sheetLlst">
		<div class="sheetTitle">喜欢美食</div>
		<div class="sheetCon">
			<ul class="interest">
				<li><input type="text" name="food1" placeholder="填写美食" class="input inputText" value="<?php if(isset($more_detail['like_food_arr'][0]) && $more_detail['like_food_arr'][0]!='') echo $more_detail['like_food_arr'][0]?>"></li>
				<li><input type="text" name="food2" placeholder="填写美食(选填)" class="input inputText" value="<?php if(isset($more_detail['like_food_arr'][1]) && $more_detail['like_food_arr'][1]!='') echo $more_detail['like_food_arr'][1]?>"></li>
				<li><input type="text" name="food3" placeholder="填写美食(选填)" class="input inputText" value="<?php if(isset($more_detail['like_food_arr'][2]) && $more_detail['like_food_arr'][2]!='') echo $more_detail['like_food_arr'][2]?>"></li>
				<li><input type="text" name="food4" placeholder="填写美食(选填)" class="input inputText" value="<?php if(isset($more_detail['like_food_arr'][3]) && $more_detail['like_food_arr'][3]!='') echo $more_detail['like_food_arr'][3]?>"></li>
			</ul>
		</div>
	</div>

	<div class="sheetLlst2">
		<div class="sheetTitle">喜欢去哪玩</div>
		<div class="sheetCon float">
			<div class="checkboxBar">出境</div>
			<ul class="interest interestChox">
			<?php foreach($jw AS $k=>$v):?>
				<?php if(!empty($go_place) && in_array($v['dict_id'], $go_place)):?>
					<li><input type="checkbox" checked="checked" name="jw[]" value="<?php echo $v['dict_id']?>" data-field="dest_id" data-table="u_expert_go" id="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
				<?php else:?>
					<li><input type="checkbox"  name="jw[]" value="<?php echo $v['dict_id']?>" data-field="dest_id" data-table="u_expert_go" id="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
				<?php endif;?>
			<?php endforeach;?>
			</ul>
		</div>
		<div class="sheetTitle"></div>
		<div class="sheetCon float">
			<div class="checkboxBar ">国内</div>
			<ul class="interest interestChox">
			<?php foreach($gn AS $k=>$v):?>
				<?php if(!empty($go_place) && in_array($v['dict_id'],$go_place)):?>
					<li><input type="checkbox" checked="checked" name="gn[]" value="<?php echo $v['dict_id']?>" data-field="dest_id" data-table="u_expert_go" id="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
				<?php else:?>
					<li><input type="checkbox"  name="gn[]" value="<?php echo $v['dict_id']?>" data-field="dest_id" data-table="u_expert_go" id="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
				<?php endif;?>
			<?php endforeach;?>
			</ul>
		</div>
	</div>

	<div class="sheetLlst2">
		<div class="sheetTitle">喜欢怎样玩</div>
		<div class="sheetCon float">
			<div class="checkboxBar">多选</div>
			<ul class="interest interestChox">
			<?php foreach($play AS $k=>$v):?>
				<?php if(!empty($expert_play) && in_array($v['dict_id'],$expert_play)):?>
					<li><input type="checkbox" checked="checked"  name="play[]" value="<?php echo $v['dict_id']?>" data-field="way_id" data-table="u_expert_play" id="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
				<?php else:?>
					<li><input type="checkbox"  name="play[]" value="<?php echo $v['dict_id']?>" data-field="way_id" data-table="u_expert_play" id="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
				<?php endif;?>
			<?php endforeach;?>
			</ul>
		</div>
	</div>

	<div class="sheetLlst2">
		<div class="sheetTitle">喜欢跟谁玩</div>
		<div class="sheetCon float">
			<div class="checkboxBar">多选</div>
			<ul class="interest interestChox">
			<?php foreach($with_who AS $k=>$v):?>
				<?php if(!empty($expert_with) && in_array($v['dict_id'],$expert_with)):?>
					<li><input type="checkbox" checked="checked" name="with_who[]" value="<?php echo $v['dict_id']?>" data-field="crowd_id" data-table="u_expert_with" id="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
				<?php else:?>
					<li><input type="checkbox"  name="with_who[]" value="<?php echo $v['dict_id']?>" data-field="crowd_id" data-table="u_expert_with" id="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
				<?php endif;?>
			<?php endforeach;?>
			</ul>
		</div>
	</div>

	<div class="sheetLlst2">
		<div class="sheetTitle">平日休闲方式</div>
		<div class="sheetCon float">
			<div class="checkboxBar">多选</div>
			<ul class="interest interestChox">
			<?php foreach($relax AS $k=>$v):?>
			<?php if(!empty($expert_relax) && in_array($v['dict_id'],$expert_relax)):?>
				<li><input type="checkbox" checked="checked" name="relax[]" value="<?php echo $v['dict_id']?>" data-field="relax_id" data-table="u_expert_relax" id="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
			<?php else:?>
				<li><input type="checkbox"  name="relax[]" value="<?php echo $v['dict_id']?>" data-field="relax_id" data-table="u_expert_relax" id="<?php echo $v['dict_id']?>"><span><?php echo $v['description']?></span></li>
			<?php endif;?>
			<?php endforeach;?>
			</ul>
		</div>
	</div>
	<div style="margin-top: 68px; text-align: center">
			<input type="submit" value="保存">
	</div>
</div>
</div>

</form>
<div>
<script type="text/javascript">
var choose_city = "<?php echo $more_detail['city']?>";
$(document).ready(function(){
	$("input[type='checkbox']").click(function(){
 		 edit_multiSelect(this);
	});

$('#personal_page').submit(function(){
      $.post(
        "<?php echo site_url('admin/b2/personal_page/update_page')?>",
        $('#personal_page').serialize(),
        function(data) {
          data = eval('('+data+')');
          if (data.code == 200) {
            alert(data.msg);
            location.reload();
          } else {
            alert(data.msg);
          }
        }
      );
      return false;
    });
   change_city($("#provinces"));
});


function change_city(obj){
	var province_id = $(obj).val();
	if(province_id!=''){
		$.post("<?php echo base_url();?>admin/b2/personal_page/ajax_get_area",{'province_id':province_id},function (data){
			$("#city").html("");
			data = eval('('+data+')');
			$.each(data ,function(key ,val){
				if(choose_city!="" && val.id==choose_city){
					str = "<option selected='selected' value='"+val.id+"'>"+val.name+"</option>";
				}else{
					str = "<option value='"+val.id+"'>"+val.name+"</option>";
				}
				$('#city').append(str);
			});
		});
	}else{
		$('#city').html('');
	}

}


function edit_multiSelect(obj){
	var operator = "";
	var table=$(obj).attr('data-table');
	var field=$(obj).attr('data-field');
	var choose_id = $(obj).val();
	if(!$(obj).is(':checked')){
		operator = "delete";
	}else{
		operator = "add";
	}
	$.post("<?php echo base_url()?>admin/b2/personal_page/ajax_edit_multiSelect",
		{'table':table,'operator':operator,'choose_id':choose_id,'field':field},
		function(data){
			console.log(data);
	});
}
</script>