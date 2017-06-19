<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>

<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
select{display:inline-block;margin-right:5px;}
</style>
</head>
<body>
<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>
 <!-- 添加供应商 弹窗 -->
<div class="fb-content" id="form1">
   
    <div class="fb-form">
        <form method="post" action="#" id="update-data" class="form-horizontal">
         <div class="list">
         <!-- 出境游 -->
         <?php $overArr=explode(',', $product['overcity']) ; if(in_array(1,$overArr)){ ?>
         
            <div class="depart_row"  style="min-height: 208px;">
            <div class="form-group div13">
                <div class="fg-title" style="width:22% !important">中文姓名：</div>
                <div class="small-input" style="width:60%;"><input type="text" name="name" value="<?php if(!empty($travel[0]['name'])){ echo $travel[0]['name'];} ?>"></div>
            </div>
            <div class="form-group div13">
                <div class="fg-title" style="width:22% !important">英文名：</div>
                <div class="small-input" style="width:60%;"><input type="text" name="enname" value="<?php if(!empty($travel[0]['enname'])){ echo $travel[0]['enname'];} ?>"></div>
            </div>
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">性别：</div>
                <div class="small-input" style="width:60%;">
                 <select name="sex">
                     <option value="<?php if(isset($travel[0]['sex'])){ echo $travel[0]['sex'];} ?>" <?php if(isset($travel[0]['sex']) && $travel[0]['sex']==1){ echo 'selected="selected"';} ?>>男</option>
                     <option value="<?php if(isset($travel[0]['sex'])){ echo $travel[0]['sex'];} ?>" <?php if(isset($travel[0]['sex']) && $travel[0]['sex']==0){ echo 'selected="selected"';} ?> >女</option>
                 </select>
                </div>
            </div>
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">证件类型：</div>
                <div class="small-input" style="width:60%;">
                 <select name="certificate_type">
                 <?php foreach ($type as $k=>$v){ ?>
                     <option value="<?php echo $v['dict_id'];?>" <?php if($v['dict_id']==$travel[0]['certificate']){ echo 'selected="selected"';} ?>>
                     <?php echo $v['description']; ?>
                     </option>
				<?php } ?>
                 </select>
                </div>
            </div>
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">证件号：</div>
                <div class="small-input" style="width:60%;"><input type="text" name="certificate_no" value="<?php if(!empty($travel[0]['certificate_no'])){ echo $travel[0]['certificate_no'];} ?>"></div>
            </div>
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">签发地：</div>
                <div class="small-input" style="width:60%;"><input type="text" name="sign_place" value="<?php if(!empty($travel[0]['sign_place'])){ echo $travel[0]['sign_place'];} ?>"></div>
            </div>
             <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">签发日期：</div>
                <div class="small-input" style="width:60%;">
                <input type="text" name="sign_time" onClick="WdatePicker()" readonly="readonly"  value="<?php if(!empty($travel[0]['sign_time'])){ echo $travel[0]['sign_time'];} ?>" >
                </div>
            </div>
             <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">有效期至：</div>
                <div class="small-input" style="width:60%;">
                <input type="text" name="endtime" onClick="WdatePicker()" readonly="readonly"  value="<?php if(!empty($travel[0]['endtime'])){ echo $travel[0]['endtime'];} ?>" >
                </div>
            </div>
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">出生日期：</div>
                <div class="small-input" style="width:60%;">
                <input type="text" name="birthday" onClick="WdatePicker()" readonly="readonly"  value="<?php if(!empty($travel[0]['birthday'])){ echo $travel[0]['birthday'];} ?>" >
                </div>
            </div>
            
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">手机号：</div>
                <div class="small-input" style="width:60%;"><input type="text" name="telephone" value="<?php if(!empty($travel[0]['telephone'])){ echo $travel[0]['telephone'];} ?>"></div>
            </div>
            
            </div>
            
       	   <?php }else{?>
           <!-- 国内游 -->

           <div class="depart_row"  style="min-height: 208px;">
            <div class="form-group div13">
                <div class="fg-title" style="width:22% !important">姓名：</div>
                <div class="small-input" style="width:60%;"><input type="text" name="name" value="<?php if(!empty($travel[0]['name'])){ echo $travel[0]['name'];} ?>"></div>
            </div>
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">性别：</div>
                <div class="small-input" style="width:60%;">
                 <select name="sex">
                     <option value="<?php if(isset($travel[0]['sex'])){ echo $travel[0]['sex'];} ?>" <?php if(isset($travel[0]['sex']) && $travel[0]['sex']==1){ echo 'selected="selected"';} ?>>男</option>
                     <option value="<?php if(isset($travel[0]['sex'])){ echo $travel[0]['sex'];} ?>" <?php if(isset($travel[0]['sex']) && $travel[0]['sex']==0){ echo 'selected="selected"';} ?> >女</option>
                 </select>
                </div>
            </div>
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">证件类型：</div>
                <div class="small-input" style="width:60%;">
                 <select name="certificate_type">
                 <?php foreach ($type as $k=>$v){ ?>
                     <option value="<?php echo $v['dict_id'];?>" <?php if($v['dict_id']==$travel[0]['certificate']){ echo 'selected="selected"';} ?>>
                     <?php echo $v['description']; ?>
                     </option>
				<?php } ?>
                 </select>
                </div>
            </div>
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">证件号：</div>
                <div class="small-input" style="width:60%;"><input type="text" name="certificate_no" value="<?php if(!empty($travel[0]['certificate_no'])){ echo $travel[0]['certificate_no'];} ?>"></div>
            </div>
            
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">出生日期：</div>
                <div class="small-input" style="width:60%;">
                <input type="text" name="birthday" onClick="WdatePicker()" readonly="readonly"  value="<?php if(!empty($travel[0]['birthday'])){ echo $travel[0]['birthday'];} ?>" >
                </div>
            </div>
            
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">手机号：</div>
                <div class="small-input" style="width:60%;"><input type="text" name="telephone" value="<?php if(!empty($travel[0]['telephone'])){ echo $travel[0]['telephone'];} ?>"></div>
            </div>
            
            </div>
        <?php } ?>
        </div>
            
            <div class="form-group" style="margin-bottom:20px;margin-bottom:20px;">
            	<input type="hidden" class="fg-but" name="id" value="<?php echo $travel[0]['id'] ?>"> 
                <input type="button" class="fg-but" id="q_bottom" onclick="submitData()" value="确定">
            </div>
            <div class="clear"></div>
           
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url() ?>static/plugins/DatePicker/WdatePicker.js"></script>
<script type="text/javascript">

function submitData(){
	   
	jQuery.ajax({ type : "POST",async:false,data : jQuery('#update-data').serialize(),url : "<?php echo base_url()?>order_from/order/update_order_travel", 
        beforeSend:function() {//ajax请求开始时的操作
            $('#q_bottom').addClass("disabled");
        },
        complete:function(){//ajax请求结束时操作
            $('#q_bottom').removeClass("disabled");
        }, 
		success : function(response) {
			var response = eval('(' + response + ')');
			if(response.status==1){
				alert(response.msg);
				parent.location.reload();
		    }else{
		    	alert(response.msg);
			}
		}
	});
}


</script>


</html>


