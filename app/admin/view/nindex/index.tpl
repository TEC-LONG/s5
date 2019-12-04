{include file='ncom/head.tpl'}

{*页头.begin*}
<div class="row no-gutters bg-dark">
    <div class="col-sm-12">
        <!-- 隐藏页头内容.begin -->
        {include file='ncom/hideBhead.tpl'}
        <!-- 隐藏页头内容.end -->
        <nav class="navbar navbar-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- 页头导航.begin -->
            {include file='ncom/bheadNav.tpl'}
            <!-- 页头导航.end -->
        </nav>
    </div>
</div>
{*页头.end*}

<div class="row no-gutters bg-dark">
    <div class="col-sm-12">
        <!-- 主页卡.begin -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#HOME" role="tab" aria-controls="home" aria-selected="true">HOME</a>
            </li>
        </ul>
        <!-- 主页卡.end -->
    </div>
</div>

<div class="row no-gutters">
    <div class="col-sm-12">
        {* 主页卡对应的模板内容.begin *}
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="HOME" role="tabpanel" aria-labelledby="home-tab">
			{*HOME模板内容*}
			{include file="nhome/home.tpl"}
			</div>
        </div>
        {* 主页卡对应的模板内容.end *}
    </div>
</div>

{include file='ncom/footer.tpl'}

{literal}
<script type="text/javascript">
function gtpl(id, webUrl, datas='no'){
	$.ajax({  
		url: webUrl,  
		type: 'post',
		async: true,
		dataType: 'html',
		data: {dts:datas},
		success: function(htmlData){
			$('#'+id).html(htmlData);
		}
	});
}

$(function(){
//--------------------.b

//首次加载后台首页，调用ajax展示HOME页面
gtpl('home', 'http://s5.home.com/index.php?p=admin&m=index&a=showTab');

var tags = ['home'];//选择标记，如果选择过的页卡，其id将会被保存进tags中

//给隐藏页头绑定点击事件
$("#navbarToggleExternalContent").find("a").click(function(){

	var thisIndex = $(this).index();
	var innerHtml = $(this).html();
	var stag = $(this).attr('stag').split('_');//["user", "p=admin&m=index&a=showList"]
	var datas = $(this).attr('sson');

	if ( tags[thisIndex] ){//如果选择过该页卡，则无需再次构建页卡
		$('#myTab a[href="#'+stag[0]+'"]').tab('show');
		return false;
	}else{//如果没有选择过该页卡，则先加入tags标记，再选择
		tags[thisIndex] = stag[0];
	}

	//添加页卡内容
	var con2 = '<div class="tab-pane fade" id="'+stag[0]+'" role="tabpanel" aria-labelledby="'+stag[0]+'-tab"></div>';
	$("#myTabContent").append(con2);

	//添加页卡
	var con1 = '<li class="nav-item">';
	con1 += '<a class="nav-link" id="'+stag[0]+'-tab" data-toggle="tab" href="#'+stag[0]+'" role="tab" aria-controls="'+stag[0]+'" aria-selected="false">'+innerHtml+'</a>';
	con1 += '</li>';
	$("#myTab").append(con1);

	//让页卡选中并显示
	$('#myTab a[href="#'+stag[0]+'"]').tab('show');

	//展示相应页卡模板内容
	gtpl(stag[0], 'http://s5.home.com/index.php?p=admin&m=index&a=showTab', datas);
});

//--------------------.e
});
</script>
{/literal}