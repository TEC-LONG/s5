<div class="pageContent">
{literal}
<style>
@charset "utf-8";
/**Style Reset**/
body, div, span, h1, h2, h3, h4, h5, h6, p, pre, sup, sub, ul, ol, li, dl, dt, dd, form, fieldset, input, button, textarea, select, iframe, img, a, header, footer, section, article, aside, details, figcaption, figure, hgroup, nav, menu, canvas { padding: 0; margin: 0; }
body { background-color: #fff; color: #000; font: 12px/20px "Microsoft Yahei", Tahoma, Arial, "Helvetica Neue", "Hiragino Sans GB", Simsun, sans-self; }
ul, ol { list-style-type: none; }
b, strong { font-weight: normal; }
i, em { font-style: normal; }
a { text-decoration: none; color: #333; }
/*清除浮动*/
.clearfix:after { clear: both; display: block; height: 0; content: ""; }
/*主体部分*/
.contains { width: 1000px; margin: 0 auto; }
/*面包屑导航*/
.crumbNav { padding: 18px 0; color: #323232; }
.crumbNav a { color: #ed7f5a; }
.crumbNav a:hover { color: #d95459; }
.crumbNav font { padding: 0 2px; font-family: simsun; }
/**选择商品分类**/
.wareSort { padding: 15px 8px 15px 7px; border: 1px solid #ddd; background-color: #f6f6f6; }
.wareSort ul { float: left; width: 290px; padding: 10px; border: 1px solid #ddd; margin-right: 7px; margin-left: 8px; background-color: #fff; }
.wareSort ul li a { display: block; padding-right: 25px; padding-left: 10px; border: 1px solid #fff; line-height: 28px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
.wareSort ul li a:hover { color: #52bea6; }
.wareSort ul li.active a { border-color: #52bea6; background: #cefff4 url(../img/arrow.png) no-repeat right center; color: #52bea6; }
.selectedSort { padding: 10px 15px; border: 1px solid #ed7f5a; margin-top: 10px; margin-bottom: 10px; background-color: #fff4f0; color: #ed7f5a; }
.selectedSort b { font-weight: bold; }
.selectedSort i font { font-family: simsun; }
.wareSortBtn { padding-bottom: 50px; text-align: center; }
.wareSortBtn input { width: 200px; height: 36px; border: 1px solid #ed7f5a; -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px; background-color: #ed7f5a; color: #fff; }
.wareSortBtn input:hover { border-color: #d95459; background-color: #d95459; }
.wareSortBtn input:disabled { border-color: #ddd; background-color: #f6f6f6; color: #9a9a9a; cursor: default; }
</style>
{/literal}


	<div class="wareSort clearfix">
		<ul id="{$navTab}sort1"></ul>
		<ul id="{$navTab}sort2" style="display: none;"></ul>
		<ul id="{$navTab}sort3" style="display: none;"></ul>
	</div>
	<div class="selectedSort"><b>您当前选择的菜单栏目是：</b><i id="{$navTab}selectedSort"></i></div>

<script type="text/javascript">
/*初始化参数*/
var navtab = '{$navTab}';
var get_child_url = '/tools/menu/getChild';
var province = {json_encode($first['p_names'])};//一级分类集合
var province_ids = {json_encode($first['p_ids'])};//一级分类对应的id集合
var province_levels = {json_encode($first['p_levels'])};//一级分类对应的level集合
var city = [];//二级分类集合
var city_ids = [];
var city_levels = [];
// var city_child_nums = [];
var district = [];//三级分类集合
var district_ids = [];
//var district_levels = [];
/*  2020-03-27
var plat = [];
var mod = [];
var act = [];
var url_navtab = [];
var level3_type = [];
var level3_href = [];
var route = [];
*/
var lookup = 0;
{if isset($search.lookup)&&$search.lookup==1}
lookup = 1;
{/if}
/*  2020-03-27
var routeFunc = function (className) {
		var this_plat = $('.'+className).find('input[name="plat"]').val();
		var this_mod = $('.'+className).find('input[name="module"]').val();
		var this_act = $('.'+className).find('input[name="act"]').val();

		if (this_plat!='') {
			this_plat = '/' + this_plat;
		}
		if (this_mod!='') {
			this_mod = '/' + this_mod;
		}
		if (this_act!='') {
			this_act = '/' + this_act;
		}
		
		return this_plat+this_mod+this_act;
};
*/
</script>



<div class="pageFormContent" layoutH="60">
<!-- 添加 -->
	<form method="post" action="{$url.adh}"  class="pageForm required-validate menu_ad" onsubmit="return validateCallback(this, navTabAjaxDone);">
	<fieldset>
		<legend>添加菜单栏目</legend>
		<dl>
			<dt><div class="button"><div class="buttonContent"><button  id="{$navTab}FIRE_resetCatPid">重置菜单栏目到顶级</button></div></div></dt>
			<dd>
				<input type="hidden" id="{$navTab}FIRE_parent_id" name="pid" value="0">
				<input type="hidden" id="{$navTab}FIRE_parent_level" name="plevel" value="0">
			</dd>
		</dl>
		<dl>
			<dt>菜单栏目名称：</dt>
			<dd><input class="required" name="name" type="text" /></dd>
		</dl>
		<dl class="nowrap"></dl>
		{* 2020-03-27<!-- <dl>
			<dt>PLAT参数：</dt>
			<dd><input name="plat" type="text" /></dd>
		</dl>
		<dl>
			<dt>MODULE参数：</dt>
			<dd><input name="module" type="text" /></dd>
		</dl>
		<dl>
			<dt>ACT参数：</dt>
			<dd><input name="act" type="text" /></dd>
		</dl>
		<dl>
			<dt>主navtab：</dt>
			<dd><input name="navtab" type="text" /></dd>
		</dl>
		<dl>
			<dt>3级菜单跳转类型：</dt>
			<dd>{T_createSelectHtml($level3_type, 'level3_type', 2)}</dd>
		</dl>
		<dl>
			<dt>外部跳转链接：</dt>
			<dd><input name="level3_href" type="text" /></dd>
		</dl>
		<dl>
			<dt>路由：</dt>
			<dd><input name="route" type="text" /></dd>
		</dl>
		<dl class="nowrap"></dl> -->*}
		<dl></dl>
		<dl>
			<dt><div class="buttonActive"><div class="buttonContent"><button type="submit">执行新增</button></div></div></dt>
			<dd></dd>
		</dl>
	</fieldset>
	{literal}
<script type="text/javascript">
$('#'+navtab+'FIRE_resetCatPid').click(function (){
	tools_menu_intProvince();
	return false;
});
/*  2020-03-27
$('.menu_ad').find('input[name="plat"]').bind('keyup', function () {
	
	var this_navtab = $(this).val()+'_'+$('.menu_ad').find('input[name="module"]').val()+'_'+$('.menu_ad').find('input[name="act"]').val();
	$('.menu_ad').find('input[name="navtab"]').val(this_navtab);
	var this_route = routeFunc('menu_ad');
	$('.menu_ad').find('input[name="route"]').val(this_route);
});
$('.menu_ad').find('input[name="module"]').bind('keyup', function () {

	var this_navtab = $('.menu_ad').find('input[name="plat"]').val()+'_'+$(this).val()+'_'+$('.menu_ad').find('input[name="act"]').val();
	$('.menu_ad').find('input[name="navtab"]').val(this_navtab);
	var this_route = routeFunc('menu_ad');
	$('.menu_ad').find('input[name="route"]').val(this_route);
});
$('.menu_ad').find('input[name="act"]').bind('keyup', function () {
	
	var this_navtab = $('.menu_ad').find('input[name="plat"]').val()+'_'+$('.menu_ad').find('input[name="module"]').val()+'_'+$(this).val();
	$('.menu_ad').find('input[name="navtab"]').val(this_navtab);
	var this_route = routeFunc('menu_ad');
	$('.menu_ad').find('input[name="route"]').val(this_route);
});
*/
</script>
	{/literal}
	</form>


	<!-- 编辑 -->
	<form method="post" action="{$url.updh}"  class="pageForm required-validate menu_upd" onsubmit="return validateCallback(this, navTabAjaxDone);">
		<fieldset>
			<legend>编辑【<strong class="{$navTab}FIRE_show_cat_name">菜单栏目</strong>】</legend>
			<dl class="nowrap">
				<dt>新菜单栏目名称：</dt>
				<dd>
					<input type="hidden" class="{$navTab}FIRE_this_cat_id" name="id">
					<input type="hidden" class="{$navTab}FIRE_this_cat_name" name="ori_name">
					<input class="required {$navTab}FIRE_this_cat_name" id="{$navTab}FIRE_this_cat_name" name="name" type="text" />
					{if isset($search.lookup)&&$search.lookup==1}
					&nbsp;&nbsp;<a href="javascript:" id="lookup-a">所选菜单：<span id="lookup-span">无</span></a>
					{/if}
				</dd>
			</dl>
			<dl class="nowrap"></dl>
			{*  2020-03-27<!-- <dl>
				<dt>PLAT参数：</dt>
				<dd><input name="plat" type="text" /><input name="ori_plat" type="hidden" /></dd>
			</dl>
			<dl>
				<dt>MODULE参数：</dt>
				<dd><input name="module" type="text" /><input name="ori_module" type="hidden" /></dd>
			</dl>
			<dl>
				<dt>ACT参数：</dt>
				<dd><input name="act" type="text" /><input name="ori_act" type="hidden" /></dd>
			</dl>
			<dl>
				<dt>主navtab：</dt>
				<dd><input name="navtab" type="text" /><input name="ori_navtab" type="hidden" /></dd>
			</dl>
			<dl>
				<dt>3级菜单跳转类型：</dt>
				<dd>{T_createSelectHtml($level3_type, 'level3_type', 2)}<input name="ori_level3_type" type="hidden" /></dd>
			</dl>
			<dl>
				<dt>外部跳转链接：</dt>
				<dd><input name="level3_href" type="text" /><input name="ori_level3_href" type="hidden" /></dd>
			</dl>
			<dl>
				<dt>路由：</dt>
				<dd><input name="route" type="text" /><input name="ori_route" type="hidden" /></dd>
			</dl> -->*}
			<dl></dl>
			<dl>
				<dt><div class="buttonActive"><div class="buttonContent"><button type="submit">执行修改</button></div></div></dt>
				<dd></dd>
			</dl>
		</fieldset>
	</form>

</div>
{literal}
<script>
/*  2020-03-27
$('.menu_upd').find('input[name="plat"]').bind('keyup', function () {
	
	var this_navtab = $(this).val()+'_'+$('.menu_upd').find('input[name="module"]').val()+'_'+$('.menu_upd').find('input[name="act"]').val();
	$('.menu_upd').find('input[name="navtab"]').val(this_navtab);
	var this_route = routeFunc('menu_upd');
	$('.menu_upd').find('input[name="route"]').val(this_route);
});
$('.menu_upd').find('input[name="module"]').bind('keyup', function () {
	
	var this_navtab = $('.menu_upd').find('input[name="plat"]').val()+'_'+$(this).val()+'_'+$('.menu_upd').find('input[name="act"]').val();
	$('.menu_upd').find('input[name="navtab"]').val(this_navtab);
	var this_route = routeFunc('menu_upd');
	$('.menu_upd').find('input[name="route"]').val(this_route);

});
$('.menu_upd').find('input[name="act"]').bind('keyup', function () {
	
	var this_navtab = $('.menu_upd').find('input[name="plat"]').val()+'_'+$('.menu_upd').find('input[name="module"]').val()+'_'+$(this).val();
	$('.menu_upd').find('input[name="navtab"]').val(this_navtab);
	var this_route = routeFunc('menu_upd');
	$('.menu_upd').find('input[name="route"]').val(this_route);
});
*/
var expressP, expressC, expressD, expressArea, areaCont;
var arrow = " <font>&gt;</font> ";

/*初始化一级目录*/
function tools_menu_intProvince() {
	if (province==null) {
		return false;
	}
	areaCont = "";
	for (var i=0; i<province.length; i++) {
		areaCont += '<li onClick="tools_menu_selectP(' + i + ');"><a href="javascript:void(0)">' + province[i] + '</a></li>';
	}
	$("#"+navtab+"sort1").html(areaCont);
	$("#"+navtab+"sort2").hide();
	$("#"+navtab+"sort3").hide();
	$("#"+navtab+"selectedSort").html('无');
	$("#"+navtab+"FIRE_parent_id").val("0");
	$("#"+navtab+"FIRE_parent_level").val("0");
	if (typeof(province_child_nums)!='undefined') {
		$("#"+navtab+"FIRE_parent_child_num").val("0");
	}
	$("."+navtab+"FIRE_this_cat_name").val("");
	$("."+navtab+"FIRE_show_cat_name").html("菜单栏目");
}
tools_menu_intProvince();
$("#lookup-a").bind('click', function () {
	$.bringBack({_id:0,name:'无'});
});

/*选择一级目录*/
function tools_menu_showC(p){//显示二级分类

	areaCont = "";
	for (var j=0; j<city[p].length; j++) {
		areaCont += '<li onClick="tools_menu_selectC(' + p + ',' + j + ');"><a href="javascript:void(0)">' + city[p][j] + '</a></li>';
	}
	$("#"+navtab+"sort2").html(areaCont).show();
	$("#"+navtab+"sort3").hide();
	$("#"+navtab+"sort1 li").eq(p).addClass("active").siblings("li").removeClass("active");
	expressP = province[p];
	$("#"+navtab+"selectedSort").html(expressP);
	$("#"+navtab+"releaseBtn").removeAttr("disabled");
	$("#"+navtab+"FIRE_parent_id").val(province_ids[p]);
	$("#"+navtab+"FIRE_parent_level").val(province_levels[p]);
	if (typeof(province_child_nums)!='undefined') {
		$("#"+navtab+"FIRE_parent_child_num").val(province_child_nums[p]);
	}
	$("."+navtab+"FIRE_this_cat_id").val(province_ids[p]);
	$("."+navtab+"FIRE_this_cat_name").val(province[p]);
	if (lookup==1) {
		$("#lookup-a").unbind('click');
		$('#lookup-span').html(province[p]);
		$("#lookup-a").bind('click', function () {
			$.bringBack({_id:province_ids[p],name:province[p]});
		});
	}
	$("."+navtab+"FIRE_show_cat_name").html(province[p]);
	/*  2020-03-27
	$('.menu_upd').find('input[name="plat"]').val('');
	$('.menu_upd').find('input[name="ori_plat"]').val('');
	$('.menu_upd').find('input[name="module"]').val('');
	$('.menu_upd').find('input[name="ori_module"]').val('');
	$('.menu_upd').find('input[name="act"]').val('');
	$('.menu_upd').find('input[name="ori_act"]').val('');
	$('.menu_upd').find('input[name="navtab"]').val('');
	$('.menu_upd').find('input[name="ori_navtab"]').val('');
	*/
}
function tools_menu_selectP(p) {
	//b.wxg.2018/6/18.ad.取得当前一级分类所属的二级分类
	if ( typeof(city[p])==='undefined' ){
		$.ajax({
			type:'POST',
			data:{p_id:province_ids[p]},
			dataType:'json',
			url:init.url.main+get_child_url,
			async:true,
			success:function (re){
				if ( re.length==0 ){
					city[p] = [];
				}else{
					city[p] = re['child_names'];
					city_ids[p] = re['child_ids'];
					city_levels[p] = re['child_levels'];
				}
				//b.ori
				tools_menu_showC(p);
				//e.ori
			}
		});
	}else{
		tools_menu_showC(p);
	}
	//e.wxg.2018/6/18
}

/*选择二级目录*/
function tools_menu_showD(p,c){//显示三级分类

	areaCont = "";
	expressC = "";

	for (var k=0; k<district[p][c].length; k++) {
		areaCont += '<li onClick="tools_menu_selectD(' + p + ',' + c + ',' + k + ');"><a href="javascript:void(0)">' + district[p][c][k] + '</a></li>';
	}
	
	$("#"+navtab+"sort3").html(areaCont).show();
	$("#"+navtab+"sort2 li").eq(c).addClass("active").siblings("li").removeClass("active");
	expressC = expressP + arrow + city[p][c];
	$("#"+navtab+"selectedSort").html(expressC);
	$("#"+navtab+"FIRE_parent_id").val(city_ids[p][c]);
	$("#"+navtab+"FIRE_parent_level").val(city_levels[p][c]);
	// if (typeof(province_child_nums)!='undefined') {
	// 	$("#"+navtab+"FIRE_parent_child_num").val(city_child_nums[p][c]);
	// }
	$("."+navtab+"FIRE_this_cat_id").val(city_ids[p][c]);
	$("."+navtab+"FIRE_this_cat_name").val(city[p][c]);
	if (lookup==1) {
		$("#lookup-a").unbind('click');
		$('#lookup-span').html(city[p][c]);
		$("#lookup-a").bind('click', function () {
			$("#lookup-a").onclick = $.bringBack({_id:city_ids[p][c],name:city[p][c]});
		});
	}
	$("."+navtab+"FIRE_show_cat_name").html(city[p][c]);
	/*  2020-03-27
	$('.menu_upd').find('input[name="plat"]').val('');
	$('.menu_upd').find('input[name="ori_plat"]').val('');
	$('.menu_upd').find('input[name="module"]').val('');
	$('.menu_upd').find('input[name="ori_module"]').val('');
	$('.menu_upd').find('input[name="act"]').val('');
	$('.menu_upd').find('input[name="ori_act"]').val('');
	$('.menu_upd').find('input[name="navtab"]').val('');
	$('.menu_upd').find('input[name="ori_navtab"]').val('');
	*/
	if (district[p][c].length==0) {
		return false;
	}
}
function tools_menu_selectC(p,c) {
	//b.wxg.2018/6/18.ad.取得当前二级分类所属的三级分类
	if ( typeof(district[p])==='undefined'||typeof(district[p][c])==='undefined' ){
		$.ajax({
			type:'POST',
			data:{p_id:city_ids[p][c]},
			dataType:'json',
			url:init.url.main+get_child_url,
			async:true,
			success:function (re){
				if ( re.length==0 ){
					if ( typeof(district[p])==='undefined' ){
						district[p] = [];
					}
					district[p][c] = [];
				}else{
					if ( typeof(district[p])==='undefined' ){
						district[p] = [];
					}
					district[p][c] = re['child_names'];
					if ( typeof(district_ids[p])==='undefined' ){
						district_ids[p] = [];
					}
					district_ids[p][c] = re['child_ids'];
					/*  2020-03-27
					if ( typeof(plat[p])==='undefined' ){
						plat[p] = [];
					}
					plat[p][c] = re['plat'];
					if ( typeof(mod[p])==='undefined' ){
						mod[p] = [];
					}
					mod[p][c] = re['module'];
					if ( typeof(act[p])==='undefined' ){
						act[p] = [];
					}
					act[p][c] = re['act'];
					if ( typeof(url_navtab[p])==='undefined' ){
						url_navtab[p] = [];
					}
					url_navtab[p][c] = re['navtab'];
					if ( typeof(level3_type[p])==='undefined' ){
						level3_type[p] = [];
					}
					level3_type[p][c] = re['level3_type'];
					if ( typeof(level3_href[p])==='undefined' ){
						level3_href[p] = [];
					}
					level3_href[p][c] = re['level3_href'];
					if ( typeof(route[p])==='undefined' ){
						route[p] = [];
					}
					route[p][c] = re['route'];
					*/
				}
				//b.ori
				tools_menu_showD(p,c);
				//e.ori
			}
		});
	}else{
		tools_menu_showD(p,c);
	}
	//e.wxg.2018/6/18
}

/*选择三级目录*/
function tools_menu_selectD(p,c,d) {
	$("#"+navtab+"sort3 li").eq(d).addClass("active").siblings("li").removeClass("active");
	$("."+navtab+"FIRE_this_cat_id").val(district_ids[p][c][d]);
	$("."+navtab+"FIRE_this_cat_name").val(district[p][c][d]);
	if (lookup==1) {
		$("#lookup-a").unbind('click');
		$('#lookup-span').html(district[p][c][d]);
		$("#lookup-a").bind('click', function () {
			$.bringBack({_id:district_ids[p][c][d],name:district[p][c][d]});
		});
	}
	$("."+navtab+"FIRE_show_cat_name").html(district[p][c][d]);
	/*  2020-03-27
	$('.menu_upd').find('input[name="plat"]').val(plat[p][c][d]);
	$('.menu_upd').find('input[name="ori_plat"]').val(plat[p][c][d]);
	$('.menu_upd').find('input[name="module"]').val(mod[p][c][d]);
	$('.menu_upd').find('input[name="ori_module"]').val(mod[p][c][d]);
	$('.menu_upd').find('input[name="act"]').val(act[p][c][d]);
	$('.menu_upd').find('input[name="ori_act"]').val(act[p][c][d]);
	$('.menu_upd').find('input[name="navtab"]').val(url_navtab[p][c][d]);
	$('.menu_upd').find('input[name="ori_navtab"]').val(url_navtab[p][c][d]);
	$('.menu_upd').find('select[name="level3_type"]').find('option').attr("selected", false);
	// console.log($('.menu_upd').find('select[name="level3_type"]').html());
	$('.menu_upd').find('select[name="level3_type"]').find("option").each(function(){
		if($(this).val()==level3_type[p][c][d]){
			$(this).attr('selected', true);
			$(this).parent().siblings('a').attr('value', level3_type[p][c][d]);
			$(this).parent().siblings('a').text($(this).text());
		}
	});
	// console.log($('.menu_upd').find('select[name="level3_type"]').html());
	//$('.menu_upd').find('input[name="ori_level3_type"]').val(level3_type[p][c][d]);
	$('.menu_upd').find('input[name="level3_href"]').val(level3_href[p][c][d]);
	$('.menu_upd').find('input[name="ori_level3_href"]').val(level3_href[p][c][d]);
	$('.menu_upd').find('input[name="route"]').val(route[p][c][d]);
	$('.menu_upd').find('input[name="ori_route"]').val(route[p][c][d]);
	*/
}
</script>
{/literal}
</div>
        