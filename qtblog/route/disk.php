<?php 
$so = param(1,'index');
$id = param(2,'');
$address = get_address($so, $id);
!empty($address) AND exit(header("Location: {$address}"));
$conf['title'] = '网盘';
include './qtblog/view/disk.php';
function get_address($so, $id) {
$source = array(
's01' => 'baidu',
's02' => 'yunpan',
's03' => 'tianyi',
's04' => 'vdisk'
);
if(array_key_exists($so, $source)) {
return $source[$so]($id);
}
return '';
}

// pan.baidu
function baidu($id) {
if(empty($id)) return;
$url = 'http://music.163.com/api/song/detail/?id='.$id.'&ids=['.$id.']';
$client = Typecho_Http_Client::get();
$client->setHeader("referer","http://music.163.com/")->setHeader("User-Agent","Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7")->setTimeout(10)->send($url);
$ct = $client->getResponseBody();
$json=json_decode($ct,true);
$audio=$json['songs']['0']['mp3Url'];
return $audio;
}



function vdisk($id) {
if(empty($id)) return;
$curl = new Curl();
$curl->setUserAgent("Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko");
$curl->setReferrer("http://vdisk.weibo.com/s/$id");
$curl->setHeader('X-Requested-With', 'XMLHttpRequest');
$curl->get("http://vdisk.weibo.com/api/weipan/fileopsStatCount?link=$id&ops=download&_=".time()."000");
return $curl->response->url;
/**
$con=file_get_contents('http://vdisk.weibo.com/s/'.$id);
preg_match('/fileDown.init\((.*)\)/',$con,$a);
$json=json_decode($a[1],true);
return $json[url];
*/
}

function tianyi($id) {
if(empty($id)) return;
$con=file_get_contents('http://cloud.189.cn/t/'.$id);
preg_match('#<input type="hidden" class="downloadUrl" value="(.*?)"/>#',$con,$url);
return $url[1];
}




function yunpan($id) {
$curl = new Curl();
$curl->setUserAgent("Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko");
$curl->get("http://yunpan.cn/$id"); //cyy4KNApbbbec

$data = array(
"shorturl"=> $id,
"linkpassword"=> $this->request->pass
);
$furl = $curl->response_headers["Location"];
$baseurl = substr($curl->response_headers["Location"],0,stripos($curl->response_headers["Location"],"yunpan.cn"));
$curl->setReferrer($furl);

$passurl = $baseurl . "yunpan.cn/share/verifyPassword";
$curl->post($passurl,$data);

print_r(json_decode($curl->response,true));


$ck = $curl->response_headers["Set-Cookie"];
$ck = explode(';',$ck);
$ck = explode('=',$ck[0]);
$ckey = $ck[0];
$cvalue = $ck[1];


$curl->setCookie($ckey,$cvalue);
$curl->setReferrer($furl);
$curl->get($furl);


preg_match("#nid : '(.*?)'#",$curl->response,$n);
$nid = $n[1];
$data = array(
"shorturl"=>$id,"nid"=>$nid);
$durl = $baseurl . "yunpan.cn/share/downloadfile/";
$curl->setHeader('X-Requested-With', 'XMLHttpRequest');
$curl->post($durl,$data);

$json = json_decode($curl->response,true);
return $json['data']['downloadurl'];
}
//end class