
<div class="clr"></div>
</div></div>

<div class="bodyContent">
	<div class="wrapperbody">
		<div class="regA1box">
			<div class="a1boxLeft">
				<h3>Mi Carrito</h3>
			</div>
			<div class="a1boxRight">
				<a class="personalizar" style="background-color: gray;background-image: url(<?php echo base_url('library/images/personalizar.png')?>);background-repeat: no-repeat;" href="<?php echo site_url('etiquetas')?>">
				regresar al cat&aacute;logo
			</a>
			</div>
			<div class="clr"></div>
		</div>
		<div class="shoppingbox">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<?php if(!empty($stickers)):?>
			<tr>
		    	<th>Descripci&oacute;n</th>
		    	<th>Cantidad</th>
		    	<th>Tipo</th>
		    	<th>Precio Unitario</th>
		    	<th>Total</th>
		    	<th><span>&nbsp;</span></th>
		  	</tr>
			<?php endif;
			if(!empty($stickers)):
			foreach($stickers as $sticker):?>
			<tr>
				<td>Label Set <?php echo $sticker->STICKER_NAME?></td>
				<td><?php echo $sticker->STICKER_QUANTITY?></td>
				<td><?php echo $sticker->LABEL?></td>
				<td>Q. <?php echo $this->cart->format_number($sticker->STICKER_PRICE)?></td>
				<td>Q. <?php echo $this->cart->format_number($sticker->STICKER_TOTAL)?></td>
				<!-- td><a href="#"><img src="<?php echo base_url('library/images/edit.jpg')?>" alt="edit" /></a></td -->
				<td><a href="javascript:void(0);" onclick="delete_sticker(<?=$sticker->CARTID?>, <?=$sticker->ID?>)"><img src="<?php echo base_url('library/images/cancel.jpg')?>" alt="Cancel" /></a></td>
			</tr>
			<?php endforeach;
			else:?>
			<tr>
				<td colspan="7">No has agregado ninguna sticker a tu carrito de compra, ingresa a nuestro <a href="<?php echo site_url('etiquetas')?>">cat&aacute;logo</a> para empezar a comprar</td>
			</tr>
			<?php endif;?>
		</table>
		<?php if(!empty($stickers)):?>
		<div class="subtotal"><h3>Subtotal (Q.)</h3><span><?php echo $this->cart->format_number($cartTotal)?></span></div>
		<?php endif?>
		</div>
		<?php if(!empty($stickers)):?>
		<div class="contine_button"><a href="<?php echo site_url('entrega/configurar/'.$cartid)?>"><img src="<?php echo base_url('library/images/guarday_Continuar.png')?>" alt="Cantinue" /></a></div>
		<?php endif?>
		<div class="clr"></div>
	</div>
</div>
<script type="text/javascript">
	function delete_sticker(cart, sticker){
		if(confirm('¿Realmente desea eliminar la etiqueta seleccionada?')){
			location.href = "<?php echo site_url('carrito/eliminar')?>/"+cart+"/"+sticker;
		}
	}
</script>