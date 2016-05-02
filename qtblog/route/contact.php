<?php
!defined('DEBUG') AND exit('Access Denied.');
$action = param(1);
if($action == 'send') {
include './xiunophp/xn_send_mail.func.php';
$name = param('name');
$email = param('email');
$phone = param('phone');
$message = param('message');

	$smtplist = include './conf/smtp.conf.php';
	$n = array_rand($smtplist);
	$smtp = $smtplist[$n];
	$subject = $name . '在' . $conf['appname'] . '给你发送了邮件';
	$message = $email . "\r\n" . $message;
	$r = xn_send_mail($smtp, $name, 'qt06.com@139.com', $subject, $message);
	
	if($r === TRUE) {
		message(0, '发送成功。');
	} else {
		message(1, $errstr);
	}
}

$conf['title'] = '联系我';
include './qtblog/view/contact.php';

