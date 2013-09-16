
<div class="clr"></div>
</div></div>

<div class="bodyContent">
	<div class="wrapper_profilebody">
		<?php echo $wizard_menu?>
		<div class="wrapper_whitebox">
			<form action="<?=site_url('entrega/add_shipping/'.$this->uri->segment(3))?>" method="post">
			<div class="gereyback">
			<!--<div class="login_heading"><h3>Ingresa a Tu Cuenta</h3></div>
			<div class="register_heading"><h3>Reg&iacute;strate</h3></div>
			<div class="clr"></div>-->
			</div>
			<div class="configBox" id="config">
			<h2>Configura tu Entrega</h2>
			<div class="confLeft option_col active">
			<div class="enviar">
				<p>
					<?php echo $deliver?> <label for="dd1">Enviar a una Ubicaci&oacute;n</label>
				</p>
			</div>

			<div class="fildbox">
				<label class="frmfld">Persona que Recibe</label>
				<?php echo form_input('SHOPPING_RECEIVER', $deliver_person)?>
				<div class="clr"></div>
			</div>

			<div class="fildbox">
				<label class="frmfld">Direcci&oacute;n</label>
				<?php echo form_input('SHIPPING_ADDRESS', $deliver_address)?>
			<div class="clr"></div>
			</div>
			<br />
			<!--
			<div class="fildbox">
			<label class="frmfld">Pa&iacute;s</label>
			<select name="List"><option>Category 1</option><option>Category 2</option><option>Category 3</option><option>Category 4</option><option>Category 5</option></select>
			<div class="clr"></div>
			</div>

			<div class="fildbox">
			<label class="frmfld">Departamento</label>
			<select name="List"><option>Category 1</option><option>Category 2</option><option>Category 3</option><option>Category 4</option><option>Category 5</option></select>
			<div class="clr"></div>
			</div> -->

			<div class="fildbox">
				<label class="frmfld">Municipio</label>
				<?php echo form_dropdown('SHIPPING_CITY', $deliver_municipios, $deliver_municipio)?>
				<div class="clr"></div>
			</div>

			<div class="fildbox">
				<label class="frmfld">Instrucciones Especiales</label>
				<?php echo form_textarea('SHIPPING_LOCATION', $deliver_location)?>
				<div class="clr"></div>
			</div>

			</div>
			<div class="registerRight option_col">
			<div class="traer">
				<p>
					<?php echo $pickup?><label for="dd2">Ir a traer</label>
					</p>
				</div>
			<div class="fildbox">
				<label class="frmtrear">Ubicaci&oacute;n</label>
				<?php echo form_dropdown('PICKUP_LOCATIONS', $pickup_locations, $pickup_location, 'disabled="disabled"');?>
				<div class="clr"></div>
			</div>

			<div class="fildbox">
				<label class="frmtrear">Persona que Recibe</label>
				<?php echo form_input(array('name' => 'SHOPPING_RECEIVER', 'value' => $deliver_person, 'disabled' => 'disabled'))?>
				<div class="clr"></div>
			</div>

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

<script type="text/javascript">
	var	config = {
			control : function(ctx, clase)
			{
				if( ctx.hasClass('active') )
				{
					// console.log('ya esta activo, no hacer nada');
				} else {
					// console.log('activar este y desactivar el otro');
					ctx.addClass('active');
					switch(clase)
					{
						case '.registerRight':
							$('.confLeft').removeClass('active');
							config.disable( $('.confLeft') );
							break;
						case '.confLeft':
							$('.registerRight').removeClass('active');
							config.disable( $('.registerRight') );
							break;
					}
					config.enable( ctx );
				}
			}
		,	disable : function(ctx)
			{
				$('input, textarea, select', ctx).not('input[type="radio"]').attr('disabled', true);
				// console.log('se procede a desactivar los elementos de ', ctx);
			}
		,	enable : function(ctx)
			{
				$('input, textarea, select', ctx).not('input[type="radio"]').attr('disabled', false);
				// console.log('se procede a activar los elementos de ', ctx);

			}
		}
	,	set_inputs_enable = function(clase) {
		var ctx = $(clase);
		config.control(ctx, clase);
	};
</script>