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
<script src="{$smarty.const.PUB_COMMON_JS}/cascade.beauty.js" type="text/javascript"></script>
<script type="text/javascript">
/*初始化参数*/
var one = {json_encode($one)};
var url = init.url.main+'/tools/expcat/getChild';
</script>


	<div class="wareSort clearfix">
		<ul id="sort1"></ul>
		<ul id="sort2" style="display: none;"></ul>
		<ul id="sort3" style="display: none;"></ul>
	</div>
	<div class="selectedSort"><b>您当前选择的商品类别是：</b><i id="selectedSort"></i></div>

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
</div>

{literal}
<script type="text/javascript">
/// 创建分类联动对象
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

/// 加载页面时显示所有一级分类
cascade_beauty.showLv1();
/// 点击重置时初始化到仅展示一级分类
$('#FIRE_resetCatPid').click(function (){
	cascade_beauty.showLv1();
	return false;
});
</script>
{/literal}
        