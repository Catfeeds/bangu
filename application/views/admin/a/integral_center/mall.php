<style type="text/css">
.page-content{ min-width: auto !important; }
input[type=file]{width:68px !important;border: 0 !important;}
.add_btn{ float:left; width:auto !important;  position: relative; top:50px; left:10px;}
#imghead,#imghead1,#imghead2,#imghead3,#imghead4,#imghead5,#imghead6{ float:left;}
</style>
<div class="page-content">
    <ul class="breadcrumb">
        <li>
            <i class="fa fa-home"></i> 
            <a href="<?php echo site_url('admin/a/') ?>"> 首页 </a>
        </li>
        <li class="active"><span>/</span>积分商城</li>
    </ul>
    <div class="page-body">
        <div class="tab-content">
        	<ul class="nav-tabs" id= "data-id">
				<li class="active" data-val="1">已上架 </li>
				<li class="tab-red" data-val="2">已下架</li>
			</ul>
			<br>			
            <a id="add-button" href="javascript:void(0);" class="but-default" >添加商品</a>
            <form action="#" id='search-condition' class="search-condition" method="post">
			<input type="hidden" value="1" name="status">
			</form>
            <div id="dataTable"></div>
        </div>
    </div>
</div>

<div class="form-box fb-body">
    <div class="fb-content" style="width: 800px; max-height:600px;overflow-y:auto;">
        <div class="box-title">
            <h4>添加商品</h4>
            <span class="fb-close">x</span>
        </div>
        <div class="fb-form">
            <form method="post" action="#" id="add-data" class="form-horizontal" >
                <div class="form-group">
                    <div class="fg-title">产品标题：<i>*</i></div>
                    <div class="fg-input">
                        <input type="text" name="p_name" />
                    </div>
                    <span>限18个字以内</span>
                </div>
                <div class="form-group">
                    <div class="fg-title">产品封面图：<i>*</i></div>
                    <div class="fg-input">
                    	<img src="#" style="width: 168px; height: 110px;" id="imghead">
                        <input class="add_btn" onclick="uploadImgFile(this,1);" type="button" value="上传" />
                        <input name="p_show_pic" type="hidden" />
                    </div>
                </div>
                <div class="form-group">
                   <div class="fg-title">产品详情图1：<i>*</i></div>
                    <div class="fg-input">
                        <img src="#" style="width: 300px; height: 200px;" id="imghead1">
						<input class="add_btn" onclick="uploadImgFile(this,2);" type="button" value="上传" />
                        <input name="p_pic1" type="hidden" />
                    </div>                   
                </div>
                <div class="form-group">
                    <div class="fg-title">产品详情图2：</div>
                    <div class="fg-input">
                         <img src="#" style="width: 300px; height: 200px;" id="imghead2">
						<input class="add_btn" onclick="uploadImgFile(this,2);"  type="button" value="上传" />
                        <input name="p_pic2" type="hidden" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">产品详情图3：</div>
                    <div class="fg-input">
                        <img src="#" style="width: 300px; height: 200px;" id="imghead3">
						<input class="add_btn" onclick="uploadImgFile(this,2);"  type="button" value="上传" />
                        <input name="p_pic3" type="hidden" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">产品详情图4：</div>
                    <div class="fg-input">
                         <img src="#" style="width: 300px; height: 200px;" id="imghead4">
						<input class="add_btn" onclick="uploadImgFile(this,2);"  type="button" value="上传" />
                        <input name="p_pic4" type="hidden" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">产品详情图5：</div>
                    <div class="fg-input">
                        <img src="#" style="width: 300px; height: 200px;" id="imghead5">
						<input class="add_btn" onclick="uploadImgFile(this,2);"  type="button" value="上传" />
                        <input name="p_pic5" type="hidden" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">备注：</div>
                    <div class="fg-input">
                        <input type="text" name="p_content" />
                    </div>
                    <span>限10个字以内</span>
                </div>
                <div class="form-group">
                    <div class="fg-title">产品描述：<i>*</i></div>
                    <div class="fg-input">
                        <textarea name="p_describe" style="resize:none"></textarea>
                    </div>
                </div>     
                <div class="form-group">
                    <div class="fg-title">已售：</div>
                    <div class="fg-input">
                        <input type="text" name="p_sold" style="width:100px;" />件
                    </div>
                    <span>默认10-20之间的随机数</span>
                </div>
                <div class="form-group">
                    <div class="fg-title">产品类型：<i>*</i></div>
                    <div class="fg-input">
                        <select name="p_attr_type" oninput="check_val(this);" class="selector kind" style="width:130px;">
                            <option value="0">请选择</option>
                            <option value="1">带金额的产品</option>
                            <option value="2">纯积分产品</option>
                        </select>
                    </div>
                </div>
                <div class="form-group p_integral">
                    <div class="fg-title">积分价格：<i>*</i></div>
                    <div class="fg-input">
                        <input type="text" name="p_integral_price" />
                    </div>
                </div>
                <div class="form-group action">
                    <div class="fg-title">产品原价：<i>*</i></div>
                    <div class="fg-input">
                        <input type="text" name="p_price" />
                    </div>
                </div>
                <div class="form-group action">
                    <div class="fg-title">市场价：<i>*</i></div>
                    <div class="fg-input">
                        <input type="text" name="p_market_price" />
                    </div>
                </div>               
                 <div class="form-group action">
                    <div class="fg-title">使用多少积分：<i>*</i></div>
                    <div class="fg-input">
                        <input type="text" name="use_integral" style="width:100px;" />积分
                    </div>
                </div>
                 <div class="form-group action">
                    <div class="fg-title">抵扣多少元：<i>*</i></div>
                    <div class="fg-input">
                        <input type="text" name="deductible_price" style="width:100px;" />元
                    </div>
                </div>
                 <div class="form-group">
                    <div class="fg-title">库存：</div>
                    <div class="fg-input">
                        <input type="text" name="stock" style="width:100px;" />件
                 </div>
                </div>
                <div class="form-group">
                	<div class="fg-title">所属栏目：</div>
					<select name="p_type" style="width: 100px;" class="p_type">
						<?php foreach ($data as $key=>$val): ?>
						<option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
						<?php  endforeach;?>
					</select>
				</div>          
                <div class="form-group">
                    <div class="fg-title">排序：</div>
                    <div class="fg-input">
                        <input name="order" type="text"/>
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" />
                    <input type="button" class="fg-but fb-close" value="取消" />
                    <input type="submit" class="fg-but" value="确定" />
                </div>
                <div class="clear"></div>
            </form>
        </div>
    </div>
</div>
<div id="xiuxiu_box1" class="xiuxiu_box"></div>
<div id="xiuxiu_box2" class="xiuxiu_box"></div>
<div id="xiuxiu_box3" class="xiuxiu_box"></div>
<div id="xiuxiu_box4" class="xiuxiu_box"></div>
<div id="xiuxiu_box5" class="xiuxiu_box"></div>
<div id="xiuxiu_box6" class="xiuxiu_box"></div>
<div id="xiuxiu_box7" class="xiuxiu_box"></div>
<div class="avatar_box"></div>
<div class="close_xiu">×</div>
<script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
<script src="<?php echo base_url("assets/js/admin/common.js"); ?>"></script>
<script src="<?php echo base_url(); ?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js'); ?>"></script>
<script type="text/javascript">
$(".p_integral").hide();
$(".action").hide();
function check_val(obj){
	var val = $(obj).val();
	if(val==1){
		$(".p_integral").hide();
		$('input[name=p_integral_price]').val('');
		$(".action").show();
	}else if(val==2){
		$(".p_integral").show();
		$('input[name=p_integral_price]').val('');
		$('input[name=p_price]').val('');
		$('input[name=p_market_price]').val('');   
		$('input[name=use_integral]').val('');
		$('input[name=deductible_price]').val('');
		$(".action").hide();
	}
	else{
		$(".p_integral").hide();
		$('input[name=p_integral_price]').val('');
		$('input[name=p_price]').val('');
		$('input[name=p_market_price]').val('');   
		$('input[name=use_integral]').val('');
		$('input[name=deductible_price]').val('');
		$(".action").hide();
	}
}



                            var columns = [{field: 'p_name', title: '产品标题', width: '100', align: 'center'},
                                {field: 'p_describe', title: '产品描述', align: 'center', width: '50'},                               
                                {field: null, title: '产品封面图', width: '180', align: 'center', formatter: function (item) {
                                	return '<img src="<?php echo trim(base_url(''),'/');?>'+item.p_show_pic+'" width="200" />';
                                    }
                                },
                                {field: null, title: '产品详情图', width: '100', align: 'center', formatter: function (item) {
	                                	var str = '';
	                                	var strs= new Array();
	                                    var strs = item.p_pic.split(',');
	                                    for(var i = 0; i < strs.length; i++){
	                                       str += '<img src="<?php echo trim(base_url(''),'/');?>'+strs[i]+'" width="120"  />'; + "&nbsp&nbsp";
	                                    }
	                                    return str;
                                    }
                                },
                                {field: 'p_price', title: '产品价格', width: '30', align: 'center'},
                                {field: 'p_integral_price', title: '积分价格', width: '30', align: 'center'},
                                {field: 'p_market_price', title: '市场价格', width: '30', align: 'center'},
                                {field: 'use_integral', title: '使用多少积分', width: '30', align: 'center'},
                                {field: 'deductible_price', title: '抵扣多少元', width: '30', align: 'center'},
                                {field: 'p_content', title: '备注', align: 'center', width: '50'},                               
                                {field: 'p_sold', title:'已售数量', align:'center', width:'20'},
                                {field: null, title:'所属栏目', align:'center', width:'20', formatter: function (item) {
                                		return item.name;
										
                                }},
                                {field: null, title:'产品类型', align:'center', width:'20', formatter: function (item) {
									if(item.p_attr_type==1){
										return '带金额的产品';
									}
									else if(item.p_attr_type==2){
										return '纯积分产品';
									}
									else{
										return item.p_attr_type;
									}
									
                       			 }},
                       			{field: 'stock', title:'库存', align:'center', width:'20'},
                                {field: 'p_time', title: '更新时间', align: 'center', width: '100'},
                                {field: 'p_sort', title:'排序', align:'center', width:'20'},
                                {field: null, title: '操作', align: 'center', width: '110', formatter: function (item) {
                                        var button = '';
                                        var status = $('#search-condition').find('input[name=status]').val();
                                        if (status == 1) {
                                             button += '<a href="javascript:void(0);" onclick="editstatus(' + item.p_id + ','+ status +')" class="tab-button but-blue">下架</a>&nbsp;';
                                        }else if(status == 2){
                                     	   button += '<a href="javascript:void(0);" onclick="editstatus(' + item.p_id + ','+ status +')" class="tab-button but-blue">上架</a>&nbsp;';                                     	   
                                        }
                                        button += '<a href="javascript:void(0);" onclick="edit(' + item.p_id + ')" class="tab-button but-blue">修改</a>&nbsp;';
                                        button += '<a href="javascript:void(0);" onclick="del(' + item.p_id + ');" class="tab-button but-red">删除</a>';
                                        return button;
                                    }
                                }
                            ];
                            $("#dataTable").pageTable({
                                columns: columns,
                                url: '/admin/a/integral_center/mall/get_data',
                                pageNumNow: 1,
                                searchForm: '#search-condition',
                                tableClass: 'table-data'
                            });
                            var formObj = $("#add-data");
							//添加弹出层
                            $("#add-button").click(function () {
                            	formObj.find('input[type=text]').val('');
                            	$(".selector").val('');
                            	formObj.find('input[type=hidden]').val('');
                            	formObj.find('input[type=file]').val('');
                            	formObj.find('textarea[name=p_describe]').val('');
                            	$("#imghead").attr("src","");
                            	$("#imghead1").attr("src",""); 
                            	$("#imghead2").attr("src",""); 
                            	$("#imghead3").attr("src",""); 
                            	$("#imghead4").attr("src",""); 
                            	$("#imghead5").attr("src","");  
                                $(".fb-body,.mask-box").show();
                                $('.uploadImg').remove();
                                
                            });

                            $("#add-data").submit(function () {
                                var id = $(this).find('input[name=id]').val();
                                var url = id > 0 ? '/admin/a/integral_center/mall/edit' : '/admin/a/integral_center/mall/add';
                                $.ajax({
                                    url: url,
                                    type: 'post',
                                    dataType: 'json',
                                    data: $(this).serialize(),
                                    success: function (data) {
                                        if (data.code == 2000) {
						                    alert(data.msg);
						                    $(".fb-body,.mask-box").hide();
						                    $("#dataTable").pageTable({
						                        columns: columns,
						                        url: '/admin/a/integral_center/mall/get_data',
						                        pageNumNow: 1,
						                        searchForm: '#search-condition',
						                        tableClass: 'table-data'
						                    });
						                } else {
						                    alert(data.msg);
						                }
						            }
						        });
						        return false;
   							});

    function edit(id) {
        $.ajax({
            url: '/admin/a/integral_center/mall/get_edit_data',
            type: 'post',
            dataType: 'json',
            data: {p_id: id},
            success: function (data) {
                if (!$.isEmptyObject(data)) {
                    //alert(JSON.stringify(data))
                    formObj.find('input[name=p_name]').val(data.p_name);
                    formObj.find('input[name=p_integral_price]').val(data.p_integral_price);
                    formObj.find('input[name=p_show_pic]').val(data.p_show_pic);
                    formObj.find('#imghead').attr('src', window.location.protocol + '//' + document.domain + data.p_show_pic);
                    if (data.p_pic[data.p_pic.length - 1] === ','){         // 如果字符串最后面有',',则去除
                        data.p_pic = data.p_pic.substring(0, data.p_pic.length - 1);
                    }
                    var arr_pic= new Array();
                    arr_pic = data.p_pic.split(',');
                    if (1 === arr_pic.length){
                    	formObj.find('input[name=p_pic1]').val(data.p_pic);
                    	formObj.find('#imghead1').attr('src', window.location.protocol + '//' + document.domain + data.p_pic);
                    }else if(2 === arr_pic.length){
                    	formObj.find('input[name=p_pic1]').val(arr_pic[0]);
                    	formObj.find('input[name=p_pic2]').val(arr_pic[1]);
                    	formObj.find('#imghead1').attr('src', window.location.protocol + '//' + document.domain + arr_pic[0]);
                    	formObj.find('#imghead2').attr('src', window.location.protocol + '//' + document.domain + arr_pic[1]);
                    }else if(3 === arr_pic.length){
                    	formObj.find('input[name=p_pic1]').val(arr_pic[0]);
                    	formObj.find('input[name=p_pic2]').val(arr_pic[1]);
                    	formObj.find('input[name=p_pic3]').val(arr_pic[2]);
                    	formObj.find('#imghead1').attr('src', window.location.protocol + '//' + document.domain + arr_pic[0]);
                    	formObj.find('#imghead2').attr('src', window.location.protocol + '//' + document.domain + arr_pic[1]);
                    	formObj.find('#imghead3').attr('src', window.location.protocol + '//' + document.domain + arr_pic[2]);
                    }else if(4 === arr_pic.length){
                    	formObj.find('input[name=p_pic1]').val(arr_pic[0]);
                    	formObj.find('input[name=p_pic2]').val(arr_pic[1]);
                    	formObj.find('input[name=p_pic3]').val(arr_pic[2]);
                    	formObj.find('input[name=p_pic4]').val(arr_pic[3]);
                    	formObj.find('#imghead1').attr('src', window.location.protocol + '//' + document.domain + arr_pic[0]);
                    	formObj.find('#imghead2').attr('src', window.location.protocol + '//' + document.domain + arr_pic[1]);
                    	formObj.find('#imghead3').attr('src', window.location.protocol + '//' + document.domain + arr_pic[2]);
                    	formObj.find('#imghead4').attr('src', window.location.protocol + '//' + document.domain + arr_pic[3]);
                    }else if(5 === arr_pic.length){
                    	formObj.find('input[name=p_pic1]').val(arr_pic[0]);
                    	formObj.find('input[name=p_pic2]').val(arr_pic[1]);
                    	formObj.find('input[name=p_pic3]').val(arr_pic[2]);
                    	formObj.find('input[name=p_pic4]').val(arr_pic[3]);
                    	formObj.find('input[name=p_pic5]').val(arr_pic[4]);
                    	formObj.find('#imghead1').attr('src', window.location.protocol + '//' + document.domain + arr_pic[0]);
                    	formObj.find('#imghead2').attr('src', window.location.protocol + '//' + document.domain + arr_pic[1]);
                    	formObj.find('#imghead3').attr('src', window.location.protocol + '//' + document.domain + arr_pic[2]);
                    	formObj.find('#imghead4').attr('src', window.location.protocol + '//' + document.domain + arr_pic[3]);
                    	formObj.find('#imghead5').attr('src', window.location.protocol + '//' + document.domain + arr_pic[4]);
                    }          
                    formObj.find(".kind option[value="+data.p_attr_type+"]").attr("selected", true);
                    if(data.p_attr_type==1){
                		$(".p_integral").hide();
                		$('input[name=p_integral_price]').val('');
                		$('input[name=p_price]').val(data.p_price);
                		$('input[name=p_market_price]').val(data.p_market_price);   
                		$('input[name=use_integral]').val(data.use_integral);
                		$('input[name=deductible_price]').val(data.deductible_price);
                		$(".action").show();
                	}else if(data.p_attr_type==2){
                		$(".p_integral").show();
                		$('input[name=p_price]').val('');
                		$('input[name=p_market_price]').val('');   
                		$('input[name=use_integral]').val('');
                		$('input[name=deductible_price]').val('');
                		$('input[name=p_integral_price]').val(data.p_integral_price);
                		$(".action").hide();
                	}
                	else{
                		$(".p_integral").hide();
                		$('input[name=p_integral_price]').val('');
                		$('input[name=p_price]').val('');
                		$('input[name=p_market_price]').val('');   
                		$('input[name=use_integral]').val('');
                		$('input[name=deductible_price]').val('');
                		$(".action").hide();
                	}          
                    formObj.find('input[name=p_content]').val(data.p_content);
                    formObj.find('textarea[name=p_describe]').val(data.p_describe);
                    formObj.find('input[name=p_sold]').val(data.p_sold);
                    formObj.find('input[name=stock]').val(data.stock);
                    formObj.find(".p_type option[value="+data.p_type+"]").attr("selected", true);   
                    formObj.find('input[name=order]').val(data.p_sort);
                    formObj.find('input[name=id]').val(data.p_id);
                    $(".fb-body,.mask-box").show();
                } else {
                    alert('请确认您选择的数据');
                }
            }
        });
    }

	function editstatus(id,status){
		if (confirm("您确定要更改吗?")) {
            $.post("/admin/a/integral_center/mall/edit_status", {p_id: id,p_status:status}, function (json) {
                var data = eval("(" + json + ")");
                if (data.code == 2000) {
                    $("#dataTable").pageTable({
                        columns: columns,
                        url: '/admin/a/integral_center/mall/get_data',
                        pageNumNow: 1,
                        searchForm: '#search-condition',
                        tableClass: 'table-data'
                    });
                    alert(data.msg);
                } else {
                    alert(data.msg);
                }
            });
        }
	}
    
  //导航栏切换
    $('.nav-tabs li').click(function(){
    	var formObj = $('#search-condition');
    	$(this).addClass('active').siblings().removeClass('active');
    	var status = $(this).attr('data-val');
    	$('input[name="status"]').val(status);
    	if(status == 2){
        	$('#add-button').hide();
    	}else if(status == 1){
    		$('#add-button').show();
    	}
    	$("#dataTable").pageTable({
    		columns:columns,
    		url:'/admin/a/integral_center/mall/get_data',
    		pageNumNow:1,
    		searchForm:'#search-condition',
    		tableClass:'table-data'
    	});
    })

    //删除
    function del(id) {
        if (confirm("您确定要删除吗?")) {
            $.post("/admin/a/integral_center/mall/del", {p_id: id}, function (json) {
                var data = eval("(" + json + ")");
                if (data.code == 2000) {
                    $("#dataTable").pageTable({
                        columns: columns,
                        url: '/admin/a/integral_center/mall/get_data',
                        pageNumNow: 1,
                        searchForm: '#search-condition',
                        tableClass: 'table-data'
                    });
                    alert(data.msg);
                } else {
                    alert(data.msg);
                }
            });
        }
    }

    /*-----------------------------------上传图片-----------------------------*/
	var imgProportion = {1:"337x221",2:"820x750",3:"350x200",4:"350x200"};
	var xiuBox = {1:'xiuxiu_box1',2:'xiuxiu_box2',3:"xiuxiu_box3",4:"xiuxiu_box4",5:"xiuxiu_box5",6:"xiuxiu_box6",7:"xiuxiu_box7"};
	var xiuxiuEditor = {1:'xiuxiuEditor1',2:'xiuxiuEditor2',3:"xiuxiuEditor3",4:"xiuxiuEditor4",5:"xiuxiuEditor5",6:"xiuxiuEditor6",7:"xiuxiuEditor7"};
	function uploadImgFile(obj ,type){
			
			var buttonObj = $(obj);
			xiuxiu.setLaunchVars("cropPresets", imgProportion[type]);
			xiuxiu.embedSWF(xiuBox[type],5,'100%','100%',xiuxiuEditor[type]);
		       //修改为您自己的图片上传接口
			xiuxiu.setUploadURL("<?php echo site_url('/admin/upload/uploadImgFileXiu'); ?>");
		    xiuxiu.setUploadType(2);
		    xiuxiu.setUploadDataFieldName("uploadFile");
		    
			xiuxiu.onInit = function ()
			{
				//默认图片
				xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg",false,xiuxiuEditor[type]);
			}
			
			xiuxiu.onUploadResponse = function (data)
			{
				data = eval('('+data+')');
				if (data.code == 2000) {
					buttonObj.next("input").val(data.msg);

					if (type == 3) {
						buttonObj.prev("img").attr("src",data.msg);
						$('input[name="p_pic2"]').val(data.msg);
					} else if (type == 2) {
						//buttonObj.prev("img").attr("src",data.msg);
						//$('input[name="p_pic1"]').val(data.msg);
						buttonObj.prev("img").attr("src",data.msg);
						buttonObj.next('input').val(data.msg);
					} else if (type == 1){
						//buttonObj.css({'margin-top': '134px','margin-left': '384px'});
						buttonObj.prev("img").attr("src",data.msg);
						$('input[name="p_show_pic"]').val(data.msg);
					}else if(type == 4){
						buttonObj.prev("img").attr("src",data.msg);
						$('input[name="p_pic3"]').val(data.msg);
					}

					closeXiu(type);
				} else {
					alert(data.msg);
				}
			}
			$("#xiuxiuEditor"+type).show();
			$('.avatar_box').show();
			$('.close_xiu').show();
			$('.right_box').show();
			return false;
	}
	$(document).mouseup(function(e) {
	    var _con = $('#xiuxiuEditor1,#xiuxiuEditor2,#xiuxiuEditor3,#xiuxiuEditor4'); // 设置目标区域
	    if (!_con.is(e.target) && _con.has(e.target).length === 0) {
	        $("#xiuxiuEditor1,#xiuxiuEditor2,#xiuxiuEditor3,#xiuxiuEditor4").hide();
	        $('.avatar_box').hide();
	        $('.close_xiu').hide();
	        $('.right_box').hide();
	    }
	})
	function closeXiu(type) {
		$("#xiuxiuEditor"+type).hide();
		$('.avatar_box').hide();
		$('.close_xiu').hide();
		$('.right_box').hide();
	}

	/*-------------------------------*/
    
    
    
</script>
