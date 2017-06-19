	<!-- 遮罩层 -->
	<div class="mask-box"></div>
	<script>
		$(".fb-close").click(function(){
			closebox();
		})
		function closebox() {
			$(".fb-body,.mask-box,.detail-box,.form-box").fadeOut(500);
		}
		$('.box-close').click(function(){
			$(".detail-box,.mask-box").fadeOut(500);
		})
		var bodyWidth = $('body').width();
		var bodyHeight = $('body').height();
		$('.mask-box').css({'width':bodyWidth});
	</script>
</body>
</html>
