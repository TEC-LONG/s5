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

		if (typeof(arguments[0])=='function') {
			var callback = arguments[0];
			callback();
		}
	}

	///选中一级分类项时
	this.selectLv1 = function (lv1_key, showLv2Callback) {

		if ( typeof(this.lv2[lv1_key])==='undefined' ){

			var that = this;
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
					that.showLv2(lv1_key, showLv2Callback);
					//e.ori
				}
			});
		}else{
			this.showLv2(lv1_key, showLv2Callback);
		}
	}

	this.showLv2 = function (lv1_key) {

		var areaCont = "";
		for (var j=0; j<this.lv2[lv1_key].length; j++) {
			areaCont += '<li onClick="selectC(' + lv1_key + ',' + j + ');"><a href="javascript:void(0)">' + this.lv2[lv1_key][j] + '</a></li>';
		}

		$(this.sort2Id).html(areaCont).show();
		$(this.sort3Id).hide();
		$(this.sort1Id+" li").eq(lv1_key).addClass("active").siblings("li").removeClass("active");

		this.expressLv1 = lv1[lv1_key];
		$(this.crumbSortId).html(this.expressLv1);//将第一栏被选中项填入面包屑区域

		if (typeof(arguments[2])=='function') {
			var callback = arguments[2];
			callback(lv1_key);
		}
	}

	///选中二级分类项时
	this.selectLv2 = function (lv1_key, lv2_key, showLv3Callback) {

		if ( typeof(this.lv3[lv1_key])==='undefined'||typeof(this.lv3[lv1_key][lv2_key])==='undefined' ){

			var that = this;
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
					that.showLv3(lv1_key,lv2_key, showLv3Callback);
					//e.ori
				}
			});
		}else{
			this.showLv3(lv1_key,lv2_key, showLv3Callback);
		}
	}

	this.showLv3 = function (lv1_key, lv2_key) {

		var areaCont = "";

		for (var k=0; k<this.lv3[lv1_key][lv2_key].length; k++) {
			areaCont += '<li onClick="selectD(' + lv1_key + ',' + lv2_key + ',' + k + ');"><a href="javascript:void(0)">' + this.lv3[lv1_key][lv2_key][k] + '</a></li>';
		}
		
		$(this.sort3Id).html(areaCont).show();
		$(this.sort2Id+" li").eq(lv2_key).addClass("active").siblings("li").removeClass("active");

		this.expressLv2 = this.expressLv1 + this.arrow + this.lv2[lv1_key][lv2_key];
		$(this.crumbSortId).html(expressLv2);

		if (typeof(arguments[2])=='function') {
			var callback = arguments[2];
			callback(lv1_key, lv2_key);
		}

		if (this.lv3[lv1_key][lv2_key].length==0) {
			return false;
		}
	}

	this.selectLv3 = function (lv1_key, lv2_key, lv3_key) {
		$(this.sort3Id+" li").eq(lv3_key).addClass("active").siblings("li").removeClass("active");

		if (typeof(arguments[3])=='function') {
			var callback = arguments[3];
			callback(lv1_key, lv2_key, lv3_key);
		}
	}
}



var expressP, expressC, expressD, expressArea, areaCont;
var arrow = " <font>&gt;</font> ";
// if (typeof(navtab)=='undefined') {
// 		var navtab = '';
// }
var navtab = '';
if (typeof(get_child_url)=='undefined') {
	var get_child_url = '/tools/expcat/getChild';
}

/*初始化一级目录*/
function intProvince() {
	if (province==null) {
		return false;
	}
	areaCont = "";
	for (var i=0; i<province.length; i++) {
		areaCont += '<li onClick="selectP(' + i + ');"><a href="javascript:void(0)">' + province[i] + '</a></li>';
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
	$("."+navtab+"FIRE_show_cat_name").html("EXP分类");
}
intProvince();

/*选择一级目录*/
function showC(p){//显示二级分类

	areaCont = "";
	for (var j=0; j<city[p].length; j++) {
		areaCont += '<li onClick="selectC(' + p + ',' + j + ');"><a href="javascript:void(0)">' + city[p][j] + '</a></li>';
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
	$("."+navtab+"FIRE_show_cat_name").html(province[p]);
}
function selectP(p) {
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
					city_child_nums[p] = re['child_child_nums'];
				}
				//b.ori
				showC(p);
				//e.ori
			}
		});
	}else{
		showC(p);
	}
	//e.wxg.2018/6/18
}

/*选择二级目录*/
function showD(p,c){//显示三级分类

	areaCont = "";
	expressC = "";

	for (var k=0; k<district[p][c].length; k++) {
		areaCont += '<li onClick="selectD(' + p + ',' + c + ',' + k + ');"><a href="javascript:void(0)">' + district[p][c][k] + '</a></li>';
	}
	
	$("#"+navtab+"sort3").html(areaCont).show();
	$("#"+navtab+"sort2 li").eq(c).addClass("active").siblings("li").removeClass("active");
	expressC = expressP + arrow + city[p][c];
	$("#"+navtab+"selectedSort").html(expressC);
	$("#"+navtab+"FIRE_parent_id").val(city_ids[p][c]);
	$("#"+navtab+"FIRE_parent_level").val(city_levels[p][c]);
	if (typeof(province_child_nums)!='undefined') {
		$("#"+navtab+"FIRE_parent_child_num").val(city_child_nums[p][c]);
	}
	$("."+navtab+"FIRE_this_cat_id").val(city_ids[p][c]);
	$("."+navtab+"FIRE_this_cat_name").val(city[p][c]);
	$("."+navtab+"FIRE_show_cat_name").html(city[p][c]);
	if (district[p][c].length==0) {
		return false;
	}
}
function selectC(p,c) {
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
				}
				//b.ori
				showD(p,c);
				//e.ori
			}
		});
	}else{
		showD(p,c);
	}
	//e.wxg.2018/6/18
}

/*选择三级目录*/
function selectD(p,c,d) {
	$("#"+navtab+"sort3 li").eq(d).addClass("active").siblings("li").removeClass("active");
	$("."+navtab+"FIRE_this_cat_id").val(district_ids[p][c][d]);
	$("."+navtab+"FIRE_this_cat_name").val(district[p][c][d]);
	$("."+navtab+"FIRE_show_cat_name").html(district[p][c][d]);
	//expressD = expressC + arrow + district[p][c][d];
	//$("#selectedSort").html(expressD);
}

/*点击下一步*/
//$("#releaseBtn").click(function() {
	//var releaseS = $(this).prop("disabled");
	//if (releaseS == false) {//未被禁用
		////location.href = "商品发布-详细信息.html";//跳转到下一页
	//}
//});