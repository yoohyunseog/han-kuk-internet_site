<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}
?>

    </div>
</div>

<!-- } 콘텐츠 끝 -->

<hr>
<style>
#ft {
	background-color:rgba(255,255,255,0.001);
}
#ft_catch {
	background-color:rgba(255,255,255,0.001);
}
</style>
<!-- 하단 시작 { -->
<div id="ft">
    <div id="ft_copy">
        <div>
            <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company"></a>
        </div>
    </div>
</div>

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php

include_once(G5_THEME_PATH."/tail.sub.php");
?>