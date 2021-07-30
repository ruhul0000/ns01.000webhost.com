$(function(){
        $("#check").click(function() {
var strr = $('input[name=url]').val();
        if(strr.length){
            
strr = strr.toLowerCase(); strr = strr.replace("http://", ""); strr = strr.replace("https://", ""); 
strr = strr.replace("www.", ""); 
            if (!/(^|\s)((https?:\/\/)?[\w-]+(\.[\w-]+)+\.?(:\d+)?(\/\S*)?)/gi.test(strr)) {
                $(url).parent().addClass('has-error');
                $(url).val('');
                $(url).attr("placeholder", "Please enter a valid URL!");
                return false;
            }else{
$(url).val(strr);
var $btn = $(this);
    $btn.button('loading'); 
}

        }
      
});
    });

$(document).ready(function() {
    $('a[href="#navbar-more-show"], .navbar-more-overlay').on('click', function(event) {
		event.preventDefault();
		$('body').toggleClass('navbar-more-show');
		if ($('body').hasClass('navbar-more-show'))	{
			$('a[href="#navbar-more-show"]').closest('li').addClass('active');
		}else{
			$('a[href="#navbar-more-show"]').closest('li').removeClass('active');
		}
		return false;
	});
});

$(document).ready(function() {
	$('.traffic-graph a[data-toggle="tab"]').on('shown.bs.tab', function () {

		$($(this).attr('href').replace('#', '#_')).addClass('in active')
	});
	var f = function () {
		var src;
		var e = $('.traffic-graph .alexa-graph');
		src = e.attr('src').replace(/(\Wy=)[a-z](\W)/ig, '$1' + $(this).attr('data-y') + '$2');
		if (src != e.attr('src')) {
			e.attr('src', src)
		}
	};

	$('.traffic-graph a[data-toggle="tab"]').unbind('click', f).click(f);
	var f = function () {
		var src;
		var e = $('.traffic-graph .alexa-graph');
		src = e.attr('src').replace(/(\Wr=)[0-9][a-z](\W)/ig, '$1' + $(this).val() + '$2');
		if (src != e.attr('src')) {
			e.attr('src', src)
		}
	};
	$('.traffic-graph select').unbind('change', f).change(f)
});