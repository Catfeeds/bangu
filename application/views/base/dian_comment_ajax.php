	 <div class="bootbox-body" style="padding-top:50px;" >
     <form class="form-horizontal" role="form" method="post" id="invoiceForm"  action="<?php echo base_url();?>base/member/save_diancomment">    
	      <div class="tousutitless">
		   <!--     <a href="#">
		        泰国5天4晚品质旅游
			   </a> -->
		  </div> 
		   <input type="hidden" name="id" value="<?php echo $rows['id'] ?>" />
		    <input type="hidden" name="moid" value="<?php echo $moid ?>" />
		  <textarea class="tuidanliyou" style="width:98%;height:155px" name="content">
		
		  </textarea>
		 <span class="submitbutton" style="left:0%;"><button class="" style="height: 90%;border: 0; background: none repeat scroll 0 0 #e0e0e0" type="submit">提交</button></span>
		   <span class="quxiaobutton" style="left:15%;"><button class="" style="height: 90%;border: 0; background: none repeat scroll 0 0 #e0e0e0" type="reset">取消</button></span> 
		   <!-- <button class="btn btn-palegreen" type="submit">提交</button>
		   <button class="btn btn-palegreen" type="submit">取消</button> -->
   
    </form>
  
</div>


