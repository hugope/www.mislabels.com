$(document).ready( function()
{
	overlaypopup_initialization();
});
//---- SCROLLER
//---- OVERLAY + POPUP
function overlaypopup_initialization()
{
	//----BEGIN: OVERLAY SETTINGS
	var $overlay_background		= "#000" ;
	var $overlay_opacity		= 0.8;
	var $overlay_zindex			= 10000;
	var $popup_background		= "#FFF";
	var $popup_width			= 300;
	var $popup_height			= 300;
	var $close_image_path		= "./resourceTHEME/theme_default/images/close.png";
	var $close_image_width		= "26";
	var $close_image_height		= "26";
	//----END: OVERLAY SETTINGS
	$('body').append('<div id="overlay"></div><div id="overlaypopup"><div class="close"></div><div class="content">loading...</div></div>');
	$('#overlay').css({
		'background-color':$overlay_background,
		'opacity':$overlay_opacity,
		'z-index':$overlay_zindex,
		'display':'none',
		'cursor':'pointer',
		'position':'fixed',
		'top':'0px',
		'bottom':'0px',
		'left':'0px',
		'right':'0px', 
	});
	$("#overlaypopup").css({
		'background-color':$popup_background,
		'min-width':$popup_width+"px",
		'min-height':$popup_height+"px",
		'z-index':($overlay_zindex+500),
		'display':'none',
		'position':'absolute'
	});
	$("#overlaypopup .close").css({
		'background-image':'url('+$close_image_path+')',
		'width':$close_image_width+"px",
		'height':$close_image_height+"px",
		'top':((-1)*$close_image_height/2)+"px",
		'right':((-1)*$close_image_width/2)+"px",
		'position':'absolute',
		'cursor':'pointer',
		'z-index':($overlay_zindex+600),
	});	
	$('#overlay').bind('click', function() 
	{
		$('#overlaypopup').fadeOut(400);
		$('#overlay').fadeOut(800);
	});
	$('#overlaypopup .close').bind('click', function() 
	{
		$('#overlaypopup').fadeOut(400);
		$('#overlay').fadeOut(800);
	});
}
function overlay_show()
{
	$('#overlay').fadeIn(400);
}
function popup_show($content)
{
	$('#overlaypopup .content').html($content);
	$('#overlaypopup').center();
	$('#overlaypopup').fadeIn(800);
	$('#overlay').fadeIn(400);
}
jQuery.fn.center = function () 
{
    this.css("position","absolute");
    this.css("top", ( $(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
    this.css("left", ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");
    return this;
}
