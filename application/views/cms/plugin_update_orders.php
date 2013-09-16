<div id="content" class="container-fluid">
	<div class="page-header">
		<h1> <?php echo $page_title; ?><small></small></h1>
	</div>
	
	<div class="row-fluid">
		<div class="span12">
			<dl class="dl-horizontal">
				<dt>C&oacute;digo del pedido</dt><dd><?php echo $SHOPPING_CODE?></dd>
				<dt>Fecha de creaci&oacute;n</dt><dd><?php echo $SHOPPING_DATECREATED?></dd>
				<dt>Nombre del usuario</dt><dd><?php echo $CUSTOMER_NAME?></dd>
			</dl>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span12">
			<table class="table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>C&oacute;digo</th>
						<th>Categor&iacute;a</th>
						<th>Cantidad</th>
						<th>Precio</th>
						<th>Total</th>
					</tr>
				</thead>
					<?php 
					foreach($STICKERS_CART as $sticker):
					$stickerCartPrice = ($sticker->STICKER_QUANTITY * $sticker->STICKER_PRICE);
					$stickerQuan[] = $sticker->STICKER_QUANTITY;
					$stickerPrice[] = $stickerCartPrice;
					?>
					<tr>
						<td><?php echo $sticker->STICKER_NAME?></td>
						<td><?php echo $sticker->STICKER_CATEGORY?></td>
						<td><?php echo $sticker->STICKER_QUANTITY?></td>
						<td>Q. <?php echo $sticker->STICKER_PRICE?></td>
						<td>Q. <?php echo number_format($stickerCartPrice, 2)?></td>
					</tr>
				<?php endforeach?>
				<tr>
					<td colspan="2" style="text-align: right"><b>TOTAL:</b></td>
					<td colspan="2"><b><?php echo array_sum($stickerQuan)?></b></td>
					<td><b>Q. <?php echo number_format(array_sum($stickerPrice), 2)?></b></td>
				</tr>
			</table>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span12 well">
			<div class="row-fluid">
				<div class="span12">
					<h5 class="title">Configurar &Oacute;rden</h5>
					<form class="form-horizontal" action="<?php echo base_url('cms/plugin_orders/post_update_val/'.$SHOPPING_ID)?>" method="POST">
						<?php echo form_hidden('CUSTOMER_EMAIL', $CUSTOMER_EMAIL)?>
						<div class="control-group">
							<label class="control-label" for="shopping_status">Configurar Status</label>
							<div class="controls">
								<?php echo form_dropdown('SHOPPING_STATUS', $SHOPPING_STATUS_OPTIONS, $SHOPPING_STATUS, 'id="shopping_status" class="span6"')?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="shopping_date">Establecer fecha de entrega</label>
							<div class="controls">
								<div class="input-prepend">
									<span class="add-on"><i class="icon-calendar"></i></span>
									<?php echo form_input(array('name' => 'SHOPPING_SHIPPINGDATE', 'value' => $SHOPPING_SHIPPINGDATE, 'class' => 'span6', 'id' => 'shopping_date', 'placeholder' => 'AAAA-MM-DD'))?>
								</div>
							</div>
						</div>
						<div class="form-actions">
							<input type="submit" class="btn btn-primary" name="POST_SUBMIT" value="<?php echo $submit_button?>" />
							<a href="<?php echo base_url('cms/plugin_orders/update_table_row/'.$SHOPPING_ID)?>" class="btn" >Cancelar</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("input#shopping_date").datepicker({
			dateFormat: 'yy-mm-dd'
		});
	});
</script>