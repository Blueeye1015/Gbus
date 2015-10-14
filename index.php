<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>吉巴士 - 首页</title>
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/views/css/head-foot.css">
	<link rel="stylesheet" href="/views/css/index.css">
	<script src="/lib/jquery/jquery.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	<?php require ('./views/public/header.php'); ?>
	<section class="main-index">
		<div class="bus-tunnel">
			<a href="/views/page/pbus.php">
				<img class="circle-btn left-btn" src="/static/img/btn-left.png">
			</a>
			<a href="/views/page/gbus.php">
				<img class="circle-btn right-btn" src="/static/img/btn-right.png">
			</a>
		</div>
		<img src="/static/img/index-land.png" class="index-land">
		<div></div>
	</section>
</body>
<script>
	$('.main-index').height($(window).height() - 100);
	$('.index-land').height($(window).height() * 0.7);
	$('.left-btn').css({'width':$(window).width() * 0.15,'left':$(window).width() * 0.2});
	$('.right-btn').css({'width':$(window).width() * 0.15,'left':$(window).width() * 0.56});

	$('.circle-btn').hover(function() {
		$(this).animate({width: $(this).width() + 5}, "fast");
	}, function() {
		$(this).animate({width: $(this).width() - 5}, "fast");
	})
</script>
<script src="/views/js/common.js"></script>
</html>