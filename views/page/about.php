<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>吉巴士 - 关于我们</title>
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/views/css/head-foot.css">
	<link rel="stylesheet" href="/views/css/about.css">
</head>
<body>
	<?php require ('../public/header.php'); ?>
	<section class="kv"></section>
	<div class="gray">
		<section class="main cop">
			<div class="line">
				<div class="index-box qa">
					<p class="question">有什么<span class="red">好的建议？</span></p>
					<p class="question">有什么<span class="red">想问我们？</span></p>
					<p class="contact">随时联系我们</p>
					<p class="contact">cooperation@greatbus.net</p>
				</div><div class="index-box"> <!-- to remove space -->
					<img class="box-img" src="/static/img/about-hand.jpg" alt="">
				</div>
			</div><!-- line_1 -->

			<div class="line">
				<div class="index-box">
					<img class="box-img" src="/static/img/about-computer.jpg" alt="">
				</div><div class="index-box about-us"> <!-- to remove space -->
					<h3 class="story-title">品牌故事</h3>
					<p class="story">吉巴士是一家上海本土的网络科技公司。创始人和联合创始人都是普通的上班族，每天挤地铁、挤公交、坐黑车苦不堪言。
					他们在一次朋友婚宴上，从租婚庆大巴这个话题开始，聊到在上海早晚高峰出行太辛苦。创始人J将创建一个集合所有巴士资源的网络平台的想法告诉了W，
					多年同窗好友的两人一拍即合！说干就干，创立了“吉巴士”，通过互联网＋巴士的模式,
					让市民拥有一站式的大巴租赁平台，并通过大巴资源的有效利用，开设公益直通班车，让市民得到实惠，
					缓解上海上下班的出行难和社区最后一公里的难题，提倡绿色、集约、安全。
					<p class="story">吉巴士集合巴士力量，集合市民力量，带来全新的极至绿色出行新
					方式！吉巴士坚持公益先行的理念，欢迎社会各界的有识之士支持和关注吉巴士！！</p>
				</div>
			</div><!-- line_2 -->
			<section class="about-bar"></section>
			<section class="cooperate">
				<div class="col-md-4">
					<p class="cop-title">商务合作</p>
					<p>联系电话: 15000058518</p>
				</div>
				<div class="col-md-4">
					<p class="cop-title">市场合作</p>
					<p>联系电话: 021-62606678</p>
				</div>
				<div class="col-md-4">
					<p class="cop-title">客服相关</p>
					<p>联系电话: 021-62606678</p>
				</div>
			</section>
		</section>
	</div>
	<?php require ('../public/footer.php'); ?>
	<script src="/lib/jquery/jquery.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
	<script src="/views/js/common.js"></script>
	<script>
		$('.kv').height($(window).width() / 4.13);
		$('.main-text').css('padding-top', $(window).width() / 20);
	</script>
</body>
</html>