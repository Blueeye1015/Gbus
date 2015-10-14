<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>吉巴士 - 定制巴士</title>
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/views/css/pbus.css">
	<link rel="stylesheet" href="/views/css/head-foot.css">
</head>
<body>
	<?php require ('../public/header.php'); ?>
	<section class="main">
		<div class="image-frame">
			<img src="/static/img/KV.jpg" alt="">
			<div class="input-area">
				<form action="./detail.php">
					<input class="main-input" name="startpoint" type="text" placeholder="你想从哪儿上车？">
					<input class="main-input" name="endpoint" type="text" placeholder="你想从哪儿下车？">
					<button type="submit" class="btn btn-danger" id="main-input-btn">搜索班车线路</button>
				</form>
			</div>
		</div>
		<div id="main-text" class="text">
			<img id="left-icon" src="/static/img/text-icon.png" alt="">
			<div id="right-text">
				<h3>互联网全新拼巴定制线路在线平台</h3>
				<p>吉巴士是一家专注于大巴运营的服务平台，我们通过数据收集系统，将大巴闲置时间利用起来，
                    并通过我们专业的资质审核结合严厉的车队奖惩制度，为受众提供优质的用车、乘车体验。
                    我们致力于分担和缓解城市上班族出行难的困扰，提倡安全、绿色、集约的“拼巴”出行方式。</p>
			</div>
		</div>
	</section>
	<section class="main text-field">
		<div class="line">
			<div class="index-box">
				<img class="box-img" src="/static/img/index-box-img1.jpg" alt="">
			</div><div class="index-box text"> <!-- to remove space -->
				<img class="box-icon" src="/static/img/index-box-icon1.png" alt="">
				<h3>以客为尊，线路定制</h3>
				<p>通过我们的WAP手机端可以发起用车需求，我们会将呼声最高的线路整合并让大家“加油”，
				最终的线路是由需求决定，更合理、更高效。</p>
			</div>
		</div><!-- line_1 -->

		<div class="line">
			<div class="index-box text">
				<img class="box-icon" src="/static/img/index-box-icon2.png" alt="">
				<h3>一人一座，安全舒适</h3>
				<p>我们通过，服务端的预定功能，保障每一位预定成功的乘客都能有座位。我们坚决抵制超员、超载。
                    吉巴士始终将每一位乘客的乘车安全和乘车体验放在首要位置。</p>
			</div><div class="index-box"> <!-- to remove space -->
				<img class="box-img" src="/static/img/index-box-img2.jpg" alt="">
			</div>
		</div><!-- line_2 -->

		<div class="line">
			<div class="index-box">
				<img class="box-img" src="/static/img/index-box-img3.jpg" alt="">
			</div><div class="index-box text"> <!-- to remove space -->
				<img class="box-icon" src="/static/img/index-box-icon3.png" alt="">
				<h3>高效运维，福利不停</h3>
				<p>吉巴士不仅是一辆班车，更多的是一个福利分享社区。
                    通过团队不断开拓合作商的加入，越来越多的优质福利也将源源不断的输送给每一位“吉”用户。</p>
			</div>
		</div><!-- line_3 -->
	</section>
	<?php require ('../public/footer.php'); ?>
	<script src="/lib/jquery/jquery.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
	<script src="/views/js/common.js"></script>
	<script src="/views/js/pbus.js"></script>
	<script>
		$('form').submit(function () {
			var flag = true;
			$('input').each(function() {
				if($(this).val() == "") {
					alert("请填写完整信息!");
					flag = false;
					return false;
				}
			})
			return flag;
		})
	</script>
</body>
</html>