<style>
.form-horizontal .form-group .fg-title{width:18%;}
.fg-radio{vertical-align: text-bottom;margin-bottom: -5px !important}
.bts-label{display: inline-block;border: 1px solid #ccc;padding: 3px 5px;border-radius: 2px;margin-top: 5px;cursor: pointer;}
.bts-label:hover{background:#2DC3E8;color:#fff;}
.editor-div{height: 110px;border: 1px solid #ccc;padding: 5px 10px;
min-height: 110px; 
max-height: 300px; 
outline: 0; 
word-wrap: break-word; 
overflow-x: hidden; 
overflow-y: auto; 
}
.bts-var{font-weight:600;}
</style>
<div class="fb-form">
	<form method="post" action="#" id="add-form" class="form-horizontal">
		<div class="form-group">
			<div class="fg-title">变量标签：</div>
            <div class="fg-input">
            	<?php if (isset($btsArr[$share['code']])):?>
            	<?php foreach($btsArr[$share['code']] as $v):?>
            	<span class="bts-label" data-val="<?php echo $v['var']?>"><?php echo $v['name']?></span>
            	<?php endforeach;?>
            	<?php endif;?>
            </div>
        </div>
		<div class="form-group">
			<div class="fg-title">分享标题：<i>*</i></div>
            <div class="fg-input">
            	<div class="editor-div" id="title" contenteditable="true"><?php echo $share['title'];?>&nbsp;</div>
            	<input type="hidden" name="title" value="">
            </div>
        </div>
        <div class="form-group">
			<div class="fg-title">分享描述：<i>*</i></div>
            <div class="fg-input">
            	<div class="editor-div" id="desc" contenteditable="true"><?php echo $share['desc'];?>&nbsp;</div>
            	<input type="hidden" name="desc" value="">
            </div>
        </div>
        <div class="form-group">
			<div class="fg-title">分享图标：<i>*</i></div>
            <div class="fg-input">
            	<ul>
            		<?php if (isset($iconArr[$share['code']])):?>
            		<?php foreach($iconArr[$share['code']] as $v):?>
            		<li><label>
            			<input type="radio" class="fg-radio" name="imgUrl" <?php if($share['imgUrl']==$v['icon']){echo 'checked';}?> value="<?php echo $v['icon']?>">
            			<?php echo $v['name']?>
            		</label></li>
            		<?php endforeach;?>
            		<?php endif;?>
				</ul>
            </div>
        </div>
		<div class="form-group">
			<input type="hidden" name="id" value="<?php echo $share['id'];?>">
            <input type="submit" class="fg-but" value="确定">
        </div>
        <div class="clear"></div>
	</form>
</div>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>
<script>
var lastEditRangec;
var selection;
$('.editor-div').click(function(){
	textObj = $(this);
	selection = getSelection();
    // 设置最后光标对象
    lastEditRange = selection.getRangeAt(0);
});
$('.editor-div').keyup(function(){
	selection = getSelection();
	// 设置最后光标对象
    lastEditRange = selection.getRangeAt(0);
})

//选择标签
$('.bts-label').click(function(){
	if (typeof lastEditRange == 'object') {
		var html = '<span contenteditable="false" class="bts-var">'+$(this).attr('data-val')+'</span>&nbsp;';
	   	var oFragment = lastEditRange.createContextualFragment(html);
	  	oLastNode = oFragment.lastChild;
	   	lastEditRange.insertNode(oFragment);
	   	//重新设置光标位置
	   	lastEditRange.setEndAfter(oLastNode);
	   	lastEditRange.setStartAfter(oLastNode);
// 	    selection.removeAllRanges();//清除选择
// 	    selection.addRange(lastEditRange);
	}
})
//提交表单
$('#add-form').submit(function(){
	var title = $('#title').html().replace(/&nbsp;/g,'');
	var desc = $('#desc').html().replace(/&nbsp;/g,'')
	$(this).find('input[name=title]').val(title);
	$(this).find('input[name=desc]').val(desc);
	$.ajax({
		url:'/admin/a/share/app_share/edit',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				parent[0].showMsg(result.msg);
				var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
				parent.layer.close(index); //再执行关闭 
			} else {
				layer.msg(result.msg ,{icon:2});
			}
		}
	});
	return false;
})

</script>
