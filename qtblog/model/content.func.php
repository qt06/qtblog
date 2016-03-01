<?php

/*
 * Copyright (C) qt.hk
 */


function content__create($arr) {
	$sqladd = array_to_sqladd($arr);
	return db_exec("INSERT INTO `qtblog_contents` SET $sqladd");
}

function content__update($cid, $arr) {
	$sqladd = array_to_sqladd($arr);
	return db_exec("UPDATE `qtblog_contents` SET $sqladd WHERE cid='$cid'");
}

function content__read($cid) {
	return db_find_one("SELECT * FROM `qtblog_contents` WHERE cid='$cid'");
}

function content__delete($cid) {
	return db_exec("DELETE FROM `qtblog_contents` WHERE cid='$cid'");
}

function content__find($cond = array(), $orderby = array(), $page = 1, $pagesize = 20) {
	$cond = cond_to_sqladd($cond);
	$orderby = orderby_to_sqladd($orderby);
	$offset = ($page - 1) * $pagesize;
	return db_find("SELECT * FROM `qtblog_contents` $cond$orderby LIMIT $offset,$pagesize");
}

// ------------> 关联 CURD，主要是强相关的数据，比如缓存。弱相关的大量数据需要另外处理。

function content_create($arr) {
	$r = content__create($arr);
	return $r;
}

function content_update($cid, $arr) {
	$r = content__update($cid, $arr);
	return $r;
}

function content_replace($arr) {
	$sqladd = array_to_sqladd($arr);
	return db_exec("REPLACE INTO `qtblog_contents` SET $sqladd");
}

function content_increase($cid, $column) {
	if(empty($column)) return false;
	return db_exec("UPDATE `qtblog_contents` SET $column = $column +1 WHERE cid='$cid'");
}

function content_read($cid) {
	$content = content__read($cid);
	//content_format($content);
	return $content;
}

function content_delete($cid) {
	$r = content__delete($cid);
	return $r;
}

function content_find($cond = array(), $orderby = array(), $page = 1, $pagesize = 1000) {
/**
	$keyname = implode('', array_keys($cond));
	$keyname = 'qtblog_'.$keyname.'_'.$page.'_'.$pagesize;
	$kv = new SaeKV();
	$kv->init();
	$contentlist = $kv->get($keyname);
	if(!empty($contentlist)) return $contentlist;
*/
	$contentlist = content__find($cond, $orderby, $page, $pagesize);
	if($contentlist) foreach ($contentlist as &$content) content_format($content);
	//$kv->set($keyname, $contentlist);
	return $contentlist;
}

function content_count($cond = array()) {
	return db_count('qtblog_contents', $cond);
}

function content_maxid() {
	return db_maxid('qtblog_contents', 'sid');
}

function content_format(&$content) {
	//$content['text'] = MarkdownExtraExtended::defaultTransform($content['text']);
	if(substr($content['text'], 0, 15) == '<!--markdown-->') {
	$text = substr($content['text'], 15);
	$parser = new HyperDown\Parser;
	$content['text'] = $parser->MakeHtml($text);
	}
	$content['tags'] = content_tags($content['cid']);
	$content['category'] = '';
}

function content_tags($cid) {
	$tagstr = '';
	$tags = db_find("SELECT B.* FROM `qtblog_relationships` as A , `qtblog_metas` as B where A.mid = B.mid and A.cid=$cid");
	if(empty($tags)) return $tagstr;
	foreach($tags as $tag) {
		$tagstr .= '<a href="/tag/' . (empty($tag['slug']) ? $tag['name'] : $tag['slug']) . '/">' . $tag['name'] . '</a>';
	}
	return $tagstr;
}

function content_find_by_tag($tag, $orderby, $page = 1, $pagesize = 20) {
	$orderby = orderby_to_sqladd($orderby);
	$offset = ($page - 1) * $pagesize;
	$contentlist = db_find("SELECT C.* FROM `qtblog_metas` as A , `qtblog_relationships` as B, `qtblog_contents` as C where A.mid = B.mid and C.cid = B.cid and A.slug='$tag' $orderby LIMIT $offset, $pagesize");
	if($contentlist) foreach ($contentlist as &$content) content_format($content);
	return $contentlist;
}

function content_find_by_category($category, $orderby, $page = 1, $pagesize = 20) {
	return content_find_by_tag($category, $orderby, $page, $pagesize);
}
