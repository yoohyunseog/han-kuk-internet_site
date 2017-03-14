<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>
<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<div class="lt">
    <strong class="lt_title"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><?php echo $bo_subject; ?></a></strong>
     <ul id="movie_1">
    <script type="text/javascript">
    var count = 0;
	var rENDER_START = 50; //rENDER 함수 // 스타트 타이머 
	var rENDER_END = 800;  //rENDER 함수 // 종료 타이머 
	
      function makeRequest(q) {
          var day = new Date();
          var today = day.toISOString();
          var subday = new Date();
          subday.setDate(subday.getDate() - <?=$bo_8?>);
          subday = subday.toISOString();
          var request = gapi.client.youtube.search.list({
          q: q,
          part: 'snippet',
          order: 'viewcount',
          type: 'video',
          publishedAfter: subday,
          publishedBefore: today,
          maxResults: 1
      });
        request.execute(function(response) {
          $('#results').empty();
          var resultItems = response.result.items;
          $.each(resultItems, function(index, item) {
            vidTitle = "<br><td>"+item.snippet.title+"</td></br>";
            vidCount = "<br></td>조회수</td></br>";
            vidId = item.id.videoId;
            vidThumburl =  item.snippet.thumbnails['default'].url;
            vidThumbimg = '<pre><img id="thumb" src="'+vidThumburl+'" alt="No  Image Available."></pre>';
            $('#movie_1').append('<li id="'+vidId+'">' + vidThumbimg + vidTitle + vidCount + '</li>');
            staticsRequest(vidId)
          });
        });
      }

	  function staticsRequest(vidId){
		  var viewCount;
		  var str;
		  var request = gapi.client.youtube.videos.list({
	          id: vidId,
	          part: 'id,statistics',
	        });
	        request.execute(function(response) {
	        	var resultItems = response.result.items;
	        	$.each(resultItems, function(index, item) {
	        	viewCount = item.statistics.viewCount;
	        	$('#'+vidId).append("<br><td>조회수: "+viewCount+"</td></br>");
	            });
	        });
	        return viewCount;
	  }
	  
      //교차 함수 로직 - > rENDER - start
      function idRequest(){
    	  var ftoday = new Date();
          //n < 10 ? "0" + n : n;
          var ftodaymonth = ftoday.getMonth()+1;
          ftodaymonth = ftodaymonth < 10 ? "0" + ftodaymonth: ftodaymonth;
          ftoday = ftoday.getFullYear()+""+ftodaymonth+""+(ftoday.getDate()-1);
    		var query;
    		var key = "<?=$bo_9?>";
    		$.ajax({
    	        type: 'GET',
    	        url: 'http://www.kobis.or.kr/kobisopenapi/webservice/rest/boxoffice/searchDailyBoxOfficeList.json?key='+key+'&targetDt='+ftoday,
    	        async: false,
    	        success: function(data) {
    	        	 if(data != null) {
    	        		 console.log(data);
    	             }
    	        	 query = data;
    	        }
    	   });
     	   
    		var str = query;
    		var str1 = str.boxOfficeResult.boxofficeType;
    		var date = str.boxOfficeResult.showRange;
    		var str1_count = str.boxOfficeResult.boxofficeType.length;
			
    		var rENDER = setInterval(function() {
    	        // logic
    	        if (count < str1_count) {
    	        	var dd = str.boxOfficeResult.dailyBoxOfficeList[count].movieNm;
        			makeRequest(dd+" "+'<?=$bo_1?>');
    	        }else {
    	        	clearInterval(rENDER);
    	        }
    	        count++;
    	    }, rENDER_START);
      }
      
      function init() {
        gapi.client.setApiKey('<?=$bo_10?>');
        gapi.client.load('youtube', 'v3');
      }

      //교차 함수 실행 - rENDER 타이머 - end
      function myFunction() {
    	    setTimeout(function(){ idRequest(); }, rENDER_END);
    	}
    </script>

    <script type="text/javascript" src="https://apis.google.com/js/client.js?onload=init">
	//function 교차 함수 실행 
    myFunction()
    </script>
	<button id="listmovie" style="display:none;" style="width:100px; height:50px;" onclick="idRequest()"></button>
    <h1>한국인터넷.한국 - YouTube API 0.1 Test</h1>
    </ul>
   
  <style>
.lt li {
    width: 250px;
    float: left;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    margin-left: 10px;
    height: auto;
}

.lt li img {
	width:250px;
	height:250px;
}
.lt{
	width:100%;
	height:auto;
}
.lt_more {
	position:relative;
    top: 10px;
    width: 100px;
    height: 100px;
    float: left;
    border:1px solid #ccc;
}
.lt_more hover {
	background-color:#ccc;
}
pre {
    overflow-x: visible;
    font-size: 1.1em;
}

</style>  
</div>
 <div class="lt_more"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><span class="sound_only"><?php echo $bo_subject ?></span>더보기</a></div>
   
<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->