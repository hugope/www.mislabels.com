(function($){

	$(document).on("ready", function(){

		var cat_nav = window.document.getElementById('main_cat_nav')
			,	$cat_nav = $('.slider.slider-header', cat_nav)
			,	cat_nav_options
			,	$cat_nav_slider
			,	showcase = window.document.getElementById('showcase')
			,	$showcase = $('.slider.slider-showcase', showcase)
			,	showcase_config
			,	cat_nav_f = window.document.getElementById('footer_cat_nav')
			,	$cat_nav_f = $('.slider.slider-footer', cat_nav_f)
			,	cat_nav_f_config
			,	$cat_nav_f_slider
			,	newest = window.document.getElementById('newest')
			,	$newest = $('.slider.slider-newest', newest)
			,	newest_config
			,	$forms = $('form.catalog-form')
			,	set_cat_form
			,	catalog_form = window.document.getElementById('catalog_filter')

		// form funcnitionality

		set_cat_form = {

				set_form : function($slider) {
					var $links = $('a', $slider);
					$links.on("click", set_cat_form.goto_catalog);
					// console.log("se procedera a agregar acciones a los links de", $slider);
					// console.log("links", $links);
				}

			,	goto_catalog: function(event) {
				event.preventDefault();
				// set data to form
				$('.category', catalog_form).val( $(this).data().cat );
				console.log("se click", this, "y su data es", $(this).data());
				console.log('enviar este form', catalog_form);
				// send data
				$(catalog_form).submit();
			}

		}


		//run cat nav slider
		cat_nav_options = {
				auto: false
			,	pager: false
			, minSlides : 6
			, maxSlides : 6
			,	moveSlides : 1
			,	slideWidth : 159
			,	hideControlOnEnd : true
			,	onSliderLoad: function(a) {
				console.log('se acaba de crear el slider del header');
				set_cat_form.set_form( $cat_nav );
			}
		}

		$cat_nav_slider = $cat_nav.bxSlider(cat_nav_options);

		// run showcase

		showcase_config = {
				auto: true
			,	pagerCustom: '#showcase_pager'
			,	controls: false
		}

		$showcase.bxSlider(showcase_config);

		// run footer cat slider

		cat_nav_f_config = {
				auto: false
			,	pager: false
			, minSlides : 6
			, maxSlides : 6
			,	moveSlides : 1
			,	slideWidth : 160
			,	onSliderLoad: function(a) {
				console.log('se acaba de crear el slider del footer');
				set_cat_form.set_form( $cat_nav_f );
			}
		}

		$cat_nav_f_slider = $cat_nav_f.bxSlider(cat_nav_f_config);

		newest_config = {
				auto: true
			,	pager: false
			,	minSlides: 4
			,	maxSlides: 4
			,	moveSlides: 1
			,	slideWidth: 220
			,	slideMargin: 18
			,	onSliderLoad: function(a) {
				console.log('se acaba de crear el slider de los mas nuevos', newest);
			}
		}

		$newest.bxSlider( newest_config );

	});
})(window.jQuery);