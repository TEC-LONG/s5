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
		<ul id="sort1"></ul>
		<ul id="sort2" style="display: none;"></ul>
		<ul id="sort3" style="display: none;"></ul>
	</div>
	<div class="selectedSort"><b>您当前选择的商品类别是：</b><i id="selectedSort"></i></div>

<script type="text/javascript">
function CascadeBeauty(json){

	this.expressLv1 = null;
	this.expressLv2 = null;
	this.expressLv3 = null;

	this.lv1 = json.lv1;
	this.lv2 = [];
	this.lv3 = [];

	this.lv1Ids = json.lv1_ids;
	this.lv2Ids = [];
	this.lv3Ids = [];

	this.lv1Levels = json.lv1_levels;
	this.lv1ChildNums = json.lv1_child_nums;
	this.lv2Levels = [];
	this.lv2ChildNums = [];

	this.getChildUrl = json.url;

	this.sort1Id = '#'+json.sort1;
	this.sort2Id = '#'+json.sort2;
	this.sort3Id = '#'+json.sort3;
	this.crumbSortId = '#'+json.crumb_id;

	this.showLv1Call = json.showLv1Call;//显示一级分类栏目时的回调
	this.showLv2Call = json.showLv2Call;//显示二级分类栏目时的回调
	this.showLv3Call = json.showLv3Call;//显示三级分类栏目时的回调
	this.selectLv3Call = json.selectLv3Call;//选中某个三级分类时的回调

	this.arrow = ' <font>&gt;</font> ';

	this.showLv1 = function () { // show level 1
		
		var areaCont = "";
		for (var i=0; i<this.lv1.length; i++) {
			areaCont += '<li onClick="selectLv1(' + i + ');"><a href="javascript:void(0)">' + this.lv1[i] + '</a></li>';
		}

		$(this.sort1Id).html(areaCont);//第一栏内容
		$(this.sort2Id).hide();
		$(this.sort3Id).hide();
		$(this.crumbSortId).html('无');//面包屑区域填充内容

		if ( typeof(this.showLv1Call)=='function' ) {
			this.showLv1Call(this);
		}else{
			console.log('请先设定回调函数：showLv1Call');
			return;
		}
		
	}

	///选中一级分类项时
	this.selectLv1 = function (lv1_key) {

		if ( typeof(this.lv2[lv1_key])==='undefined' ){

			var that = this;
			{literal}
			$.ajax({
				type:'POST',
				data:{p_id:this.lv1Ids[lv1_key]},
				dataType:'json',
				url:this.getChildUrl,
				async:true,
				success:function (re){

					if ( re.length==0 ){
						that.lv2[lv1_key] = [];
					}else{
						that.lv2[lv1_key] = re['child_names'];
						that.lv2Ids[lv1_key] = re['child_ids'];

						that.lv2Levels[lv1_key] = re['child_levels'];
						that.lv2ChildNums[lv1_key] = re['child_child_nums'];
					}
					//b.ori
					that.showLv2(lv1_key);
					//e.ori
				}
			});
			{/literal}
		}else{
			this.showLv2(lv1_key);
		}
	}

	this.showLv2 = function (lv1_key) {

		var areaCont = "";
		for (var j=0; j<this.lv2[lv1_key].length; j++) {
			areaCont += '<li onClick="selectLv2(' + lv1_key + ',' + j + ');"><a href="javascript:void(0)">' + this.lv2[lv1_key][j] + '</a></li>';
		}

		$(this.sort2Id).html(areaCont).show();
		$(this.sort3Id).hide();
		$(this.sort1Id+" li").eq(lv1_key).addClass("active").siblings("li").removeClass("active");

		this.expressLv1 = this.lv1[lv1_key];
		$(this.crumbSortId).html(this.expressLv1);//将第一栏被选中项填入面包屑区域

		if ( typeof(this.showLv2Call)=='function' ) {
			this.showLv2Call(this, lv1_key);
		}else{
			console.log('请先设定回调函数：showLv2Call');
			return;
		}
	}

	///选中二级分类项时
	this.selectLv2 = function (lv1_key, lv2_key) {

		if ( typeof(this.lv3[lv1_key])==='undefined'||typeof(this.lv3[lv1_key][lv2_key])==='undefined' ){

			var that = this;
			{literal}
			$.ajax({
				type:'POST',
				data:{p_id:this.lv2Ids[lv1_key][lv2_key]},
				dataType:'json',
				url:this.getChildUrl,
				async:true,
				success:function (re){
					if ( re.length==0 ){
						if ( typeof(that.lv3[lv1_key])==='undefined' ){
							that.lv3[lv1_key] = [];
						}
						that.lv3[lv1_key][lv2_key] = [];
					}else{
						if ( typeof(that.lv3[lv1_key])==='undefined' ){
							that.lv3[lv1_key] = [];
						}
						that.lv3[lv1_key][lv2_key] = re['child_names'];
						if ( typeof(that.lv3Ids[lv1_key])==='undefined' ){
							that.lv3Ids[lv1_key] = [];
						}
						that.lv3Ids[lv1_key][lv2_key] = re['child_ids'];
					}
					//b.ori
					that.showLv3(lv1_key,lv2_key);
					//e.ori
				}
			});
			{/literal}
		}else{
			this.showLv3(lv1_key,lv2_key);
		}
	}

	this.showLv3 = function (lv1_key, lv2_key) {

		var areaCont = "";

		for (var k=0; k<this.lv3[lv1_key][lv2_key].length; k++) {
			areaCont += '<li onClick="selectLv3(' + lv1_key + ',' + lv2_key + ',' + k + ');"><a href="javascript:void(0)">' + this.lv3[lv1_key][lv2_key][k] + '</a></li>';
		}
		
		$(this.sort3Id).html(areaCont).show();
		$(this.sort2Id+" li").eq(lv2_key).addClass("active").siblings("li").removeClass("active");

		this.expressLv2 = this.expressLv1 + this.arrow + this.lv2[lv1_key][lv2_key];
		$(this.crumbSortId).html(this.expressLv2);

		if ( typeof(this.showLv3Call)=='function' ) {
			this.showLv3Call(this, lv1_key, lv2_key);
		}else{
			console.log('请先设定回调函数：showLv3Call');
			return;
		}

		if (this.lv3[lv1_key][lv2_key].length==0) {
			return false;
		}
	}

	this.selectLv3 = function (lv1_key, lv2_key, lv3_key) {
		$(this.sort3Id+" li").eq(lv3_key).addClass("active").siblings("li").removeClass("active");

		if ( typeof(this.selectLv3Call)=='function' ) {
			this.selectLv3Call(this, lv1_key, lv2_key, lv3_key);
		}else{
			console.log('请先设定回调函数：selectLv3Call');
			return;
		}
	}
}

/*初始化参数*/
var province = {json_encode($first['p_names'])};//一级分类集合
var province_ids = {json_encode($first['p_ids'])};//一级分类对应的id集合
var province_levels = {json_encode($first['p_levels'])};//一级分类对应的level集合
var province_child_nums = {json_encode($first['p_child_nums'])};//一级分类对应的child_nums集合
var url = init.url.main+'/tools/expcat/getChild';
// var city = [];//二级分类集合
// var city_ids = [];
// var city_levels = [];
// var city_child_nums = [];
// var district = [];//三级分类集合
// var district_ids = [];
// //var district_levels = [];

var cascade_beauty = new CascadeBeauty({
	"lv1": province,
	"lv1_ids": province_ids,
	"lv1_levels": province_levels,
	"lv1_child_nums": province_child_nums,
	"url": url,
	"sort1": "sort1",
	"sort2": "sort2",
	"sort3": "sort3",
	"crumb_id": "selectedSort",
	"showLv1Call": function (obj){

		$("#FIRE_parent_id").val("0");
		$("#FIRE_parent_level").val("0");
		if (typeof(obj.lv1ChildNums)!='undefined') {
			$("#FIRE_parent_child_num").val("0");
		}
		$(".FIRE_this_cat_name").val("");
		$(".FIRE_show_cat_name").html("EXP分类");
	},
	"showLv2Call": function (obj, p){

		$("#FIRE_parent_id").val(obj.lv1Ids[p]);
		$("#FIRE_parent_level").val(obj.lv1Levels[p]);
		if (typeof(obj.lv1ChildNums)!='undefined') {
			$("#FIRE_parent_child_num").val(obj.lv1ChildNums[p]);
		}
		$(".FIRE_this_cat_id").val(obj.lv1Ids[p]);
		$(".FIRE_this_cat_name").val(obj.lv1[p]);
		$(".FIRE_show_cat_name").html(obj.lv1[p]);
	},
	"showLv3Call": function (obj, p, c) {
		
		$("#FIRE_parent_id").val(obj.lv2[p][c]);
		$("#FIRE_parent_level").val(obj.lv2Levels[p][c]);
		if (typeof(obj.lv1ChildNums)!='undefined') {
			$("#FIRE_parent_child_num").val(obj.lv2ChildNums[p][c]);
		}
		$(".FIRE_this_cat_id").val(obj.lv2Ids[p][c]);
		$(".FIRE_this_cat_name").val(obj.lv2[p][c]);
		$(".FIRE_show_cat_name").html(obj.lv2[p][c]);
		if (obj.lv3[p][c].length==0) {
			return false;
		}
	},
	"selectLv3Call": function (obj, p, c, d) {
		$(".FIRE_this_cat_id").val(obj.lv3Ids[p][c][d]);
		$(".FIRE_this_cat_name").val(obj.lv3[p][c][d]);
		$(".FIRE_show_cat_name").html(obj.lv3[p][c][d]);
	}
});

var selectLv3 = function (k1, k2, k3) {
	cascade_beauty.selectLv3(k1, k2, k3);
}
var selectLv2 = function (k1, k2) {
	cascade_beauty.selectLv2(k1, k2);
}
var selectLv1 = function (k1) {
	cascade_beauty.selectLv1(k1);
}
</script>



<div class="pageFormContent" layoutH="60">
<!-- 添加 -->
	<form method="post" action="{$url.adh}"  class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
	<fieldset>
		<legend>添加EXP分类</legend>
		<dl>
			<dt><div class="button"><div class="buttonContent"><button  id="FIRE_resetCatPid">重置父分类到顶级</button></div></div></dt>
			<dd>
				<input type="hidden" id="FIRE_parent_id" name="pid" value="0">
				<input type="hidden" id="FIRE_parent_level" name="plevel" value="0">
				<input type="hidden" id="FIRE_parent_child_num" name="pchild_num" value="0">
			</dd>
		</dl>
		<dl>
			<dt>EXP分类名称：</dt>
			<dd><input class="required" name="name" type="text" /></dd>
		</dl>
		<dl class="nowrap"></dl>
		<dl></dl>
		<dl>
			<dt><div class="buttonActive"><div class="buttonContent"><button type="submit">执行新增EXP分类</button></div></div></dt>
			<dd></dd>
		</dl>
	</fieldset>
	{literal}
<script type="text/javascript">
// $('#FIRE_resetCatPid').click(function (){
// 	intProvince();
// 	return false;
// });
cascade_beauty.showLv1();
$('#FIRE_resetCatPid').click(function (){

	cascade_beauty.showLv1();

	return false;
});
</script>
	{/literal}
	</form>


	<!-- 编辑 -->
	<form method="post" action="{$url.edith}"  class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
		<fieldset>
			<legend>编辑【<strong class="FIRE_show_cat_name">EXP分类</strong>】</legend>
			<dl class="nowrap">
				<dt>新分类名称：</dt>
				<dd>
					<input type="hidden" class="FIRE_this_cat_id" name="id">
					<input type="hidden" class="FIRE_this_cat_name" name="ori_name">
					<input class="required FIRE_this_cat_name" id="FIRE_this_cat_name" name="name" type="text" />
				</dd>
			</dl>
			<dl></dl>
			<dl>
				<dt><div class="buttonActive"><div class="buttonContent"><button type="submit">执行修改EXP分类</button></div></div></dt>
				<dd></dd>
			</dl>
		</fieldset>
	</form>

</div>




<!-- <scr ipt src="{$smarty.const.PUBLIC_TOOLS}/cat/jquery.sort.js"></scr ipt> -->

</div>
        