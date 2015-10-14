<?php
/**
 * Created by PhpStorm.
 * User: Dante
 * Date: 2015.06.20
 * Time: 19:40
 */
if(isset($_POST['password']) && $_POST['password'] == date("Ymd")) {
	setcookie("gbus", md5(date("Ymd") . "greatbus"), time()+3600*2);
	header("Location:http://www.greatbus.cn/managesys/book-data.php");
} else {
	header("Location:http://www.greatbus.cn/managesys/admin-login.php");
}