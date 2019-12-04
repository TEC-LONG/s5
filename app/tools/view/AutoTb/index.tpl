<h2 class="contentTitle">MYSQL</h2>


<div class="pageContent">
	
	<!-- <form method="post" id="mysql" action="http://www.adm.com/index.php/Admin/CAutotb/index" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone, '第一步操作成功');"> -->
	<form method="post" id="mysql" action="{$url.index}" class="pageForm required-validate">

		<div class="pageFormContent nowrap" layoutH="97">
			
			<dl class="nowrap">
				<dt>Structure：</dt>
				<dd><textarea name="structure" class="required" cols="190" rows="7"></textarea></dd>
			</dl>

			<dl>
				<dt>Engine：</dt>
				<dd>
				<select class="combox" name="engine">
				{foreach $datas.engines as $engine}
					<option value="{$engine}">{$engine}</option>
				{/foreach}
				</select> 
				</dd>
			</dl>

			<dl>
				<dt>Charset：</dt>
				<dd>
				<select class="combox" name="charset">
				{foreach $datas.chars as $char}
					<option value="{$char}">{$char}</option>
				{/foreach}
				</select>
				</dd>
			</dl>

			<dl class="nowrap">
				<dt>Step：</dt>
				<dd>
					<select class="combox" name="step">
					{foreach $datas.steps as $stepsK=>$step}
						<option value="{$stepsK}">{$step}</option>
					{/foreach}
					</select>
				</dd>
			</dl>

			<dl class="nowrap">
				<dt>acts：</dt>
				<dd>
					add：<input name="add" value="1" type="checkbox" checked="checked" />&nbsp;&nbsp;
					edit：<input name="edit" value="1" type="checkbox" checked="checked" />&nbsp;&nbsp;
					list：<input name="list" value="1" type="checkbox" checked="checked" onclick="return false;" />&nbsp;&nbsp;
					del：<input name="del" value="1" type="checkbox" checked="checked" />&nbsp;&nbsp;
				</dd>
			</dl>

			<div class="divider"></div>

			<dl class="nowrap">
				<dt>SQL：</dt>
				<dd><textarea readonly="true" cols="190" rows="17" class="sql"></textarea></dd>
			</dl>

			<div class="divider"></div>

			<dl class="nowrap columList" style="display:none;">
				<dd style="width:1500px;">
				</dd>
			</dl>

			
			<div class="divider"></div>
			<p>自定义扩展请参照：</p>
			<p>错误提示信息国际化请参照：</p>
		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
				<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
			</ul>
		</div>
	</form>
	
</div>

{literal}
<script type="text/javascript">
////s.js.WangXin2016/1/8.函数定义...............................e
//function customvalidXxx(element){
	//if ($(element).val() == "xxx") return false;
	//return true;
//}
function navTabAjaxDone(json){
	
	//DWZ.ajaxDone(json);//s.WangXin2016/1/7.提示框(成功提示成功，错误提示报错)
	//console.log(DWZ.ajaxDone(json));

	//console.log(json);

	if (json.statusCode == DWZ.statusCode.ok){

		if ( $('select[name="step"]').val()=='one' ){ 

			$('.columList').find('dd').html(json.exInfo.columList);
			$('.columList').show(0);
		}else if($('select[name="step"]').val()=='two'){ 
		
			
		}

		$('.sql').html(json.exInfo.sql);

		//if (json.navTabId){ //把指定navTab页面标记为需要“重新载入”。注意navTabId不能是当前navTab页面的

			//navTab.reloadFlag(json.navTabId);

		//} else { //重新载入当前navTab页面

			//navTabPageBreak();
		//}

		//if ("closeCurrent" == json.callbackType) {

			//setTimeout(function(){navTab.closeCurrentTab();}, 100);

		//} else if ("forward" == json.callbackType) {

			//navTab.reload(json.forwardUrl);
		//}
	}


}
//function navTabSearch(form){
	//console.log(form.action);
	//console.log($(form).serializeArray());
	//navTab.reload(form.action, $(form).serializeArray());
	//return false;
//}
var mysqlSubmit = function (){

	var confirmMsg = '确定要执行'+$('select[name="step"]').val()+'?';
	return validateCallback(this, navTabAjaxDone, confirmMsg);
}
////s.js.WangXin2016/1/8.执行部分...............................e
$('#mysql').bind('submit', mysqlSubmit);
</script>
{/literal}
