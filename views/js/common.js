$(function () {
	var pageName = function () {
		var a = location.href;
		var b = a.split("/");
		var c = b.slice(b.length-1, b.length).toString(String).split(".");
		var pageName = c.slice(0, 1);
		if(pageName == 'checkorder') pageName = 'gbus';
		if(pageName == 'detail') pageName = 'pbus';
		if(pageName == '') pageName = 'index';
		return pageName;
	}

	$('.nav-menu-item').hover(function(){
		if($(this).hasClass('active')) {
			return false
		} else {
			$(this).addClass('hover');
		}
	}, function() {
		$(this).removeClass('hover');
	})

	$('#' + pageName()).addClass('active');
})