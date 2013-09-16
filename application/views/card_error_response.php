				<div class="pagoPendient">
					<div class="titulo">
					<h3 class="errorResponse"><span class="">x</span> Pago Rechazado</h3></div>
					<p><strong>No se pudo procesar su pago debido a la siguiente raz&oacute;n devuelta por la tarjeta:</strong></p>
					<p><?php echo $card_response?></p>
					<div class="penfld">
					<label>No. de Pedido</label><input type="text" readonly="readonly" value="<?php echo $this->uri->segment(3)?>" />
					<p>Puede saber el estado de su Pedido <br />llamando al t&eacute;lefono 2333-0500.</p>
					</div>
				</div>