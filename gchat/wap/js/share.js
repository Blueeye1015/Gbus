'use strict'
function share(openid) {
	wx.ready(function(){
		wx.onMenuShareTimeline({
			title: '吉巴士不让你的TA去试衣间 准时免费接送上下班', // 分享标题
			desc: '我今天坐了吉巴士免费大巴，你也来试试吧！',
			link: 'http://www.greatbus.cn/gchat/wap/huodong.html', // 分享链接
			imgUrl: 'http://www.greatbus.cn/static/img/share-logo.jpg', // 分享图标
			success: function () {
				var busUser = AV.Object.extend("gbusUser")
				var query = new AV.Query(busUser)
				query.equalTo("openId", openid)
				query.find({
					success: function (users) {
						if(users[0].attributes.scorePerDay < 300) {
							users[0].set("score", users[0].attributes.score + 100)
							users[0].set("scorePerDay", users[0].attributes.scorePerDay + 100)
							users[0].save()

							var data = AV.Object.extend("dataCount")
							var query = new AV.Query(data)
							query.get('55a3a3e1e4b06d11d38bcb5a', {
								success: function (data) {
									data.set("shareNum", data.attributes.shareNum + 1)
									data.save()
								},
								error: function (e) {
									console.log(e)
								}
							})
							alert('分享成功!您已经获得100积分!');
						} else {
							alert('每天只可以赚取300积分噢，更多积分可以通过订票确认上车后获得！');
						}
						location.reload()
					},
					error: function (e) {
						console.log(e)
					}
				})
			},
			cancel: function () {
				alert('只有成功分享才能获得积分哦!');
			}
		});
		wx.onMenuShareAppMessage({
			title: '吉巴士不让你的TA去试衣间 准时免费接送上下班', // 分享标题
			desc: '我今天坐了吉巴士免费大巴，你也来试试吧！',
			link: 'http://www.greatbus.cn/gchat/wap/huodong.html', // 分享链接
			imgUrl: 'http://www.greatbus.cn/static/img/share-logo.jpg', // 分享图标
			success: function () {
				var busUser = AV.Object.extend("gbusUser")
				var query = new AV.Query(busUser)
				query.equalTo("openId", openid)
				query.find({
					success: function (users) {
						if(users[0].attributes.scorePerDay < 300) {
							users[0].set("score", users[0].attributes.score + 100)
							users[0].set("scorePerDay", users[0].attributes.scorePerDay + 100)
							users[0].save()

							var data = AV.Object.extend("dataCount")
							var query = new AV.Query(data)
							query.get('55a3a3e1e4b06d11d38bcb5a', {
								success: function (data) {
									data.set("shareNum", data.attributes.shareNum + 1)
									data.save()
								},
								error: function (e) {
									console.log(e)
								}
							})
							alert('分享成功!您已经获得100积分!');
						} else {
							alert('每天只可以赚取300积分噢，更多积分可以通过订票确认上车后获得！');
						}
						location.reload()
					},
					error: function (e) {
						console.log(e)
					}
				})
			},
			cancel: function () {
				alert('只有成功分享才能获得积分哦!');
			}
		})
	});
}