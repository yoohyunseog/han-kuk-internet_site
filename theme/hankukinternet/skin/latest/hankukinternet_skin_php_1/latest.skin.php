<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>

<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<div class="lt">
<?php echo $bo_subject;?>
    <?php
/**
 * Library Requirements
 *
 * 1. Install composer (https://getcomposer.org)
 * 2. On the command line, change to this directory (api-samples/php)
 * 3. Require the google/apiclient library
 *    $ composer require google/apiclient:~2.0
 */



if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
  throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}

require_once __DIR__ . '/vendor/autoload.php';

$htmlBody = <<<END
<form method="GET">
  <div>
    Search Term: <input type="search" id="q" name="q" placeholder="Enter Search Term">
  </div>
  <div>
    Max Results: <input type="number" id="maxResults" name="maxResults" min="1" max="50" step="1" value="25">
  </div>
  <input type="submit" value="Search">
</form>
END;
$_GET['q'] = $bo_1;
$_GET['maxResults'] =1;
// This code will execute if the user entered a search query in the form
// and submitted the form. Otherwise, the page displays the form above.
if (isset($_GET['q']) && isset($_GET['maxResults'])) {
  /*
   * Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the
   * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
   * Please ensure that you have enabled the YouTube Data API for your project.
   */
  $DEVELOPER_KEY = $bo_10;
  $key = $bo_9;
  $client = new Google_Client();
  $client->setDeveloperKey($DEVELOPER_KEY);

  // Define an object that will be used to make all API requests.
  $youtube = new Google_Service_YouTube($client);

  $htmlBody = '';
  $day = date('Y-m-d\TH:i:s\Z');
  $day_month = date(m);
  //date
  $publishedAfter = '2017-'.($day_month).'-01T00:00:00Z';
  date_default_timezone_set("Asia/Seoul");
  $publishedBefore = $day;
  $array_movie = array();
  $jsonURL = file_get_contents("http://www.kobis.or.kr/kobisopenapi/webservice/rest/boxoffice/searchDailyBoxOfficeList.json?key={$key}&targetDt=20170312");
  $json = json_decode($jsonURL);
  //boxOfficeResult.dailyBoxOfficeList[i].movieNm
  for($i=2; $i<10; $i++){
  	//echo $json->{'boxOfficeResult'}->{'dailyBoxOfficeList'}[$i]->{'movieNm'};
  	$array_movie[$i] = $json->{'boxOfficeResult'}->{'dailyBoxOfficeList'}[$i]->{'movieNm'};
  }
  for($i=0; $i<count($array_movie); $i++){
  try {
    // Call the search.list method to retrieve results matching the specified
    // query term.
    $searchResponse = $youtube->search->listSearch('id,snippet', array(
      'q' => $_GET['q'].' '.$array_movie[$i],
      'maxResults' => $_GET['maxResults'],
      'order' => 'viewCount',
      'publishedAfter' => $publishedAfter,
      'publishedBefore'	=> $publishedBefore,
    ));
    $videos = '';
    $publishedAt = '';
    $count = 0;
    // Add each result to the appropriate list, and then display the lists of
    // matching videos, channels, and playlists.
    foreach ($searchResponse['items'] as $searchResult) {
      switch ($searchResult['id']['kind']) {
        case 'youtube#video':
         	$video_ID = $searchResult['id']['videoId'];
        	$jsonURL = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id={$video_ID}&key={$DEVELOPER_KEY}&part=statistics");
        	$json = json_decode($jsonURL);
        	$views = $json->{'items'}[0]->{'statistics'}->{'viewCount'}; 
        	
        	$videos .= sprintf('<li id="li_%s_%s"><img src="%s"><br>%s <br>https://www.youtube.com/watch?v=XEJUkWF7m9c날짜:%s <br><hd id="hd%s_%s">조회수:%s</hd></li>',$i,$i,$searchResult['snippet']['thumbnails']['medium']['url'],
        			$searchResult['snippet']['title'],$searchResult['snippet']['publishedAt'],$bo_table,$views,$views);
        	$count++;
        	sleep(0.1);
         break;
      }
    }
  	
    $htmlBody .= <<<END
    <ul id="vidos_ul">$videos</ul>
END;
  } catch (Google_Service_Exception $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  }
}
}
?>
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
.lt .lt_more {
	position:relative;
	float:right;
	top:0px;
}
</style>

    <div class="lt_more"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><span class="sound_only"><?php echo $bo_subject; echo $bo_1; ?></span>더보기</a></div>
	<?=$htmlBody?>
</div>

<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->