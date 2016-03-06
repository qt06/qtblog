<?php
!defined('DEBUG') AND exit('Access Denied.');
$author = param(1,0);
$page = param(2,0);
empty($author) AND $author = 1;
empty($page) AND $page = 1;
$pagesize = 20;
$conf['title'] = '晴天博客';
$bloglist = content_find(array('authorId'=>$author),array('cid'=>-1),$page,$pagesize);
$pager = pager($conf['appurl'] . 'author/1/{page}/', count($bloglist), $page, $pagesize);
include './qtblog/view/index.php';
