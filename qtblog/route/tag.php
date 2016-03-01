<?php
!defined('DEBUG') AND exit('Access Denied.');
$tag = param(1);
$page = param(2,0);
empty($tag) AND $tag = 'wuzhangai';
empty($page) AND $page = 1;
$pagesize = 20;
$tag = urldecode($tag);
$conf['title'] = $tag . ' - 晴天博客';
$bloglist = content_find_by_tag($tag,array('cid'=>-1),$page,$pagesize);
$pager = pager($conf['appurl'] . 'tag/' . $tag . '/{page}/', count($bloglist), $page, $pagesize);
include './qtblog/view/index.php';
