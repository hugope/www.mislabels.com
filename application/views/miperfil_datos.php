<h2><span>Bienvenido, </span><?php echo $this->session->userdata('CUSTOMER_NAME')?></h2>
				<div class="datos_container">
					<h3>Datos Personales</h3>
					<form method="post" action="">
					<div class="fildbox">
						<label>Nombre:</label>
						<?php echo form_input('CUSTOMER_NAME', $perfil->CUSTOMER_NAME)?>
						<?php echo form_error('CUSTOMER_NAME'); ?>
						<div class="clr"></div>
					</div>
					<div class="fildbox">
						<label>Apellido:</label>
						<?php echo form_input('CUSTOMER_LASTNAME', $perfil->CUSTOMER_LASTNAME)?>
						<?php echo form_error('CUSTOMER_LASTNAME'); ?>
						<div class="clr"></div>
					</div>
					<div class="fildbox">
						<label>Pa&iacute;s:</label>
						<?php echo form_dropdown('CUSTOMER_COUNTRY', world_countries(), $perfil->CUSTOMER_COUNTRY)?>
						<?php echo form_error('CUSTOMER_COUNTRY'); ?>
						<div class="clr"></div>
					</div>
					<div class="fildbox">
						<label>Direcci&oacute;n:</label>
						<?php echo form_textarea('CUSTOMER_ADDRESS', $perfil->CUSTOMER_ADDRESS)?>
						<?php echo form_error('CUSTOMER_ADDRESS'); ?>
						<div class="clr"></div>
					</div>
					<div class="greenbtn"><input type="submit" name="PROFILE_SUBMIT" value="Editar Datos Personales"></div>
					</form>
				</div>
				<div class="datos_container">
					<h3>Contrase&ntilde;a:</h3>
					<form method="post" action="">
					<div class="fildbox">
						<label>Contrase&ntilde;a:</label>
						<?php echo form_password('CUSTOMER_PASSWORD')?>
						<?php echo form_error('CUSTOMER_PASSWORD'); ?>
						<div class="clr"></div>
					</div>
					<div class="fildbox">
						<label>Confirmar:</label>
						<?php echo form_password('CUSTOMER_PASSWORD_CONFIRMATION')?>
						<?php echo form_error('CUSTOMER_PASSWORD_CONFIRMATION'); ?>
						<div class="clr"></div>
					</div>
					<div class="greenbtn"><input type="submit" name="PASSWORD_SUBMIT" value="Editar Contrase&ntilde;a"></div>
					</form>
				</div>
				<div class="clr"></div>