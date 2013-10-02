<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="<?php echo $this->fw_resource->request('RESOURCE_THEME_HTMLTYPE')?>; charset=<?php echo $this->fw_resource->request('RESOURCE_THEME_CHARSET')?>" />
	<title><?php echo 'Imprimir Orden '.$SHOPPING_CODE.':: MisLabels.com'; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('library/cms/css/bootstrap.min.css'); ?>" type="text/css" />
</head>
<body onload="window.print()">
	<div class="container-fluid">
		<h2>Imprimir Orden - <?php echo $SHOPPING_CODE?></h2>
		<div class="row-fluid">
			<div class="span12"><h3>Datos de la Orden</h3></div>
		</div>
		<div class="row-fluid">
			<table class="table">
				<tr>
					<td><b>Status</b></td>
					<td><?php echo $ORDER_DATA->SHOPPING_STATUS?></td>
					<td><b>Fecha de entrega</b></td>
					<td colspan="3"><?php echo mysql_date_to_dmy($ORDER_DATA->SHOPPING_DATECREATED) ?></td>
				</tr>
				<tr>
					<td><b>Nombre de facturación</b></td>
					<td><?php echo $ORDER_DATA->SHOPPING_CUSTOMER_BILLINGNAME?></td>
					<td><b>NIT</b></td>
					<td><?php echo $ORDER_DATA->SHOPPING_CUSTOMER_BILLINGTIN?></td>
					<td><b>Dirección</b></td>
					<td><?php echo $ORDER_DATA->SHOPPING_CUSTOMER_BILLINGLOCATION?></td>
				</tr>
			</table>
		</div>
		
		<div class="row-fluid">
			<div class="span12"><h3>Datos del Usuario</h3></div>
		</div>
		<div class="row-fluid">
			<table class="table">
				<tr>
					<td><b>Nombre y Apellido</b></td>
					<td colspan="3"><?php echo $ORDER_DATA->CUSTOMER_NAME?></td>
				</tr>
				<tr>
					<td><b>Email</b></td>
					<td><?php echo $ORDER_DATA->CUSTOMER_EMAIL?></td>
					<td><b>Teléfono</b></td>
					<td><?php echo $ORDER_DATA->CUSTOMER_PHONE?></td>
				</tr>
				<tr>
					<td><b>Dirección</b></td>
					<td colspan="3"><?php echo $ORDER_DATA->CUSTOMER_ADDRESS?></td>
				</tr>
			</table>
		</div>
		
		<div class="row-fluid">
			<div class="span12"><h3>Datos de entrega</h3></div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<table class="table">
					<tr>
						<td><b>Dirección de entrega</b></td>
						<td><?php echo $ORDER_DATA->SHOPPING_SHIPPINGADDRESS?></td>
					</tr>
					<tr>
						<td><b>Tipo de entrega</b></td>
						<td><?php echo $ORDER_DATA->SHIPPING_TYPE?></td>
					</tr>
				</table>
			</div>
		</div>
		
		
		<div class="row-fluid">
			<div class="span12"><h3>Datos de etiquetas</h3></div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<table class="table">
					<?php foreach($ORDER_DATA->SHOPPING_CART as $etiqueta):?>
					<tr>
						<td><b>C&oacute;digo</b></td>
						<td><?php echo $etiqueta->STICKER_NAME?></td>
						<td><b>Color</b></td>
						<td><?php echo $etiqueta->STICKER_COLOR?></td>
						<td><b>Tipografía</b></td>
						<td><?php echo $etiqueta->FONT_NAME?></td>
						<td><b>Texto</b></td>
						<td><?php echo @implode(', ', $etiqueta->STICKER_TEXT)?></td>
						<td><b>Cantidad</b></td>
						<td><?php echo $etiqueta->STICKER_QUANTITY?></td>
						<td><b>Tipo</b></td>
						<td><?php echo $etiqueta->STICKER_TYPE?></td>
					</tr>
					<?php endforeach?>
				</table>
			</div>
		</div>
	</div>
</body>
</html>