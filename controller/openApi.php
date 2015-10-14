<?php
/**
 * Created by PhpStorm.
 * User: Dante
 * Date: 2015/7/6
 * Time: 17:12
 */
include('../vendor/autoload.php');
include('../module/db/db.php');

if($_POST['type'] == 'recentTickets') {
	$sql = "SELECT LEFT(lines.leaveAt, 10) as date, COUNT(tickets.id) as number FROM `tickets` LEFT JOIN `lines` ON tickets.line_id = lines.id GROUP BY LEFT(lines.leaveAt, 10) LIMIT 0,15";
	$result = mysql_query($sql);
	$jsonData = [];

	while($row = mysql_fetch_array($result)) {
		if($row['date'] != null) {
			$jsonData[$row['date']] = $row['number'];
		}
	}

	$response = json_encode($jsonData);
	print_r($response);
} else if ($_POST['type'] == 'addTicket') {
	$phone = $_POST['phone'];
	$openId = $_POST['open_id'];
	$lineId = $_POST['line_id'];
	$sql = "INSERT INTO `tickets`(`phone`, `line_id`, `openid`) VALUES ({$phone}, {$lineId}, '{$openId}')";
	$result = mysql_query($sql);
	echo mysql_insert_id();
} else if ($_POST['type'] == 'sendTicket') {
	$config = [
		'app_id' => 'wxaa24b8c26ef8c218',
		'secret' => '456840b01100991311951e2ddbdfa066'
	];
	$notice = new \Overtrue\Wechat\Notice($config);
	$color = '#ff0000';
	$templateId = "zMDgxQa9cZ-OITQ0cxSdABb1X9-j0p6xiOPQIyvWlBQ";
	$phone = $_POST['phone'];
	$openId = $_POST['open_id'];
	$lineId = $_POST['line_id'];
	$ticketId = $_POST['ticket_id'];

	$getLineInfo = mysql_query("SELECT `route`, `leaveAt`, LEFT(`leaveAt`, 10) as time FROM `lines` WHERE `id` = {$lineId}");
	$lineInfo = mysql_fetch_object($getLineInfo);

	$points = explode(',', $lineInfo->route);
	$url = "http://www.greatbus.cn/gchat/wap/ticket.php?id={$ticketId}";
	// 恭喜您，订座成功！宜山路站-虹桥路站 13780032111 2015-01-01 12:22:33 点击查看车票
	$data = [
		"first"    => "恭喜您，订座成功！\n班次信息：" . $points[0] . "->" . $points[count($points) - 1] . "\n用户类型：VIP用户",
		"keyword1" => "订单确认",
		"keyword2" => date('Y-m-d H:i:s', time()),
		"remark"   => "发车时间：".$lineInfo->leaveAt."\n备注信息：过时不候，请提前到达上车点，谢谢配合！",
	];

	try {
		$messageId = $notice->uses($templateId)->withColor($color)->withUrl($url)->andData($data)->andReceiver($openId)->send();
	} catch (Exception $e) {
		var_dump($e);
	}
}