<?php

/*
 * Copyright (C) qt.hk
 */


function meta__create($arr) {
	$sqladd = array_to_sqladd($arr);
	return db_exec("INSERT INTO `qtblog_metas` SET $sqladd");
}

function meta__update($mid, $arr) {
	$sqladd = array_to_sqladd($arr);
	return db_exec("UPDATE `qtblog_metas` SET $sqladd WHERE mid='$mid'");
}

function meta__read($mid) {
	return db_find_one("SELECT * FROM `qtblog_metas` WHERE mid='$mid'");
}

function meta__delete($mid) {
	return db_exec("DELETE FROM `qtblog_metas` WHERE mid='$mid'");
}

function meta__find($cond = array(), $orderby = array(), $page = 1, $pagesize = 20) {
	$cond = cond_to_sqladd($cond);
	$orderby = orderby_to_sqladd($orderby);
	$offset = ($page - 1) * $pagesize;
	return db_find("SELECT * FROM `qtblog_metas` $cond$orderby LIMIT $offset,$pagesize");
}

// ------------> 关联 CURD，主要是强相关的数据，比如缓存。弱相关的大量数据需要另外处理。

function meta_create($arr) {
	$r = meta__create($arr);
	return $r;
}

function meta_update($mid, $arr) {
	$r = meta__update($mid, $arr);
	return $r;
}

function meta_replace($arr) {
	$sqladd = array_to_sqladd($arr);
	return db_exec("REPLACE INTO `qtblog_metas` SET $sqladd");
}

function meta_read($mid) {
	$meta = meta__read($mid);
	//meta_format($meta);
	return $meta;
}

function meta_delete($mid) {
	$r = meta__delete($mid);
	return $r;
}

function meta_find($cond = array(), $orderby = array(), $page = 1, $pagesize = 1000) {
	$metalist = meta__find($cond, $orderby, $page, $pagesize);
	/*if($metalist) foreach ($metalist as &$meta) meta_format($meta);*/
	return $metalist;
}

function meta_count($cond = array()) {
	return db_count('qtblog_metas', $cond);
}

function meta_maxid() {
	return db_maxid('qtblog_metas', 'mid');
}

function meta_get_meta($meta) {
	$metas = meta_find(array('slug' => $meta), array(), 1, 1);
$meta = empty($metas) ? array() : array_pop($metas);
return $meta;
}

function meta_get_category($cate) {
$category = meta_get_meta($cate);
return (!empty($category) && $category['type'] == 'category') ? $category : array();
}

function meta_get_tag($tag) {
$tag = meta_get_meta($tag);
return (!empty($tag) && $tag['type'] == 'tag') ? $tag : array();
}
