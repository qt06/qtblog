<? include 'header.php'; ?>
<div class="container">
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="diskurl">网盘地址</label>
                            <input type="text" class="form-control" placeholder="请输入要转换的网盘分享地址" id="diskurl" name="diskurl" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-default" id="convert">开始转换</button>
                        </div>
                    </div>
                    <div id="result" style="display: none" class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="newurl">转换结果</label>
                            <input type="text" class="form-control" placeholder="" id="newurl" name="newurl" required />
                        </div>
                    </div>
</div>



<div class="sr-only">
<object tabindex="-1" id="wmp" width="0" height="0" classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6">   
    <param name="URL" value="" />   
    <param name="rate" value="1" />   
    <param name="balance" value="0" />   
    <param name="currentPosition" value="0" />   
    <param name="defaultFrame" />   
    <param name="playCount" value="1" />   
    <param name="autoStart" value="true" />   
    <param name="currentMarker" value="0" />   
    <param name="invokeURLs" value="-1" />   
    <param name="baseURL" />   
    <param name="volume" value="50" />   
    <param name="mute" value="0" />   
    <param name="uiMode" value="full" />   
    <param name="stretchToFit" value="0" />   
    <param name="windowlessVideo" value="0" />   
    <param name="enabled" value="-1" />   
    <param name="enableContextMenu" value="-1" />   
    <param name="fullScreen" value="0" />   
    <param name="SAMIStyle" />   
    <param name="SAMILang" />   
    <param name="SAMIFilename" />   
    <param name="captioningID" />   
    <param name="enableErrorDialogs" value="0" />   
    <param name="_cx" value="6482" />   
    <param name="_cy" value="6350" />   
</object>
</div>
<? include 'footer.php'; ?>
<script src="<?=$conf['appurl']?>qtblog/view/js/jquery.hotkeys.js"></script>
<script>
var wmp = $("#wmp").get(0);
$(document).on("keydown.space",function() {play();});
$(document).on("keydown.ctrl_right",function() {wmp.controls.currentPosition += 5;});
$(document).on("keydown.ctrl_left",function() {wmp.controls.currentPosition-= 5;});
$(document).on("keydown.ctrl_up",function() {wmp.settings.volume += 5;});
$(document).on("keydown.ctrl_down",function() {wmp.settings.volume -= 5;});
$(document).on("keydown.esc",function() {window.close();});
function play() {
if(wmp.playState == 3) {
wmp.controls.pause();
} else {
wmp.controls.play();
}
}

$("#convert").on("click",function() {
var url = $("#diskurl").val();
var domain = [
{"k":"s02","v":"yunpan.cn/"},
{"k":"s03","v":"cloud.189.cn/t/"},
{"k":"s04","v":"vdisk.weibo.com/s/"},
];
var newurl = "";

for(var i=0;i<domain.length;i++) {
if(url.indexOf(domain[i].v) > 0) {
var pre = "http://" + domain[i].v;
var t = url.substring(pre.length);
newurl += "http://lab.qt.hk/disk/" + domain[i].k + "/" + t;
newurl = newurl.indexOf("提取码") != -1 ? newurl.replace(/ （提取码：/,"?pass=").replace(/）/,"").replace(/  提取码 /,"?pass=") : newurl;
break;
}
}
if(newurl == "") {
alert("错误");
} else {
$("#result").css("display","block");
$("#newurl").val(newurl).focus();}
});
$("#diskurl").on("keyup",function(e) {
if(e.which == 13) {
$("#convert").trigger("click");
}
});
</script>
