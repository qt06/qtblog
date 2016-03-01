<?php
!defined('DEBUG') AND exit('Access Denied.');
$cid = param(1, 0);
empty($cid) AND message(-1, '您的访问出错啦！');

$blog = content_read($cid);
empty($blog) AND message(-1, '您的访问出错啦！');
content_increase($cid,'views');
$conf['title'] = $blog['title'] . ' - 晴天博客';
content_format($blog);
include './qtblog/view/post.php';
