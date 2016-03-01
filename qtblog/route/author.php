<?php
!defined('DEBUG') AND exit('Access Denied.');
$author = param(1);
$conf['title'] = '晴天博客';
$bloglist = content_find(array('authorId'=>$author),array('cid'=>-1),1,10);
include './qtblog/view/index.php';
