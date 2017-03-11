<?php 

$array_movie = array("조작된 도시","공조","트리플 엑스 리턴즈", "더 킹", "컨택트", "발레리나", "50가지 그림자: 심연", "모아나");
echo count($array_movie)."<br>";
$count = count($array_movie);
for($i=0; $i<$count; $i++){
	echo $array_movie[$i].'<br>';
}
?>