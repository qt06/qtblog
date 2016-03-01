<?php
!defined('DEBUG') AND exit('Access Denied.');

$conf['title'] = '关于 - 晴天博客';
$blog = content_read(1);
content_format($blog);
include './qtblog/view/page.php';
