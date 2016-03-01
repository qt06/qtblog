<?php

/*
 * Copyright (C) qt.hk
 */


function relationship__create($arr) {
	$sqladd = array_to_sqladd($arr);
	return db_exec("INSERT INTO `qtblog_relationships` SET $sqladd");
}

function relationship__update($coid, $arr) {
	$sqladd = array_to_sqladd($arr);
	return db_exec("UPDATE `qtblog_relationships` SET $sqladd WHERE coid='$coid'");
}

function relationship__read($coid) {
	return db_find_one("SELECT * FROM `qtblog_relationships` WHERE coid='$coid'");
}

function relationship__delete($coid) {
	return db_exec("DELETE FROM `qtblog_relationships` WHERE coid='$coid'");
}

function relationship__find($cond = array(), $orderby = array(), $page = 1, $pagesize = 20) {
	$cond = cond_to_sqladd($cond);
	$orderby = orderby_to_sqladd($orderby);
	$offset = ($page - 1) * $pagesize;
	return db_find("SELECT * FROM `qtblog_relationships` $cond$orderby LIMIT $offset,$pagesize");
}

// ------------> 关联 CURD，主要是强相关的数据，比如缓存。弱相关的大量数据需要另外处理。

function relationship_create($arr) {
	$r = relationship__create($arr);
	return $r;
}

function relationship_update($coid, $arr) {
	$r = relationship__update($coid, $arr);
	return $r;
}

function relationship_replace($arr) {
	$sqladd = array_to_sqladd($arr);
	return db_exec("REPLACE INTO `qtblog_relationships` SET $sqladd");
}

function relationship_read($coid) {
	$relationship = relationship__read($coid);
	//relationship_format($relationship);
	return $relationship;
}

function relationship_delete($coid) {
	$r = relationship__delete($coid);
	return $r;
}

function relationship_find($cond = array(), $orderby = array(), $page = 1, $pagesize = 1000) {
	$relationshiplist = relationship__find($cond, $orderby, $page, $pagesize);
	/*if($relationshiplist) foreach ($relationshiplist as &$relationship) relationship_format($relationship);*/
	return $relationshiplist;
}

function relationship_count($cond = array()) {
	return db_count('qtblog_relationships', $cond);
}

function relationship_maxid() {
	return db_maxid('qtblog_relationships', 'sid');
}

