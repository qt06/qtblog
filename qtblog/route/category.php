<?php
!defined('DEBUG') AND exit('Access Denied.');
$category = param(1);
$page = param(2,0);
empty($category) AND $category = 'zaqizaba';
empty($page) AND $page = 1;
$pagesize = 20;
$conf['title'] = '晴天博客';
$bloglist = content_find_by_category($category,array('cid'=>-1),$page,$pagesize);
$pager = pager($conf['appurl'] . 'category/' . $category . '/{page}/', count($bloglist), $page, $pagesize);
include './qtblog/view/index.php';
