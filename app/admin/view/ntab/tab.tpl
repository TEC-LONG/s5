<div class="row">
{if $dts!='no'}
<div class="col-sm-2">
	<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
	{foreach from=$dts item='son' key='property_name' name='f1'}
		<a class="nav-link {if $smarty.foreach.f1.index==0}active{/if}" id="v-pills-{$property_name}-tab" data-toggle="pill" href="#v-pills-{$property_name}" role="tab" aria-controls="v-pills-home" aria-selected="true" webUrl="{$son->gvar}">{$son->name}</a>
	{/foreach}
		<!-- <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">新增</a> -->
	</div>
</div>

{/if}
{if $dts!='no'}
<div class="col-sm-10">
	<div class="tab-content" id="v-pills-tabContent">
	{foreach from=$dts item='son' key='property_name' name='f2'}
		<div class="tab-pane fade show {if $smarty.foreach.f2.index==0}active{/if}" id="v-pills-{$property_name}" role="tabpanel" aria-labelledby="v-pills-{$property_name}-tab"></div>
	{/foreach}
		<!-- <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">ddd</div> -->
	</div>
</div>

{literal}
<script type="text/javascript">
var sonTags = [];
//sonTags[0] = $($('#v-pills-tab').find('a')[0]).attr('id');//["v-pills-user_list-tab"]  第一个子选项卡为加载页面时默认就显示出来的

function getSonTabTpl(obj){
	
	if ( obj.type=='click' ){//不传参，则会有个event对象，如果该对象的type值为click，则表示没传参
		obj = $(this);
	}

	var webUrl = 'http://exp.local.com/index.php?'+obj.attr('webUrl');
	var tplId = obj.attr('href');
	var id = obj.attr('id');
	var thisIndex = obj.index();

	if ( sonTags[thisIndex]!=id ){
		//console.log(webUrl);
		sonTags[thisIndex]  = id;
		$.ajax({  
			url: webUrl,
			type: 'post',
			async: true,
			dataType: 'html',
			success: function(htmlData){
				$(tplId).html(htmlData);
			}
		});
	}
}

$(function(){
//--------------------.b
var firstAId = $($('#v-pills-tab').find('a')[0]).attr('id');//第一个a标签的id值
getSonTabTpl($('#'+firstAId));//调用函数展示首次加载时需要展示的子模板页面，比如列表页
$('#v-pills-tab').find('a').click(getSonTabTpl);//给子页卡绑定点击事件，渲染相应的子页卡对应的子模板
//--------------------.e
});
</script>
{/literal}
{/if}
</div>