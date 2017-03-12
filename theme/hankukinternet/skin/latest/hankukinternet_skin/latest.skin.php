<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>
<script>

	//페이지 데이터 모두 로딩되면 로드
	$(window).on('load',function(){
		var key = '<?=$bo_10?>';
		var str = '헌재가미친날!';
		var dataSub;
		setTimeout(function(){dataload()},300);

		function dataload(){ 
		$.ajax({
	        type: 'GET',
	        url: "https://www.googleapis.com/youtube/v3/search?part=id,snippet&q="+str+"&fields=items&key="+key,
	        async: false,
	        success: function(data) {
	        	 if(data != null) {
	        		 console.log(data);
	             	}
	        	 dataSub = data;
	        	}
	   		});

		 //$("#data").text(dataSub.items[0].snippet.title);
		 var str1 = dataSub.items[0].snippet.title;
		$(".lt ul").append("<li>"+str1+"</li>");
		}

		
	});
	</script>
	
<style>
#vidos_ul li{
	width:150px; 
	height:150px;
	float:left;
	overflow: hidden; 
	text-overflow: ellipsis;
	white-space: nowrap; 
}
#vidos_ul li img {
	width:150px;
}
.lt{
	width:100%;
	height:auto;
}
</style>	
	
<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<div class="lt">
    <strong class="lt_title"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><?php echo $bo_subject; ?></a></strong>
    <ul>
    
    </ul>
    <div class="lt_more"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><span class="sound_only"><?php echo $bo_subject ?></span>더보기</a></div>
</div>
<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->