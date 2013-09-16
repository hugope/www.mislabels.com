
<div class="clr"></div>
</div></div>

<div class="bodyContent">
	<div class="wrapperbody">
		<div class="regA1box">
			<div class="login_heading"><h3>Ingresa a Tu Cuenta</h3></div>
			<div class="register_heading"><h3>Reg&iacute;strate</h3></div>
			<div class="clr"></div>
		</div>
		<div class="validate_login">
			<div class="loginLeft">
				<form action="<?php echo site_url('login/iniciar_sesion')?>" name="user_login" method="post" >
					<?php echo $stickerdata?>
					<div class="fildbox">
						<label>Email</label>
						<input type="text" onfocus="if(this.value=='info@mislabels.com') this.value='';" onblur="if(this.value=='') this.value='info@mislabels.com';" value="info@mislabels.com" alt="info@mislabels.com" name="CUSTOMER_EMAIL"/>
						<div class="clr"></div>
					</div>
					
					<div class="fildbox">
						<label>Contrase&ntilde;a</label>
						<input type="password" onfocus="if(this.value=='* * * * * * * * * *') this.value='';" onblur="if(this.value=='') this.value='* * * * * * * * * *';" value="* * * * * * * * * *" alt="* * * * * * * * * *" name="CUSTOMER_PASSWORD"/>
						<div class="clr"></div>
					</div>
					
					<div class="fildbox"><a href="<?php echo site_url('login/recuperar')?>">Olvid&eacute; Mi Contrase&ntilde;a</a></div>
					<div class="greenbtn"><input type="submit" value="Ingresar" /></div>
				</form>
			</div>
			<div class="registerRight">
				<form action="" name="user_registration" method="post">
					<div class="fildbox">
						<label class="frmfld">Nombre</label>
						<input type="text" onfocus="if(this.value=='Tu Nombre') this.value='';" onblur="if(this.value=='') this.value='Tu Nombre';" value="<?php echo set_value('CUSTOMER_NAME'); ?>" alt="Tu Nombre" name="CUSTOMER_NAME"/>
						<?php echo form_error('CUSTOMER_NAME'); ?>
						<div class="clr"></div>
					</div>
					
					<div class="fildbox">
						<label class="frmfld">Apellido</label>
						<input type="text" onfocus="if(this.value=='Tu Apellido') this.value='';" onblur="if(this.value=='') this.value='Tu Apellido';" value="<?php echo set_value('CUSTOMER_LASTNAME'); ?>" alt="Tu Apellido" name="CUSTOMER_LASTNAME"/>
						<?php echo form_error('CUSTOMER_LASTNAME'); ?>
						<div class="clr"></div>
					</div>
					
					<div class="fildbox">
						<label class="frmfld">Email</label>
						<input type="text" onfocus="if(this.value=='Ingresa un email v&aacute;lido') this.value='';" onblur="if(this.value=='') this.value='Ingresa un email v&aacute;lido';" value="<?php echo set_value('CUSTOMER_EMAIL'); ?>" alt="Ingresa un email v&aacute;lido" name="CUSTOMER_EMAIL"/>
						<?php echo form_error('CUSTOMER_EMAIL'); ?>
						<div class="clr"></div>
					</div>
					
					<div class="fildbox">
						<label class="frmfld">Tel&eacute;fono</label>
						<input type="text" onfocus="if(this.value=='Tu Tel&eacute;fono') this.value='';" onblur="if(this.value=='') this.value='Tu Tel&eacute;fono';" value="<?php echo set_value('CUSTOMER_PHONE'); ?>" alt="Tu Tel&eacute;fono" name="CUSTOMER_PHONE"/>
						<div class="clr"></div>
					</div>
					<br />
					
					<div class="fildbox">
						<label class="frmfld">Contrase&ntilde;a</label>
						<input type="password" onfocus="if(this.value=='') this.value='';" onblur="if(this.value=='') this.value='';" value="" alt="" name="CUSTOMER_PASSWORD"/>
						<?php echo form_error('CUSTOMER_PASSWORD'); ?>
						<div class="clr"></div>
					</div>
					
					<div class="fildbox">
						<label class="frmfld">Confirmar Contrase&ntilde;a</label>
						<input type="password" onfocus="if(this.value=='') this.value='';" onblur="if(this.value=='') this.value='';" value="" alt="" name="CUSTOMER_PASSWORD_CONFIRMATION" />
						<?php echo form_error('CUSTOMER_PASSWORD_CONFIRMATION'); ?>
						<div class="clr"></div>
					</div>
					
					<span>*Por tu seguridad, no uses contrase&ntilde;a tan simples.</span>
					<p>
						<input type="checkbox" value="NO" name="CUSTOMER_TERMS_ACCEPTANCE" /> Acepto los <a href="#">T&eacute;rminos y Condiciones </a> del servicio.
						<?php echo form_error('CUSTOMER_EMAIL'); ?>
					</p>
					
					<div class="greenbtn"><input type="submit" value="Registrarme" name="register_user" /></div>
				</form>
			</div>
			<div class="clr"></div>
		</div>
		<div class="contine_button"><!--<a href="#"><img src="<?php echo base_url('library/images/guarday_Continuar.png');?>" alt="Cantinue" /></a>--></div>
		<div class="clr"></div>
	</div>
</div>