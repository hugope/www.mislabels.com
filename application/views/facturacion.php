
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
				<form method="post" action="<?=site_url('factura/add_billing/'.$this->uri->segment(3))?>">
					<div class="configBox">
						<h2>Facturaci&oacute;n</h2>
						<div class="confLeft">
						
						<div class="fildbox">
							<label class="frmfld">Nombre</label>
							<?php echo form_input('SHOPPING_CUSTOMER_BILLINGNAME', $billing_name)?>
							<div class="clr"></div>
						</div>
						
						<div class="fildbox">
							<label class="frmfld">Nit</label>
							<?php echo form_input('SHOPPING_CUSTOMER_BILLINGTIN', $billing_tin)?>
							<div class="clr"></div>
						</div>
						
						<div class="fildbox">
							<label class="frmfld">Direcci&oacute;n</label>
							<?php echo form_input('SHOPPING_CUSTOMER_BILLINGLOCATION', $billing_location)?>
							<div class="clr"></div>
						</div>
						
						</div>
						<div class="registerRight">
							&nbsp;
						</div>
						<div class="clr"></div>
					</div>
					
					<div class="greenbtn">
						<input type="submit" value="Guardar y Continuar" />
					</div>
					<div class="gereyback_bottom">
						<!--<div class="login_heading"><h3>Ingresa a Tu Cuenta</h3></div>
						<div class="register_heading"><h3>Reg&iacute;strate</h3></div>
						<div class="clr"></div>-->
					</div>
				</form>
				<div class="clr"></div>
			</div>
		</div>
	</div>