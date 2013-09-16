
<div class="clr"></div>
</div></div>

<div class="bodyContent">
<div class="wrapperbody">
<div class="catalogleft">
	<form action="<?php echo site_url('etiquetas/index')?>" method="POST" >
		<h3>B&uacute;squeda Filtrada</h3>
		<span>Por Tipo de Set</span>
		<ul>
			<li><a href="javascript:void(0);"><input id="label_set_all" checked="checked" type="checkbox" value="" onclick="select_all_sets()"/> <label style="cursor:pointer;" for="label_set_all">Mostrar todos</label></a></li>
			<?php foreach($label_sets_filter as $label_set): $selected = ($label_set->ACTIVE)?'checked="checked"':'';?>
			<li><a href="javascript:void(0);"><input class="label_set" name="labels_sets[]" type="checkbox" <?php echo $selected?> value="<?php echo $label_set->ID?>" id="labelset_<?php echo $label_set->ID?>" /> <label style="cursor:pointer;" for="labelset_<?php echo $label_set->ID?>"><?php echo $label_set->LABEL?></label></a></li>
			<?php endforeach?>
		</ul>
		<span>Por Categor&iacute;a</span>
		<ul>
			<li><a href="javascript:void(0);"><input id="labels_categories_set_all" checked="checked" type="checkbox" value="" onclick="select_all_cats()" /> <label style="cursor:pointer;" for="labels_categories_set_all">Mostrar todos</label></a></li>
			<?php foreach($categories_filter as $cat):$selected = ($cat->ACTIVE)?'checked="checked"':'';?>
			<li><a href="javascript:void(0);"><input class="label_cat" name="labels_categories[]" type="checkbox" <?php echo $selected?> value="<?php echo $cat->ID?>" id="categoryfilter_<?php echo $cat->ID?>" /> <label style="cursor:pointer;" for="categoryfilter_<?php echo $cat->ID?>"><?php echo $cat->CATEGORY_NAME?></label></a></li>
			<?php endforeach?>
		</ul>
		<input type="submit" value="Filtrar Cat&aacute;logo" class="btn btn-info" />
	</form>
</div>

<div class="catalogRight">
	<div class="catlog_labeltab">
		<h3>Labels:<a href="#"> Todas</a></h3>
		<div class="pazinat"><strong>Mostrando: <span><?php echo ($total_rows < $per_page)?$total_rows:$per_page;?> de <?php echo $total_rows?></span></strong></div>

		<?php echo $pagination?>
		<div class="clr"></div>
	</div>

	<div class="catalogsBox">
		<?php foreach($list_stickers as $sticker):?>
		<div class="leftbox_cata">
			<div class="ribbon" style="background-color:<?php echo $sticker->CATEGORY_COLOR?>;">&nbsp;</div>
			<a href="<?php echo site_url('etiquetas/'.$sticker->STICKER_SET.'/'.$sticker->ID)?>" class="catalog_image" style="background-image: url('<?php echo base_url('user_files/uploads').'/'.$sticker->STICKER_GALLERY[0]?>')"></a>
			<span style="color:<?php echo $sticker->CATEGORY_COLOR?> !important;">Q. <?php echo $sticker->STICKER_PRICE?></span>
			<h5><a href="<?php echo site_url('etiquetas/'.$sticker->STICKER_SET.'/'.$sticker->ID)?>" style="color:<?php echo $sticker->CATEGORY_COLOR?> !important;"><?php echo $sticker->CATEGORY_NAME?></a></h5>
			<a class="personalizar" style="background-color:<?php echo $sticker->CATEGORY_COLOR?>;background-image: url(<?php echo base_url('library/images/personalizar.png')?>);background-repeat: no-repeat;" href="<?php echo site_url('etiquetas/'.$sticker->STICKER_SET.'/'.$sticker->ID)?>">Personalizar</a>
		</div>
		<?php endforeach?>
		<div class="clr"></div>
	</div>

	<div class="catlog_labeltab">
		<?php echo $pagination?>
		<div class="clr"></div>
		<div class="pazinat_bottom"><strong>Mostrando: <span><?php echo ($total_rows < $per_page)?$total_rows:$per_page;?> de <?php echo $total_rows?></span></strong></div>
		<div class="topUp"><p><a href="#"><img src="<?php echo base_url('library/images/topup.png')?>" alt="Top Up" /></a><a href="#">Arriba</a></p></div>
		<div class="clr"></div>
	</div>

</div>
<div class="clr"></div>
</div></div>
<script type="text/javascript">
	//Función para seleccionar todos los input de los sets
	function select_all_sets(){
		var all_input 	= $('input#label_set_all');
		var inputs		= $('input.label_set');

		set_inputs_checked(all_input, inputs);
	}
	//Función para seleccionar todos los input de las categorías
	function select_all_cats(){
		var all_input 	= $('input#labels_categories_set_all');
		var inputs		= $('input.label_cat');

		set_inputs_checked(all_input, inputs);
	}

	//Acción que ejecuta para chequear todos los campos
	function set_inputs_checked(all_input, inputs){

		if (all_input.is(":checked")) {
			$(inputs).each(function(){
				$(this).attr('checked', 'checked');
			});
		}else{
			$(inputs).each(function(){
				$(this).removeAttr('checked', 'checked');
			});

		}
	}
</script>