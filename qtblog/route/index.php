<?php
!defined('DEBUG') AND exit('Access Denied.');
$page = param(1, 0);
empty($page) AND $page = 1;
$pagesize = 20;
$conf['title'] = '晴天博客';
$bloglist = content_find(array(),array('cid'=>-1),$page, $pagesize);
$pager = pager($conf['appurl'] . 'index/{page}/', count($bloglist), $page, $pagesize);
include './qtblog/view/index.php';
