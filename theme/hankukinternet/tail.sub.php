<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<?php if ($is_admin == 'super') {  ?><!-- <div style='float:left; text-align:center;'>RUN TIME : <?php echo get_microtime()-$begin_time; ?><br></div> --><?php }  ?>

<!-- ie6,7에서 사이드뷰가 게시판 목록에서 아래 사이드뷰에 가려지는 현상 수정 -->
<!--[if lte IE 7]>
<script>
$(function() {
    var $sv_use = $(".sv_use");
    var count = $sv_use.length;

    $sv_use.each(function() {
        $(this).css("z-index", count);
        $(this).css("position", "relative");
        count = count - 1;
    });
});
</script>
<![endif]-->

</body>
</html>
<script>
$(document).ready(function(){
	var query;
	var count = <?=$count?>;
 	for(var i = 0; i<count; i++){
 	 	for(var n = 0; n<<?=$checkPoint?>; n++){
 	 	 	var name = "#test"+i+"_"+n;
 	 	 	if($(name).length){
	$.ajax({
        type: 'GET',
        url: 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='+$(name).val()+'&key=AIzaSyClUC-kVxJtYDxjraNMHEOebqn032h_-1M',
        async: false,
        success: function(data) {
        	 if(data != null) {
        		 console.log(data);
             	}
        		 query = data.items[0].statistics.viewCount;
        	}
   		});
 	 
		query = number_format(query);
	$("#hdtest"+(i)+"_"+n).text("조회수:"+query);
 			}
 	 	}
 	}
 	function number_format( number )
 	{
 	  number=number.replace(/\,/g,"");
 	  nArr = String(number).split('').join(',').split('');
 	  for( var i=nArr.length-1, j=1; i>=0; i--, j++)  if( j%6 != 0 && j%2 == 0) nArr[i] = '';
 	  return nArr.join('');
 	 }
});
</script>
<?php 
echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다. ?>