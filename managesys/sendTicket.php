<?php
/**
 * Created by PhpStorm.
 * User: Dante
 * Date: 2015.07.12
 * Time: 21:33
 */
require_once('../vendor/autoload.php');
require_once('../module/db/db.php');
$vips = json_decode($_POST['vip']);

$config = [
	'app_id' => 'wxaa24b8c26ef8c218',
	'secret' => '456840b01100991311951e2ddbdfa066'
];
$notice = new \Overtrue\Wechat\Notice($config);
$color = '#ff0000';
$templateId = "zMDgxQa9cZ-OITQ0cxSdABb1X9-j0p6xiOPQIyvWlBQ";
//var_dump($vips);
foreach($vips as $vip){
	$getLineInfo = mysql_query("SELECT `route`, `leaveAt`, LEFT(`leaveAt`, 10) as time FROM `lines` WHERE `id` = {$vip->lineId}");
	$lineInfo = mysql_fetch_object($getLineInfo);

	$points = explode(',', $lineInfo->route);
	$url = "http://www.greatbus.cn/gchat/wap/ticket.php?id={$vip->ticketId}";
	// 恭喜您，订座成功！宜山路站-虹桥路站 13780032111 2015-01-01 12:22:33 点击查看车票
	$data = [
		"first"    => "恭喜您，订座成功！\n班次信息：" . $points[0] . "->" . $points[count($points) - 1] . "\n用户类型：VIP用户",
		"keyword1" => "订单确认",
		"keyword2" => date('Y-m-d H:i:s', time()),
		"remark"   => "发车时间：".$lineInfo->leaveAt."\n备注信息：过时不候，请提前到达上车点，谢谢配合！",
	];

	try {
		$messageId = $notice->uses($templateId)->withColor($color)->withUrl($url)->andData($data)->andReceiver($vip->openId)->send();
	} catch (Exception $e) {
		var_dump($e);
	}
}