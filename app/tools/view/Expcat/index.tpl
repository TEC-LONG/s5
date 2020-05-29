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

	this.getChildUrl = json.url;

	this.sort1Id = '#'+json.sort1;
	this.sort2Id = '#'+json.sort2;
	this.sort3Id = '#'+json.sort3;
	this.crumbSortId = '#'+json.crumb_id;

	this.showLv1Call = json.showLv1Call;//显示一级分类栏目时的回调
	this.selectLv1Call = json.selectLv1Call;//选中某个一级分类时的回调
	this.showLv2Call = json.showLv2Call;//显示二级分类栏目时的回调
	this.selectLv2Call = json.selectLv2Call;//选中某个二级分类时的回调
	this.showLv3Call = json.showLv3Call;//显示三级分类栏目时的回调
	this.selectLv3Call = json.selectLv3Call;//选中某个三级分类时的回调

	this.one = json.one;
	this.two = [];
	this.three = [];

{literal}
	/*
	
one = [
	{"id":10, "name":"吃饭做菜"},
	{"id":10, "name":"日常总结"},
	{"id":10, "name":"寄情山水"},
	{"id":10, "name":"金融"},
	{"id":10, "name":"编程"},
	{"id":10, "name":"美术"},
	{"id":10, "name":"上学"},
	{"id":10, "name":"综合学习"}
];
two = [
	[
		{"id":10, "name":"吃饭做菜"},
		{"id":10, "name":"日常总结"},
		{"id":10, "name":"寄情山水"}
	],[
		{"id":10, "name":"美术"},
		{"id":10, "name":"上学"},
		{"id":10, "name":"综合学习"}
	],[
		{"id":10, "name":"美术"},
		{"id":10, "name":"上学"},
		{"id":10, "name":"综合学习"}
	]
];
three = [
	[
		[
			{"id":10, "name":"吃饭做菜"},
			{"id":10, "name":"日常总结"}
		],[
			{"id":10, "name":"金融"},
			{"id":10, "name":"编程"}
		]
	],[
		[
			{"id":10, "name":"吃饭做菜"},
			{"id":10, "name":"日常总结"},
			{"id":10, "name":"寄情山水"}
		],[
			{"id":10, "name":"编程"},
			{"id":10, "name":"美术"}
		],[
			{"id":10, "name":"上学"},
			{"id":10, "name":"综合学习"}
		]
	],[
		[
			{"id":10, "name":"吃饭做菜"},
			{"id":10, "name":"日常总结"},
			{"id":10, "name":"寄情山水"}
		],[
			{"id":10, "name":"编程"},
			{"id":10, "name":"美术"}
		],[
			{"id":10, "name":"上学"},
			{"id":10, "name":"综合学习"}
		],[
			{"id":10, "name":"上学"},
			{"id":10, "name":"综合学习"}
		]
	]
];

	*/
	{/literal}

	this.arrow = ' <font>&gt;</font> ';

	this.showLv1 = function () { // show level 1
		
		var one_area = "";
		for (var one_k=0; one_k<this.one.length; one_k++) {
			
			var one_val = this.one[one_k];
			one_area += '<li onClick="selectLv1(' + one_k + ');"><a href="javascript:void(0)">' + one_val.name + '</a></li>';
		}

		$(this.sort1Id).html(one_area);//第一栏内容
		$(this.sort2Id).hide();
		$(this.sort3Id).hide();
		$(this.crumbSortId).html('无');//面包屑区域填充内容

		/// 展示一级分类列表时的回调
		if ( typeof(this.showLv1Call)=='function' ) {
			this.showLv1Call(this);
		}
	}

	///选中一级分类项时
	this.selectLv1 = function (one_key) {

		if ( typeof(this.two[one_key])==='undefined' ){

			var that = this;
			var now_cat = this.one[one_key];
			{literal}
			$.ajax({
				type:'POST',
				data:{p_id:now_cat.id},//当前一级分类的id，作为该一级分类下二级分类的父id
				dataType:'json',
				url:this.getChildUrl,
				async:true,
				success:function (two){
					if ( two.length==0 ){
						that.two[one_key] = [];
					}else{
						that.two[one_key] = two;

						/// 点击一级分类列表中的某个分类时的回调
						if ( typeof(that.selectLv1Call)=='function' ) {
							//that.selectLv1Call( 当前选中的一级, 当前一级所有的二级, 级联对象)
							that.selectLv1Call(now_cat, two, that);
						}
					}
					//b.ori
					that.showLv2(one_key);
					//e.ori
				}
			});
			{/literal}
		}else{
			this.showLv2(one_key);
		}
	}

	this.showLv2 = function (one_key) {

		var two_area = "";
		for (var two_key=0; two_key<this.two[one_key].length; two_key++) {
			two_area += '<li onClick="selectLv2(' + one_key + ',' + two_key + ');"><a href="javascript:void(0)">' + this.two[one_key][two_key].name + '</a></li>';
		}

		$(this.sort2Id).html(two_area).show();
		$(this.sort3Id).hide();
		$(this.sort1Id+" li").eq(one_key).addClass("active").siblings("li").removeClass("active");

		this.expressLv1 = this.one[one_key].name;
		$(this.crumbSortId).html(this.expressLv1);//将第一栏被选中项填入面包屑区域

		if ( typeof(this.showLv2Call)=='function' ) {
			this.showLv2Call(this.one[one_key], this);
		}
	}

	///选中二级分类项时
	this.selectLv2 = function (one_key, two_key) {

		if ( typeof(this.three[one_key])==='undefined'||typeof(this.three[one_key][two_key])==='undefined' ){

			var that = this;
			var now_cat = this.two[one_key][two_key];
			{literal}
			$.ajax({
				type:'POST',
				data:{p_id:this.lv2Ids[lv1_key][lv2_key]},
				data:{p_id:this.now_cat.id},//当前二级分类的id，作为该二级分类下三级分类的父id
				dataType:'json',
				url:this.getChildUrl,
				async:true,
				success:function (three){
					if ( three.length==0 ){
						if ( typeof(that.three[one_key])==='undefined' ){
							that.three[one_key] = [];
						}
						that.three[one_key][two_key] = [];
					}else{
						that.three[one_key][two_key] = three;
					}

					/// 点击二级分类列表中的某个分类时的回调
					if ( typeof(that.selectLv2Call)=='function' ) {
						//that.selectLv2Call( 当前选中的二级, 当前二级所有的三级, 级联对象)
						that.selectLv2Call(now_cat, three, that);
					}

					//b.ori
					that.showLv3(one_key,two_key);
					//e.ori
				}
			});
			{/literal}
		}else{
			this.showLv3(one_key,two_key);
		}
	}

	this.showLv3 = function (one_key,two_key) {

		var three_area = "";
		var this_three = this.three[one_key][two_key];

		for (var three_key=0; three_key<this_three.length; three_key++) {
			three_area += '<li onClick="selectLv3(' + one_key + ',' + two_key + ',' + three_key + ');"><a href="javascript:void(0)">' + this_three[three_key].name + '</a></li>';
		}
		
		$(this.sort3Id).html(three_area).show();
		$(this.sort2Id+" li").eq(two_key).addClass("active").siblings("li").removeClass("active");

		this.expressLv2 = this.expressLv1 + this.arrow + this.two[one_key][two_key].name;
		$(this.crumbSortId).html(this.expressLv2);

		if ( typeof(this.showLv3Call)=='function' ) {
			this.showLv3Call(this.two[one_key][two_key], this);
		}

		if (this_three.length==0) {
			return false;
		}
	}

	this.selectLv3 = function (one_key, two_key, three_key) {
		$(this.sort3Id+" li").eq(three_key).addClass("active").siblings("li").removeClass("active");

		if ( typeof(this.selectLv3Call)=='function' ) {
			this.selectLv3Call(this.three[one_key][two_key][three_key], this);
		}
	}
}

/*初始化参数*/
var one = {json_encode($one)};
var url = init.url.main+'/tools/expcat/getChild';

var cascade_beauty = new CascadeBeauty({
	"one": one,
	"url": url,
	"sort1": "sort1",
	"sort2": "sort2",
	"sort3": "sort3",
	"crumb_id": "selectedSort",
	"showLv1Call": function (obj){

		$("#FIRE_parent_id").val("0");
		$("#FIRE_parent_level").val("0");
		$("#FIRE_parent_child_num").val("0");
		$(".FIRE_this_cat_name").val("");
		$(".FIRE_show_cat_name").html("EXP分类");
	},
	"showLv2Call": function (now_select_one, obj){

		$("#FIRE_parent_id").val(now_select_one.id);
		$("#FIRE_parent_level").val(now_select_one.level);
		$("#FIRE_parent_child_num").val(now_select_one.child_num);

		$(".FIRE_this_cat_id").val(now_select_one.id);
		$(".FIRE_this_cat_name").val(now_select_one.name);
		$(".FIRE_show_cat_name").html(now_select_one.name);
	},
	"showLv3Call": function (now_select_two, obj) {
		
		$("#FIRE_parent_id").val(now_select_two.id);
		$("#FIRE_parent_level").val(now_select_two.level);
		$("#FIRE_parent_child_num").val(now_select_two.child_num);

		$(".FIRE_this_cat_id").val(now_select_two.id);
		$(".FIRE_this_cat_name").val(now_select_two.name);
		$(".FIRE_show_cat_name").html(now_select_two.name);
	},
	"selectLv3Call": function (now_select_three, obj) {
		$(".FIRE_this_cat_id").val(now_select_three.id);
		$(".FIRE_this_cat_name").val(now_select_three.name);
		$(".FIRE_show_cat_name").html(now_select_three.name);
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
        