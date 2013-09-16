<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="<?php echo $this->fw_resource->request('RESOURCE_THEME_HTMLTYPE')?>; charset=<?php echo $this->fw_resource->request('RESOURCE_THEME_CHARSET')?>" />
	<title><?php echo 'Imprimir Orden '.$this->uri->segment(3).':: MisLabels.com'; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('library/cms/css/bootstrap.min.css'); ?>" type="text/css" media="screen" />
</head>
<body>
	<div class="container-fluid">
		<h2>Imprimir Orden - <?php echo $this->uri->segment(3)?></h2>
		<div class="row-fluid">
			<div class="span12"><h3>Datos de la Órden</h3></div>
		</div>
		<div class="row-fluid">
			<table class="table">
				<tr>
					<td><b>Status</b></td>
					<td>PENDIENTE</td>
					<td><b>Fecha de entrega</b></td>
					<td colspan="3">20/09/2013</td>
				</tr>
				<tr>
					<td><b>Nombre de facturación</b></td>
					<td>Guido Orellana</td>
					<td><b>NIT</b></td>
					<td>123456-7</td>
					<td><b>Dirección</b></td>
					<td>Ciudad</td>
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
					<td colspan="3">Guido Orellana</td>
				</tr>
				<tr>
					<td><b>Email</b></td>
					<td>guido@grupoperinola.com</td>
					<td><b>Teléfono</b></td>
					<td>12345678</td>
				</tr>
				<tr>
					<td><b>Dirección</b></td>
					<td colspan="3">13 Ave. 2-81 Z.15 - Ciudad de Guatemala</td>
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
						<td>zona 15, colonia Tecn Humn, Cerca del hospital el pilar</td>
					</tr>
					<tr>
						<td><b>Tipo de entrega</b></td>
						<td>Dirección particular</td>
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
					<tr>
						<td><b>Tipo de etiqueta</b></td>
						<td>A-1</td>
						<td><b>Color</b></td>
						<td>9</td>
						<td><b>Tipografía</b></td>
						<td>Apple Casual</td>
						<td><b>Texto</b></td>
						<td>Esto es mío</td>
						<td><b>Cantidad</b></td>
						<td>1</td>
					</tr>
					<tr>
						<td><b>Tipo de etiqueta</b></td>
						<td>A-1</td>
						<td><b>Color</b></td>
						<td>9</td>
						<td><b>Tipografía</b></td>
						<td>Apple Casual</td>
						<td><b>Texto</b></td>
						<td>Esto es mío</td>
						<td><b>Cantidad</b></td>
						<td>3</td>
					</tr>
					<tr>
						<td><b>Tipo de etiqueta</b></td>
						<td>D-1</td>
						<td><b>Color</b></td>
						<td>9</td>
						<td><b>Tipografía</b></td>
						<td>Apple Casual</td>
						<td><b>Texto</b></td>
						<td>Azcar, Cereal, Cocina, Margarina, Frijol, Avena, Miel, Incaparina, Cereal, Harina, Granos, Semillas</td>
						<td><b>Cantidad</b></td>
						<td>2</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</body>
</html>