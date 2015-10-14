<?php
/**
 * 微信公众平台 PHP SDK 示例文件
 *
 * @author NetPuter <netputer@gmail.com>
 */

  require('./gchat/Wechat.php');
  require('./module/db/db.php');

  /**
   * 微信公众平台演示类
   */
  class MyWechat extends Wechat {
    protected function onSubscribe() {
      $this->responseText('欢迎关注吉巴士！');
    }

    protected function onUnsubscribe() {
      // 「悄悄的我走了，正如我悄悄的来；我挥一挥衣袖，不带走一片云彩。」
    }

    protected function menuFunction($eventID,$openID) {
      switch ($eventID) {
        case 'ABOUT_US':
          $this->responseText('感谢您支持吉巴士');
        default:
          $this->responseText('发生了一些未知的错误=.=!我们正在处理中~');
          break;
      }
    }

    protected function onText() {
	    if(substr($this->getRequest('content'),0,6) === '充值'){
		    $this->responseText('感谢您参与我们的活动，请期待幸运的降临吧！');
	    } else {
		    $this->responseText('您好，感谢您支持吉巴士！您的支持是我们前进的动力！');
	    }
    }

    protected function onImage() {
      $items = array(
        new NewsResponseItem('标题一', '描述一', $this->getRequest('picurl'), $this->getRequest('picurl')),
        new NewsResponseItem('标题二', '描述二', $this->getRequest('picurl'), $this->getRequest('picurl')),
      );

      $this->responseNews($items);
    }

    /**
     * 收到地理位置消息时触发，回复收到的地理位置
     *
     * @return void
     */
    protected function onLocation() {
      $num = 1 / 0;
      // 故意触发错误，用于演示调试功能

      $this->responseText('收到了位置消息：' . $this->getRequest('location_x') . ',' . $this->getRequest('location_y'));
    }

    /**
     * 收到链接消息时触发，回复收到的链接地址
     *
     * @return void
     */
    protected function onLink() {
      $this->responseText('收到了链接：' . $this->getRequest('url'));
    }

    /**
     * 收到未知类型消息时触发，回复收到的消息类型
     *
     * @return void
     */
    protected function onUnknown() {
      $this->responseText('收到了未知类型消息：' . $this->getRequest('msgtype'));
    }

  }

  $wechat = new MyWechat('weixin', TRUE);
  $wechat->run();
