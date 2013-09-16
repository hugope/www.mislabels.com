
<div class="clr"></div>
</div></div>

<div class="bodyContent">
	<div class="wrapper_profilebody">
		<?php echo $wizard_menu?>
		<div class="wrapper_whitebox">
			<div class="gereyback">
			<!--<div class="login_heading"><h3>Ingresa a Tu Cuenta</h3></div>
			<div class="register_heading"><h3>Reg&iacute;strate</h3></div>
			<div class="clr"></div>-->
			</div>
			<form method="post" action="https://credomatic.compassmerchantsolutions.com/api/transact.php" autocomplete="off">
				<?php 
				//Desplegar los datos para validar la tarjeta
				echo $validation_fields;
				?>
				<div class="configBox">
				<h2>Formulario de Pago</h2>
				<div class="paymentPago">
				<table width="100%" border="0" cellspacing="10" cellpadding="5">
				  <tr>
				    <td align="right"><label>N&uacute;mero de Tarjeta</label></td>
				    <td><?php echo form_input(array('name' => 'ccnumber', 'placeholder' => '1111222233334444'))?></td>
				    <td class="requir">*Ingresar sin espacios</td>
				  </tr>
				  <tr>
				    <td align="right"><label>C&oacute;digo de Seguridad</label></td>
				    <td><?php echo form_input(array('name' => 'cvv', 'placeholder' => '123'))?></td>
				    <td class="requir"><a href="#">&iquest;Qu&eacute; es?</a></td>
				  </tr>
				  <tr>
				   <td align="right"><label>Fecha de Expiraci&oacute;n</label></td>
				   <?php echo form_hidden('ccexp', '01'.date('y'))?>
				   <td width="220"><?php echo $expmonth?><?php echo $expyear?></td>
				    <td class="requir">&nbsp;</td>
				  </tr>
				  <tr>
				  	<td align="right">&nbsp;</td>
				  	<td width="220"><img src="<?php echo base_url('library/images/masterCard.jpg');?>" alt="Pagar" /></td>
				  	<td class="requir">&nbsp;</td>
				  </tr>
				</table>
				</div>
				<div class="clr"></div>
				</div>
				<div class="configBox_button">
					<div class="greenbtn"><input type="submit" value="Realizar Pago" name="register_user" /></div>
				</div>
			</form>
			<div class="gereyback_bottom">
			<!--<div class="login_heading"><h3>Ingresa a Tu Cuenta</h3></div>
			<div class="register_heading"><h3>Reg&iacute;strate</h3></div>
			<div class="clr"></div>-->
			</div>
			
			<div class="clr"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function expdate_format(){
		var expmonth = $('select#expmonth').val();
		var expyear = $('select#expyear').val();
		
		$('input[name="ccexp"]').val(expmonth+expyear);
	}
</script>