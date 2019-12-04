<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>后台登录</title>
<meta name="author" content="DeathGhost" />
<link rel="stylesheet" type="text/css" href="{$smarty.const.URL}/public/admin/Login/css/style.css" tppabs="{$smarty.const.URL}/public/admin/Login/css/style.css" />
{literal}
<style>
body{height:100%;background:#16a085;overflow:hidden;}
canvas{z-index:-1;position:absolute;}
img{padding:3px;background-color:#fff;width:85px;height:40px;z-index:0;position:absolute;}
</style>
{/literal}
<script src="{$smarty.const.URL}/public/admin/Login/js/jquery1.11.3.js"></script>
<script src="{$smarty.const.URL}/public/admin/Login/js/verificationNumbers.js" tppabs="{$smarty.const.URL}/public/admin/Login/js/verificationNumbers.js"></script>
<script src="{$smarty.const.URL}/public/admin/Login/js/Particleground.js" tppabs="{$smarty.const.URL}/public/admin/Login/js/Particleground.js"></script>
<script>
$(document).ready(function() {
  //粒子背景特效
  $('body').particleground({
    dotColor: '#5cbdaa',
    lineColor: '#5cbdaa'
  });
});
</script>
</head>
<body>
<form method="POST" name="login" action="{$smarty.const.URL}/index.php?p=admin&m=login&a=checklogin" />
	
<dl class="admin_login">
 <dt>
  <strong>FIRES后台管理系统</strong>
  <em>FIRES. SYSTEM</em>
 </dt>
 <dd class="user_icon">
  <input name="acc" type="text" placeholder="账号" class="login_txtbx"/>
 </dd>
 <dd class="pwd_icon">
  <input name="pwd" type="password" placeholder="密码" class="login_txtbx"/>
 </dd>
 <dd class="val_icon">
  <div class="checkcode">
    <input name="checkcode" type="text" id="J_codetext" placeholder="验证码" maxlength="4" class="login_txtbx">
	<img class="checkCodeImg" src="{$smarty.const.URL}/index.php?p=admin&m=login&a=showCheckcodeImg" />
    <!-- <canvas class="J_codeimg" id="myCanvas" onclick="createCode()">对不起，您的浏览器不支持canvas，请下载最新版浏览器!</canvas> -->
  </div>
  <input type="button" value="CHANGE" class="ver_btn changeCheckCodeImg">
 </dd>
 <dd>
  <input type="submit" value="立即登陆" class="submit_btn"/>
 </dd>
 <dd>
  <p>© 2018-2019 fires 版权所有</p>
  <!-- <p></p> -->
 </dd>
</dl>

</form>
<script type="text/javascript">
var changeCheckCodeImgClick = function (){
	var url = '{$smarty.const.URL}/index.php?p=admin&m=login&a=showCheckcodeImg&rd='+Math.random();
	$('.checkCodeImg').attr('src', url);
}
$(function(){
	$('.changeCheckCodeImg').bind('click', changeCheckCodeImgClick);
})
</script>
</body>
</html>
