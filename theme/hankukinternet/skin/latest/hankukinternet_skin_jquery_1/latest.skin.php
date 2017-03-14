<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>
<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<div class="lt">
    <strong class="lt_title"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><?php echo $bo_subject; ?></a></strong>
    <div class="lt_more"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><span class="sound_only"><?php echo $bo_subject ?></span>더보기</a></div>
    <ul id="movie_1">
    <script type="text/javascript">

      function makeRequest(q) {
          var request = gapi.client.youtube.search.list({
          q: q,
          part: 'snippet',
          maxResults: 6
      });
		alert();
        request.execute(function(response) {
          $('#results').empty();
          var resultItems = response.result.items;
          $.each(resultItems, function(index, item) {
            vidTitle = "<br><td>"+item.snippet.title+"</td></br>";
            vidThumburl =  item.snippet.thumbnails.default.url;
            vidThumbimg = '<pre><img id="thumb" src="'+vidThumburl+'" alt="No  Image Available."></pre>';
            $('#results').append('<li>' + vidThumbimg + vidTitle +  '</li>');
          });
        });
      }

      function search() {
        gapi.client.setApiKey('<?=$bo_10?>');
        gapi.client.load('youtube', 'v3', function() {
          data = jQuery.parseJSON( '{ "data": [{"name":"taylor swift"}]}' );
          $.each(data["data"], function(index, value) {
            makeRequest(value["name"]);
          });
        });
      }
    </script>

    <script type="text/javascript" src="https://apis.google.com/js/client.js?onload=search"></script>
	<button style="width:100px; height:50px;" onclick="makeRequest('애니')"></button>
    <h1>YouTube API 3.0 Test</h1>
    <ul id="results"></ul>
    </ul>
  <style>
.lt li {
    width: 160px;
    float: left;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    margin-left: 10px;
    height: 200px;
}

.lt li img {
	width:150px;
	height:150px;
}
.lt{
	width:100%;
	height:auto;
}
.lt .lt_more {
	position:absolute;
    float: right;
    top: 10px;
}

pre {
    overflow-x: visible;
    font-size: 1.1em;
}

</style>  
</div>
<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->