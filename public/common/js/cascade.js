function Cascade(url, lv2_class, lv3_class){

	this.url = url;
	this.lv2_class = '.'+lv2_class;
	this.lv3_class = '.'+lv3_class;

	this.option0 = '<option value="0">请选择...</option>';

	this.clickOption0 = function (pid, type) {
		if (type=='lv1') {
			this.selectInnerHtml(this.lv2_class, this.option0);
			this.toogleDisableLv2('off');
		}
		this.selectInnerHtml(this.lv3_class, this.option0);
		this.toogleDisableLv3('off');
	}

	this.selectInnerHtml = function (class_name, option_html) {
		$(class_name).html(option_html);
	}

	this.toogleDisableLv2 = function (on_off) {

		if (on_off=='off') {
			$(this.lv2_class).attr('disabled', true);
		}else if(on_off='on'){
			$(this.lv2_class).removeAttr('disabled');
		}
	}

	this.toogleDisableLv3 = function (on_off) {

		if (on_off=='off') {
			$(this.lv3_class).attr('disabled', true);
		}else if(on_off='on'){
			$(this.lv3_class).removeAttr('disabled');
		}
	}

	this.showNext = function (pid, type) {

		var that = this;

		$.ajax({
			type: 'POST',
			data: {p_id:pid},
			dataType: 'json',
			url: this.url,
			async: true,
			success:function (re){

				var options = that.option0;
				for(var i in re.child_names){
					options += '<option value="'+re.child_ids[i]+'|'+re.child_names[i]+'">'+re.child_names[i]+'</option>';
				}

				if (type=='lv1') {
					that.selectInnerHtml(that.lv2_class, options);
					that.toogleDisableLv2('on');
					window.setTimeout(function() {//ajax加载select-option选项，需要给一个延迟，否则将出现数据有回填，但是显示的选中项却是空白的问题
						that.selectInnerHtml(that.lv3_class, that.option0);
						that.toogleDisableLv3('off');
					}, 10);
					
				} else {
					window.setTimeout(function() {
						that.selectInnerHtml(that.lv3_class, options);
						that.toogleDisableLv3('on');
					}, 10);
				}

				if (typeof(that.callback)!='undefined') {
					that.callback();
				}
			}
		});
	}
}

var cascade_this = function (now, type) {

	var pid = $(now).val().split('|')[0];

	if (typeof(arguments[2])=='function') {
		cascade.callback = arguments[2];
	}

	if (pid==0) { //点击了第一个选项 "请选择.."
		cascade.clickOption0(pid, type);
	}else{ //点击了非 "请选择.." 选项,则获取并展示下一级的内容
		cascade.showNext(pid, type);
	}
}