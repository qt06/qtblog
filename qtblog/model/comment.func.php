<?php

/*
 * Copyright (C) qt.hk
 */


function comment__create($arr) {
	$sqladd = array_to_sqladd($arr);
	return db_exec("INSERT INTO `qtblog_comments` SET $sqladd");
}

function comment__update($coid, $arr) {
	$sqladd = array_to_sqladd($arr);
	return db_exec("UPDATE `qtblog_comments` SET $sqladd WHERE coid='$coid'");
}

function comment__read($coid) {
	return db_find_one("SELECT * FROM `qtblog_comments` WHERE coid='$coid'");
}

function comment__delete($coid) {
	return db_exec("DELETE FROM `qtblog_comments` WHERE coid='$coid'");
}

function comment__find($cond = array(), $orderby = array(), $page = 1, $pagesize = 20) {
	$cond = cond_to_sqladd($cond);
	$orderby = orderby_to_sqladd($orderby);
	$offset = ($page - 1) * $pagesize;
	return db_find("SELECT * FROM `qtblog_comments` $cond$orderby LIMIT $offset,$pagesize");
}

// ------------> 关联 CURD，主要是强相关的数据，比如缓存。弱相关的大量数据需要另外处理。

function comment_create($arr) {
	$r = comment__create($arr);
	return $r;
}

function comment_update($coid, $arr) {
	$r = comment__update($coid, $arr);
	return $r;
}

function comment_replace($arr) {
	$sqladd = array_to_sqladd($arr);
	return db_exec("REPLACE INTO `qtblog_comments` SET $sqladd");
}

function comment_read($coid) {
	$comment = comment__read($coid);
	//comment_format($comment);
	return $comment;
}

function comment_delete($coid) {
	$r = comment__delete($coid);
	return $r;
}

function comment_find($cond = array(), $orderby = array(), $page = 1, $pagesize = 1000) {
	$commentlist = comment__find($cond, $orderby, $page, $pagesize);
	/*if($commentlist) foreach ($commentlist as &$comment) comment_format($comment);*/
	return $commentlist;
}

function comment_count($cond = array()) {
	return db_count('qtblog_comments', $cond);
}

function comment_maxid() {
	return db_maxid('qtblog_comments', 'sid');
}

