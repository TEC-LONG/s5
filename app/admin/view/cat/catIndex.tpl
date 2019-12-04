{include file="common/top.tpl" htag='catIndex'}
                
                <h4 class="page-title">分类管理</h4>
				<div class="block-area">
					<div style="color: #000; font: 12px/20px "Microsoft Yahei", Tahoma, Arial, "Helvetica Neue", "Hiragino Sans GB", Simsun, sans-self;">
						{literal}
					<style>
	.wareSort a { text-decoration: none; color: #333; }
					</style>
						{/literal}
						<div class="wareSort clearfix">
							<ul id="sort1"></ul>
							<ul id="sort2" style="display: none;"></ul>
							<ul id="sort3" style="display: none;"></ul>
						</div>
						<div class="selectedSort"><b>您当前选择的分类是：</b><i id="selectedSort"></i></div>
						<!-- <div class="wareSortBtn"> -->
							<!-- <input id="releaseBtn" type="button" value="下一步" disabled="disabled" /> -->
						<!-- </div> -->
					</div>
				</div>

				<div class="block-area" id="tableHover">
                    <h3 class="block-title">modify</h3>
					<br/><br/>
					<div class="col-md-4">
						<input type="text" class="form-control input-sm m-b-10 catUpdName" placeholder="分类名称：" name="name">
					</div>
					<!-- <div class="col-md-4"> -->
						<!-- <input type="text" class="form-control input-sm m-b-10" placeholder="直属文章数量：" name="name"> -->
					<!-- </div> -->
					<!-- <div class="col-md-4"> -->
						<!-- <input type="text" class="form-control input-sm m-b-10" placeholder="当前分类层级：" name="name"> -->
					<!-- </div> -->
					<!-- <div class="clearfix"></div> -->
					<!-- <div class="col-md-4"> -->
						<!-- <input type="tel" class="form-control input-sm m-b-10" placeholder="是否有子节点：" name="cell"> -->
					<!-- </div> -->
					<!-- <div class="col-md-4"> -->
						<!-- <input type="text" class="form-control input-sm m-b-10" placeholder="直属子节点总数：" name="email"> -->
					<!-- </div> -->
					<!-- <div class="col-md-4 m-b-10"> -->
						<!-- <select class="select" name="level"> -->
							<!-- <option value="0">普通用户</option> -->
							<!-- <option value="1">管理员</option> -->
						<!-- </select> -->
					<!-- </div> -->
					<div class="col-md-10">
						<button class="btn btn-sm catUpdBtn">Save Modify</button>
					</div>
                </div>

				<div class="block-area" id="tableHover">
                    <h3 class="block-title">ADD</h3>
					<br/><br/>
					<div class="col-md-4">
						<input type="text" class="form-control input-sm m-b-10 catAdName" placeholder="分类名称：" name="name">
					</div>
					<div class="col-md-4">
						<div class="make-switch" data-text-label="FIRST"><input type="checkbox" class="is_first"></div>
					</div>
					<div class="col-md-10">
						<button class="btn btn-sm catAdBtn">Add New One</button>
					</div>
                </div>

            </section>
            <br/><br/>
        </section>

<script type="text/javascript">
/* init vars */
var domain = '{$smarty.const.URL}';
//一级分类
//var province = ["教育", "文艺", "青春"];
var province = {json_encode($p['p_names'])};
var province_ids = {json_encode($p['p_ids'])};
//二级分类
var city = [];
var city_ids = [];
var g_p, g_c, g_d;
//三级分类
var district = [];
var district_ids = [];

{literal}
var expressP, expressC, expressD, expressArea, areaCont;
var arrow = " <font>&gt;</font> ";
var nowCat = {'id':0, 'name':'', 'level':0};//level值默认为0，表示没选中任何分类
{/literal}
</script>

        {* Javascript Libraries *}
        {include file="common/js_footer.tpl" tag="catIndex"}
<script type="text/javascript">
//将添加顶级分类标记按钮设置为switch-on
window.onload = function (){
	$('.make-switch').find('div').attr('class', 'switch-on switch-animate');
}

{* 点击编辑按钮 *}
$('.catUpdBtn').click(function (){

	{*检查分类名是否填写*}
	var name = $('.catUpdName').val().replace(/\s/g,"");{*去掉所有的空格*}
	if ( typeof(name)==='string'&&name==='' ){
		alert('请填写分类名称');
		return false;
	}

	{*检查是否选择需要修改的分类*}
	if ( nowCat.id==0 ){
		alert('请先选择需要修改的分类');
		return false;
	}
	
	{literal}
	$.ajax({
		type:'POST',
		data:{name:name, id:nowCat.id},
		dataType:'json',
		url:domain+'/index.php?p=admin&m=cat&a=catUpdh',
		async:false,
		success:function (re){
			if ( re.type=='yes' ){
				switch ( nowCat.level ){
					case 1://修改的是1级分类
						province[g_p] = name;
						intProvince();
						selectP(g_p);
					break;
					case 2://修改的是2级分类
						city[g_p][g_c] = name;
						selectP(g_p);
						selectC(g_p,g_c);
					break;
					case 3://修改的是3级分类
						district[g_p][g_c][g_d] = name;
						selectC(g_p,g_c);
						selectD(g_p,g_c,g_d);
					break;
				}
				alert('yes');
			}
		}
	});
	{/literal}
});


{* 点击添加按钮-begin *}
$('.catAdBtn').click(function(){

//{$smarty.const.URL}/index.php?p=admin&m=cat&a=catAdh

	{*检查分类名是否填写*}
	var name = $('.catAdName').val().replace(/\s/g,"");{*去掉所有的空格*}
	if ( typeof(name)==='string'&&name==='' ){
		alert('请填写分类名称');
		return false;
	}

	{*检查当前添加的是否为顶级分类，包含switch-on表示是顶级分类*}
	if ( $('.make-switch').find('div').attr('class').indexOf('switch-on')>=0 ){
		{literal}
		nowCat = {'id':0, 'name':'', 'level':0}
		{/literal}
	}

	{*检查父分类层级是否是第一级或第二级*}
	if ( nowCat.level>2 ){
		alert('父分类只能选择一级分类或者二级分类！');
		return false;
	}

	{literal}
	$.ajax({
		type:'POST',
		data:{name:name, parent_id:nowCat.id, level:(nowCat.level+1)},
		dataType:'json',
		url:domain+'/index.php?p=admin&m=cat&a=catAdh',
		async:false,
		success:function (re){
			switch ( nowCat.level ){
				case 0:
					var length = province.length;
					province[length] = name;
					province_ids[length] = re.id;
					city[length] = [];
					intProvince();
				break;
				case 1:
					var length = city[g_p].length;
					if ( typeof(city[g_p])==='undefined' ){
						city[g_p] = [];
					}
					city[g_p][length] = name;
					if ( typeof(city_ids[g_p])==='undefined' ){
						city_ids[g_p] = [];
					}
					city_ids[g_p][length] = re.id;
					if ( typeof(district_ids[g_p])==='undefined' ){
						district_ids[g_p] = [];
					}
					district_ids[g_p][length] = [];
					selectP(g_p);
				break;
				case 2:
					
					var length = district[g_p][g_c].length;
					
					if ( typeof(district[g_p][g_c])==='undefined' ){
						district[g_p][g_c] = [];
					}
					district[g_p][g_c][length] = name;
					if ( typeof(district_ids[g_p][g_c])==='undefined' ){
						district_ids[g_p][g_c] = [];
					}
					district_ids[g_p][g_c][length] = re.id;
					selectC(g_p,g_c);
				break;
			}
		}
	});
	{/literal}

});
{* 点击添加按钮-end *}
</script>
    </body>
</html>

