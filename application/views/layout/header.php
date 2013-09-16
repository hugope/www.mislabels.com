<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Welcome to Mislabels</title>
	<link media="screen" type="text/css" href="<?php echo base_url('library/css/clear.css')?>" rel="stylesheet">
	<link href="<?php echo base_url('library/css/fonts.css')?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('library/css/style.css')?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('library/css/slider.css')?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('library/js/lightbox/css/lightbox.css')?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('library/js/validation-engine/css/validationEngine.jquery.css"')?>" rel="stylesheet" type="text/css" />
	<!--
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('library/js/Arctext/css/style.css')?>" /> -->

	<!-- Javascript libraries -->
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" ></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" ></script>
	<script type="text/javascript" src="<?php echo base_url('library/js/Arctext/js/jquery.arctext.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('library/js/lightbox/js/lightbox.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('library/cms/js/tagit/js/tag-it.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('library/cms/js/tagit.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('library/js/bootstrap.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('library/js/bootstrap.min.js')?>"></script>
	<!--
	<script type="text/javascript" src="<?php echo base_url('library/js/validation-engine/js/languages/jquery.validationEngine-es.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('library/js/validation-engine/js/jquery.validationEngine.js')?>"></script> -->

	
	<script type="text/javascript">
		$(document).ready(function(){
			
			//Menu de botones Bootstrap
			$('.btn').button('complete');
			
			//Cambiar color de etiquetas colores
			$('a.palette').click(function(){
				var color 		= $(this).attr('colorcode');
				var colorlabel	= $(this).attr('colorlabel');
				
				$('.labelSetContainer').animate({'background-color': color}, 1500);
				$('.text.colorvar').animate({'color': color}, 1500);
				$('input#colorlabel').val(colorlabel);
			});
		
			//Cambiar textos etiqueta
			$('input.stickerfont').on('focus, change', function(){
				var fontfamily 		= $(this).attr('fontfamily');
				
				$('.text, .prevlabel span').css('font-family', fontfamily);
			});
			
			//Cambiar color texto etiqueta
			$('input#sticker_label').on('change', function(){
				var etiqueta 	= $(this).val();
				var color 		= $('input#colorlabel').val();
				var font		= $('input.stickerfont:checked').val();
				
				location.href = "<?php echo site_url('etiquetas').'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)?>/"+etiqueta+'/'+color+'/'+font;
			});
			
			//cambiar textos de etiquetas tres tamaños
			$('.btn-group .btn').click(function(){
				var size 		= $(this).attr('labelsize');
				var inputsList	= $('.labelsInputList');
				var inputLabel	= '<input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Cereales" />';
				var imgSrc	= $('.tipoc img').attr('src');
				var labelList	= $('.labelSetContainer.tipoc');
				var imgLabel	= '<div class="prevlabel"><img src="'+imgSrc+'"><span>Cereales</span></div>';
				
				$('.labelSetContainer.tipoc').removeClass('size20 size12 size40').addClass('size'+size);
				inputsList.html(''); //Borrar listado de inputs
				labelList.html(''); //Borrar etiquetas
				
				for($i = 0; $i < size; $i++){
					inputsList.append(inputLabel); //Agregar listado de inputs según tamaño seleccionado
					labelList.append(imgLabel); //Agregar listado de etiquetas según tamaño seleccionado
				}
				
				//Cambiar el texto
				change_label_text();
				
				//Validar el formulario
				//form_validation()
			});
			
			//Validate the forms
			//form_validation();
			
		});
		
		//Change the text in the specific label
		function change_label_text(){
			
			$('.labelsText').change(function(){
				var inputNumber = $(this).index();
				var inputText	= $(this).val();
				console.log(inputNumber);
				
				$(".prevlabel:eq("+inputNumber+")").find("span").html(inputText);
			});
		}
		
		//Validate the forms
		function form_validation(){
			$("form").validationEngine();
		}
	</script>
	<!--[if lt IE 9]>
		<style>.leftbox_cata .ribbon{display:none}</style>
	<![endif]-->
</head>

<body>
	<div id="header_wrapper">
		<div class="headerContener">
			<div class="headtopbox">
				<div class="twittNews"><p><a href="#"><img src="<?php echo base_url('library/images/bird.png')?>" alt="Bird" /> </a></p></div>
				<div class="loginrightbox">
					<ul>
						<?php if($this->session->userdata('CUSTOMER_SESSION') == TRUE):?>
						<li><a href="<?php echo site_url('carrito')?>" class="active"><img src="<?php echo base_url('library/images/shopCart.png')?>" alt="Cart" /> &nbsp; Mi Carrito</a></li>
						<li><a href="<?php echo site_url('miperfil')?>" class="">Mi cuenta</a></li>
						<li><a href="<?php echo site_url('login/out')?>" class="close-session">Cerrar Sesi&oacute;n</a></li>
						<?php else:?>
						<li><a href="<?php echo site_url('login')?>">Mi Cuenta / Registrarme</a></li>
						<?php endif;?>
						<!-- li><a href="#"><img src="<?php echo base_url('library/images/flag.png')?>" alt="Flag" /></a></li -->
					</ul>
					<div class="clr"></div>
				</div>
				<div class="clr"></div>
				<div class="logo"><a href="<?php echo site_url()?>"><img src="<?php echo base_url('library/images/logo.png')?>" alt="Logo" /></a></div>
				<div class="bluebox">
					
					<div class="serchbar">
						<form action="<?php echo site_url('etiquetas')?>">
						<div class="icon">
							<input type="submit" value="" name="SEARCH_SUBMIT" />
						</div>
							<input type="text"  value="" placeholder="Buscar Etiquetas" name="search_labels"/>
						</form>
					</div>
					<div class="clr"></div>
					<div class="topnav">
						<ul id="nav" class="dropdown">
							<?php foreach($menu_btns as $btn):
							$active = ($current_page == strtolower($btn->CLASS))?'active':'';
							$src	= (strtolower($btn->CLASS) == 'etiquetas')? 'etiquetas/':strtolower($btn->CLASS).'/';
							?>
							<li><a href="<?php echo site_url($src)?>" class="<?php echo $active?>" id="<?php echo $btn->CLASS?>"><?php echo $btn->LABEL?></a></li>
							<?php endforeach?>
						</ul>
						<div class="clr"></div>
					</div>
				</div>
			</div>

			<div class="cateBox" id="main_cat_nav">

				<div class="slider-container">
					<ul class="slider slider-header">
						<?php foreach($categories_menu as $cat): ?>
						<?php $selected = ($cat->ACTIVE)?'checked="checked"':'';?>
						<li><a data-cat="<?php echo $cat->ID?>" class="categorybtnfilter" href="#" style="border-bottom:10px solid <?php echo $cat->CATEGORY_COLOR?>;color: <?php echo $cat->CATEGORY_COLOR?>;"><?php echo $cat->CATEGORY_NAME?></a></li>

						<?php endforeach?>
					</ul>
				</div>
				<div class="clr"></div>
			</div>

			<?php echo $this->fw_alerts->display_alert_message();?>
		</div>

	</div>

