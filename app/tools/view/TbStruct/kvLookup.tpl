<div class="pageContent">
	<div class="pageFormContent key_val_div" layoutH="58">
		<select class="combox" name="database" ref="w_combox_tb" refUrl="{$url.combox_tb}&belong_db={ldelim}value{rdelim}">
		{foreach $belong_db as $belong_db_k=>$belong_db_v}
			<option value="{$belong_db_k}">{$belong_db_v}</option>
		{/foreach}
		</select>
		<br/><br/><br/>
		<select class="combox" name="tb" id="w_combox_tb" ref="w_combox_fields" refUrl="{$url.combox_tb}&id={ldelim}value{rdelim}">
		{foreach $first_database_tbs as $first_database_tbs_k=>$first_database_tbs_v}
			<option value="{$first_database_tbs_v.0}">{$first_database_tbs_v.1}</option>
		{/foreach}
		</select>
		<select name="fields" id="w_combox_fields" style="display:none;" onchange="f1(this)">
			{foreach $first_tb_normal_special_fields as $first_tb_normal_special_fields_k=>$first_tb_normal_special_fields_v}
			<option value="{$first_tb_normal_special_fields_v.ori_key_val}">{$first_tb_normal_special_fields_v.en_name}</option>
			{/foreach}
		</select>
		<br/><br/>
		<ul class="tree">
		{foreach $first_tb_normal_special_fields as $first_tb_normal_special_fields_k=>$first_tb_normal_special_fields_v}
			<li><a href="javascript:" onclick="$.bringBack({ldelim}'en_name[]':'{$first_tb_normal_special_fields_v.en_name}','ori_key_val[]':'{$first_tb_normal_special_fields_v.ori_key_val}'{rdelim})">{$first_tb_normal_special_fields_v.en_name}：{$first_tb_normal_special_fields_v.ori_key_val}</a></li>
		{/foreach}
		</ul>
	</div>
	
	<div class="formBar">
		<ul>
			<li><div class="button"><div class="buttonContent"><button class="close" type="button">关闭</button></div></div></li>
		</ul>
	</div>
</div>
<script>


var f1 = function (select){

	var ul = document.createElement("ul");
	$('select[name="fields"]').find('option').each(function(i){

		//console.log($(this).val());
		//console.log($(this).html());
		//console.log('=================');
		//tree_html += '<li><a href="javascript:" onclick="$.bringBack({ldelim}en_name:"'+$(this).html()+'",ori_key_val:"'+$(this).val()+'"{rdelim})">'+$(this).html()+'：'+$(this).val()+'</a></li>';

		if($(this).val()!=='none'){
			var li = document.createElement("li");
			var a = document.createElement("a");
			var div1 = document.createElement("div");
			var div2 = document.createElement("div");
			$(div2).addClass('node');
			a.setAttribute('href', 'javascript:');
			a.setAttribute('onclick', '$.bringBack({ldelim}en_name:"'+$(this).html()+'",ori_key_val:"'+$(this).val()+'"{rdelim})');
			a.innerText = $(this).html()+'：'+$(this).val();
			div1.appendChild(div2);
			div1.appendChild(a);
			li.appendChild(div1);
			ul.appendChild(li);
		}

		//if(i==0){
		//	$('#key_val_ul').html(li);
		//}else{
		//	document.getElementById('key_val_ul').appendChild(li);
		//}

		//console.log(li);
	});
	//删除老的select和ul
	$('.key_val_div').find('ul').remove();
	$('.key_val_div').find('select[name="fields"]').remove();

	/*<select name="fields" id="w_combox_fields" style="display:none;" onchange="f1(this)">
		{foreach $first_tb_normal_special_fields as $first_tb_normal_special_fields_k=>$first_tb_normal_special_fields_v}
		<option value="{$first_tb_normal_special_fields_v.ori_key_val}">{$first_tb_normal_special_fields_v.en_name}</option>
		{/foreach}
	</select>*/

	//构建新的select
	var new_select = document.createElement("select");
	var new_select_option = document.createElement("option");
	new_select.setAttribute('name', 'fields');
	new_select.setAttribute('id', 'w_combox_fields');
	new_select.setAttribute('style', 'display:none;');
	new_select.setAttribute('onchange', 'f1(this)');
	new_select.appendChild(new_select_option);

	//先加select
	$('.key_val_div')[0].appendChild(new_select);

	//后加ul
	$(ul).addClass('tree');
	//$(ul).addClass('expand');
	$('.key_val_div')[0].appendChild(ul);

};
</script>
