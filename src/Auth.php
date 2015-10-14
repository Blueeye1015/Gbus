<?php 

if (!isset($_SESSION)) {  
   session_start();  
}

/**
* Auth class for wechat
* @author Xiangmin Wang <wang@xiangmin.net>
*/
class Auth
{
	public $auth;
	private $user;
	private $refresh_token;
	
	function __construct($config = [])
	{
		$config = [
			'app_id' => 'wxaa24b8c26ef8c218',
			'secret' => '456840b01100991311951e2ddbdfa066'
		];
		$this->auth = new \Overtrue\Wechat\Auth($config);
		
		$this->user = null;
		$this->refresh_token = null;
	}

	public function getUser()
	{
		if (!isset($_SESSION['user'])) {
			return null;
		}

		return $_SESSION['user'];
	}

	public function setUser()
	{
		if (!$this->getUser()) {
			$this->user = $this->auth->authorize();
			$_SESSION['refresh_token'] = $this->auth->refresh_token;
		} elseif (!$this->auth->accessTokenIsValid($_SESSION['user']->accessToken, $_SESSION['user']->openid )) {
			$this->user = $this->auth->refresh($_SESSION['refresh_token']);
		}

		$_SESSION['user'] = $this->user;
		return $this->user;
	}

	public function login($refer)
	{
		$_SESSION['redirect'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		header("Location: http://www.greatbus.cn/gchat/wap/_login.php?refer=".$refer);
	}
}
