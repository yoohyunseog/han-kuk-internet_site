<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>
<script>
var gapikey = 'AIzaSyB8iIcd6fUMjuJNWxzLyAI1Ub92UWgnSfQ';
function search() {

    // clear 
    $('#results').html('');
    $('#buttons').html('');
    alert();
    // get form input
    q = query;  // this probably shouldn't be created as a global
    
    // run get request on API
    $.get(
    	"https://www.googleapis.com/youtube/v3/search", {
            part: 'snippet, id',
            q: '조작',
            type: 'video',
            key: gapikey,
            order: 'viewCount',
            publishedAfter: publishedAfter,
            publishedBefore: publishedBefore
        }, function(data) {
            var nextPageToken = data.nextPageToken;
            var prevPageToken = data.prevPageToken;
            
            // Log data
            console.log(data);
            
            $.each(data.items, function(i, item) {
                // Get Output
                var output = getOutput(item);
                
                // display results
                $('#results').append(output);
            });
            
            var buttons = getButtons(prevPageToken, nextPageToken);
            
            // Display buttons
            $('#buttons').append(buttons);
        });
}

//Build output
function getOutput(item) {
    var videoID = item.id.videoId;
    var title = item.snippet.title;
    var description = item.snippet.description;
    var thumb = item.snippet.thumbnails.high.url;
    var channelTitle = item.snippet.channelTitle;
    var videoDate = item.snippet.publishedAt;
    var query = statistics(videoID);
    // Build output string
/*    var output = 	'<li>' +
        				'<div class="list-left">' +
        					'<img src="' + thumb + '">' +
        				'</div>' +
        				'<div class="list-right">' +
        					'<h3><a data-fancybox-type="iframe" class="fancyboxIframe" href="http://youtube.com/embed/' + videoID + '?rel=0">' + title + '</a></h3>' +
        					'<small>By <span class="cTitle">' + channelTitle + '</span> on ' + videoDate + '</small>' +
        					'<p>' + description + '</p>' +'<p>' +"조회수: "+query +'회' +'</p>'+
        				'</div>' +
        			'</li>' +
        			'<div class="clearfix"></div>' +
        			'';
    return output;*/
    var output = 	'<li>' +
	'<div class="list-left">' +
		'<img src="' + thumb + '">' +
	'</div>' +
	'<div class="list-right">' +
		'<h3><a data-fancybox-type="iframe" class="fancyboxIframe" href="http://youtube.com/embed/' + videoID + '?rel=0">' + title + '</a></h3>' +
		'<small>' + videoDate + '</small>' +
		'<p>' + description + '</p>' +'<p>' +"조회수: "+query +'회' +'</p>'+
	'</div>' +
'</li>' +
'<div class="clearfix"></div>' +
'';
return output;
}
</script>
<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<div class="lt">
    <strong class="lt_title"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><?php echo $bo_subject; ?></a></strong>
    <ul>
    <?php for ($i=0; $i<count($list); $i++) {  ?>
        <li>
            <?php
            //echo $list[$i]['icon_reply']." ";
            echo "<a href=\"".$list[$i]['href']."\">";
            if ($list[$i]['is_notice'])
                echo "<strong>".$list[$i]['subject']."</strong>";
            else
                echo $list[$i]['subject'];

            if ($list[$i]['comment_cnt'])
                echo $list[$i]['comment_cnt'];

            echo "</a>";

            // if ($list[$i]['link']['count']) { echo "[{$list[$i]['link']['count']}]"; }
            // if ($list[$i]['file']['count']) { echo "<{$list[$i]['file']['count']}>"; }

            if (isset($list[$i]['icon_new'])) echo " " . $list[$i]['icon_new'];
            if (isset($list[$i]['icon_hot'])) echo " " . $list[$i]['icon_hot'];
            if (isset($list[$i]['icon_file'])) echo " " . $list[$i]['icon_file'];
            if (isset($list[$i]['icon_link'])) echo " " . $list[$i]['icon_link'];
            if (isset($list[$i]['icon_secret'])) echo " " . $list[$i]['icon_secret'];
             ?>
        </li>
    <?php }  ?>
    <?php if (count($list) == 0) { //게시물이 없을 때  ?>
    <li>게시물이 없습니다.</li>
    <?php }  ?>
    </ul>
    <div class="lt_more"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><span class="sound_only"><?php echo $bo_subject ?></span>더보기</a></div>
</div>
<ul id="results"></ul>
<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->