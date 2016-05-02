<?php
!defined('DEBUG') AND exit('Access Denied.');
$action = param(1);
$user = user_read($uid);
empty($user) AND $user = user_guest();
if($action == 'login') {
	if($method == 'GET') {
		$conf['title'] = '登录到' . $conf['appname'];
		include './qtblog/view/user_login.php';

	} else if($method == 'POST') {

		$account = param('account');			// 邮箱或者手机号
		$password = param('password');
		empty($account) AND message(1, '账号为空');
		if(is_email($account, $err)) {
			$user = user_read_by_email($account);
			empty($user) AND message(1, 'Email 不存在');
		} else {
			$user = user_read_by_username($account);
			empty($user) AND message(1, '用户名不存在');
		}

		md5(md5($password).$user['salt']) != $user['password'] AND message(2, '密码错误');

		// 更新登录时间和次数
		user_update($user['uid'], array('login_ip'=>$longip, 'login_date' =>$time , 'logins+'=>1));

		$uid = $user['uid'];
		$gid = $user['gid'];
		
		$user['token'] = user_token_set($uid, $gid, $user['password'], $user['avatar'], $user['username'], '', 86400 * 30);

		unset($user['password']);
		unset($user['password_sms']);
		unset($user['salt']);
		

		message(0, 'successed');

	}
} elseif($action == 'create') {
	
	if($method == 'GET') {
		
		
		$conf['title'] = '发布新文章 - ' . $conf['appname'];
		include './qtblog/view/post_create.php';
		
	} else {
		$title = param('title', '', false);
		$tags = param('tags', '', false);
		$text = param('text', '', FALSE);
		!trim(str_replace(array('　', '&nbsp;', '<br>', '<br/>', '<br />'), '', $text)) AND message(2, '内容不能为空');
		$post = array(
			'title' => $title,
			'created'=>$time,
			'modified'=>$time,
			'authorId'=>$uid,
			'type'=>'post',
			'text'=>$text,
		);
		$cid = content_create($post);
		empty($cid) AND message(1, 'post failed.');
		

//处理tags
		$tags = trim($tags);
		$tags = str_replace('　', ' ', $tags);
		$tags = array_filter(explode(' ', $tags));
		foreach($tags as $tag) {
			$mid = 0;
			$meta = meta_get_meta_by_name($tag);
			if(empty($meta)) {
				$mid = meta_create(array('name'=>$tag, 'slug'=>$tag, 'count'=>1));
			} else {
				meta_update($meta['mid'], array('count+'=>1));
				$mid = $meta['mid'];
			}
			if(!empty($mid)) {
				relationship_create(array('cid'=>$cid, 'mid'=>$mid));
			}

		}

		message(0, 'successed', $conf['appurl'].'post/'.$cid.'/');
	
	}
	
} elseif($action == 'edit') {

	$cid = param(2);
	$post = content_read($cid);
	empty($post) AND message(-1, 'no exists'.$cid);
	
	if($method == 'GET') {
		
		
		$rsps = relationship_find(array('cid'=>$cid), array(), 1, 100);
		$rsps = empty($rsps) ? array() : $rsps;
		$tags = '';
		foreach($rsps as $rsp) {
			$meta = meta_read($rsp['mid']);
			if(!empty($meta)) $tags .= ' ' . $meta['name'];
		}
		$conf['title'] = '编辑：' . $post['title'] . '- ' . $conf['appname'];
		include './qtblog/view/post_edit.php';
		
	} elseif($method == 'POST') {
		
		$title = htmlspecialchars(param('title', '', FALSE));
		$tags = param('tags', '', FALSE);
		$text = param('text', '', FALSE);


		$r = content_update($cid, array('title'=>$title, 'modified'=>time(),'text'=>$text));
		$r === FALSE AND message(-1, 'edit failed.');
		
//处理tags
		$tags = trim($tags);
		$tags = str_replace('　', ' ', $tags);
		$tags = array_filter(explode(' ', $tags));
		$rsps = relationship_find(array('cid'=>$cid), array(), 1, 100);
		$rsps = empty($rsps) ? array() : $rsps;
		for($i = 0; $i < count($rsps); $i++) {
			$meta = meta_read($rsps[$i]['mid']);
			if(!empty($meta)) {
				for($j = 0; $j < count($tags); $j++) {
					if(!empty($tags[$j]) && $tags[$j] == $meta['name']) {
unset($tags[$j]);
unset($rsps[$i]);
break;
					}
				}
			}
		}
print_r($tags);
		foreach($tags as $tag) {
			$mid = 0;
			$meta = meta_get_meta_by_name($tag);
print_r($meta);
			if(empty($meta)) {
				$mid = meta_create(array('name'=>$tag, 'slug'=>$tag, 'type'=>'tag'));
			} else {
				$mid = $meta['mid'];
			}
			if(!empty($mid)) {
				$temp = relationship_read($cid, $mid);
				if(empty($temp)) {
					relationship_create(array('cid'=>$cid, 'mid'=>$mid));
					meta_update($mid, array('count+'=>1));
				}
			}
		}
		foreach($rsps as $rsp) {
			meta_update($rsp['mid'], array('count-'=>1));
			relationship_delete($rsp['cid'], $rsp['mid']);
		}
		message(0, array('cid'=>$cid, 'title'=>$title, 'text'=>$text));
	}
	
} elseif($action == 'delete') {

	$cid = param(2, 0);
	
	if($method != 'POST') message(-1, '方法不对');
	
	$post = content_read($cid);
	empty($post) AND message(-1, '帖子不存在:'.$pid);
	
		content_delete($cid);
	
	message(0, '删除成功');
	
//end of delete
}