<?php

define('DEBUG', 1); 				// 发布的时候改为 0 
define('APP_NAME', 'qtblog');			// 应用的名称
//define('APP_PATH', './');			// 应用的路径 getcwd().'/'   dirname(__FILE__).'/'
//define('IN_SAE', class_exists('SaeKV'));	// 一般应用不需要支持 SAE，可以删掉
define('URL_REWRITE_PATH_FORMAT_ON', 1);
$conf = (@include './conf/conf.php') OR exit(header('Location: install/'));
//IN_SAE AND include './conf/sae.conf.php'; 	// 支持 SAE
$conf += @include './qtblog/conf.php';

include './xiunophp/xiunophp.php';
include './qtblog/model/user.func.php';
include './qtblog/model/content.func.php';
include './qtblog/model/comment.func.php';
include './qtblog/model/meta.func.php';
include './qtblog/model/relationship.func.php';
include './qtblog/model/check.func.php';
include './qtblog/var/HyperDown.php';
include './qtblog/var/Parsedown.php';

$user = user_token_get(); 			// 全局的 user
$uid = $user['uid'];				// 全局的 uid
$gid = $user['gid'];				// 全局的 gid

$route = param(0, 'index');

switch ($route) {
	case 'index': 	include './qtblog/route/index.php'; 	break;
	case 'post': 	include './qtblog/route/post.php'; 	break;
	case 'about': 	include './qtblog/route/about.php'; 	break;
	case 'disk': 	include './qtblog/route/disk.php'; 	break;
	default:
		$route = preg_match("/^\w+$/", $route) ? $route : 'index';
		$filename = "./qtblog/route/$route.php";
		is_file($filename) ? include($filename) : message(-1, '您的访问出错啦！'. $route . '不存在。');
}


function message($code, $message, $goto = '') {
	global $ajax;
	if($ajax) {
		echo xn_json_encode(array('code'=>$code, 'message'=>$message));
		exit();
	}
$conf['title'] = is_array($message) ? '提示信息' : $message;
		if(is_array($message)) {
			print_r($message);
		} else {
			echo $message;
		}
if(!empty($goto)) {
			header("Location: $goto");
		}
	exit;
}

function pager($url, $totalnum, $page, $pagesize = 20) {
	$s = '<ul class="pager">';
	$page > 1 AND $s .= '<li class="prev"><a href="'.str_replace('{page}', $page-1, $url).'">上一页</a></li>';
	$totalnum >= $pagesize AND $s .= '<li class="next"><a href="'.str_replace('{page}', $page+1, $url).'">下一页</a></li>';
	$s.= '</ul>';
	return $s;
}
