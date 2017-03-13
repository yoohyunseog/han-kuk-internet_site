<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>
<script>

//페이지 데이터 모두 로딩되면 로드
$(window).load(function(){
		var bo_table = '<?=$bo_table?>';
		var key = '<?=$bo_10?>';
		var key1 = '<?=$bo_9?>';
		var dataSub;
		var delay = 100;
		var moviedata = movieData();
		var count = moviedata.boxOfficeResult.dailyBoxOfficeList.length;
		var count1 = 0;
		for(var i = 0; i<count; i++){
		delay = delay*(i+1); 
		//setTimeout(function(){dataload(moviedata.boxOfficeResult.dailyBoxOfficeList[i])},delay);
		dataload(moviedata.boxOfficeResult.dailyBoxOfficeList[i].movieNm,i);
		count1++;
		}
		
		function dataload(str,movie_count){
		$.ajax({
	        type: 'GET',
	        url: "https://www.googleapis.com/youtube/v3/search?part=id,snippet&publishedAfter=2017-03-03T00:00:00Z&publishedBefore=2017-03-13T00:00:00Z&maxResults=1&order=viewCount&q="+str+"&fields=items&key="+key,
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
		 var images = dataSub.items[0].snippet.thumbnails.default.url;
		 var video_id = dataSub.items[0].id.videoId;
		 if($('#li_test'+movie_count).length==0){
			 //<param id="%s_%s" value="%s"><li id="li_%s"><img src="%s"><br>%s <br>날짜:%s <br><hd id="hd%s_%s">조회수:0</hd></li>
			 var viewcount = viewCount(video_id);
			$(".lt ul").append('<parma id="'+bo_table+'_'+movie_count+'" value="'+video_id+'"><li id="li_test'+movie_count+'"><img src='+images+'><br>'+str1+'<br><hd id="">조회수:'+viewcount+'</hd></li>');
		 }
		}
		
		function movieData(){
			var query1;
			$.ajax({
		        type: 'GET',
		        url: 'http://www.kobis.or.kr/kobisopenapi/webservice/rest/boxoffice/searchDailyBoxOfficeList.json?key='+key1+'&targetDt=20170312',
		        async: false,
		        success: function(data) {
		        	 if(data != null) {
		        		 console.log(data);
		             }
		             query1 = data;
		        }
		   });
		return query1;
		}
		
		function viewCount(str){
			var query2;
			$.ajax({
		        type: 'GET',
		        url: 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='+str+'&key='+key,
		        async: false,
		        success: function(data) {
		        	 if(data != null) {
		        		 console.log(data);
		             	}
		        	 query2 = data.items[0].statistics.viewCount;
		        	 
		        	 }
		   		});
	   		query2 = number_format(query2);
			return query2;
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
	
<style>
.lt li{
	width:150px; 
	height:150px;
	float:left;
	overflow: hidden; 
	text-overflow: ellipsis;
	white-space: nowrap; 
}
#li_test img {
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