<?php
	require_once("../module/db/db.php");
	if(isset($_COOKIE["gbus"]) && $_COOKIE["gbus"] == md5(date("Ymd") . "greatbus")) {
		$result = mysql_query("SELECT * FROM `lines`");
		$lineArray = array();
		while($lines = mysql_fetch_object($result)) {
			$lineArray[$lines->id] = $lines->route;
		}
	} else {
		header("Location:http://www.greatbus.cn/managesys/admin-login.php");
	}
?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>GBUS后台管理</title>
	<link rel="stylesheet" href="../lib/bootstrap/css/bootstrap.min.css"/>
	<style>
		.main {
			width: 80%;
			margin: 0 auto;
			margin-bottom: 40px;
		}
		#apply-table {
			margin-top: 10px;
			display: none;
		}
		.green {
			font-weight: bold;
			color: limegreen;
		}
	</style>
	<script src="../lib/jquery/jquery.min.js"></script>
	<script src="../lib/bootstrap/js/bootstrap.min.js"></script>
	<script src="../lib/echart/echarts.js"></script>
</head>
<body>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">GBUS后台管理</a>
			</div>
		</div>
	</nav>
	<div class="main">
		<button class="btn btn-danger btn-lg" id="vip-btn" style="margin-bottom: 20px">推送VIP消息(请确认完信息正确后再点)</button>
		<div id="recentBookData" style="height:400px"></div>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>日期</th>
					<th>订票数</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = "SELECT LEFT(lines.leaveAt, 10) as date, COUNT(tickets.id) as number FROM `tickets` LEFT JOIN `lines` ON tickets.line_id = lines.id GROUP BY LEFT(lines.leaveAt, 10) LIMIT 0,15";
				$dResult = mysql_query($sql);
				while($row = mysql_fetch_array($dResult)) {
					$date = $row["date"];
					$number = $row["number"];
					if($date != null) {
						echo "
							<tr>
								<td>{$date}</td>
								<td>{$number}</td>
							</tr>";
					} else {
						continue;
					}
				}
				?>
			</tbody>
		</table>
	</div>

	<div class="main">
		<h4>近期班车排班</h4>
		<table class="table table-bordered">
			<thead>
			<tr>
				<th>路线</th>
				<th>车号</th>
				<th>时间</th>
				<th>剩余座位</th>
				<th>上车人数</th>
				<th>上车率(上车人数/售出票数)</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$route = "SELECT * FROM `lines` WHERE `status` = 1 AND `leaveAt` BETWEEN curdate() AND date_add(curdate(), INTERVAL 1 DAY) order by `route`,`leaveAt`";
			$aresult = mysql_query($route);
			while($jrow = mysql_fetch_array($aresult)) {
				$peopleNum = mysql_query("SELECT COUNT( * ) as number FROM  `tickets` WHERE `state` = 1 AND `line_id` = ".$jrow["id"]);
				$nresult = mysql_fetch_array($peopleNum);
				if($jrow["busNo"] == 3) {
					$wholeSit = 19;
				} else {
					$wholeSit = 44;
				}
				$sitPercent = intval($nresult["number"] / ($wholeSit - $jrow["sitnum"]) * 100);
				if($sitPercent > 100) $sitPercent = 100;
				echo "
						<tr>
							<td>{$jrow["route"]}</td>
							<td>{$jrow["busNo"]}号车</td>
							<td>{$jrow["leaveAt"]}</td>";
						if($jrow["sitnum"] == 0) {
							echo "<td class='green'>{$jrow["sitnum"]} / {$wholeSit}</td>";
						} else {
							echo "<td>{$jrow["sitnum"]} / {$wholeSit}</td>";
						}
				echo "
							<td>{$nresult["number"]}</td>
							<td> $sitPercent %</td>
						</tr>";
			}
			$route = "SELECT * FROM `lines` WHERE `status` = 1 AND `leaveAt` BETWEEN date_add(curdate(), INTERVAL 1 DAY) AND date_add(curdate(), INTERVAL 2 DAY) order by `route`,`leaveAt`";
			$aresult = mysql_query($route);
			while($jrow = mysql_fetch_array($aresult)) {
				if($jrow["busNo"] == 3) {
					$wholeSit = 19;
				} elseif($jrow["busNo"] == 4) {
					$wholeSit = 33;
				} else {
					$wholeSit = 44;
				}
				$sitPercent = intval($nresult["number"] / ($wholeSit - $jrow["sitnum"]) * 100);
				if($sitPercent > 100) $sitPercent = 100;
				$peopleNum = mysql_query("SELECT COUNT( * ) as number FROM  `tickets` WHERE `state` = 1 AND `line_id` = ".$jrow["id"]);
				$nresult = mysql_fetch_array($peopleNum);
				echo "
						<tr class='info'>
							<td>{$jrow["route"]}</td>
							<td>{$jrow["busNo"]}号车</td>
							<td>{$jrow["leaveAt"]}</td>";
				if($jrow["sitnum"] == 0) {
					echo "<td class='green'>{$jrow["sitnum"]} / {$wholeSit}</td>";
				} else {
					echo "<td>{$jrow["sitnum"]} / {$wholeSit}</td>";
				}
				echo "
							<td>{$nresult["number"]}</td>
							<td> $sitPercent %</td>
						</tr>";
			}
			?>
			</tbody>
		</table>
	</div>

	<div class="main">
		<h4>申请开通信息</h4>
		<button class="btn btn-default" id="apply-table-btn">展开/隐藏表格</button>
		<table class="table table-bordered" id="apply-table">
			<thead>
				<tr>
					<th>路线</th>
					<th>手机号</th>
					<th>时间段</th>
					<th>信息创建时间</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$apply = "SELECT * FROM `jiayou` WHERE `phone` != '' order by `rid`";
				$aresult = mysql_query($apply);
				while($jrow = mysql_fetch_array($aresult)) {
					$rid = $jrow['rid'];
					if(array_key_exists($jrow['rid'],$lineArray)) {
						$lineName = $lineArray[$rid];
					} else {
						continue;
					}
					echo "<tr>
								<td>{$lineName}</td>
								<td>{$jrow["phone"]}</td>
								<td>{$jrow["time"]}</td>
								<td>{$jrow["createAt"]}</td>
							</tr>";
				}
				?>
			</tbody>
		</table>
	</div>

<!--	<div class="main">-->
<!--		<h4>订座信息</h4>-->
<!--		<table class="table table-bordered">-->
<!--			<thead>-->
<!--			<tr>-->
<!--				<th>路线</th>-->
<!--				<th>手机号</th>-->
<!--				<th>是否上车</th>-->
<!--				<th>订座时间</th>-->
<!--			</tr>-->
<!--			</thead>-->
<!--		</table>-->
<!--	</div>-->
	<script src="managesys.js"></script>
	<script src="/lib/leancloud-javascript-sdk/dist/av-core-mini.js"></script>
	<script>
		var leanconfig = {
			APPID: 'q0esn38jbmkacw7hgt6bcevpplubg6lfffnz2sfmlhjz0gz1',
			APPKEY: 'kn4ys1veebhjzyp7jmh9njsua0qir2jyjxyt3j2nf7h43i4l',
		}
		var vipData = {}
		AV.initialize(leanconfig.APPID, leanconfig.APPKEY);
		var vip = AV.Object.extend("vip")
		var query = new AV.Query(vip)
		$('#vip-btn').on('click', function () {
			query.find({
				success: function (users) {
					for(var i in users) {
						vipData[i] = {"openId": users[i].attributes.openId,
							"lineId": users[i].attributes.lineId,
							"ticketId": users[i].attributes.ticketId
						}
					}
					var postData = JSON.stringify(vipData)
					$.ajax({
						type: "POST",
						url: "./sendTicket.php",
//						dataType: "json",
						data: {vip: postData},
						success: function (res) {
							console.log(res.responseText)
						},
						error: function (err) {
							console.log(err)
						}
					})
				},
				error: function (e) {
					alert(e)
				}
			})
		})
	</script>
</body>
</html>