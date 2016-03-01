<?php
!defined('DEBUG') AND exit('Access Denied.');

$title = param('title');
$text = param('text', '', false);
if(empty($title) || empty($text)) {
echo '<!DOCTYPE html>
<html>
<head>
<title>发布文章</title>
<meta charset="utf-8" />
</head>
<body>
<h2>发布文章</h2>
<form action="add.htm" method="post">
<p><label for="title">标题：</label><input type="text" id="title" name="title" /></p>
<p><label for="text">内容：</label><textarea id="text" name="text"></textarea></p>
<button type="submit">发布</button>
</form>
</body>
</html>';
exit();
}

$ret = content_create(array('title'=>$title,'text'=>$text,'created'=>time(),'modified'=>time(),'authorId'=>1));
var_dump($ret);
$blog = content_read($ret);
var_dump($blog);
